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