function like(id){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var rep = JSON.parse(this.response);
            var like_url = rep.heart;
            var DOM_like_url = document.getElementById('like_comment_' + id);
            var DOM_like_nb = document.getElementById('nb_likes_comment_' + id);
            var like_nb = rep.nblikes;
            if (like_nb === undefined || like_nb === null) {
                like_nb = DOM_like_nb.innerText;
            }
            DOM_like_url.setAttribute('src', like_url);
            DOM_like_nb.textContent = like_nb;
        }
    }
    xhr.open("POST", window.location.pathname + "/like", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("id_comment="+id);
}
