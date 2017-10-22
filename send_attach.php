<?php
	session_start();
	if($_SESSION['valid_token'] != "3") {
		header('Location:index.php');
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>


<?php
	require_once("conn/db.php");
	
	$postby = $_SESSION['valid_admin_account'];



	if($_FILES['myfile']['error'] > 0){
		echo "<script>
				alert(\"新增檔案失敗1\");
				self.location.href='post_attach.php';
		</script>";
	} 


	
	



	if(is_uploaded_file($_FILES['myfile']['tmp_name'])){
		
		if ($_POST['type'] == 5){
			$DestDIR = "download/meeting_first/";
		}
		else if ($_POST['type'] == 6){
			$DestDIR = "download/meeting_second/";
		}
		else{
			$DestDIR = "download/pass_files_test/";
		}
		

		if(!is_dir($DestDIR) || !is_writeable($DestDIR)){
			echo "
			<script>
				alert(\"新增檔案失敗2\");
				self.location.href='post_attach.php';
			</script>";
		}

		$filename=mb_convert_encoding($_FILES['myfile']['name'],"big5","utf8");

		
		if(!copy($_FILES['myfile']['tmp_name'] , $DestDIR . "/" . $filename )){
			header('Location:pass_attach.php');
			exit;
		}

		
		
	}


	$filename=$_FILES['myfile']['name'];

	$sql = "INSERT INTO `pass`.`attach` (
				`attach_classify`,
				`attach_title`,
				`attach_filename`,
				`attach_time`,
				`attach_postby`
			)
			VALUES (
				'$_POST[type]', '$_POST[title]', '$filename', NOW(), '$postby'
			)";
		
	
	
	$ret = mysql_query($sql, $db) or die(mysql_error());

	if($ret)
	{
		header('Location:post_attach.php');
		exit;
	}
	else
	{
		header('Location:post_attach.php');
		exit;
	}
?>
</body>
</html>