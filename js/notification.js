function acceptFriend(idSender,idNotif){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("verticalScrollContainer");
			var notifToRemove = document.getElementById("notif-"+idNotif);
			var throwawayNode = container.removeChild(notifToRemove);

		}
	};

	xhr.open("POST","./ajax/acceptfriend",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("id="+idSender+"&idnotif="+idNotif);
}

function denyFriend(idSender,idNotif){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("verticalScrollContainer");
			var notifToRemove = document.getElementById("notif-"+idNotif);
			var throwawayNode = container.removeChild(notifToRemove);

		}
	};

	xhr.open("POST","./ajax/denyfriend",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("id="+idSender+"&idnotif="+idNotif);
}

function deleteNotif(idNotif){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState ==4 && this.status ==200) {
			var container = document.getElementById("verticalScrollContainer");
			var notifToRemove = document.getElementById("notif-"+idNotif);
			var throwawayNode = container.removeChild(notifToRemove);
		}
	};

	xhr.open("POST","./ajax/deletenotif",true);
	xhr.responseType="json";
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("idnotif="+idNotif);
}
