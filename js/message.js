function on_se_met_en_bas(){
        obj=document.getElementById('contentOfConv');
        obj.scrollTop = obj.scrollHeight;
    }

function send(){
    var input = document.getElementById("inputMessage");

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            //on vide le champs d'entré
            input.value=""
            //on ajoute le message en dernier
            var containerMSG = document.getElementById("contentOfConv");
            containerMSG.insertAdjacentHTML('beforeend', this.response);
            on_se_met_en_bas()
        }
        else if (this.readyState ==4){
            console.log("ERREUR");
            //console.log(this);
        }
    };

    xhr.open("POST","ajax/messages/send",true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("msg="+input.value);
}

function delmsg(id){
    var msg = document.getElementById(id);
    var p = msg.querySelector("p");
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            console.log(this.response);
            p.innerHTML="Message supprimé";
            var img = msg.querySelector("img.crossForMessage");
            p.classList.add("delMSG");
            msg.removeChild(img);
        }
        else if (this.readyState ==4){
            console.log("ERREUR");
            //console.log(this);
        }
    };

    xhr.open("POST","ajax/messages/delMSG",true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id);
}

function verifMessage(id){
    var msg = document.getElementById(id);
    var p = msg.querySelector("p");
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            if(this.response[0]){
                p.innerHTML=this.response[1];
                var img = msg.querySelector("img.crossForMessage");
                p.classList.add("delMSG");
                msg.removeChild(img);
            }
            
        }
        else if (this.readyState ==4){
            console.log("ERREUR");
            //console.log(this);
        }
    };

    xhr.open("POST","ajax/messages/checkModif",true);
    xhr.responseType="json";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id+"&text="+p.innerHTML);
}

function checkDelMsg(){
    var allmsgs = document.getElementsByClassName("msg");
    
    for(i=0;i<allmsgs.length;i++){
        var id = allmsgs[i].id;
        //on garde que les 500 derniers messages
        if ((allmsgs.length>1000 && i >=allmsgs.length-1000) || allmsgs.length<=1000){
            var p = allmsgs[i].querySelector("p");
            if (p.innerHTML!="Message supprimé"){
                 verifMessage(id);
            }
        }else{
            var containerMSG = document.getElementById("contentOfConv");
            containerMSG.removeChild(document.getElementById(id));
        }
        
    }
}


function checkMSG(){
    var containerMSG = document.getElementById("contentOfConv");
    lastmsg=containerMSG.childNodes[containerMSG.childNodes.length -2];
    date=lastmsg.dataset.date;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState ==4 && this.status ==200) {
            //on ajoute les messages (déja trié du plus ancien au plus récent)
            var containerMSG = document.getElementById("contentOfConv");
            containerMSG.insertAdjacentHTML('beforeend', this.response);
            if (this.response!="" && enbas) {
                on_se_met_en_bas()
            }
            
        }
        else if (this.readyState ==4){
            console.log("ERREUR");
            //console.log(this);
        }
    };

    xhr.open("POST","ajax/messages/check",true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("lastMessage="+date);
}


window.onload = function(){on_se_met_en_bas()};
var enbas=false;
jQuery(function($) {
    $('#contentOfConv').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            enbas=true;
        }else{
            enbas=false;
        }
    })
});


//boucle toute les 1 sec
setInterval(function(){
    checkMSG(); 
}, 1000);
//boucle toute les 10 sec
setInterval(function(){
    console.log("verifie les msg supprimés & supprime les plus vieux message si besoins")
    checkDelMsg();
}, 10000);
