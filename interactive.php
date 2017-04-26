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
		<link href="css/slideshow.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/JSCookMenu.js"></script>
		<script type="text/javascript" src="js/effect.js"></script>
		<script type="text/javascript" src="js/theme.js"></script>
		<script src="js/mootools.js" type="text/javascript"></script>
		<script src="js/slideshow.js" type="text/javascript"></script>
		<script src="js/slideshow.kenburns.js" type="text/javascript"></script>
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

<!-- News -->
			<div id="main">
				<div id="welcome" class="post">
					<h3>互動分享區</h3>
					<p>
						<div id="show1" ></div>

						<script type="text/javascript">
						// BeginWebWidget Ken_Burns_Slideshow: show1
						window.addEvent('domready', function(){
							var data = {
								'2.jpg': { caption: '營歌教唱，小朋友都很大方到台上和大哥哥大姐姐一起唱歌！' }, 
								'3.jpg': { caption: '第一天的急救概述，熱心的大哥哥大姐姐幫小朋友們解惑。' }, 
								'4.jpg': { caption: '小朋友們都很認真的看著舞台上的大哥哥大姐姐賣力的演出。' }, 
								'5.jpg': { caption: '第一天簽到時的相見歡～' }, 
								'6.jpg': { caption: '包紮課大家在練習，現在教的是頭部巾狀。弟弟你的繩頭沒收唷！' }, 
								'7.jpg': { caption: '結束時的大合照1、2、3，YA～' }
							};
							var myShow = new Slideshow.KenBurns('show1', data, { captions: true, controller: true, delay: 4000, duration: 1000, height: 450, hu: 'pictures/main/', thumbnails: false, width: 600 });
						});

						// EndWebWidget Ken_Burns_Slideshow: show1
						</script>
					</p>
					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
