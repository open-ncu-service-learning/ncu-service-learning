<?php
	session_start();
	
	// 身分驗證
	if($_SESSION['valid_token'] != "3") {
		header('Location: index.php');
		exit;
	}
	
	$year = date("Y");
	$month = date("m");
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
					<h3 style="margin-top: 10px;">活動申請(個人)</h3>
					<form id="form1" name="form1" action="send_pass_apply_out_activity.php" method="post" onsubmit="return check_pass_apply_out_activityForm(form1)">
						<table width="700" style="margin-top: 20px;" border="1" cellspacing="0" cellpadding="1">
							<tr>
								<td align="right"><label for="title" style="color: #AF0000;">活動標題：</label></td>
								<td><input type="text" size="50" name="title" id="title" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入活動標題" /></td>
							</tr>
							<tr>
								<td align="right"><label for="location" style="color: #AF0000;">活動地點：</label></td>
								<td><input type="text" size="50" name="location" id="location" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入活動地點" /></td>
							</tr>
							<tr>
								<td align="right"><label for="semester" style="color: #AF0000;">學期：</label></td>
								<td>
									<input type="hidden" name="year" value="<?=$year?>" />
									<select name="school_year" style="font-size: 14pt; height: 25px;">
<?php
									//學年問題所以多減一年 1911->1912
									//裕隆哥要求改為1911
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
								<td align="right"><label for="begin_time" style="color: #AF0000;">開始時間：</label></td>
								<td>
									<input id="begin_time" name="begin_time" type="text" size="30" style="font-size: 14pt; height: 25px;" class="date-pick" />							
									<select name="begin_hour" id="begin_hour" style="font-size: 14pt; height: 25px;">
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
								<td align="right"><label for="end_time" style="color: #AF0000;">結束時間：</label></td>
								<td>
									<input id="end_time" name="end_time" type="text" size="30" style="font-size: 14pt; height: 25px;" class="date-pick" />
									<select name="end_hour" id="end_hour" style="font-size: 14pt; height: 25px;">
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
								<td align="right"><label for="type" style="color: #AF0000;">活動類別：</label></td>
								<td>
									<input type="radio" name="type" id="type1" value="1" checked /> 服務學習
									<br><input type="radio" name="type" id="type2" value="2" /> 生活知能學習
									<select name="life_sub" id="type2">
										<!--<option value="0">請選擇子項目</option>-->
										<option value="5">一般</option>
										<!--<option value="1">大一週會</option>
										<option value="6">院週會</option>
										<option value="2">大一CPR</option>
										<option value="3">自我探索與生涯規劃</option>-->
										<option value="4">國際視野</option>
									</select>
									<br><input type="radio" name="type" id="type3" value="3" /> 人文藝術學習
									<!--<br><input type="radio" name="type" id="type2" value="2" /> 國際視野
									<select name="life_sub" id="type2" style="visibility: hidden;">
										<option value="4">國際視野</option>
									</select>-->
								</td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="des" style="color: #AF0000;">活動描述：</label></td>
								<td><textarea name="des" cols="50" rows="10" id="des"></textarea></td>
							</tr>
							<tr>
								<td width="100" align="right"><label for="service_hour" style="color: #AF0000;">認證時數：</label></td>
								<td><!-- 將一般增為基本和高階-->
									<input type="radio" name="service_hour_type" value="1" checked />
										基本 <input type="text" name="service_hour_1" size="3" style="font-size: 14pt; height: 25px;" value="0" />小時 <br />
									<input type="radio" name="service_hour_type" value="2" />
										高階 <input type="text" name="service_hour" size="3" style="font-size: 14pt; height: 25px;" value="0" />小時 <br />
									<input type="radio" name="service_hour_type" value="3" />
										基本 <input type="text" name="service_hour_low" size="3" style="font-size: 14pt; height: 25px;" value="0" />小時 + 
										高階 <input type="text" name="service_hour_high" size="3" style="font-size: 14pt; height: 25px;" value="0" />小時 <br />
								</td>
							</tr>
							<!-- 刪掉認證類別 直接從認證時數去取得類別
							<tr>
								<td align="right"><label for="pass_type" style="color: #AF0000;">認證類別：</label></td>
								<td>
									<input type="radio" name="pass_type" id="pass_type1" value="1" checked /> 基本
									<input type="radio" name="pass_type" id="pass_type2" value="2" /> 高階
									<input type="radio" name="pass_type" id="pass_type3" value="3" /> 基本+高階
								</td>
							</tr>
							-->
							<tr>
								<td align="right"><label for="person">承辦人：</label></td>
								<td><input type="text" name="person" id="person" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入承辦人" /></td>
							</tr>
							<tr>
								<td align="right"><label for="office">活動單位：</label></td>
								<td><input type="text" name="office" id="office" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入活動單位" /></td>
							</tr>
							<tr>
								<td align="right"><label for="phone">聯絡電話：</label></td>
								<td><input type="text" name="phone" id="phone" size="30" style="font-size: 14pt; height: 25px;" class="textstyle titleHintBox" title="請輸入聯絡電話" /></td>
							</tr>
							<tr>
								<td align="right"><label for="service_type">服務方式：</label></td>
								<td>
									<select name="service_type" id="service_type" style="font-size: 14pt; height: 25px;">
										<option value="老殘照顧" selected="selected">老殘照顧</option>
										<option value="勞務工作">勞務工作</option>
										<option value="廁所清潔">廁所清潔</option>
										<option value="偏遠山區">偏遠山區</option>
										<option value="兒童教育">兒童教育</option>
										<option value="醫病照顧">醫病照顧</option>
										<option value="室外解說">室外解說</option>
										<option value="治安協助">治安協助</option>
										<option value="老辦公室行政">辦公室行政</option>
										<option value="其它">其它</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align="right"><label for="learn_type">學習分類：</label></td>
								<td>
									<select name="learn_type" id="learn_type" style="font-size: 14pt; height: 25px;">
										<option value="表演藝術演出欣賞(音樂、舞蹈、戲劇…)" selected="selected">表演藝術演出欣賞(音樂、舞蹈、戲劇…)</option>
										<option value="藝文展覽欣賞(書畫、美術、雕塑…)">藝文展覽欣賞(書畫、美術、雕塑…)</option>
										<option value="藝文教育、講座、研習">藝文教育、講座、研習</option>
										<option value="文史博物館參觀">文史博物館參觀</option>
										<option value="其它">其它</option>
									</select>
								</td>
							</tr>							
						</table>
						<br />
						<span style="color: #0F93FF;">《紅色的部分一定要填寫，其他可選填》</span>

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
