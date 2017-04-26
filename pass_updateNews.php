<?php
	session_start();

	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		//header('Location: index.php');
		//exit;
	}
	
	require_once("conn/db.php");
	
	if(!is_numeric($_GET['news_id'])) {
		header('Location: index.php');
		exit;
	}
	
	$id = (int)$_GET['news_id'];
	
	$dir = "download/pass_news/";
	$sql = "SELECT * FROM `news` WHERE `news_del` = '0' AND `news_id` = '$id'";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
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
					<h3 style="margin-top: 10px;">修改公告</h3>
					<form id="form1" name="form1" action="update_pass_post_news.php" method="post" enctype="multipart/form-data" onsubmit="return check_newsForm(form1)">
						<table width="700" style="margin-top: 20px;">
							<tr>
								<td align="right"><label for="title" style="color: #AF0000;">標題：</label></td>
								<td><input type="text" name="title" size="50" id="title" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入標題" value="<?=$row['news_title']?>"/></td>
							</tr>
							<tr>
								<td align="right"><label for="title" style="color: #AF0000;">分類：</label>
								</td>
								<td>
								<input type="radio" name="type" value=1 <?php if($row['news_type']==1)echo "checked"?>>校內公告</input>
								<input type="radio" name="type" value=2 <?php if($row['news_type']==2)echo "checked"?>>校外公告</input>
		
								</td>
							</tr>
							
							
	<script type="text/javascript">
		window.onload = function()
		{
			/*var oCKeditor = new CKeditor('description');
			oCKeditor.Width		= 500;
			oCKeditor.Height		= 250;
			oCKeditor.ToolbarSet	= 'Basic';
			oCKeditor.ReplaceTextarea();*/
		}
	</script>
							<tr>
								<td width="100" align="right"><label for="description" style="color: #AF0000;">內容：</label></td>
								<td><textarea  width="700" height="400"  name="description" class="ckeditor" cols="30" rows="5" id="description" class="textstyle titleHintBox" title="請輸入內容"><?=str_replace("<br />","",$row['news_text']);?></textarea></td>
							</tr>
							<tr>
								<td align="right"><label for="link" style="color: #AF0000;">相關網址：</label></td>
								<td><input type="text" name="link" id="link" size="50" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入網址" value="<?=$row['news_link']?>" /></td>
							</tr>
							<?if($row['news_file1'] != NULL){?>
							<tr>
								<td width="95" align="right"><a href="<?=$row['news_file1']?>" align="right" style="color: #AF0000;">附檔1 :</a></td>
								<td>
								<?php
									echo "<a href='$dir"."$row[news_file1]'>附檔1</a>"."<a href='pass_delFile.php?news_id=$row[news_id]&file=news_file1&table=news'"." onClick=\"return confirm('確定刪除?');\" style=\"color: #D57100;\">(刪除)</a>";
								?>
								</td>	
							</tr>
							<?} else{?>
							<tr>
								<td width="100" align="right"><label for="file1" style="color: #AF0000;">附檔1：</label></td>
								<td><input type="file" name="file1" size="30" id="file1" /></td>
							</tr>
							<?}?>
							<?if($row['news_file2'] != NULL){?>
							<tr>
								<td width="95" align="right"><a href="<?=$row['news_file2']?>" align="right" style="color: #AF0000;">附檔2 :</a></td>
								<td>
								<?php
									echo "<a href='$dir"."$row[news_file2]'>附檔2</a>"."<a href='pass_delFile.php?news_id=$row[news_id]&file=news_file2&table=news'"." onClick=\"return confirm('確定刪除?');\" style=\"color: #D57100;\">(刪除)</a>";
								?>
								</td>	
							</tr>
							<?} else{?>
							<tr>
								<td width="100" align="right"><label for="file2" style="color: #AF0000;">附檔2：</label></td>
								<td><input type="file" name="file2" size="30" id="file2" /></td>
							</tr>
							<?}?>
							<?if($row['news_file3'] != NULL){?>
							<tr>
								<td width="95" align="right"><a href="<?=$row['news_file3']?>" align="right" style="color: #AF0000;">附檔3 :</a></td>
								<td>
								<?php
									echo "<a href='$dir"."$row[news_file3]'>附檔3</a>"."<a href='pass_delFile.php?news_id=$row[news_id]&file=news_file3&table=news'"." onClick=\"return confirm('確定刪除?');\" style=\"color: #D57100;\">(刪除)</a>";
								?>
								</td>	
							</tr>
							<?} else{?>
							<tr>
								<td width="100" align="right"><label for="file3" style="color: #AF0000;">附檔3：</label></td>
								<td><input type="file" name="file3" size="30" id="file3" /></td>
							</tr>
							<?}?>
						</table>
						<input type="hidden" name="news_id" id="news_id" value="<?=$id?>" />

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
