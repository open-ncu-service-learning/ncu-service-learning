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
					$lesson = $row['SL_lesson'];
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
					
					if($no<104000000 || $no>950000000){ //103 & before
						rule103($bsc_serv, $bsc_life, $bsc_art,
								$adv_serv, $adv_life, $adv_art, $lesson,
								$totalHour, $qualify);
						$lifesub_str = "無";
					}
					if($no>104000000 && $no<105000000){ //104
						rule104($bsc_serv, $bsc_life, $bsc_art,
								$adv_serv, $adv_life, $adv_art,
								$ass_fre, $ass_dep, $lesson, $totalHour, $qualify);
						$lifesub_str = "大一週會、院週會";
					}
					if($no>105000000 && $no<106000000){ //105
						rule105($bsc_serv, $bsc_life, $bsc_art, $bsc_inter,
								$adv_serv, $adv_life, $adv_art, $adv_inter,
								$ass_fre, $ass_dep, $lesson, $cpr, $career, $totalHour, $qualify);
						$lifesub_str = "大一週會、院週會、大一CPR、自我探索與生涯規劃、國際視野";
					}
					if($no>106000000 && $no<108000000){ //106 & 107
						rule106($bsc_serv, $bsc_life, $bsc_art, $bsc_inter,
								$adv_serv, $adv_life, $adv_art, $adv_inter, 
								$ass_fre, $ass_dep, $lesson, $cpr, $career, $totalHour, $qualify);
						$lifesub_str = "大一週會、院週會、大一CPR、自我探索與生涯規劃";
					}
					
				?>

					<br>
					<span><strong>此為每日更新乙次的資料庫資料，非即時資料</strong></span><br><br>
					<span><strong>※ 生活知能時數注意事項：</strong><br>
					依據服務學習實施細則第九條規定，生活知能除自我學習時數外，另須修滿生活知能必修時數（<?=$lifesub_str?>），始可符合生活知能基本時數門檻規定。</span><br><br>
					<br>
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
