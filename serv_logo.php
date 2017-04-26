<?php
	session_start();
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
					<h3>服務學習辦公室LOGO</h3>
					<div align="center">
						<img src="images/logo.png" style="width: 70%;">
					</div>
					<div>					
					<a style="font-weight:bold;font-size:16pt;"><br>理念：</a><br>
					<p style="font-size:14pt;">
						Logo的左右兩個人是希望同學們能發揮大手牽小手的精神，積極地去服務他人。
						中間的心代表了心的發現，透過服務的過程來培養同理心，從中獲得自我成長和增加了解社會的機會。
						遠看Logo，像是看到一本書，就如同是每一位具備知識的中央同學，每一個人都有一顆善良的心。
						設計這個Logo是希望同學除了有愛心之外，還要能夠積極行動，才能獲得更多。
					</p>
					</div>
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
