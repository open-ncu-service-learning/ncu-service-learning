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
	$case3 = 0;
	$j = 0;

	$id = (int)$_GET['news_id'];

// 資料刪除
	//$sql = " DELETE FROM `pass`.`news_activity` WHERE `news_id` = '$id'";
	//$ret = mysql_query($sql, $db) or die(mysql_error());

	$sql = "SELECT news_no,news_title,news_begin_time,news_end_time FROM news_activity WHERE `news_id` = '$id'";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);

	//$sql1= "UPDATE `activity` SET `act_del`=1 WHERE `act_title` = '$row[news_title]' AND `act_begin_time` = '$row[news_begin_time]' and `act_end_time` = '$row[news_end_time]'";
	$sql1= "UPDATE `activity` SET `act_del`=1 WHERE act_id =".$sub_id;
	$ret1 = mysql_query($sql1, $db) or die(mysql_error());

	$sql2="UPDATE `news_activity` SET `news_del`=1 WHERE `news_id` = '$id'";
	//$sql2 = " DELETE FROM `pass`.`news_activity` WHERE `news_id` = '$id'";
	$ret2 = mysql_query($sql2, $db) or die(mysql_error());

	// 刪除學生時數

	//$sql3 = "SELECT * FROM `activity` WHERE `act_title` = '$row[news_title]' AND `act_begin_time` = '$row[news_begin_time]' and `act_end_time` = '$row[news_end_time]'";
	$sql3 = "SELECT * FROM `activity` WHERE act_id =".$sub_id;
	$ret3 = mysql_query($sql3, $db) or die(mysql_error());
	$row3 = mysql_fetch_assoc($ret3);

	// 若已有認證的學生
	if($row3['act_admit_student'] != NULL)
	{
		$list = $row3['act_admit_student'];
		$arr = explode(',', $list);
		$i = 0;


		if ($row3['act_service_hour'] == -1){
			foreach ($arr as $ar){
				$sql4 = "SELECT * FROM `service_activity` WHERE `ser_act_id` = '$row3[act_id]' AND `ser_del` = 0 AND `ser_stu_id` = '$ar'";
				$ret4 = mysql_query($sql4, $db) or die(mysql_error());
				$row4 = mysql_fetch_assoc($ret4);
				$service_hour[$i] = $row4['ser_hour'];
				$i ++;
			}
		}else{
			$service_hour[$i] = $row3['act_service_hour'];
		}


		// 判斷活動型態的認證時數
		switch($row3['act_pass_type'])
		{
			case 1:
				//$service_hour = $row3['act_service_hour'];
				if ($row3['act_type'] == 1){//服務學習
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - '%s',
									`user_basicHour` = `user_basicHour` - '%s',
									`basic_service` = `basic_service` - '%s'
								WHERE
									`user_student` = '%s'";
				}
				else if ($row3['act_type'] == 2){//生活知能
					if ($row3['act_life_sub'] == 1){//大一週會
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - '%s',
								`user_basicHour` = `user_basicHour` - '%s',
								`basic_life` = `basic_life` - '%s',
								`assembly_freshman` = `assembly_freshman` - 1
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 6){//院週會
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - '%s',
								`user_basicHour` = `user_basicHour` - '%s',
								`basic_life` = `basic_life` - '%s',
								`assembly_dep` = `assembly_dep` - 1
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 2){//大一CPR
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - '%s',
								`user_basicHour` = `user_basicHour` - '%s',
								`basic_life` = `basic_life` - '%s',
								`cpr` = `cpr` - '%s'
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 3){//自我探索
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - '%s',
								`user_basicHour` = `user_basicHour` - '%s',
								`basic_life` = `basic_life` - '%s',
								`career` = `career` - '%s'
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";
						foreach($arr as $stu_id)
						{
							$sql_t2 = sprintf($sql_t, $stu_id);
							$ret_t2 = mysql_query($sql_t2, $db) or die(mysql_error());
							$row_t2 = mysql_fetch_array($ret_t2);
							if ((int)$row_t2['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
								$stu_106[] = $row_t2['user_student'];
								if ($row3['act_service_hour'] == -1){
									$hours_106[] = $service_hour[j];
								}
							}
							$j++;
						}
						$sqlStr_106 = "UPDATE `all_user`
								SET
									`basic_life` = `basic_life` + '%s'
								WHERE
									`user_student` = '%s'";
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - '%s',
									`user_basicHour` = `user_basicHour` - '%s',
									`basic_life` = `basic_life` - '%s',
									`basic_inter` = `basic_inter` - '%s'
								WHERE
									`user_student` = '%s'";
					}
					else{// if ($row3['act_life_sub'] != 4){
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - '%s',
									`user_basicHour` = `user_basicHour` - '%s',
									`basic_life` = `basic_life` - '%s'
								WHERE
									`user_student` = '%s'";
					}
				}
				else if ($row3['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - '%s',
									`user_basicHour` = `user_basicHour` - '%s',
									`basic_art` = `basic_art` - '%s'
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
				//$service_hour = $row3['act_service_hour'];
				if ($row3['act_type'] == 1){//服務學習
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - '%s',
									`user_advanHour` = `user_advanHour` - '%s',
									`advan_service` = `advan_service` - '%s'
								WHERE
									`user_student` = '%s'";
				}
				else if ($row3['act_type'] == 2){//生活知能
					if ($row3['act_life_sub'] == 1){//大一週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` - '%s',
							`user_advanHour` = `user_advanHour` - '%s',
							`advan_life` = `advan_life` - '%s',
							`assembly_freshman` = `assembly_freshman` - 1
						WHERE
							`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 6){//院週會
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - '%s',
								`user_advanHour` = `user_advanHour` - '%s',
								`advan_life` = `advan_life` - '%s',
								`assembly_dep` = `assembly_dep` - 1
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 2){//大一CPR
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`  -  '%s',
								`user_advanHour` = `user_advanHour`  -  '%s',
								`advan_life` = `advan_life`  -  '%s',
								`cpr` = `cpr`  -  '%s'
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 3){//自我探索
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - '%s',
								`user_advanHour` = `user_advanHour` - '%s',
								`advan_life` = `advan_life` - '%s',
								`career` = `career` - '%s'
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";
						foreach($arr as $stu_id)
						{
							$sql_t2 = sprintf($sql_t, $stu_id);
							$ret_t2 = mysql_query($sql_t2, $db) or die(mysql_error());
							$row_t2 = mysql_fetch_array($ret_t2);
							if ((int)$row_t2['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
								$stu_106[] = $row_t2['user_student'];
							}
						}
						$sqlStr_106 = "UPDATE `all_user`
								SET
									`advan_life` = `advan_life` + '%s'
								WHERE
									`user_student` = '%s'";
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - '%s',
									`user_advanHour` = `user_advanHour` - '%s',
									`advan_life` = `advan_life` - '%s',
									`advan_inter` = `advan_inter` - '%s'
								WHERE
									`user_student` = '%s'";
					}
					else{// if ($row3['act_life_sub'] != 4){
						$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - '%s',
									`user_advanHour` = `user_advanHour` - '%s',
									`advan_life` = `advan_life` - '%s'
								WHERE
									`user_student` = '%s'";
					}
				}
				else if ($row3['act_type'] == 3){//人文藝術
					$sqlStr = "UPDATE `all_user`
								SET
									`user_totalHour` = `user_totalHour` - '%s',
									`user_advanHour` = `user_advanHour` - '%s',
									`advan_art` = `advan_art` - '%s'
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
				$case3 = 1;
				$service_hour = explode(",", $row3['act_service_hour']);
				$sum = $service_hour[0]+$service_hour[1];
				if ($row3['act_type'] == 1){//服務學習
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
				else if ($row3['act_type'] == 2){//生活知能
					if ($row3['act_life_sub'] == 1){//大一週會
					$sqlStr = "UPDATE `all_user`
						SET
							`user_totalHour` = `user_totalHour` - ".$sum.",
							`user_basicHour` = `user_basicHour` - ".$service_hour[0].",
							`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
							`basic_life` = `basic_life` - ".$service_hour[0].",
							`advan_life` = `advan_life` - ".$service_hour[1].",
							`assembly_freshman` = `assembly_freshman` - 1
						WHERE
							`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 6){//院週會
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$sum.",
								`user_basicHour` = `user_basicHour` - ".$service_hour[0].",
								`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
								`basic_life` = `basic_life` - ".$service_hour[0].",
								`advan_life` = `advan_life` - ".$service_hour[1].",
								`assembly_dep` = `assembly_dep` - 1
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 2){//大一CPR
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour`  -  ".$sum.",
								`user_basicHour` = `user_basicHour`  -  ".$service_hour[0].",
								`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
								`basic_life` = `basic_life` - ".$service_hour[0].",
								`advan_life` = `advan_life`  -  ".$service_hour[1].",
								`cpr` = `cpr`  -  ".$sum."
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 3){//自我探索
						$sqlStr = "UPDATE `all_user`
							SET
								`user_totalHour` = `user_totalHour` - ".$sum.",
								`user_basicHour` = `user_basicHour` - ".$service_hour[0].",
								`user_advanHour` = `user_advanHour` - ".$service_hour[1].",
								`basic_life` = `basic_life` - ".$service_hour[0].",
								`advan_life` = `advan_life` - ".$service_hour[1].",
								`career` = `career` - ".$sum."
							WHERE
								`user_student` = '%s'";
					}
					else if ($row3['act_life_sub'] == 4){//國際視野
						$sql_t = "SELECT `user_student` FROM `all_user` WHERE `user_student` = '%s'";
						foreach($arr as $stu_id)
						{
							$sql_t2 = sprintf($sql_t, $stu_id);
							$ret_t2 = mysql_query($sql_t2, $db) or die(mysql_error());
							$row_t2 = mysql_fetch_array($ret_t2);
							if ((int)$row_t2['user_student'] >= 106000000 && (int)$row_t2['user_student'] <= 300000000){//106後不算生活知能
								$stu_106[] = $row_t2['user_student'];
							}
						}
						$sqlStr_106 = "UPDATE `all_user`
								SET
									`basic_life` = `basic_life` + ".$service_hour[0].",
									`advan_life` = `advan_life` + ".$service_hour[1]."
								WHERE
									`user_student` = '%s'";
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
					else{// if ($row3['act_life_sub'] != 4){
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
				else if ($row3['act_type'] == 3){//人文藝術
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

		$arr = explode(",", $row3['act_admit_student']);
		$i = 0;
		//之後要用$case3 = 1判斷是否為混時，不是混時的才要用'%s'，混時照原本的就可
		if ($case3 != 1){
			if ($row3['act_life_sub'] == 2 || $row3['act_life_sub'] == 3 || $row3['act_life_sub'] == 4){
				foreach($arr as $stu_id)
				{
					$sql3 = sprintf($sqlStr, $service_hour[$i], $service_hour[$i], $service_hour[$i], $service_hour[$i], $stu_id);
					$ret3 = mysql_query($sql3, $db) or die(mysql_error());
					if ($row3['act_service_hour'] == -1){
						$i ++;
					}
				}
			}
			else{
				foreach($arr as $stu_id)
				{
					$sql3 = sprintf($sqlStr, $service_hour[$i], $service_hour[$i], $service_hour[$i], $stu_id);
					$ret3 = mysql_query($sql3, $db) or die(mysql_error());
					if ($row3['act_service_hour'] == -1){
						$i ++;
					}
				}
			}
			if (count($stu_106) != 0 && $row3['act_service_hour'] != -1){
				foreach($stu_106 as $student_106)
				{
					$sql = sprintf($sqlStr_106, $service_hour[$i], $student_106);
					$ret = mysql_query($sql, $db) or die(mysql_error());
				}
			}
			else if (count($stu_106) != 0 && $row3['act_service_hour'] == -1){
				$j = 0;
				foreach($stu_106 as $student_106)
				{
					$sql = sprintf($sqlStr_106, $hours_106[$j], $student_106);
					$ret = mysql_query($sql, $db) or die(mysql_error());
					$j ++;
				}
			}
		}

	}

	if($ret2)
	{
		echo
		"
			<script>
				alert(\"刪除公告成功\");
				self.location.href='pass_new_activity.php';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"刪除公告失敗\");
				self.location.href='pass_activity_content.php?news_id='$row[news_id]'';
			</script>
		";
	}
?>
	</body>
</html>
