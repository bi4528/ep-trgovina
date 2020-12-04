## ep-projekt #

Projekt pri predmetu EP

## Vzpostavljanje podatkovne baze #

ep@ep:~$ mysql -u root -p < NetBeansProjects/ep-trgovina/sql/db.sql
Enter password: 
ep@ep:~$ mysql -u root -p
Enter password: 
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 14
Server version: 8.0.22-0ubuntu0.20.04.2 (Ubuntu)

Copyright (c) 2000, 2020, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| bookstore          |
| information_schema |
| jokes              |
| myJokes            |
| mysql              |
| performance_schema |
| quickform2         |
| sys                |
| testna_shema       |
| uporabniki         |
+--------------------+
10 rows in set (0.01 sec)

mysql> use uporabniki;
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Database changed
mysql> show tables;
+----------------------+
| Tables_in_uporabniki |
+----------------------+
| uporabniki           |
+----------------------+
1 row in set (0.00 sec)

mysql> select * from uporabniki;
+----+------+---------+---------------------+-------------+--------+-------+
| id | ime  | priimek | email               | geslo       | naslov | vloga |
+----+------+---------+---------------------+-------------+--------+-------+
|  1 | Adam | Admin   | adam.admin@mail.com | adamAmin123 | NULL   | admin |
+----+------+---------+---------------------+-------------+--------+-------+
1 row in set (0.01 sec)

mysql> 


