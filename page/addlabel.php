<!DOCTYPE html>
<html>
<head>
	<title>Add Label</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>

<div class="topBar">
	<img onclick="window.history.back();" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
	<h1 class="noselect shareTitle">Nouvelle étiquette</h1>
</div>

<section class="shareContainer">
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="<?=Routes::url_for('/addLabel/'.$GLOBALS["page"]["userOfUrl"]->nickname())?>" method="post">
		<!-- Nom label -->
		<input class="titleInput" type="text" name="label_text" placeholder="Nom de l'étiquette">
		<!-- couleur -->
		<input type="color" name="color" id="colorpicker" ></input>
        <label for="colorpicker">Couleur de l'étiquette</label>
		
		<label for="submit" class="submitUploadLabel cursor"><img src="./img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="create" />	
	</form>

</section>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= Routes::url_for('/js/imagePreview.js')?>"></script>
</html>