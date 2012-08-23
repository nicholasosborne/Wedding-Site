<?php
$db_host = "localhost";
$db_user = "";
$db_password = "";
$db_name = "";


$link = mysql_connect($db_host, $db_user, $db_password) or die("Could not connect: " . mysql_error());
mysql_select_db($db_name) or die(mysql_error());
?>