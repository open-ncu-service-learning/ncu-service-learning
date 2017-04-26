<?php
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
	require_once("conn/db.php");
	
	$account = $_SESSION['valid_admin_account'];
	$password= $_POST['pass'];
	
	if($_POST['pass'] == $_POST['repass'])
	{
		$p = sha1($_POST['pass']);
		// 紀錄ip
		if(empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = $ip[0];
		}
		$sql = "UPDATE `admin`  SET ad_password = '$p'  WHERE ad_account = '$account'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		
		if($ret)
		{
			echo
			"
				<script>
					alert(\"密碼修改成功\");
					self.location.href='pass_admin2.php';
				</script>
			";
		}
		else
		{
			echo
			"
				<script>
					alert(\"密碼修改失敗\");
					self.location.href='pass_admin2.php';
				</script>
			";
		}
	}
	else
	{
		echo
		"
			<script>
				alert(\"請確認密碼\");
				self.location.href='pass_admin2.php';
			</script>
		";	
	}

?>
	</body>
</html>