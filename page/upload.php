<!DOCTYPE html>
<html>
<head>
	<title>Post</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>

<div class="topBar">
	<img onclick="window.history.back();" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
	<h1 class="noselect shareTitle">Partagez !</h1>
</div>

<section class="shareContainer">
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="<?= Routes::url_for("/document/new")?>" method="post">
		<!-- Titre -->
		<input class="titleInput" type="text" name="title" placeholder="Titre de votre document.">

		<!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
		<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
		<!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
		<label id ="uploadbtn"for="file" class="fileUploadLabel cursor"><img src="./img/svg/upload.svg"></label>
		<input class="fileUploadInput" id="file" name="file" type="file"/>
		<img id="preview" class="hidden" src="#" alt="preview">
		<!-- Description -->
		<textarea class="descriptionInput" type="text" name="description" placeholder="Description."></textarea>

		<select id="communitySelected">
			<option value="valeur1" selected>USMB</option>
			<option value="valeur2">CMI</option>
			<option value="valeur3">Vive les pates</option>
		</select>
		
		<label for="submit" class="submitUploadLabel cursor"><img src="./img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="publier" />	

	</form>

<!-- 	<form action="." method="post">
	    <input type="hidden" name="action" value="toggle_visibility"/>
	    <input type="number" name="id" />
	    <input type="submit" />
	</form> -->


</section>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">

function readURL(input) {

	if (input.files && input.files[0]) {
    	var reader = new FileReader();
    
    	reader.onload = function(e) {
      		document.getElementById('preview').src=e.target.result
    	}
    
   		reader.readAsDataURL(input.files[0]); // convert to base64 string
   		//on change l'appercu et le bouton
   		var btn = document.getElementById('uploadbtn');
   		btn.classList.add('btn-when-preview');
   		var preview = document.getElementById('preview');
   		preview.classList.remove('hidden');
  }
}

$("#file").change(function() {
  readURL(this);
});
</script>
</html>