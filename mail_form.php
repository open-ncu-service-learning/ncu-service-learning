<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	require_once("function_lib.php");
?>
<!DOCTYPE html>
<html lang="zh-Hant">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>國立中央大學服務學習網</title>
		
		<link href="css/menuTheme.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/JSCookMenu.js"></script>
		<script type="text/javascript" src="js/effect.js"></script>
		<script type="text/javascript" src="js/theme.js"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>
		<!-- Content -->
		<div class="container">
			<div class="row">
				
				<? require_once("sidebar_responsive.php");?>
				
				<div class="col-xs-8">
					<div id="" style="margin-top: 15px;">　</div>
					<form role="form" action="send_mail.php" method="post">
				
						<div class="form-group">
							<label for="email_title">郵件主旨</label>
							<input type="text" class="form-control" id="subject" name="subject" placeholder="輸入信件標題">
						</div>
						
						<label for="">寄件對象</label>
						<div class="checkbox">
							<label>
								<input type="checkbox" id="" name="recipient[]" value="grade_3_warning" aria-label="大三學生">大三(未通過畢審學生)
							</label>
							<br>
							<label>
								<input type="checkbox" id="" name="recipient[]" value="grade_4_warning" aria-label="大四學生">大四(未通過畢審學生)
							</label>
						</div>
						 <div class="form-group">
							<label for="">信件內容</label>
							<textarea class="form-control" name="content" rows="3"></textarea>
						  </div>
						
						<button type="submit" class="btn btn-default">送出</button>
					</form>
				</div>
			</div>
		
		

			<? require_once("footer_responsive.php");?>
		
		</div>
	</body>
</html>
