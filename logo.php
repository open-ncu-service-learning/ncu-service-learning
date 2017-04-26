
<!-- Logo -->
	
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">	 	
	<div class="w3-content w3-display-container" style="position: relative;">
		<?php
		if($_SESSION['valid_token'] == "3"){
			echo "		<a href=\"pass_logout.php\" title=\"登出\" style=\"color:#ffffff;\">  <img src=\"images\\cover.png\" style='position: absolute; top: 0px; opacity: 0;'> </a>";
		}
		else{
			echo "		<a href=\"pass_login.php\" title=\"登入\" style=\"color:#ffffff;\"> <img src=\"images\\cover.png\" style='position: absolute; top: 0px; opacity: 0;'> </a>";
		}
		?>
		<a href="index.php" title=\"首頁\" style=\"color:#ffffff;\"><img class="mySlides" src="./images/cover.jpg" style="width:100%"></a>
		<!--<a href="http://service-learning.ncu.edu.tw/pass_news_content.php?news_id=887" title=\"志工招募\" style=\"color:#ffffff;\"><img class="mySlides" src="./images/677647504_o.jpg" style="width:100%"></a>-->
		<a href="http://service-learning.ncu.edu.tw/pass_news_content.php?news_id=902" title=\"金銀質獎\" style=\"color:#ffffff;\"><img class="mySlides" src="./images/price.jpg" style="width:100%"></a>
		<a href="http://service-learning.ncu.edu.tw/pass_news_content.php?news_id=907" title=\"桃園客庄\" style=\"color:#ffffff;\"><img class="mySlides" src="./images/haka.jpg" style="width:100%"></a>
		<!--<a href="http://service-learning.ncu.edu.tw/pass_news_content.php?news_id=886" title=\"首頁\" style=\"color:#ffffff;\"><img class="mySlides" src="./images/foryouforyuoth.jpg" style="width:100%"></a>-->
		<!--<a href="http://service-learning.ncu.edu.tw/pass_news_content.php?news_id=897" title=\"首頁\" style=\"color:#ffffff;\"><img class="mySlides" src="./images/farmer.jpg" style="width:100%"></a>-->
		<div class="w3-center w3-section w3-large w3-text-white w3-display-bottommiddle" style="width:100%">
			<div class="w3-left w3-padding-left w3-hover-text-khaki" onclick="plusDivs(-1)">&#10094;</div>
			<div class="w3-right w3-padding-right w3-hover-text-khaki" onclick="plusDivs(1)">&#10095;</div>
			<span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(1)"></span>
			<span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(2)"></span>
			<span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>
			<!--<span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>-->
		</div>			
	</div>
	<style>
	.mySlides {display:none}
	.w3-left, .w3-right, .w3-badge {cursor:pointer}
	.w3-badge {height:13px;width:13px;padding:0}
	</style>
	<script>
		var slideIndex = 1;
		showDivs(slideIndex);

		function plusDivs(n) {
		  showDivs(slideIndex += n);
		}

		function currentDiv(n) {
		  showDivs(slideIndex = n);
		}

		function showDivs(n) {
		  var i;
		  var x = document.getElementsByClassName("mySlides");
		  var dots = document.getElementsByClassName("demo");
		  if (n > x.length) {slideIndex = 1}    
		  if (n < 1) {slideIndex = x.length}
		  for (i = 0; i < x.length; i++) {
			 x[i].style.display = "none";  
		  }
		  for (i = 0; i < dots.length; i++) {
			 dots[i].className = dots[i].className.replace(" w3-white", "");
		  }
		  x[slideIndex-1].style.display = "block";  
		  dots[slideIndex-1].className += " w3-white";
		}
		
		var myIndex = 0;
		carousel();
		function carousel() {
			var i;
			var x = document.getElementsByClassName("mySlides");
			for (i = 0; i < x.length; i++) {
			   x[i].style.display = "none";  
			}
			myIndex++;
			if (myIndex > x.length) {myIndex = 1}    
			x[myIndex-1].style.display = "block";  
			setTimeout(carousel, 4000); // Change image every 2 seconds
		}
	</script>
