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
	require("conn/db.php");
	
	// 刪除學生時數
	$sql = "SELECT * FROM `out_activity` WHERE act_id = "."'".$_GET['id']."'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	
	// 若已有認證的學生
	if($row['act_admit_student'] != NULL)
	{		
		// 判斷活動型態的認證時數
		switch($row['act_pass_type'])
		{
			case 1:
				$service_hour = $row['act_service_hour'];	
				if ($row['act_type'] == 1){//服務學習
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_basicHour` = `user_basicHour` - ".$service_hour.",
									`basic_service` = `basic_service` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
				}
				else if ($row['act_type'] == 2){//生活知能
					if ($row['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";
							$sql_t = sprintf($sql_t, $stu_id);
							$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
						$row_t = mysql_fetch_array($ret_t);
						if ((int)$row_t['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_basicHour` = `user_basicHour` - ".$service_hour.",
									`basic_inter` = `basic_inter` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
						}else{		
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_basicHour` = `user_basicHour` - ".$service_hour.",
									`basic_life` = `basic_life` - ".$service_hour.",
									`basic_inter` = `basic_inter` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
						}
					}
					else if ($row['act_life_sub'] != 4){
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_basicHour` = `user_basicHour` - ".$service_hour.",
									`basic_life` = `basic_life` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
					}
				}
				else if ($row['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_basicHour` = `user_basicHour` - ".$service_hour.",
									`basic_art` = `basic_art` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
				}/*				
				$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`-".$service_hour.", 
									`user_basicHour` = `user_basicHour`-".$service_hour."
								WHERE
									`user_student` = '%s'";*/
				break;
			case 2:
				$service_hour = $row['act_service_hour'];	
				if ($row['act_type'] == 1){//服務學習
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_advanHour` = `user_advanHour` - ".$service_hour.",
									`advan_service` = `advan_service` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
				}
				else if ($row['act_type'] == 2){//生活知能
					if ($row['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";
							$sql_t = sprintf($sql_t, $stu_id);
							$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
						$row_t = mysql_fetch_array($ret_t);
						if ((int)$row_t['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_advanHour` = `user_advanHour` - ".$service_hour.",
									`advan_inter` = `advan_inter` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
						}else{
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_advanHour` = `user_advanHour` - ".$service_hour.",
									`advan_life` = `advan_life` - ".$service_hour.",
									`advan_inter` = `advan_inter` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
						}
					}
					else if ($row['act_life_sub'] != 4){
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_advanHour` = `user_advanHour` - ".$service_hour.",
									`advan_life` = `advan_life` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
					}
				}
				else if ($row['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$service_hour.", 
									`user_advanHour` = `user_advanHour` - ".$service_hour.",
									`advan_art` = `advan_art` - ".$service_hour."
								WHERE
									`user_student` = '%s'";
				}/*				
				$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`-".$service_hour.", 
									`user_advanHour` = `user_advanHour`-".$service_hour."
								WHERE
									`user_student` = '%s'";*/
				break;
			case 3:
				$service_hour = explode(",", $row['act_service_hour']);
				$sum = $service_hour[0]+$service_hour[1];
				if ($row['act_type'] == 1){//服務學習
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$sum.", 
								`user_basicHour` = `user_basicHour` - ".$service_hour[0].",
								`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
								`basic_service` = `basic_service` - ".$service_hour[0].",
								`advan_service` = `advan_service` - ".$service_hour[1]."
							WHERE
								`user_student` = '%s'";
				}
				else if ($row['act_type'] == 2){//生活知能
					if ($row['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";
							$sql_t = sprintf($sql_t, $stu_id);
							$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
						$row_t = mysql_fetch_array($ret_t);
						if ((int)$row_t['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$sum.",
									`user_basicHour` = `user_basicHour` - ".$service_hour[0].",
									`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
									`basic_inter` = `basic_inter` - ".$service_hour[0].",
									`advan_inter` = `advan_inter` - ".$service_hour[1]."
								WHERE
									`user_student` = '%s'";
						}else{
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$sum.", 
									`user_basicHour` = `user_basicHour` - ".$service_hour[0].",
									`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
									`basic_life` = `basic_life` - ".$service_hour[0].",
									`advan_life` = `advan_life` - ".$service_hour[1].",
									`basic_inter` = `basic_inter` - ".$service_hour[0].",
									`advan_inter` = `advan_inter` - ".$service_hour[1]."
								WHERE
									`user_student` = '%s'";
						}
					}
					else if ($row['act_life_sub'] != 4){
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$sum.", 
									`user_basicHour` = `user_basicHour` - ".$service_hour[0].",
									`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
									`basic_life` = `basic_life` - ".$service_hour[0].",
									`advan_life` = `advan_life` - ".$service_hour[1]."
								WHERE
									`user_student` = '%s'";
					}
				}
				else if ($row['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$sum.", 
									`user_basicHour` = `user_basicHour` - ".$service_hour[0].",
									`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
									`basic_art` = `basic_art` - ".$service_hour[0].",
									`advan_art` = `advan_art` - ".$service_hour[1]."
								WHERE
									`user_student` = '%s'";
				}/*
				$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`-".$sum.",
									`user_basicHour` = `user_basicHour`-".$service_hour[0].",
									`user_advanHour` = `user_advanHour`-".$service_hour[1]."
								WHERE
									`user_student` = '%s'";*/
				break;
		}
	
		$arr = explode(",", $row['act_admit_student']);
		foreach($arr as $stu_id)
		{
			$sql = sprintf($sqlStr, $stu_id);
			$ret = mysql_query($sql, $db) or die(mysql_error());
		}
	}
	
	// 刪除活動
	$sql = "UPDATE `out_activity` SET act_del = '1' WHERE act_id = "."'".$_GET['id']."'";
	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"活動刪除成功\");
				self.location.href='pass_out_activities_manage.php';
			</script>
		";
	}
	else
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"活動刪除失敗\");
				self.location.href='pass_out_activities_manage.php';
			</script>
		";
	}
?>
	</body>
</html>