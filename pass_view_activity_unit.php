<?php
	session_start();
	
	// 身分驗證
	if ($_SESSION['valid_token'] != "2") {
		header('Location: index.php');
		exit;
	}

	// 檢查
	if(!is_numeric($_GET['id'])) {
		header('Location: index.php');
		exit;
	}
	$id = (int)$_GET['id'];
	
	require_once("conn/db.php");
	$sql = "SELECT * FROM `activity` WHERE `act_del` = '0' AND `act_id` = '$id'";
	//$sql = "SELECT * FROM `activity` LEFT JOIN `news_activity` ON activity.act_title=news_activity.news_title WHERE `act_del` = '0' AND `act_id` = '$id' AND news_activity.news_no LIKE '%$id%'";
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
<?php 

		// 活動型態
		$type = "";
		switch($row['act_type']) {
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
		
		// 認證時數
		$hour = "";
		switch($row['act_pass_type']) {
			case 1:
				$hour = "基本: ".$row['act_service_hour'];
				break;
			case 2:
				$hour = "高階: ".$row['act_service_hour'];
				break;
			case 3:
				$arr = explode(',', $row['act_service_hour']);
				$hour = "基本: $arr[0] <br />高階: $arr[1]";
				break;
			case -1:
				$hour = "依服務時數進行認證";
			default:
				$hour = 0;
		}
		
		if($row['act_service_hour'] == -1)
		{
			$hour = "依服務時數進行認證";
		}
		
		// 認證條件
		if($row['act_report'])
			$requirement[] = "心得報告";
		if($row['act_engage'])
			$requirement[] = "全程參與";
		if($row['act_questionnaire'])
			$requirement[] = "問卷回饋";
		if($row['act_test'])
			$requirement[] = "考試";
		if($row['act_other'])
			$requirement[] = $row['act_other'];
			
		$req = implode(",", $requirement);
		
		// 檔案附件
		$dir = "download/pass_activities/";
?>
					<h3 class="title">
						<?php echo $row['act_title']; ?>
					</h3>
					
					<div class="story">
						<table style="table-layout:fixed" width="600" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
							<tr>
								<td width="120"><span class="highlight">活動編號</span></td>
								<!--<td width="480"><?=$row['news_no']?></td>-->
								<td width="480"><?=$row['act_id']?></td>
							</tr>
							<tr>
								<td><span class="highlight">活動名稱</span></td>
								<td><?=$row['act_title']?></td>
							</tr>
							<tr>
								<td><span class="highlight">活動地點</span></td>
								<td><?=$row['act_location']?></td>
							</tr>
							<tr>
								<td><span class="highlight">活動年度</span></td>
								<td><?=$row['act_semester']?></td>
							</tr>
							<tr>
								<td><span class="highlight">活動開始時間</span></td>
								<td><?=$row['act_begin_time']?></td>
							</tr>
							<tr>
								<td><span class="highlight">活動結束時間</span></td>
								<td><?=$row['act_end_time']?></td>
							</tr>
							<tr>
								<td><span class="highlight">發佈單位</span></td>
								<td><?=$row['act_req_office']?></td>
							</tr>
							<tr>
								<td><span class="highlight">活動類別</span></td>
								<td><?=$type?></td>
							</tr>
							<tr>
								<td><span class="highlight">核定認證時數</span></td>
								<td><?=$hour?></td>
							</tr>
							<!--<tr>
								<td><span class="highlight">認證貼紙張數</span></td>
								<td><?//=$row['act_sticker_number']?></td>
							</tr>-->	
							<tr>
								<td><span class="highlight">認證要求</span></td>
								<td><?=$req?></td>
							</tr>
							<tr>
								<td width="120"><span class="highlight">活動內容</span></td>
								<td width="480" style= "word-wrap: break-word; word-break: break-all; overflow: hidden; width: 480px;"><?php echo nl2br($row['act_description']); ?></td>
							</tr>
							<tr>
								<td><span class="highlight">附加檔案</span></td>
								<td>
								<?php
									if($row['act_file'])
										echo "<a href='".$dir.$row['act_file']."' style='color: #ED00FF;'>".substr($row['act_file'],10)."</a>";
									else
										echo "無";
								?>
								</td>
							</tr>
							<tr>
								<td><span class="highlight">相關連結</span></td>
								<td>								
								<?php
									if($row['act_link'])
										echo "<a style=\"color: red;\" href=\"$row[act_file]\">".$row['act_link']."</a>";
									else
										echo "無";
								?>			
								</td>
							</tr>
							<tr>
								<td><span class="highlight">聯絡人</span></td>
								<td><?=$row['act_req_person']?></td>
							</tr>
							<tr>
								<td><span class="highlight">聯絡電話</span></td>
								<td><?=$row['act_req_phone']?></td>
							</tr>
							<tr>
								<td><span class="highlight">聯絡信箱</span></td>
								<td><?=$row['act_req_email']?></td>
							</tr>
						</table>
					</div>
				</div>
	            <div class="buttons" style="margin: 10px;">
					<a href="pass_apply_print.php?id=<?=$id?>.php" type="button" id="print">列印本申請表</a>
					<a href="history.php" class="button" id="register-now">回上頁</a>
				</div>
			</div>	
		</div>
		
		<? require_once("footer.php");?>

	</body>
</html>
