OPEN MYSQL CRUD UI
------------------

Lists ALL tables in your MySQL db (for now just bellow one another). The tables are then searchable and editable (CRUD - create,read,update,delete) and you can order them. To be used in a safe administration area. It doesn't allow user (web admin in our case) to add columns etc.  
It is desired to be a easier-to-use alternative to phpmyadmin, which is too complicated to serve a web-admin.  
Editing is saved immediately with ajax. Validation of fields is not supported in this release. 

Built upon Vincy's scripts (I extended them from one concrete table to any table), especially  
http://phppot.com/php/php-mysql-inline-editing-using-jquery-ajax/  
and  
http://phppot.com/php/php-crud-with-search-and-pagination-using-jquery-ajax/  
Big thanks!  

DEMO
----
Test it here with two tables:

http://devtests.webisti.cz/open_mysql_crud_ui/

INSTALLATION
------------
Prerequisite: your tables all have an auto increment primary key

set the MySQL vars on top of scripts/dbcontroller.php  

run index.php

CUSTOMIZATION
-------------
set the desired number of rows per page on top of scripts/pagination.class.php ($this->perpage =YOURNUMBER)  

if you need to list only specific tables, edit the call (in index.php) to: getresult("scripts/getresult.php?onlytables=YOURTABLENAME1,YOURTABLENAME2",'');

LICENCE
-------
Free even for commercial projects under GPL.

SUPPORT & COLLABORATION
-------
Paid work accepted, contact me at jakub (a) webisti cz    
My team's website: http://www.webisti.cz
