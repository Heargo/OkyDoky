<!DOCTYPE html>
<html>
<head>
	<title>Modify the profile</title>
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
	<h1 class="noselect shareTitle">Modifiez votre profil !</h1>
</div>


<section class="shareContainer">
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="<?= Routes::url_for('/modify')?>" method="post">

		<!-- Nom -->
		<H3> Nom : </H3>
		<input class="nameInput" type="text" name="name" value="<?= User::is_connected() ? User::current()->nickname() : 'Nom' ?>"> 

		<!-- Nom d'utilisateur -->
		<H3> Nom d'utilisateur : </H3>
		<input class="nameutilInput" type="text" name="name" value="<?= User::is_connected() ? User::current()->display_name() : "Nom d'utilisateur" ?>">

		<!-- Bio -->
		<H3> Bio : </H3>
		<textarea class="descriptionInput" type="text" name="bio" value="<?= User::is_connected() ? User::current()->description() : 'Bio' ?>"></textarea>

		<!-- Photo de profil -->
		<!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
		<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
		<!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
		<H3> Votre photo de profil : </H3>
		<label id ="uploadbtn" for="file" class="fileUploadLabel cursor"><img src="../img/svg/upload.svg"></label>
		<input class="fileUploadInput" id="file" name="file" type="file" />
		<img id="preview" class="hidden" src="#" alt="preview">
		
		
		<label for="submit" class="submitUploadLabel cursor"><img src="../img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="create" />	
	</form>

</section>

