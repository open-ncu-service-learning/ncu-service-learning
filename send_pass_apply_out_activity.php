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

// 活動時間
	$begin = $_POST['begin_time']." ".$_POST['begin_hour'].":".$_POST['begin_minute'].":00";
	$end = $_POST['end_time']." ".$_POST['end_hour'].":".$_POST['end_minute'].":00";
	
// 認證時數
	//將一般改為基本和高階兩個，取類型就直接取它的value
	$hour = "0";
	if($_POST['service_hour_type'] == 1) {
		$hour = $_POST['service_hour_1'];
	}elseif($_POST['service_hour_type'] == 2) {
		$hour = $_POST['service_hour']; 
	}elseif($_POST['service_hour_type'] == 3) {
		$hour = $_POST['service_hour_low'].",".$_POST['service_hour_high'];
	} else {
		$hour = "";
	}
	
//跳脫字元
	$location = mysql_escape_string($_POST['location']);
	$title = mysql_escape_string($_POST['title']);
	$person = mysql_escape_string($_POST['person']);
	$office = mysql_escape_string($_POST['office']);
	$phone = mysql_escape_string($_POST['phone']);
	$des = "";
	//$des = nl2br($_POST['des']);
	//$des = mysql_escape_string($des);

	

// 學期
	$semester = $_POST['school_year'].$_POST['term'];
	$year = $_POST['school_year'] + 1911;

		
	$sql = "SELECT MAX(`act_id`)+1 FROM `out_activity`";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_array($ret);
	
	$no = "P".sprintf("%03d", $_POST['school_year']).sprintf("%04d", $row[0]);
	
	
	
	
// 資料更新	//更改認證類別post的來源
	$sql = "INSERT INTO `out_activity` (
				`act_title`,
				`act_location`,
				`act_begin_time`,
				`act_end_time`,
				`act_type`,
				`act_life_sub`,
				`act_subtype`,
				`act_description`,
				`act_service_hour`,
				`act_pass_type`,
				`act_year`,
				`act_semester`,
				`act_req_person`,
				`act_req_office`,
				`act_req_phone`,
				`act_time`,
				`act_service_type`,
				`act_learn_type`,
				`act_no`,
				`act_del`
			)
			VALUES (
				'$title', 
				'$location', 
				'$begin', 
				'$end', 
				'$_POST[type]',
				'$_POST[life_sub]',
				'0',
				'$des', 
				'$hour', 
				'$_POST[service_hour_type]', 
				'$year',
				'$semester', 
				'$person', 
				'$office', 
				'$phone', 
				NOW(), 
				'$_POST[service_type]', 
				'$_POST[learn_type]', 
				'$no',
				'0'
			)";

	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		echo
		"
			<script>
				alert(\"新增活動成功\");
				self.location.href='index.php';
			</script>
		";
	}
	else
	{
		echo
		"
			 <script>
				alert(\"新增活動失敗\");
				self.location.href='pass_apply_out_activity.php';
			</script>
		";
	}

?>
		
	</body>
</html>