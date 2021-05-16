<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<link rel="shortcut icon" href="<?= Routes::url_for('/img/favicon.ico')?>" type="image/x-icon" />
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>

<div class="topBar">
	<?php $n= User::current()->nickname();
	$url=Routes::url_for("/user/$n");
	?>
	<img onclick="location.href='<?=$url?>'" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
	<h1 class="noselect profilEditTitle">Votre profil</h1>
</div>


<section class="shareContainer">


<?php 
/*MODIFICATION DU PROFIL*/
if (!isset($_GET["type"])) {
	?>
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="<?= Routes::url_for('/modify-user-profil')?>" method="post">

		<!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
		<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />

		<!-- Photo de profil -->
		<H3> Votre photo de profil : </H3>
		<img id="preview-img" class="previewImgProfil" src="<?= User::is_connected() ? User::current()->profile_pic() : 'preview' ?>" alt="preview">
		<label id ="uploadbtn" for="file" class="fileUploadLabelProfil cursor">Changer...</label>
		<input class="fileUploadInput" id="file" name="file" type="file" />

		<!-- Nom d'utilisateur -->
		<H3> Pseudo </H3>
		<input class="titleInput" type="text" name="display_name" value="<?= User::is_connected() ? User::current()->display_name() : "Nom d'utilisateur" ?>">
		<!-- Bio -->
		<H3> Bio </H3>
		<textarea class="descriptionInput" type="text" name="description"><?=trim(User::current()->description())?></textarea>

		<H3>Validez les modifications</H3>
		<label for="submit" class="submitUploadLabel cursor"><img src="./img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="create" />	
	</form>
	<?php 
}
/*MODIFICATION DU MAIL*/
elseif($_GET["type"]=="mail"){
	?>
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="<?= Routes::url_for('/modify-user-email')?>" method="post">
		<!-- Nom d'utilisateur -->
		<H3> Ancien mail </H3>
		<label><?= User::is_connected() ? User::current()->email() : "Nom d'utilisateur" ?></label>
		<H3> Nouveau mail </H3>
		<input class="titleInput" type="mail" name="newmail" value="<?= User::is_connected() ? User::current()->email() : "Nom d'utilisateur" ?>">

		<H3>Confirmez le changement d'adresse mail</H3>
		<label for="submit" class="submitUploadLabel cursor"><img src="./img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="create" />	
	</form>

	<?php
}
/*MODIFICATION DU PASSWORD*/
elseif($_GET["type"]=="password"){
	?>
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="<?= Routes::url_for('/modify-user-password')?>" method="post">
		<!-- Nom d'utilisateur -->
		<H3> Ancien mot de passe </H3>
		<input class="titleInput" autocomplete="new-password" type="password" name="oldpassword">
		<H3> Nouveau mot de passe </H3>
		<input class="titleInput" autocomplete="new-password" type="password" name="newpassword">
		<H3> Confirmation </H3>
		<input class="titleInput" autocomplete="new-password" type="password" name="confirmation">

		<H3>Confirmez le changement de mot de passe</H3>
		<label for="submit" class="submitUploadLabel cursor"><img src="./img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="create" />	
	</form>

	<?php
} elseif($_GET["type"]=="delete"){
?>
	<form enctype="multipart/form-data" action="<?= Routes::url_for('/deleteProfile')?>" method="post">
		<!-- Nom d'utilisateur -->
		<H3> Pour confirmer la supression du compte, veuillez entrer votre mot de passe </H3>
		<input class="titleInput" type="password" name="passwordConfirm">
		
		<H3>Confirmez la suppression du compte</H3>
		<label for="submit" class="submitUploadLabel cursor"><img src="./img/svg/check.svg"></label>
		<input id ="submit" type="submit" value="create" />	
	</form>
<?php
}
?>

</section>


</body>
<script type="text/javascript">
	var previewType = "onlyImage";
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= Routes::url_for('/js/preview.js')?>"></script>
</html>