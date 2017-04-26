<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	//設定執行時間為無限大
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
		<title>學生護照時數統計表</title>
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
	
	$ncu = array( "1001", "1002", "1003", "2002", "2001", "2003", "8001", 
				  "2006", "2008", "3004", "3002", "3003", "4001", "4003", 
				  "4008", "4009", "5001", "5002", "5003", "6002", "6001" );	
	//$ncu = array( "4001", "4003", "4008" );
	$k = 0;
	$len = count($ncu);
	//len = 2;
	for($k; $k < $len; $k++)
	{
		unset($stuid);
		unset($name);
		unset($arr);
		
		// 取出學系
		$sql = "SELECT user_dep FROM all_user WHERE user_dep_id = $ncu[$k]";
		if($ret = mysql_query($sql))
		{
			$dep = '';
			while($row = mysql_fetch_assoc($ret))
				$dep = $row['user_dep'];
		}

		// 取出學生
		$sql = "SELECT user_student,user_name FROM all_user WHERE user_dep_id = $ncu[$k] AND SUBSTR(user_student,1,$str) =$semester  AND user_status = 0 ORDER BY user_student ASC";
		
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
			$sql = "SELECT `act_id`, `act_title`, `act_type`, `act_begin_time`, `act_service_hour`, `act_pass_type` FROM `activity` WHERE `act_del` = '0' AND `act_admit_student` LIKE '%$stuid[$i]%' UNION
				SELECT `act_id`, `act_title`, `act_type`, `act_begin_time`, `act_service_hour`, `act_pass_type` FROM `out_activity` WHERE `act_del` = '0' AND `act_admit_student` LIKE '%$stuid[$i]%'
				ORDER BY `act_begin_time` DESC";
			
			$ret = mysql_query($sql) or die(mysql_error());
			$totalHour[$i] = 0;
			
			$serviceHour[$i] = array(0, 0, 0, 0);
			
			while($row = mysql_fetch_assoc($ret))
			{
				// 活動型態
				$type = "";
				switch($row['act_type']) {
					case 1:
						$type = "服務學習";
						$index = 1;
						break;
					case 2:
						$type = "生活知能";
						$index = 2;
						break;
					case 3:
						$type = "人文藝術";
						$index = 3;
						break;
					default:
						$type = "無";
				}
				
				// 時數與護照型態
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

						

						if($row['act_service_hour'] == 40)
							$serviceHour[$i][$index-1] = $row['act_service_hour'];
						elseif($row['act_id']==7645 || $row['act_id']==6708  || $row['act_id']==6707 || $row['act_id']==6862 || $row['act_id']==7689 || $row['act_id']==7690 || $row['act_id']==6852 || $row['act_id']==6856) 
							$serviceHour[$i][$index-1] += $row['act_service_hour'];
						else
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
			
			//判斷基本時數
			if($serviceHour[$i][1] > 10)
				$serviceHour[$i][1] = 10;
			if($serviceHour[$i][2] > 30)
				$serviceHour[$i][2] = 30;
			if($serviceHour[$i][3] > 20)
				$serviceHour[$i][3] = 20;

			// 總時數
			$totalHour[$i] = $serviceHour[$i][0]+$serviceHour[$i][1]+$serviceHour[$i][2]+$serviceHour[$i][3];
		}
?>
	<table width="1000" align="center" border="0">
			<tr align="center">
				<td><strong style="font-size: 14pt;">國立中央大學學生學習護照<span style="color: red;"><?=$dep?></span>時數統計表</strong></td>
			</tr>
			<tr align="right">
				<td>統計日期: <?=$today ?></td>
			</tr>
		</table>
		<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr align="center">
				<td width="100" rowspan="4">學號</td>
				<td width="180" rowspan="4"><p>姓名/應完成時數</p></td>
				<td width="600" colspan="6">基本</td>
				<td width="120" rowspan="3">基本總時數</td>
			</tr>
			<tr align="center">
				<td width="220" colspan="2">服務學習</td>
				<td width="220" colspan="2" rowspan="2">生活知能</td>
				<td width="160" colspan="2" rowspan="2">人文藝術</td>
			</tr>
			<tr align="center">
				<td width="100">課程</td>
				<td width="120">校外服務</td>
			</tr>
			<tr align="center">
				<td>40</td>
				<td>10</td>
				<td colspan="2">30</td>
				<td colspan="2">20</td>
				<td>100</td>
<?
	$i = 0;
	$t_ser1 = 0;
	$t_ser2 = 0;
	$t_life=0;
	$t_art = 0;
	$t_sum = 0;
	for($i; $i < $length; $i++)
	{
?>				
		<tr align="center">
				<td><?=$stuid[$i]?></td>
				<td><?=$name[$i]?></td>
				<td><?=$serviceHour[$i][0]?></td>
				<td><?=$serviceHour[$i][1]?></td>
				<td colspan="2"><?=$serviceHour[$i][2]?></td>
				<!--<td><?//=$life1[$i]?></td>-->
				<!-- <td colspan="2"><?//=$life2[$i]?></td> -->
				<td colspan="2"><?=$serviceHour[$i][3]?></td>
				<td><?=$totalHour[$i]?></td>
			</tr>
<?
		$t_ser1 += $serviceHour[$i][0];
		$t_ser2 += $serviceHour[$i][1];
		$t_life += $serviceHour[$i][2];
		$t_art += $serviceHour[$i][3];
		$t_sum += $totalHour[$i];	
	}

	$avg_ser1 = 0;
	$avg_ser2 = 0;
	$avg_life = 0;
	$avg_art = 0;
	$avg_sum = 0;
	
	$avg_ser1 = $t_ser1 / $length;
	$avg_ser2 = $t_ser2 / $length;
	$avg_life = $t_life / $length;
	$avg_art = $t_art / $length;
	$avg_sum = $t_sum / $length;
	
	$chart[] = round($avg_ser1, 1);
	$chart[] = round($avg_ser2, 1);
	$chart[] = round($avg_life,1);
	$chart[] = round($avg_art, 1);
	$chart[] = round($avg_sum, 1);
?>
			<tr align="center">
				<td colspan="2">平均</td>
				<td><?=round($avg_ser1, 1)?></td>
				<td><?=round($avg_ser2, 1)?></td>
				<td colspan="2"><?=round($avg_life,1)?></td>
				<td colspan="2"><?=round($avg_art, 1)?></td>
				<td><?=round($avg_sum, 1)?></td>
			</tr>
		</table>
		<P style='page-break-after:always'></P>
<?php
}
?>
		<table width="1000" align="center" border="0">
			<tr align="center">
				<td><strong style="font-size: 14pt;">國立中央大學<?echo $semester;?>級各院系 學生學習護照平均認證基本時數統計表</strong></td>
			</tr>
			<tr align="right">
				<td>統計日期: <?=$today ?></td>
			</tr>
		</table>
		<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr align="center">
				<td width="100" rowspan="4">院別</td>
				<td width="200" rowspan="4">系別</td>
				<td width="150" rowspan="4">級別/畢業應達時數</td>
				<td width="440" colspan="4">基本時數</td>
				<td width="100" rowspan="3">合計</td>
			</tr>
			<tr align="center">
				<td colspan="2">服務學習</td>
				<td rowspan="2">生活知能</td>
				<td rowspan="2">人文藝術</td>
			</tr>
			<tr align="center">
				<td>課程</td>
				<td>校外服務</td>
			</tr>
			<tr align="center">
				<td width="60">40</td>
				<td width="90">10</td>
				<td width="150">30</td>
				<td width="150">20</td>
				<td width="100">100</td>
			</tr>
			<tr align="center">
				<td rowspan="3">文學院</td>
				<td>中國文學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[0]?></td>
				<td><?=$chart[1]?></td>
				<td><?=$chart[2]?></td>
				<td><?=$chart[3]?></td>
				<td><?=$chart[4]?></td>
				
			</tr>
			<tr align="center">
				<td>英美語文系</td>
				<td><?=$semester?></td>
				<td><?=$chart[5]?></td>
				<td><?=$chart[6]?></td>
				<td><?=$chart[7]?></td>
				<td><?=$chart[8]?></td>
				<td><?=$chart[9]?></td>

			</tr>
			<tr align="center">
				<td>法國語文系</td>
				<td><?=$semester?></td>
				<td><?=$chart[10]?></td>
				<td><?=$chart[11]?></td>
				<td><?=$chart[12]?></td>
				<td><?=$chart[13]?></td>
				<td><?=$chart[14]?></td>

			</tr>
			<tr align="center">
				<td rowspan="6">理學院</td>
				<td>物理學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[15]?></td>
				<td><?=$chart[16]?></td>
				<td><?=$chart[17]?></td>
				<td><?=$chart[18]?></td>
				<td><?=$chart[19]?></td>

			</tr>
			<tr align="center">
				<td>數學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[20]?></td>
				<td><?=$chart[21]?></td>
				<td><?=$chart[22]?></td>
				<td><?=$chart[23]?></td>
				<td><?=$chart[24]?></td>

			</tr>
			<tr align="center">
				<td>化學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[25]?></td>
				<td><?=$chart[26]?></td>
				<td ><?=$chart[27]?></td>
				<td><?=$chart[28]?></td>
				<td><?=$chart[29]?></td>

			</tr>
			<tr align="center">
				<td>生命科學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[30]?></td>
				<td><?=$chart[31]?></td>
				<td><?=$chart[32]?></td>
				<td><?=$chart[33]?></td>
				<td><?=$chart[34]?></td>

			</tr>
			<tr align="center">
				<td>光電科學與工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[35]?></td>
				<td><?=$chart[36]?></td>
				<td><?=$chart[37]?></td>
				<td><?=$chart[38]?></td>
				<td><?=$chart[39]?></td>

			</tr>
			<tr align="center">
				<td>理學院學士班</td>
				<td><?=$semester?></td>
				<td><?=$chart[40]?></td>
				<td><?=$chart[41]?></td>
				<td><?=$chart[42]?></td>
				<td><?=$chart[43]?></td>
				<td><?=$chart[44]?></td>

			</tr>
			<tr align="center">
				<td rowspan="3">工學院</td>
				<td>化學工程與材料工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[45]?></td>
				<td><?=$chart[46]?></td>
				<td><?=$chart[47]?></td>
				<td><?=$chart[48]?></td>
				<td><?=$chart[49]?></td>

			</tr>
			<tr align="center">
				<td>土木工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[50]?></td>
				<td><?=$chart[51]?></td>
				<td><?=$chart[52]?></td>
				<td><?=$chart[53]?></td>
				<td><?=$chart[54]?></td>

			</tr>
			<tr align="center">
				<td>機械工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[55]?></td>
				<td><?=$chart[56]?></td>
				<td><?=$chart[57]?></td>
				<td><?=$chart[58]?></td>
				<td><?=$chart[59]?></td>

			</tr>
			<tr align="center">
				<td rowspan="4">管理學院</td>
				<td>企業管理學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[60]?></td>
				<td><?=$chart[61]?></td>
				<td><?=$chart[62]?></td>
				<td><?=$chart[63]?></td>
				<td><?=$chart[64]?></td>

			</tr>
			<tr align="center">
				<td>資訊管理學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[65]?></td>
				<td><?=$chart[66]?></td>
				<td><?=$chart[67]?></td>
				<td><?=$chart[68]?></td>
				<td><?=$chart[69]?></td>

			</tr>
			<tr align="center">
				<td>財務金融學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[70]?></td>
				<td><?=$chart[71]?></td>
				<td><?=$chart[72]?></td>
				<td><?=$chart[73]?></td>
				<td><?=$chart[74]?></td>

			</tr>
			<tr align="center">
				<td>經濟學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[75]?></td>
				<td><?=$chart[76]?></td>
				<td><?=$chart[77]?></td>
				<td><?=$chart[78]?></td>
				<td><?=$chart[79]?></td>

			</tr>
			<tr align="center">
				<td rowspan="3">資電學院</td>
				<td>電機工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[80]?></td>
				<td><?=$chart[81]?></td>
				<td><?=$chart[82]?></td>
				<td><?=$chart[83]?></td>
				<td><?=$chart[84]?></td>

			</tr>
			<tr align="center">
				<td>資訊工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[85]?></td>
				<td><?=$chart[86]?></td>
				<td><?=$chart[87]?></td>
				<td><?=$chart[88]?></td>
				<td><?=$chart[89]?></td>

			</tr>
			<tr align="center">
				<td>通訊工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[90]?></td>
				<td><?=$chart[91]?></td>
				<td><?=$chart[92]?></td>
				<td><?=$chart[93]?></td>
				<td><?=$chart[94]?></td>

			</tr>
			<tr align="center">
				<td rowspan="2">地科學院</td>
				<td>地球科學學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[95]?></td>
				<td><?=$chart[96]?></td>
				<td><?=$chart[97]?></td>
				<td><?=$chart[98]?></td>
				<td><?=$chart[99]?></td>

			</tr>
			<tr align="center">
				<td>大氣科學學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[100]?></td>
				<td><?=$chart[101]?></td>
				<td><?=$chart[102]?></td>
				<td><?=$chart[103]?></td>
				<td><?=$chart[104]?></td>

			</tr>
<?php
	$i = 0;
	$leng = count($chart);
	for($i; $i < $leng; $i++)
	{
		if($i%5 == 0)
			$a += $chart[$i];
		elseif($i%5 == 1)
			$b += $chart[$i];
		elseif($i%5 == 2)
			$c += $chart[$i];
		elseif($i%5 == 3)
			$d += $chart[$i];
		elseif($i%5 == 4)
			$e += $chart[$i];
	}
?>
			<tr align="center">
				<td></td>
				<td>平均</td>
				<td><?=$semester?></td>
				<td><?=round($a/$len, 1)?></td>
				<td><?=round($b/$len, 1)?></td>
				<td><?=round($c/$len, 1)?></td>
				<td><?=round($d/$len, 1)?></td>
				<td><?=round($e/$len, 1)?></td>
			</tr>
		</table>
	</body>
</html>
