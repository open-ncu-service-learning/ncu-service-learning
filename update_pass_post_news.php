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
	
	$id = (int)$_POST['news_id'];
	$postby = $_SESSION['valid_username'];
	
// 檔案上傳
	$dir = "download/pass_news/";
	$var = "";
	$tag = 0;

	$str = "";
	for($i = 1; $i <= 3; $i++)
	{
		$var = "file"."$i";
		if(is_uploaded_file($_FILES[$var]['tmp_name']))
		{
			$filetype = substr($_FILES[$var]['name'], strrpos($_FILES[$var]['name'] , ".")+1);
			$$var = time()."$i." . $filetype;
			
			if(move_uploaded_file($_FILES[$var]['tmp_name'], $dir.$$var)) {
				$str .= ", news_$var = '".$$var."'";
			} else {
				echo
				"
					<script>
						alert(\"檔案上傳失敗\");
						self.location.href='pass_updateNews.php?news_id=$id';
					</script>
				";	
			}
		}		
	}

// 記錄ip
	if(empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$ip = $ip[0];
	}
	
	function transtr($post_string)
	{
	$ptextrea=str_replace("'","&#39;",$post_string) ;
	return str_replace('"','&quot;',$ptextrea);
	}
	$postedValue = transtr(nl2br($_POST['description']));
	$postedtitle= transtr($_POST['title']);

// 資料更新	
	$sql = "UPDATE `pass`.`news` 
			SET
				`news_title` = '$postedtitle' 
				$str,
				`news_link`  = '$_POST[link]',
				`news_type`  = '$_POST[type]',
				`news_text`  = '$postedValue'
			WHERE
				`news_id` = '$id'
		   ";
		
	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		echo
		"
			<script>
				alert(\"修改公告成功\");
				self.location.href='pass_news_content.php?news_id=$id';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"修改公告失敗\");
				self.location.href='pass_updateNews.php?news_id=$id';
			</script>
		";
	}
?>
	</body>
</html>