function certify_user(idComm, idUser){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            console.log('coucou');
            var uncertif = document.getElementById("uncertify-button");
            uncertif.classList.toggle("hidden");
            var certif = document.getElementById("certify-button")
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
            document.getElementById("uncertify-button").classList.toggle("hidden");
            document.getElementById("certify-button").classList.toggle("hidden");
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
            document.getElementById("unpromote-button").classList.toggle("hidden");
            document.getElementById("promote-button").classList.toggle("hidden");
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
            document.getElementById("unpromote-button").classList.toggle("hidden");
            document.getElementById("promote-button").classList.toggle("hidden");
        }

     
    };
  
    xhr.open("POST", "./ajax/unpromote", true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("idComm="+idComm + "&idUser="+ idUser);

}