/*<!-- script pour colorpicker -->*/
	
var label = document.getElementById("color_front");
var input = document.getElementById("colorpicker");
var text = document.getElementById("previewLabel");
var badges = ["1-bleu",
			"1-rouge",
			"1-violet",
			"2-bleu",
			"2-rouge",
			"2-violet",
			"3-bleu",
			"3-rouge",
			"3-violet",
			"4-bleu",
			"4-rouge",
			"4-violet",
			"5-bleu",
			"5-rouge",
			"5-violet",
			"final"
]

input.addEventListener("change", function(){
		label.style.backgroundColor = input.value;
		text.style.backgroundColor = input.value;
		console.log(text.style.backgroundColor);
});

function toogleformlabel() {
	var f =document.getElementById("labelForm")

	f.classList.toggle("hidden")
}


function toogleFriendship(id){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			console.log(this.response);
			document.getElementById("friendsubmit").classList.add("rotate-center")
			document.getElementById("followBTN").classList.toggle("waiting")
			setTimeout(function(){ 
				document.getElementById("friendsubmit").classList.remove("rotate-center");
		    }, 700);

			
		}
	};
	xhr.open("POST",route+"/ajax/askfriend",true);
	xhr.responseType="text";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("id="+id);
}
function removeFriend(id){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			console.log(this.response)
			document.getElementById("friendsubmit").classList.add("rotate-center")
			document.getElementById("friendsubmit").src=route+"/img/svg/baseline-person-add-alt-1.svg";
			document.getElementById("followBTN").setAttribute("onclick","toogleFriendship("+id+")");
			setTimeout(function(){ 
				document.getElementById("friendsubmit").classList.remove("rotate-center");
		    }, 700);		
		}
	};

	xhr.open("POST",route+"/ajax/removefriend",true);
	xhr.responseType="text";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("id="+id);
}
function acceptFriend(idSender,idNotif){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("verticalScrollContainer");
			var notifToRemove = document.getElementById("notif-"+idNotif);
			var throwawayNode = container.removeChild(notifToRemove);

		}
	};

	xhr.open("POST","./ajax/acceptfriend",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("id="+idSender+"&idnotif="+idNotif);
}

function denyFriend(idSender,idNotif){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("verticalScrollContainer");
			var notifToRemove = document.getElementById("notif-"+idNotif);
			var throwawayNode = container.removeChild(notifToRemove);

		}
	};

	xhr.open("POST","./ajax/denyfriend",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("id="+idSender+"&idnotif="+idNotif);
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

function updatelevel(nickname,community){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var level = this.response["level"]
			// change le badge
			var badge = document.getElementById("badgeIcon");
			if (level>32){
				badge.src=(route+"/img/svg/medals/final.svg");
			}else{
				var i = Math.round(level/2)-1;
				badge.src=(route+"/img/svg/medals/"+badges[i]+".svg");
			}
			

			//change le niveau
			var levelText = document.getElementById("badgeText");
			levelText.innerHTML=level;

			//change la barre d'xp
			var infosXp = document.getElementById("infosXpNumber");
			infosXp.innerHTML=this.response["xp_points"]+"/"+this.response["xpToNextLevel"];

			var barrexp = document.getElementById("prctXp");
			barrexp.style.width=this.response["prctCurrentXp"]+"%";

		}
	};

	xhr.open("POST",route+"/ajax/getlevel",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("user="+nickname+"&community="+community);
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

	//on met a jour le niveau
	updatelevel(nickname,n)

	var inputCommu=document.getElementById("idcommu");
	inputCommu.value=comm;
    

   
}
