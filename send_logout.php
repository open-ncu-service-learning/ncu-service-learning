<?php
	session_start();

	// 身分驗證
	if($_SESSION['valid_token'] != "1" && $_SESSION['valid_token'] != "2") {
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
	// 清除session
	if($_SESSION['valid_token'] == "1") {			// 學生
		unset($_SESSION['valid_token']);
		unset($_SESSION['valid_student_id']);
		unset($_SESSION['valid_student_name']);
	}
	elseif($_SESSION['valid_token'] == "2") {		// 活動單位
		unset($_SESSION['valid_token']);
		unset($_SESSION['valid_office_account']);
		unset($_SESSION['valid_office']);
		unset($_SESSION['valid_type']);
	}

	session_destroy();

	echo
	"
		<script>
			alert(\"您已成功登出\");
			self.location.href='index.php';
		</script>
	";
?>
	</body>
</html>