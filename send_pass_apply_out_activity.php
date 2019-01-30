<?php
	session_start();
	// 身分驗證
	if($_SESSION['valid_token'] == "1"){
		$stuid = $_SESSION['valid_student_id'];
	}	
	else if($_SESSION['valid_token'] == "3") {
		
	}
	else{
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
// 檔案上傳
	$dir = "download/pass_out_activities/";
	$var = "";
	$tag = 0;

	for($i = 1; $i <= 1; $i++)
	{
		$var = "file"."$i";
		if(is_uploaded_file($_FILES[$var]['tmp_name']))
		{
			$filetype = substr($_FILES[$var]['name'], strrpos($_FILES[$var]['name'] , ".")+1);
			$$var = time()."$i." . $filetype;
			if(move_uploaded_file($_FILES[$var]['tmp_name'], $dir.$$var)) {
			} else {
				echo
				"
					<script>
						alert(\"檔案上傳失敗\");
						self.location.href='pass_apply_out_activity.php';
					</script>
				";	
			}
			$tag = 1;
		}		
	}	
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
	
	function transtr($post_string)
	{
	$ptextrea=str_replace("'","&#39;",$post_string) ;
	return str_replace('"','&quot;',$ptextrea);
	}
	//$des = transtr(nl2br($_POST['des']));
	$ref = transtr(nl2br($_POST['ref']));

// 學期
	$semester = $_POST['school_year'].$_POST['term'];
	$year = $_POST['school_year'] + 1911;

		
	$sql = "SELECT MAX(`act_id`)+1 FROM `out_activity`";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_array($ret);
	
	$no = "P".sprintf("%03d", $_POST['school_year']).sprintf("%04d", $row[0]);
	
	$life_sub=5;
	$sub="";
	if($_POST[type] == 1){				//服務學習
		$sub = $_POST[service_type];
	}
	else if($_POST[type] == 2){			//生活知能
		if($_POST[life_sub_3])
			$life_sub=3;					//自我探索與生涯規劃
		$sub = $_POST[life_type];
	}
	else if($_POST[type] == 3){			//人文藝術
		$sub = $_POST[art_type];
	}
	else if($_POST[type] == 4){			//國際視野
		$sub = $_POST[inter_type];
	}
	else{
		$sub = "";
	}
	
	
// 資料更新	//更改認證類別post的來源
	$sql = "INSERT INTO `out_activity` (
				`act_title`,
				`act_location`,
				`act_begin_time`,
				`act_end_time`,
				`act_type`,
				`act_sub`,
				`act_life_sub`,
				`act_subtype`,
				`act_service_hour`,
				`act_pass_type`,
				`act_year`,
				`act_semester`,
				`act_reflection`,
				`act_file`,
				`act_req_person`,
				`act_req_office`,
				`act_req_phone`,
				`act_time`,
				`act_service_type`,
				`act_learn_type`,
				`act_admit_student`,
				`act_no`,
				`act_del`
			)
			VALUES (
				'$title', 
				'$location', 
				'$begin', 
				'$end', 
				'$_POST[type]',
				'$sub',
				'$life_sub',
				'0',
				'$hour', 
				'$_POST[service_hour_type]', 
				'$year',
				'$semester',
				'$ref',
				'$file1',
				'$person', 
				'$office', 
				'$phone', 
				NOW(), 
				'0', 
				'0',
				'$stuid',
				'$no',
				'0'
			)";

	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		if($_SESSION['valid_token'] == "1"){

			echo $sql = "SELECT MAX(`act_id`) AS id From `out_activity` WHERE `act_title` = '$title'";
			$ret = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_assoc($ret);
			$print_id = $row['id'];
			echo
			"
				<script>
					alert(\"新增活動成功\");
					self.location.href='pass_apply_print_out.php?id=$print_id';
				</script>
				
			";
		}
		else if($_SESSION['valid_token'] == "3"){
			echo
			"
				<script>
					alert(\"新增活動成功\");
					self.location.href='index.php';
				</script>
			";
		}
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