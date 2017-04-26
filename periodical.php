<?php	
	session_start();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>國立中央大學服務學習網</title>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
		<link href="css/menuTheme.css" rel="stylesheet" type="text/css" />
		<script src="js/JSCookMenu.js" type="text/javascript" ></script>
		<script src="js/effect.js" type="text/javascript" ></script>
		<script src="js/theme.js" type="text/javascript" ></script>
		<script src="js/jquery-1.2.3.min.js" type="text/javascript"></script>
		<script src="js/jquery.dimensions.min.js" type="text/javascript"></script>		
		<script src="js/jquery.inputHintBox.js" type="text/javascript"></script>
		<script src="js/checkForm.js" type="text/javascript"></script>
		<script src="fckeditor/fckeditor.js" type="text/javascript"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

<!-- Publish -->
			<div id="main">
				


<h3>期刊閱覽</h3>

<ol>
	
  <li><a href="periodical/first.pdf" >創刊號</a></li>
  <li><a href="periodical/second.pdf" >第二刊</a></li>
  <li><a href="periodical/third.pdf">第三刊</a></li>
  <li><a href="periodical/forth.pdf" >第四刊</a></li>
  <li><a href="periodical/fifth.pdf" >第五刊</a></li>
  <li><a href="periodical/sixth.pdf" >第六刊</a></li>
  <li><a href="periodical/seventh.pdf" >第七刊</a></li>
 
  
</ol>





			</div>
		</div>
		
		<? require_once("footer.php");?>

	</body>
</html>


