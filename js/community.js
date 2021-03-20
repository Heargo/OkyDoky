var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}
//showSpecificSlide
function showSpecificSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var captionText = document.getElementById("caption");
  var numberText = document.getElementById("number");
  var descText = document.getElementById("descriptionCommu");
  

  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  slides[slideIndex-1].style.display = "block";
  captionText.innerHTML = slides[slideIndex-1].childNodes[1].alt;
  numberText.innerHTML = slides[slideIndex-1].childNodes[1].dataset.number;
  descText.innerHTML = slides[slideIndex-1].childNodes[1].dataset.description;
}

function switchComs(){
	//on toogle la visibilité
	var container = document.getElementById("communitiesContainer");
	container.classList.toggle("hidden");
	//l'opacité et le scroll du fond
	var toBlurry = document.getElementById("background-to-blur");
	toBlurry.classList.toggle("blurryOverlay"); 
	var body = document.body;
	body.classList.toggle("blocScroll"); 
}
