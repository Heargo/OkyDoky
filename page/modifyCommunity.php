<!DOCTYPE html>
<html>
<head>
	<title>Edit Community</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>
<style type="text/css">
	.shareContainer h3{
		color: grey;
		font-size: 0.9em;
		margin-top: 22px;
	}

</style>

<div class="topBar">
	<img onclick="window.history.back();" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
	<h1 class="noselect shareTitle">Communauté</h1>
</div>

<section class="shareContainer">
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="<?= Routes::url_for('/modify-community')?>" method="post">
		
		<!-- Titre -->
		<H3> Nom de la communauté </H3>
		<?php 
			$commu = $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]);
			$title = $commu->get_display_name();
		?>
		<input class="titleInput" type="text" name="display_name" value="<?php echo $title;?>">

		<!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
		<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
		<!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
		<H3> Cover de la communauté </H3>
		<?php 
			$cover = $commu->get_cover();
		?>
		<img id="preview" class="previewImgCommu" src="<?php echo $cover;?>" alt="preview">
		<label id ="uploadbtnCommu" for="file" class="fileUploadLabelCommu cursor">Changer...</label>
		<input class="fileUploadInput" id="file" name="file" type="file" />

		<!-- Description -->
		<H3> Description de la communauté </H3>
		<?php 
			$desc = trim($commu->get_description());
		?>
		<textarea class="descriptionInput" type="text" name="description"><?php echo $desc;?></textarea>
		
		<label for="submit" class="submitUploadLabel cursor"><img src="./img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="create" />	
	</form>

</section>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= Routes::url_for('/js/imagePreview.js')?>"></script>
</html>