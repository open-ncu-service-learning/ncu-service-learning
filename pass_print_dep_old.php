<?php
	session_start();
	
	// ȭŀƧĒ
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	//ԝʷѵǦω̰֡֌ͭŪ
	set_time_limit(0); 
	
	require_once("conn/db.php");
	require_once("function_lib.php");
	
	if(isset($_POST['pass_stuid']))
		$stuid = trim($_POST['pass_stuid'], " ");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>學生護照預警系統統計表</title>
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
	if($semester >= 100)
		$str = 3;
	else
		$str = 2;
	
	$ncu = array( "1001", "1002", "1003", "2002", "2001", "2003", "2004", 
				  "2006", "2008", "3004", "3002", "3003", "4001", "4003", 
				  "4008", "4009", "5001", "5002", "5003", "6002", "6001" );	
	//$ncu = array( "4001", "4003", "4008" );
	$k = 0;
	$len = count($ncu);
	//len = 2;
	for($k; $k < 1; $k++)
	{
		unset($stuid);
		unset($name);
		unset($arr);
		
		// 取出學系
		/*$sql = "SELECT user_dep FROM all_user WHERE user_dep_id = $ncu[$k]";
		if($ret = mysql_query($sql))
		{
			$dep = '';
			while($row = mysql_fetch_assoc($ret))
				$dep = $row['user_dep'];
		}*/
		
		$sql = "SELECT user_dep FROM all_user WHERE user_dep_id = '$_GET[dep]' LIMIT 1,1";
		$ret = mysql_query($sql);
		$row = mysql_fetch_assoc($ret);
		$dep = $row['user_dep'];

		// 取出學生
		$sql = "SELECT user_student,user_name FROM all_user WHERE user_dep_id = $_GET[dep] AND SUBSTR(user_student,1,$str) =$semester  AND user_status = 0 ORDER BY user_student ASC";//AND user_basicHour<100 
		
		if($ret = mysql_query($sql))
		{
			$i = 0;
			while($row = mysql_fetch_assoc($ret))
			{
				$stuid[$i] = $row['user_student'];
				$name[$i] = $row['user_name'];
				$i++;
				 
			}
		}
		$i = 0;
		$length = count($stuid);
		
		//$length = 1;
		for($i; $i < $length; $i++)
		{
			// 取出活動資料
			$sql = "SELECT `act_id`, `act_title`, `act_type`, `act_begin_time`, `act_service_hour`, `act_pass_type` FROM `activity` WHERE `act_del` = '0' AND `act_admit_student` LIKE '%$stuid[$i]%'  UNION
				SELECT `act_id`, `act_title`, `act_type`, `act_begin_time`, `act_service_hour`, `act_pass_type` FROM `out_activity` WHERE `act_del` = '0' AND `act_admit_student` LIKE '%$stuid[$i]%'
				ORDER BY `act_begin_time` DESC";
			
			$ret = mysql_query($sql) or die(mysql_error());
			$totalHour[$i] = 0;
			//ser_basic, ser_advan, life_basic, life_advan, art_basic, art_advan 
			$serviceHour[$i] = array(0, 0, 0);
			
			while($row = mysql_fetch_assoc($ret))
			{
				// 活動型態
				$type = "";
				switch($row['act_type']) {
					case 1:
						$type = "服務學習";
						$index = 0;
						break;
					case 2:
						$type = "生活知能";
						$index = 1;
						break;
					case 3:
						$type = "人文藝術";
						$index = 2;
						break;
					default:
						$type = "無";
				}
				
				//  時數與護照型態
				if($row['act_service_hour']== "-1") {
					$sql = "SELECT * FROM `service_activity` WHERE `ser_stu_id` = '$stuid[$i]' 
															   AND `ser_act_id` = '$row[act_id]'
															   AND `ser_del` = '0'";
					$ret1 = mysql_query($sql) or die(mysql_error());
					$row1 = mysql_fetch_assoc($ret1);
					$row['act_service_hour'] = $row1['ser_hour'];
				}		
				
				switch($row['act_pass_type']) {
					case 1:
						
						$serviceHour[$i][$index] += $row['act_service_hour'];
						break;
					case 3:
						$arr = explode(',', $row['act_service_hour']);
						$serviceHour[$i][$index] += $arr[0];
						
						break;
						
					default:
						$totalHour[$i] = 0;
				}
			}
			
			
			if($serviceHour[$i][0]>50){
				//$serviceHour[$i][1]+=$serviceHour[$i][0]-50;
				$serviceHour[$i][0]=50;
			}
			if($serviceHour[$i][1]>30){
				//$serviceHour[$i][3]+=$serviceHour[$i][2]-30;
				$serviceHour[$i][1]=30;
			}
			if($serviceHour[$i][2]>20){
				//$serviceHour[$i][5]+=$serviceHour[$i][4]-20;
				$serviceHour[$i][2]=20;
			}
			// 計算總和
			$totalHour[$i] = $serviceHour[$i][0]+$serviceHour[$i][1]+$serviceHour[$i][2];
		}
?>
	<table width="1000" align="center" border="0">
			<tr align="center">
				<td><strong style="font-size: 14pt;">國立中央大學學生學習護照<span style="color: red;"><?php echo $dep; ?></span>預警系統時數統計表</strong></td>
			</tr>
			<tr align="right">
				<td>統計日期: <?=$today ?></td>
			</tr>
		</table>
		<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr align="center">
				<td width="100" rowspan="2">學號</td>
				<td width="180" rowspan="2"><p>姓名/應完成時數</p></td>
				<td width="600" colspan="6">基本</td>
				<td width="120" rowspan="2">基本總時數</td>
			</tr>
			<tr align="center">
				<td width="220" colspan="2" >服務學習</td>
				<td width="220" colspan="2" >生活知能</td>
				<td width="160" colspan="2" >人文藝術</td>
			</tr>
			
<?
	$i = 0;

	for($i; $i < $length; $i++)
	{
		// 判斷是否達到各項基本標準
			$service	= 50;
			$life		= 30;
			$art		= 20;
			
			
			if($serviceHour[$i][0] >= $service && $serviceHour[$i][1] >= $life && $serviceHour[$i][2] >= $art){
				$standard = 1;
			}else{
				$standard = 0;
			}
			if($standard == 0){
?>				
		<tr align="center">
				<td><?=$stuid[$i]?></td>
				<td><?=$name[$i]?></td>
				<td colspan="2"><?=$serviceHour[$i][0]?></td>
				<td colspan="2"><?=$serviceHour[$i][1]?></td>
				<td colspan="2"><?=$serviceHour[$i][2]?></td>
			
				<td><?=$totalHour[$i]?></td>
		</tr>
<?
			}
		


	}
	echo "</table>";			
}
require_once("pass_hour_query_function.php");
for($i=0; $i < $length; $i++)
{
	// 判斷是否達到各項基本標準
	$service	= 50;

	$life		= 30;
	$art		= 20;
			
			
	if($serviceHour[$i][0] >= $service && $serviceHour[$i][1] >= $life && $serviceHour[$i][2] >= $art)
	{
		$standard = 1;
	}else
	{
		$standard = 0;
	}
	if($standard==0)
	{
		query_one($stuid[$i]);
	}
}
?>
	</body>
</html>