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
	$file = $_GET['file'];
	$table = $_GET['table'];
	
// 檔案位置刪除	
	$sql = "UPDATE `pass`.`$table` SET `$file`= '' WHERE `news_id` = '$id'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	
	if($table == "news")
		$location = "pass_updateNews.php?news_id=$id";
	else
		$location = "pass_updateActivity.php?news_id=$id";

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