function toggleFav(id,value){
  if (typeof route === 'undefined') {
    route="."
  }
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    if (this.readyState ==4 && this.status ==200) {
        var fav = document.getElementById("favIcon-"+id);
        var favButton = document.getElementById("favIconButton-"+id);
        console.log(this.response);
        if (value==1){
          // TODO : insert the filled bookmark
        	fav.setAttribute("src", route+"/img/svg/share.svg");
        	favButton.setAttribute("onclick", "toggleFav("+id+",0)");
        }
        else{
        	fav.setAttribute("src", route+"/img/svg/bookmark.svg");
        	favButton.setAttribute("onclick", "toggleFav("+id+",1)");
        }
        //prct        
    }
  };
  if (value==1){
      xhr.open("POST",route+"/addInFav",true);
  }
  else{
    xhr.open("POST",route+"/removeFav",true);
  }
  xhr.responseType="json";
  xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xhr.send("idpost="+id);
}