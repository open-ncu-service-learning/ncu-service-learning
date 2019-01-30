<link rel="stylesheet" href="./css/logoN.css" type="text/css" />	 
<!-- Slideshow container -->
<div class="slideshow-container">

  <!-- Full-width images with number and caption text -->
  <div class="mySlides fade">
    <div class="numbertext">1 / 4</div>
    <a href="index.php" title=首頁 style="color:#ffffff;"><img src="./images/cover.jpg" style="width:100%"></a>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">2 / 4</div>
    <a href="#" title=服務學習成果發表 style="color:#ffffff;"><img src="./images/perform.png" style="width:100%"></a>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">3 / 4</div>
    <a href="#" title=東南亞國際志工 style="color:#ffffff;"><img src="./images/vietnam.jpg" style="width:100%"></a>
  </div 
  
<div class="mySlides fade">
    <div class="numbertext">4 / 4</div>
    <a href="http://service-learning.ncu.edu.tw/oversea.php" title=東南亞國際志工 style="color:#ffffff;"><img src="./images/vietnam2.jpg" style="width:100%"></a>
  </div>


  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>


	<!-- The dots/circles -->
	<div style="text-align:center; position:absolute; bottom:0; width: 100%;">
	  <span class="dot" onclick="currentSlide(1)"></span> 
	  <span class="dot" onclick="currentSlide(2)"></span> 
	  <span class="dot" onclick="currentSlide(3)"></span> 
	  <span class="dot" onclick="currentSlide(4)"></span>
	</div>
	
</div>

<script>
	var slideIndex = 0;
	autoShowSlides();

	// Next/previous controls
	function plusSlides(n) {
	  showSlides(slideIndex += n);
	}

	// Thumbnail image controls
	function currentSlide(n) {
	  showSlides(slideIndex = n);
	}

	function showSlides(n) {
	  var i;
	  var slides = document.getElementsByClassName("mySlides");
	  var dots = document.getElementsByClassName("dot");
	  if (n > slides.length) {slideIndex = 1} 
	  if (n < 1) {slideIndex = slides.length}
	  for (i = 0; i < slides.length; i++) {
		  slides[i].style.display = "none"; 
	  }
	  for (i = 0; i < dots.length; i++) {
		  dots[i].className = dots[i].className.replace(" active", "");
	  }
	  slides[slideIndex-1].style.display = "block"; 
	  dots[slideIndex-1].className += " active";
	}

	function autoShowSlides() {
		showSlides(slideIndex += 1)
		setTimeout(autoShowSlides, 5000); // Change image every 3 seconds
	}
	
</script>

