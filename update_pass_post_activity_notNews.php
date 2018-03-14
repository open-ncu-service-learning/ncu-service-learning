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
	
	$id = (int)$_POST['act_id'];
	
// 檔案上傳
	$dir = "download/pass_activities/";
	$var = "";
	$tag = 0;

	$str = "";
	$str_act = "";
	for($i = 1; $i <= 1; $i++)
	{
		$var = "file"."$i";
		if(is_uploaded_file($_FILES[$var]['tmp_name']))
		{
			$filetype = substr($_FILES[$var]['name'], strrpos($_FILES[$var]['name'] , ".")+1);
			$$var = time()."$i." . $filetype;
			
			if(move_uploaded_file($_FILES[$var]['tmp_name'], $dir.$$var)) {
				$str_act .= ", `act_file` = '".$$var."'";
			} else {
				echo
				"
					<script>
						alert(\"檔案上傳失敗\");
						self.location.href='pass_updateActivitiesnotNews.php?act_id='$id'';
					</script>
				";	
			}
			$tag = 1;
		}		
	}	

// 記錄ip
	if(empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$ip = $ip[0];
	}

// 活動時間
	$begin = $_POST['begin_time']." ".$_POST['begin_hour'].":".$_POST['begin_minute'].":00";
	$end = $_POST['end_time']." ".$_POST['end_hour'].":".$_POST['end_minute'].":00";
	
// 認證時數
	//將一般改為基本和高階兩個
	$hour = "0";
	if($_POST['service_hour_type'] == 1) {
		$hour = $_POST['service_hour_1'];
	} elseif($_POST['service_hour_type'] == 2) {
		$hour = $_POST['service_hour'];
	} elseif($_POST['service_hour_type'] == 3) {
		$hour = $_POST['service_hour_low'].",".$_POST['service_hour_high'];
	} elseif($_POST['service_hour_type'] == 4 || $_POST['service_hour_type'] == 5) {
		$hour = "-1";
	} else {
		$hour = "";
	}
	//依服務時數 預設類型是存為 基本(1)
	if($_POST['service_hour_type']==4){
		$_POST['service_hour_type']=1;
	}
		//依服務時數 高階
	if($_POST['service_hour_type']==5){
		$_POST['service_hour_type']=2;
	}
	
	
// 學期
	$semester = $_POST['school_year'].$_POST['term'];

//認證需求
	if($_POST['req_report'] == 1)
		$req_report = 1;
	else
		$req_report = 0;
	if($_POST['req_engage'] == 1)
		$req_engage = 1;
	else
		$req_engage = 0;
	if($_POST['req_questionnaire'] == 1)
		$req_questionnaire = 1;
	else
		$req_questionnaire = 0;
	if($_POST['req_test'] == 1)
		$req_test = 1;
	else
		$req_test = 0;

//其他
	if($_POST['req_other_option'] != 0)
		$req_other_option = $_POST['req_other'];
	else
		$req_other_option = 0;		
	$req = $req_report.",".$req_engage.",".$req_questionnaire.",".$req_test.",".$req_other_option;	
	
	function transtr($post_string)
	{
	$ptextrea=str_replace("'","&#39;",$post_string) ;
	return str_replace('"','&quot;',$ptextrea);
	}
	
	$des = transtr($_POST['des']);
	$postedtitle= transtr($_POST['title']);
	
//新的資料庫活動編號和舊的資料活動編號
	$sql = "SELECT * FROM `activity` WHERE `act_id`='$id'";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	/*$str_id = "";
	$sub_id = substr($row['news_no'],3);
	if(strlen($row['news_no']) == 6)
		$str_id .= "`act_no` = '$row[news_no]'";
	else if(strlen($row['news_no']) == 7)
		$str_id .= "`act_id`  = '$sub_id'";*/
	
	//$sub_id = substr($row['news_no'],3);
	
	$title = $row['act_title'];
	$begin_time = $row['act_begin_time'];
	$end_time = $row['act_end_time'];


//資料活動更新 //更改認證類別post的來源
	$sql = "UPDATE `pass`.`activity` 
				SET
					`act_title`            = '$postedtitle',
					`act_location`         = '$_POST[location]',
					`act_begin_time`       = '$begin',
					`act_end_time`         = '$end',
					`act_type`             = '$_POST[type]',
					`act_life_sub`		   = '$_POST[life_sub]',
					`act_description`      = '$des',
					`act_service_hour`     = '$hour',
					`act_pass_type`        = '$_POST[service_hour_type]',
					`act_semester`         = '$semester'
					$str_act,
					`act_link`             = '$_POST[link]',
					`act_req_person`       = '$_POST[person]',
					`act_req_office`       = '$_POST[office]',
					`act_req_email`        = '$_POST[email]',
					`act_req_phone`        = '$_POST[phone]',
					`act_report`           = '$req_report',
					`act_engage`           = '$req_engage',
					`act_questionnaire`    = '$req_questionnaire',
					`act_test`             = '$req_test',
					`act_other`            = '$req_other_option',
					`act_ip`               = '$ip'
				WHERE 
					`act_title`	= '$title' AND `act_begin_time` = '$begin_time' AND `act_end_time` = '$end_time' AND act_id ='$id' ";

	$ret = mysql_query($sql) or die(mysql_error());

	if($ret)
	{
		echo
		"
			<script>
				alert(\"修改公告成功\");
				self.location.href='pass_view_activity.php?act_id=$id';
			</script>
		";
	}
	else
	{
		echo
		"
			<script>
				alert(\"修改公告失敗\");
				self.location.href='pass_updateActivitiesnotNews.php?act_id=$id';
			</script>
		";
	}
?>
	</body>
</html>