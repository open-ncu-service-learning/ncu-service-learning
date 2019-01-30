<?php
	session_start();
	

	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}

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
	
	$len = count($ncu);

	unset($stuid);
	unset($name);
	unset($arr);
	
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
	
	for($i; $i < $length; $i++)
	{

		$sql = "SELECT * FROM `all_user` WHERE user_student = '$stuid[$i]'";
		$ret = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($ret);
		
		list($b1[$i], $b2[$i], $b3[$i], $b4[$i], $q1, $q2, $q3, $q4) = calHours($row);
		
		if($row['qualified']==0){
			$qualified[$i]="未通過";
		}
		else{
			$qualified[$i]="通過";
		}
		$basicHour[$i] = $b1[$i] + $b2[$i] + $b3[$i];
		$cols = 3;
		if($semester>=106){
			$basicHour[$i] = $b1[$i] + $b2[$i] + $b3[$i] + $b4[$i];
			$cols = 4;
		}
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
				<td>
					<?echo "<a href='personal_activity.php?stuid=$stuid[$i]'  target=_blank>$stuid[$i]</a>";?>
				</td>
				<td><?=$name[$i]?></td>
				<td colspan="2"><?=$b1[$i]?></td>
				<td colspan="2"><?=$b2[$i]?></td>
				<td colspan="2"><?=$b3[$i]?></td>
				<td><?=$basicHour[$i]?></td>
				<td><?=$qualified[$i]?></td>
		</tr>
		<?		}
	}
	echo "</table><br>";
	echo "<div align='center'>";
	echo "總人數：$length ,未通過人數：$GG<br>";
	echo "</div>";
	echo "<br>";

?>
	</body>
</html>