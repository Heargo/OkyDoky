window.onscroll = function(ev) {

	if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight -2) {
		console.log("je suis en bas !");
		console.log("faire la requete ajax");
		console.log("modif la page");
	}
};