<?php
	session_start();
	
	require_once("conn/db.php");

	// 記錄ip
	if(empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$ip = $ip[0];
	}
	
	$errorMessage = '';
	if(isset($_POST['account']) && isset($_POST['pass'])) 
	{
		$u = $_POST['account'];
		$p = sha1($_POST['pass']);
		
		$sql = sprintf("SELECT * FROM `admin` WHERE ad_account='%s' AND ad_password='%s' AND ad_del='0'", mysql_real_escape_string($u), mysql_real_escape_string($p)); 
		$ret = mysql_query($sql, $db) or die(mysql_error());
		
		if($row = mysql_fetch_assoc($ret))
		{
			// 記錄session
			$_SESSION['valid_token']				= "3";						// token
			$_SESSION['valid_admin_username']		= $row['ad_username'];		// 名稱
			$_SESSION['valid_admin_account']		= $row['ad_account'];		// 帳號
			$_SESSION['valid_admin_permission'] = $row['ad_permission'];
			// 記錄登入時間與ip
			$sql = "UPDATE `admin` SET `ad_login_time` = NOW(),
									   `ad_login_ip` = '$ip' 
					WHERE `ad_id` = '".$row['ad_id']."'";
			$ret = mysql_query($sql, $db) or die(mysql_error());
			
			header('Location: index.php');
			exit;
		}
		else
		{
			$errorMessage = '帳號密碼錯誤';
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>國立中央大學服務學習網</title>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
		<link href="css/userlayout.css" rel="stylesheet" type="text/css" />
		<link href="css/menuTheme.css" rel="stylesheet" type="text/css" />
		<script src="js/JSCookMenu.js" type="text/javascript" ></script>
		<script src="js/effect.js" type="text/javascript" ></script>
		<script src="js/theme.js" type="text/javascript" ></script>
		<script src="js/jquery-1.2.3.min.js" type="text/javascript"></script>
		<script src="js/jquery.dimensions.min.js" type="text/javascript"></script>		
		<script src="js/jquery.inputHintBox.js" type="text/javascript"></script>
		<script src="js/checkForm.js" type="text/javascript"></script>
		<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<div>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>
	</div>
<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

<!-- Publish -->
			<div id="main">
				<div id="welcome" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
<?php
	if($errorMessage != '')
	{
?>
					<p style="margin-top: 20px;"><strong><?=$errorMessage; ?></strong></p>
<?php
	}
?>
					<h3 style="margin-top: 10px;">管理者登入</h3>
					<form id="form1" name="form1" action="pass_login.php" method="post" onsubmit="return check_pass_loginForm(form1)">
						<table width="700" style="margin-top: 20px;">
							<tr>
								<td align="right"><label for="account" style="color: #AF0000;">帳號：</label></td>
								<td><input type="text" name="account" id="account" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入帳號" /></td>
							</tr>
							<tr>
								<td align="right"><label for="pass" style="color: #AF0000;">密碼：</label></td>
								<td><input type="password" name="pass" id="pass" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入密碼" /></td>
							</tr>
						</table>

<!-- Shiny_box -->
						<div id="shiny_box" class="shiny_box" style="display:none;">
							<span class="tl"></span><span class="tr"></span>
							<div class="shiny_box_body"></div>
							<span class="bl"></span><span class="br"></span>
						</div>
						<script type="text/javascript">
							$().ready(function(){
								$('.titleHintBox').inputHintBox({div:$('#shiny_box'),div_sub:'.shiny_box_body',source:'attr',attr:'title',incrementLeft:5});
							});
						</script>

<!-- Submit -->					
						<table width="100%">
							<tr style="height: 20px;">
								<td></td>
							</tr>
							<tr>
								<td>
									<div class="buttons">
										<button type="submit" class="positive">
											<img src="images/tick.png" alt=""/> 
											確定送出
										</button>
										<button type="reset" class="negative">
											<img src="images/cross.png" alt=""/>
											取消重設
										</button>
									</div>
								</td>
							</tr>
						</table>
					</form>
					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
