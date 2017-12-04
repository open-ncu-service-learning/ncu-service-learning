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
		<!--<script LANGUAGE='JavaScript'>
			function printPage() {
			   window.print();
			}
		</script> onLoad='printPage()'-->
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
					var title = "各系時數統計表";
					var year = "<?=$_GET['semester']?>";
					var blob = new Blob([document.getElementById('outputData').innerHTML], {
						type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
					});
					var strFile = year+title+".xls";
					saveAs(blob, strFile);
					return false;
				});
			})
		</script>
	</head>
	<body>
	<div>
		<td><button id="print" disabled>pdf / printer</button></td>
		<td><button id="xsl" disabled>excel</button></td>
		<td><a id="load">loading...</a></td>
	</div>
	<div id="outputData">			
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
	
		$ncu = array( "1001", "1002", "1003", 
					  "2002", "2001", "2003", "2006", "2008", 
					  "3004", "3002", "3003", 
					  "4001", "4003", "4008", "4009", 
					  "5001", "5002", "5003", 
					  "6002", "6001", 
					  "7007", 
				      "8001", "8002");	
					  
	//$ncu = array( "4001", "4003", "4008" ,"2004");
	/*$ncu = array( "1001", "1002", "1003", "2002", "2001", "2003", "8001", 
				  "2006", "2008", "3004", "3002", "3003", "4001", "4003", 
				  "4008", "4009", "5001", "5002", "5003", "6002", "6001" );	*/
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
		$sql = "SELECT user_student,user_name FROM all_user WHERE user_dep_id = $ncu[$k] AND SUBSTR(user_student,1,$str) =$semester AND user_del=0 ORDER BY user_student ASC";
		
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
			
			$serviceHour[$i] = array(0, 0, 0, 0, 0);
			
			$serGoal = array(0, 0, 0, 0, 0);
			
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
						if($row['act_life_sub']==4){
							$type = "國際視野";
							$index = 4;
						}
						else	
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
						if(strstr($row['act_title'], "服務學習課程"))
							$serviceHour[$i][0] += $row['act_service_hour'];
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
			if($stuid[$i]<104000000 || $stuid[$i]>950000000){
				if($serviceHour[$i][0] > 40)  
					$serviceHour[$i][0] = 40;
				if($serviceHour[$i][1] > 10)  
					$serviceHour[$i][1] = 10;
				if($serviceHour[$i][2] > 30)
					$serviceHour[$i][2] = 30;
				if($serviceHour[$i][3] > 20)
					$serviceHour[$i][3] = 20;
				
				$serviceHour[$i][4] = 0;
				
				$serGoal[0] = 40;
				$serGoal[1] = 10;
				$serGoal[2] = 30;
				$serGoal[3] = 20;
				$serGoal[4] = 0;
 			}
			if($stuid[$i]>104000000 && $stuid[$i]<105000000){
				if($serviceHour[$i][0] > 40)  
					$serviceHour[$i][0] = 40;
				if($serviceHour[$i][1] > 10)  
					$serviceHour[$i][1] = 10;
				if($serviceHour[$i][2] > 30)
					$serviceHour[$i][2] = 30;
				if($serviceHour[$i][3] > 20)
					$serviceHour[$i][3] = 20;
  
				$serviceHour[$i][4] = 0;
				
				$serGoal[0] = 40;
				$serGoal[1] = 10;
				$serGoal[2] = 30;
				$serGoal[3] = 20;
				$serGoal[4] = 0;
			}
			if($stuid[$i]>105000000 && $stuid[$i]<106000000){
				if($serviceHour[$i][0] > 30)  
					$serviceHour[$i][0] = 30;
				if($serviceHour[$i][1] > 10)  
					$serviceHour[$i][1] = 10;
				if($serviceHour[$i][2] > 40)
					$serviceHour[$i][2] = 40;
				if($serviceHour[$i][3] > 20)
					$serviceHour[$i][3] = 20;

				$serviceHour[$i][4] = 0;
				
				$serGoal[0] = 30;
				$serGoal[1] = 10;
				$serGoal[2] = 40;
				$serGoal[3] = 20;
				$serGoal[4] = 0;
			}
			if($stuid[$i]>106000000 && $stuid[$i]<107000000){
				if($serviceHour[$i][0] > 30)  
					$serviceHour[$i][0] = 30;
				if($serviceHour[$i][1] > 10)  
					$serviceHour[$i][1] = 10;
				if($serviceHour[$i][2] > 35)
					$serviceHour[$i][2] = 35;
				if($serviceHour[$i][3] > 20)
					$serviceHour[$i][3] = 20;
				if($serviceHour[$i][4] > 5)  
					$serviceHour[$i][4] = 5;
				
				$serGoal[0] = 30;
				$serGoal[1] = 10;
				$serGoal[2] = 35;
				$serGoal[3] = 20;
				$serGoal[4] = 5;
			}
			

			// 總時數
			$totalHour[$i] = $serviceHour[$i][0]+$serviceHour[$i][1]+$serviceHour[$i][2]+$serviceHour[$i][3]+$serviceHour[$i][4];
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
				<?if($semester>=106){ ?>
					<td width="600" colspan="8">基本</td>
				<? }
				else{ ?>
					<td width="600" colspan="6">基本</td>
				<?}?>
				
				<td width="120" rowspan="3">基本總時數</td>
			</tr>
			<tr align="center">
				<td width="240" colspan="2">服務學習</td>
				
				<?if($semester>=106){ ?>
					<td width="120" colspan="2" rowspan="2">生活知能</td>
					<td width="120" colspan="2" rowspan="2">人文藝術</td>
					<td width="120" colspan="2" rowspan="2">國際視野</td>
				<? }
				else{ ?>
					<td width="180" colspan="2" rowspan="2">生活知能</td>
					<td width="180" colspan="2" rowspan="2">人文藝術</td>
				<?}?>
			</tr>
			<tr align="center">
				<td width="120">課程</td>
				<td width="120">校外服務</td>
			</tr>
			<tr align="center">
				<td><?=$serGoal[0]?></td>
				<td><?=$serGoal[1]?></td>
				<td colspan="2"><?=$serGoal[2]?></td>
				<td colspan="2"><?=$serGoal[3]?></td>
				<?if($semester>=106){ ?>
					<td colspan="2"><?=$serGoal[4]?></td>
				<? }?>
				<td>100</td>
<?
		$i = 0;
		$t_ser1 = 0;
		$t_ser2 = 0;
		$t_life=0;
		$t_art = 0;
		$t_inter = 0;
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
				<td colspan="2"><?=$serviceHour[$i][3]?></td>
				<?if($semester>=106){ ?>
					<td colspan="2"><?=$serviceHour[$i][4]?></td>
				<? }?>
				<td><?=$totalHour[$i]?></td>
			</tr>-
<?
			$t_ser1 += $serviceHour[$i][0];
			$t_ser2 += $serviceHour[$i][1];
			$t_life += $serviceHour[$i][2];
			$t_art += $serviceHour[$i][3];
			$t_inter += $serviceHour[$i][4];
			$t_sum += $totalHour[$i];	
		}

		$avg_ser1 = 0;
		$avg_ser2 = 0;
		$avg_life = 0;
		$avg_art = 0;
		$avg_inter = 0;
		$avg_sum = 0;
		
		$avg_ser1 = $t_ser1 / $length;
		$avg_ser2 = $t_ser2 / $length;
		$avg_life = $t_life / $length;
		$avg_art = $t_art / $length;
		$avg_inter = $t_inter / $length;
		$avg_sum = $t_sum / $length;
		
		$chart[] = round($avg_ser1, 1);
		$chart[] = round($avg_ser2, 1);
		$chart[] = round($avg_life,1);
		$chart[] = round($avg_art, 1);
		$chart[] = round($avg_inter, 1);
		$chart[] = round($avg_sum, 1);
?>
			<tr align="center">
				<td colspan="2">平均</td>
				<td><?=round($avg_ser1, 1)?></td>
				<td><?=round($avg_ser2, 1)?></td>
				<td colspan="2"><?=round($avg_life,1)?></td>
				<td colspan="2"><?=round($avg_art, 1)?></td>
				<?if($semester>=106){ ?>
					<td colspan="2"><?=round($avg_inter, 1)?></td>
				<? }?>
				<td><?=round($avg_sum, 1)?></td>
			</tr>
		</table>
		<P style='page-break-after:always'></P>
	<?php
	}

	?>
		<table width="1000" align="center" border="0">
			<tr align="center">
				<td><strong style="font-size: 14pt;">國立中央大學<span style="color: red;" id="b"><?echo $semester;?></span>級各院系 學生學習護照平均認證基本時數統計表</strong></td>
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
				<?if($semester>=106){ ?>
					<td width="440" colspan="5">基本時數</td>
				<? }
				else{ ?>
					<td width="440" colspan="4">基本時數</td>
				<?} ?>
				
				<td width="100" rowspan="3">合計</td>
			</tr>
			<tr align="center">
				<td colspan="2" width="140">服務學習</td>

				<?if($semester>=106){ ?>
					<td rowspan="2" width="100">生活知能</td>
					<td rowspan="2" width="100">人文藝術</td>
					<td rowspan="2" width="100">國際視野</td>
				<? }
				else{?>
					<td rowspan="2" width="150">生活知能</td>
					<td rowspan="2" width="150">人文藝術</td>
				<? }?>
			</tr>
			<tr align="center">
				<td width="70">課程</td>
				<td width="70">校外服務</td>
			</tr>
				<tr align="center">
				<td><?=$serGoal[0]?></td>
				<td><?=$serGoal[1]?></td>
				
				<?if($semester>=106){ ?>
					<td><?=$serGoal[2]?></td>
					<td><?=$serGoal[3]?></td>
					<td><?=$serGoal[4]?></td>
				<? }
				else{ ?>
					<td><?=$serGoal[2]?></td>
					<td><?=$serGoal[3]?></td>
				<?} ?>
				<td>100</td>
			</tr>
			<? $j=0; ?>
			
			<tr align="center">
				<td rowspan="3">文學院</td>
				<td>中國文學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
			</tr>
			<tr align="center">
				<td>英美語文系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
				
			</tr>
			<tr align="center">
				<td>法國語文系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
			<tr align="center">
				<td rowspan="5">理學院</td>
				<td>物理學系</td>
				<td><?=$semester?></td>
				<<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
				
			</tr>
			<tr align="center">
				<td>數學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
	
			</tr>
			<tr align="center">
				<td>化學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
				
			</tr>
			<tr align="center">
				<td>光電科學與工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
			<tr align="center">
				<td>理學院學士班</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
			</tr>
			<tr align="center">
				<td rowspan="3">工學院</td>
				<td>化學工程與材料工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
				
			</tr>
			<tr align="center">
				<td>土木工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
			</tr>
			<tr align="center">
				<td>機械工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
				
			</tr>
			<tr align="center">
				<td rowspan="4">管理學院</td>
				<td>企業管理學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
			<tr align="center">
				<td>資訊管理學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
			<tr align="center">
				<td>財務金融學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
			<tr align="center">
				<td>經濟學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>


			</tr>
			<tr align="center">
				<td rowspan="3">資電學院</td>
				<td>電機工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
			<tr align="center">
				<td>資訊工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
			<tr align="center">
				<td>通訊工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
			<tr align="center">
				<td rowspan="2">地科學院</td>
				<td>地球科學學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
			</tr>
			<tr align="center">
				<td>大氣科學學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
			</tr>
			<tr align="center">
				<td rowspan="1">客家學院</td>
				<td>客家語文暨社會科學學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
			</tr>
			<tr align="center">
				<td rowspan="2">生醫理工學院</td>
				<td>生命科學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>
			</tr>
			<tr align="center">
				<td>生醫科學與工程學系</td>
				<td><?=$semester?></td>
				<td><?=$chart[$j+0]?></td>
				<td><?=$chart[$j+1]?></td>
				<td><?=$chart[$j+2]?></td>
				<td><?=$chart[$j+3]?></td>
				<?if($semester>=106){ ?>
					<td><?=$chart[$j+4]?></td>
				<? }?>
				<td><?=$chart[$j+5]?></td>
				<? $j+=6; ?>

			</tr>
<?php
	$i = 0;
	$leng = count($chart);
	for($i; $i < $leng; $i++)
	{
		if($i%6 == 0)
			$a += $chart[$i];
		elseif($i%6 == 1)
			$b += $chart[$i];
		elseif($i%6 == 2)
			$c += $chart[$i];
		elseif($i%6 == 3)
			$d += $chart[$i];
		elseif($i%6 == 4)
			$e += $chart[$i];
		elseif($i%6 == 5)
			$f += $chart[$i];
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
				<?if($semester>=106){ ?>
					<td><?=round($e/$len, 1)?></td>
				<? }?>
				<td><?=round($f/$len, 1)?></td>
			</tr>
			

		</table>
	</div>
	</body>
</html>
