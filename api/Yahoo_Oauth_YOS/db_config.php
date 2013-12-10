<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'bolcom_noel');
define('DB_PASSWORD', 'noel2468');
define('DB_DATABASE', 'bolcom_bolooka_db');

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('Oops connection error -> ' . mysql_error());
mysql_select_db(DB_DATABASE, $connection) or die('Database error -> ' . mysql_error());
?>