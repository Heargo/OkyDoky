function search(txt){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			//on supprime les resultats précédents
			verticalScrollContainer = document.getElementById("verticalScrollContainer");
			  while (verticalScrollContainer.firstChild) {
				verticalScrollContainer.removeChild(verticalScrollContainer.lastChild);
			  }
			//on écrit les nouveaux results
			verticalScrollContainer.insertAdjacentHTML('afterbegin', this.response);
		}
		else if (this.readyState ==4){
			console.log("ERREUR");
			//console.log(this);
		}
	};

	xhr.open("POST","ajax/searchAdmin/",true);
	xhr.responseType="text";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("tosearch="+txt);

}

function runSearchBar(txt){
	search(txt);
}

try{
	search("");
	const searchbar = document.getElementById("searchBar");
	searchbar.addEventListener('keyup', function(){
		searchbar.addEventListener('focus', runSearchBar(this.value));
	});
	runSearchBar(searchbar.value);
}catch(error){}