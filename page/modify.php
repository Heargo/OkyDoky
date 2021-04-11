<!DOCTYPE html>
<html>
<head>
	<title>Modify the profil</title>
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
	<h1 class="noselect profilEditTitle">Votre profil</h1>
</div>


<section class="shareContainer">
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="<?= Routes::url_for('/modify-user-profil')?>" method="post">

		<!-- Photo de profil -->
		<H3> Votre photo de profil : </H3>
		<img id="preview" class="previewImgProfil" src="<?= User::is_connected() ? User::current()->profile_pic() : 'preview' ?>" alt="preview">
		<label id ="uploadbtnProfil" for="file" class="fileUploadLabelProfil cursor">Changer...</label>
		<input class="fileUploadInput" id="file" name="file" type="file" />

		<!-- Nom d'utilisateur -->
		<H3> Pseudo </H3>
		<input class="nameutilInput" type="text" name="display_name" value="<?= User::is_connected() ? User::current()->display_name() : "Nom d'utilisateur" ?>">

		<!-- Bio -->
		<H3> Bio </H3>
		<textarea class="descriptionInput" type="text" name="description"><?=User::current()->description()?>
		</textarea>

		
		<!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
		<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
		
		
		
		<H3>Validez les modifications</H3>
		<label for="submit" class="submitUploadLabel cursor"><img src="./img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="create" />	
	</form>

</section>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= Routes::url_for('/js/imagePreview.js')?>"></script>
</html>