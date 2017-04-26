<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "2" ) {
		header('Location: index.php');
		exit;
	}
	$account = $_SESSION['valid_office_account'];
	$office = $_SESSION['valid_office'];

	require_once("conn/db.php");
	require_once("function_lib.php");		
		
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
			<? 
			require_once("sidebar.php");
			$sql = "SELECT * FROM `ncu_user` WHERE user_account = '$account'";
			$ret = mysql_query($sql, $db) or die(mysql_error());
			$row = mysql_fetch_assoc($ret);
			
			?>
	
					<form id="form1" name="form1" action="send_others.php" method="post">
						<table  width="700" style="margin-top: 20px; font-size: 14pt;">
							<tr>
								<td align="left" width="120"><label for="name" style="color: #AF0000;"> 單位名稱：</label></td>
								<td align="left"><span style="color: #210B61;"><?=$_SESSION['valid_office']?></span></td>
							</tr>
							<tr>
								
								<td align="left" width="120"><label for="account" style="color: #AF0000;"> 單位帳號：</label></td>
								<td align="left"><span style="color: #210B61;"><?=$_SESSION['valid_office_account']?></span></td>
							</tr>	

							<tr>
								<td align="left" width="120"><label for="pres" style="color: #AF0000;"> 社長名稱：</label></td>
								<td><input id="pres" style="font-size: 14pt; height: 25px;" name="pres" type="text" value='<?=$row['user_pres']?>' /></td>
								
								
							</tr>
							<tr>
								<td align="left" width="120"><label for="email" style="color: #AF0000;"> 電子郵件：</label></td>
								<td><input id="email" style="font-size: 14pt; height: 25px;" name="email" type="text" value='<?=$row['user_email']?>'/></td>
								
								
							</tr>
							<tr>
								
								<td align="left" width="120"><label for="phone" style="color: #AF0000;"> 連絡電話 :</label></td>
								<td><input id="phone" style="font-size: 14pt; height: 25px;" name="phone" type="text" value='<?=$row['user_contact']?>'/></td>
							</tr>
						
						
<!-- Submit -->					
						
							<tr style="height: 20px;">
								<td></td>
							</tr>
							<tr>
								<td>
									<div class="buttons">
										<button type="submit" class="positive">
											<img src="images/tick.png" alt=""/> 
											修改
										</button></div></td>
								<td>
									<div class="buttons">
										<button type="button" class="positive" onclick="location.href='others.php'">
											<img src="images/tick.png" alt=""/>
											返回
										</button>
									</div>
								</td>
							</tr>
						</table>
					</form>
					<br /><br />
					<?php if($msg != NULL) { echo $msg."<br /><br />"; } ?>
	

					<br /><br />
		<? require_once("footer.php");?>

	</body>
</html>
