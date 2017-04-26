<?php
	session_start();
	require("conn/mysqli.php");
	$conn->set_charset("utf8");
	require_once("function_lib.php");
	
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
					<!-- 公告 -->

<?php
	$stmt = $conn->prepare("SELECT news_time, news_id, news_title, COUNT(news_id) AS numrows FROM news WHERE news_type = ?");
	$stmt->bind_param("i", $_GET['type']);
	$stmt->execute();
	
	$stmt->close();
	// 有效筆數
	$sql =  "SELECT COUNT(news_id) AS numrows FROM news WHERE news_del = '0' AND news_type= '"
			.$_GET['type'] ." ' ";
	
	
	$ret = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($ret);
	$numrows = $row['numrows'];
	
	include("pass_paging.php");
	
	//公告資料
		$sql = "SELECT news_time, news_id, news_title FROM news WHERE news_del = '0' AND news_type = '"
		.$_GET['type']
		." ' ORDER BY news_time DESC LIMIT $offset, $rowsPerPage";
	
	$ret = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($ret);
	
	if($numrows > 0)
	{
?>
		
				<div class="post">
					<h2 class="title">
<?php					
	if($_GET['type']==1){
		echo "校內公告";
	}else if($_GET['type']==2){
		echo "校外公告";
	}else if($_GET['type']==3){
		echo "補助公告";
	}
	else if($_GET['type']==4){
		echo "志工招募";
	}
					
?>
					</h2>
				</div>
				<div class="story">
					<div class="chart">
						<div class="item1">
							發佈時間
						</div>
<!--
						<div class="item2">
							類別
						</div>
-->
						<div class="item3">
							標題
						</div>
					</div>
					<div style="border-bottom: 1px solid #EAEAEA;"></div>
<?
		do {
?>
						<div class="chart">
							<div class="item1">
								<? echo substr($row['news_time'], 0, 10);?>
							</div>
<!--
							<div class="item2">
								一般公告
							</div>
-->
							<div class="item3">
								<a href="pass_news_content.php?news_id=<?=$row['news_id']?>"><?=bite_str($row['news_title'], 0 , 40)?></a>							
							</div>
						</div>
<?php
		} while ($row = mysqli_fetch_assoc($ret));
?>
					</div>
				</div>
				<p><? echo $first . $prev . $nav . $next . $last; ?></p>
<?php
	}
	elseif($numrows == 0)
	{
?>
					<div class="chart">
						<div class="item1">
							暫無公告
						</div>
					</div>
				</div>
<?php
	}
	elseif($numrows == $topnum) {
		echo "			
					</div>
				</div>";
	}
?>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
