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
	
	$id = (int)$_GET['news_id'];
	//$idcol = $_GET['idcol']
	$file = $_GET['file'];
	$table = $_GET['table'];
	
// 檔案位置刪除	
	
	
	if($table == "news"){
		$sql = "UPDATE `pass`.`$table` SET `$file`= '' WHERE `news_id` = '$id'";
		$location = "pass_updateNews.php?news_id=$id";
	}
	else if($table == "out_activity"){
		$sql = "UPDATE `pass`.`$table` SET `$file`= '' WHERE `act_id` = '$id'";
		$location = "pass_updateOutActivity.php?id=$id";
	}
	else if($table == "activity"){
		$sql = "UPDATE `pass`.`$table` SET `$file`= '' WHERE `act_id` = '$id'";
		$location = "pass_updateActivitynotNews.php?act_id=$id";
	}	
	else{
		$sql = "UPDATE `pass`.`$table` SET `$file`= '' WHERE `news_id` = '$id'";
		$location = "pass_updateActivity.php?news_id=$id";
	}
		
	$ret = mysql_query($sql, $db) or die(mysql_error());
	if($ret)
	{
		echo
		"
			<script>
				alert(\"刪除檔案成功\");
				self.location.href='$location';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"刪除檔案失敗\");
				self.location.href='$location';
			</script>
		";
	}
?>
	</body>
</html>