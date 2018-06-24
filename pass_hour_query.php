<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	require_once("ruleFunction.php");
	
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
		$ass_fre = $row['assembly_freshman'];
		$ass_dep = $row['assembly_dep'];
		$cpr = $row['cpr'];
		$career = $row['career'];
		$qualify = $row['qualified'];
		
		$totalHour=$row['user_totalHour'];
					
		$bsc_serv=$row['basic_service'];		$adv_serv=$row['advan_service'];
		$bsc_life=$row['basic_life'];			$adv_life=$row['advan_life'];
		$bsc_art=$row['basic_art'];				$adv_art=$row['advan_art'];
		$bsc_inter=$row['basic_inter'];			$adv_inter=$row['advan_inter'];
		
		
		
		// 取出活動資料
		$sql = "SELECT act_id, act_title, act_type, act_life_sub, act_begin_time, act_service_hour, act_pass_type FROM `activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%' UNION
				SELECT act_id, act_title, act_type, act_life_sub, act_begin_time, act_service_hour, act_pass_type FROM `out_activity` WHERE act_del = '0' AND act_admit = '1' AND act_admit_student LIKE '%$stuid%'
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
						//$index = 0;
						break;
					case 2:
						$type = "生活知能";
						if($stuid>106000000 && $stuid<951001029 && $row['act_life_sub'] == 4){
							$type = "國際視野";
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
				<tr>
					<td><?=$row['act_title']?></td>
					<td align="center"><?=$type?></td>
					<td align="center"><?=substr($row['act_begin_time'], 0, 10)?></td>
					<td><?=$hour?></td>
				</tr>		
<?php
			}
?>
			</table>
<?php
		}
		else{
?>
			<p style="color: #009AEF; font-size: 20pt;">您過去沒有任何活動記錄</p>
<?php
		}
		
		
		if($no<104000000 || $no>950000000){
			rule103($bsc_serv, $bsc_life, $bsc_art,
					$adv_serv, $adv_life, $adv_art, 
					$totalHour, $qualify);
		}
		if($no>104000000 && $no<105000000){
			rule104($bsc_serv, $bsc_life, $bsc_art,
					$adv_serv, $adv_life, $adv_art,
					$ass_fre, $ass_dep, $totalHour, $qualify);
		}
		if($no>105000000 && $no<106000000){
			rule105($bsc_serv, $bsc_life, $bsc_art, $bsc_inter,
					$adv_serv, $adv_life, $adv_art, $adv_inter,
					$ass_fre, $ass_dep, $cpr, $career, $totalHour, $qualify);
		}
		if($no>106000000 && $no<107000000){
			rule106($bsc_serv, $bsc_life, $bsc_art, $bsc_inter,
					$adv_serv, $adv_life, $adv_art, $adv_inter, 
					$ass_fre, $ass_dep, $cpr, $career, $totalHour, $qualify);
		}
	
	}
?>

					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>
	</body>
</html>
