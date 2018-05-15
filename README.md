# Library-Project
A simple project that will be used to evaluate my competency as a web developer for Fresno State.
Installed and tested on Centos 7:
Linux version 3.10.0-862.2.3.el7.x86_64 (builder@kbuilder.dev.centos.org) (gcc version 4.8.5 20150623 (Red Hat 4.8.5-28) (GCC) ) #1 SMP Wed May 9 18:05:47 UTC 2018
PHP Version: 
PHP 5.4.16 (cli) (built: Apr 12 2018 19:02:01)
Copyright (c) 1997-2013 The PHP Group
Zend Engine v2.4.0, Copyright (c) 1998-2013 Zend Technologies

Install LAMP stack by (mariadb is optional):
sudo yum install httpd
sudo systemctl start httpd.service
sudo systemctl enable httpd.service
sudo yum install mariadb-server mariadb
sudo systemctl start mariadb
sudo mysql_secure_installation
sudo systemctl enable mariadb.service
sudo yum install php php-mysql
sudo mkdir /var/log/php
sudo chown apache /var/log/php
sudo systemctl reload httpd

File Structure:
..
css/
    excerpt.css
    jcarousel.basic.css
    style.css
javascript/
    jcarousel.basic.js
    jquery.jcarousel.js
    jquery.js
templates/
    carousel.template.html
generate.php

If you copy the file structure that is accessible to the internet, then you may run the commands below out of the box.  However, if you move folders or files around then you may break the script.  Keep in mind that after you successfully run the command and generate an html file that you can move the html file, but you also must move the javascript and css directories.  You may also edit your html file so that the javascript and css tags match the location of those directories.

How to run:
php generate.php {ISBN} {destination.file}
php generate.php {ISBN,ISBN,...} {distination.file}
php generate.php {isbn_source.file} {distination.file}

{ISBN} - The first argument for the script can be a single ISBN number.
{ISBN,ISBN,...}The first argument may be many ISBN numbers seperated by a ',' with no spaces
{isbn_source.file}The first argument may be the name of a file that has an ISBN number on each line.

{destination.file} The second argument is optional, but if provided the script will create the file given the name you provide.  If blank then it will create 'index.html'.  Caution!  This will overwrite the file if it already exist.

You may need to run the above commands with the 'sudo' command depending on your environment and permission level.
