<?php	
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
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
		<!--<script src="ckeditor/ckeditor.js" type="text/javascript"></script>-->
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
					<h3 style="margin-top: 10px;">新增公告 (最新消息)</h3>
					<form id="form1" name="form1" action="send_pass_post_news.php" method="post" enctype="multipart/form-data" onsubmit="return check_newsForm(form1)">
						<table width="700" style="margin-top: 20px;">
							<tr>
								<td align="right"><label for="title" style="color: #AF0000;">標題：</label></td>
								<td><input type="text" name="title" size="50" id="title" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入標題" /></td>
							</tr>
							<tr>
								<td align="right"><label for="title" style="color: #AF0000;">分類：</label>
								</td>
								<td>
								<input type=radio name=news_type value=1 checked>校內公告</input>
								<input type=radio name=news_type value=2>校外公告</input>
								
								</td>
							</tr>
							
							
	<script type="text/javascript">
		window.onload = function()
		{
			/*
			var oCKeditor = new CKeditor('description');
			oCKeditor.Width		= 500;
			oCKeditor.Height		= 250;
			oCKeditor.ToolbarSet	= 'Basic';
			oCKeditor.ReplaceTextarea();
			*/
		}
	</script>
							<tr>
								<td width="100" align="right"><label for="description" style="color: #AF0000;">內容：</label></td>
								<td><textarea width="700" height="400"  name="description" class="ckeditor" cols="30" rows="5" id="description" class="textstyle titleHintBox" title="請輸入內容"></textarea></td>
							</tr>
							<tr>
								<td align="right"><label for="link" style="color: #AF0000;">相關網址：</label></td>
								<td><input type="text" name="link" id="link" size="50" value="http://" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入網址" /></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="file1" style="color: #AF0000;">附檔1：</label></td>
								<td><input type="file" name="file1" size="30" id="file1" /></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="file2" style="color: #AF0000;">附檔2：</label></td>
								<td><input type="file" name="file2" size="30" id="file2" /></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="file3" style="color: #AF0000;">附檔3：</label></td>
								<td><input type="file" name="file3" size="30" id="file3" /></td>
							</tr>
						</table>
						<!--input type="hidden" name="news_type" id="news_type" value="1" /-->

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
