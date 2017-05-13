<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
<?php
	require_once("conn/db.php");
	
// 活動id
	$id = $_GET['id'];
	$view = $_GET['view'];
	$approver=$_SESSION['valid_admin_account'];
	if($view)
	{
		$success = "pass_view_activity.php?act_id=".$id."&view=1";
		$fail = "pass_view_activity.php?act_id=".$id."&view=1";
	}
	else
	{
		$success = "pass_activities_manage.php";
		$fail = "pass_activities_manage.php";
	}
	
// 取出活動公告
	$sql = "SELECT * FROM `activity` WHERE `act_id` = '".$id."' AND `act_admit` = '1'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
		
	if(mysql_num_rows($ret))
	{
		$row = mysql_fetch_assoc($ret);
		$no = sprintf("%03d", substr($row['act_semester'],0,-3)).sprintf("%04d", $id);
		$require = $row['act_report'].",".$row['act_engage'].",".$row['act_questionnaire'].",".$row['act_test'].",".$row['act_other'];
		echo $require;
// 資料更新	
		$sql = "INSERT INTO `news_activity` (
					`news_no`, 
					`news_title`, 
					`news_location`, 
					`news_semester`, 
					`news_post_time`, 
					`news_begin_time`, 
					`news_end_time`, 
					`news_office`, 
					`news_act_type`,
					`news_life_sub`, 
					`news_hour`, 
					`news_pass_type`, 
					`news_requirement`, 
					`news_link`, 
					`news_file`, 
					`news_text`, 
					`news_person`, 
					`news_phone`, 
					`news_email`, 
					`news_sticker_number`,
					`news_del`,
					`news_approver`
				) VALUES (
					'$no',
					'$row[act_title]',
					'$row[act_location]',
					'$row[act_semester]',
					NOW(),
					'$row[act_begin_time]',
					'$row[act_end_time]',
					'$row[act_req_office]',
					'$row[act_type]',
					'$row[act_life_sub]',
					'$row[act_service_hour]',
					'$row[act_pass_type]',
					'$require',
					'$row[act_link]',
					'$row[act_file]',
					'$row[act_description]',
					'$row[act_req_person]',
					'$row[act_req_phone]',
					'$row[act_req_email]',
					'$row[act_sticker_number]',
					'0',
					'$approver'					
				)
			";
			
		$ret = mysql_query($sql, $db) or die(mysql_error());
		
		if($ret)
		{
			$sql = "UPDATE `activity` SET act_post = '1', act_post_time = NOW() WHERE act_id = "."'".$id."'";
			$ret = mysql_query($sql, $db) or die(mysql_error());
			
			echo
			"
				<script>
					alert(\"新增公告成功\");
					self.location.href='$success';
				</script>
			";
		}
		else
		{
			echo
			"
				<script>
					alert(\"新增公告失敗\");
					self.location.href='$fail';
				</script>
			";
		}
	}
	else
	{
		echo
		"
			<script>
				alert(\"核可通過後才可進行公告\");
				self.location.href='$fail';
			</script>
		";
	}
?>
	</body>
</html>