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
	
	$valid_admin_account=(string)$_SESSION['valid_admin_account'];
	
	// 活動id
	$act_id = $_POST['act_id'];
	
	// 認證名單
	$list = $_POST['list'];
	
	
	
	// 檢查該學生是否重複核可
	foreach($list as $student)
	{
		$sql = "SELECT * FROM `activity` WHERE `act_id` = '".$_POST['act_id']."' AND `act_admit_student` LIKE '%".$student."%'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		$num = mysql_num_rows($ret);
		
		// 允許核可
		if($num == 0){
			$people[] = $student;
			$sql_i = "INSERT INTO activity_student ( student , activity ) ".
				"VALUES ( $student , $act_id ) ; ";
			$ret = mysql_query($sql_i, $db) or die(mysql_error());
		}	
		else // 重複的學生
			$repeat[] = $student;
	}
	
	// 將陣列的內容以逗號串接
	$peopleStr = "";
	$repeatStr = "";
	
	if(count($people))
		$peopleStr = implode(",", $people);
	if(count($repeat))
		$repeatStr = implode(",", $repeat);
	
	// 新的核可名單
	$newList = "";
	
	$sql = "SELECT * FROM `activity` WHERE `act_id` = '".$_POST['act_id']."'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$oldList = $row['act_admit_student'];
	$act_type = $row['act_type'];
	$life_sub = $row['act_life_sub'];
	
	// 若本次有新增
	if($peopleStr)
	{
		// 若舊名單已有其他學生
		if($oldList)
			$newList = $oldList.",".$peopleStr;
		else
			$newList = $peopleStr;
	}
	else	// 維持舊名單
		$newList = $oldList;


// 資料更新	
	$sql = "UPDATE `activity` SET `act_admit_student` = '$newList' WHERE `act_id` = '$act_id'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	
	$tip = "";
	if($repeatStr)
		$tip = ", 學號 ".$repeatStr." 的學生已在核可名單內。";

	if($ret)
	{	
		if(count($people))
		{
			// 新增名單(service_activity)
			foreach($people as $stuid) 
			{
				$stuid = trim($stuid);
				
				// 檢查學號是否為空
				if($stuid != "")
				{
					// 檢查是否重複新增
					$sql = "SELECT * FROM `service_activity` WHERE ser_stu_id = '$stuid' AND ser_act_id = '$act_id' AND ser_del = '0'";
					$ret = mysql_query($sql, $db) or die(mysql_error());
					$num = mysql_num_rows($ret);
					
					if($num == 0) {
						$sql = "INSERT INTO `pass`.`service_activity` (
									`ser_id`,
									`ser_stu_id`,
									`ser_act_id`,
									`ser_hour`,
									`ser_time`,
									`ser_del`
								)
								VALUES (
									NULL, '$stuid', '$act_id', '0', NOW(), '0'
								)
							";
						$ret = mysql_query($sql, $db) or die(mysql_error());
						
						if ($act_type == 2 && $life_sub == 1){
							$sql = "UPDATE `all_user` SET `assembly_freshman` = 1  WHERE `user_student` = '$stuid'";
							$ret = mysql_query($sql, $db) or die(mysql_error());
						}
						else if ($act_type == 2 && $life_sub == 6){
							$sql = "UPDATE `all_user` SET `assembly_dep` = 1  WHERE `user_student` = '$stuid'";
							$ret = mysql_query($sql, $db) or die(mysql_error());
						}
					}
				}
			}
		}
		// 清空陣列
		unset($people);
		unset($repeat);
		
		if($ret)
		{
			echo
			"
				<script>
					alert(\"核可名單新增成功".$tip."\");
					self.location.href='pass_service_hour_admit_student.php?id=$_POST[act_id]';
				</script>
			";
		}
		else
		{
			echo
			"
				<script>
					alert(\"核可名單新增失敗\");
					self.location.href='pass_service_hour_admit_student.php?id=$_POST[act_id]';
				</script>
			";
		}
	}
	else
	{
		echo
		"
			<script>
				alert(\"核可名單新增失敗\");
				self.location.href='pass_service_hour_admit_student.php?id=$_POST[act_id]';
			</script>
		";
	}
	
?>
	</body>
</html>