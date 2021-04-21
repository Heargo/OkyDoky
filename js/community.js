try{
var carrousel = document.getElementById("carroussel");
var slideIndex = getSlideOfID(parseInt(carrousel.dataset.current));
showSlides(slideIndex);
}catch(error){
}




// Next/previous controls
function plusSlides(n) {
  console.log("je passe a suiv")
  showSlides(slideIndex += n);
}
//showSpecificSlide
function showSpecificSlide(n) {
  showSlides(slideIndex = n);
}


function getSlideOfID(id){
  var i;
  var slides = document.getElementsByClassName("mySlides");

  for (i = 0; i < slides.length; i++) {
    if (slides[i].childNodes[1].dataset.idcommu==id){
      console.log("Pour l'id de commu "+id+" l'index est "+(i+1))
      return parseInt(i)+1;
    }
  }
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

    //console.log("show slide"+slideIndex)
    //console.log("je passe a la commu"+slides[slideIndex-1].childNodes[1].dataset.idcommu)
    //console.log(slides[slideIndex-1].childNodes[1])
    //console.log(slides[slideIndex].childNodes[1])


    slides[slideIndex-1].style.display = "block";
    captionText.innerHTML = slides[slideIndex-1].childNodes[1].alt;
    numberText.innerHTML = slides[slideIndex-1].childNodes[1].dataset.number;
    descText.innerHTML = slides[slideIndex-1].childNodes[1].dataset.description;
    navPreview.setAttribute("src",slides[slideIndex-1].childNodes[1].src);
    
    changeCommu(slides[slideIndex-1].childNodes[1].dataset.idcommu);
    loadHP();
    loadAC();
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

function loadHP(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            var post = this.response;
            console.log(post);
            //on supprime les resultats précédents
			communityContentContainer = document.getElementById("communityContentContainer");
            var hp_zone = communityContentContainer.children[1];
            communityContentContainer.removeChild(hp_zone);
      
            //on écrit les nouveaux results
            var title = document.querySelector("#communityContentContainer>.communityTitle");
            title.insertAdjacentHTML('afterend', this.response);
        }
    };
    xhr.open("POST","./ajax/hp",true);
    xhr.send();
}

function loadAC(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            var post = this.response;
            console.log(post);
            //on supprime les resultats précédents
			communityContentContainer = document.getElementById("communityContentContainer");
            var ac_zone = communityContentContainer.children[2];
            communityContentContainer.removeChild(ac_zone);
      
            //on écrit les nouveaux results
            communityContentContainer.insertAdjacentHTML('beforeend', this.response);
        }
    };
    xhr.open("POST","./ajax/ac",true);
    xhr.send();
}


