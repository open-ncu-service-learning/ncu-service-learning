﻿<?php	
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
<?php 	
	require("conn/db.php");
	$sql = "UPDATE `admin` SET ad_del = '1' WHERE ad_id = "."'".$_GET['id']."'";
	
	//$sql = "DELETE FROM `admin`  WHERE ad_id = "."'".$_GET['id']."'";
	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"管理員帳號刪除成功\");
				self.location.href='pass_admin.php';
			</script>
		";
	}
	else
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"管理員帳號刪除失敗\");
				self.location.href='pass_admin.php';
			</script>
		";
	}
?>
	</body>
</html>