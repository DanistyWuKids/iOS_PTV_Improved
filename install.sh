#!/bin/bash

## Check if user is the super user
if [ $UID -ne 0 ]; then
    echo "Superuser privileges are required to run this script."
    echo "Please run: \"sudo $0\""
    exit 1
fi
echo -e "Updateing Repository Information prepare for install\n\n"
echo
sudo apt-get update
echo

#echo -e "Installing Teamviewer Hosts\n\n"
#wget https://download.teaviewer.com/download/linux/version_12x/teamviewer-host_armhf.deb
#sudo dpkg -i teamviewer-host_armhf.dpkg
#sudo apt-get install -f -y

cd /home/pi
if [ -d "Pictures" ]; then
  rm -rf /home/pi/Pictures
fi
if [ -d "Videos" ]; then
  rm -rf /home/pi/Videos
fi

echo -e "\n\nInstall Sensors & system environments\n\n"
sudo apt-get -y install python-rpi.gpio python3-rpi.gpio git unzip avahi-daemon debconf-utils

echo -e "\n\nInstall PHP Components\n\n"
sudo apt-get -y install php php-cgi php-intl php-mbstring php-xml php-common php-mysql curl php-cli php-fpm mariadb-client

echo -e "\n\nInstalling Composer\n\n"
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm -rf composer-setup.php

echo -e "\n\nInstall Web Server Engine\n\n"
sudo apt-get -y install apache2
sudo a2enmod rewrite
sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php7.3-fpm
sudo systemctl restart apache2
#sudo apt-get -y install nginx
sudo mkdir /var/www/raspberrypis.local/
sudo ln -s /var/www/html /var/www/raspberrypis.local/


echo -e "\n\nClone the object from git\n\n"
cd /var/www
if [ ! -d "comp6733webif" ]; then
  sudo git clone https://gitlab.cse.unsw.EDU.AU/z5269058/comp6733webif.git
  if [ ! -d "comp6733webif" ]; then
    echo -e "Git Clone failure, try again? (y for YES, others for no.)\n\n"
    read cloneinput
    if [ "$cloneinput" == "y" ]; then
      sudo git clone https://gitlab.cse.unsw.EDU.AU/z5269058/comp6733webif.git
      if [ ! -d "comp6733webif" ]; then
        echo -e "Git Clone failure, try again? (y for YES, others for no.)\n\n"
	read cloneinput2
        if [ "$cloneinput2" == "y" ]; then
          sudo git clone https://gitlab.cse.unsw.EDU.AU/z5269058/comp6733webif.git
	  if [ ! -d "comp6733webif" ]; then
            echo -e "Git Clone failed";
          fi;
        else
          exit 1;
        fi
      fi
    else
      exit 1;
    fi
  fi
fi

if [ -d "comp6733webif" ]; then
  sudo rm -rf html
  sudo mv comp6733webif html
  cd /var/www/html
  echo -e "\n\nSetting up default folder link for Photos and Videos\n\n"
  sudo mkdir /var/www/html/webroot/Pictures
  sudo mkdir /var/www/html/webroot/Videos
  sudo ln -sfn /var/www/html/webroot/Pictures /home/pi
  sudo ln -sfn /var/www/html/webroot/Videos /home/pi
  echo -e "\n\nInstall package dependency of server\n\n"
  sudo composer install -n
  cd /var/www/html/config
  sudo cp -rf /var/www/html/config/settings/apache2.conf /etc/apache2/apache2.conf
  echo -e "\n\nRestarting Web Engine\n\n"
  sudo systemctl restart apache2
  #sudo service nginx reload
  echo -e "\n\nIs this will be the main server?\n('y' for YES, other input for NO)"
  read uinput
  echo -e "\n\nConfiguring app.php\n\n"
  if [ "$uinput" == "y" ]; then
    echo "\n\nStart installing database\n\n"
    export DEBIAN_FRONTEND="nointeractive"
    sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password qwe123"
    sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password qwe123"
    sudo apt-get -y install mariadb-server
    echo "\n\nAdding database to mysql\n\n"
    sudo mysql -u root -pqwe123 < /var/www/html/config/schema/script.sql
    echo "\n\nAdding users to mysql\n\n"
    sudo mysql -u root -pqwe123 < /var/www/html/config/schema/adduser.sql
    sudo rm -rf /var/www/html/config/app.php
    sudo cp /var/www/html/config/settings/app.server.php /var/www/html/config/app.php
    sudo composer install -n
    sudo hostnamectl set-hostname raspberrypis
    sudo rm -rf /etc/mysql/mariadb.conf.d/50-server.cnf
    sudo cp /var/www/html/config/settings/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf
    echo -e "\n\nMySQL is restarting\n\n"
    sudo /etc/init.d/mysql restart
    echo -e "\n\nUpdate permission request\n\n"
    sudo cp -rf /var/www/html/config/settings/sudoers /etc/sudoers
    echo -e "You MySQL Preset Cridential Details:"
    echo -e "\tUsername:root\tPassword: qwe123\n\n"
    echo -e "\n\nDo you wish to reboot system now?('y' for Yes, other for NO)\n"
    read ureboot
    if [ "$ureboot" == "y" ]; then
      sudo reboot
    fi
  else
    sudo cp /var/www/html/config/settings/app.client.php /var/www/html/config/app.php
    sudo composer install -n
    echo -e "Update permission request\n\n"
    sudo cp -rf /var/www/html/config/settings/sudoers /etc/sudoers
  fi
fi
echo -e "\n\nAll Done ! Yay!\n\n"
exit 0;
