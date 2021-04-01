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
			console.log(this);
		}
	};

	xhr.open("POST","ajax/search",true);
	xhr.responseType="text";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("tosearch="+txt);

}

function runSearchBar(txt){
  	//console.log(txt)
	search(txt);
}



function joinOrLeave(id){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			console.log(this.response);
			window.location.href = "./community";
		}
		else if (this.readyState ==4){
			console.log("ERREUR");
			console.log(this);
		}
	};

	xhr.open("POST","ajax/JoinOrLeave",true);
	xhr.responseType="text";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("idCommu="+id);
}


try{
	search("");
	const searchbar = document.getElementById("searchBar");

	searchBar.addEventListener('keyup', function(){
	    searchBar.addEventListener('focus', runSearchBar(this.value));
	});
}catch(error){}
