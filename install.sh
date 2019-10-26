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

echo -e "Install PHP Components\n\n"
echo
sudo apt-get -y install php php-cgi php-intl php-mbstring php-xml php-common php-mysql apache2 debconf-utils curl php-cli git unzip
export DEBIAN_FRONTEND="nointeractive"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password qwe123"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password qwe123"
sudo apt-get -y install mariadb-server
echo

echo -e "Installing Composer\n\n"
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm -rf composer-setup.php

echo -e "Configure Apache2\n\n"
sudo a2enmod rewrite
sudo a2enmod proxy_fcgi setenvif
sudo systemctl restart apache2
lineno=`cat /etc/apache2/apache2.conf | grep "<Directory /var/www/>" -n | cut -d ":" -f 1`
let lineno=${lineno}+2
newline=`echo -e '\tAllowOverride All'`
perl -pe 's/.*/$newline if $. == $lineno' < /etc/apache2/apache2.conf 

echo -e "Restarting Apache Web Engine\n\n"
sudo systemctl restart apache2

echo -e "Clean up packages\n\n"
echo
sudo apt-get autoremove
echo

echo -e "Clone the object from git\n\n"
cd /var/www
if [ ! -d "comp6733webif" ]; then
  git clone https://gitlab.cse.unsw.EDU.AU/z5269058/comp6733webif.git
  if [ ! -d "comp6733webif" ]; then
    echo -e "Git Clone failure, please try execute this script again.\n\n"
    exit 1;
  fi
fi
if [ -d "comp6733webif" ]; then
  sudo rm -rf html
  sudo mv comp6733webif html
  cd /var/www/html
  echo -e "Install package dependency of server\n\n"
  sudo composer install -n
  cd /var/www/html/config
  
  echo -e "Is this will be the main server?\n('y' for YES, other input for NO)"
  read uinput
  echo -e "\n\nConfiguring app.php\n\n"
  if [ "$uinput" == "y" ]; then
    echo "Adding database to mysql"
    sudo mysql -u root -pqwe123 < /var/www/html/config/schema/script.sql
    echo "Adding users to mysql"
    sudo mysql -u root -pqwe123 < /var/www/html/config/schema/adduser.sql
  else 
    lineno=`cat /var/www/html/config/app.php | grep "Datasources" -n | cut -d ":" -f 1`
    let appusername=${lineno}+12
    let apphost=${lineno}+5
    newline=`echo -e "\t\t'host'=>'raspberrypi.local'"`
    perl -pe 's/.*/$newline if $. == $apphost' < /var/www/html/config/app.php 
    newline=`echo -e "\t\t'username'=>'piremote'"`
    perl -pe 's/.*/$newline if $. == $appusername' < /var/www/html/config/app.php
  fi
fi
echo -e "You MySQL Preset Cridential Details:"
echo -e "Username:root\tPassword: qwe123\n\n"



echo -e "All Done\n\n- Enjoy! -\n\n"

exit 0;