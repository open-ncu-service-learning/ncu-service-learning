<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "2" && $_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	$postBy = "";
	if($_SESSION['valid_token'] == "2")
		$postBy = $_SESSION['valid_office_account'];
	elseif($_SESSION['valid_token'] == "3")
		$postBy = $_SESSION['valid_admin_account'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
<?php
	require_once("conn/db.php");
	
// 檔案上傳
	$dir = "download/pass_activities/";
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
						self.location.href='pass_apply_activites.php';
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
	if (isset($_POST['begin_time'])) {
		$begin = $_POST['begin_time']." ".$_POST['begin_hour'].":".$_POST['begin_minute'].":00";
	}
	$end = $_POST['end_time']." ".$_POST['end_hour'].":".$_POST['end_minute'].":00";
// 認證時數
	$hour = "0";
	//將一般改為基本和高階兩個
	if($_POST['service_hour_type'] == 1) {
		$hour = $_POST['service_hour_1'];
	} elseif($_POST['service_hour_type'] == 2) {
		$hour = $_POST['service_hour'];
	} elseif($_POST['service_hour_type'] == 3) {
		$hour = $_POST['service_hour_low'].",".$_POST['service_hour_high'];
	} elseif($_POST['service_hour_type'] == 4 || $_POST['service_hour_type'] ==5 ) {
		$hour = "-1";
	} else {
		$hour = "";
	}
	//依服務時數 基本
	if($_POST['service_hour_type']==4){
		$_POST['service_hour_type']=1;
	}
	//依服務時數 高階
	if($_POST['service_hour_type']==5){
		$_POST['service_hour_type']=2;
	}
// 學期
	$semester = $_POST['school_year'].$_POST['term'];
	
//活動編號
	//$act_no = sprintf("%03d",$_POST['school_year']).;
	
// 其他
	$other = "";
	if($_POST['req_other_option'] == 1)
		$other = nl2br($_POST['req_other']);
		
	

	$link = "";
	if($_POST['link'] != "http://")
		$link = $_POST['link'];
	
	function transtr($post_string)
	{
	$ptextrea=str_replace("'","&#39;",$post_string) ;
	return str_replace('"','&quot;',$ptextrea);
	}
	$postedtitle= transtr($_POST['title']);
	$des = transtr(nl2br($_POST['des']));
// 資料更新	//更改認證類別post的來源
	$sql = "INSERT INTO `activity` (
				`act_title`,
				`act_location`,
				`act_begin_time`,
				`act_end_time`,
				`act_type`,
				`act_life_sub`,
				`act_description`,
				`act_service_hour`,
				`act_pass_type`,
				`act_sticker_number`,
				`act_year`,
				`act_semester`,
				`act_file`,
				`act_link`,
				`act_req_person`,
				`act_req_office`,
				`act_req_email`,
				`act_req_phone`,
				`act_req_account`,
				`act_report`,
				`act_engage`,
				`act_questionnaire`,
				`act_test`,
				`act_other`,
				`act_time`,
				`act_ip`,
				`act_admit`,
				`act_del`,
				`act_applier`
			)
			VALUES (
				'$postedtitle', '$_POST[location]', '$begin', '$end', 
				'$_POST[type]', '$_POST[life_sub]', '$des', '$hour', '$_POST[service_hour_type]', '$_POST[sticker]', 
				'$_POST[year]', '$semester', '$file1', '$link', '$_POST[person]', 
				'$_POST[office]', '$_POST[email]', '$_POST[phone]', '$postBy',
				'$_POST[req_report]', '$_POST[req_engage]', '$_POST[req_questionnaire]', '$_POST[req_test]', 
				'$other', NOW(), '$ip', '0', '0','$postBy'
			)
		";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	
	if($ret)
	{
		//列印活動申請表
		if($_SESSION['valid_token'] == "2" || $_SESSION['valid_token'] == "3")
		{
			echo $sql = "SELECT MAX(`act_id`) AS id From `activity` WHERE `act_title` = '$postedtitle'";
			$ret = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_assoc($ret);
			$print_id = $row['id'];
			echo
			"
				<script>
					alert(\"活動申請成功\");
					self.location.href='pass_apply_print.php?id=$print_id';
				</script>
			";
		}
		
		/*  工讀生新增完後希望頁面自動跳轉到活動頁面,因此將下列判斷式註解掉,並將判斷的字串加到上方判斷式(token=2代表單位使用者, token=3代表服學組人員)
		else if($_SESSION['valid_token'] == "3")
		{
			echo
			"
				<script>
					alert(\"新增公告成功\");
					self.location.href='pass_apply_activities.php';
				</script>
			";
		}
		*/
		
	}
	else
	{
		echo
		"
			<script>
				alert(\"活動申請失敗\");
				self.location.href='pass_apply_activities.php';
			</script>
		";
	}
	
?>
	</body>
</html>