<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	require_once("function_lib.php");

	if($_POST['adminID'] != NULL || $_POST['actName'] != NULL || $_POST['actDate'] != NULL)
	{
		// user_student
		// user_name 	
		// user_dep
		$msg="<table width=\"680\" style=\"margin-top: 20px; font-size: 16pt;\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">";
		$sql = "";
		if($_POST['adminID'] != NULL){
			$sql="SELECT * FROM `admin` WHERE ad_account='".$_POST['adminID']."' && ad_del !=1";
			$ret = mysql_query($sql, $db) or die(mysql_error());
			while($row=mysql_fetch_assoc($ret)){
				$msg.="<tr><label style=\"font-size: 14pt; height: 25px;\">Name : ".$row['ad_username']."</label></tr><br></br>";
				$msg.="<tr><label style=\"font-size: 14pt; height: 25px;\">Account : ".$row['ad_account']."</label></tr>";
			}
			$sql = "SELECT * FROM `activity` WHERE act_approver='".$_POST['adminID']."' ORDER BY `act_id` DESC";	
			$ret_search = mysql_query($sql, $db) or die(mysql_error());
			$numRows = mysql_num_rows($ret_search);
			if($numRows!=0){
				
				while($rows=mysql_fetch_assoc($ret_search)){
					$msg.="<tr><td align=\"center\" ><a href=\"pass_view_activity.php?act_id=$rows[act_id]\" style=\"color: #0066CC;\">".$rows['act_title']."</a></td></tr>";
							
				}		
			}
		}
		elseif( $_POST['actName'] != NULL ){	
			$sql = "SELECT * FROM `activity` WHERE act_title LIKE '%".$_POST['actName']."%' && act_del=0 ORDER BY `act_id` DESC";
			$ret=mysql_query($sql,$db) or die(mysql_error());
			$msg.="<tr><td align=\"center\"  width=100px>No.</a></td>";
				$msg.="<td align=\"center\" width=380px>活動名稱</a></td>";
				$msg.="<td align=\"center\"  width=320px>活動地點</a></td>";
				$msg.="<td align=\"center\" width=150px>開始時間</a></td>";
				$msg.="<td align=\"center\" width=150px>結束時間</a></td>";
				$msg.="<td align=\"center\" width=600px>發佈單位</a></td></tr>";

			while($row=mysql_fetch_assoc($ret)){
				$msg.="<td align=\"center\" >".$row['act_id']."</a></td>";
				$msg.="<td align=\"center\" ><a href=\"pass_view_activity.php?act_id=$row[act_id]\" style=\"color: #0066CC;\">".$row['act_title']."</a></td>";
				$msg.="<td align=\"center\" >".$row['act_location']."</a></td>";
				$msg.="<td align=\"center\" >".$row['act_begin_time']."</a></td>";
				$msg.="<td align=\"center\" >".$row['act_end_time']."</a></td>";
				$msg.="<td align=\"center\" >".$row['act_req_office']."</a></td></tr>";
			}
			
		}
		elseif($_POST['actDate'] !=NULL){
			$sql = "SELECT * FROM `activity` WHERE act_begin_time LIKE '%".$_POST['actDate']."%' && act_del=0 ORDER BY `act_id` DESC";
			$ret=mysql_query($sql,$db) or die(mysql_error());
			$msg.="<tr><td align=\"center\"  width=100px>No.</a></td>";
				$msg.="<td align=\"center\" width=380px>活動名稱</a></td>";
				$msg.="<td align=\"center\"  width=320px>活動地點</a></td>";
				$msg.="<td align=\"center\" width=150px>開始時間</a></td>";
				$msg.="<td align=\"center\" width=150px>結束時間</a></td>";
				$msg.="<td align=\"center\" width=600px>發佈單位</a></td></tr>";

			while($row=mysql_fetch_assoc($ret)){
				$msg.="<td align=\"center\" >".$row['act_id']."</a></td>";
				$msg.="<td align=\"center\" ><a href=\"pass_view_activity.php?act_id=$row[act_id]\" style=\"color: #0066CC;\">".$row['act_title']."</a></td>";
				$msg.="<td align=\"center\" >".$row['act_location']."</a></td>";
				$msg.="<td align=\"center\" >".$row['act_begin_time']."</a></td>";
				$msg.="<td align=\"center\" >".$row['act_end_time']."</a></td>";
				$msg.="<td align=\"center\" >".$row['act_req_office']."</a></td></tr>";
			}
		}
		
		
		$ret_search = mysql_query($sql, $db) or die(mysql_error());
		$numRows = mysql_num_rows($ret_search);
		
		$msg.="</table>";	
		
	}elseif($_POST['warning'] !=NULL){
		header('Location: print_total.php?semester='.$_POST['warning']);
		exit;
	}
	elseif($_POST['prize'] != NULL)	{
		header('Location: pass_list.php?semester='.$_POST['prize']);
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

					<form id="form1" name="form1" action="pass_approver.php" method="post">
						<table width="700" style="margin-top: 20px; font-size: 14pt;">
							<tr>
								<td>
									<label for="adminID">1. 依<span style="color: #C300FF"> 帳號 </span>查詢：</label>
									<input id="adminID" style="font-size: 14pt; height: 25px;" name="adminID" type="text" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="actName">2. 依<span style="color: #C300FF"> 活動名稱 </span>查詢：</label>
									<input id="actName" style="font-size: 14pt; height: 25px;" name="actName" type="text" />
								</td>
							</tr>	

							<tr>
								<td>
									<label for="actDate">3. 依<span style="color: #C300FF"> 活動日期 </span>查詢：</label>
									<input id="actDate" style="font-size: 14pt; height: 25px;" name="actDate" type="text" />(yyyy-mm-dd)
								</td>
							</tr>
							<tr>
								<td>
									<label for="prize">4. <span style="color: #C300FF">金銀質獎名單</span> 年度：</label>
									<input id="prize" style="font-size: 14pt; height: 25px;" name="prize" type="text" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="warning">5. <span style="color: #C300FF">預警名單</span> 年度：</label>
									<input id="warning" style="font-size: 14pt; height: 25px;" name="warning" type="text" />
								</td>
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
					<?php if($msg != NULL) { echo $msg."<br /><br />"; } ?>
	

					<br /><br />
		<? require_once("footer.php");?>

	</body>
</html>
