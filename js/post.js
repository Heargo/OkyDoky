function set_highlight_post(id){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        console.log("set_hp");
     
    };
  
    xhr.open("POST","./ajax/hpset",true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id);
}

function delete_post(id){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var container = document.getElementById("verticalScrollContainer");
            var postToRemove = document.getElementById(""+id);
            var throwawayNode = container.removeChild(postToRemove);
            deletePostFromStorage(id);
        }
     
    };
  
    xhr.open("POST","./ajax/delpost",true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id);
}
