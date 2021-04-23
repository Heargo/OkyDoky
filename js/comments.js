function del_comment(id){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        console.log(this.response);
     
    };
  
    xhr.open("POST","./ajax/delcomment",true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id);
}