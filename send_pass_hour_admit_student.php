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
	
	// 認證名單
	$list = $_POST['list'];
	$act_id = $_POST['act_id'];
	$valid_admin_account=(string) $_SESSION['valid_admin_account'];
	
	// 檢查該學生是否重複核可
	foreach($list as $student)
	{
		$sql = "SELECT * FROM `activity` WHERE `act_id` = '".$_POST['act_id']."' AND `act_admit_student` LIKE '%".$student."%'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		$num = mysql_num_rows($ret);
		
		// 允許核可
		if($num == 0){
			$people[] = (string)$student;
			$sql_i = "INSERT INTO `activity_student` ( student , activity ) ".
				"VALUES ( $student , $act_id ) ; ";
			echo $sql_i;
			$ret = mysql_query($sql_i, $db) or die(mysql_error());
		}
		else // 重複的學生
			$repeat[] = $student;
	}
	
	// 將陣列的內容以逗號串接
	$peopleStr = "";
	$repeatStr = "";
	
	if(count($people))
		$peopleStr = implode(",", $people);
	if(count($repeat))
		$repeatStr = implode(",", $repeat);
	
	// 新的核可名單
	$newList = "";
	$sql = "SELECT * FROM `activity` WHERE `act_id` = '".$_POST['act_id']."'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$oldList = $row['act_admit_student'];
	// 取出認證時數
	switch($row['act_pass_type'])
	{
		case 1://基本
			$service_hour = $row['act_service_hour'];	
			if ($row['act_type'] == 1){//服務學習
				/*if ($row['act_life_sub'] == 6){//院週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_basicHour` = `user_basicHour`+".$service_hour.",
							`basic_service` = `basic_service`+".$service_hour.",
							`assembly_dep` = `assembly_dep`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` + ".$service_hour.", 
							`user_basicHour` = `user_basicHour` + ".$service_hour.",
							`basic_service` = `basic_service` + ".$service_hour.",
							`cpr` = `cpr` + ".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 3){//自我探索
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_basicHour` = `user_basicHour`+".$service_hour.",
							`basic_service` = `basic_service`+".$service_hour.",
							`career` = `career`+".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 4){//國際視野
					$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";					
					foreach($people as $student)
					{
						$sql_t = sprintf($sql_t, $student);
						$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
					}
					$row_t = mysql_fetch_array($ret_t);
					if ((int)$row_t['user_student'] >= 106000000){//106後不算生活知能
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_inter` = `basic_inter`+".$service_hour."
							WHERE
								`user_student` = '%s'";
					}else{		
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_service` = `basic_service`+".$service_hour.",
								`basic_inter` = `basic_inter`+".$service_hour."
							WHERE
								`user_student` = '%s'";
					}
				}
				else{*///一般
					$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_service` = `basic_service`+".$service_hour."
							WHERE
								`user_student` = '%s'";
				//}
			}
			else if ($row['act_type'] == 2){//生活知能				
				if ($row['act_life_sub'] == 1){//大一週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_basicHour` = `user_basicHour`+".$service_hour.",
							`basic_life` = `basic_life`+".$service_hour.",
							`assembly_freshman` = `assembly_freshman`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 6){//院週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_basicHour` = `user_basicHour`+".$service_hour.",
							`basic_life` = `basic_life`+".$service_hour.",
							`assembly_dep` = `assembly_dep`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` + ".$service_hour.", 
							`user_basicHour` = `user_basicHour` + ".$service_hour.",
							`basic_life` = `basic_life` + ".$service_hour.",
							`cpr` = `cpr` + ".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 3){//自我探索
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_basicHour` = `user_basicHour`+".$service_hour.",
							`basic_life` = `basic_life`+".$service_hour.",
							`career` = `career`+".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 4){//國際視野
					$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";
					foreach($people as $student)
					{
						$sql_t2 = sprintf($sql_t, $student);
						$ret_t2 = mysql_query($sql_t2, $db) or die(mysql_error());									
						$row_t2 = mysql_fetch_array($ret_t2);
						if ((int)$row_t2['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
							$stu_106[] = $row_t2['user_student'];
						}
					}
					$sqlStr_106 = "UPDATE `all_user`
								SET
									`basic_life` = `basic_life`-".$service_hour."
								WHERE
									`user_student` = '%s'";
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour`+".$service_hour.", 
									`user_basicHour` = `user_basicHour`+".$service_hour.",
									`basic_life` = `basic_life`+".$service_hour.",
									`basic_inter` = `basic_inter`+".$service_hour."
								WHERE
									`user_student` = '%s'";									
				}
				else{//一般
					$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_life` = `basic_life`+".$service_hour."
							WHERE
								`user_student` = '%s'";
				}
			}
			else if ($row['act_type'] == 3){//人文藝術
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_basicHour` = `user_basicHour`+".$service_hour.",
								`basic_art` = `basic_art`+".$service_hour."
							WHERE
								`user_student` = '%s'";
			}		
			break;
			
		case 2://高階
			$service_hour = $row['act_service_hour'];			
			if ($row['act_type'] == 1){//服務學習
				/*if ($row['act_life_sub'] == 6){//院週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_advanHour` = `user_advanHour`+".$service_hour.",
							`advan_service` = `advan_service`+".$service_hour.",
							`assembly_dep` = `assembly_dep`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` + ".$service_hour.", 
							`user_advanHour` = `user_advanHour` + ".$service_hour.",
							`advan_service` = `advan_service` + ".$service_hour.",
							`cpr` = `cpr` + ".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 3){//自我探索
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_advanHour` = `user_advanHour`+".$service_hour.",
							`advan_service` = `advan_service`+".$service_hour.",
							`career` = `career`+".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 4){//國際視野
					$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";					
					foreach($people as $student)
					{
						$sql_t = sprintf($sql_t, $student);
						$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
					}
					$row_t = mysql_fetch_array($ret_t);
					if ((int)$row_t['user_student'] >= 106000000){//106後不算生活知能
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_inter` = `advan_inter`+".$service_hour."
							WHERE
								`user_student` = '%s'";
					}else{		
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_service` = `advan_service`+".$service_hour.",
								`advan_inter` = `advan_inter`+".$service_hour."
							WHERE
								`user_student` = '%s'";
					}
				}
				else{*///一般
					$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_service` = `advan_service`+".$service_hour."
							WHERE
								`user_student` = '%s'";
				//}				
			}
			else if ($row['act_type'] == 2){//生活知能
				if ($row['act_life_sub'] == 1){//大一週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_advanHour` = `user_advanHour`+".$service_hour.",
							`advan_life` = `advan_life`+".$service_hour.",
							`assembly_freshman` = `assembly_freshman`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 6){//院週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_advanHour` = `user_advanHour`+".$service_hour.",
							`advan_life` = `advan_life`+".$service_hour.",
							`assembly_dep` = `assembly_dep`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` + ".$service_hour.", 
							`user_advanHour` = `user_advanHour` + ".$service_hour.",
							`advan_life` = `advan_life` + ".$service_hour.",
							`cpr` = `cpr` + ".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 3){//自我探索
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$service_hour.", 
							`user_advanHour` = `user_advanHour`+".$service_hour.",
							`advan_life` = `advan_life`+".$service_hour.",
							`career` = `career`+".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 4){//國際視野
					$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";					
					foreach($people as $student)
					{
						$sql_t2 = sprintf($sql_t, $student);
						$ret_t2 = mysql_query($sql_t2, $db) or die(mysql_error());									
						$row_t2 = mysql_fetch_array($ret_t2);
						if ((int)$row_t2['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
							$stu_106[] = $row_t2['user_student'];
						}
					}
					$sqlStr_106 = "UPDATE `all_user`
								SET
									`advan_life` = `advan_life`-".$service_hour."
								WHERE
									`user_student` = '%s'";	
					$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_life` = `advan_life`+".$service_hour.",
								`advan_inter` = `advan_inter`+".$service_hour."
							WHERE
								`user_student` = '%s'";
				}
				else{//一般
					$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_life` = `advan_life`+".$service_hour."
							WHERE
								`user_student` = '%s'";
				}
			}
			else if ($row['act_type'] == 3){//人文藝術
				$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$service_hour.", 
								`user_advanHour` = `user_advanHour`+".$service_hour.",
								`advan_art` = `advan_art`+".$service_hour."
							WHERE
								`user_student` = '%s'";
			}
			break;
			
		case 3://基本+高階
			$service_hour = explode(",", $row['act_service_hour']);
			$sum = $service_hour[0]+$service_hour[1];
			if ($row['act_type'] == 1){//服務學習
				/*if ($row['act_life_sub'] == 6){//院週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$sum.", 
							`user_basicHour` = `user_basicHour`+".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_service` = `basic_service`+".$service_hour[0].",
							`advan_service` = `advan_service`+".$service_hour[1].",
							`assembly_dep` = `assembly_dep`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` + ".$sum.", 
							`user_basicHour` = `user_basicHour` + ".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_service` = `basic_service`+".$service_hour[0].",
							`advan_service` = `advan_service` + ".$service_hour[1].",
							`cpr` = `cpr` + ".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 3){//自我探索
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$sum.", 
							`user_basicHour` = `user_basicHour`+".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_service` = `basic_service`+".$service_hour[0].",
							`advan_service` = `advan_service`+".$service_hour[1].",
							`career` = `career`+".$service_hour."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 4){//國際視野
					$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";					
					foreach($people as $student)
					{
						$sql_t = sprintf($sql_t, $student);
						$ret_t = mysql_query($sql_t, $db) or die(mysql_error());
					}
					$row_t = mysql_fetch_array($ret_t);
					if ((int)$row_t['user_student'] >= 106000000){//106後不算生活知能
						$sqlStr = "UPDATE `all_user`
								`user_totalHour` = `user_totalHour`+".$sum.",
								`user_basicHour` = `user_basicHour`+".$service_hour[0].",
								`user_advanHour` = `user_advanHour`+".$service_hour[1].",
								`basic_inter` = `basic_inter`+".$service_hour[0].",
								`advan_inter` = `advan_inter`+".$service_hour[1]."
							WHERE
								`user_student` = '%s'";
					}else{		
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$sum.", 
								`user_basicHour` = `user_basicHour`+".$service_hour[0].",
								`user_advanHour` = `user_advanHour`+".$service_hour[1].",
								`basic_service` = `basic_service`+".$service_hour[0].",
								`advan_service` = `advan_service`+".$service_hour[1].",
								`basic_inter` = `basic_inter`+".$service_hour[0].",
								`advan_inter` = `advan_inter`+".$service_hour[1]."
							WHERE
								`user_student` = '%s'";
					}
				}
				else{*///一般
					$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$sum.", 
								`user_basicHour` = `user_basicHour`+".$service_hour[0].",
								`user_advanHour` = `user_advanHour`+".$service_hour[1].",
								`basic_service` = `basic_service`+".$service_hour[0].",
								`advan_service` = `advan_service`+".$service_hour[1]."
							WHERE
								`user_student` = '%s'";
				//}
			}
			else if ($row['act_type'] == 2){//生活知能
				if ($row['act_life_sub'] == 1){//大一週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$sum.", 
							`user_basicHour` = `user_basicHour`+".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_life` = `basic_life`+".$service_hour[0].",
							`advan_life` = `advan_life`+".$service_hour[1].",
							`assembly_freshman` = `assembly_freshman`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 6){//院週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$sum.", 
							`user_basicHour` = `user_basicHour`+".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_life` = `basic_life`+".$service_hour[0].",
							`advan_life` = `advan_life`+".$service_hour[1].",
							`assembly_dep` = `assembly_dep`+1
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 2){//大一CPR
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` + ".$sum.", 
							`user_basicHour` = `user_basicHour` + ".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_life` = `basic_life`+".$service_hour[0].",
							`advan_life` = `advan_life` + ".$service_hour[1].",
							`cpr` = `cpr` + ".$sum."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 3){//自我探索
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour`+".$sum.", 
							`user_basicHour` = `user_basicHour`+".$service_hour[0].",
							`user_advanHour` = `user_advanHour`+".$service_hour[1].",
							`basic_life` = `basic_life`+".$service_hour[0].",
							`advan_life` = `advan_life`+".$service_hour[1].",
							`career` = `career`+".$sum."
						WHERE
							`user_student` = '%s'";
				}
				else if ($row['act_life_sub'] == 4){//國際視野
					$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";					
					foreach($people as $student)
					{
						$sql_t2 = sprintf($sql_t, $student);
						$ret_t2 = mysql_query($sql_t2, $db) or die(mysql_error());									
						$row_t2 = mysql_fetch_array($ret_t2);
						if ((int)$row_t2['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
							$stu_106[] = $row_t2['user_student'];
						}
					}
					$sqlStr_106 = "UPDATE `all_user`
								SET
									`basic_life` = `basic_life`-".$service_hour[0].",
									`adbvan_life` = `advan_life`-".$service_hour[1]."
								WHERE
									`user_student` = '%s'";
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
								`user_student` = '%s'";
				}
				else{//一般
					$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`+".$sum.", 
								`user_basicHour` = `user_basicHour`+".$service_hour[0].",
								`user_advanHour` = `user_advanHour`+".$service_hour[1].",
								`basic_life` = `basic_life`+".$service_hour[0].",
								`advan_life` = `advan_life`+".$service_hour[1]."
							WHERE
								`user_student` = '%s'";
				}
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
								`user_student` = '%s'";
			}
			break;
	}

	// 若本次有新增
	if($peopleStr)
	{
		// 若舊名單已有其他學生
		if($oldList)
			$newList = $oldList.",".$peopleStr;
		else
			$newList = $peopleStr;
			
		// 更新核可名單	
		$sql = "UPDATE `activity` SET `act_admit_student` = '$newList' , `act_admiter` = '$valid_admin_account' WHERE `act_id` = '".$_POST['act_id']."'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		
		// 寫入時數
		foreach($people as $student)
		{
			$sql = sprintf($sqlStr, $student);
			$ret = mysql_query($sql, $db) or die(mysql_error());
		}
		if (count($stu_106) != 0){
			foreach($stu_106 as $student_106)
			{
				$sql = sprintf($sqlStr_106, $student_106);
				$ret = mysql_query($sql, $db) or die(mysql_error());
			}
		}
	}
	else	// 維持舊名單
		$newList = $oldList;
	
	// 清空陣列
	unset($people);
	unset($repeat);	
	
	$tip = "";
	if($repeatStr)
		$tip = ", 學號 ".$repeatStr." 的學生曾經核可過。";
		
		
	if($ret)
	{
		echo
		"
			<script>
				alert(\"時數核可成功".$tip."\");
				self.location.href='pass_hour_admit_student.php?id=$_POST[act_id]';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"時數核可失敗\");
				self.location.href='pass_hour_admit_student.php?id=$_POST[act_id]';
			</script>
		";
	}
?>
	</body>
</html>