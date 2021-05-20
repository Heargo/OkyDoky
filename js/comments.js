function del_comment(id){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
       	if (this.readyState == 4 && this.status == 200) {
	        var container = document.getElementById("commentairesContainer");
	        var commentaireToRemove = document.getElementById("com-"+id);
	        var throwawayNode = container.removeChild(commentaireToRemove);
	    }

     
    };
  
    xhr.open("POST", window.location.pathname + "/delcomment", true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id);
}

function restore_comment(id){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var container = document.getElementById("commentairesContainer");
            var commentaireToRemove = document.getElementById("com-"+id);
            var throwawayNode = container.removeChild(commentaireToRemove);
        }
    };
  
    xhr.open("POST", "ajax/restorecomment", true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id);
}

function toogleSettingsOfComm(id){
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
function sendComment(r){
    var text = document.getElementById("commentaireContentPost").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let form = document.getElementById("formulaireForCommentToSend")
            form.insertAdjacentHTML("afterend", this.response);
            document.getElementById("commentaireContentPost").value="";

        }
    };
    xhr.open("POST", r, true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("commentaire="+text);
}

function donate(r,to,commu){
    var togive = document.getElementById("nbjetonstogive").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let c = document.getElementById("coinToAnimAfterGive");
            if(togive>0){
                c.classList.add("animate");
                setTimeout(function(){ 
                    c.classList.remove("animate");
                    document.getElementById("nbjetonstogive").max=document.getElementById("nbjetonstogive").max-document.getElementById("nbjetonstogive").value;
                    document.getElementById("nbjetonstogive").value="";
                }, 1100);

            }
            
        }
    };
    xhr.open("POST", r, true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("number="+togive+"&to="+to+"&in="+commu);
}