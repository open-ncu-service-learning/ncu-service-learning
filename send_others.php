<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "2") {
		header('Location: index.php');
		exit;
	}
	$account = $_SESSION['valid_office_account'];
	$office = $_SESSION['valid_office'];

	require_once("conn/db.php");
	require_once("function_lib.php");		
		
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
<?php

	//$pres = $_POST['pres'];
	$pres = null;
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$sql = "SELECT COUNT(*) as num FROM `admin` WHERE `ad_account` = '$account' AND ad_del = '0'";
	
	
		// 紀錄ip
		if(empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = $ip[0];
		}
	// 修改資料
		$sql = "UPDATE `pass`.`ncu_user` SET `user_pres`='$pres',`user_contact`='$phone',`user_email`='$email', `user_login_time`=NOW(),`user_login_ip`='$ip' 
			WHERE `user_account`='$account' && `user_del`='0' ";
		
				
		$ret = mysql_query($sql) or die(mysql_error());
		
		if($ret)
		{
			echo
			"
				<script>
					alert(\"單位檔案修改成功\");
					self.location.href='others.php';
				</script>
			";
		}
		else
		{
			echo
			"
				<script>
					alert(\"單位檔案修改失敗\");
					self.location.href='others.php';
				</script>
			";
		}

?>
	</body>
</html>
