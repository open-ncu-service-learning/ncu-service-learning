<?php	
	session_start();

?>
<!DOCTYPE html>
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
		<script src="fckeditor/fckeditor.js" type="text/javascript"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? 
			require_once("sidebar.php");			
			require_once("conn/db.php");
			
			$sql="SELECT * FROM `pass`.`attach` ORDER BY `attach_id` ASC ";
			$result=mysql_query($sql, $db) or die(mysql_error());
			?>

<!-- Publish -->
			<div id="main">
			<? if ($_GET['name'] == "first"){
				echo "<h3>服務學習執行小組會議</h3>"?>
				<table width="600px" style="margin:16px;">
					
					<? while($row=mysql_fetch_array($result)){		
							if($row['attach_classify'] == 5){		
						?><tr>	
							<td width="75%">
							<li><? echo $row['attach_title'];?></li>
							</td>
							<td>
								<a href="download/meeting_first/<?php echo $row['attach_filename'];?>"><img align="left" src="images/icon/download.jpg" style="width: 30px; border: none;"></a>
							</td>
							<? if($_SESSION['valid_token'] == "3") {?>
							<td>
								<form action="delete_attach.php" method="POST" onsubmit="return confirm('確定要刪除檔案?');">
									<input type="hidden" name="id" value="<?php echo $row['attach_id'];?>" />
									<input type="hidden" name="filename" value="<?php echo $row['attach_filename'];?>" />
									<input type="hidden" name="key" value="meeting1">
									<button type="submit" class="negative"><img src="images/cross.png" alt=""/><font size=3>刪除檔案</font></button>
								</form>						
							</td>
							<? }?>
						</tr>	
							<?}
						}?>
					
				</table><?
			}
			else if ($_GET['name'] == "second"){
				echo "<h3>服務學習指導委員會</h3>";?>
				<table width="600px" style="margin:16px;">
				<?  while($row=mysql_fetch_array($result)){		
						if($row['attach_classify'] == 6){		
					?>	<tr>
							<td width="75%">
							<li><? echo $row['attach_title'];?></li>
							</td>
							<td>
								<a href="download/meeting_second/<?php echo $row['attach_filename'];?>"><img align="left" src="images/icon/download.jpg" style="width: 30px; border: none;"></a>
							</td>
							<? if($_SESSION['valid_token'] == "3") {?>
							<td>
								<form action="delete_attach.php" method="POST" onsubmit="return confirm('確定要刪除檔案?');">
									<input type="hidden" name="id" value="<?php echo $row['attach_id'];?>" />
									<input type="hidden" name="filename" value="<?php echo $row['attach_filename'];?>" />
									<input type="hidden" name="key" value="meeting2">
									<button type="submit" class="negative"><img src="images/cross.png" alt=""/><font size=3>刪除檔案</font></button>
								</form>						
							</td>
							<? }?>
						</tr>
						<?}
					}?>	
				</table><?
			}?> 
			</div>
		</div>
		
		<? require_once("footer.php");?>

	</body>
</html>


