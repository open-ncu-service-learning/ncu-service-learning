<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>passport angel</title>
<link rel="stylesheet" href="lightbox.css" type="text/css" />
<script type="text/javascript" src="lightbox.js"></script>

<script type="text/javascript" src="./fancybox/jquery.min.js"></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".link").fancybox({
			'overlayShow'	: true,
			'titlePosition'	: 'inside',
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		});
		
		$("[rel=news_group]").fancybox({
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'titlePosition' 	: 'over',
			'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
				return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
			}
		});
	});
</script>


<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<!--<style type="text/css">

  .linkstyle-2 {

font-size: 12px;

color: #9B9BDD;

}

.linkstyle-2 a{

font-size: 12px;

color: #9B9BDD;

text-decoration: underline;

}

.linkstyle-2 a:hover{

font-size: 12px;

color: #9B9BDD;

text-decoration: underline;

background-color: #4A4A71;

}

</style>-->
</head>

<body>
<center>
  <div align="center"><img src="images/f_pass.jpg" alt="first" width="1024" height="1163" border="0" usemap="#Map1" id="f_pass" />
  <map name="Map1" id="Map1">
    <!--<area shape="rect" coords="795,115,897,162" href="images/f_c.jpg" alt="天使徵選" />
	    <area class="link" shape="rect" coords="199,315,499,369" href="#apply_tea_time" alt="" />-->
	<area class="link" shape="rect" coords="795,115,897,162" href="images/f_c.jpg" alt="天使徵選" />
   
    <!--<area class="link" shape="rect" coords="801,178,895,212" href="#box_service" alt="走進" />-->
	<area class="link" shape="rect" coords="801,178,895,212" href="http://140.115.184.158/angel-21.php" alt="走進" />
    <area shape="rect" coords="792,224,894,263" href="http://140.115.184.158/angel-2.php" alt="啟程" />
    <area shape="rect" coords="771,274,898,311" href="images/ftt.jpg" alt="上山" />
	<!--<area shape="rect" coords="771,274,898,311" href="http://www.youtube.com/watch?feature=player_embedded&v=fenIVMj9b78" alt="上山" />-->
    <area shape="rect" coords="340,1128,424,1154" href="http://www.ncu.edu.tw/" alt="中大首頁" />
    <area shape="rect" coords="453,1125,564,1149" href="http://service-learning.ncu.edu.tw/index.php" alt="中大服務學習網" />
    <area shape="rect" coords="589,1124,668,1154" href="http://service-learning.ncu.edu.tw/index.php" alt="關於我們" />
    <area class="link" shape="rect" coords="155,455,359,706" href="images/people/A.jpg" alt="投1" />
    <area class="link" shape="rect" coords="410,455,614,715" href="images/people/B.jpg" alt="2" />
    <area class="link" shape="rect" coords="674,458,850,698" href="images/people/C.jpg" alt="3" />
    <area class="link" shape="rect" coords="155,773,349,1025" href="images/people/D.jpg" alt="4" />
    <area class="link" shape="rect" coords="419,776,605,1019" href="images/people/E.jpg" alt="5" />
    <area class="link" shape="rect" coords="680,778,852,1021" href="images/people/F.jpg" alt="6" />
    <!--<area shape="rect" coords="273,1221,904,1478" href="http://www.youtube.com/watch?v=6YnOyeohn_Y&amp;feature=player_embedded" alt="影片" />-->
<!--	
	<tr align="middle">
	<br /><td width="60%""><iframe style="padding:20px 0px;" src="http://www.youtube.com/embed/vIYlrYZQB1k?feature=player_detailpage" frameborder="0" allowfullscreen></iframe></td>
	<!--<br /><iframe title="YouTube video player" width="640" height="360" src="http://www.youtube.com/embed/6YnOyeohn_Y" frameborder="0" allowfullscreen></iframe>-->
<!--	<td width="60%"><iframe style="padding:20px 0px;" src="http://www.youtube.com/embed/fi1boZ5uiHg?feature=player_detailpage" frameborder="0" allowfullscreen></iframe></td>
	<!--<iframe title="YouTube video player" width="700" height="450" style="padding:20px 0px;" src="" frameborder="0" allowfullscreen></iframe>-->
	</tr> -->
 -->
  </map>
  </div>
</center>

<div style="display: none;">
	<div id="box_service" style="width:800px; height:500px; overflow: hidden;">
		<iframe src="http://140.115.8.145/service/" width="99%" height="99%" ></iframe>
	</div>
</div>

</body>
</html>