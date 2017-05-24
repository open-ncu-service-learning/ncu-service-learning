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
	/*
	$ncu = array( "1001", "1002", "1003", "2002", "2001", "2003", "2004", 
				  "2006", "2008", "3004", "3002", "3003", "4001", "4003", 
				  "4008", "4009", "5001", "5002", "5003", "6002", "6001" );	
				  */
	//$ncu = array( "4001", "4003", "4008" );
	
	$ncu = array(
		'1001',
		'1002',
		'1003',
		'2001',
		'2002',
		'2003',
		'2006',
		'2008',
		'3002',
		'3003',
		'3004',
		'4001',
		'4003',
		'4008',
		'4009',
		'5001',
		'5002',
		'5003',
		'6001',
		'6002',
		'7007',
		'8001',
		'8002'
		);
	
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
		$sql = "SELECT user_student,user_name FROM all_user WHERE user_dep_id = $ncu[$k] AND SUBSTR(user_student,1,$str) =$semester  AND user_status = 0  ORDER BY user_student ASC";
		
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
		
		$q1=50;
		$q2=30;
		$q3=20;
		
		if($row['user_student']>105000000 && $row['user_student'] <106000000)
		{
			$q1=40;
			$q2=40;
			$q3=20;
		}
		
		//$length = 1;
		for($i; $i < $length; $i++)
		{
	
			$sql = "SELECT * FROM `all_user` WHERE user_student = '$stuid[$i]'";
			$ret = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_assoc($ret);
			
			if($row['qualified']==0){
				$qualified[$i]="未通過";
			}
			else{
				$qualified[$i]="通過";
			}
			
			//轉時數
			$b1[$i]=$row['basic_service'];			
			$b2[$i]=$row['basic_life'];				
			$b3[$i]=$row['basic_art'];				
			
			if($b1[$i] > $q1){
				$b1[$i] = $q1;
			}
			if($b2[$i] > $q2){
				$b2[$i] = $q2;
			}
			if($b3[$i] > $q3){
				$b3[$i] = $q3;
			}		
		
			$basicHour[$i] = $b1[$i] + $b2[$i] +$b3[$i];
		}
?>
	<table width="1000" align="center" border="0">
			<tr align="center">
				<td>
					<strong style="font-size: 14pt;">國立中央大學學生學習護照<span style="color: red;"><?=$dep?></span>預警系統時數統計表</strong>
				</td>
			</tr>
			<tr align="right">
				<td>印表日期: <?=$today ?></td>
			</tr>
		</table>
		<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr align="center">
				<td width="100" rowspan="2">學號</td>
				<td width="180" rowspan="2"><p>姓名</p></td>
				<td width="600" colspan="6">基本</td>
				<td width="120" rowspan="2">基本總時數</td>
				<td width="180" rowspan="2">狀態</td>
			</tr>
			<tr align="center">
				<td width="220" colspan="2" >服務學習</td>
				<td width="220" colspan="2" >生活知能</td>
				<td width="160" colspan="2" >人文藝術</td>
			</tr>
			
<?
	$i = 0;
	$GG=0;
	for($i; $i < $length; $i++)
	{
		if($qualified[$i]=="未通過"){
			$GG++;
?>		
			<tr align="center">
					<td><?
					echo "<a href='personal_activity.php?stuid=$stuid[$i]'  target=_blank>$stuid[$i]</a>";
					?></td>					
					<td><?=$name[$i]?></td>
					<td colspan="2"><?=$b1[$i]?></td>
					<td colspan="2"><?=$b2[$i]?></td>
					<td colspan="2"><?=$b3[$i]?></td>
					<td><?=$basicHour[$i]?></td>
					<td><?=$qualified[$i]?></td>
			</tr>
<?
		}
	}
	/*$i = 0;
	$ok=0;
	for($i; $i < $length; $i++)
	{
		if($qualified[$i]=="通過"){
			$ok++;
?>				
			<tr align="center">
					<td><?
					echo "<a href='personal_activity.php?stuid=$stuid[$i]'>$stuid[$i]</a>";
					?></td>
					<td><?=$name[$i]?></td>
					<td colspan="2"><?=$b1[$i]?></td>
					<td colspan="2"><?=$b2[$i]?></td>
					<td colspan="2"><?=$b3[$i]?></td>
					<td><?=$basicHour[$i]?></td>
					<td><?=$qualified[$i]?></td>
			</tr>
<?
		}
	}*/
	
	echo "</table><br>";
	$ok=$length-$GG;
	echo "<div align='center'>總人數：$length ,未通過人數：$GG, 通過人數：$ok";?>
	(<a href="pass_print_dep.php?semester=<?php echo $_GET['semester']; ?>&dep=<?php echo $ncu[$k]; ?>"  target=_blank>顯示科系詳細資料</a>)
<?	echo "</div><br><br><br>";
	
}
?>
	</body>
</html>