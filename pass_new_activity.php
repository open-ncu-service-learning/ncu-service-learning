<?php
	session_start();
	require_once("conn/mysqli.php");
	$conn->set_charset("utf8");
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
					<select name="type" style="float: right;" onChange="location.href=this.options[this.selectedIndex].value;">
						<option value="pass_new_activity.php" <?php if (!(strcmp("", $_GET['type']))) {echo "selected";} ?>>請選擇活動類別</option>
						<option value="pass_new_activity.php?type=1" <?php if (!(strcmp(1, $_GET['type']))) {echo "selected";} ?>>服務學習</option>
						<option value="pass_new_activity.php?type=2" <?php if (!(strcmp(2, $_GET['type']))) {echo "selected";} ?>>生活知能</option>
						<option value="pass_new_activity.php?type=3" <?php if (!(strcmp(3, $_GET['type']))) {echo "selected";} ?>>人文藝術</option>
					</select>

<?php
	
	$condition = "";
	if($_GET['type'] != NULL)
		$condition = " news_act_type ='".$_GET['type']."' AND ";

	$stmt = $conn->prepare("SELECT *, COUNT(news_id) AS num FROM news_activity WHERE news_act_type =? AND news_del = '0'");
	$stmt->bind_param("i", $_GET['type']);
	$stmt->execute();
	$stmt->close();
	
	//管理者:全部的活動 一般使用者:只能看到近期舉辦活動
	if($_SESSION['valid_token'] == "3")
		$sql = "SELECT COUNT(news_id) as num FROM news_activity WHERE $condition news_del = '0' ORDER BY news_begin_time DESC";
	else
		$sql = "SELECT COUNT(news_id) as num FROM news_activity WHERE $condition news_del = '0' AND news_end_time >= CURDATE() ORDER BY news_begin_time";
	
	$ret = mysqli_query($conn,$sql) or die(mysqli_error());
	$row = mysqli_fetch_assoc($ret);
	$numrows = $row['num'];
	
	// 分頁
	require_once("pass_paging.php");
	
	//管理者:全部的活動 一般使用者:只能看到近期舉辦活動
	if($_SESSION['valid_token'] == "3")
		$sql = "SELECT * FROM news_activity WHERE $condition news_del = '0' ORDER BY news_begin_time DESC LIMIT  $offset, $rowsPerPage";
	else
		$sql = "SELECT * FROM news_activity WHERE $condition news_del = '0' AND news_end_time >= CURDATE() ORDER BY news_begin_time LIMIT $offset, $rowsPerPage";
		
	$ret = mysqli_query($conn,$sql) or die(mysqli_error());
	$row = mysqli_fetch_assoc($ret);
	
	if($numrows > 0)
	{
?>
		
				<div class="post">
					<h2 class="title">
						最新認證活動
					</h2>
				</div>
				<div class="story">
					<div class="chart">
						<div class="item1">
							活動時間
						</div>
						<div class="item2">
							類別
						</div>
						<div class="item3">
							標題
						</div>
					</div>
					<div style="border-bottom: 1px solid #EAEAEA;"></div>
<?
		do {
				$type = "";
				switch($row['news_act_type']) {
					case 1:
						$type = "服務學習";
						break;
					case 2:
						$type = "生活知能";
						break;
					case 3:
						$type = "人文藝術";
						break;
					default:
						$type = "無";
				}
?>
						<div class="chart">
							<div class="item1">
								<? echo substr($row['news_begin_time'], 0, 10);?>
							</div>
							<div class="item2">
								<?=$type?>								
							</div>
							<div class="item3">
								<a href="pass_activity_content.php?news_id=<?=$row['news_id']?>"><?=$row['news_title']?></a>
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
?>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
