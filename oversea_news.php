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
										<a href="http://ncusec.ncu.edu.tw/news/headlines_content.php?H_ID=518"><i class="fa fa-play-circle" style="font-size:24px"></i>2007 泰緬邊境海外服務　學子「五人行」整裝待發</a><br>
										<a href="http://ncusec.ncu.edu.tw/news/press_content.php?P_ID=7090"><i class="fa fa-play-circle" style="font-size:24px"></i>2008 中大志工隊　送愛到中印</a><br>
										<a href="http://ncusec.ncu.edu.tw/news/headlines_content.php?H_ID=1213"><i class="fa fa-play-circle" style="font-size:24px"></i>2012 返鄉、饋鄉－僑生返鄉服務計畫</a><br>
										<a href="http://ncusec.ncu.edu.tw/news/headlines_content.php?H_ID=1400"><i class="fa fa-play-circle" style="font-size:24px"></i>2013 中央聯蒙、古動你心－國際志工前進蒙古育幼院</a><br>
										<a href="http://ncusec.ncu.edu.tw/news/headlines_content.php?H_ID=1719"><i class="fa fa-play-circle" style="font-size:24px"></i>2015 日本「里山文化」服務學習　找回人與自然的和諧關係</a><br>
										<a href="http://www.ncu.edu.tw/campus/article/2007"><i class="fa fa-play-circle" style="font-size:24px"></i>2017 夢想「蘭」圖　國際志工前進斯里蘭卡</a><br>
										<a data-toggle="collapse" data-target="#demo5"><i class="fa fa-play-circle" style="font-size:24px"></i>2018讓心。飛「越」幸福</a></br>
										<div id="demo5" class="collapse">
										<p style="margin: 10px; margin-left:6%;">
										（一）<a href="https://www.ncu.edu.tw/campus/article/2165">中大新聞</a><br>
										（二）<a href="https://money.udn.com/money/story/6722/3319896">經濟日報</a><br>
										（三）<a href="https://www.ettoday.net/news/20180820/1239842.htm">ETtoday新聞雲</a><br>
										（四）<a href="http://www.cdns.com.tw/news.php?n_id=0&nc_id=247443">中華日報</a><br>
										（五）<a href="http://www.epochtimes.com/b5/18/8/20/n10652086.htm">台灣大紀元</a><br>
										（六）<a href="https://times.hinet.net/news/21920241">HiNet新聞</a><br>
										（七）<a href="https://news.sina.com.tw/article/20180821/27910222.html">新浪新聞</a>
										</p>
										</div>
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
