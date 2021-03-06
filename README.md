fab-cms-extensions
==================

Some extensions to the fuel cms for fab equipment tracking

Install FUEL cms from github.  One note here: I ran into trouble on my centos box because I didn't have the php-mysql extensions installed.
FUEL doesn't give a helpful error in that case.  So make sure to do a yum install php-mysql php-pgsql if on CentOS/Redhat.  

Some additional prerequisites and their install commands on centos:

yum install php-gd php-ldap

git clone git://github.com/daylightstudio/FUEL-CMS.git

Follow fuel installation instructions:

    [ryant@ryan gitcms]$ mysql -u root
    Welcome to the MySQL monitor.  Commands end with ; or \g.
    Your MySQL connection id is 24
    Server version: 5.1.52 Source distribution
    
    Copyright (c) 2000, 2010, Oracle and/or its affiliates. All rights reserved.
    This software comes with ABSOLUTELY NO WARRANTY. This is free software,
    and you are welcome to modify and redistribute it under the GPL v2 license
    
    Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.
    
    mysql> create database fueldb;
    Query OK, 1 row affected (0.05 sec)
    
    mysql> create user myfueldba@'localhost' IDENTIFIED BY 'myfuelpass';
    Query OK, 0 rows affected (0.04 sec)
    
    mysql> grant all privileges on fueldb.* to myfueldba;
    Query OK, 0 rows affected (0.02 sec)
    
    perl -i -pe "s/\['username'\] = ''/['username'] = 'myfueldba'/" FUEL-CMS/fuel/application/config/database.php
    perl -i -pe "s/\['password'\] = ''/['password'] = 'myfuelpass'/" FUEL-CMS/fuel/application/config/database.php
    perl -i -pe "s/\['database'\] = ''/['database'] = 'fueldb'/" FUEL-CMS/fuel/application/config/database.php
    
    chgrp -R apache FUEL-CMS/fuel/application/cache/
    chgrp -R apache FUEL-CMS/assets/images
    
    chmod g+w FUEL-CMS/fuel/application/cache/
    chmod g+w FUEL-CMS/fuel/application/cache/dwoo/
    chmod g+w FUEL-CMS/fuel/application/cache/dwoo/compiled
    chmod g+w FUEL-CMS/assets/images
  
    perl -i -pe "s/admin_enabled'\] = FALSE;/admin_enabled'] = TRUE;/" FUEL-CMS/fuel/application/config/MY_fuel.php

Update .htaccess
-------------------

    vim FUEL-CMS/.htaccess #this is to change the rewrite base to match the url for where fuel is
  
Download changes to fuel cms for equipment tracking:

    git clone git://github.com/ufabdyop/fab-cms-extensions.git

rsync those to main fuel directory

    rsync -nrv --size-only fab-cms-extensions/ /var/www/html/FUEL-CMS/ #check the output
    rsync -rv --size-only fab-cms-extensions/ /var/www/html/FUEL-CMS/ #remove the dry-run flag -n
    
    
edit fuel/application/config/database.php

edit fuel/modules/equipment/config/equipment_config.php to configure svn for files

edit fuel/modules/equipment/models/equipment_model.php:   public static $coral_eq_url = 'http://mycoralserver.mydomain.com/coral/xml/equipment/Area.xml';

edit fuel/application/helpers/login_helper.php

create svn tree: public, staff, member

create coralutah schema in postgres db

Make sure short tags are on in /etc/php.ini

Make sure "AllowOverride FileInfo Options Limit" is in /etc/httpd/conf/httpd.conf
