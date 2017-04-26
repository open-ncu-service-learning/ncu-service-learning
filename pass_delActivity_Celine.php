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
	
	$id = (int)$_GET['news_id'];
	
// 取出資料	
	//$sql = " DELETE FROM `pass`.`news_activity` WHERE `news_id` = '$id'";	
	//$ret = mysql_query($sql, $db) or die(mysql_error());
	
	$sql = "SELECT news_title,news_begin_time,news_end_time FROM news_activity WHERE `news_id` = '$id'";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	
	
	/*刪除學生時數*/
	
	$sql3 = "SELECT * FROM `activity` WHERE `act_title` = '$row[news_title]' AND `act_begin_time` = '$row[news_begin_time]' and `act_end_time` = '$row[news_end_time]'";
	$ret3 = mysql_query($sql3, $db) or die(mysql_error());
	$row3 = mysql_fetch_assoc($ret3);
	
	
	// 若已有認證的學生
	if($row3['act_admit_student'] != NULL)
	{	
		// 活動型態
		$type = "";
		switch($row3['act_type']) 
		{
			case 1:
				$type = "服務學習";
				$index = 0;
				break;
			case 2:
				$type = "生活知能";
				$index = 2;
				if($row3[['act_type'] == 4 )//國際視野
				{
					if($stuid>106000000)
					{
						$type = "國際視野";
						$index = 6;
					}								
				}														
				break;
			case 3:
				$type = "人文藝術";
				$index = 4;
				break;
			default:
				$type = "無";
		}
		
		
		
		$list = $row3['act_admit_student'];
		$arr = explode(',', $list);
		foreach ($arr as $student )
		{
			
　			if ($row3['act_service_hour'] == -1)
			{
			$sql4 = "SELECT * FROM `service_activity` WHERE `ser_act_id` = '$row3[act_id]' AND `ser_del` = 0 AND `ser_stu_id` = '$student'";
			$ret4 = mysql_query($sql4, $db) or die(mysql_error());
			$row4 = mysql_fetch_assoc($ret4);
			$row3['act_service_hour'] = $row4['ser_hour'];
			}
			
			
			/*抓出學生的現在狀況，再去扣$row3['act_service_hour']，算完UPDATE回去 */
			
			$sql_user = "SELECT * FROM `all_user` WHERE `user_student` = '$student' AND user_del = '0' ";
			$ret_user = mysql_query($sql_user) or die(mysql_error());
			$row_user = mysql_fetch_assoc($ret_user);
			
			
		
			$totalHour = $row_user[''];	//總時數		
			$basicHour = $row_user[''];	//基本時數
			$advanHour = $row_user[''];	//高階時數	
			
			$serviceHour = array($row_user[''], $row_user[''], $row_user[''], $row_user[''], $row_user[''], $row_user[''],$row_user[''],$row_user['']);
			//0服學基本、1服學高階、2生活基本、3生活高階、4人文基本、5人文高階、6國際基本、7國際高階
			
			
			/*變數count 大一週會次數*/
			$i=$row_user[''];
			/*變數count 院週會次數*/
			$j=$row_user[''];
			
			$career=$row_user[''];//自我探索
			$cpr=$row_user[''];
			
			switch($row3[['act_pass_type']) {
						case 1:
							$hour = "基本: ".$row3[['act_service_hour'];
							$totalHour -= $row3[['act_service_hour'];
							$basicHour -= $row3[['act_service_hour'];
							$serviceHour[$index] -= $row3[['act_service_hour'];
							if($row3[['act_type']==2 )
							{
								if ($row['act_life_sub'] == 1)//大一週會
								{
									i--;
								}
								else if($row['act_life_sub'] == 6)//院週會
								{
									j--;
								}
								else if($row['act_life_sub'] == 2)//CPR
								{
									$cpr-= $row3[['act_service_hour'];
								}
								else if($row['act_life_sub'] == 3)//自我探索
								{
									$career -= $row3[['act_service_hour'];
								}
								else if($row3[['act_type'] == 4 )//國際視野
								{
									if($stuid<106000000)
									{
										$serviceHour[6] -= $row3[['act_service_hour'];
									}
								}
							}
							break;
						case 2:
							$hour = "高階: ".$row3[['act_service_hour'];
							$totalHour -= $row3[['act_service_hour'];
							$advanHour -= $row3[['act_service_hour'];
							$serviceHour[$index+1] -= $row3[['act_service_hour'];
							break;
						case 3:
							$arr = explode(',', $row3[['act_service_hour']);
							$hour = "基本: $arr[0] <br />高階: $arr[1]";
							$totalHour -= $arr[0];
							$totalHour -= $arr[1];
							$basicHour -= $arr[0];
							$advanHour -= $arr[1];
							$serviceHour[$index] -= $arr[0];
							$serviceHour[$index+1] -= $arr[1];
							if($row3[['act_type']==2 )
							{
								if ($row['act_life_sub'] == 1)//大一週會
								{
									i++;
								}
								else if($row['act_life_sub'] == 6)//院週會
								{
									j++;
								}
								else if($row['act_life_sub'] == 2)//CPR
								{
									$cpr-= $arr[0];
								}
								else if($row['act_life_sub'] == 3)//自我探索
								{
									$career -= $arr[0];
								}
								else if($row3[['act_type'] == 4 )//國際視野
								{
									if($stuid<106000000)
									{
										$serviceHour[6] -= $arr[0];
										$serviceHour[7] -= $arr[1];
									}
								}
							}
							break;
						default:
							$hour = 0;
					}
			
			
			$sql_u = "UPDATE `all_user` SET 
							`user_totalHour` =  '$totalHour',
							`user_basicHour` =  '$basicHour',
							`user_advanHour` = '$advanHour',
							`basic_service`= $serviceHour[0],
							`advan_service`= $serviceHour[1],
							`basic_life`= $serviceHour[2],
							`advan_life`= $serviceHour[3],
							`basic_art`= $serviceHour[4],
							`advan_art`= $serviceHour[5],
							`basic_inter`= $serviceHour[6],
							`advan_inter`= $serviceHour[7],
							`assembly_freshman`= '$i',
							`assembly_dep`= '$j',
							`career` = '$career',
							`cpr` = '$cpr'							
					WHERE `user_student` = '$student' AND `user_del` = '0'
					";
			$ret_u = mysql_query($sql_u) or die(mysql_error());
			
			
		}
		
			
	}	
	
		
		
	}
	//資料刪除
	$sql1= "UPDATE `activity` SET `act_del`=1 WHERE `act_title` = '$row[news_title]' AND `act_begin_time` = '$row[news_begin_time]' and `act_end_time` = '$row[news_end_time]'";	
	$ret1 = mysql_query($sql1, $db) or die(mysql_error());
	
	$sql2="UPDATE `news_activity` SET `news_del`=1 WHERE `news_id` = '$id'";
	//$sql2 = " DELETE FROM `pass`.`news_activity` WHERE `news_id` = '$id'";	
	$ret2 = mysql_query($sql2, $db) or die(mysql_error());
	
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
