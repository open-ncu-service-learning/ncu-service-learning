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
	$actid = $_GET['id'];
	$sql = "SELECT * FROM `out_activity` WHERE `act_id` = '$actid'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$stuid = $row['act_admit_student'];
	
	$sql = "UPDATE `out_activity` SET `act_admit` = '1' WHERE `act_id` = '$actid'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	if(!$ret){
		$errorstr = "時數核可失敗";
	}
	else{
		$errorstr = "時數核可成功";
	}
	
	// 取出認證時數
	switch($row['act_pass_type'])
	{
		case 1:	//基本
			$service_hour = $row['act_service_hour'];	
			if ($row['act_type'] == 1){//服務學習
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_service` = `basic_service`+".$service_hour."
							WHERE
								`user_student` = '$stuid'";
			}
			else if ($row['act_type'] == 2){//生活知能
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_life` = `basic_life`+".$service_hour."
							WHERE
								`user_student` = '$stuid'";
				
			}
			else if ($row['act_type'] == 3){//人文藝術
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_art` = `basic_art`+".$service_hour."
							WHERE
								`user_student` = '$stuid'";
			}
			else if ($row['act_type'] == 4){//國際視野
				if ($stuid >= 106000000 && $stuid <= 300000000){
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_basicHour` = `user_basicHour`+".$service_hour.",
							`basic_inter` = `basic_inter`+".$service_hour."
						WHERE
							`user_student` = '$stuid'";
				}else{		
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_basicHour` = `user_basicHour`+".$service_hour.",
							`basic_life` = `basic_life`+".$service_hour.",
							`basic_inter` = `basic_inter`+".$service_hour."
						WHERE
							`user_student` = '$stuid'";
				}
			}
			break;
			
		case 2: //進階
			$service_hour = $row['act_service_hour'];			
			if ($row['act_type'] == 1){//服務學習
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_service` = `advan_service`+".$service_hour."
							WHERE
								`user_student` = '$stuid'";
			}
			else if ($row['act_type'] == 2){//生活知能
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_life` = `advan_life`+".$service_hour."
							WHERE
								`user_student` = '$stuid'";
				
			}
			else if ($row['act_type'] == 3){//人文藝術
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_art` = `advan_art`+".$service_hour."
							WHERE
								`user_student` = '$stuid'";
			}
			else if ($row['act_type'] == 4){//國際視野
				
				if ($stuid >= 106000000 && $stuid <= 300000000){
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_advanHour` = `user_advanHour`+".$service_hour.",
							`advan_inter` = `advan_inter`+".$service_hour."
						WHERE
							`user_student` = '$stuid'";
				}else{
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_advanHour` = `user_advanHour`+".$service_hour.",
							`advan_life` = `advan_life`+".$service_hour.",
							`advan_inter` = `advan_inter`+".$service_hour."
						WHERE
							`user_student` = '$stuid'";
				}
			}
			break;
			
		case 3:
			$service_hour = explode(",", $row['act_service_hour']);
			$sum = $service_hour[0]+$service_hour[1];
			if ($row['act_type'] == 1){//服務學習
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$sum.", 
								`user_basicHour` = `user_basicHour`+".$service_hour[0].",
								`user_advanHour` = `user_advanHour`+".$service_hour[1].",
								`basic_service` = `basic_service`+".$service_hour[0].",
								`advan_service` = `advan_service`+".$service_hour[1]."
							WHERE
								`user_student` = '$stuid'";
			}
			else if ($row['act_type'] == 2){//生活知能
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$sum.", 
								`user_basicHour` = `user_basicHour`+".$service_hour[0].",
								`user_advanHour` = `user_advanHour`+".$service_hour[1].",
								`basic_life` = `basic_life`+".$service_hour[0].",
								`advan_life` = `advan_life`+".$service_hour[1]."
							WHERE
								`user_student` = '$stuid'";
				
			}
			else if ($row['act_type'] == 3){//人文藝術
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$sum.", 
								`user_basicHour` = `user_basicHour`+".$service_hour[0].",
								`user_advanHour` = `user_advanHour`+".$service_hour[1].",
								`basic_art` = `basic_art`+".$service_hour[0].",
								`advan_art` = `advan_art`+".$service_hour[1]."
							WHERE
								`user_student` = '$stuid'";
			}
			else if ($row['act_type'] == 4){//國際視野
				if ($stuid >= 106000000 && $stuid <= 300000000){
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$sum.",
							`user_basicHour` = `user_basicHour`+".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_inter` = `basic_inter`+".$service_hour[0].",
							`advan_inter` = `advan_inter`+".$service_hour[1]."
						WHERE
							`user_student` = '$stuid'";
				}else{
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$sum.", 
							`user_basicHour` = `user_basicHour`+".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_life` = `basic_life`+".$service_hour[0].",
							`advan_life` = `advan_life`+".$service_hour[1].",
							`basic_inter` = `basic_inter`+".$service_hour[0].",
							`advan_inter` = `advan_inter`+".$service_hour[1]."
						WHERE
							`user_student` = '$stuid'";
				}
			}
			break;
	}

	$sql = $sqlStr;
	$ret = mysql_query($sql, $db) or die(mysql_error());
	
	if($ret)
	{
		echo
		"
			<script>
				alert(\"".$errorstr."\");
				self.location.href='pass_view_out_activity.php?act_id=$actid';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"時數核可失敗\");
				self.location.href='pass_view_out_activity.php?act_id=$actid';
			</script>
		";
	}
?>
	</body>
</html>