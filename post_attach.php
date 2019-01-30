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
		<script src="fckeditor/fckeditor.js" type="text/javascript"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			function isAddValid(){
				var title=document.addForm.title.value;
				var path=document.addForm.myfile.value;
				if( title==""){
					alert("請輸入檔案標題");
					return false;
				}
				if(path==""){
					alert("請指定檔案路徑");
					return false;
				}

				return true;
			}
		</script>
	</head>
	<body>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>

<!-- Publish -->
			<div id="main">
				<?php if($_SESSION['valid_token'] == "3") {?>
					<div class="post">
						<h3>新增檔案</h3>
					<form name="addForm" action="send_attach.php" method="post" enctype="multipart/form-data" onSubmit="return isAddValid()">

					
						<table  cellspacing=10>
							
							<tr>
								<td align="right"><label>檔案名稱</label></td>
								<td><input name="title" type="text" size="30" /></td>
							</tr>
							<script>
							$(document).ready(function(){
								$("#semArea").hide();
								$('#radioBox').change(function(){
									selected_value = $("input[name='type']:checked").val();
									if (selected_value==6){
										$("#semArea").show();
									}
									else{
										$("#semArea").hide();
									}
								});
							});
							</script>
							<tr>
								<td align="right"><label>檔案類型</label></td>
								<td id="radioBox">
								<input type="radio" name="type" value=1 checked>學生學習護照</input>
								<input type="radio" name="type" value=2>服務學習課程</input>
								<input type="radio" name="type" value=3>學生自主團隊</input>
								<input type="radio" name="type" value=4>獎學金</input><br>
								<input type="radio" name="type" value=5>服務學習執行小組會議</input>
								<input type="radio" name="type" value=6>服務學習指導委員會</input>
								</td>
							</tr>
							<tr id="semArea">
							<td align="right"><label>學期別</label></td>
							<td>
							<select name="semester">
								<?for($i=103;$i<=107;$i++){?>
								　<option value="<?=$i?>"><?=$i?></option>
								<?}?>
							</select>
							</td>
							</tr>
							<tr>
								<td align="right">檔案來源(來源檔名限英文!!!)</td>
								<td><input type="file" name="myfile" /></td>
							</tr>
							<tr>
								<td colspan=2 align="left">
									<div class="buttons">
										<button type="submit" class="positive">
											<img src="images/tick.png" alt=""/> 
											新增檔案
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
					</div>
				<?php }?>

<div id="welcome" class="post">
<h3>表單下載</h3><br />
<table width="600" >
<?php
	
	require_once("conn/db.php");
	$sql="SELECT * FROM `pass`.`attach` ORDER BY `attach_id` ASC ";
	$result=mysql_query($sql, $db) or die(mysql_error());

/*	if(mysql_num_rows($result)>0){
		for($i=1;$i<=mysql_num_rows($result);$i++){
			$row=mysql_fetch_array($result);
*/
?> 
<tr><h5 style="color:#F88017">學生學習護照</h5></tr>
<?php	
		$i = 1;
		echo "<label style='color:#FF0000'>※ 學生學習護照活動認證申請表(團體) → 請有帳密單位使用線上申請</label>";
		while($row=mysql_fetch_array($result)){		
		if($row['attach_classify'] == 1){		
?>
				<tr>
					<td width="75%">
						<?php echo $i.". ".$row['attach_title'];?>
					</td>
					<td>
						<a href="download/pass_files_test/<?php echo $row['attach_filename'];?>"><img align="left" src="images/icon/download.jpg" style="width: 30px; border: none;"></a>
					</td>
					<?php if($_SESSION['valid_token'] == "3") {?>
					<td>
						<form action="delete_attach.php" method="POST" onsubmit="return confirm('確定要刪除檔案?');">

							<input type="hidden" name="id" value="<?php echo $row['attach_id'];?>" />
							<input type="hidden" name="filename" value="<?php echo $row['attach_filename'];?>" />
							<button type="submit" class="negative"><img src="images/cross.png" alt=""/><font size=3>刪除檔案</font></button>
						</form>
						
					</td>
					<?php }?>
				</tr>

<?php
/*		}
	}else{
	echo "<tr><td>暫無檔案</td></tr>";
	}*/
			$i++;
		}
	}
	
?>	
</table><br />

<table width="600" >
<?php
	$sql="SELECT * FROM `pass`.`attach` ORDER BY `attach_id` ASC ";
	$result=mysql_query($sql, $db) or die(mysql_error());

/*	if(mysql_num_rows($result)>0){
		for($i=1;$i<=mysql_num_rows($result);$i++){
			$row=mysql_fetch_array($result);
*/
?>
<tr><h5 style="color:#F88017">服務學習課程</h5></tr>
<?php	
	$i = 1;
	while($row=mysql_fetch_array($result)){		
		if($row['attach_classify'] == 2){		
?>
		<tr>
			<td width="75%">
				<?php echo $i.". ".$row['attach_title'];?>
			</td>
			<td>
				<a href="download/pass_files_test/<?php echo $row['attach_filename'];?>"><img align="left" src="images/icon/download.jpg" style="width: 30px; border: none;"></a>
			</td>
			<?php if($_SESSION['valid_token'] == "3") {?>
			<td>
				<form action="delete_attach.php" method="POST" onsubmit="return confirm('確定要刪除檔案?');">

					<input type="hidden" name="id" value="<?php echo $row['attach_id'];?>" />
					<input type="hidden" name="filename" value="<?php echo $row['attach_filename'];?>" />
					<button type="submit" class="negative"><img src="images/cross.png" alt=""/><font size=3>刪除檔案</font></button>
				</form>
				
			</td>
			<?php }?>
		</tr>

<?php
			$i++;
		}
	}
?>	
</table><br />
<table width="600" >
<?php
	$sql="SELECT * FROM `pass`.`attach` ORDER BY `attach_id` ASC ";
	$result=mysql_query($sql, $db) or die(mysql_error());

/*	if(mysql_num_rows($result)>0){
		for($i=1;$i<=mysql_num_rows($result);$i++){
			$row=mysql_fetch_array($result);
*/
?>
<tr><h5 style="color:#F88017">學生自主團隊</h5></tr>
<?php	
	$i = 1;
	while($row=mysql_fetch_array($result)){		
		if($row['attach_classify'] == 3){		
?>
		<tr>
			<td width="75%">
				<?php echo $i.". ".$row['attach_title'];?>
			</td>
			<td>
				<a href="download/pass_files_test/<?php echo $row['attach_filename'];?>"><img align="left" src="images/icon/download.jpg" style="width: 30px; border: none;"></a>
			</td>
			<?php if($_SESSION['valid_token'] == "3") {?>
			<td>
				<form action="delete_attach.php" method="POST" onsubmit="return confirm('確定要刪除檔案?');">

					<input type="hidden" name="id" value="<?php echo $row['attach_id'];?>" />
					<input type="hidden" name="filename" value="<?php echo $row['attach_filename'];?>" />
					<button type="submit" class="negative"><img src="images/cross.png" alt=""/><font size=3>刪除檔案</font></button>
				</form>
				
			</td>
			<?php }?>
		</tr>

<?php
			$i++;
		}
	}
?></table><br />
<table width="600" >
<?php
	$sql="SELECT * FROM `pass`.`attach` ORDER BY `attach_id` ASC ";
	$result=mysql_query($sql, $db) or die(mysql_error());
?>	
<tr><h5 style="color:#F88017">獎學金</h5></tr>
<?php	
	$i = 1;
	while($row=mysql_fetch_array($result)){		
		if($row['attach_classify'] == 4){		
?>
		<tr>
			<td width="75%">
				<?php echo $i.". ".$row['attach_title'];?>
			</td>
			<td>
				<a href="download/pass_files_test/<?php echo $row['attach_filename'];?>"><img align="left" src="images/icon/download.jpg" style="width: 30px; border: none;"></a>
			</td>
			<?php if($_SESSION['valid_token'] == "3") {?>
			<td>
				<form action="delete_attach.php" method="POST" onsubmit="return confirm('確定要刪除檔案?');">

					<input type="hidden" name="id" value="<?php echo $row['attach_id'];?>" />
					<input type="hidden" name="filename" value="<?php echo $row['attach_filename'];?>" />
					<button type="submit" class="negative"><img src="images/cross.png" alt=""/><font size=3>刪除檔案</font></button>
				</form>
				
			</td>
			<?php }?>
		</tr>

<?php
			$i++;
		}
	}
?>	
</table>
<br /><br />
</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>


