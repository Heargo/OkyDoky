function isEmpty(obj) {
    return Object.keys(obj).length === 0;
}

function markEmpty(bool, section) {
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

var OFFSET = OFFSET || 0;
var IDS = [];
function moreposts() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/moreposts', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var rep = this.response;
            var rep = JSON.parse(rep);

            var posts_section = document.querySelector("section#verticalScrollContainer");

            if (isEmpty(rep)) {
                markEmpty(true, posts_section);
            } else {
                markEmpty(false, posts_section);
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

    xhr.send("offset=" + OFFSET.toString());
}

window.onload = function() { // might be moved
    moreposts(); // loads first posts at load time
}

window.onscroll = function(ev) {

	if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight -2) {
        moreposts();
	}
};
