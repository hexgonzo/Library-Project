# Library-Project
A simple project that will be used to evaluate my competency as a web developer for Fresno State.
Installed and tested on Centos 7:

Linux version 3.10.0-862.2.3.el7.x86_64 (builder@kbuilder.dev.centos.org) (gcc version 4.8.5 20150623 (Red Hat 4.8.5-28) (GCC) ) #1 SMP Wed May 9 18:05:47 UTC 2018

PHP Version: 

PHP 5.4.16 (cli) (built: Apr 12 2018 19:02:01)
Copyright (c) 1997-2013 The PHP Group
Zend Engine v2.4.0, Copyright (c) 1998-2013 Zend Technologies

If you copy the file structure in a directory that is accessible to the internet, then you may run the commands below out of the box.  However, if you move folders or files around then you may break the script.  Keep in mind that after you successfully run the command and generate an html file that you can move the html file, but you also must move the javascript and css directories.  You may also edit your html file so that the javascript and css tags match the location of those directories.

How to run:
Type the following lines into the command line, ommit the single quotes: 
'php generate.php {ISBN} {destination.file}'.  {ISBN} may be a single ISBN, or many ISBN seperated by a comma with no spaces.  It may also be a file that contains a list of ISBN on seperate lines.  {destination.file} is the name of the html file you would like to create.  If blank, 'index.html' will be created.  A word of caution, if the file already exists then this program will overwrite it.

Example:  'php generate.php 554433222 onebook.html'.  The program will attempt to look up the number 554433222 and create onebook.html if the ISBN is found.


You may need to run the above commands with the 'sudo' command depending on your environment and permission level.
