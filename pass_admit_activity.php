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
	require("conn/db.php");
	
	$id = $_GET['id'];
	$view = $_GET['view'];
	$value = $_GET['value'];
	$approver=$_SESSION['valid_admin_account'];
	
	if($view)
	{
		$sql = "UPDATE `activity` SET act_admit = '$value', act_admit_time = NOW(),act_approver='$approver' WHERE act_id = "."'".$_GET['id']."'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		
		$success = "pass_view_activity.php?act_id=".$id."&view=1";
		$fail = "pass_view_activity.php?act_id=".$id."&view=1";
	}
	else
	{
		$sql = "UPDATE `activity` SET act_admit = '1', act_admit_time = NOW(),act_approver='$approver' WHERE act_id = "."'".$_GET['id']."'";
		$ret = mysql_query($sql, $db) or die(mysql_error());
		
		$success = "pass_activities_manage.php";
		$fail = "pass_activities_manage.php";
	}
	
	if($value == "1")
		$str = "活動核可成功";
	elseif($value == "2")
		$str = "活動拒絕核可";
	
	if($view == 0)
		$str = "活動核可成功";

	if($ret)
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"".$str."\");
				self.location.href='$success';
			</script>
		";
	}
	else
	{
		echo
		"
			<script type=\"text/javascript\" charset=\"utf-8\">
				alert(\"活動核可失敗\");
				self.location.href='$fail';
			</script>
		";
	}
?>
	</body>
</html>