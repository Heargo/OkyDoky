function del_comment(id){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        console.log(this.response);
        console.log(window.location.pathname + "/delcomment");

     
    };
  
    xhr.open("POST", window.location.pathname + "/delcomment", true);
    xhr.responseType="text";
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id);
}