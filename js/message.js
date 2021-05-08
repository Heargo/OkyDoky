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
            console.log(enbas);
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
