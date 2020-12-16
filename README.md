## ep-projekt #

Projekt pri predmetu EP

## Vzpostavljanje podatkovne baze #

ep@ep:~$ mysql -u root -p < NetBeansProjects/ep-trgovina/sql/db.sql  
ep@ep:~$ mysql -u root -p  
mysql> show databases;  
mysql> use uporabniki;  
mysql> show tables;  
mysql> select * from uporabniki;  

## Captcha #
apt-get install php-text-captcha
pear install HTML_QuickForm2_Captcha-0.1.2

## Tipkarske napake, ki vlečejo #
UporabnikiController.php
UporabnikDB.php, venader class Uprabnik.php
Good to know :)
