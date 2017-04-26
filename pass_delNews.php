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
	
// 資料刪除	
	//$sql = " DELETE FROM`pass`.`news` WHERE `news_id` = '$id'";
	$sql="UPDATE `news` SET `news_del`='1' WHERE `news_id` = '$id'";
		
	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		echo
		"
			<script>
				alert(\"刪除公告成功\");
				self.location.href='pass_new_news.php';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"刪除公告失敗\");
				self.location.href='pass_new_content.php?news_id='$row[news_id]'';
			</script>
		";
	}
?>
	</body>
</html>
