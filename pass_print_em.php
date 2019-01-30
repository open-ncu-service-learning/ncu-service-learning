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
					var title = "預警系統時數統計表";
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
				<td width="600" colspan="12">基本</td>
				<td width="120" rowspan="2">基本總時數</td>
				<td width="180" rowspan="2">狀態</td>
			</tr>
			<tr align="center">
				<td width="<?echo 600/$cols;?>" colspan="<?echo 12/$cols;?>" >服務學習</td>
				<td width="<?echo 600/$cols;?>" colspan="<?echo 12/$cols;?>" >生活知能</td>
				<td width="<?echo 600/$cols;?>" colspan="<?echo 12/$cols;?>" >人文藝術</td>
			<?if($semester>=106){?>
				<td width="<?echo 600/$cols;?>" colspan="<?echo 12/$cols;?>" >國際視野</td>
			<?}?>
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
					<td colspan="<?echo 12/$cols;?>"><?=$b1[$i]?></td>
					<td colspan="<?echo 12/$cols;?>"><?=$b2[$i]?></td>
					<td colspan="<?echo 12/$cols;?>"><?=$b3[$i]?></td>
				<?if($semester>=106){?>
					<td colspan="<?echo 12/$cols;?>"><?=$b4[$i]?></td>
				<?}?>
					<td><?=$basicHour[$i]?></td>
					<td><?=$qualified[$i]?></td>
			</tr>
<?
		}
	}

	
	echo "</table><br>";
	$ok=$length-$GG;
	echo "<div align='center'>總人數：$length ,未通過人數：$GG, 通過人數：$ok";?>
	（顯示科系詳細資料：
	<a href="pass_print_dep.php?semester=<?php echo $_GET['semester']; ?>&dep=<?php echo $ncu[$k]; ?>"  target=_blank>所有學生</a>、
	<a href="pass_print_depNot.php?semester=<?php echo $_GET['semester']; ?>&dep=<?php echo $ncu[$k]; ?>"  target=_blank>未通過學生</a>）
<?	echo "</div><br><br><br>";
	
}
?>
	</div>
	</body>
</html>

<??>