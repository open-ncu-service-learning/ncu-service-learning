<?php 
	$hostname_db = "localhost";
	$database_db = "pass";
	$username_db = "service_learning";
	$password_db = "hCDDP76XzEUJKymB";
	$db = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($database_db, $db);
	mysql_query("SET NAMES 'utf8mb4'");
?>
