function moreposts() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/moreposts', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var rep = this.response;
            var rep = JSON.parse(rep);

            var posts_section = document.querySelector("section#verticalScrollContainer");

            Object.entries(rep).forEach(([id, post_html]) => {
                // TODO ajoute id à la liste des id
                if(true) { // TODO uniquement si on a pas déjà l'id
                    var new_post = document.createElement("div");
                    new_post.innerHTML = `${post_html}`; // à creuser
                    posts_section.appendChild(new_post.firstElementChild);
                }
            });

        }
    }

    xhr.send("offset=0"); // A STOCKER ET INCREMENTER
}
window.onscroll = function(ev) {

	if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight -2) {
		console.log("je suis en bas !");
		console.log("faire la requete ajax");
		console.log("modif la page");
	}
};
