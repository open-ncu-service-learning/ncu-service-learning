<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	require_once("function_lib.php");
	
	if(isset($_POST['pass_stuid']))
		$stuid = trim($_POST['pass_stuid'], " ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>國立中央大學服務學習網</title>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
		<link href="css/userlayout.css" rel="stylesheet" type="text/css" />
		<link href="css/menuTheme.css" rel="stylesheet" type="text/css" />
		<script src="js/JSCookMenu.js" type="text/javascript" ></script>
		<script src="js/effect.js" type="text/javascript" ></script>
		<script src="js/theme.js" type="text/javascript" ></script>
		<script src="js/jquery-1.2.3.min.js" type="text/javascript"></script>
		<script src="js/jquery.dimensions.min.js" type="text/javascript"></script>		
		<script src="js/jquery.inputHintBox.js" type="text/javascript"></script>
		<script src="js/checkForm.js" type="text/javascript"></script>
		<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
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
				<div id="welcome" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
					<h3 style="margin-top: 10px;">時數查詢</h3>
					<form id="form1" name="form1" action="pass_hour_query.php" method="post" onsubmit="return check_pass_adminForm(form1)">
						<table width="700" style="margin-top: 20px;">
							<tr>
								<td width="100"><label for="pass_stuid">請輸入學號</label></td>
								<td width="500"><input type="text" name="pass_stuid" id="pass_stuid" size="20" style="font-size: 14pt; height: 25px;" /></td>
							</tr>
						</table>

<!-- Shiny_box -->
						<div id="shiny_box" class="shiny_box" style="display:none;">
							<span class="tl"></span><span class="tr"></span>
							<div class="shiny_box_body"></div>
							<span class="bl"></span><span class="br"></span>
						</div>
						<script type="text/javascript">
							$().ready(function(){
								$('.titleHintBox').inputHintBox({div:$('#shiny_box'),div_sub:'.shiny_box_body',source:'attr',attr:'title',incrementLeft:5});
							});
						</script>

<!-- Submit -->					
						<table width="100%">
							<tr style="height: 20px;">
								<td></td>
							</tr>
							<tr>
								<td>
									<div class="buttons">
										<button type="submit" class="positive">
											<img src="images/tick.png" alt=""/> 
											確定送出
										</button>
										<button type="reset" class="negative">
											<img src="images/cross.png" alt=""/>
											取消重設
										</button>
									</div>
								</td>
							</tr>
						</table>
					</form>
					<br />
<?php
	if(isset($stuid) && $stuid != '')
	{
		// 取出個人資料
		$sql = "SELECT * FROM `all_user` WHERE user_student = '$stuid'";
		$ret = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($ret);
		
		// 學生資訊
		$no = $row['user_student'];
		$name = $row['user_name'];
		$dep = $row['user_dep'];
		
		// 取出活動資料
		$sql = "SELECT act_id, act_title, act_type, act_begin_time, act_service_hour, act_pass_type FROM `activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%' UNION
				SELECT act_id, act_title, act_type, act_begin_time, act_service_hour, act_pass_type FROM `out_activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%'
				ORDER BY `act_type`,`act_begin_time` DESC
			";
		$ret = mysql_query($sql) or die(mysql_error());
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
		$totalHour = 0;
		$basicHour = 0;
		$advanHour = 0;
		
		$serviceHour = array(0, 0, 0, 0, 0, 0);
		/*變數count 大一週會次數*/
		$i=0;
		/*變數count 院週會次數*/
		$j=0;
		
		if($actNumber > 0)
		{
?>
					<table width="700" border="1" cellpadding="0" cellspacing="0">
						<tr align="center">
							<td width="360" style="padding: 12px;"><span style="color: #0F50FF; font-size: 18pt;">活動名稱</span></td>
							<td width="100"><span style="color: #0F50FF; font-size: 18pt;">類別</span></td>
							<td width="140"><span style="color: #0F50FF; font-size: 18pt;">活動時間</span></td>
							<td width="100"><span style="color: #0F50FF; font-size: 18pt;">時數</span></td>
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
				/*計算大一週會次數*/
				$tt = explode("大一週會", $row['act_title']);
				if (count($tt)>1) {
					$i++;
				}
				/*計算院週會次數*/
				$ss = explode("院週會", $row['act_title']);
				if (count($ss)>1) {
					$j++;
				}
				
?>
						<tr>
							<td><?=$row['act_title']?></td>
							<td align="center"><?=$type?></td>
							<td align="center"><?=substr($row['act_begin_time'], 0, 10)?></td>
							<td><?=$hour?></td>
						</tr>		
<?php
			}
			
			//判斷基本時數:100 服務學習:50 生活知能:30 人文藝術:20 超過的計算到高階
			if($serviceHour[0] > 50){
				$serviceHour[1] += $serviceHour[0] - 50;
				$serviceHour[0] = 50;
			}
			if($serviceHour[2] > 30){
				$serviceHour[3] += $serviceHour[2] - 30;
				$serviceHour[2] = 30;
			}
			if($serviceHour[4] > 20){
				$serviceHour[5] += $serviceHour[4] - 20;
				$serviceHour[4] = 20;
			}
			$basicHour = $serviceHour[0] + $serviceHour[2] +$serviceHour[4];
			$advanHour = $serviceHour[1] + $serviceHour[3] +$serviceHour[5];
			$totalHour = $basicHour + $advanHour;
						
			// 判斷護照類別
			$passportType = judgePassport($serviceHour);
			
			/*
			echo $serviceHour[0];
			echo "<br>";
			echo $serviceHour[2];
			echo "<br>";
			echo $serviceHour[4];
			*/
			
			$string = "";
			switch($passportType) {
				case 0:
					$string = "";
					break;
				case 1:
					$string = "<img src='images/basic.png' style='width: 150px; float: left;' />";
					break;
				case 2:
					$string = "<img src='images/silver.png' style='width: 150px; float: left;' />";
					break;
				case 3:
					$string = "<img src='images/gold.png' style='width: 150px; float: left;' />";
					break;
			}
?>
					</table>
<?php
		}
		else
		{
?>
					<p style="color: #009AEF; font-size: 20pt;">您過去沒有任何活動記錄</p>
<?php
		}
?>
<?php /*大一週會次數&院週會次數table*/?>
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
<?php /**/?>
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

<?php
/*****
<?php
		mysql_select_db("ncu_passpost", $db);
		require_once("func.php");
?>
		<h3 style="margon-top: 20px;">活動記錄</h3>
		<br />
		<div id="total" style="color: #FF0022;">
			總時數: <?=getStudentHour($stuid);?>
		</div>
		<table width="700" border="1" cellpadding="0" cellspacing="0">
			<tr>
				<td width="360">活動名稱</td>
				<td width="100">活動類別</td>
				<td width="140">活動時間</td>
				<td width="100">時數</td>
			</tr>
			<?php
				$row = getStudentHistory($stuid);
				
				while($curr_row = current($row)) {
					echo "<tr>";
					
					while(($curr_field = current($curr_row)) !== false) {
						echo "<td>".$curr_field."</td>";
						next($curr_row);
					}
					next($row);
					echo "</tr>";
				}
			?>			
		</table>
*******/		
?>
<?php
	}


?>

					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
