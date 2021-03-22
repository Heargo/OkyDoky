var carrousel = document.getElementById("carroussel");
var slideIndex = parseInt(carrousel.dataset.current);
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  console.log("je passe a suiv")
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
  var navPreview = document.getElementById("previewCommunityBottomNav");

  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  slides[slideIndex-1].style.display = "block";
  captionText.innerHTML = slides[slideIndex-1].childNodes[1].alt;
  numberText.innerHTML = slides[slideIndex-1].childNodes[1].dataset.number;
  descText.innerHTML = slides[slideIndex-1].childNodes[1].dataset.description;
  navPreview.setAttribute("src",slides[slideIndex-1].childNodes[1].src);
  changeCommu(slides[slideIndex-1].childNodes[1].dataset.idcommu);
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

function changeCommu(id){
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    if (this.readyState ==4 && this.status ==200) {
     console.log("community changed");
    }
  };

  xhr.open("POST","./ajax/community/current",true);
  xhr.responseType="text";
  xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xhr.send("id="+id);
}


