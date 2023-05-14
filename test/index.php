<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>

<style>
	* {
	box-sizing: border-box;
	}

	.row > .column {
	padding: 0 8px;
	}


	.column {
	float: left;
	width: 10%;
	}

	.cursor {
	cursor: pointer;
	}


	img.hover-shadow {
	transition: 0.3s;
	}

	.hover-shadow:hover {
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	</style>
	<body>

	<h2 style="text-align:center">Дополнительный материал от производителя</h2>

	<div class="row slides">

		<div class="column">
			<link href="/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg" itemprop="image">

			<a href="/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg"
			   data-fancybox-group="item_slider" class="popup_link fancy"
			   title="1">
				<img src="https://zoosat.ru/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg"
				     style="width:100%" onclick="openModal();currentSlide"
				     class="hover-shadow cursor">

			</a>
		</div>

		<div class="column">
			<link href="/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg" itemprop="image">
			<a href="/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg"
			   data-fancybox-group="item_slider" class="popup_link fancy"
			   title="2">
				<img src="https://zoosat.ru/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg"
				     style="width:100%" onclick="openModal();currentSlide(1)"
				     class="hover-shadow cursor">
			</a>
		</div>

		<div class="column">
			<link href="/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg" itemprop="image">
			<a href="/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg"
			   data-fancybox-group="item_slider" class="popup_link fancy"
			   title="3">
				<img src="https://zoosat.ru/upload/iblock/e6e/qdu26r91xmm0giw62qx48471ck9msicj.jpg"
				     style="width:100%" onclick="openModal();currentSlide(1)"
				     class="hover-shadow cursor">
			</a>
		</div>

	</div>







	<script>
function openModal() {
  document.getElementById('myModal').style.display = "block";
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
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
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>






<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>