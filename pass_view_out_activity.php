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
	
	$dir = "download/pass_out_activities/";
	$sql = "SELECT * FROM `out_activity` WHERE `act_del` = '0' AND `act_id` = '$id'";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$stuid = $row['act_admit_student'];
	$sql = "SELECT * FROM `all_user` WHERE `user_del` = '0' AND `user_student` = '$stuid'";
	$ret = mysql_query($sql) or die(mysql_error());
	$usrrow = mysql_fetch_assoc($ret);
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
		$sub = "";
		switch($row['act_type']) {
			case 1:
				$type = "服務學習";
				if($row['act_sub']!="0")
					$sub = "-".$row['act_sub'];
				break;
			case 2:
				$type = "生活知能";
				if($row['act_sub']!="0")
					$sub = "-".$row['act_sub'];
				break;
			case 3:
				$type = "人文藝術";
				if($row['act_sub']!="0")
					$sub = "-".$row['act_sub'];
				break;
			case 4:
				$type = "國際視野";
				if($row['act_sub']!="0")
					$sub = "-".$row['act_sub'];
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

						<?php
							echo "<a href='pass_updateOutActivity.php?id=$row[act_id]'"." onClick=\"return confirm('確定修改?');\" style=\"color: #D57100;\"> 修改活動</a> \t";
						?>

						<table style="table-layout:fixed" width="600" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
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
								<td><?=$type.$sub?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">核定認證時數</span></td>
								<td><?=$hour?></td>
							</tr>
							<!--<tr height="30">
								<td width="120" align="left"><span class="highlight">活動內容</span></td>
								<td width="480" style= "word-wrap: break-word; word-break: break-all; overflow: hidden; width: 480px;"><?php// echo nl2br($row['act_description']); ?></td>
							</tr>-->
							<tr height="30">
								<td width="120" align="left"><span class="highlight">學習反思</span></td>
								<td width="480" style= "word-wrap: break-word; word-break: break-all; overflow: hidden; width: 480px;"><?php echo nl2br($row['act_reflection']); ?></td>
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
							<tr height="30">
								<td align="left"><span class="highlight">申請人學號</span></td>
								<td><?=$stuid;?></td>
							</tr>
							<tr height="30">
								<td align="left"><span class="highlight">申請人姓名</span></td>
								<td><?=$usrrow['user_name'];?></td>
							</tr>
							<!--<tr height="30">
								<td align="left"><span class="highlight">聯絡電話</span></td>
								<td><?//$phone=($row['act_req_phone'] == NULL)?"無":$row['act_req_phone']; echo $phone;?></td>
							</tr>-->
							<tr height="30">
								<td align="left"><span class="highlight">申請人信箱</span></td>
								<td><?=$usrrow['user_email'];?></td>
							</tr>
						</table>
					</div>
				</div>
				
				<table width="600" style="margin-top: 20px;" border="0" cellspacing="0" cellpadding="0">
					<tr align="center">
						<?php
							echo "<td><a href='pass_del_out_activity.php?id=$id'"." onClick=\"return confirm('確定拒絕?');\"><img src=\"images/icon/reject.png\" style=\"border: none; width: 150px;\" alt=\"拒絕\"/></a></td>";
							if($row['act_admit'] == 0)
								echo "<td><a href='pass_admit_out_activity.php?id=$row[act_id]'"." onClick=\"return confirm('確定核可?');\"><img src=\"images/icon/admit.png\" style=\"border: none; width: 150px;\" alt=\"核可\"/></a></td>";
							else
								echo "<td>已核可</td>";
						?>
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
