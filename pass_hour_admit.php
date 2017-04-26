<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	require_once("function_lib.php");
	
	// 今年,去年與前年的活動
	$year = date("Y")-4;

	// 有效筆數
	$sql = "SELECT COUNT(`act_id`) as num FROM `activity` WHERE act_service_hour != '-1' AND act_post = '1' AND act_del = '0' AND act_begin_time <= CURDATE() AND SUBSTR(act_begin_time, 1, 4) >= '$year' ORDER BY `act_id` DESC";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$numrows = $row['num'];
	
	// 分頁
	require_once("pass_paging.php");
	
	// 審核過(act_admit=1)的活動才可進行時數認證
	$sql = "SELECT * FROM `activity` WHERE act_service_hour != '-1' AND act_post = '1' AND act_del = '0' AND act_begin_time <= CURDATE() AND SUBSTR(act_begin_time, 1, 4) >= '$year' ORDER BY `act_begin_time` DESC LIMIT $offset, $rowsPerPage";
	$ret = mysql_query($sql, $db) or die(mysql_error());
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

<!-- Archives -->
			<div id="main">
				<div id="welcome" class="post">
					<h3>時數核可(校內)</h3>
					<table width="700" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
						<tr align="center">
							<td width="280" height="30"><span style="color: #7F0000;">活動名稱</span></td>
							<td width="100"><span style="color: #7F0000;">活動日期</span></td>
							<td width="100"><span style="color: #7F0000;">活動型態</span></td>
							<td width="120"><span style="color: #7F0000;">時數核可</span></td>
						</tr>					
<?php
	while($row = mysql_fetch_assoc($ret)) {
		$type = "";
		switch($row['act_type']) {
			case 1:
				$type = "服務學習";
				break;
			case 2:
				$type = "生活知能";
				break;
			case 3:
				$type = "人文藝術";
				break;
			default:
				$type = "無";
		}
		
		$admit = "<a href=\"pass_hour_admit_student.php?id=$row[act_id]\" style=\"color: #0066CC;\" onClick=\"return confirm('進行時數核可?');\">進行核可</a>";			

			
?>
						<tr>
							<td height="30"><?=bite_str($row['act_title'], 0, 34)?></td>
							<td align="center"><?=substr($row['act_begin_time'], 0, 10)?></td>
							<td align="center"><?=$type?></td>
							<td align="center"><?=$admit?></td>
						</tr>
<?php
	}
?>
					</table>
					<br /><br />
					<p><? echo $first . $prev . $nav . $next . $last; ?></p>
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
