<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
<?php

// 活動心得
	$postArray = &$HTTP_POST_VARS;
	
	foreach($postArray as $sForm => $value) {
		if(get_magic_quotes_gpc())
			$postedValue = stripslashes($value);
		else
			$postedValue = $value;
	}
	
// 資料更新
	$sql = "
			INSERT INTO `archives` (
				`arch_id` ,
				`arch_name` ,
				`arch_dep` ,
				`arch_type` ,
				`arch_act_name` ,
				`arch_act_location` ,
				`arch_text` ,
				`arch_time` ,
				`arch_del`
			)
			VALUES (
				'', '$_POST[name]', '$_POST[dep]', '$_POST[type]', '$_POST[act_name]', 
				'$_POST[act_location]', '$postedValue', NOW(), '0'
			)
		";
	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		echo
		"
			<script>
				alert(\"發佈認證成果成功\");
				self.location.href='pass_archives.php';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"發佈認證成果失敗\");
				self.location.href='pass_post_archives.php';
			</script>
		";
	}
?>
	</body>
</html>