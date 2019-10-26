# COMP6733 Surveillance Project Web interface

### Oh-My-IoT @ UNSW 2019 Term 3

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

An interface application build with [CakePHP](https://cakephp.org) 3.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

### The easiest way (Download one-key install script):

1. Download the script by:

```bash
$ wget https://gitlab.cse.unsw.edu.au/z5269058/comp6733webif/raw/master/install.sh
OR
$ wget https://gitlab.com/DanistyWuKids/comp6733webif/raw/master/install.sh
```

2. Adding executable permission to script.
```bash
$ chmod +x install.sh
```

3. Execute Install script by (Require Superuser privileges):

```bash
$ sudo ./install.sh
```

### The old-school method:
1. Install following packages on raspberry pi.

```bash
$ sudo apt-get install php php-cgi php-intl php-mbstring php-xml php-common php-mysql apache2
```

* Install following package on main server only
    ```bash
    $ sudo apt-get install mysql-server
    $ mysql_secure_installation
    ```
    
    And follow the screen to setting up your MySQL Server.


2. After installation, configure the ***/etc/apache2/apache2.conf*** on section ***/var/www*** as follow shows.

```ini
<Directory /var/www/>
	Options Indexes FollowSymLinks
	AllowOverride All
	Require all granted
</Directory>
```

3. Download and install the [Composer](https://getcomposer.org/doc/00-intro.md) and do update `composer self-update` within the web folder.

4. Clone this project to Apache webroot folder, default location is "/var/www/html".
```bash
$ git clone https://gitlab.com/DanistyWuKids/comp6733webif
or 
$ git clone https://gitlab.cse.unsw.edu.au/z5269058/comp6733webif
```

5. Execute following commands within the project folder
```bash
$ sudo a2enmod rewrite
$ sudo a2enmod proxy_fcgi setenvif
$ sudo systemctl restart apache2
```

6. Check your php-fpm version and enable it in apache 2
```bash
$ sudo a2enconf php<version>-fpm
$ sudo systemctl restart apache2
```

You can now either use your Apache Web Engine by browsing `http://localhost`, or start up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Configuration

NB: If you are installed by using script and successfully installed all require components. No further configures required.

Read and edit `config/app.php` and setup the `'Datasources'` and any other configuration relevant for your application.

## Layout

This application is using open ourced bootstrap theme sb-admin2 as management template. Original Template can be found on [GitHub](https://github.com/BlackrockDigital/startbootstrap-sb-admin-2)
