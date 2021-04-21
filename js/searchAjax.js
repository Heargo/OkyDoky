function search(txt, typeSearch){
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

	xhr.open("POST","ajax/search/"+typeSearch,true);
	xhr.responseType="text";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("tosearch="+txt);

}

function runSearchBar(txt, typeSearch){
	var searchTo = "";
	for(i = 0; i < typeSearch.length; i++) {
		if(typeSearch[i].checked)
			searchTo = typeSearch[i].value;
	}
	search(txt, searchTo);
}



function joinOrLeave(id){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			//console.log(this.response);
			window.location.href = "./community";
		}
		else if (this.readyState ==4){
			console.log("ERREUR");
			//console.log(this);
		}
	};

	xhr.open("POST","ajax/JoinOrLeave",true);
	xhr.responseType="text";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("idCommu="+id);
}


try{
	search("","commu");
	const searchbar = document.getElementById("searchBar");
	const radioTypeSearch = document.getElementsByName("typeSearch");
	searchBar.addEventListener('keyup', function(){
		searchBar.addEventListener('focus', runSearchBar(this.value, radioTypeSearch));
	});
	

	const commuRadio = document.getElementById("commu");
	const profilRadio = document.getElementById("profil");
	const docuRadio = document.getElementById("post");
	//console.log(commuRadio);
	commuRadio.addEventListener('click', function(){
		runSearchBar(searchBar.value, radioTypeSearch);
	});
	profilRadio.addEventListener('click', function(){
		runSearchBar(searchBar.value, radioTypeSearch);
	});
	docuRadio.addEventListener('click', function(){
		runSearchBar(searchBar.value, radioTypeSearch);
	});
}catch(error){}
