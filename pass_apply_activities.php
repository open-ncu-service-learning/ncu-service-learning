<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "2" && $_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	$year = date("Y");
	$month = date("m");
	require_once("conn/db.php");
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
		<script src="js/checkForm.js"></script>
		<script src="js/date.js" type="text/javascript" ></script>
		<script src="js/jquery.datePicker.js" type="text/javascript" ></script>
		<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
		<!--<script src="js/TEST.js"></script>-->
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
					<h3 style="margin-top: 10px;">活動申請(校內)</h3>
					<?//echo "<script>tester();</script>";?>
					<form id="form1" name="form1" action="send_pass_apply_activities.php" method="post" enctype="multipart/form-data" onsubmit="return check_pass_apply_activitiesForm(form1)">
						<table width="700" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
							<tr>
								<td align="center"><label for="title" style="color: #AF0000;">活動標題：</label></td>
								<td><input type="text" size="50" name="title" id="title" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入活動標題" /></td>
							</tr>
							<tr>
								<td align="center"><label for="location" style="color: #AF0000;">活動地點：</label></td>
								<td><input type="text" size="50" name="location" id="location" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入活動地點" /></td>
							</tr>
							<tr>
								<td align="center"><label for="semester" style="color: #AF0000;">學期：</label></td>
								<td>
									<input type="hidden" name="year" value="<?=($year-1911)?>" />
									<select name="school_year" style="font-size: 14pt; height: 25px;">
<?php
									//學年問題所以多減一年 1911->1912
									//裕隆哥要求 改為1911
									$k = $year - 1912;
									if ($month >= 8){
?>
										<option value="<?=$k+1?>"><?=$k+1?>
										<option value="<?=$k?>"><?=$k?>
<?
									}else{
?>
										<option value="<?=$k?>"><?=$k?>
										<option value="<?=$k+1?>"><?=$k+1?>
<?
									}
									
									for($i = 0; $i < 3; $i++)
									{
?>
										<option value="<?=$k+2?>"><?=$k+2?>
<?php
										$k++;
									}
?>
									</select> 學年度 
									<select name="term" style="font-size: 14pt; height: 25px;">
										<option selected="selected">上</option>
										<option>下</option>
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
								<td align="center"><label for="begin_time" style="color: #AF0000;">開始時間：</label></td>
								<td>
									<input id="begin_time" name="begin_time" type="text" placeholder="201Y-MM-DD" size="30" style="font-size: 14pt; height: 25px;" class="date-pick" />							
									<select name="begin_hour" id="begin_hour" style="font-size: 14pt; height: 25px;">
																				
										<option value="05">00</option>
										<option value="05">01</option>
										<option value="05">02</option>
										<option value="05">03</option>
										<option value="05">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08" selected="selected">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
									</select>時
									<select name="begin_minute" id="begin_minute" style="font-size: 14pt; height: 25px;">
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
										<option value="32">32</option>
										<option value="33">33</option>
										<option value="34">34</option>
										<option value="35">35</option>
										<option value="36">36</option>
										<option value="37">37</option>
										<option value="38">38</option>
										<option value="39">39</option>
										<option value="40">40</option>
										<option value="41">41</option>
										<option value="42">42</option>
										<option value="43">43</option>
										<option value="44">44</option>
										<option value="45">45</option>
										<option value="46">46</option>
										<option value="47">47</option>
										<option value="48">48</option>
										<option value="49">49</option>
										<option value="50">50</option>
										<option value="51">51</option>
										<option value="52">52</option>
										<option value="53">53</option>
										<option value="54">54</option>
										<option value="55">55</option>
										<option value="56">56</option>
										<option value="57">57</option>
										<option value="58">58</option>
										<option value="59">59</option>
									</select>分
								</td>
							</tr>
							<tr>
								<td align="center"><label for="end_time" style="color: #AF0000;">結束時間：</label></td>
								<td>
									<input id="end_time" name="end_time" type="text" placeholder="201Y-MM-DD" size="30" style="font-size: 14pt; height: 25px;" class="date-pick" />
									<select name="end_hour" id="end_hour" style="font-size: 14pt; height: 25px;">
																				
										<option value="05">00</option>
										<option value="05">01</option>
										<option value="05">02</option>
										<option value="05">03</option>
										<option value="05">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08" selected="selected">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="00">00</option>
									</select>時
									<select name="end_minute" id="end_minute" style="font-size: 14pt; height: 25px;">
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
										<option value="32">32</option>
										<option value="33">33</option>
										<option value="34">34</option>
										<option value="35">35</option>
										<option value="36">36</option>
										<option value="37">37</option>
										<option value="38">38</option>
										<option value="39">39</option>
										<option value="40">40</option>
										<option value="41">41</option>
										<option value="42">42</option>
										<option value="43">43</option>
										<option value="44">44</option>
										<option value="45">45</option>
										<option value="46">46</option>
										<option value="47">47</option>
										<option value="48">48</option>
										<option value="49">49</option>
										<option value="50">50</option>
										<option value="51">51</option>
										<option value="52">52</option>
										<option value="53">53</option>
										<option value="54">54</option>
										<option value="55">55</option>
										<option value="56">56</option>
										<option value="57">57</option>
										<option value="58">58</option>
										<option value="59">59</option>
									</select>分
								</td>
							</tr>
							<tr>
								<td align="center"><label for="type" style="color: #AF0000;">活動類別：</label></td>
								<td>
									<input type="radio" name="type" id="type1" value="1" /> 服務學習
									<br><input type="radio" name="type" id="type2" value="2" /> 生活知能學習
									<select name="life_sub" id="type2">
										<option value="0">請選擇子項目</option>
										<option value="5">一般</option>
										<option value="1">大一週會</option>
										<option value="6">院週會</option>
										<option value="2">大一CPR</option>
										<option value="3">自我探索與生涯規劃</option>
										<option value="4">國際視野</option>
									</select>
									<br><input type="radio" name="type" id="type3" value="3" /> 人文藝術學習
									<!--<br><input type="radio" name="type" id="type4" value="2" /> 國際視野
									select name="life_sub" id="type2" style="visibility: hidden;">
										<option value="4">國際視野</option>
									</select>-->
								</td>
							</tr>
							<tr>
								<td width="100" align="center"><label for="des" style="color: #AF0000;">活動描述：</label></td>
								<td><textarea name="des" cols="50" rows="10" id="des"></textarea></td>
							</tr>
							<tr>
								<td width="100" align="center"><label for="service_hour" style="color: #AF0000;">認證時數：</label></td>
								<td><!-- 將一般改成基本和高階-->
									<input type="radio" name="service_hour_type" value="1" />
										基本 <input type="text" name="service_hour_1" size="3" value="0" style="font-size: 14pt; height: 25px;" />小時 <br />
									<input type="radio" name="service_hour_type" value="2" />
										高階 <input type="text" name="service_hour" size="3" value="0" style="font-size: 14pt; height: 25px;" />小時 <br />
									<input type="radio" name="service_hour_type" value="3" />
										基本 <input type="text" name="service_hour_low" size="3" value="0" style="font-size: 14pt; height: 25px;" />小時 + 
										高階 <input type="text" name="service_hour_high" size="3" value="0" style="font-size: 14pt; height: 25px;" />小時 <br />
									<input type="radio" name="service_hour_type" value="4" />
										依實際時數 (基本)<br />
									<input type="radio" name="service_hour_type" value="5" />
										依實際時數 (高階)<br />
									<span style="color: red;">(若勾選依服務時數認證即不需填寫時數欄位)</span>
								</td>
							</tr>
							<!--<tr>
								<td width="100" align="right"><label for="sticker" style="color: #AF0000;">認證貼紙：</label></td>
								<td><input type="text" name="sticker" id="sticker" size="3" value="0" style="font-size: 14pt; height: 25px;" />條</td>
							</tr>-->
							<!-- 刪掉了認證類別  直接從認證時數去取得類別-->
							<tr>
								<td width="100" align="center"><label for="requirement" style="color: #AF0000;">認證要求：</label></td>
								<td>
									<input type="checkbox" name="req_report" value="1" id="r"/>心得報告<br />
									<input type="checkbox" name="req_engage" value="1" />全程參與<br />
									<input type="checkbox" name="req_questionnaire" value="1" />問卷回饋<br />
									<input type="checkbox" name="req_test" value="1" />考試<br />								
									<input type="checkbox" name="req_other_option" value="1" />其他
									<input type="text" name="req_other" id="req_other" size="30" style="font-size: 14pt; height: 25px;" />
								</td>
							</tr>
							<tr>
								<td align="center"><label for="link" style="color: #AF0000;">相關網址：</label></td>
								<td><input type="text" name="link" id="link" size="50" value="http://" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入網址" /><br />
								<span style="color: red;">(網址字數上限100字元，過長建議使用短網址)</span>
								</td>
								
							</tr>
							<tr>
								<td width="100" align="center"><label for="file1" style="color: #AF0000;">相關檔案：</label></td>
								<td><input type="file" name="file1" size="30" id="file1" /></td>
							</tr>							
							<tr>
								<td align="center"><label for="person" style="color: #AF0000;">聯絡人：</label></td>
								<td><input type="text" name="person" id="person" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入聯絡人" /></td>
							</tr>
							<tr>
								<td align="center"><label for="office" style="color: #AF0000;">發佈單位：</label></td>

					
<?php
	//用於新增新發佈單位選項
	/*	
	$sql = "INSERT INTO `orgnization` (
					`org_id`,
					`org_name`,
					`org_del`
				)
				VALUES (
					'', '台灣聯合大學系統', '0'
				)
			";	
		$ret = mysql_query($sql, $db) or die(mysql_error());*/
$sql = "SELECT  `org_name` as office FROM  `orgnization`  WHERE `org_del` =0";
	
	//工讀生key in

	$sql = "SELECT  `user_office` as office
			FROM  `ncu_user` 
			WHERE  `user_account` ='$account' ";
	$ret = mysql_query($sql, $db) or die(mysql_error());
	if(is_null(mysql_fetch_assoc($ret))){
		$sql = "SELECT  `org_name` as office
			FROM  `orgnization` 
			WHERE  `org_del` =0
			ORDER BY  `org_id` ";
	}
	else{
		$account=$_SESSION['valid_office_account'];
		$sql = "SELECT  `user_office` as office
			FROM  `ncu_user` 
			WHERE  `user_account` ='$account' ";

	}

	if($_SESSION['valid_token'] ==3){
	$sql = "SELECT  `org_name` as office
			FROM  `orgnization` 
			WHERE  `org_del` =0
			ORDER BY  `org_id` ";}
			else{
			$account=$_SESSION['valid_office_account'];
	//單位申請 固定申請人	
	$sql = "SELECT  `user_office` as office
			FROM  `ncu_user` 
			WHERE  `user_account` ='$account' ";
				}
	
	$ret = mysql_query($sql, $db) or die(mysql_error());
	
	
?>
								<td>
									<select name="office" id="office" style="font-size: 14pt; height: 25px;">
<?php
									while($row = mysql_fetch_assoc($ret))
									{
										echo "
																								
												<option value='".$row['office']."'>".$row['office']."</option>
											";									
									}
?>
									</select>						
								</td>	
<!--
	<td><input type="text" name="office" id="office" size="30" class="textstyle titleHintBox" title="請輸入發佈單位" /></td>
-->
							</tr>
							<tr>
								<td align="right"><label for="phone" style="color: #AF0000;">聯絡電話：</label></td>
								<td><input type="text" name="phone" id="phone" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入聯絡電話" /></td>
							</tr>
							<tr>
								<td align="right"><label for="email" style="color: #AF0000;">聯絡信箱：</label></td>
								<td><input type="text" name="email" id="email" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入聯絡信箱" /></td>
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
							$("#b").click(function(){
								alert($("#r.value()"));
							});
							
							$('#type4').click(function(){
								$('select[name="life_sub"]').val('4');
								//alert($("select[name='life_sub'].value()"));
							})
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
