function certify_user(idComm, idUser){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            console.log('coucou');
            var uncertif = document.getElementById("uncertify-button-"+idUser);
            uncertif.classList.toggle("hidden");
            var certif = document.getElementById("certify-button-"+idUser)
            certif.classList.toggle("hidden");
            console.log(uncertif);
            console.log(certif);
        }
    };
  
    xhr.open("POST", "./ajax/certify", true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("idComm="+idComm + "&idUser="+ idUser);

    }


function uncertify_user(idComm, idUser){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            document.getElementById("uncertify-button-"+idUser).classList.toggle("hidden");
            document.getElementById("certify-button-"+idUser).classList.toggle("hidden");
        }

     
    };
  
    xhr.open("POST", "./ajax/uncertify", true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("idComm="+idComm + "&idUser="+ idUser);

}
function promote_user(idComm, idUser){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            document.getElementById("unpromote-button-"+idUser).classList.toggle("hidden");
            document.getElementById("promote-button-"+idUser).classList.toggle("hidden");
        }

     
    };
  
    xhr.open("POST", "./ajax/promote", true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("idComm="+idComm + "&idUser="+ idUser);

}

function unpromote_user(idComm, idUser){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            document.getElementById("unpromote-button-"+idUser).classList.toggle("hidden");
            document.getElementById("promote-button-"+idUser).classList.toggle("hidden");
        }

     
    };
  
    xhr.open("POST", "./ajax/unpromote", true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("idComm="+idComm + "&idUser="+ idUser);

}

function kick_user(idComm,idUser){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("verticalScrollContainer");
			var userToRemove = document.getElementById("profil-"+idUser);
			var throwawayNode = container.removeChild(userToRemove);

		}
	};

	xhr.open("POST","./ajax/kickuser",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("idComm="+idComm + "&idUser="+ idUser);
}

function ban_user(idComm,idUser){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("verticalScrollContainer");
			var userToRemove = document.getElementById("profil-"+idUser);
			var throwawayNode = container.removeChild(userToRemove);

		}
	};

	xhr.open("POST","./ajax/banuser",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("idComm="+idComm + "&idUser="+ idUser);
}

function unban_user(idComm,idUser){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("verticalScrollContainer");
			var userToRemove = document.getElementById("profil-"+idUser);
			var throwawayNode = container.removeChild(userToRemove);

		}
	};

	xhr.open("POST","./ajax/unbanuser",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("idComm="+idComm + "&idUser="+ idUser);
}