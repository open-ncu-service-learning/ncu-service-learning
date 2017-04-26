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

<!-- News -->
			<div id="main">
				<div id="welcome" class="post">
					<h3>中大護照精神</h3>
					<p style="margin-top: 10px;">
						<中大護照精神><br /><br />
						萬株蒼松滿布校園，承載「誠樸」校訓，孕育無數卓絕質樸學子，實為中大
						無價傳承資產。面對時代變遷與全球化浪潮下，本校在追求學術卓越之際，
						亟思提升環保永續校園優質文化，建構學生領導統御與團隊合作的核心價值
						，倡導其體認服務、活動、生活多元學習，激發其活力與創意的潛能，培養
						其積極與負責的態度，引領其發掘自我、尊重生命、關懷社會，成為學養兼
						修，勇於面對挑戰，胸懷自信達略的中大人。
					</p>
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
