<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	
	if(!is_numeric($_GET['act_id'])) {
		header('Location: index.php');
		exit;
	}
	
	$id = (int)$_GET['act_id'];
	
	$dir = "download/pass_activities/";
	$sql = "SELECT * FROM `out_activity` WHERE `act_del` = '0' AND `act_id` = '$id'";
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
		$life_sub = "";
		switch($row['act_type']) {
			case 1:
				$type = "服務學習";
				break;
			case 2:
				$type = "生活知能";
				if ($row['act_life_sub'] == 1){
				$life_sub = " - 大一週會";
				}
				else if ($row['act_life_sub'] == 2){
					$life_sub = " - 大一CPR";
				}
				else if ($row['act_life_sub'] == 3){
					$life_sub = " - 自我探索與生涯規劃";
				}
				else if ($row['act_life_sub'] == 4){
					$life_sub = " - 國際視野";
				}

				else if ($row['act_life_sub'] == 6){
					$life_sub = " - 院週會";
				}
				else{
					$life_sub = " - 一般";
				}
				break;
			case 3:
				$type = "人文藝術";
				break;
			default:
				$type = "無";
		}
		
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
			default:
				$hour = 0;
		}
		
?>
					<h3 class="title">
						<?php echo $row['act_title']; ?>
					</h3>
					<div class="story">
						<table style="table-layout:fixed" width="600" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
							<tr height="30">
								<td width="120" align="left"><span class="highlight">活動編號</span></td>
								<td width="480"><?=$row['act_no']?></td>
							</tr>
							<tr height="30">
								<td width="120" align="left"><span class="highlight">活動名稱</span></td>
								<td width="480"><?=$row['act_title']?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">活動地點</span></td>
								<td><?=$row['act_location']?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">活動年度</span></td>
								<td><?=$row['act_semester']?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">活動開始時間</span></td>
								<td><?=$row['act_begin_time']?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">活動結束時間</span></td>
								<td><?=$row['act_end_time']?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">活動主辦單位</span></td>
								<td><?$office=($row['act_req_office'] == NULL)?"無":$row['act_req_office']; echo $office;?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">活動類別</span></td>
								<td><?=$type.$life_sub?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">核定認證時數</span></td>
								<td><?=$hour?></td>
							</tr>
							<tr height="30">
								<td width="120" align="left"><span class="highlight">活動內容</span></td>
								<td width="480" style= "word-wrap: break-word; word-break: break-all; overflow: hidden; width: 480px;"><?php echo nl2br($row['act_description']); ?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">服務方式</span></td>
								<td><?$service=($row['act_service_type'] == NULL)?"無":$row['act_service_type']; echo $service;?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">學習分類</span></td>
								<td><?$learn=($row['act_learn_type'] == NULL)?"無":$row['act_learn_type']; echo $learn;?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">聯絡人</span></td>
								<td><?$person=($row['act_req_person'] == NULL)?"無":$row['act_req_person']; echo $person;?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">聯絡電話</span></td>
								<td><?$phone=($row['act_req_phone'] == NULL)?"無":$row['act_req_phone']; echo $phone;?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">聯絡信箱</span></td>
								<td><?$email=($row['act_req_email'] == NULL)?"無":$row['act_req_email']; echo $email;?></td>
							</tr>
						</table>
					</div>
				</div>
				
<?php
	$reject = "<a href=\"pass_del_out_activity.php?id=$id\" onClick=\"return confirm('確定拒絕?');\"><img src=\"images/icon/reject.png\" style=\"border: none; width: 150px;\"/></a>";
?>
				<table width="600" style="margin-top: 20px;" border="0" cellspacing="0" cellpadding="0">
					<tr align="center">
						<td><?=$reject?></td>
					</tr>
				</table>
	            <div class="buttons" style="margin: 10px;">
					<a href="pass_out_activities_manage.php" class="button" id="register-now">回上頁</a>
				</div>
			</div>	
		</div>
		
		<? require_once("footer.php");?>

	</body>
</html>
