function isEmpty(obj) {
    return Object.keys(obj).length === 0;
}

function markEmpty(bool, section,page) {
    if (page=="feed"){
        var alreadyPresent = document.getElementById("emptyFlux");
        if (bool) {
            if (!alreadyPresent) {
                var empty = document.createElement("p");
                empty.id = "emptyFlux";
                empty.innerHTML = "Il n'y a plus rien à charger :'(";
                section.appendChild(empty);
            }
        } else {
            if (alreadyPresent) {
                alreadyPresent.remove();
            }
        }
    }
    
}


var OFFSET = OFFSET || 0;
var IDS = [];
function moreposts(page="feed",user="none",comm="current",reset=false) {

    if (reset){
        OFFSET=0;
        IDS=[];
    }
    if (typeof route === 'undefined') {
    r=""
    }else{
        r=route+"/";
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', r+'ajax/moreposts', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var rep = this.response;
            var rep = JSON.parse(rep);
            var posts_section = document.querySelector("section#verticalScrollContainer");
            /*console.log(page)
            console.log(this.response)*/
            if (isEmpty(rep)) {
                markEmpty(true, posts_section,page);
            } else {
                markEmpty(false, posts_section,page);
                Object.entries(rep).forEach(([id, post_html]) => {
                    if(!IDS.includes(id)) {
                        IDS.push(id);
                        OFFSET++;
                        var new_post = document.createElement("div");
                        new_post.innerHTML = `${post_html}`; // à creuser
                        posts_section.appendChild(new_post.firstElementChild);
                    }
                });
            }

        }
    }
    xhr.send("offset=" + OFFSET.toString()+"&page="+page+"&user="+user+"&comm="+comm);

}

window.onload = function() { // might be moved
    try{
        moreposts(page,user,comm); // loads first posts at load time
    }catch{
        moreposts();
    }    
}

window.onscroll = function(ev) {

	if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight -2) {
        try{
        moreposts(page,user,comm); // loads first posts at load time
        }catch{
            moreposts();
        }
	}
};
