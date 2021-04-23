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
        console.log("del post");
     
    };
  
    xhr.open("POST","./ajax/delpost",true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id);
}