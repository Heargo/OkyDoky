function vote(id,value){
  if (typeof route === 'undefined') {
    route="."
  }
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    //console.log(route+"/voteU")
    if (this.readyState ==4 && this.status ==200) {
        var voteValue = this.response[0];
        var prctValeur = this.response[1]
        //on modifie l'affichage
        var up = document.getElementById("upVoteIcon-"+id);
        var down = document.getElementById("downVoteIcon-"+id);
        var prct = document.getElementById("prctQualityText-"+id);

        //les boutons up/down vote
        if (voteValue==1){
          up.setAttribute("src",route+"/img/svg/arrow-up-green.svg")
          down.setAttribute("src",route+"/img/svg/arrow-down.svg")
        }
        else if (voteValue==0){
          up.setAttribute("src",route+"/img/svg/arrow-up.svg")
          down.setAttribute("src",route+"/img/svg/arrow-down.svg")
        }else{
          up.setAttribute("src",route+"/img/svg/arrow-up.svg")
          down.setAttribute("src",route+"/img/svg/arrow-down-orange.svg")
        }
        //prct
        if (prctValeur != null){
          if (prctValeur > 50){
            prct.classList.remove("red");
            prct.classList.add("green");
          }else{
            prct.classList.remove("green");
            prct.classList.add("red");
          }
          
        }
        prct.innerHTML = prctValeur !== null ? prctValeur + "%" : prctValeur;

        updatePost(id);
    }
  };

  if (value>0){
    xhr.open("POST",route+"/voteU",true);
  }
  else{
    xhr.open("POST",route+"/voteD",true);
  }
  xhr.responseType="json";
  xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xhr.send("idpost="+id);
}

function toogleSettingsOfPost(id){
    //on cache tout le autres menus
    var allMenus = document.getElementsByClassName("menuSettings");
    var menu = document.getElementById("Settings-"+id);
    for (var i = 0; i < allMenus.length; i++) {
      if (allMenus[i] !=menu){
        allMenus[i].classList.add("hidden")
      }
    }
    //on affiche le bon
    menu.classList.toggle("hidden");

}

