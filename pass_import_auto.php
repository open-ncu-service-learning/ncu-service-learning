<?php
	if ($_GET['pw']!=1916) {
		exit;
	}
	
	require("conn/db.php");
	
	//設定執行時間為無限大
	set_time_limit(0); 
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
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

<!-- News -->
			<div id="main">
				<div id="welcome" class="post">

				<!-- 內容由此填入 -->
				<script language="javascript">
　					var NowDate=new Date();				
　					document.write(NowDate.getFullYear()+ " 年 " + (NowDate.getMonth()+1) + " 月 " + NowDate.getDate() + " 日"+NowDate.getHours()+":"+NowDate.getMinutes());
					
				</script>
				<br>
<?
				// 開始執行時間
				$begin = cacutime();
				
				//匯入學生時數
				studentHours();
				
				
				
				echo "<h2>匯入完成!</h2>";
				echo "<br />";
				
				// 結束執行時間
				$end = cacutime();
				
				// 執行花費時間
				$timediff = $end - $begin;
				echo "<h2>費時 $timediff 秒</h2>";
?>
				</div>
			</div>
		</div>
		
		<? require_once("footer.php");?>

	</body>
</html>

<?	
	
	function studentHours()
	{
		$sql = "SELECT * FROM `all_user` WHERE user_del = '0' ORDER BY `user_id` ASC";
		$ret_user = mysql_query($sql) or die(mysql_error());
		while($row_user = mysql_fetch_assoc($ret_user))
		{
			$stuid = $row_user['user_student'];
			
			$qualified  = 0;//門檻
		
			$totalHour = 0;	//總時數		
			$basicHour = 0;	//基本時數，一樣有轉時數
			$advanHour = 0;	//高階時數	
			
			$serviceHour = array(0, 0, 0, 0, 0, 0,0,0);//0服學基本、1服學高階、2生活基本、3生活高階、4人文基本、5人文高階、6國際基本、7國際高階
			
			
			/*變數count 大一週會次數*/
			$i=0;
			/*變數count 院週會次數*/
			$j=0;
			
			$career=0;//自我探索
			$cpr=0;
			
			// 取出2016-08-01前的活動資料,在周會判斷上採用名稱
			if($stuid<106000000 || $stuid>951001029 )
			{
			
				$sql = "SELECT act_id, act_title, act_type, act_begin_time, act_service_hour, act_pass_type FROM `activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%' AND act_begin_time > '2006-08-01 00:00:00' AND act_begin_time < '2016-08-01 00:00:00'
					UNION
					SELECT act_id, act_title, act_type, act_begin_time, act_service_hour, act_pass_type FROM `out_activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%'  AND act_begin_time > '2006-08-01 00:00:00' AND act_begin_time < '2016-08-01 00:00:00'
					ORDER BY `act_begin_time` DESC";
					
				$ret = mysql_query($sql) or die(mysql_error());				
				
				while($row = mysql_fetch_assoc($ret))
				{
					
					/*計算大一週會次數*/
					$tt = explode("大一週會", $row['act_title']);
					if (count($tt)>1) {
						$i++;
					}
					/*計算院週會次數*/
					$ss = explode("院週會", $row['act_title']);
					if (count($ss)>1) {
						$j++;
					}
					
					// 活動型態
					$type = "";
					switch($row['act_type']) {
						case 1:
							$type = "服務學習";
							$index = 0;
							break;
						case 2:
							$type = "生活知能";
							$index = 2;
							break;
						case 3:
							$type = "人文藝術";
							$index = 4;
							break;
						default:
							$type = "無";
					}
					
					// 時數與護照型態
					$hour = 0;
					if($row['act_service_hour'] == "-1") 
					{
						$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid' 
																   AND `ser_act_id` = '$row[act_id]'
																   AND `ser_del` = '0'";
						$ret1 = mysql_query($sql) or die(mysql_error());
						$row1 = mysql_fetch_assoc($ret1);
						$row['act_service_hour'] = $row1['ser_hour'];
					}
					/*else if($row['act_service_hour'] == "0,-1") //依個人服務時數認證沒有混合基本與高階
					{
						$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid' 
																   AND `ser_act_id` = '$row[act_id]'
																   AND `ser_del` = '0'";
						$ret1 = mysql_query($sql) or die(mysql_error());
						$row1 = mysql_fetch_assoc($ret1);
						$row['act_service_hour'] ="0,".$row1['ser_hour'];
					}*/
						//echo $row['act_title']." ".$type." ".$row['act_service_hour'].'<br>';
					
					switch($row['act_pass_type']) {
						case 1:
							$hour = "基本: ".$row['act_service_hour'];
							$totalHour += $row['act_service_hour'];
							$basicHour += $row['act_service_hour'];
							$serviceHour[$index] += $row['act_service_hour'];
							break;
						case 2:
							$hour = "高階: ".$row['act_service_hour'];
							$totalHour += $row['act_service_hour'];
							$advanHour += $row['act_service_hour'];
							$serviceHour[$index+1] += $row['act_service_hour'];
							break;
						case 3:
							$arr = explode(',', $row['act_service_hour']);
							$hour = "基本: $arr[0] <br />高階: $arr[1]";
							$totalHour += $arr[0];
							$totalHour += $arr[1];
							$basicHour += $arr[0];
							$advanHour += $arr[1];
							$serviceHour[$index] += $arr[0];
							$serviceHour[$index+1] += $arr[1];
							break;
						default:
							$hour = 0;
					}
				}
			
			}
			// 取出2016-08-01後的活動資料,在周會判斷上採用生活知能 子類別
			$sql_new = "SELECT act_id, act_title, act_type,act_life_sub , act_begin_time, act_service_hour, act_pass_type FROM `activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%' AND act_begin_time > '2016-08-01 00:00:00'
					UNION
					SELECT act_id, act_title, act_type, act_life_sub , act_begin_time, act_service_hour, act_pass_type FROM `out_activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%'  AND act_begin_time > '2016-08-01 00:00:00'
					ORDER BY `act_begin_time` DESC";
					
				$ret_new = mysql_query($sql_new) or die(mysql_error());				
				
				while($row_new = mysql_fetch_assoc($ret_new))
				{				
					
					// 活動型態
					$type = "";
					switch($row_new['act_type']) {
						case 1:
							$type = "服務學習";
							$index = 0;
							break;
						case 2:
							$type = "生活知能";
							$index = 2;
							if($row_new['act_life_sub'] == 4 )//國際視野
							{
								if($stuid>106000000 && $stuid<951001029)
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
						case 4:
							$type = "國際視野";
							$index = 6;
							break;
						default:
							$type = "無";
					}
					
					// 時數與護照型態
					$hour = 0;
					if($row_new['act_service_hour'] == "-1") //代表依個人服務時數認證
					{
						$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid' 
																   AND `ser_act_id` = '$row_new[act_id]'
																   AND `ser_del` = '0'";
						$ret1 = mysql_query($sql) or die(mysql_error());
						$row1 = mysql_fetch_assoc($ret1);
						$row_new['act_service_hour'] = $row1['ser_hour'];
					}
					/*else if($row_new['act_service_hour'] == "0,-1") 
					{
						$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid' 
																   AND `ser_act_id` = '$row_new[act_id]'
																   AND `ser_del` = '0'";
						$ret1 = mysql_query($sql) or die(mysql_error());
						$row1 = mysql_fetch_assoc($ret1);
						$row_new['act_service_hour'] ="0,".$row1['ser_hour'];
					}*/						
					
					//echo $row['act_title']." ".$type." ".$row['act_service_hour'].'<br>';
					
					switch($row_new['act_pass_type']) {
						case 1:
							$hour = "基本: ".$row_new['act_service_hour'];
							$totalHour += $row_new['act_service_hour'];
							$basicHour += $row_new['act_service_hour'];
							$serviceHour[$index] += $row_new['act_service_hour'];
							if($row_new['act_type']==2 )
							{
								if ($row_new['act_life_sub'] == 1)//大一週會
								{
									$i++;
								}
								else if($row_new['act_life_sub'] == 6)//院週會
								{									
									$j++;
								}
								else if($row_new['act_life_sub'] == 2)//CPR
								{
									$cpr+= $row_new['act_service_hour'];
								}
								else if($row_new['act_life_sub'] == 3)//自我探索
								{
									$career += $row_new['act_service_hour'];
								}
								else if($row_new['act_life_sub'] == 4 )//國際視野
								{
									if($stuid<106000000 || $stuid>951001029 )
									{
										$serviceHour[6] += $row_new['act_service_hour'];
									}
								}
							}
							break;
						case 2:
							$hour = "高階: ".$row_new['act_service_hour'];
							$totalHour += $row_new['act_service_hour'];
							$advanHour += $row_new['act_service_hour'];
							$serviceHour[$index+1] += $row_new['act_service_hour'];
							break;
						case 3:
							$arr = explode(',', $row_new['act_service_hour']);
							$hour = "基本: $arr[0] <br />高階: $arr[1]";
							$totalHour += $arr[0];
							$totalHour += $arr[1];
							$basicHour += $arr[0];
							$advanHour += $arr[1];
							$serviceHour[$index] += $arr[0];
							$serviceHour[$index+1] += $arr[1];
							if($row_new['act_type']==2 )
							{
								if ($row_new['act_life_sub'] == 1)//大一週會
								{
									$i++;
								}
								else if($row_new['act_life_sub'] == 6)//院週會
								{
									$j++;
								}
								else if($row_new['act_life_sub'] == 2)//CPR
								{
									$cpr+= $arr[0];
								}
								else if($row_new['act_life_sub'] == 3)//自我探索
								{
									$career += $arr[0];
								}
								else if($row_new['act_life_sub'] == 4 )//國際視野
								{
									if($stuid<106000000 || $stuid>951001029 ) //106以後入學的已經在上面的index+1計算過了，所以是106以前的人再加
									{
										$serviceHour[6] += $arr[0];
										$serviceHour[7] += $arr[1];
									}
								}
							}
							break;
						default:
							$hour = 0;
					}
					
					
				}
				
			if($stuid<103999999 || $stuid>951001029 )
				{				
					if(ceil($serviceHour[0])>=50 && ceil($serviceHour[2])>=30 && ceil($serviceHour[4])>=20)
					$qualified  = 1;
				}
			else if ($stuid<104999999)
			{
				if($i>=4 && $j>=2 && ceil($serviceHour[0])>=50 && ceil($serviceHour[2])>=30 && ceil($serviceHour[4])>=20)
					$qualified  = 1;
			}
			else if($stuid<105999999)
			{
				$qualified  = 1;
				if($i<4 || $j<2 || ceil($serviceHour[4])<20 || ceil($serviceHour[0])<40 || ceil($serviceHour[2])<40 || $career<10 || $cpr<5 || ceil($serviceHour[6])<5) 
				{
					$qualified  = 0;
				}				
			}
			else if($stuid>=106000000 && $stuid<951001029)
			{
				$qualified  = 1;
				if($i<4 || $j<2 || ceil($serviceHour[4])<20 || ceil($serviceHour[0])<40 || ceil($serviceHour[2])<35 || $career<10 || $cpr<5  || ceil($serviceHour[6])<5) 
				{
					$qualified  = 0;
				}				
			}
			
				
			//轉時數
			$b1=$serviceHour[0];			$a1=$serviceHour[1];
			$b2=$serviceHour[2];			$a2=$serviceHour[3];
			$b3=$serviceHour[4];			$a3=$serviceHour[5];
			$b4=$serviceHour[6];			$a4=$serviceHour[7];
			
			if($b1 > 50){
				$a1 += $b1 - 50;
				$b1 = 50;
			}
			if($b2 > 30){
				$a2 += $b2 - 30;
				$b2 = 30;
			}
			if($b3 > 20){
				$a3 += $b3 - 20;
				$b3 = 20;
			}
			if($b4 > 5){
				$a4 += $b4 - 5;
				$b4 = 5;
			}
				
			$basicHour = $b1 + $b2 +$b3;
			
			if($stuid>=106000000 && $stuid<951001029){
				$basicHour += b4;
			}
			//轉時數
			
			
			// 總時數, 基本, 高階
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
							`cpr` = '$cpr',
							qualified = '$qualified'							
					WHERE `user_student` = '$stuid' AND `user_del` = '0'
					";
			$ret_u = mysql_query($sql_u) or die(mysql_error());
			
			
			
		}
	}
	
	
	function studentHours___old()
	{
		$sql = "SELECT * FROM `all_user` WHERE user_del = '0' ORDER BY `user_id` ASC";
		$ret_user = mysql_query($sql) or die(mysql_error());
		while($row_user = mysql_fetch_assoc($ret_user))
		{
			$stuid = $row_user['user_student'];
		
			// 取出活動資料
			$sql = "SELECT act_id, act_title, act_type, act_begin_time, act_service_hour, act_pass_type FROM `activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%' 
				UNION
				SELECT act_id, act_title, act_type, act_begin_time, act_service_hour, act_pass_type FROM `out_activity` WHERE act_del = '0' AND act_admit_student LIKE '%$stuid%'
				ORDER BY `act_begin_time` DESC";
				
			$ret = mysql_query($sql) or die(mysql_error());
			
			$totalHour = 0;			
			$basicHour = 0;			
			$advanHour = 0;
		
			
			$serviceHour = array(0, 0, 0, 0, 0, 0);
			
			/*變數count 大一週會次數*/
			$i=0;
			/*變數count 院週會次數*/
			$j=0;
			
			
			while($row = mysql_fetch_assoc($ret))
			{
				/*計算大一週會次數*/
				$tt = explode("大一週會", $row['act_title']);
				if (count($tt)>1) {
					$i++;
				}
				/*計算院週會次數*/
				$ss = explode("院週會", $row['act_title']);
				if (count($ss)>1) {
					$j++;
				}
				
				// 活動型態
				$type = "";
				switch($row['act_type']) {
					case 1:
						$type = "服務學習";
						$index = 0;
						break;
					case 2:
						$type = "生活知能";
						$index = 2;
						break;
					case 3:
						$type = "人文藝術";
						$index = 4;
						break;
					default:
						$type = "無";
				}
				
				// 時數與護照型態
				$hour = 0;
				if($row['act_service_hour'] == "-1" )
				{
					$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid' 
															   AND `ser_act_id` = '$row[act_id]'
															   AND `ser_del` = '0'";
					$ret1 = mysql_query($sql) or die(mysql_error());
					$row1 = mysql_fetch_assoc($ret1);
					$row['act_service_hour'] = $row1['ser_hour'];
				}
				/*else if($row['act_service_hour'] == "0,-1") //依個人服務時數認證沒有混合基本與高階
				{
					$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid' 
															   AND `ser_act_id` = '$row[act_id]'
															   AND `ser_del` = '0'";
					$ret1 = mysql_query($sql) or die(mysql_error());
					$row1 = mysql_fetch_assoc($ret1);
					$row['act_service_hour'] ="0,".$row1['ser_hour'];
				}*/						
				
				switch($row['act_pass_type']) {
					case 1:
						$hour = "基本: ".$row['act_service_hour'];
						$totalHour += $row['act_service_hour'];
						$basicHour += $row['act_service_hour'];
						$serviceHour[$index] += $row['act_service_hour'];
						break;
					case 2:
						$hour = "高階: ".$row['act_service_hour'];
						$totalHour += $row['act_service_hour'];
						$advanHour += $row['act_service_hour'];
						$serviceHour[$index+1] += $row['act_service_hour'];
						break;
					case 3:
						$arr = explode(',', $row['act_service_hour']);
						$hour = "基本: $arr[0] <br />高階: $arr[1]";
						$totalHour += $arr[0];
						$totalHour += $arr[1];
						$basicHour += $arr[0];
						$advanHour += $arr[1];
						$serviceHour[$index] += $arr[0];
						$serviceHour[$index+1] += $arr[1];
						break;
					default:
						$hour = 0;
				}
			}
			
			$qualified  =0;
			if( !$serviceHour[0]<50 && !$serviceHour[2]<30 && !$serviceHour[4]<20)
			{
				$qualified  = 1;
			}
			
			//轉時數
			$b1=$serviceHour[0];$a1=$serviceHour[1];
			$b2=$serviceHour[2];$a2=$serviceHour[3];
			$b3=$serviceHour[4];$a3=$serviceHour[5];
			
			
			if($b1 > 50){
				$a1 += $b1 - 50;
				$b1 = 50;
			}
			if($b2 > 30){
				$a2 += $b2 - 30;
				$b2 = 30;
			}
			if($b3 > 20){
				$a3 += $b3 - 20;
				$b3 = 20;
			}
			$basicHour = $b1 + $b2 +$b3;
			//轉時數
			
			// 總時數, 基本, 高階
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
							`assembly_freshman`= '$i',
							`assembly_dep`= '$j',							
							qualified = '$qualified'							
					WHERE `user_student` = '$stuid' AND `user_del` = '0'
					";
			$ret_u = mysql_query($sql_u) or die(mysql_error());
			
			
			
		}
	}
	
	
	
	
	function cacutime()
	{	
		$time = explode(" ", microtime());
		$usec = (double)$time[0];
		$sec = (double)$time[1];
		
		return $sec + $usec; 
	}

?>
