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
					<tr>
						<td align="left" style="margin: 10px; margin-left:3%;">
							<button style="margin: 10px; margin-left:3%;" type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo1"><h3 style="font-family: 微軟正黑體;" >107培訓課程</h3></button>
							<div id="demo1" class="collapse">
								<p style="margin: 10px; margin-left:3%;">
									<img src="images/oversea/winter_course107.jpg" width="100%">
									<img src="images/oversea/professional_course107.jpg" width="100%">
								</p>
							</div>
						</td>
						</tr>
						<tr>
						<td align="left" style="margin: 10px; margin-left:3%;">
							<button style="margin: 10px; margin-left:3%;" type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo2"><h3 style="font-family: 微軟正黑體;" >108培訓課程</h3></button>
							<div id="demo2" class="collapse">
								<p style="margin: 10px; margin-left:3%;">
									<img src="images/oversea/winter_course108.jpg" width="100%">
									<img src="images/oversea/professional_course108.jpg" width="100%">
								</p>
							</div>
						</td>
						</tr>
						
							
				</div>	
		</div>

		
		<? require_once("footer.php");?>

	</body>
</html>
