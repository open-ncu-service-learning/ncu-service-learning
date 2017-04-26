<?php
	session_start();
	require_once("conn/db.php");
	
	if(!is_numeric($_GET['news_id'])) {
		header('Location: index.php');
		exit;
	}
	
	$id = (int)$_GET['news_id'];
	
	$dir = "download/pass_news/";
	$sql = "SELECT * FROM news WHERE news_del = '0' AND news_id = '$id' ORDER BY news_time ASC";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
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
	<!-- logo -->
		<? require_once("logo.php");?>
	<!-- MenuBar -->
		<? require_once("menu.php");?>
	<!-- Content -->
		<div id="content">
		<!-- sidebar --> 
			<? require_once("sidebar.php");?>
		<!-- news -->
			<div id="main">
				<div id="welcome" class="post">
<?php do { ?>
					<h3 class="title">
						<?php echo $row['news_title']; ?>
					</h3>
					<h2 class="date">
						<span class="month">
						<?php
							switch(substr($row['news_time'], 5, 2))
							{	
								case '01':
									echo '一月';
									break;
								case '02':
									echo '二月';
									break;
								case '03':
									echo '三月';
									break;
								case '04':
									echo '四月';
									break;
								case '05':
									echo '五月';
									break;
								case '06':
									echo '六月';
									break;
								case '07':
									echo '七月';
									break;
								case '08':
									echo '八月';
									break;
								case '09':
									echo '九月';
									break;	
								case '10':
									echo '十月';
									break;	
								case '11':
									echo '十一月';
									break;	
								case '12':
									echo '十二月';
									break;	
							}					
							?>
						</span> 
						<span class="day">
							<? echo substr($row['news_time'], 8, 2); ?>
						</span>
					</h2>
					<div class="meta" style="color: #333333; font-size: 12pt;">
						<span style="color: #3F1000;">公告單位：服務學習網</span>
						<?php
						if($_SESSION['valid_token'] == "3")
						{
							echo "<a href='pass_updateNews.php?news_id=$row[news_id]'"." onClick=\"return confirm('確定修改?');\" style=\"color: #D57100;\"> 修改公告</a> \t";
							echo "<a href='pass_delNews.php?news_id=$row[news_id]'"." onClick=\"return confirm('確定刪除?');\" style=\"color: #D57100;\">刪除公告</a>";
						}
						?>
				
						<br />
						<span style="color: #3F1000;">公告日期：<?=$row['news_time']?></span><br />
						
						
						<?
							// 連結
							if($row['news_link'] != NULL && $row['news_link'] != "http://")
								echo "<a href='$row[news_link]' style='color: #FF00FA;'>相關連結 </a>";
							
							// 檔案
							for($i = 1; $i <= 5; $i++)
							{
								$var = "news_file"."$i";
								if ($row[$var]){
									echo "<a href=\"".$dir.$row[$var]."\" style=\"color: #009900;\">檔案$i </a>";
								}
							}
						?>
					</div>
					<div class="story">
						<td><?php echo nl2br($row['news_text']); ?></td>
					</div>
<?php } while ($row = mysql_fetch_assoc($ret)); ?>
				</div>
	            <div class="buttons" style="margin: 10px;">
					<a href="javascript:history.back()" class="button" id="register-now">回上頁</a>
				</div>
			</div>	
		</div>
		
		<? require_once("footer.php");?>

	</body>
</html>
