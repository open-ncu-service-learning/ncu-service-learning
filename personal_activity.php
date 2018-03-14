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
/*		$cpr=$row["cpr"];
		$career=$row["career"];
		$basic_inter=$row["basic_inter"];
		$ass_fre = $row['assembly_freshman'];
		$ass_dep = $row['assembly_dep'];
*/		
		// 取出活動資料
		$sql = "SELECT act_id, act_title, act_type, act_end_time, act_service_hour, act_pass_type FROM `activity` WHERE act_del = '0' AND act_admit = '1' AND act_admit_student LIKE '%$stuid%' UNION
				SELECT act_id, act_title, act_type, act_end_time, act_service_hour, act_pass_type FROM `out_activity` WHERE act_del = '0' AND act_admit = '1' AND act_admit_student LIKE '%$stuid%'
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
/*		$totalHour = 0;
		$basicHour = 0;
		$advanHour = 0;
		
		$serviceHour = array(0, 0, 0, 0, 0, 0);
		//變數count 大一週會次數
		$i=0;
		//變數count 院週會次數
		$j=0;
*/		
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
						$index = 0;
						break;
					case 2:
						$type = "生活知能";
						$index = 2;
						break;
					case 3:
						$type = "人文藝術";
						$index = 4;
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
/*				//計算大一週會次數
				$tt = explode("大一週會", $row['act_title']);
				if (count($tt)>1) {
					$i++;
				}
				//計算院週會次數
				$ss = explode("院週會", $row['act_title']);
				if (count($ss)>1) {
					$j++;
				}
		*/
?>
						<tr>
							<td style="padding: 5px;"><?=$row['act_title']?></td>
							<td align="center"><?=$type?></td>
							<td align="center"><?=substr($row['act_end_time'], 0, 10)?></td>
							<td><?=$hour?></td>
						</tr>
<?php
			}
			
	/*		//判斷基本時數:100 服務學習:50 生活知能:30 人文藝術:20 超過的計算到高階
			$q1=50;
			$q2=30;
			$q3=20;
			
			if($stuid>105000000 && $stuid <106000000)
			{
				$q1=40;
				$q2=40;
				$q3=20;
			}
			if($serviceHour[0] > $q1){
				$serviceHour[1] += $serviceHour[0] - $q1;
				$serviceHour[0] = $q1;
			}
			if($serviceHour[2] > $q2){
				$serviceHour[3] += $serviceHour[2] - $q2;
				$serviceHour[2] = $q2;
			}
			if($serviceHour[4] > $q3){
				$serviceHour[5] += $serviceHour[4] - $q3;
				$serviceHour[4] = $q3;
			}
			$basicHour = $serviceHour[0] + $serviceHour[2] +$serviceHour[4];
			$advanHour = $serviceHour[1] + $serviceHour[3] +$serviceHour[5];
			$totalHour = $basicHour + $advanHour;
?>*/?>
			</table><?/*
					<p>
						<span style="color: #FF0022;">總時數: <?=$totalHour?></span>
						<span style="color: #002DFF;">基本: <?=$basicHour?></span>
						<span style="color: #FF7A0F;">高階: <?=$advanHour?></span>
					</p>
<?			
			// 判斷護照類別
			$passportType = judgePassport($serviceHour);
			$string = "";
			switch($passportType) {
				case 0:
					$string = "";
					break;
				case 1:
					$string = "<img src='images/basic.png' style='width: 150px; float: right;' />";
					break;
				case 2:
					$string = "<img src='images/silver.png' style='width: 150px; float: right;' />";
					break;
				case 3:
					$string = "<img src='images/gold.png' style='width: 150px; float: right;' />";
					break;
			}
			if($string!="")
			{?>
				<table width="700" border="0" >
				<tr>
				<td>
					<div id="person" style="color: #3F3F3F; margin-top: 20px;">
						<ul class="list" style="margin-left: 10px; list-style-type: none;">
							<li>學號：<span style="color: #FF00B2;"><?=$no?></span></li>
							<li>姓名：<span style="color: #FF00B2;"><?=$name?></span></li>
							<li>系級：<span style="color: #FF00B2;"><?=$dep?></span></li>
						</ul>
					</div>
				</td>
				<td>
					<div align="right">
						<?=$string?>
					</div>
				</td>
				</tr>
				</table>
			<?}
*/
		}
		else
		{?>
					<p style="color: #009AEF; font-size: 20pt;">您過去沒有任何活動記錄</p>
		<?}/*
?>		
		<table width="700" border="1" cellpadding="0" cellspacing="0">
			<tr align="center">
				<td width="175"><span style="color: #0F50FF; font-size: 18pt;">總時數</span></td>
				<td width="175"><span style="color: #0F50FF; font-size: 18pt;">服務學習</span></td>
				<td width="175"><span style="color: #0F50FF; font-size: 18pt;">生活知能</span></td>
				<td width="175"><span style="color: #0F50FF; font-size: 18pt;">人文藝術</span></td>
			</tr>
			<tr>
				<td align="center" style="color: #FF0022;">畢業門檻</td>
				<td align="center" style="color: #FF0022;"><?=$q1?></td>
				<td align="center" style="color: #FF0022;"><?=$q2?></td>
				<td align="center" style="color: #FF0022;"><?=$q3?></td>
			</tr>
			<tr>
				<td align="center">基本時數</td>
				<td align="center"><?=$serviceHour[0]?></td>
				<td align="center"><?=$serviceHour[2]?></td>
				<td align="center"><?=$serviceHour[4]?></td>
			</tr>
			<tr>
				<td align="center">高階時數</td>
				<td align="center"><?=$serviceHour[1]?></td>
				<td align="center"><?=$serviceHour[3]?></td>
				<td align="center"><?=$serviceHour[5]?></td>
			</tr>
		</table>
		<?php //大一週會次數&院週會次數table?>
		<br />
		<table width="700" border="1" cellpadding="0" cellspacing="0">
			<tr>
				<td><span style="color: #0F50FF; font-size: 18pt;">其他</span></td>
				<td  aligh="center">已參加</td>
				<? if($stuid>104000000 && $stuid <900000000)
				{?>
					<td  aligh="center">門檻</td>
				<?}?>
			</tr>
			<tr>
				<td><span style="color: #0F50FF; font-size: 14pt;">大一週會(次數)</span></td>
				<td aligh="center"><?=$ass_fre//$i?></td>
				<? if($stuid>104000000 && $stuid <900000000)
				{?>
					<td  aligh="center">4</td>
				<?}?>
			</tr>
			<tr>
				<td><span style="color: #0F50FF; font-size: 14pt;">院週會(次數)</span></td>
				<td aligh="center"><?=$ass_dep//$j?></td>
				<? if($stuid>104000000 && $stuid <900000000)
				{?>
					<td  aligh="center">2</td>
				<?}?>
			</tr>
			<?
			if($stuid>105000000 && $stuid <900000000)
				{?>
					<tr>
						<td><span style="color: #0F50FF; font-size: 14pt;">大一CPR(時數)</span></td>
						<td aligh="center"><?=$cpr?></td>
						<td  aligh="center">5</td>
					</tr>
					<tr>
						<td><span style="color: #0F50FF; font-size: 14pt;">自我探索與生涯規劃(時數)</span></td>
						<td aligh="center"><?=$career?></td>
						<td  aligh="center">10</td>
					</tr>
				<?}?>
				<? 
				if($stuid>105000000 && $stuid <106000000)
				{?>								
					<tr>
						<td><span style="color: #0F50FF; font-size: 14pt;">國際視野(時數)</span></td>
						<td aligh="center"><?=$basic_inter?></td>
						<td  aligh="center">5</td>
					</tr>
				<?}?>
		</table>
		
<?php

//大一週會次數&院週會次數table
					<br />
					<table width="700" border="1" cellpadding="0" cellspacing="0">
						<tr>
							<td><span style="color: #0F50FF; font-size: 18pt;">已參與大一週會的次數</span></td>
							<td aligh="center"><?=$i?></td>
						</tr>
						<tr>
							<td><span style="color: #0F50FF; font-size: 18pt;">已參與院週會的次數</span></td>
							<td aligh="center"><?=$j?></td>
						</tr>
					</table>
*/
?>
<?php /*

					<p>
						<span style="color: #FF0022;">總時數: <?=$totalHour?></span>
						<span style="color: #002DFF;">基本: <?=$basicHour?></span>
						<span style="color: #FF7A0F;">高階: <?=$advanHour?></span>
					</p>
					<?=$string?>
					<table width="700" border="1" cellpadding="0" cellspacing="0">
						<tr align="center">
							<td width="175"><span style="color: #0F50FF; font-size: 18pt;">總時數</span></td>
							<td width="175"><span style="color: #0F50FF; font-size: 18pt;">服務學習</span></td>
							<td width="175"><span style="color: #0F50FF; font-size: 18pt;">生活知能</span></td>
							<td width="175"><span style="color: #0F50FF; font-size: 18pt;">人文藝術</span></td>
						</tr>
						<tr>
							<td align="center" style="color: #FF0022;">畢業門檻</td>
							<td align="center" style="color: #FF0022;">50</td>
							<td align="center" style="color: #FF0022;">30</td>
							<td align="center" style="color: #FF0022;">20</td>
						</tr>
						<tr>
							<td align="center">基本時數</td>
							<td align="center"><?=$serviceHour[0]?></td>
							<td align="center"><?=$serviceHour[2]?></td>
							<td align="center"><?=$serviceHour[4]?></td>
						</tr>
						<tr>
							<td align="center">高階時數</td>
							<td align="center"><?=$serviceHour[1]?></td>
							<td align="center"><?=$serviceHour[3]?></td>
							<td align="center"><?=$serviceHour[5]?></td>
						</tr>
					</table>
	*/?>
					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
