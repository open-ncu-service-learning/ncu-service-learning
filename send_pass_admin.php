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
	
	// 檢查使用者帳號是否重複
	$account = $_POST['account'];
	$sql = "SELECT COUNT(*) as num FROM `admin` WHERE `ad_account` = '$account' AND ad_del = '0'";
	if($ret = mysql_query($sql, $db) or die(mysql_error())) {
		$row = mysql_fetch_assoc($ret);
		if($row['num'] == '1') {
			echo
			"
				<script>
					alert(\"此管理員帳號已經使用過\");
					self.location.href='pass_admin.php';
				</script>
			";			
			exit;
		}
	}
	
	// 新增資料
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

		echo $row['ad_permission'];
		
		$sql = "INSERT INTO `pass`.`admin` (
					`ad_username`,
					`ad_account`,
					`ad_password`,
					`ad_permission`,
					`ad_login_time`,
					`ad_login_ip`,
					`ad_del`
				)
				VALUES (
					'$_POST[name]', '$_POST[account]', '$p', '$_POST[permission]' ,NOW() , '$ip', '0'
				)
			";	
		$ret = mysql_query($sql, $db) or die(mysql_error());
		
		if($ret)
		{
			echo
			"
				<script>
					alert(\"管理員帳號新增成功\");
					self.location.href='pass_admin.php';
				</script>
			";
		}
		else
		{
			echo
			"
				<script>
					alert(\"管理員帳號新增失敗\");
					self.location.href='pass_admin.php';
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
				self.location.href='pass_admin.php';
			</script>
		";	
	}

?>
	</body>
</html>
