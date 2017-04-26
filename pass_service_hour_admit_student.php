<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	
	$act_id = $_GET['id'];
	$sql = "SELECT * FROM `activity` WHERE act_del = '0' AND act_id = '".$_GET['id']."'";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	
	$admit_student = $row['act_admit_student'];
	
	// 活動型態
	$type = "";
	$life_sub = "";
	switch($row['act_type']) {
		case 1:
			$type = "服務學習";
			break;
		case 2:
			$type = "生活知能";
			if ($row['act_life_sub'] == 1){
				$life_sub = " - 大一週會";
			}
			else if ($row['act_life_sub'] == 2){
				$life_sub = " - 大一CPR";
			}
			else if ($row['act_life_sub'] == 3){
				$life_sub = " - 自我探索與生涯規劃";
			}
			else if ($row['act_life_sub'] == 4){
				$life_sub = " - 國際視野";
			}

			else if ($row['act_life_sub'] == 6){
				$life_sub = " - 院週會";
			}
			else{
				$life_sub = " - 一般";
			}
			break;
		case 3:
			$type = "人文藝術";
			break;
		default:
			$type = "無";
	}
	
	// 護照型態
	$pass = "";
	switch($row['act_pass_type']) {
		case 1:
			$pass = "基本";
			break;
		case 2:
			$pass = "高階";
			break;
		case 3:
			$pass = "基本+高階";
			break;
		default:
			$pass = "無";
	}
	
	// 搜尋學生
	$message = "";
	if($_POST['stuID'] != NULL || $_POST['name'] != NULL || $_POST['dep'] != NULL)
	{
		// user_student
		// user_name 	
		// user_dep
		
		$str = "";
		if($_POST['name'] != NULL && $_POST['stuID'] != NULL && $_POST['dep'] != NULL)
			$str = "user_student like '".$_POST['stuID']."%' AND user_name='".$_POST['name']."' AND user_dep='".$_POST['dep']."'";
		elseif($_POST['stuID'] != NULL && $_POST['name'] == NULL && $_POST['dep'] == NULL)
			$str = "user_student like '".$_POST['stuID']."%'";
		elseif($_POST['name'] != NULL && $_POST['stuID'] == NULL && $_POST['dep'] == NULL)
			$str = "user_name='".$_POST['name']."'";
		elseif($_POST['dep'] != NULL && $_POST['stuID'] == NULL && $_POST['name'] == NULL)
			$str = "user_dep='".$_POST['dep']."'";
		elseif($_POST['stuID'] != NULL && $_POST['name'] != NULL && $_POST['dep'] == NULL)
			$str = "user_student like '".$_POST['stuID']."%' AND user_name='".$_POST['name']."'";
		elseif($_POST['stuID'] != NULL && $_POST['dep'] != NULL && $_POST['name'] == NULL)
			$str = "user_student like '".$_POST['stuID']."%' AND user_dep='".$_POST['dep']."'";
		elseif($_POST['dep'] != NULL && $_POST['name'] != NULL && $_POST['stuID'] == NULL)
			$str = "user_dep='".$_POST['dep']."' AND user_name='".$_POST['name']."'";
			
		$sql = "SELECT * FROM `all_user` WHERE ".$str." ORDER BY `user_student` DESC";
		$ret_search = mysql_query($sql, $db) or die(mysql_error());
		$numRows = mysql_num_rows($ret_search);
		
		if($ret_search)
		{
			if($numRows == 0)
			{
				$message = "查無此人";
				mysql_free_result($ret);
			}
			else
			{
				$message = "<h3>搜尋結果</h3>
							<form id=\"form2\" name=\"form2\" action=\"send_pass_service_hour_admit_student.php?id=".$act_id."\" method=\"post\">
							<table width=\"680\" style=\"margin-top: 20px; font-size: 16pt;\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">
								<tr align=\"center\">
									<td width=\"50\"><span class=\"highlight\">選取</span></td>
									<td width=\"150\"><span class=\"highlight\">學號</span></td>
									<td width=\"130\"><span class=\"highlight\">姓名</span></td>
									<td width=\"270\"><span class=\"highlight\">系級</span></td>
									<td width=\"80\"><span class=\"highlight\">總時數</span></td>	
								</tr>
				";
				
				while($row_search = mysql_fetch_assoc($ret_search))
				{
					if($row_search['user_totalHour'])
						$totalHour = $row_search['user_totalHour'];
					else
						$totalHour = 0;					
					$message .= "
								<tr>
									<td align=\"center\"><input style=\"width: 20px;\" type=\"checkbox\" name=\"list[]\" value=\"".$row_search['user_student']."\" /></td>
									<td align=\"center\">".$row_search['user_student']."</td>
									<td align=\"center\">".$row_search['user_name']."</td>
									<td align=\"center\">".$row_search['user_dep']."</td>
									<td align=\"center\">".$totalHour."</td>
								</tr>
					";
				}
				$message .= "</table>
				<input type=\"hidden\" name=\"act_id\" value=\"".$_GET['id']."\" />
				<!-- Submit -->					
						<table width=\"100%\">
							<tr style=\"height: 20px;\">
								<td></td>
							</tr>
							<tr>
								<td>
									<div class=\"buttons\">
										<button type=\"submit\" class=\"positive\">
											<img src=\"images/tick.png\" alt=\"\"/> 
											確定送出
										</button>
										<button type=\"reset\" class=\"negative\">
											<img src=\"images/cross.png\" alt=\"\"/>
											取消重設
										</button>
									</div>
								</td>
							</tr>
						</table>
					</form>
				";
			}
		}
	}
	else
	{
		$message = "請輸入搜尋條件..";
	}
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

<!-- Archives -->
			<div id="main">
				<div id="welcome" class="post">
					<a href="pass_service_hour_admit.php" style="float: right; color: red">> 返回時數核可</a>
					<h3>依服務時數核可(校內)</h3>
					<ul style="margin-top: 20px; font-size: 14pt;">
						<li>活動名稱：<?=$row['act_title']?></li>
						<li>活動時間：<?=$row['act_begin_time']." ~ ".$row['act_end_time']?></li>
						<li>活動地點：<?=$row['act_location']?></li>
						<li>活動型態：<?=$type.$life_sub?></li>
						<li>護照型態：<?=$pass?></li>
						<li>認證時數：依個人服務時數核可</li>
					</ul>
					<h3>搜尋名單</h3>
					<form id="form1" name="form1" action="pass_service_hour_admit_student.php?id=<?=$act_id?>" method="post">
						<table width="700" style="margin-top: 20px; font-size: 14pt;">
							<tr>
								<td>
									<label for="stuID">1. 依<span style="color: #C300FF">學號</span>查詢：</label>
									<input id="stuID" style="font-size: 14pt; height: 25px;" name="stuID" type="text" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="name">2. 依<span style="color: #C300FF">姓名</span>查詢：</label>
									<input id="name" style="font-size: 14pt; height: 25px;" name="name" type="text" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="dep">3. 依<span style="color: #C300FF">系級</span>查詢：</label>
									<select id="dep" name="dep" style="font-size: 14pt; height: 25px;">
										<option value="">請選擇</option>
										<option value="電機工程學系">電機工程學系</option>
										<option value="大氣科學學系">大氣科學學系</option>
										<option value="機械工程學系">機械工程學系</option>
										<option value="中國文學系">中國文學系</option>
										<option value="資訊管理學系">資訊管理學系</option>
										<option value="企業管理學系">企業管理學系</option>
										<option value="經濟學系">經濟學系</option>
										<option value="財務金融學系">財務金融學系</option>
										<option value="地球科學學系">地球科學學系</option>
										<option value="數學系">數學系</option>
										<option value="物理學系">物理學系</option>
										<option value="化學學系">化學學系</option>
										<option value="生命科學系">生命科學系</option>
										<option value="土木工程學系">土木工程學系</option>
										<option value="化學工程與材料工程學系">化學工程與材料工程學系</option>
										<option value="資訊工程學系">資訊工程學系</option>
										<option value="通訊工程學系">通訊工程學系</option>
										<option value="法國語文學系">法國語文學系</option>
										<option value="英美語文學系">英美語文學系</option>
										<option value="光電科學與工程學系">光電科學與工程學系</option>
										<option value="理學院學士班">理學院學士班</option>
										<option value="客家語文暨社會科學學系">客家語文暨社會科學學系</option>
										<option value="生醫科學與工程學系">生醫科學與工程學系</option>
									</select>
								<!--
									<select id="class" name="class" style="font-size: 14pt; height: 25px;">
										<option value="">請選擇</option>
										<option value="1">一年級</option>
										<option value="2">二年級</option>
										<option value="3">三年級</option>
										<option value="4">四年級</option>
									</select>
								-->
								</td>
							</tr>
						</table>
						<input type="hidden" name="act_id" value="<?=$_GET['id']?>" />
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
					<?php if($message != NULL) { echo "$message<br /><br />"; } ?>
<?php
	if($admit_student != "")
	{
		$list = explode(",", $admit_student);
		$number = sizeof($list);
?>
				<form id="form3" name="form3" action="send_pass_service_hour_admit_each_student.php" method="post">
					<h3>名單列表</h3>
					<input type="hidden" name="act_id" value="<?=$act_id?>" />
					<input type="hidden" name="num" value="<?=$number?>" />
					<input type="hidden" name="list" value="<?=$admit_student?>" />					
					<div style="margin-top: 20px; font-size: 16pt;"><span class="yhl">人數：<?=$number?></span>
					<table width="730" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
						<tr align="center">							
							<td width="50"><span class="highlight">刪除</span></td>
							<td width="80"><span class="highlight">時數</span></td>
							<td width="150"><span class="highlight">學號</span></td>
							<td width="100"><span class="highlight">姓名</span></td>
							<td width="270"><span class="highlight">系級</span></td>
							<td width="80"><span class="highlight">總時數</span></td>														
						</tr>
<?php
		$i = 1;
		foreach($list as $id)
		{
			$sql = "SELECT * FROM `pass`.`service_activity` WHERE ser_stu_id = '$id' AND ser_act_id = '$act_id' AND ser_del = '0'";
			$ret = mysql_query($sql, $db) or die(mysql_error());
			$row = mysql_fetch_assoc($ret);
			$stud_hour = $row['ser_hour'];
			$ser_id = $row['ser_id'];	

			$sql = "SELECT * FROM `all_user` WHERE user_student = '$id'";
			$ret = mysql_query($sql, $db) or die(mysql_error());
			$row = mysql_fetch_assoc($ret);
		
?>
						<tr>							
							<td align="center"><a href="pass_del_each_student.php?ser=<?=$ser_id?>&amp;stu=<?=$row['user_student']?>&amp;act=<?=$act_id?>&amp;hour=<?=$stud_hour?>" onClick="return confirm('確定刪除?');"><img src="images/cross.png" style="border: none;" /></a></td>
							<td align="center">
								<input type="text" onkeyup="value=value.replace(/[^\d]/g,0) " size="3" style="color: #1F46FF; height: 20px; font-size: 14pt;" name="hour<?=$i?>" value="<?=$stud_hour?>" />
								<input type="hidden" name="stud<?=$i?>" value="<?=$row['user_student']?>" />
								<input type="hidden" name="pre<?=$i?>" value="<?=$stud_hour?>" />
							</td>	
							<td align="center"><?=$row['user_student']?></td>
							<td align="center"><?=$row['user_name']?>
							<td align="center"><?=$row['user_dep']?></td>							
							<td align="center"><?=$row['user_totalHour']?></td>							
						</tr>
					
<?php
			$i++;
		}
?>
						</table><br />
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
						<br />
					</div>
				</form>
<?php		
	}
?>
				<br /><br />
				</div>
			</div>
		</div>
		<? require_once("footer.php");?>

	</body>
</html>
