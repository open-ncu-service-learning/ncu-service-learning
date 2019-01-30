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
	$sql = "SELECT * FROM `activity` WHERE `act_del` = '0' AND `act_id` = '$id'";
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
				else if ($row['act_life_sub'] == 5){
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
				$serv_type = " - 基本";
				break;
			case 2:
				$hour = "高階: ".$row['act_service_hour'];
				$serv_type = " - 高階";
				break;
			case 3:
				$arr = explode(',', $row['act_service_hour']);
				$hour = "基本: $arr[0] <br />高階: $arr[1]";
				$serv_type = "";
				break;
			default:
				$hour = 0;
		}
		if($row['act_service_hour'] == -1)
		{
			$hour = "依服務時數進行認證".$serv_type;
		}
		
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
		
		if(isset($requirement))
			$req = implode(",", $requirement);
?>
					<h3 class="title">
						<?php echo $row['act_title']; ?>
					</h3>
					<div class="story">
						<?php
							echo "<a href='pass_updateActivitynotNews.php?act_id=$row[act_id]'"." onClick=\"return confirm('確定修改?');\" style=\"color: #D57100;\"> 修改活動</a> \t";
						?>
						<table style="table-layout:fixed" width="600" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
							<tr>
								<td width="120"><span class="highlight">活動名稱</span></td>
								<td width="480"><?=$row['act_title']?></td>
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
								<td><?=$type.$life_sub?></td>
							</tr>
							<tr>
								<td><span class="highlight">核定認證時數</span></td>
								<td><?=$hour?></td>
							</tr>
							<!--<tr>
								<td><span class="highlight">認證貼紙張數</span></td>
								<td>
								<?php
									//if($row['act_sticker_number'])
									//	echo $row['act_sticker_number'];
									//else
									//	echo "無";
								?>
								</td>
							</tr>-->	
							<tr>
								<td><span class="highlight">認證要求</span></td>
								<td>
								<?php
									if($req)
										echo $req;
									else
										echo "無";
								?>
								</td>
							</tr>
							<tr>
								<td width="120"><span class="highlight">活動內容</span></td>
								<td width="480" style= "word-wrap: break-word; word-break: break-all; overflow: hidden; width: 480px;">
								<?php
									if($row['act_description'])
										echo nl2br($row['act_description']);
									else
										echo "無";
								?>
								</td>
							</tr>
							<tr>
								<td><span class="highlight">附加檔案</span></td>
								<td>
								<?php
									if($row['act_file'])
										//echo $row['act_file'];
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
								<td>
								<?php
									if($row['act_req_person'])
										echo $row['act_req_person'];
									else
										echo "無";
								?>
								</td>
							</tr>
							<tr>
								<td><span class="highlight">聯絡電話</span></td>
								<td>
								<?php
									if($row['act_req_phone'])
										echo $row['act_req_phone'];
									else
										echo "無";
								?>
								</td>
							</tr>
							<tr>
								<td><span class="highlight">聯絡信箱</span></td>
								<td>
								<?php
									if($row['act_req_email'])
										echo $row['act_req_email'];
									else
										echo "無";
								?>
								</td>
							</tr>
<tr>
								<td><span class="highlight">申請人</span></td>
								<td>
								<?php
									if($row['act_applier'])
										echo $row['act_applier'];
									else
										echo "無";
								?>
								</td>
							</tr>
</tr>
<tr>
								<td><span class="highlight">公告人員</span></td>
								<td>
								<?php
									if($row['act_approver']){
										$account= $row['act_approver'];
										$sql = "SELECT * FROM `admin` WHERE `ad_account` = '$account'";
										$ret = mysql_query($sql) or die(mysql_error());
										if ($approver = mysql_fetch_assoc($ret))
											{
												echo $approver['ad_account'];
												echo ' ';
												echo $approver['ad_username'];
											}
										}
									else
										echo "無";
								?>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
<?php
		// 核可
		if($row['act_admit'] == 0)
		{
			$admit = "<a href=\"pass_admit_activity.php?id=$id&amp;view=1&amp;value=1\" style=\"color: #0066CC;\" onClick=\"return confirm('確定核可?');\"><img src=\"images/icon/admit.png\" style=\"border: none; width: 150px;\" alt=\"核可\" /></a>";			
			$reject = "<a href=\"pass_admit_activity.php?id=$id&amp;view=1&amp;value=2\" style=\"color: #0066CC;\" onClick=\"return confirm('確定拒絕?');\"><img src=\"images/icon/reject.png\" style=\"border: none; width: 150px;\" alt=\"拒絕\" /></a>";			
		}
		elseif($row['act_admit'] == 1)
			$admit = "<img src=\"images/icon/admitted.png\" style=\"border: none; width: 150px;\" alt=\"已核可\">";
		elseif($row['act_admit'] == 2)
			$admit = "<img src=\"images/icon/rejected.png\" style=\"border: none; width: 150px;\" alt=\"已拒絕\">";
			
		// 公告
		if($row['act_post'] == 0)
			$post = "<a href=\"pass_post_activity.php?id=$id&amp;view=1\" style=\"color: #0066CC;\" onClick=\"return confirm('確定公告?');\"><img src=\"images/icon/publish.png\" style=\"border: none; width: 150px;\" alt=\"公告\"/></a>";			
		elseif($row['act_post'] == 1)
			$post = "<img src=\"images/icon/published.png\" style=\"border: none; width: 150px;\" alt=\"已公告\" >";
		
		//收件
		if($row['act_accept'] == 0)
			$accept = "<!--<a href=\"#\" style=\"color: #0066CC;\" onClick=\"return confirm('輸入送件人');\">--><img src=\"images/icon/accept.png\" style=\"border: none; width: 150px;\" alt=\"收件\"><!--</a>-->";
		elseif($row['act_accept'] == 1)
			$accept = "<img src=\"images/icon/accepted.png\" style=\"border: none; width: 150px;\" alt=\"已收件\">";
?>
				<table width="640" style="margin-top: 20px;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="160"><?=$admit?></td>
						<td width="160"><?=$reject?></td>
						<td width="160"><?=$post?></td>
						<td width="160"><?=$accept?></td>
					</tr>
				</table>
	            <div class="buttons" style="margin: 10px;">
					<a href="pass_activities_manage.php" class="button" id="register-now">回上頁</a>
				</div>
			</div>	
		</div>
		
		<? require_once("footer.php");?>

	</body>
</html>
