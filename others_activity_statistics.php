<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	require_once("function_lib.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>活動報表</title>
		<script LANGUAGE='JavaScript'>
			function printPage() {
			   window.print();
			}
		</script>
	</head>
	<body onLoad='printPage()'>
	
<?php
	require_once("conn/db.php");
	
	// 時間
	$year = date("Y")-1911;
	$today = $year.date("md");
	
	//年度
	$semester = $_GET['semester'];
	$ADsemester = $semester + 1911;
	$ADsemester_1 = $ADsemester + 1;
	if($semester >= 100)
		$index = 3;
	else
		$index = 2;
?>
<table width="1000" align="center" border="0">
			<tr align="center">
				<td><strong style="font-size: 14pt;">國立中央大學學生學習護照<span style="color: red;"><?=$semester?></span>年度 活動時數統計表</strong></td>
			</tr>
			<tr align="right">
				<td>統計日期: <?=$today ?></td>
			</tr>
		</table>
		<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr align="center">
				<td width="100">辦理活動單位</td>
				<td width="100">類別</td>
				<td width="300">活動名稱</td>
				<td width="100">活動日期</td>
				<!--<td width="100">活動數量</td>-->
				<td width="100">基本時數</td>
				<td width="100">高階時數</td>
				<td width="100">認證人數</td>
			</tr>
<?	
	//活動
	$sql = "SELECT act_id,act_title,act_begin_time,act_end_time,act_type,act_service_hour,act_pass_type,act_admit_student,act_req_office FROM `activity` WHERE `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_admit` = 1 ORDER BY act_req_office,act_type,act_begin_time DESC";
	$ret = mysql_query($sql) or die(mysql_error());
	$actNumber = mysql_num_rows($ret);
	$l_s =0;
	$l_l =0;
	$l_h =0;
	$hour_s=0;
	$hour_l=0;
	$hour_h=0;
	
	if($actNumber > 0)
	{
		while($row = mysql_fetch_assoc($ret))
		{	
			//活動單位
			if($dep_temp == $row['act_req_office'])
			{
				//$actOffice = "&nbsp";
				$num = "&nbsp";
			}
			else
			{
				$actOffice = $row['act_req_office'];
				//活動數量
				$sql = "SELECT count(act_id) AS num FROM activity WHERE `act_req_office` LIKE '$actOffice' AND `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_admit` = 1";
				$ret1 = mysql_query($sql) or die(mysql_error());
				$row1 = mysql_fetch_assoc($ret1);
				$num= $row1['num'];
			}			
			
			
			//活動類別
			if($type_temp == $row['act_type'] && $dep_temp == $row['act_req_office'])
			{
				//$type = "&nbsp";
			}
			else
			{
				switch($row['act_type'])
				{
					case 1:
						$type = "服務學習";
						break;
					case 2:
						$type = "生活知能";
						break;
					case 3:
						$type = "人文藝術";
						break;
					default:
						$type = "";
				}
			}
			$dep_temp = $row['act_req_office'];
			$type_temp = $row['act_type'];
			
			//活動日期
			$begin_time = substr($row['act_begin_time'],0,10);
			$end_time = substr($row['act_end_time'],0,10);
			if($begin_time == $end_time)
				$time = $begin_time;
			else
				$time = $begin_time . "-" . $end_time;
				
			// 時數與護照型態
			if($row['act_service_hour']== "-1") {
				$sql = "SELECT count(ser_stu_id) as c FROM `service_activity` WHERE `ser_act_id` = '$row[act_id]' AND `ser_del` = '0'";
				$ret2 = mysql_query($sql) or die(mysql_error());
				$row2 = mysql_fetch_assoc($ret2);
				$service_length= $row2['c'];
			}	
				
			//活動時數
			unset($arr);
			switch($row['act_pass_type'])
			{
				case 1:
					$basic = $row['act_service_hour'];
					$high = 0;
					break;
				case 2:
					$basic = 0;
					$high = $row['act_service_hour'];
					break;
				case 3:
					$arr = explode(',', $row['act_service_hour']);
					$basic = $arr[0];
					$high = $arr[1];
					break;
				default:
					$basic = 0;
					$high = 0;
			}
			
			
			
			//認證人數
			unset($arr1);
			$arr1 = explode(',', $row['act_admit_student']);
			$length = count($arr1);
			
			
			if($row['act_service_hour']== "-1") {
				
				$service_hour=0;
				$sql = "SELECT SUM( `ser_hour` ) as amount
						FROM  `service_activity` 
						WHERE  `ser_act_id` ='$row[act_id]' AND `ser_del` = '0'";
				$ret1 = mysql_query($sql) or die(mysql_error());
				$row1 = mysql_fetch_assoc($ret1);
				$service_hour = $row1['amount'];
				$basic = $service_hour/$length ;//依時數認證全部人的總時數/人數(即平均)
				$high = 0;
			}
			
			
			
?>
			<tr align="center">
				<td><?=$actOffice?></td>
				<td><?=$type?></td>
				<td><?=$row['act_title']?></td>
				<td><?=$time?></td>
				<!--<td><?//=$num?></td>-->
				<td><?=round($basic)?></td>
				<td><?=round($high)?></td>
				<td><?=$length?></td>
			</tr>
<?		
		//計算認證人數與時數
		switch($row['act_type'])
				{
					case 1:
						$l_s += $length;
						if($row['act_service_hour']!= "-1")
						{
							$hour_s += $basic+$high; 
						}
						break;
					case 2:
						$l_l += $length;
						if($row['act_service_hour']!= "-1")
						{
							$hour_l += $basic+$high; 
						}
						break;
					case 3:
						$l_h += $length;
						if($row['act_service_hour']!= "-1")
						{
							$hour_h += $basic+$high; 
						}
						break;
					default:
						$type = "";
				}
		//計算活動場次
		/*人文*/
		$sqlh = "SELECT COUNT( act_id ) AS num
				FROM activity
				WHERE  `act_type` = 3
				AND  `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_admit` = 1";
		$reth = mysql_query($sqlh) or die(mysql_error());
		$rowh = mysql_fetch_assoc($reth);
		$num_h= $rowh['num'];
		/*生活*/
		$sqll = "SELECT COUNT( act_id ) AS num
				FROM activity
				WHERE  `act_type` = 2
				AND  `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_admit` = 1";
		$retl = mysql_query($sqll) or die(mysql_error());
		$rowl = mysql_fetch_assoc($retl);
		$num_l= $rowl['num'];
		/*服務*/
		$sqls = "SELECT COUNT( act_id ) AS num
				FROM activity
				WHERE  `act_type` = 1
				AND  `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_admit` = 1";
		$rets = mysql_query($sqls) or die(mysql_error());
		$rows = mysql_fetch_assoc($rets);
		$num_s= $rows['num'];
		}
	}
?>
	</table>
	
	<table width="1000" align="center" border="0">
			<tr align="center">
				<td><strong style="font-size: 14pt;">國立中央大學學生學習護照<span style="color: red;"><?=$semester?></span>年度 依類別統計表</strong></td>
			</tr>
			<tr align="right">
				<td>統計日期: <?=$today ?></td>
			</tr>
		</table>
		<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr align="center">
				<td width="100" ></td>
				<td width="200" >活動場次</td>
				<td width="150" >認證人數</td>
				<td width="150" >認證時數</td>
			</tr>
			<tr align="center">
				<td width="100" >人文藝術</td>
				<td width="200" ><?=$num_h?></td>
				<td width="150" ><?=$l_h?></td>
				<td width="150" ><?=$hour_h?></td>
			</tr>
			<tr align="center">
				<td width="100" >生活知能</td>
				<td width="200" ><?=$num_l?></td>
				<td width="150" ><?=$l_l?></td>
				<td width="150" ><?=$hour_l?></td>
			</tr>
			<tr align="center">
				<td width="100" >服務學習</td>
				<td width="200" ><?=$num_s?></td>
				<td width="150" ><?=$l_s?></td>
				<td width="150" ><?=$hour_s?></td>
			</tr>
		</table>
	</body>
</html>