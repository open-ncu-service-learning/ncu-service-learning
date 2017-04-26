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
	
	$ser_id = $_GET['ser'];
	$stu_id = $_GET['stu'];
	$act_id = $_GET['act'];
	$hour = $_GET['hour'];
	
	$sql = "DELETE FROM `activity_student` WHERE `student`= $stu_id and `activity` = $act_id ";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	
	$sql = "SELECT * FROM `activity` WHERE act_id = '$act_id'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$list = $row['act_admit_student'];
	$pass_type = $row['act_pass_type'];

/***************************************
** 將Activity名單中該位學生的學號刪除 **
***************************************/
	
	$arr = explode(',', $list);
	
	$i = 0;
	foreach($arr as $student)
	{
		if($student == $stu_id)
			break;
		$i++;
	}
	
/////////////////////////
// 重新更新學生時數
/////////////////////////
	switch($pass_type)
	{
			case 1:
				if ($row['act_type'] == 1){//服務學習
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$hour.", 
								`user_basicHour` = `user_basicHour` - ".$hour.",
								`basic_service` = `basic_service` - ".$hour."
							WHERE
								`user_student` = '".$stu_id."'";
				}
				else if ($row['act_type'] == 2){//生活知能
					if ($row['act_life_sub'] == 1){//大一週會
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$hour.", 
								`user_basicHour` = `user_basicHour` - ".$hour.",
								`basic_life` = `basic_life`-".$hour.",
								`assembly_freshman` = `assembly_freshman`-1
							WHERE
								`user_student` = '".$stu_id."'";
					}
					else if ($row['act_life_sub'] == 6){//院週會
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`-".$hour.", 
								`user_basicHour` = `user_basicHour`-".$hour.",
								`basic_life` = `basic_life`-".$hour.",
								`assembly_dep` = `assembly_dep`-1
							WHERE
								`user_student` = '".$stu_id."'";
					}
					else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` - ".$hour.", 
							`user_basicHour` = `user_basicHour` - ".$hour.",
							`basic_life` = `basic_life` - ".$hour.",
							`cpr` = `cpr` - ".$hour."
						WHERE
							`user_student` = '".$stu_id."'";
					}
					else if ($row['act_life_sub'] == 3){//自我探索
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`-".$hour.", 
								`user_basicHour` = `user_basicHour`-".$hour.",
								`basic_life` = `basic_life`-".$hour.",
								`career` = `career`-".$hour."
							WHERE
								`user_student` = '".$stu_id."'";
					}
					else if ($row['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '".$stu_id."'";
							$sql_t = sprintf($sql_t, $stu_id);
							$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
						$row_t = mysql_fetch_array($ret_t);
						if ((int)$row_t['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`-".$hour.", 
									`user_basicHour` = `user_basicHour`-".$hour.",
									`basic_inter` = `basic_inter`-".$hour."
								WHERE
									`user_student` = '".$stu_id."'";
						}else{		
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`-".$hour.", 
									`user_basicHour` = `user_basicHour`-".$hour.",
									`basic_life` = `basic_life`-".$hour.",
									`basic_inter` = `basic_inter`-".$hour."
								WHERE
									`user_student` = '".$stu_id."'";
						}
					}
					else{//一般
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`-".$hour.", 
									`user_basicHour` = `user_basicHour`-".$hour.",
									`basic_life` = `basic_life`-".$hour."
								WHERE
									`user_student` = '".$stu_id."'";
					}
				}
				else if ($row['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`-".$hour.", 
									`user_basicHour` = `user_basicHour`-".$hour.",
									`basic_art` = `basic_art`-".$hour."
								WHERE
									`user_student` = '".$stu_id."'";
				}	/*	
			$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`-".$hour.", 
								`user_basicHour` = `user_basicHour`-".$hour."
							WHERE
								`user_student` = '".$stu_id."'";*/
			$ret = mysql_query($sqlStr, $db) or die(mysql_error());
			break;
			
			case 2:
				if ($row['act_type'] == 1){//服務學習
					$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$hour.", 
								`user_advanHour` = `user_advanHour` - ".$hour.",
								`advan_service` = `advan_service` - ".$hour."
							WHERE
								`user_student` = '".$stu_id."'";
				}
				else if ($row['act_type'] == 2){//生活知能
					if ($row['act_life_sub'] == 1){//大一週會
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$hour.", 
								`user_advanHour` = `user_advanHour` - ".$hour.",
								`advan_life` = `advan_life` - ".$hour.",
								`assembly_freshman` = `assembly_freshman` - 1
							WHERE
								`user_student` = '".$stu_id."'";
					}
					else if ($row['act_life_sub'] == 6){//院週會
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$hour.", 
								`user_advanHour` = `user_advanHour` - ".$hour.",
								`advan_life` = `advan_life` - ".$hour.",
								`assembly_dep` = `assembly_dep` - 1
							WHERE
								`user_student` = '".$stu_id."'";
					}
					else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` - ".$hour.", 
							`user_advanHour` = `user_advanHour` - ".$hour.",
							`advan_life` = `advan_life` - ".$hour.",
							`cpr` = `cpr` - ".$hour."
						WHERE
							`user_student` = '".$stu_id."'";
					}
					else if ($row['act_life_sub'] == 3){//自我探索
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$hour.", 
								`user_advanHour` = `user_advanHour` - ".$hour.",
								`advan_life` = `advan_life` - ".$hour.",
								`career` = `career` - ".$hour."
							WHERE
								`user_student` = '".$stu_id."'";
					}
					else 
					if ($row['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '".$stu_id."'";
							$sql_t = sprintf($sql_t, $stu_id);
						$row_t = mysql_fetch_array($ret_t);
						if ((int)$row_t['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$hour.", 
									`user_advanHour` = `user_advanHour` - ".$hour.",
									`advan_inter` = `advan_inter` - ".$hour."
								WHERE
									`user_student` = '".$stu_id."'";
						}else{		
							$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$hour.", 
									`user_advanHour` = `user_advanHour` - ".$hour.",
									`advan_life` = `advan_life` - ".$hour.",
									`advan_inter` = `advan_inter` - ".$hour."
								WHERE
									`user_student` = '".$stu_id."'";
						}
					}
					else{//一般
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$hour.", 
									`user_advanHour` = `user_advanHour` - ".$hour.",
									`advan_life` = `advan_life` - ".$hour."
								WHERE
									`user_student` = '".$stu_id."'";
					}
				}
				else if ($row['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - ".$hour.", 
									`user_advanHour` = `user_advanHour` - ".$hour.",
									`advan_art` = `advan_art` - ".$hour."
								WHERE
									`user_student` = '".$stu_id."'";
				}
				/*
			$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`-".$hour.", 
								`user_advanHour` = `user_advanHour`-".$hour."
							WHERE
								`user_student` = '".$stu_id."'";
			*/
			$ret = mysql_query($sqlStr, $db) or die(mysql_error());
			break;
			
		case 3:
			/*
			 * 沒有混合時數
			 */
			break;
	}	
	
	// 移除該學生
	unset($arr[$i]);
	
	// 新的學生名單
	$newList = "";
	$tmp = array_values($arr);
	if(count($tmp))
		$newList = implode(",", $tmp);

	$sql = "UPDATE `activity` SET act_admit_student = '$newList' WHERE act_id = '$act_id'";
	$ret = mysql_query($sql, $db) or die(mysql_error());

//////////////////////////	
// 將服務時數刪除
//////////////////////////
	$sql = "UPDATE `service_activity` SET ser_del = '1' WHERE ser_act_id = '$act_id' AND ser_id = '$ser_id'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	

	if($ret)
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"學生刪除成功\");
				self.location.href='pass_service_hour_admit_student.php?id=".$act_id."';
			</script>
		";
	}
	else
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"學生刪除失敗\");
				self.location.href='pass_service_hour_admit_student.php?id=".$act_id."';
			</script>
		";
	}
?>
	</body>
</html>