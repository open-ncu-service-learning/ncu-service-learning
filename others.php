<?php
	session_start();
	
	// 身分驗證
	if ($_SESSION['valid_token'] != "2") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	$account = $_SESSION['valid_office_account'];
	$office = $_SESSION['valid_office'];
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

			<div id="main">
				<div id="welcome" class="post">
<?php
		// 取出個人資料
		$sql = "SELECT * FROM `ncu_user` WHERE user_account = '$account'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		$row = mysql_fetch_assoc($ret);
?>
					<h3>申請單位</h3>
					<div id="person" style="color: #3F3F3F; margin-top: 20px;">
						<ul class="list" style="margin-left: 10px; list-style-type: none;">
							<li>單位名稱：<span style="color: #FF00B2;"><?=$row['user_office']?></span></li>
							<li>單位帳號：<span style="color: #FF00B2;"><?=$row['user_account']?></span></li>
							<!--<li>社長名稱：<span style="color: #FF00B2;"><?//=$row['user_pres']?></span></li>
							<li>電子郵件：<span style="color: #FF00B2;"><?//=$row['user_email']?></span></li>
							<li>連絡電話：<span style="color: #FF00B2;"><?//=$row['user_contact']?></span></li>-->
						</ul>
					</div>
<!--					<form id="form" action="others-1.php" method="post">
						<div class="buttons">
							<button type="submit">
								<img src="images/tick.png" alt="" />修改資料
							</button>
						</div>
					</form>-->
					<form id="form" action="pass_apply_activities.php" method="post">
						<div class="buttons">
							<button type="submit">
								<img src="images/tick.png" alt="" />活動申請
							</button>
						</div>
					</form>
					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
