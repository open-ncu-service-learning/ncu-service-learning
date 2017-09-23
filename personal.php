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
	require_once("ruleFunction.php");
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
				<div id="welcome" class="post" style="font-size: 18px; color: #1F1F1F;">
				<?php
					// 取出個人資料					
					$sql = "SELECT * FROM `all_user` WHERE user_student = '$stuid'";
					$ret = mysql_query($sql, $db) or die(mysql_error());
					$row = mysql_fetch_assoc($ret);
					
					
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
					
				?>
					<h3>時數查詢</h3>
					<div id="person" style="color: #3F3F3F; margin-top: 20px;">
						<ul class="list" style="margin-left: 10px; list-style-type: none;">
							<li>學號：<span style="color: #FF00B2;"><?=$no?></span></li>
							<li>姓名：<span style="color: #FF00B2;"><?=$name?></span></li>
							<li>系級：<span style="color: #FF00B2;"><?=$dep?></span></li>
						</ul>
					</div>
			
				<?php 
					
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
					
				?>

					<br>
					<span>此為每日更新乙次的資料庫資料，非即時資料</span>
					<br>
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
