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

function savePosts(offset, to_add_array) {
    var previousPosts = JSON.parse(window.localStorage.getItem('posts'));
    var newPosts = {...previousPosts,...to_add_array};

    window.localStorage.setItem('posts', JSON.stringify(newPosts));
    window.localStorage.setItem('offset', offset);
}

function retrievePosts() {
    var posts = JSON.parse(window.localStorage.getItem('posts'));
    var offset = JSON.parse(window.localStorage.getItem('offset'));
    return [parseInt(offset), posts];
}

function deletePostFromStorage(id) {
    // Delete in localstorage
    var offset = retrievePosts()[0];
    var posts = retrievePosts()[1];
    delete posts[id];
    window.localStorage.setItem('posts', JSON.stringify(posts));
    window.localStorage.setItem('offset', offset - 1)
}

function clearPosts() {
    window.localStorage.removeItem('posts');
    window.localStorage.removeItem('offset');
    console.log('Storage cleared!');
}

function addPostToContainer(post_html,container,id) {
    var new_post = document.createElement("div");
    new_post.innerHTML = `${post_html}`; // à creuser
    post = new_post.firstElementChild
    container.appendChild(post);
    pre = post.querySelector("pre");
    if (pre!=null){
        Prism.highlightElement(pre);
    }
    var json_row = {[id]: post_html};
    savePosts(OFFSET || 0, json_row);
}


var OFFSET = OFFSET || 0;
var IDS = [];
function moreposts(page="feed",user="none",comm="current",reset=false) {
    console.log("moreposts() called!");
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
            //save post to be retrieved when using The Cross
            if (isEmpty(rep)) {
                markEmpty(true, posts_section,page);
            } else {
                markEmpty(false, posts_section,page);
                Object.entries(rep).forEach(([id, post_html]) => {
                    if(!IDS.includes(id)) {
                        IDS.push(id);
                        OFFSET++;
                        addPostToContainer(post_html, posts_section, id);
                    }
                });
            }
            //savePosts(OFFSET, rep);
        }
    }
    xhr.send("offset=" + OFFSET.toString()+"&page="+page+"&user="+user+"&comm="+comm);
}

window.onload = function() {
    // This block execute last, after shouldBeRestored block in feed.php

    //Load more posts only if none have been restored
    var posts_section = document.querySelector("section#verticalScrollContainer");
    if (posts_section.childElementCount === 0) {
        // We need to reset OFFSET and IDS
        try{
            moreposts(page,user,comm,true); 
        }catch{
            moreposts(undefined,undefined,undefined,true);
        }
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
