<?php
	session_start();
	require_once("conn/db.php");		
	require_once("function_lib.php");//cutStr
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>國立中央大學服務學習網</title>
		<link href="css/default.css" rel="stylesheet" type="text/css" />
		<link href="css/menuTheme.css" rel="stylesheet" type="text/css" />		
		<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />	
		<script type="text/javascript" src="js/JSCookMenu.js"></script>
		<script type="text/javascript" src="js/effect.js"></script>
		<script type="text/javascript" src="js/theme.js"></script>
		<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
		<script src="framework/mootools.js" type="text/javascript"></script>
		<script src="slideshow/js/slideshow.js" type="text/javascript"></script>
		<script src="slideshow/js/slideshow.kenburns.js" type="text/javascript"></script>
		<link href="slideshow/css/slideshow.css" rel="stylesheet" type="text/css" />		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<link href="css/bg.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	
	<div>
		<? require_once("logo.php");?>
		<? require_once("menu.php");?>	
	</div>

</div>
<?php
$load_count = file_get_contents("counts.txt"); 
if(empty($_COOKIE["counts"])){
  setcookie("counts","true",time()+1800);
  $load_count ++;
  file_put_contents("counts.txt",$load_count);
}

?>	
<h1 align="right"><font face="Arial" color="#0431B4" size="4" ><PRE><b>瀏覽人次：<?=$load_count?>人&#9&#9&#9&#9</b></PRE></h1>

<!--圖片放大-->
<script>

$(document).ready(function() {
    $('#pi').mouseenter(function(){
		$(this).animate({
			right: '50%',
			speed: '100',
			height: '150%',
			width: '150%'
		});
	});
});
 
$(document).ready(function() {
    $('#pi').mouseleave(function(){
		$(this).animate({
			right:'0%',
			speed: '10',
			height: '100%',
			width: '100%'
		});
	});
}); 

</script>

<!--右側浮動廣告-->
<script type="text/javascript">      
	 // 右側浮動廣告寬度  
     var fadrWidth = 250;  
   
     // 廣告預設位置  
     var fadrInitX = 0;  
     var fadrInitY = 0;  
   
     // 廣告位置 
     var fadrX = 0;  
     var fadrY = 0; 
  
     // 主要區塊大小 (廣告會置於主要區塊之右) 
     var mainBlockWidth = 550; 
  
     // FloatADRightInitial: 右側浮動廣告初始 
     function FADR_Initial()  
     { 
         // 計算廣告之位置 
         var pageWidth = document.documentElement.clientWidth || document.body.clientWidth; 
  
         // 計算右側寬度, 若右側寬度大於廣告寬度, 則廣告接在主要區塊之右 
         var edgeRight = (pageWidth - mainBlockWidth) / 2; 
  
         if (edgeRight > fadrWidth)  
         { 
             fadrInitX = edgeRight + mainBlockWidth; 
         } 
         else  
         { 
             fadrInitX = pageWidth - fadrWidth; 
         } 
 
         // 設定位置Y 
         fadrInitY = 100; 
     } 
  
     // FloatAdRightRefresh: 更新視窗位置 
     function FADR_Refresh()  
     { 
         // 預防定義不同之設定 
         var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft; 
         var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop; 
 
         // 計算每次更新之位移 
         fadrX += (fadrInitX + scrollLeft - fadrX) / 5; 
         fadrY += (fadrInitY + scrollTop - fadrY) / 5; 
 
         // 更新指定圖層之位置 
         var fadrStyle = document.getElementById('divFadR').style;  
         // 須加上'px' 
         fadrStyle.left = fadrX + 'px'; 
        fadrStyle.top = fadrY + 'px'; 
  
         // 每次更新時間，預設為50微秒 
         setTimeout('FADR_Refresh()', 50); 
     } 
  
     // FloatAdRightStart: 啟動 
     function FADR_Start()  
     { 
         FADR_Initial(); 
         FADR_Refresh(); 
     } 
  
     FADR_Start(); 
 </script>

<!-- Content -->
		<div id="content">
			<? require_once("sidebar.php");?>
			
<!-- News -->
			<div id="main">

			
			

				<div class="post">
				
<div id="TabbedPanels1" class="TabbedPanels" >
	<ul class="TabbedPanelsTabGroup">
		<li class="TabbedPanelsTab" tabindex="0">最新認證活動</li>
		<li class="TabbedPanelsTab" tabindex="0">最新公告</li>
		

	</ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">

		<!-- 公告 -->
			<select name="type" style="float: right;" onChange="location.href=this.options[this.selectedIndex].value;">
				<option value="pass_new_activity.php" <?php if (!(strcmp("", $_GET['type']))) {echo "selected";} ?>>請選擇活動類別</option>
				<option value="pass_new_activity.php?type=1" <?php if (!(strcmp(1, $_GET['type']))) {echo "selected";} ?>>服務學習</option>
				<option value="pass_new_activity.php?type=2" <?php if (!(strcmp(2, $_GET['type']))) {echo "selected";} ?>>生活知能</option>
				<option value="pass_new_activity.php?type=3" <?php if (!(strcmp(3, $_GET['type']))) {echo "selected";} ?>>人文藝術</option>
				<option value="pass_new_activity.php?type=4" <?php if (!(strcmp(4, $_GET['type']))) {echo "selected";} ?>>大一週會</option>
				<option value="pass_new_activity.php?type=5" <?php if (!(strcmp(5, $_GET['type']))) {echo "selected";} ?>>大一CPR</option>
				<option value="pass_new_activity.php?type=6" <?php if (!(strcmp(6, $_GET['type']))) {echo "selected";} ?>>自我探索與生涯規劃</option>
				<option value="pass_new_activity.php?type=7" <?php if (!(strcmp(7, $_GET['type']))) {echo "selected";} ?>>國際視野</option>
				<option value="pass_new_activity.php?type=8" <?php if (!(strcmp(8, $_GET['type']))) {echo "selected";} ?>>院週會</option>
			</select>

<?php
	$condition = "";
	if($_GET['type'] != NULL)
		if($_GET['type'] >= 1 && $_GET['type'] <= 3){
			$condition = " news_act_type ='".$_GET['type']."' AND ";
		}
		else if($_GET['type'] >= 4 && $_GET['type'] <= 8){
			if ($_GET['type'] == 8){				
				$condition = " news_act_type = '2' AND news_life_sub = '6' AND ";
			}
			else{
				$typ = $_GET['type'] - 3;
				$condition = " news_act_type = '2' AND news_life_sub ='".$typ."' AND ";				
			}
		}
	
	//管理者:全部的活動 一般使用者:只能看到近期舉辦活動(有效筆數)
	if($_SESSION['valid_token'] == "3")
		$sql = "SELECT COUNT(news_id) as num FROM news_activity WHERE $condition news_del = '0' ORDER BY news_begin_time DESC";
	else
		$sql = "SELECT COUNT(news_id) as num FROM news_activity WHERE $condition news_del = '0' AND news_end_time >= CURDATE() ORDER BY news_begin_time";
		
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$numrows = $row['num'];
	
	// 分頁
	
	$rowsPerPage=10;
	$pageNum = 1;
	
	$offset = ($pageNum - 1) * $rowsPerPage;
	
	//管理者:全部的活動 一般使用者:只能看到近期舉辦活動(公告筆數)
	if($_SESSION['valid_token'] == "3")
		$sql = "SELECT * FROM news_activity WHERE $condition news_del = '0' ORDER BY news_begin_time DESC LIMIT  $offset, $rowsPerPage";
	else
		$sql = "SELECT * FROM news_activity WHERE $condition news_del = '0' AND news_end_time >= CURDATE() ORDER BY news_begin_time LIMIT $offset, $rowsPerPage";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	
	if($numrows > 0)
	{
?>
		
				
				<div class="story">
					<div class="chart">
						<div class="item1">
							活動時間
						</div>
						<div class="item2">
							類別
						</div>
						<div class="item3">
							標題
						</div>
					</div>
					<div style="border-bottom: 1px solid #EAEAEA;"></div>
<?
		do {
				$type = "";
				switch($row['news_act_type']) {
					case 1:
						$type = "服務學習";
						break;
					case 2:
						$type = "生活知能";
						break;
					case 3:
						$type = "人文藝術";
						break;
					default:
						$type = "無";
				}
?>
						<div class="chart">
							<div class="item1">
								<? echo substr($row['news_begin_time'], 0, 10);?>
							</div>
							<div class="item2">
								<?=$type?>								
							</div>
							<div class="item3">
								<a href="pass_activity_content.php?news_id=<?=$row['news_id']?>"><?=$row['news_title']?></a>
							</div>
						</div>
<?php
		} while ($row = mysql_fetch_assoc($ret));
?>
					</div>
			
<?php
	}
	elseif($numrows == 0)
	{
?>
				<div class="story">
					<div class="chart">
						<div class="item1">
							暫無公告
						</div>
					</div>
				</div>
<?php
	}
?>
	
	<p><a href="pass_new_activity.php" style="float: right; color: #6B00DF; font-weight: bold;">[more]</a></p>
	
	
	</div>
	
	
    <div class="TabbedPanelsContent">
		<!-- 公告 -->
		<select name="type" style="float: right;" onChange="location.href=this.options[this.selectedIndex].value;">
			<option value="pass_new_news.php" <?php if (!(strcmp("", $_GET['type']))) {echo "selected";} ?>>請選擇公告類別</option>
			<option value="pass_new_news.php?type=1" <?php if (!(strcmp(1, $_GET['type']))) {echo "selected";} ?>>校內公告</option>
			<option value="pass_new_news.php?type=2" <?php if (!(strcmp(2, $_GET['type']))) {echo "selected";} ?>>校外公告</option>
	
		</select>
	<?php
	$condition = "";
	if($_GET['type'] != NULL)
		$condition_news = " news_type ='".$_GET['type']."' AND ";
	
	// 有效筆數
	$sql = "SELECT COUNT(news_id) AS numrows FROM news WHERE $condition_news news_del = '0'";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	$numrows = $row['numrows'];
	
	include("pass_paging.php");
	
	//公告資料
	$rowsPerPage=10;
	$sql = "SELECT news_time, news_id, news_title, news_type FROM news WHERE $condition_news news_del = '0' ORDER BY news_time DESC LIMIT $rowsPerPage";
	$ret = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($ret);
	
	if($numrows > 0)
	{
?>

		<div class="story">
			<ul class="chart">
				<li class="item1">
					發佈時間
				</li>

				<li class="item2" width="50px">
					類別
				</li>

				<li class="item3" width="50px">
					標題
				</li>
			</ul>
			<div style="border-bottom: 1px solid #EAEAEA;"></div>
<?
			do {
?>
			<div class="chart">
				<div class="item1">
					<? echo substr($row['news_time'], 0, 10);?>
				</div>

				<div class="item2">
					<?php					
						if($row['news_type']==1){
							echo "校內公告";
						}else if($row['news_type']==2){
							echo "校外公告";
						}else if($row['news_type']==3){
							echo "補助公告";
						}else if($row['news_type']==4){
							echo "志工招募";
						}else{
							echo "暫無分類";
						}
										
					?>
				</div>

				<div class="item3">
					<a href="pass_news_content.php?news_id=<?=$row['news_id']?>"><?=bite_str($row['news_title'], 0 , 50)?></a>							
				</div>
			</div>
			<?php
			} while ($row = mysql_fetch_assoc($ret));
			?>

	
		</div>
<?php
	}elseif($numrows == 0)
	{
?>
		<div class="story">
			<div class="chart">
				<div class="item1">
					暫無公告
				</div>
			</div>
		</div>
<?php
	}

	
	
?>
	
	<p><a href="pass_new_news.php" style="float: right; color: #6B00DF; font-weight: bold;">[more]</a></p>


	</div>
			

	
  </div><!--group -->
</div><!--panels-->

</div><!--post -->

<div class="imag"><!--類別分層-->   
	<div class="item-wrap">
		<img id="pi" width="100%" style="padding:20px 0px; position: relative; " src="images/graduate.png">
	</div>	
</div>

<!-- 20150326 更換成影片清單 -->
		<div class="video_class"><!--類別分層-->   
					<div class="item-wrap">
					<iframe title="YouTube video player" width="700" height="400" style="padding:20px 0px;" src="//www.youtube.com/embed/tk17cXrnJQ0" frameborder="0" allowfullscreen></iframe>
					<!--影片說明在這裡-->
					</div>	
		</div>	


<div class=post style="float:center">


</div>

			</div><!--main -->
		</div><!--content -->
		
		

<style>
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>
	
	<script type="text/javascript">

var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");

</script>	
	
	
		
		<? require_once("footer.php");?>

	</body>
</html>