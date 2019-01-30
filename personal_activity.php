<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] == "1"){
		$stuid = $_SESSION['valid_student_id'];
	}
	elseif($_SESSION['valid_token'] == "3") {
		$stuid = $_GET['stuid'];
	}
	else{
		header('Location: index.php');
		exit;
	}
	require_once("conn/db.php");
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
			
			<div id="main">
				<div id="welcome" class="post">
<?php
		// 取出個人資料
		$sql = "SELECT * FROM `all_user` WHERE user_student = '$stuid'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		$row = mysql_fetch_assoc($ret);
		
		// 學生資訊
		$no = $row['user_student'];
		$name = $row['user_name'];
		$dep = $row['user_dep'];
	
		// 取出活動資料
		$sql = "SELECT act_id, act_title, act_type,act_life_sub, act_end_time, act_service_hour, act_pass_type FROM `activity` WHERE act_del = '0' AND act_admit = '1' AND act_admit_student LIKE '%$stuid%' UNION
				SELECT act_id, act_title, act_type,act_life_sub, act_end_time, act_service_hour, act_pass_type FROM `out_activity` WHERE act_del = '0' AND act_admit = '1' AND act_admit_student LIKE '%$stuid%'
				ORDER BY `act_type`,`act_end_time` DESC
			";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		$actNumber = mysql_num_rows($ret);
?>
					<h3>活動記錄</h3>
					<div id="person" style="color: #3F3F3F; margin-top: 20px;">
						<ul class="list" style="margin-left: 10px; list-style-type: none;">
							<li>學號：<span style="color: #FF00B2;"><?=$no?></span></li>
							<li>姓名：<span style="color: #FF00B2;"><?=$name?></span></li>
							<li>系級：<span style="color: #FF00B2;"><?=$dep?></span></li>
						</ul>
					</div>
<?php
	
		if($actNumber > 0)
		{
?>
					<table width="700" border="1" cellpadding="0" cellspacing="0">
						<tr align="center">
							<td width="360" style="padding: 12px;"><span style="color: #0F50FF; font-size: 16pt; font-weight: bold;">活動名稱</span></td>
							<td width="100"><span style="color: #0F50FF; font-size: 16pt; font-weight: bold;">類別</span></td>
							<td width="140"><span style="color: #0F50FF; font-size: 16pt; font-weight: bold;">活動時間</span></td>
							<td width="100"><span style="color: #0F50FF; font-size: 16pt; font-weight: bold;">時數</span></td>
						</tr>
<?php
			while($row = mysql_fetch_assoc($ret))
			{
				// 活動型態
				$type = "";
				switch($row['act_type']) {
					case 1:
						$type = "服務學習";
						//$index = 0;
						break;
					case 2:
						
						if($stuid>106000000 && $stuid<951001029 && $row['act_life_sub'] == 4){
							$type = "國際視野";
							echo "123";
						}
						else{
							$type = "生活知能";
						}
						//$index = 2;
						break;
					case 3:
						$type = "人文藝術";
						//$index = 4;
						break;
					case 4:
						$type = "國際視野";
						break;
					default:
						$type = "無";
				}
				
				// 時數與護照型態
				$hour = 0;
				if($row['act_service_hour'] == "-1") {
					$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid' 
															   AND `ser_act_id` = '$row[act_id]'
															   AND `ser_del` = '0'";
					$ret1 = mysql_query($sql) or die(mysql_error());
					$row1 = mysql_fetch_assoc($ret1);
					$row['act_service_hour'] = $row1['ser_hour'];
				}
				elseif($row['act_service_hour'] == "0,-1") {
					$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid' 
															   AND `ser_act_id` = '$row[act_id]'
															   AND `ser_del` = '0'";
					$ret1 = mysql_query($sql) or die(mysql_error());
					$row1 = mysql_fetch_assoc($ret1);
					$row['act_service_hour'] = $row1['ser_hour'];
				}			
				
				switch($row['act_pass_type']) {
					case 1:
						$hour = "基本: ".$row['act_service_hour'];
						$totalHour += $row['act_service_hour'];
						$basicHour += $row['act_service_hour'];
						$serviceHour[$index] += $row['act_service_hour'];
						break;
					case 2:
						$hour = "高階: ".$row['act_service_hour'];
						$totalHour += $row['act_service_hour'];
						$advanHour += $row['act_service_hour'];
						$serviceHour[$index+1] += $row['act_service_hour'];
						break;
					case 3:
						$arr = explode(',', $row['act_service_hour']);
						$hour = "基本: $arr[0] <br />高階: $arr[1]";
						$totalHour += $arr[0];
						$totalHour += $arr[1];
						$basicHour += $arr[0];
						$advanHour += $arr[1];
						$serviceHour[$index] += $arr[0];
						$serviceHour[$index+1] += $arr[1];
						break;
					default:
						$hour = 0;
				}

?>
						<tr>
							<td style="padding: 5px;"><?=$row['act_title']?></td>
							<td align="center"><?=$type?></td>
							<td align="center"><?=substr($row['act_end_time'], 0, 10)?></td>
							<td><?=$hour?></td>
						</tr>
<?php
			}
			
	?>
			</table><?
		}
		else
		{?>
					<p style="color: #009AEF; font-size: 20pt;">您過去沒有任何活動記錄</p>
		<?}?>

					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
