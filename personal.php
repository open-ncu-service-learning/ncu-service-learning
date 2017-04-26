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
					
					$q1=50;
					$q2=30;
					$q3=20;
					
					if($row['user_student']>105000000 && $row['user_student'] <106000000)
					{
						$q1=40;
						$q2=40;
						$q3=20;
					}
					
					$totalHour=$row['user_totalHour'];
					
					//轉時數
					$b1=$row['basic_service'];			$a1=$row['advan_service'];
					$b2=$row['basic_life'];				$a2=$row['advan_life'];
					$b3=$row['basic_art'];				$a3=$row['advan_art'];
					
					if($b1 > $q1){
						$a1 += $b1 - $q1;
						$b1 = $q1;
					}
					if($b2 > $q2){
						$a2 += $b2 - $q2;
						$b2 = $q2;
					}
					if($b3 > $q3){
						$a3 += $b3 - $q3;
						$b3 = $q3;
					}		
				
					$basicHour = $b1 + $b2 +$b3;
					
					$advanHour=$a1 + $a2 +$a3;
					$serviceHour =array($b1,$a1,$b2,$a2,$b3,$a3);
					// 判斷護照類別
					$passportType = judgePassport($serviceHour);
					$string = "";
					switch($passportType) {
						case 0:
							$string = "尚未通過畢審門檻!";
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
					?>
					<h3>時數查詢</h3>
					<table width="700" border="0" >
					<tr>
					<td>
						<div id="person" style="color: #3F3F3F; margin-top: 20px;">
							<ul class="list" style="margin-left: 10px; list-style-type: none;">
								<li>學號：<span style="color: #FF00B2;"><?=$row['user_student']?></span></li>
								<li>姓名：<span style="color: #FF00B2;"><?=$row['user_name']?></span></li>
								<li>系級：<span style="color: #FF00B2;"><?=$row['user_dep']?></span></li>
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
					<p>
						<span style="color: #FF0022;">總時數: <?=$totalHour?></span>
						<span style="color: #002DFF;">基本: <?=$basicHour?></span>
						<span style="color: #FF7A0F;">高階: <?=$advanHour?></span>
					</p>
					
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
							<td align="center"><?=$b1?></td>
							<td align="center"><?=$b2?></td>
							<td align="center"><?=$b3?></td>
						</tr>
						<tr>
							<td align="center">高階時數</td>
							<td align="center"><?=$a1?></td>
							<td align="center"><?=$a2?></td>
							<td align="center"><?=$a3?></td>
						</tr>
					</table>
					<br /><br />
					<?php /*大一週會次數&院週會次數table*/?>
					<br />
					<table width="700" border="1" cellpadding="0" cellspacing="0">
						<tr>
							<td><span style="color: #0F50FF; font-size: 18pt;">其他</span></td>
							<td  aligh="center">已參加</td>
							<? if($row['user_student']>104000000 && $row['user_student'] <900000000)
							{?>
								<td  aligh="center">門檻</td>
							<?}?>
						</tr>
						<tr>
							<td><span style="color: #0F50FF; font-size: 14pt;">大一週會(次數)</span></td>
							<td aligh="center"><?=$row["assembly_freshman"]?></td>
							<? if($row['user_student']>104000000 && $row['user_student'] <900000000)
							{?>
								<td  aligh="center">4</td>
							<?}?>
						</tr>
						<tr>
							<td><span style="color: #0F50FF; font-size: 14pt;">院週會(次數)</span></td>
							<td aligh="center"><?=$row["assembly_dep"]?></td>
							<? if($row['user_student']>104000000 && $row['user_student'] <900000000)
							{?>
								<td  aligh="center">2</td>
							<?}?>
						</tr>
						<?
						if($row['user_student']>105000000 && $row['user_student'] <900000000)
							{?>
								<tr>
									<td><span style="color: #0F50FF; font-size: 14pt;">大一CPR(時數)</span></td>
									<td aligh="center"><?=$row["cpr"]?></td>
									<td  aligh="center">5</td>
								</tr>
								<tr>
									<td><span style="color: #0F50FF; font-size: 14pt;">自我探索與生涯規劃(時數)</span></td>
									<td aligh="center"><?=$row["career"]?></td>
									<td  aligh="center">10</td>
								</tr>
							<?}?>
							<? 
							if($row['user_student']>105000000 && $row['user_student'] <106000000)
							{?>								
								<tr>
									<td><span style="color: #0F50FF; font-size: 14pt;">國際視野(時數)</span></td>
									<td aligh="center"><?=$row["basic_inter"]?></td>
									<td  aligh="center">5</td>
								</tr>
							<?}?>
					</table>
					<br>
					<span>此為每日更新乙次的資料庫資料，非即時資料</span>
					<br>
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
