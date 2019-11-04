# libraries
import RPi.GPIO as GPIO
from picamera import PiCamera
from time import sleep
import datetime
import time
import socket
import fcntl
import struct
import uuid
import os
import _thread
import pymysql # sudo apt-get install python3-pymysql
import email, smtplib, ssl

from email import encoders
from email.mime.base import MIMEBase
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

def sendEmail(filename, date):
    subject = "Sensor triggered"
    body = ""
    sender_email = "comp6733asdf@gmail.com"
    receiver_email = "d.conlan@student.unsw.edu.au"
    password = "comp6733uytgb"
    message = MIMEMultipart()
    message["From"] = sender_email
    message["To"] = receiver_email
    message["Subject"] = subject
    message["Bcc"] = receiver_email  # Recommended for mass emails
    message.attach(MIMEText(body, "plain"))
    filename = "/var/www/html/webroot/Pictures/" + date + ".jpg"
    with open(filename, "rb") as attachment:
        part = MIMEBase("application", "octet-stream")
        part.set_payload(attachment.read())
    encoders.encode_base64(part)
    part.add_header(
        "Content-Disposition",
        f"attachment; filename= {filename}",
    )
    message.attach(part)
    text = message.as_string()
    context = ssl.create_default_context()
    with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=context) as server:
        server.login(sender_email, password)
        server.sendmail(sender_email, receiver_email, text)

# global variables
# schedule[0][1] = 0 means monday 01:00am - 01:59am dont record,
# 1 means do record
schedule = [[1]*24 for i in range(7)] 
# this needs to be set manually, later we make it automatic? 

main_server_ip = "raspberrypis.local"

# this gets called when button pressed
# this will get replaced with pir sensor when we get them
def button_callback(channel):
    if GPIO.input(10):     # if port 10 == 1
        print("Rising edge detected on 10")
    else:                  # if port 10 != 1
        print("Falling edge detected on 10")
        return
    global main_server_ip
    global schedule
    global camera
    global id_addr
    camera.resolution = (1920, 1080)
    date = datetime.datetime.now().strftime("%Y_%m_%d_%H_%M_%S")
    # TODO check schedule to see if we should capture
    # capture onto device
    camera.start_preview()
    sleep(1)
    camera.capture('/var/www/html/webroot/Pictures/' + date + '.jpg')
    print("Captured image at /var/www/html/webroot/Pictures/" + date + '.jpg')
    camera.start_recording("/var/www/html/webroot/Videos/" + date + '.h264')
    sleep(1)
    camera.stop_recording()
    print("Captured video at /var/www/html/webroot/Videos/" + date + '.h264')
    camera.stop_preview()
    # send email
    #sendEmail(date + ".jpg", date)
    # insert record into main server db
    conn = pymysql.connect(host=main_server_ip, user="piremote", passwd="raspberry", db="pidb")
    cur = conn.cursor()
    cur.execute(f"INSERT INTO pidb.recordings(recTime,recTriggered,recType,recIp) VALUES ('{date}',1,0,'{ip_addr}');")
    print(f"INSERT INTO pidb.recordings(recTime,recTriggered,recType,recIp) VALUES ('{date}',1,0,'{ip_addr}';") 
    cur.execute(f"INSERT INTO pidb.recordings(recTime,recTriggered,recType,recIp) VALUES ('{date}',1,1,'{ip_addr}');")
    conn.commit()
    cur.close()
    conn.close()
    
   

# this thread periodically retrieves the user's surveillance schedule
# from the main server's db
# it puts the result in a local array that gets used by the camera
# to determine whether to record on a detection
def schedule_update():
    while(1):
        sleep(1000) # run this every x seconds
        # connect to database
        conn = pymysql.connect(host=main_server_ip, user="piremote", passwd="raspberry", db="pidb")
        cur = conn.cursor()
        cur.execute("SELECT * FROM settings WHERE id=1;")
        for res in cur:
            print(res) #TODO update schedule
        cur.close()
        conn.close()

# get our inet ip address
s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
s.connect(("8.8.8.8", 80))
ip_addr = s.getsockname()[0]
s.close()
print(ip_addr)

# get mac address
mac_addr = ':'.join(['{:02x}'.format((uuid.getnode() >> ele) & 0xff)for ele in range(0,8*6,8)][::-1])
print(mac_addr)

# set up button callback
GPIO.setwarnings(False) # Ignore warning for now
GPIO.setmode(GPIO.BOARD) # Use physical pin numbering
GPIO.setup(10, GPIO.IN, pull_up_down=GPIO.PUD_DOWN) # Set pin 10 to be an input pin and set initial value to be pulled low (off)
GPIO.add_event_detect(10,GPIO.RISING,callback=button_callback) # Setup event on pin 10 rising edge
camera = PiCamera()
try:
    _thread.start_new_thread(schedule_update, ())
except:
   print("Error: unable to start thread")
   exit(1)
while(1):
    sleep(10)
GPIO.cleanup() # Clean up

