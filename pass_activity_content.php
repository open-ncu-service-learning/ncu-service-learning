<?php
	session_start();
	require_once("conn/db.php");
	
	if(!is_numeric($_GET['news_id'])) {
		header('Location: index.php');
		exit;
	}
	
	$id = (int)$_GET['news_id'];
	
	$dir = "download/pass_activities/";
	
	$sql = "SELECT * FROM news_activity WHERE news_del = '0' AND news_id = '$id' ORDER BY news_post_time ASC";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
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
		<style type="text/css">
			.AutoNewline
			{
				word-break: break-all;/*必須*/
			}
		</style>
	</head>

	<body>
	<!-- logo -->
		<? require_once("logo.php");?>
	<!-- MenuBar -->
		<? require_once("menu.php");?>
	<!-- Content -->
		<div id="content">
		<!-- sidebar --> 
			<? require_once("sidebar.php");?>
		<!-- news -->
			<div id="main">
				<div id="welcome" class="post">
<?php 
	do { 
		// 活動型態
		$type = "";
		$life_sub = "";
		switch($row['news_act_type']) {
			case 1:
				$type = "服務學習";
				break;
			case 2:
				$type = "生活知能";
				if ($row['news_life_sub'] == 1){
					$life_sub = " - 大一週會";
				}
				else if ($row['news_life_sub'] == 2){
					$life_sub = " - 大一CPR";
				}
				else if ($row['news_life_sub'] == 3){
					$life_sub = " - 自我探索與生涯規劃";
				}
				else if ($row['news_life_sub'] == 4){
					$life_sub = " - 國際視野";
				}

				else if ($row['news_life_sub'] == 6){
					$life_sub = " - 院週會";
				}
				else if ($row['news_life_sub'] == 5){
					$life_sub = " - 一般";
				}
				break;
			case 3:
				$type = "人文藝術";
				break;
			default:
				$type = "無";
		}
		
		$hour = "";
		switch($row['news_pass_type']) {
			case 1:
				$hour = "基本: ".$row['news_hour'];
				break;
			case 2:
				$hour = "高階: ".$row['news_hour'];
				break;
			case 3:
				$arr = explode(',', $row['news_hour']);
				$hour = "基本: $arr[0] <br />高階: $arr[1]";
				break;
			default:
				$hour = 0;
		}
		if($row['news_hour'] == -1)
		{
			$hour = "依服務時數進行認證";
		}
		
		$requirement = "";
		$req = explode(',', $row['news_requirement']);
		if($req[0])
			$requirement .= "心得報告 ";
		if($req[1])
			$requirement .= "全程參與 ";
		if($req[2])
			$requirement .= "問卷回饋 ";
		if($req[3])
			$requirement .= "考試 ";
		if($req[4])
			$requirement .= $req[4];
?>
					<h3 class="title">
						<?php echo $row['news_title']; ?>
					</h3>
					<h2 class="date">
						<span class="month">
						<?php
							switch(substr($row['news_post_time'], 5, 2))
							{	
								case '01':
									echo '一月';
									break;
								case '02':
									echo '二月';
									break;
								case '03':
									echo '三月';
									break;
								case '04':
									echo '四月';
									break;
								case '05':
									echo '五月';
									break;
								case '06':
									echo '六月';
									break;
								case '07':
									echo '七月';
									break;
								case '08':
									echo '八月';
									break;
								case '09':
									echo '九月';
									break;	
								case '10':
									echo '十月';
									break;	
								case '11':
									echo '十一月';
									break;	
								case '12':
									echo '十二月';
									break;	
							}					
							?>
						</span> 
						<span class="day">
							<? echo substr($row['news_post_time'], 8, 2); ?>
						</span>
					</h2>
					<div class="meta" style="color: #333333; font-size: 12pt;">
						<span style="color: #3F1000;">公告單位：服務學習網</span>
						<?php
						$approver=$row['news_approver'];
						if($_SESSION['valid_token'] == "3")
						{
							echo "<a href='pass_updateActivity.php?news_id=$row[news_id]'"." onClick=\"return confirm('確定修改?');\" style=\"color: #D57100;\"> 修改活動</a> \t";
							echo "<a href='pass_delActivity.php?news_id=$row[news_id]'"." onClick=\"return confirm('確定刪除?');\" style=\"color: #D57100;\">刪除活動</a> \r\n";

							echo"公告核可：$approver";
						}
						?>
						<br />
						<span style="color: #3F1000;">公告日期：<?=$row['news_post_time']?></span><br />
						
						<?php
							
							// 檔案
							if($row['news_file'])
								echo "<a href=\"".$dir.$row['news_file']."\" style=\"color: #009900;\">相關檔案 </a>";
							// 連結
							if($row['news_link'])
								echo "<a href=\"".$row['news_link']."\" style=\"color: #CC0066;\">相關連結</a>";
						?>
					</div>
					<div class="story">
						<table width="600" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
							<tr>
								<td width="120">活動編號</td>
								<td width="480"><?=$row['news_no']?></td>
							</tr>
							<tr>
								<td>活動名稱</td>
								<td><?=$row['news_title']?></td>
							</tr>
							<tr>
								<td>活動地點</td>
								<td><?=$row['news_location']?></td>
							</tr>
							<tr>
								<td>活動時段</td>
								<td><?=$row['news_semester']?></td>
							</tr>
							<tr>
								<td>活動開始時間</td>
								<td><?=$row['news_begin_time']?></td>
							</tr>
							<tr>
								<td>活動結束時間</td>
								<td><?=$row['news_end_time']?></td>
							</tr>
							<tr>
								<td>發佈單位</td>
								<td><?=$row['news_office']?></td>
							</tr>
							<tr>
								<td>活動類別</td>
								<td><?=$type.$life_sub?></td>
							</tr>
							<tr>
								<td>核定認證時數</td>
								<td><?=$hour?></td>
							</tr>	
							<tr>
								<td>認證要求</td>
								<td><?=$requirement?></td>
							</tr>
							<tr>
								<td>活動內容</td>
								<td  class="AutoNewline" style="width:478.4px;"><div><?php echo nl2br($row['news_text']); ?></div></td>
							</tr>
							<tr>
								<td>聯絡人</td>
								<td><?=$row['news_person']?></td>
							</tr>
							<tr>
								<td>聯絡信箱</td>
								<td><?=$row['news_email']?></td>
							</tr>
							<?php
								if($_SESSION['valid_token'] == "3"){

							?>
							
							<tr>
								<td>聯絡電話</td>
								<td><?=$row['news_phone']?></td>
							</tr>
							
							<?php
								}

							?>
						
						</table>
					</div>
<?php } while ($row = mysql_fetch_assoc($ret)); ?>
				</div>
	            <div class="buttons" style="margin: 10px;">
					<a href="javascript:history.back()" class="button" id="register-now">回上頁</a>
				</div>
			</div>	
		</div>
		
		<? require_once("footer.php");?>

	</body>
</html>
