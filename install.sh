# !/bin/bash

## Check if user is the super user
if [ $UID -ne 0 ]; then
    echo "Superuser privileges are required to run this script."
    echo "e.g. \"sudo $0\""
    exit 1
fi

echo "Install PHP Components"
sudo apt-get -y install php php-cgi php-intl php-mbstring php-xml php-common php-mysql apache2 debconf-utils curl php-cli git unzip
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password qwe123!@#'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password qwe123!@#'
sudo apt-get -y install mysql-server

echo "Install Composer"
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm -rf composer-setup.php

echo "Configure Apache2"
sudo a2enmod rewrite
sudo a2enmod proxy_fcgi setenvif
$lineno = cat /etc/apache2/apache2.conf | grep "<Directory /var/www/>" | cut -d ":" -f 1
let "$lineno += 2"
echo "Change on line $lineno"
$newline = "	AllowOverride All"
perl -pe 's/.*/$newline if $. == $lineno' < /etc/apache2/apache2.conf 
sudo systemctl restart apache2


echo "Clone the object from git"
cd /var/www/html
git clone https://gitlab.cse.unsw.EDU.AU/z5269058/comp6733webif.git

if [ ! -d "$comp6733webif" ]; then
  echo "Retrying to clone the repository"
  git clone https://gitlab.cse.unsw.EDU.AU/z5269058/comp6733webif.git
  if [ ! -d "$comp6733webif" ]; then
    echo "Git Clone failure, please try clone it manually."
    echo "Then execute 'composer install' within the folder"
  fi
fi

echo "You MySQL Cridential Details:"
echo "Username:root, Password: qwe123!@#"
echo "After you have setup your database, plase update 'Datasource' section in /config/app.php"

exit 1
