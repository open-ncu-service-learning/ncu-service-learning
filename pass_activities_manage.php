<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	require_once("function_lib.php");
	
	$year = date("Y");
	
	// 有效筆數
	//$sql = "SELECT COUNT(act_id) AS num FROM `activity` WHERE act_del = '0' AND act_begin_time >= CURDATE()";
	$sql = "SELECT COUNT(act_id) AS num FROM `activity` WHERE act_del = '0' AND act_year  >= 99 AND `act_admit` != 2";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$numrows = $row['num'];
	
	// 分頁
	require_once("pass_paging.php");
	
	// 取出資料
	$order = $_GET['orderby'];
	if($order == "applydate"){
		//申請日期
		$sql = "SELECT * FROM `activity` WHERE act_del = '0' AND act_year  >= 99 AND `act_admit` != 2 ORDER BY `act_id` DESC LIMIT $offset, $rowsPerPage";
	}
	else{
		//活動日期
		$sql = "SELECT * FROM `activity` WHERE act_del = '0' AND act_year  >= 99 AND `act_admit` != 2 ORDER BY `act_begin_time` DESC LIMIT $offset, $rowsPerPage";

	}
	//$sql = "SELECT * FROM `activity` WHERE act_del = '0' AND act_begin_time >= CURDATE() ORDER BY `act_end_time` ASC LIMIT $offset, $rowsPerPage";
	//$sql = "SELECT * FROM `activity` WHERE act_del = '0' AND act_year  >= 99 AND `act_admit` != 2 ORDER BY `act_begin_time` DESC LIMIT $offset, $rowsPerPage";
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
					<h3>活動管理(校內)</h3>
					<select onchange="location.href='pass_activities_manage.php?orderby='+this.value">
						<optgroup label="排序依">
							<?if($order == "applydate"){
								echo "<option value=\"applydate\">申請日期</option><option value=\"actdate\">活動日期</option>";
							}
							else{
								echo "<option value=\"actdate\">活動日期</option><option value=\"applydate\">申請日期</option>";
							}
							?>
						</optgroup>
					</select>
					<table width="680" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
						<tr align="center">
							<td width="320" height="30"><span style="color: #7F0000;">活動名稱</span></td>
							<td width="100"><span style="color: #7F0000;">活動日期</span></td>
							<td width="100"><span style="color: #7F0000;">申請時間</span></td>
							<td width="120"><span style="color: #7F0000;">申請狀態</span></td>
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
		
		// 核可
		if($row['act_admit'] == 0)
			$admit = "未核可";			
		elseif($row['act_admit'] == 1)
			$admit = "<font color=\"green\"><b>已核可</b></font>";
		elseif($row['act_admit'] == 2)
			$admit = "<font color=\"red\"><b>已拒絕</b></font>";
			
		// 公告
		if($row['act_post'] == 0)
			$post = "未公告";			
		elseif($row['act_post'] == 1)
			$post = "<font color=\"green\"><b>已公告</b></font>";
			
		// 刪除
		//$delete = "<a href=\"pass_del_activity.php?id=$row[act_id]\" onClick=\"return confirm('確定刪除?');\"><img src=\"images/cross.png\" style=\"border: none;\" /></a>";	
			
?>
						<tr>
							<td height="30"><a href="pass_view_activity.php?act_id=<?=$row['act_id']?>&amp;view=1" style="color: #FF0082;"><?=bite_str($row['act_title'], 0, 34)?></a></td>
							<td align="center"><?=substr($row['act_begin_time'], 0, 10)?></td>
							<td align="center"><?=substr($row['act_time'], 0, 10)?></td>
							<td align="center"><?=$admit?> ︱ <?=$post?> </td>
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
