<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	if($_SESSION['valid_admin_permission'] !="1"){
		header('Location: index.php');
		exit;
	}

	require_once("conn/db.php");
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
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

<!-- Publish -->
			<div id="main">
				<div id="welcome" style="font-size: 20px; color: #1F1F1F; line-height: 1.5;">
					<h3 style="margin-top: 10px;">新增管理員</h3>
					<form id="form1" name="form1" action="send_pass_admin.php" method="post" onsubmit="return check_pass_adminForm(form1)">
						<table width="700" style="margin-top: 20px;">
							<tr>
								<td align="right"><label for="name" style="color: #AF0000;">姓名：</label></td>
								<td><input type="text" name="name" id="name" size="20" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入姓名" /></td>
							</tr>
							<tr>
								<td align="right"><label for="account" style="color: #AF0000;">帳號：</label></td>
								<td><input type="text" name="account" id="account" size="20" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入帳號" /></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="pass" style="color: #AF0000;">密碼：</label></td>
								<td><input type="password" name="pass" id="pass" size="20" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入密碼" /></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="repass" style="color: #AF0000;">確認密碼：</label></td>
								<td><input type="password" name="repass" id="repass" size="20" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請確認密碼" /></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="permission" style="color: #AF0000;">權限：</label></td>
								<td>
									<select name="permission" id="permission" style="font-size: 14pt; height: 25px;">
										<option value="1">管理員</option>
										<option value="2">行政服務志工</option>
										<!--20150910更新為行政服務志工-->
									</select>
								</td>
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
					
<?php
	$sql = "SELECT * FROM `admin` WHERE ad_del = '0' ORDER BY `ad_permission`";
	$ret = mysql_query($sql, $db) or die(mysql_error());
?>

					<h3 style="margin-top: 50px;">管理員列表</h3>
<?php
	$i = 1;
	
	while ($row = mysql_fetch_assoc($ret))
	{
		$str = "";
		if($row['ad_permission'] == '1')
			$str = " (管理員)";
		elseif($row['ad_permission'] == '2')
			$str = " (行政服務志工)";
?>
						<div class="chart">
							<div class="item1">
								<?=$i?>.
							</div>
							<div class="item2">
								<?=$row['ad_username'].$str?>
							</div>
							<div class="item3">
								<?=$row['ad_account']?>
							</div>
							<div class="item3">
								<? echo "<a href='del_pass_admin.php?id=".$row['ad_id']."' onClick=\"return confirm('確定刪除?');\"><img src=\"images/cross.png\" style=\"border: none;\"></a>"; ?>
							</div>
						</div>
<?php
		$i++;
	}
?>
					<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
