<?php



	session_start();
	

	if($_SESSION['valid_token'] != "3") {
		header('Location:index.php');
		exit;
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>


<?php
	require_once("conn/db.php");
	
	$fileDir="download/pass_files_test/";

	$postby = $_SESSION['valid_admin_account'];
	$sql="DELETE FROM `pass`.`attach` WHERE `attach_id`=".$_POST['id'];

	$ret=mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		$filename=mb_convert_encoding($_POST['filename'],"big5","utf8");
		if(!unlink($fileDir.$filename)){
			header('Location:pass_attach.php');
			exit;
		}
	}
		

	header('Location:post_attach.php');
	exit;
	

?>
</body>
</html>



						