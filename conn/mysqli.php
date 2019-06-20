<?php 
	$hostname_db = "localhost";
	$database_db = "pass";
	$username_db = "service_learning";
	$password_db = "hCDDP76XzEUJKymB";
	$conn = new mysqli($hostname_db, $username_db, $password_db, $database_db);
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	} 
	else
	{
		$conn->set_charset("utf8");
	}
	
?>