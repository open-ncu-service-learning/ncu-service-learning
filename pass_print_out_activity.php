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
		<!--<script LANGUAGE='JavaScript'>
			function printPage() {
			   window.print();
			}
		</script>-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="./FileSaver.js-master/FileSaver.min.js"></script>
		<script>
			$(document).ready(function(){
				$('button').removeAttr('disabled');
				$('#load').html('finish');
				$('#print').click(function printPage(){
					window.print();
				})
				$('#xsl').click(function () {
					var title = document.getElementById('a').innerHTML.split(" ");
					var year = document.getElementById('b').innerHTML;
					var blob = new Blob([document.getElementById('outputData').innerHTML], {
						type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
					});
					var strFile = year+title[4]+".xls";
					saveAs(blob, strFile);
					return false;
				});
			})
		</script>
	</head>
	<body>
	
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
	<div>
		<td><button id="print" disabled>pdf / printer</button></td>
		<td><button id="xsl" disabled>excel</button></td>
		<td><a id="load">loading...</a></td>
	</div>
	<div id="outputData">
		<table width="1000" align="center" border="0">
			<tr align="center">
				<td><strong style="font-size: 14pt;" id="a">國立中央大學學生學習護照<span style="color: red;" id="b"><?=$semester?></span>年度 個人申請活動時數統計表</strong></td>
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
				<!--<td width="100">認證人數</td>-->
			</tr>
<?	
	//活動
	$sql = "SELECT act_id,act_title,act_begin_time,act_end_time,act_type,act_life_sub,act_service_hour,act_pass_type,act_req_office FROM `out_activity` WHERE `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_del` = 0 AND `act_admit` = '1' ORDER BY act_req_office,act_type,act_begin_time DESC";
	$ret = mysql_query($sql) or die(mysql_error());
	$actNumber = mysql_num_rows($ret);
	
	//依類別統計參數
	$num_h=0;
	$num_s=0;
	$num_l=0;
	$num_i=0;
	$hour_s=0;
	$hour_l=0;
	$hour_h=0;
	$hour_i=0;
	
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
				/*$sql = "SELECT count(act_id) AS num FROM out_activity WHERE `act_req_office` LIKE '%$actOffice%' AND `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' ";
				$ret1 = mysql_query($sql) or die(mysql_error());
				$row1 = mysql_fetch_assoc($ret1);
				$num= $row1['num'];*/
			}			
			
			
			//活動類別
			switch($row['act_type'])
			{
				case 1:
					$type = "服務學習";
					break;
				case 2:
					$type = "生活知能";
					if($row['act_life_sub']==4 && $semester>=107)
						$type = "國際視野";
					break;
				case 3:
					$type = "人文藝術";
					break;
				case 4:
					$type = "國際視野";
					break;
				default:
					$type = "";
			}
			$dep_temp = $row['act_req_office'];
			
			//活動日期
			$begin_time = substr($row['act_begin_time'],0,10);
			$end_time = substr($row['act_end_time'],0,10);
			if($begin_time == $end_time)
				$time = $begin_time;
			else
				$time = $begin_time . "-" . $end_time;
				
			// 時數與護照型態
			if($row['act_service_hour']== "-1") {
				$sql = "SELECT count(ser_stu_id) as num FROM `service_activity` WHERE `ser_act_id` = '$row[act_id]' AND `ser_del` = '0'";
				$ret2 = mysql_query($sql) or die(mysql_error());
				$row2 = mysql_fetch_assoc($ret2);
				$length= $row1['num'];
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
			
			if($row['act_service_hour']== "-1") {
				$basic = "*";
				$high = "*";
			}
			
			/*
			//認證人數
			unset($arr1);
			$arr1 = explode(',', $row['act_admit_student']);
			$length = count($arr1);
			*/
?>
			<tr align="center">
				<td><?=$actOffice?></td>
				<td><?=$type?></td>
				<td><?=$row['act_title']?></td>
				<td><?=$time?></td>
				<!--<td><?//=$num?></td>-->
				<td><?=round($basic)?></td>
				<td><?=round($high)?></td>
				<!--<td><?//=$length?></td>-->
			</tr>
<?	
		//計算認證時數
		switch($row['act_type'])
				{
					case 1:
						
						if($row['act_service_hour']!= "-1")
						{
							$hour_s += round($basic)+round($high); 
						}
						break;
					case 2:
						
						if($row['act_service_hour']!= "-1")
						{
							if($row['act_life_sub'] == 4 && $semester>=107)
								$hour_i += round($basic)+round($high);
							else
								$hour_l += round($basic)+round($high); 
						}
						break;
					case 3:
						
						if($row['act_service_hour']!= "-1")
						{
							$hour_h += round($basic)+round($high); 
						}
						break;
					case 4:
						
						if($row['act_service_hour']!= "-1")
						{
							$hour_i += round($basic)+round($high); 
						}
						break;
					default:
						$type = "";
				}
		
		//計算活動場次
		/*人文*/
		$sqlh = "SELECT count(act_id) AS num FROM out_activity WHERE `act_type` = 3 AND `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_del` = 0 AND `act_admit` = '1'";
		$reth = mysql_query($sqlh) or die(mysql_error());
		$rowh = mysql_fetch_assoc($reth);
		$num_h= $rowh['num'];
		/*生活*/
		$sqll = "SELECT count(act_id) AS num FROM out_activity WHERE `act_type` = 2 AND `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_del` = 0 AND `act_admit` = '1'";
		if($semester>=107)
			$sqll = "SELECT count(act_id) AS num FROM out_activity WHERE `act_type` = 2 AND `act_life_sub` != 4 AND `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_del` = 0 AND `act_admit` = '1'";
		$retl = mysql_query($sqll) or die(mysql_error());
		$rowl = mysql_fetch_assoc($retl);
		$num_l= $rowl['num'];
		/*服務*/
		$sqls = "SELECT count(act_id) AS num FROM out_activity WHERE `act_type` = 1 AND `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_del` = 0 AND `act_admit` = '1'";
		$rets = mysql_query($sqls) or die(mysql_error());
		$rows = mysql_fetch_assoc($rets);
		$num_s= $rows['num'];//var_dump($num_s->act_title)
		/*國際*/
		$sqli = "SELECT count(act_id) AS num FROM out_activity WHERE `act_type` = 2 AND `act_life_sub` = 4 AND `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_del` = 0 AND `act_admit` = '1'";
		$reti = mysql_query($sqli) or die(mysql_error());
		$rowi = mysql_fetch_assoc($reti);
		$num_i= $rowi['num'];
		$sqli = "SELECT count(act_id) AS num FROM out_activity WHERE `act_type` = 4 AND `act_begin_time` between '$ADsemester-08-01 00:00:00' and '$ADsemester_1-07-31 00:00:00' AND `act_del` = 0 AND `act_admit` = '1'";
		$reti = mysql_query($sqli) or die(mysql_error());
		$rowi = mysql_fetch_assoc($reti);
		$num_i+= $rowi['num'];
		}
		//it seems that這裡開始有問題
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
				<td width="150" >認證時數</td>
				<td width="150" >人時數</td>
			</tr>
			<tr align="center">
				<td width="100" >人文藝術</td>
				<td width="200" ><?=$num_h?></td>
				<td width="150" ><?=$hour_h?></td>
				<td width="150" ><?=$hour_h?></td>
			</tr>
			<tr align="center">
				<td width="100" >生活知能</td>
				<td width="200" ><?=$num_l?></td>
				<td width="150" ><?=$hour_l?></td>
				<td width="150" ><?=$hour_l?></td>
			</tr>
			<tr align="center">
				<td width="100" >服務學習</td>
				<td width="200" ><?=$num_s?></td>
				<td width="150" ><?=$hour_s?></td>
				<td width="150" ><?=$hour_s?></td>
			</tr>
			<?if($semester>=107){?>
			<tr align="center">
				<td width="100" >國際視野</td>
				<td width="200" ><?=$num_i?></td>
				<td width="150" ><?=$hour_i?></td>
				<td width="150" ><?=$hour_i?></td>
			</tr>
			<?}?>
		</table>
	</div>
</body>
</html>