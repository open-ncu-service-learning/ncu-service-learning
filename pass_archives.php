<?php
	session_start();
	require_once("conn/db.php");
	
	$sql = "SELECT * FROM `archives` WHERE arch_del = '0'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>國立中央大學服務學習網</title>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
		<link href="css/menuTheme.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/JSCookMenu.js"></script>
		<script type="text/javascript" src="js/effect.js"></script>
		<script type="text/javascript" src="js/theme.js"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

<!-- Archives -->
			<div id="main">
				<div id="welcome" class="post">
					<h3>個人認證學習成果</h3>
<?php
	while($row = mysql_fetch_assoc($ret)) {
?>
						
					<div style="margin-top: 20px;">
						<h2 class="title">姓名：<?=$row['arch_name']?> 系級：<?=$row['arch_dep']?> 類別：<?=$row['arch_type']?></h2>
					</div>
					<br />
					<div style="font-size: 14pt;">
						活動名稱：<?=$row['arch_act_name']?><br />
						活動地點：<?=$row['arch_act_location']?><br /><br />
						<?=$row['arch_text']?>
					</div>
<?php
	}
?>
					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
