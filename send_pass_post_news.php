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
	
	$postby = $_SESSION['valid_admin_account'];
	
// 檔案上傳
	$dir = "download/pass_news/";
	//$dir = $_SERVER['DOCUMENT_ROOT'] ."/download/pass_news/";
	$var = "";
	$tag = 0;

	for($i = 1; $i <= 3; $i++)
	{
		$var = "file"."$i";
		if(is_uploaded_file($_FILES[$var]['tmp_name']))
		{
			$filetype = substr($_FILES[$var]['name'], strrpos($_FILES[$var]['name'] , ".")+1);
			$$var = time()."$i." . $filetype;
			
			if(move_uploaded_file($_FILES[$var]['tmp_name'], $dir.$$var)) {
			} else {
				echo
				
				"
					<script>
						alert(\"檔案上傳失敗\");
						self.location.href='pass_post_news.php';
					</script>
				";	
			}
			$tag = 1;
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
	$sql = "INSERT INTO `pass`.`news` (
				`news_title`,
				`news_type`,
				`news_file1`,
				`news_file2`,
				`news_file3`,
				`news_link`,
				`news_text`,
				`news_time`,
				`news_postby`,
				`news_del`
			)
			VALUES (
				'$postedtitle', '$_POST[news_type]', '$file1', '$file2', '$file3', '$_POST[link]', 
				'$postedValue', NOW(), '$postby', '0'
			)
		";
		
	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		echo
		"
			<script>
				alert(\"新增公告成功\");
				self.location.href='pass_new_news.php';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"新增公告失敗\");
				self.location.href='pass_post_news.php';
			</script>
		";
	}
?>
	</body>
</html>
