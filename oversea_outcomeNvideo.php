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
		<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />	
		<script type="text/javascript" src="js/JSCookMenu.js"></script>
		<script type="text/javascript" src="js/effect.js"></script>
		<script type="text/javascript" src="js/theme.js"></script>
		<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
			
				<div class="post" style="font-family:  微軟正黑體;" >
					<div id="TabbedPanels1" class="TabbedPanels" style="margin-bottom: 10px;">
						<div class="TabbedPanelsContentGroup">
							<div class="TabbedPanelsContent">
								<ul>
								<div id="welcome" class="post"> 
								<h3>新聞報導</h3>
								</div>
							
								<p style="margin: 10px; margin-left:6%;">
									<a href="https://www.youtube.com/watch?v=cOOmqd8990A"><i class="fa fa-play-circle" style="font-size:24px"></i>2008印度孟買暑期服務學習之旅</a><br>
									<a href="https://www.youtube.com/watch?v=YhfO3wDIkk8"><i class="fa fa-play-circle" style="font-size:24px"></i>2009印尼泗水暑期服務學習</a><br>
									<a href="https://youtu.be/W1mpfxYxWDg"><i class="fa fa-play-circle" style="font-size:24px"></i>2010柬埔寨暑期服務學習成果影片</a><br>
									<a href="https://youtu.be/mHovHic5DxI"><i class="fa fa-play-circle" style="font-size:24px"></i>2013蒙古暑期服務學習成果影片</a><br>
									<a href="https://youtu.be/EuTy0roucqg"><i class="fa fa-play-circle" style="font-size:24px"></i>2015日本暑期服務學習成果影片</a><br>
									<a href="https://youtu.be/gHG68hJhVvA"><i class="fa fa-play-circle" style="font-size:24px"></i>2016日本暑期服務學習成果影片</a><br>
									<a href="https://youtu.be/2trnjcN1cvA"><i class="fa fa-play-circle" style="font-size:24px"></i>2017斯里蘭卡暑期國際志工成果影片</a><br>
									<a href="https://youtu.be/AP-jV_0B0mQ"><i class="fa fa-play-circle" style="font-size:24px"></i>2018越南暑期國際志工招募影片</a><br><br>
									<a href="/download/servLearn_files/achievement.pdf"><i class="fa fa-file-o" style="font-size:24px"></i>歷年服務成果</a>
								</p>
								</ul>
							
							</div>
						</div>
					</div>
	
				</div>	
		</div>

		
		<? require_once("footer.php");?>

	</body>
</html>
