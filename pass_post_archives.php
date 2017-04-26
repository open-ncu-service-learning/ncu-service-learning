<?php	
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>國立中央大學服務學習網</title>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
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
					<h3 style="margin-top: 10px;">發佈認證成果</h3>
					<form id="form1" name="form1" action="send_pass_post_archives.php" method="post" onsubmit="return check_pass_post_archivesForm(form1)">
						<table width="700" style="margin-top: 20px;">
							<tr>
								<td align="right"><label for="name" style="color: #AF0000;">姓名：</label></td>
								<td><input type="text" name="name" id="name" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入姓名" /></td>
							</tr>
							<tr>
								<td align="right"><label for="dep" style="color: #AF0000;">系級：</label></td>
								<td><input type="text" name="dep" id="dep" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入系級" /></td>
							</tr>
							<tr>
								<td align="right"><label for="name" style="color: #AF0000;">活動類別：</label></td>
								<td>
									<input type="radio" name="type" id="type1" value="服務學習" checked /> 服務學習
									<input type="radio" name="type" id="type2" value="生活知能" /> 生活知能
									<input type="radio" name="type" id="type3" value="人文藝術" /> 人文藝術
								</td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="act_name" style="color: #AF0000;">活動名稱：</label></td>
								<td><input type="text" name="act_name" id="act_name" style="font-size: 14pt; height: 25px;" size="50" class="textstyle titleHintBox" title="請輸入活動名稱" /></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="act_location" style="color: #AF0000;">活動地點：</label></td>
								<td><input type="text" name="act_location" id="act_location" style="font-size: 14pt; height: 25px;" size="50" class="textstyle titleHintBox" title="請輸入活動地點" /></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="act_des" style="color: #AF0000;">活動心得：</label></td>
								<td><textarea name="act_des" class="ckeditor" cols="30" rows="5" id="act_des" class="textstyle titleHintBox" title="請輸入活動心得" ></textarea></td>
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
