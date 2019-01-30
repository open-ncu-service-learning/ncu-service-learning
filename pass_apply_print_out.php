<?
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "1") {
		header('Location: index.php');
		exit;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>學生學習護照活動認證申請表列印</title>
<style type="text/css">
table {
font-size:16px;
font-size-adjust:inherit;
}
.ps1 {font-size:10px;}
.ps2 {font-size:12px;}
.title {font-size:16px;}
@media print{
#printbutton {display:none;}
.noprint {display:none;}
}
</style>
</head>

<body onload="focus();print();">
<div id ="printbutton" class="noprint"  printalign="right"><input type="button" onclick="focus();print();" value="列印本申請表" /></div>
<?
	require_once("conn/db.php");
	$id = (int)$_GET['id'];
	$sql = "SELECT * From `out_activity` WHERE `act_id` = $id";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	
	//活動時間
	$begin_time = substr($row['act_begin_time'],0,-3);
	$end_time = substr($row['act_end_time'],0,-3);
	
	//申請時間
	$apply_time = substr($row['act_time'],0,10);
	
	// 活動型態
	$type = "";
	switch($row['act_type']) {
		case 1:
			$type = "服務學習";
			break;
		case 2:
			$type = "生活知能";
			if($row['act_life_sub']==1)
				$lifesub = "大一週會";
			else if($row['act_life_sub']==6)
				$lifesub = "院週會";
			else if($row['act_life_sub']==2)
				$lifesub = "大一CPR";
			else if($row['act_life_sub']==3)
				$lifesub = "自我探索與生涯規劃";
			else if($row['act_life_sub']==5)
				$lifesub = "一般";
			else if($row['act_life_sub']==4)
				$lifesub = "國際視野";
			break;
		case 3:
			$type = "人文藝術";
			break;
		default:
			$type = "無";
	}

	
	//認證要求
	if($row['act_report'])
		$requirement[] = "心得報告";
	if($row['act_engage'])
		$requirement[] = "全程參與";
	if($row['act_questionnaire'])
		$requirement[] = "回饋問卷";
	if($row['act_test'])
		$requirement[] = "考試";
	if($row['act_other'])
		$requirement[] = $row['act_other'];
	if(isset($requirement))
		$req = implode(",", $requirement);
	//判斷是否依時數認證 是的話不顯示'-1'改為空白 且後面框框填上黑色
	if($row[act_service_hour]=='-1'){
		$row_hour=' ';
		$squ='■';
	} else{
		$row_hour=$row[act_service_hour];
		$squ='□';
	}
		
	
echo <<<EOD
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td valign="top"><div align="center"><strong>學生學習護照活動認證申請單</strong></div></td>

  </tr>

  <tr>
    <td valign="top">1.活動辦理單位 :<u>    $row[act_req_office]    </u>     活動地點：<u>    $row[act_location]    </u> </td>
  </tr>
  <tr>
    <td width="656" valign="top">2.活動名稱 :<strong><font class=title size=4>    $row[act_title]  <br>  </font></strong></td>
  </tr>
  <tr>
    <td width="656" valign="top">3.活動摘要說明 :（或請附上企劃書或詳細流程）<br><font class=title size=4>    $row[act_description]  </font></td>
  </tr>
  <tr>
    <td valign="top">4.活動時間 :<u> {$begin_time} </u> ~ <u> $end_time  </u>  ( 西元年 - 月 - 日 時 : 分 )</td>
  </tr>

  <tr>
    <td valign="top">5.申請認證時數 ：
    &nbsp;
    <u>$row_hour</u>&nbsp;小時;&nbsp;&nbsp;$squ&nbsp;&nbsp;依實際認證時數認證&nbsp;&nbsp;&nbsp;<br/>
	<u></u></td>
  </tr>
  <tr>
    <td valign="top">6.活動類型：<u> $type </u> &nbsp;&nbsp;<u>$lifesub</u></td>
  </tr>
  <tr>
    <td valign="top">7.認證要求：	<u>	$req</u> </td>
  </tr>
  <tr>
    <td height="50" valign="top">8.單位承辦申請人:<u>  $row[act_req_person]     </u>&nbsp;&nbsp;聯絡電話:  <u>  $row[act_req_phone]          </u></td>
  </tr>

  <tr>
    <td  width="661" valign="top">9.活動辦理單位主管:<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
    <tr>
    <td valign="top"> <font class=ps2 size=2>以下欄位，由服務學習辦公室填列</font></td>
  </tr>
    <tr>
    <td valign="top"> <strong>認證型態：□&nbsp;&nbsp;基本 □&nbsp;&nbsp;高階 □&nbsp;&nbsp;基本+高階 □&nbsp;&nbsp;依實際時數認證 </strong></td>
  </tr>
    <tr>
    <td valign="top"> <strong>核定認證時數：___小時 ； 基本___+高階___ 編號:________</strong></td>
  </tr>
  <tr>
    <td width="656" valign="top"><p align="right"><strong>本聯學務處存查</strong><br />
    </p></td>
  </tr>

  <tr>
 <td> <strong>--------------------------------------------------------------------------------------------------------------------------------</strong></td>
  </tr>
<tr>
    <td valign="top"><div align="center"><strong> </strong><strong>學生學習護照活動認證回覆單        </strong></div></td>
  </tr>
   <tr>
    <td valign="top">1.活動辦理單位 :<u>    $row[act_req_office]    </u>     活動地點：<u>    $row[act_location]    </u> </td>
  </tr>
  <tr>
     <td width="656" valign="top">2.活動名稱 :<strong><font class=title size=4>    $row[act_title]  <br>  </font></strong></td>
  </tr>
  <tr>
    <td valign="top">3.活動時間 :<u> {$begin_time} </u> ~ <u> $end_time  </u>  ( 西元年 - 月 - 日 時 : 分 )</td>
  </tr>
    <tr>
    <td valign="top">4.通過認證要求：<u> $req    </u> </td>
  </tr>
  <tr>
    <td valign="top">5.單位承辦申請人:<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       </u>&nbsp;&nbsp;聯絡電話:  <u>  $row[act_req_phone]          </u></td>
  </tr>
  </tr>
    <tr>
    <td valign="top"> <br><font class=ps2 size=2>以下欄位，由服務學習辦公室填列</font></td>
  </tr>
  <tr>
    <td valign="top">5.<strong>審定活動類型：□服務學習類  □生活知能類  □人文藝術類  □不合規範 </strong></td>
  </tr>
  <tr>
    <td valign="top">6.<strong>審定護照型態：□ 基本學習 □高階學習 □依實際時數認證</strong></td>
  </tr>
  <tr>
    <td valign="top">7.<strong>審定認證時數：_____小時；基本___+高階___</strong></td>
  <tr>
  <tr>
    <td valign="top">8.<strong>活動認證編號:_________號</strong></td>
  </tr>
  
    <td valign="top"><p><font class=ps2 size=2>註:&nbsp;&nbsp;<br>1.請於活動至少五個工作天前申請。<br>
2.活動結束五個工作天內，請將簽到單（於服務學習網下載表格）正本擲回服務學習辦公室，以登錄時數。<br>
3.本表單蒐集之個人資料，僅限於個人資料申請認證時數使用，保存期限五年。非經當事人同意，絕不轉做其他用途，僅限活動聯繫使用，並遵循本校個人資料保護管理制度資料保存與安全控管辦理。 <br /></font></p>
</td>
  </tr>
   <tr>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
  </tr>
  <tr>
    <td valign="top">審查小組:    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
  </tr>
  <tr>
   <td width="656" valign="top"><div align="right"><strong>本聯回覆申請單位</strong></div></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
</table>

</body>
</html>
EOD;
?>