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
	
	// 活動id
	$actID = $_POST['act_id'];
	
	// 學生人數
	$number = $_POST['num'];
	
	// 取出活動資訊
	$sql = "SELECT * FROM `activity` WHERE `act_id` = '$actID'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$pass_type = $row['act_pass_type'];
	
	for($i = 1; $i <= $number; $i++)
	{
		//$varHour = "hour"."$i";
		//$varStud = "stud"."$i";
		//$varPre = "pre"."$i";
		
		if ($_POST["hour"."$i"] == ''){//空值自動代入0
			$varHour = 0;
		}
		else{
			$varHour = $_POST["hour"."$i"];
		}
		
		$varStud = $_POST["stud"."$i"];
		$varPre = $_POST["pre"."$i"];
	
		// 更新學生總時數
		switch($pass_type)
		{
			case 1:
				$service_hour = $varHour - $varPre;
				if ($row['act_type'] == 1){//服務學習
				$sqlStr = "UPDATE `pass`.`all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_service` = `basic_service`+".$service_hour."
							WHERE
								`user_student` = '".$varStud."'";
				}
				else if ($row['act_type'] == 2){//生活知能
					if ($row['act_life_sub'] == 1){//大一週會`assembly_freshman` = `assembly_freshman`+1
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_life` = `basic_life`+".$service_hour."
							WHERE
								`user_student` = '".$varStud."'";
					}
					else if ($row['act_life_sub'] == 6){//院週會`assembly_dep` = `assembly_dep`+1
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_life` = `basic_life`+".$service_hour."								
							WHERE
								`user_student` = '".$varStud."'";
					}
					else if ($row['act_life_sub'] == 2){//大一CPR
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` + ".$service_hour.", 
								`user_basicHour` = `user_basicHour` + ".$service_hour.",
								`basic_life` = `basic_life` + ".$service_hour.",
								`cpr` = `cpr` + ".$service_hour."
							WHERE
								`user_student` = '".$varStud."'";
					}
					else if ($row['act_life_sub'] == 3){//自我探索
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_life` = `basic_life`+".$service_hour.",
								`career` = `career`+".$service_hour."
							WHERE
								`user_student` = '".$varStud."'";
					}
					else if ($row['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '".$varStud."'";
							$sql_t = sprintf($sql_t, $varStud);
							$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
						$row_t = mysql_fetch_array($ret_t);
						if ((int)$row_t['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_basicHour` = `user_basicHour`+".$service_hour.",
									`basic_inter` = `basic_inter`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
						}else{		
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_basicHour` = `user_basicHour`+".$service_hour.",
									`basic_life` = `basic_life`+".$service_hour.",
									`basic_inter` = `basic_inter`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
						}
					}
					else{//一般
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_basicHour` = `user_basicHour`+".$service_hour.",
									`basic_life` = `basic_life`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
					}
				}
				else if ($row['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_basicHour` = `user_basicHour`+".$service_hour.",
									`basic_art` = `basic_art`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
				}
				$ret = mysql_query($sqlStr, $db) or die(mysql_error());	
				/*$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_basicHour` = `user_basicHour`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
				$ret = mysql_query($sqlStr, $db) or die(mysql_error());*/
				break;
				
			case 2:
				$service_hour = $varHour - $varPre;	
				if ($row['act_type'] == 1){//服務學習
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_service` = `advan_service`+".$service_hour."
							WHERE
								`user_student` = '".$varStud."'";
				}
				else if ($row['act_type'] == 2){//生活知能
					if ($row['act_life_sub'] == 1){//大一週會`assembly_freshman` = `assembly_freshman`+1
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_life` = `advan_life`+".$service_hour."								
							WHERE
								`user_student` = '".$varStud."'";
					}
					else if ($row['act_life_sub'] == 6){//院週會`assembly_dep` = `assembly_dep`+1
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_life` = `advan_life`+".$service_hour."								
							WHERE
								`user_student` = '".$varStud."'";
					}
					else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` + ".$service_hour.", 
							`user_advanHour` = `user_advanHour` + ".$service_hour.",
							`advan_life` = `advan_life` + ".$service_hour.",
							`cpr` = `cpr` + ".$service_hour."
						WHERE
							`user_student` = '".$varStud."'";
					}
					else if ($row['act_life_sub'] == 3){//自我探索
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_life` = `advan_life`+".$service_hour.",
								`career` = `career`+".$service_hour."
							WHERE
								`user_student` = '".$varStud."'";
					}else
					if ($row['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '".$varStud."'";
							$sql_t = sprintf($sql_t, $varStud);
							$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
						$row_t = mysql_fetch_array($ret_t);
						if ((int)$row_t['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_advanHour` = `user_advanHour`+".$service_hour.",
									`advan_inter` = `advan_inter`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
						}else{		
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_advanHour` = `user_advanHour`+".$service_hour.",
									`advan_life` = `advan_life`+".$service_hour.",
									`advan_inter` = `advan_inter`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
							}
					}
					else{//一般
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_advanHour` = `user_advanHour`+".$service_hour.",
									`advan_life` = `advan_life`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
					}
				}
				else if ($row['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_advanHour` = `user_advanHour`+".$service_hour.",
									`advan_art` = `advan_art`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
				}
					
				$ret = mysql_query($sqlStr, $db) or die(mysql_error());/*
				$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_advanHour` = `user_advanHour`+".$service_hour."
								WHERE
									`user_student` = '".$varStud."'";
				*/
				break;
				
			case 3:
				/*
				 * 沒有混合時數
				 */
				break;
		}
				
		// 更新服務時數
		//$sql = "UPDATE `service_activity` SET `ser_hour` = '".$$varHour."' WHERE `ser_act_id` = '$actID' AND `ser_stu_id` = '".$$varStud."' AND ser_del = '0'";
		$sql = "UPDATE `service_activity` SET `ser_hour` = '".$varHour."' WHERE `ser_act_id` = '$actID' AND `ser_stu_id` = '".$varStud."' AND ser_del = '0'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
	}
	
	if($ret)
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"時數核可成功\");
				self.location.href='pass_service_hour_admit_student.php?id=$actID';
			</script>
		";
	}
	else
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"時數核可失敗\");
				self.location.href='pass_service_hour_admit_student.php?id=$actID';
			</script>
		";
	}
?>
	</body>
</html>