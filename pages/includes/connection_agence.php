<?php
$mysql_hostname = "db715463274.db.1and1.com";
$mysql_user = "dbo715463274";
$mysql_password = "28011.Aerow";
$mysql_database = "db715463274";
$prefix = "";
$bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysqli_query("SET NAMES UTF8"); 
mysqli_set_charset($bd,"utf8");
mysqli_select_db($bd, $mysql_database) or die("Could not select database");
?>