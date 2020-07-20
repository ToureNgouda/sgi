<?php
// $mysql_hostname = "db712152367.db.1and1.com";
// $mysql_user = "dbo712152367";
// $mysql_password = "28011.Infinite";
// $mysql_database = "db712152367";
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "sgiclient";
$prefix = "";
$bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysqli_query($bd,"SET NAMES UTF8"); 
// mysql_query('SET NAMES UTF8') ;
//mysqli_set_charset($bd, "UTF8");
mysqli_select_db($bd, $mysql_database) or die("Could not select database");
?>     