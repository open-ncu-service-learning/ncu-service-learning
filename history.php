<?php
	session_start();
	
	// 身分驗證
	if ($_SESSION['valid_token'] != "2") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	$account = $_SESSION['valid_office_account'];
	$office = $_SESSION['valid_office'];	
	$Id = $_SESSION['valid_id'];
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
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

			<div id="main">
				<div id="welcome" class="post">
					<h3>歷史資料</h3>
<?php
		// 取出申請記錄
		$sql = "SELECT * FROM `activity` WHERE act_req_account = '$account' OR act_req_office = '$office' ORDER BY `act_time` DESC";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		if(mysql_num_rows($ret) > 0)
		{
?>
					<table width="700" border="1" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
						<tr align="center">
							<td width="300" style="padding: 12px;"><span style="color: #0F50FF; font-size: 16pt; font-weight: bold;">活動名稱</span></td>
							<td width="150"><span style="color: #0F50FF; font-size: 16pt; font-weight: bold;">活動地點</span></td>
							<td width="140"><span style="color: #0F50FF; font-size: 16pt; font-weight: bold;">申請時間</span></td>
							<td width="110"><span style="color: #0F50FF; font-size: 16pt; font-weight: bold;">審核狀態</span></td>
						</tr>
<?php
			while($row = mysql_fetch_assoc($ret))
			{
				$string = "";
				switch($row['act_admit'])
				{
					case 0:
						$string = "審核中";
						break;
					case 1:
						$string = "核可";
						break;
					case 2:
						$string = "拒絕";
						break;
					default:
						$string = "";
				}
?>
						<tr>
							<td style="padding: 5px;"><a href="pass_view_activity_unit.php?id=<?=$row['act_id']?>" style="color: #5F0000;"><?=$row['act_title']?></a></td>
							<td align="center"><?=$row['act_location']?></td>
							<td align="center"><?=substr($row['act_time'], 0, 10)?></td>
							<td align="center"><?=$string?></td>
						</tr>
<?php
			}
?>
					</table><br /><br />
<?php
		}
		else
		{
?>
					<p style="color: #009AEF; font-size: 20pt;">您過去無任何申請記錄</p>
<?php
		}
?>
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
