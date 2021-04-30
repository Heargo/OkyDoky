var commu = document.getElementById("communitySelected");
var input = document.getElementById("number");
var number = document.getElementById("number");


function updateLabel(){
	var nbjetonsLabel = document.getElementById("numberOfJeton");
	var infos = JSON.parse(commu.value);
	if(input.value!=""){
		nbjetonsLabel.innerHTML=infos['nbjetons']-parseInt(input.value);
	}else{
		nbjetonsLabel.innerHTML=infos['nbjetons'];
	}
	
}

function updateXP(){
	var infos = JSON.parse(commu.value);
	var com = infos['id'];
	var jetonInCom= infos['nbjetons'];
	if(input.value!=""){
		var xp = parseInt(infos["currentXpPoint"])+(parseInt(input.value)*10)
	}else{
		var xp = parseInt(infos["currentXpPoint"])
	}
	if(parseInt(input.value)<=jetonInCom){
		var tot = infos['xpToNextLevel']
		var prct = xp/tot*100
		if (prct>100){
			prct=100;
		}
		//change la barre d'xp
		var infosXp = document.getElementById("infosXpNumber");
		infosXp.innerHTML=xp+"/"+tot;
		var barrexp = document.getElementById("prctXp");
		barrexp.style.width=prct+"%";
		//on change le label
		updateLabel()

	}else{

	}
	
}

commu.addEventListener("input", function(){
		updateLabel()
		var infos = JSON.parse(commu.value);
		number.max = infos["nbjetons"];
		updateXP()
});

input.addEventListener("input", function(){
		//met un 0 si le champ et vide enleve le 0 si la valaeur et sup a 0
		if(input.value==""){
			this.value=0
		}else{
			this.value=Math.round(this.value)
		}
		updateXP()
});

updateLabel()
updateXP()
var infos = JSON.parse(commu.value);
number.max = infos["nbjetons"];