<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	require_once("conn/db.php");
	
	$year = date("Y");
	
	if(!is_numeric($_GET['act_id'])) {
		header('Location: index.php');
		exit;
	}
	
	$id = (int)$_GET['act_id'];
	
	$dir = "download/pass_activities/";
	$sql = "SELECT * FROM activity WHERE act_del = '0' AND act_id = '$id'";
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
		<link href="css/datePicker.css" rel="stylesheet" type="text/css" />
		<link href="css/date.css" rel="stylesheet" type="text/css" />
		<script src="js/JSCookMenu.js" type="text/javascript" ></script>
		<script src="js/effect.js" type="text/javascript" ></script>
		<script src="js/theme.js" type="text/javascript" ></script>
		<script src="js/jquery-1.2.3.min.js" type="text/javascript"></script>
		<script src="js/jquery.dimensions.min.js" type="text/javascript"></script>		
		<script src="js/jquery.inputHintBox.js" type="text/javascript"></script>
		<script src="js/checkForm.js" type="text/javascript"></script>
		<script src="js/date.js" type="text/javascript" ></script>
		<script src="js/jquery.datePicker.js" type="text/javascript" ></script>
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
					<h3 style="margin-top: 10px;">修改活動申請(校內)</h3>
					<form id="form1" name="form1" action="update_pass_post_activity_notNews.php" method="post" enctype="multipart/form-data" onsubmit="return check_pass_apply_activitiesForm(form1)">
						<table width="700" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
							<tr>
								<td align="right"><label for="title" style="color: #AF0000;">活動標題：</label></td>
								<td><input type="text" size="50" name="title" id="title" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入活動標題" value="<?=$row['act_title']?>" /></td>
							</tr>
							<tr>
								<td align="right"><label for="location" style="color: #AF0000;">活動地點：</label></td>
								<td><input type="text" size="50" name="location" id="location" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入活動地點" value="<?=$row['act_location']?>" /></td>
							</tr>
							<tr>
								<td align="right"><label for="semester" style="color: #AF0000;">學期：</label></td>
								<td>
									<input type="hidden" name="year" value="<?=$year?>" />
									<select name="school_year" style="font-size: 14pt; height: 25px;">
<?php
									//學年問題所以多減一年 1911->1912
									$k = $year - 1912;
									for($i = 0; $i < 5; $i++)
									{
?>										
										<option value="<?=$k?>" <?if( substr($row['act_semester'],0,-3) == $k ) echo "selected=\"selected\"";?>><?=$k?>
<?php
										$k++;
									}
?>
									</select> 學年度 
									<select name="term" style="font-size: 14pt; height: 25px;">
										<option <? if( strcmp(substr($row['act_semester'],-3) ,"上") == 0 ) echo "selected=\"selected\""; ?>>上</option>
										<option <? if( strcmp(substr($row['act_semester'],-3) ,"下") == 0 ) echo "selected=\"selected\""; ?>>下</option>
									</select> 學期 
								</td>
							</tr>		
								<script type="text/javascript" charset="utf-8">
									Date.firstDayOfWeek = 7;
									Date.format = 'yyyy-mm-dd';
									$(function() {
										$('.date-pick').datePicker({clickInput:true})
									});
								</script>
							<tr>
								<td align="right"><label for="begin_time" style="color: #AF0000;">活動日期：開始時間：</label></td>
								<td>
									<input id="begin_time" name="begin_time" type="text" size="30" style="font-size: 14pt; height: 25px;" class="date-pick" value="<? echo substr($row['act_begin_time'], 0, 10); ?>" />
									<select name="begin_hour" id="begin_hour" style="font-size: 14pt; height: 25px;">
										<option value="05" <?if(substr($row['act_begin_time'], 11, -6) == "05") echo "selected=\"selected\"";?> >05</option>
										<option value="06" <?if(substr($row['act_begin_time'], 11, -6) == "06") echo "selected=\"selected\"";?> >06</option>
										<option value="07" <?if(substr($row['act_begin_time'], 11, -6) == "07") echo "selected=\"selected\"";?> >07</option>
										<option value="08" <?if(substr($row['act_begin_time'], 11, -6) == "08") echo "selected=\"selected\"";?> >08</option>
										<option value="09" <?if(substr($row['act_begin_time'], 11, -6) == "09") echo "selected=\"selected\"";?> >09</option>
										<option value="10" <?if(substr($row['act_begin_time'], 11, -6) == "10") echo "selected=\"selected\"";?> >10</option>
										<option value="11" <?if(substr($row['act_begin_time'], 11, -6) == "11") echo "selected=\"selected\"";?> >11</option>
										<option value="12" <?if(substr($row['act_begin_time'], 11, -6) == "12") echo "selected=\"selected\"";?> >12</option>
										<option value="13" <?if(substr($row['act_begin_time'], 11, -6) == "13") echo "selected=\"selected\"";?> >13</option>
										<option value="14" <?if(substr($row['act_begin_time'], 11, -6) == "14") echo "selected=\"selected\"";?> >14</option>
										<option value="15" <?if(substr($row['act_begin_time'], 11, -6) == "15") echo "selected=\"selected\"";?> >15</option>
										<option value="16" <?if(substr($row['act_begin_time'], 11, -6) == "16") echo "selected=\"selected\"";?> >16</option>
										<option value="17" <?if(substr($row['act_begin_time'], 11, -6) == "17") echo "selected=\"selected\"";?> >17</option>
										<option value="18" <?if(substr($row['act_begin_time'], 11, -6) == "18") echo "selected=\"selected\"";?> >18</option>
										<option value="19" <?if(substr($row['act_begin_time'], 11, -6) == "19") echo "selected=\"selected\"";?> >19</option>
										<option value="20" <?if(substr($row['act_begin_time'], 11, -6) == "20") echo "selected=\"selected\"";?> >20</option>
										<option value="21" <?if(substr($row['act_begin_time'], 11, -6) == "21") echo "selected=\"selected\"";?> >21</option>
										<option value="22" <?if(substr($row['act_begin_time'], 11, -6) == "22") echo "selected=\"selected\"";?> >22</option>
										<option value="23" <?if(substr($row['act_begin_time'], 11, -6) == "23") echo "selected=\"selected\"";?> >23</option>
										<option value="24" <?if(substr($row['act_begin_time'], 11, -6) == "24") echo "selected=\"selected\"";?> >24</option>
									</select>時
									<select name="begin_minute" id="begin_minute" style="font-size: 14pt; height: 25px;">
										<option value="00" <?if(substr($row['act_begin_time'], 14, -3) == "00") echo "selected=\"selected\"";?> >00</option>
										<option value="01" <?if(substr($row['act_begin_time'], 14, -3) == "01") echo "selected=\"selected\"";?> >01</option>
										<option value="02" <?if(substr($row['act_begin_time'], 14, -3) == "02") echo "selected=\"selected\"";?> >02</option>
										<option value="03" <?if(substr($row['act_begin_time'], 14, -3) == "03") echo "selected=\"selected\"";?> >03</option>
										<option value="04" <?if(substr($row['act_begin_time'], 14, -3) == "04") echo "selected=\"selected\"";?> >04</option>
										<option value="05" <?if(substr($row['act_begin_time'], 14, -3) == "05") echo "selected=\"selected\"";?> >05</option>
										<option value="06" <?if(substr($row['act_begin_time'], 14, -3) == "06") echo "selected=\"selected\"";?> >06</option>
										<option value="07" <?if(substr($row['act_begin_time'], 14, -3) == "07") echo "selected=\"selected\"";?> >07</option>
										<option value="08" <?if(substr($row['act_begin_time'], 14, -3) == "08") echo "selected=\"selected\"";?> >08</option>
										<option value="09" <?if(substr($row['act_begin_time'], 14, -3) == "09") echo "selected=\"selected\"";?> >09</option>
										<option value="10" <?if(substr($row['act_begin_time'], 14, -3) == "10") echo "selected=\"selected\"";?> >10</option>
										<option value="11" <?if(substr($row['act_begin_time'], 14, -3) == "11") echo "selected=\"selected\"";?> >11</option>
										<option value="12" <?if(substr($row['act_begin_time'], 14, -3) == "12") echo "selected=\"selected\"";?> >12</option>
										<option value="13" <?if(substr($row['act_begin_time'], 14, -3) == "13") echo "selected=\"selected\"";?> >13</option>
										<option value="14" <?if(substr($row['act_begin_time'], 14, -3) == "14") echo "selected=\"selected\"";?> >14</option>
										<option value="15" <?if(substr($row['act_begin_time'], 14, -3) == "15") echo "selected=\"selected\"";?> >15</option>
										<option value="16" <?if(substr($row['act_begin_time'], 14, -3) == "16") echo "selected=\"selected\"";?> >16</option>
										<option value="17" <?if(substr($row['act_begin_time'], 14, -3) == "17") echo "selected=\"selected\"";?> >17</option>
										<option value="18" <?if(substr($row['act_begin_time'], 14, -3) == "18") echo "selected=\"selected\"";?> >18</option>
										<option value="19" <?if(substr($row['act_begin_time'], 14, -3) == "19") echo "selected=\"selected\"";?> >19</option>
										<option value="20" <?if(substr($row['act_begin_time'], 14, -3) == "20") echo "selected=\"selected\"";?> >20</option>
										<option value="21" <?if(substr($row['act_begin_time'], 14, -3) == "21") echo "selected=\"selected\"";?> >21</option>
										<option value="22" <?if(substr($row['act_begin_time'], 14, -3) == "22") echo "selected=\"selected\"";?> >22</option>
										<option value="23" <?if(substr($row['act_begin_time'], 14, -3) == "23") echo "selected=\"selected\"";?> >23</option>
										<option value="24" <?if(substr($row['act_begin_time'], 14, -3) == "24") echo "selected=\"selected\"";?> >24</option>
										<option value="25" <?if(substr($row['act_begin_time'], 14, -3) == "25") echo "selected=\"selected\"";?> >25</option>
										<option value="26" <?if(substr($row['act_begin_time'], 14, -3) == "26") echo "selected=\"selected\"";?> >26</option>
										<option value="27" <?if(substr($row['act_begin_time'], 14, -3) == "27") echo "selected=\"selected\"";?> >27</option>
										<option value="28" <?if(substr($row['act_begin_time'], 14, -3) == "28") echo "selected=\"selected\"";?> >28</option>
										<option value="29" <?if(substr($row['act_begin_time'], 14, -3) == "29") echo "selected=\"selected\"";?> >29</option>
										<option value="30" <?if(substr($row['act_begin_time'], 14, -3) == "30") echo "selected=\"selected\"";?> >30</option>
										<option value="31" <?if(substr($row['act_begin_time'], 14, -3) == "31") echo "selected=\"selected\"";?> >31</option>
										<option value="32" <?if(substr($row['act_begin_time'], 14, -3) == "32") echo "selected=\"selected\"";?> >32</option>
										<option value="33" <?if(substr($row['act_begin_time'], 14, -3) == "33") echo "selected=\"selected\"";?> >33</option>
										<option value="34" <?if(substr($row['act_begin_time'], 14, -3) == "34") echo "selected=\"selected\"";?> >34</option>
										<option value="35" <?if(substr($row['act_begin_time'], 14, -3) == "35") echo "selected=\"selected\"";?> >35</option>
										<option value="36" <?if(substr($row['act_begin_time'], 14, -3) == "36") echo "selected=\"selected\"";?> >36</option>
										<option value="37" <?if(substr($row['act_begin_time'], 14, -3) == "37") echo "selected=\"selected\"";?> >37</option>
										<option value="38" <?if(substr($row['act_begin_time'], 14, -3) == "38") echo "selected=\"selected\"";?> >38</option>
										<option value="39" <?if(substr($row['act_begin_time'], 14, -3) == "39") echo "selected=\"selected\"";?> >39</option>
										<option value="40" <?if(substr($row['act_begin_time'], 14, -3) == "40") echo "selected=\"selected\"";?> >40</option>
										<option value="41" <?if(substr($row['act_begin_time'], 14, -3) == "41") echo "selected=\"selected\"";?> >41</option>
										<option value="42" <?if(substr($row['act_begin_time'], 14, -3) == "42") echo "selected=\"selected\"";?> >42</option>
										<option value="43" <?if(substr($row['act_begin_time'], 14, -3) == "43") echo "selected=\"selected\"";?> >43</option>
										<option value="44" <?if(substr($row['act_begin_time'], 14, -3) == "44") echo "selected=\"selected\"";?> >44</option>
										<option value="45" <?if(substr($row['act_begin_time'], 14, -3) == "45") echo "selected=\"selected\"";?> >45</option>
										<option value="46" <?if(substr($row['act_begin_time'], 14, -3) == "46") echo "selected=\"selected\"";?> >46</option>
										<option value="47" <?if(substr($row['act_begin_time'], 14, -3) == "47") echo "selected=\"selected\"";?> >47</option>
										<option value="48" <?if(substr($row['act_begin_time'], 14, -3) == "48") echo "selected=\"selected\"";?> >48</option>
										<option value="49" <?if(substr($row['act_begin_time'], 14, -3) == "49") echo "selected=\"selected\"";?> >49</option>
										<option value="50" <?if(substr($row['act_begin_time'], 14, -3) == "50") echo "selected=\"selected\"";?> >50</option>
										<option value="51" <?if(substr($row['act_begin_time'], 14, -3) == "51") echo "selected=\"selected\"";?> >51</option>
										<option value="52" <?if(substr($row['act_begin_time'], 14, -3) == "52") echo "selected=\"selected\"";?> >52</option>
										<option value="53" <?if(substr($row['act_begin_time'], 14, -3) == "53") echo "selected=\"selected\"";?> >53</option>
										<option value="54" <?if(substr($row['act_begin_time'], 14, -3) == "54") echo "selected=\"selected\"";?> >54</option>
										<option value="55" <?if(substr($row['act_begin_time'], 14, -3) == "55") echo "selected=\"selected\"";?> >55</option>
										<option value="56" <?if(substr($row['act_begin_time'], 14, -3) == "56") echo "selected=\"selected\"";?> >56</option>
										<option value="57" <?if(substr($row['act_begin_time'], 14, -3) == "57") echo "selected=\"selected\"";?> >57</option>
										<option value="58" <?if(substr($row['act_begin_time'], 14, -3) == "58") echo "selected=\"selected\"";?> >58</option>
										<option value="59" <?if(substr($row['act_begin_time'], 14, -3) == "59") echo "selected=\"selected\"";?> >59</option>
									</select>分
								</td>	
							</tr>
							<tr>
								<td align="right"><label for="end_time" style="color: #AF0000;">活動時間：</label></td>
								<td>
									<input id="end_time" name="end_time" type="text" size="30" style="font-size: 14pt; height: 25px;" class="date-pick" value="<? echo substr($row['act_end_time'], 0, 10); ?>" />
									<select name="end_hour" id="end_hour" style="font-size: 14pt; height: 25px;">
										<option value="05" <?if(substr($row['act_end_time'], 11, -6) == "05") echo "selected=\"selected\"";?> >05</option>
										<option value="06" <?if(substr($row['act_end_time'], 11, -6) == "06") echo "selected=\"selected\"";?> >06</option>
										<option value="07" <?if(substr($row['act_end_time'], 11, -6) == "07") echo "selected=\"selected\"";?> >07</option>
										<option value="08" <?if(substr($row['act_end_time'], 11, -6) == "08") echo "selected=\"selected\"";?> >08</option>
										<option value="09" <?if(substr($row['act_end_time'], 11, -6) == "09") echo "selected=\"selected\"";?> >09</option>
										<option value="10" <?if(substr($row['act_end_time'], 11, -6) == "10") echo "selected=\"selected\"";?> >10</option>
										<option value="11" <?if(substr($row['act_end_time'], 11, -6) == "11") echo "selected=\"selected\"";?> >11</option>
										<option value="12" <?if(substr($row['act_end_time'], 11, -6) == "12") echo "selected=\"selected\"";?> >12</option>
										<option value="13" <?if(substr($row['act_end_time'], 11, -6) == "13") echo "selected=\"selected\"";?> >13</option>
										<option value="14" <?if(substr($row['act_end_time'], 11, -6) == "14") echo "selected=\"selected\"";?> >14</option>
										<option value="15" <?if(substr($row['act_end_time'], 11, -6) == "15") echo "selected=\"selected\"";?> >15</option>
										<option value="16" <?if(substr($row['act_end_time'], 11, -6) == "16") echo "selected=\"selected\"";?> >16</option>
										<option value="17" <?if(substr($row['act_end_time'], 11, -6) == "17") echo "selected=\"selected\"";?> >17</option>
										<option value="18" <?if(substr($row['act_end_time'], 11, -6) == "18") echo "selected=\"selected\"";?> >18</option>
										<option value="19" <?if(substr($row['act_end_time'], 11, -6) == "19") echo "selected=\"selected\"";?> >19</option>
										<option value="20" <?if(substr($row['act_end_time'], 11, -6) == "20") echo "selected=\"selected\"";?> >20</option>
										<option value="21" <?if(substr($row['act_end_time'], 11, -6) == "21") echo "selected=\"selected\"";?> >21</option>
										<option value="22" <?if(substr($row['act_end_time'], 11, -6) == "22") echo "selected=\"selected\"";?> >22</option>
										<option value="23" <?if(substr($row['act_end_time'], 11, -6) == "23") echo "selected=\"selected\"";?> >23</option>
										<option value="24" <?if(substr($row['act_end_time'], 11, -6) == "24") echo "selected=\"selected\"";?> >24</option>
									</select>時
									<select name="end_minute" id="end_minute" style="font-size: 14pt; height: 25px;">
										<option value="00" <?if(substr($row['act_end_time'], 14, -3) == "00") echo "selected=\"selected\"";?> >00</option>
										<option value="01" <?if(substr($row['act_end_time'], 14, -3) == "01") echo "selected=\"selected\"";?> >01</option>
										<option value="02" <?if(substr($row['act_end_time'], 14, -3) == "02") echo "selected=\"selected\"";?> >02</option>
										<option value="03" <?if(substr($row['act_end_time'], 14, -3) == "03") echo "selected=\"selected\"";?> >03</option>
										<option value="04" <?if(substr($row['act_end_time'], 14, -3) == "04") echo "selected=\"selected\"";?> >04</option>
										<option value="05" <?if(substr($row['act_end_time'], 14, -3) == "05") echo "selected=\"selected\"";?> >05</option>
										<option value="06" <?if(substr($row['act_end_time'], 14, -3) == "06") echo "selected=\"selected\"";?> >06</option>
										<option value="07" <?if(substr($row['act_end_time'], 14, -3) == "07") echo "selected=\"selected\"";?> >07</option>
										<option value="08" <?if(substr($row['act_end_time'], 14, -3) == "08") echo "selected=\"selected\"";?> >08</option>
										<option value="09" <?if(substr($row['act_end_time'], 14, -3) == "09") echo "selected=\"selected\"";?> >09</option>
										<option value="10" <?if(substr($row['act_end_time'], 14, -3) == "10") echo "selected=\"selected\"";?> >10</option>
										<option value="11" <?if(substr($row['act_end_time'], 14, -3) == "11") echo "selected=\"selected\"";?> >11</option>
										<option value="12" <?if(substr($row['act_end_time'], 14, -3) == "12") echo "selected=\"selected\"";?> >12</option>
										<option value="13" <?if(substr($row['act_end_time'], 14, -3) == "13") echo "selected=\"selected\"";?> >13</option>
										<option value="14" <?if(substr($row['act_end_time'], 14, -3) == "14") echo "selected=\"selected\"";?> >14</option>
										<option value="15" <?if(substr($row['act_end_time'], 14, -3) == "15") echo "selected=\"selected\"";?> >15</option>
										<option value="16" <?if(substr($row['act_end_time'], 14, -3) == "16") echo "selected=\"selected\"";?> >16</option>
										<option value="17" <?if(substr($row['act_end_time'], 14, -3) == "17") echo "selected=\"selected\"";?> >17</option>
										<option value="18" <?if(substr($row['act_end_time'], 14, -3) == "18") echo "selected=\"selected\"";?> >18</option>
										<option value="19" <?if(substr($row['act_end_time'], 14, -3) == "19") echo "selected=\"selected\"";?> >19</option>
										<option value="20" <?if(substr($row['act_end_time'], 14, -3) == "20") echo "selected=\"selected\"";?> >20</option>
										<option value="21" <?if(substr($row['act_end_time'], 14, -3) == "21") echo "selected=\"selected\"";?> >21</option>
										<option value="22" <?if(substr($row['act_end_time'], 14, -3) == "22") echo "selected=\"selected\"";?> >22</option>
										<option value="23" <?if(substr($row['act_end_time'], 14, -3) == "23") echo "selected=\"selected\"";?> >23</option>
										<option value="24" <?if(substr($row['act_end_time'], 14, -3) == "24") echo "selected=\"selected\"";?> >24</option>
										<option value="25" <?if(substr($row['act_end_time'], 14, -3) == "25") echo "selected=\"selected\"";?> >25</option>
										<option value="26" <?if(substr($row['act_end_time'], 14, -3) == "26") echo "selected=\"selected\"";?> >26</option>
										<option value="27" <?if(substr($row['act_end_time'], 14, -3) == "27") echo "selected=\"selected\"";?> >27</option>
										<option value="28" <?if(substr($row['act_end_time'], 14, -3) == "28") echo "selected=\"selected\"";?> >28</option>
										<option value="29" <?if(substr($row['act_end_time'], 14, -3) == "29") echo "selected=\"selected\"";?> >29</option>
										<option value="30" <?if(substr($row['act_end_time'], 14, -3) == "30") echo "selected=\"selected\"";?> >30</option>
										<option value="31" <?if(substr($row['act_end_time'], 14, -3) == "31") echo "selected=\"selected\"";?> >31</option>
										<option value="32" <?if(substr($row['act_end_time'], 14, -3) == "32") echo "selected=\"selected\"";?> >32</option>
										<option value="33" <?if(substr($row['act_end_time'], 14, -3) == "33") echo "selected=\"selected\"";?> >33</option>
										<option value="34" <?if(substr($row['act_end_time'], 14, -3) == "34") echo "selected=\"selected\"";?> >34</option>
										<option value="35" <?if(substr($row['act_end_time'], 14, -3) == "35") echo "selected=\"selected\"";?> >35</option>
										<option value="36" <?if(substr($row['act_end_time'], 14, -3) == "36") echo "selected=\"selected\"";?> >36</option>
										<option value="37" <?if(substr($row['act_end_time'], 14, -3) == "37") echo "selected=\"selected\"";?> >37</option>
										<option value="38" <?if(substr($row['act_end_time'], 14, -3) == "38") echo "selected=\"selected\"";?> >38</option>
										<option value="39" <?if(substr($row['act_end_time'], 14, -3) == "39") echo "selected=\"selected\"";?> >39</option>
										<option value="40" <?if(substr($row['act_end_time'], 14, -3) == "40") echo "selected=\"selected\"";?> >40</option>
										<option value="41" <?if(substr($row['act_end_time'], 14, -3) == "41") echo "selected=\"selected\"";?> >41</option>
										<option value="42" <?if(substr($row['act_end_time'], 14, -3) == "42") echo "selected=\"selected\"";?> >42</option>
										<option value="43" <?if(substr($row['act_end_time'], 14, -3) == "43") echo "selected=\"selected\"";?> >43</option>
										<option value="44" <?if(substr($row['act_end_time'], 14, -3) == "44") echo "selected=\"selected\"";?> >44</option>
										<option value="45" <?if(substr($row['act_end_time'], 14, -3) == "45") echo "selected=\"selected\"";?> >45</option>
										<option value="46" <?if(substr($row['act_end_time'], 14, -3) == "46") echo "selected=\"selected\"";?> >46</option>
										<option value="47" <?if(substr($row['act_end_time'], 14, -3) == "47") echo "selected=\"selected\"";?> >47</option>
										<option value="48" <?if(substr($row['act_end_time'], 14, -3) == "48") echo "selected=\"selected\"";?> >48</option>
										<option value="49" <?if(substr($row['act_end_time'], 14, -3) == "49") echo "selected=\"selected\"";?> >49</option>
										<option value="50" <?if(substr($row['act_end_time'], 14, -3) == "50") echo "selected=\"selected\"";?> >50</option>
										<option value="51" <?if(substr($row['act_end_time'], 14, -3) == "51") echo "selected=\"selected\"";?> >51</option>
										<option value="52" <?if(substr($row['act_end_time'], 14, -3) == "52") echo "selected=\"selected\"";?> >52</option>
										<option value="53" <?if(substr($row['act_end_time'], 14, -3) == "53") echo "selected=\"selected\"";?> >53</option>
										<option value="54" <?if(substr($row['act_end_time'], 14, -3) == "54") echo "selected=\"selected\"";?> >54</option>
										<option value="55" <?if(substr($row['act_end_time'], 14, -3) == "55") echo "selected=\"selected\"";?> >55</option>
										<option value="56" <?if(substr($row['act_end_time'], 14, -3) == "56") echo "selected=\"selected\"";?> >56</option>
										<option value="57" <?if(substr($row['act_end_time'], 14, -3) == "57") echo "selected=\"selected\"";?> >57</option>
										<option value="58" <?if(substr($row['act_end_time'], 14, -3) == "58") echo "selected=\"selected\"";?> >58</option>
										<option value="59" <?if(substr($row['act_end_time'], 14, -3) == "59") echo "selected=\"selected\"";?> >59</option>
									</select>分
								</td>
							</tr>
							<tr>
								<td align="right"><label for="type" style="color: #AF0000;">活動類別：</label></td>
								<td>
									<input type="radio" name="type" id="type1" value="1" <?if($row['act_type'] == 1) echo "checked"; ?>/> 服務學習
									<br><input type="radio" name="type" id="type2" value="2" <?if($row['act_type'] == 2) echo "checked"; ?>/> 生活知能
									<select name="life_sub" id="type2">
										<!--<option value="0"></option>-->
										<option value="5"<?if($row['act_life_sub'] == 5 && $row['act_type'] == 2) echo "selected=\"selected\""; ?>/>一般</option>
										<option value="1"<?if($row['act_life_sub'] == 1 && $row['act_type'] == 2) echo "selected=\"selected\""; ?>/>大一週會</option>
										<option value="6"<?if($row['act_life_sub'] == 6 && $row['act_type'] == 2) echo "selected=\"selected\""; ?>/>院週會</option>
										<option value="2"<?if($row['act_life_sub'] == 2 && $row['act_type'] == 2) echo "selected=\"selected\""; ?>/>大一CPR</option>
										<option value="3"<?if($row['act_life_sub'] == 3 && $row['act_type'] == 2) echo "selected=\"selected\""; ?>/>自我探索與生涯規劃</option>
										<option value="4"<?if($row['act_life_sub'] == 4 && $row['act_type'] == 2) echo "selected=\"selected\""; ?>/>國際視野</option>
									</select>
									<br><input type="radio" name="type" id="type3" value="3" <?if($row['act_type'] == 3) echo "checked"; ?> /> 人文藝術
								</td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="des" style="color: #AF0000;">活動描述：</label></td>
								<td><textarea name="des" cols="50" rows="10" id="des"><?=str_replace("<br />",chr(13).chr(10),$row['act_description'])?></textarea></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="service_hour" style="color: #AF0000;">認證時數：</label></td>
								<td>
									<input type="radio" name="service_hour_type" value="1" <?if($row['act_pass_type'] == 1 && $row['act_service_hour'] != -1) echo "checked"; ?> />
										基本 <input type="text" name="service_hour_1" style="font-size: 14pt; height: 25px;" size="5" value="<?if($row['act_pass_type'] == 1 && $row['act_service_hour'] != -1) echo $row['act_service_hour']?>" />小時 <br />
									<input type="radio" name="service_hour_type" value="2" <?if($row['act_pass_type'] == 2 && $row['act_service_hour'] != -1) echo "checked"; ?> />
										高階 <input type="text" name="service_hour" style="font-size: 14pt; height: 25px;" size="5" value="<?if($row['act_pass_type'] == 2 && $row['act_service_hour'] != -1) echo $row['act_service_hour']?>" />小時 <br />
									<input type="radio" name="service_hour_type" value="3" <?if($row['act_pass_type'] == 3 && $row['act_service_hour'] != -1) echo "checked"; ?> />	
									<?
										if($row['act_pass_type'] == 3)
											list($low, $high) = split('[,]', $row['act_service_hour']);
									?>
										基本 <input type="text" name="service_hour_low" style="font-size: 14pt; height: 25px;" size="5" value="<?=$low?>" />小時 + 
										高階 <input type="text" name="service_hour_high" style="font-size: 14pt; height: 25px;" size="5" value="<?=$high?>" />小時 <br />
									<input type="radio" name="service_hour_type" value="4" <?if($row['act_service_hour'] == -1) echo "checked"; ?> />
										依服務時數 (基本)<br />
									<input type="radio" name="service_hour_type" value="5" <?if($row['act_service_hour'] == -1) echo "checked"; ?> />
										依服務時數 (高階)<br />
									<span style="color: red;">(若勾選依服務時數認證即不需填寫時數欄位)</span>
								</td>
							</tr>
							<!--<tr>
								<td width="100" align="right"><label for="sticker" style="color: #AF0000;">認證貼紙：</label></td>
								<td><input type="text" name="sticker" id="sticker" size="5" style="font-size: 14pt; height: 25px;" value="<?//if($row['news_sticker_number'] != NULL) echo $row['news_sticker_number']; else echo "0"; ?>" />張</td>
							</tr>
							1002刪掉這欄
							<tr>
								<td align="right"><label for="pass_type" style="color: #AF0000;">認證類別：</label></td>
								<td>
									<input type="radio" name="pass_type" id="pass_type1" value="1" <?//if($row['news_pass_type'] == 1) echo "checked"; ?> /> 基本
									<input type="radio" name="pass_type" id="pass_type2" value="2" <?//if($row['news_pass_type'] == 2) echo "checked"; ?>/> 高階
									<input type="radio" name="pass_type" id="pass_type3" value="3" <?//if($row['news_pass_type'] == 3) echo "checked"; ?>/> 基本+高階
								</td>
							</tr>
							-->
							<tr>
								<td width="100" align="right"><label for="requirement" style="color: #AF0000;">認證要求：</label></td>
								<td>
								<?//list($report, $engage,$questionnaire,$test,$other_option) = split('[,]', $row['news_requirement']);?>
									<input type="checkbox" name="req_report" id="req_report" value="1" <?if($row['act_report'] == 1) echo "checked";?>/>心得報告<br />
									<input type="checkbox" name="req_engage" id="req_engage" value="1" <?if($row['act_engage'] == 1) echo "checked";?>/>全程參與<br />
									<input type="checkbox" name="req_questionnaire" id="req_questionnaire" value="1" <?if($row['act_questionnaire'] == 1) echo "checked";?> />問卷回饋<br />
									<input type="checkbox" name="req_test" id="req_test" value="1" <?if($row['act_test'] == 1) echo "checked";?>/>考試<br />								
									<input type="checkbox" name="req_other_option" id="req_other_option" value="1" <?if($row['act_other'] !=0) echo "checked";?>/>其他
									<input type="text" name="req_other" id="req_other" style="font-size: 14pt; height: 25px;" size="30" value=<?=$row['act_other']?> />
								</td>
							</tr>
							<tr>
								<td align="right"><label for="link" style="color: #AF0000;">相關網址：</label></td>
								<td><input type="text" name="link" id="link" size="50" style="font-size: 14pt; height: 25px;" value="<?=$row['act_link']?>" class="textstyle titleHintBox" title="請輸入網址" /></td>
							</tr>
							<?if($row['act_file'] != NULL){?>
							<tr>
								<td width="100" align="right"><label for="file1" style="color: #AF0000;">相關檔案：</label></td>
								<td>
								<?php
									echo "<a href='pass_delFile.php?news_id=$row[act_id]&file=act_file&table=activity'"." onClick=\"return confirm('確定刪除?');\" style=\"color: #D57100;\">(刪除檔案)</a>";
								?>
								</td>
							</tr>
							<?} else{?>							
							<tr>
								<td width="100" align="right"><label for="file1" style="color: #AF0000;">相關檔案：</label></td>
								<td><input type="file" name="file1" size="30" id="file1" /></td>
							</tr>
							<?}?>
							<tr>
								<td align="right"><label for="person" style="color: #AF0000;">聯絡人：</label></td>
								<td><input type="text" name="person" id="person" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入聯絡人" value="<?=$row['act_req_person']?>" /></td>
							</tr>
							<tr>
								<td align="right"><label for="office" style="color: #AF0000;">發佈單位：</label></td>
								<td><input type="text" name="office" id="office" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入發佈單位" value="<?=$row['act_req_office']?>" /></td>
							</tr>
							<tr>
								<td align="right"><label for="phone" style="color: #AF0000;">聯絡電話：</label></td>
								<td><input type="text" name="phone" id="phone" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入聯絡電話" value="<?=$row['act_req_phone']?>" /></td>
							</tr>
							<tr>
								<td align="right"><label for="email" style="color: #AF0000;">聯絡信箱：</label></td>
								<td><input type="text" name="email" id="email" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入聯絡信箱" value="<?=$row['act_req_email']?>" /></td>
							</tr>
							<input type="hidden" name="act_id" id="act_id" value="<?=$id?>" />
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
