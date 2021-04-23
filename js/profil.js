/*<!-- script pour colorpicker -->*/
	
var label = document.getElementById("color_front");
var input = document.getElementById("colorpicker");
var text = document.getElementById("previewLabel");

input.addEventListener("change", function(){
		label.style.backgroundColor = input.value;
		text.style.backgroundColor = input.value;
		console.log(text.style.backgroundColor);
});

function toogleformlabel() {
	var f =document.getElementById("labelForm")

	f.classList.toggle("hidden")
}

function deleteLabel(id,n,c){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("roleprofilContainer");
			var labelToRemove = document.getElementById("label-"+id);
			var throwawayNode = container.removeChild(labelToRemove);

		}
	};

	xhr.open("POST",route+"/delLabel",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("idlabel="+id+"&user="+n+"&community="+c);
}

function getLabel(n,c){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			// Supprime tous les enfant d'un élément
			var container = document.getElementById("roleprofilContainer");
			while (container.firstChild) {
				container.removeChild(container.firstChild);
			}
			container.insertAdjacentHTML('afterbegin', this.response);

		}
	};

	xhr.open("POST",route+"/getLabel",true);
	xhr.responseType="text";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("user="+n+"&community="+c);
} 


/*<!-- FONCTIONS POUR AFFICHAGE DES PARAMETRES -->*/
function afficheparameter(){
	document.getElementById('pageparametres').style.display = 'block';
	document.getElementById('page').style.opacity = '0.2';

	//document.getElementById(pageparametres).style.displat = none;
}

function closeparametre(){
	document.getElementById('pageparametres').style.display = 'none';
	document.getElementById('page').style.opacity = '1';

}


function switchFilter(n,nickname){
	var  boxes = document.getElementById("boxesContainer").childNodes;
	for (var i = 0; i < boxes.length; i++) {
		
		if (i%2!=0){
			boxe = boxes[i]
			var c= boxe.childNodes;
			var toBlurry = c[1];
			var label = c[3];
			var check = c[5];
			if (check.id=="check-"+n){
				//on toogle la visibilité du nom et du check
			    label.classList.add("hide");
			    check.classList.remove("hidden");
			    //l'opacité et le scroll du fond
			    toBlurry.classList.add("blurryOverlayProfilFilter");
			    comm=n;
			}else{
				//on toogle la visibilité du nom et du check
			    label.classList.remove("hide");
			    check.classList.add("hidden");
			    //l'opacité et le scroll du fond
			    toBlurry.classList.remove("blurryOverlayProfilFilter"); 
			}
		}
	//on supprime les posts
	verticalScrollContainer = document.getElementById("verticalScrollContainer");
	  while (verticalScrollContainer.firstChild) {
		verticalScrollContainer.removeChild(verticalScrollContainer.lastChild);
	  }	

	}
	moreposts(page,user,comm,true);

	//on gere les labels
	getLabel(nickname,n)

	var inputCommu=document.getElementById("idcommu");
	inputCommu.value=comm;
    

   
}
