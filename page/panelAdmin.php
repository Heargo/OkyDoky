<?php 
$isAdmin=true;
$isOwner=true;
$id = $_SESSION["current_community"];
$comm = $GLOBALS["communities"]->get_by_id($id);


if ($isAdmin) {
	if (!isset($_GET["page"])) {
	header("Location: ?page=home");
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>
<div class="topBar">
	<img onclick="location.href='./community'" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
	<?php if($_GET["page"]=="home"): ?>
	<h1 class="noselect shareTitle">Panel admin</h1>
	<?php elseif($_GET["page"]=="users"): ?>
	<h1 class="noselect shareTitle">Uilisateurs</h1>
	<?php elseif($_GET["page"]=="posts"): ?>
	<h1 class="noselect shareTitle">Docs & posts</h1>
	<?php elseif($_GET["page"]=="coms"): ?>
	<h1 class="noselect shareTitle">Commentaires</h1>
	<?php endif ?>

</div>

<section class="adminpageContainer">
	
<?php if($_GET["page"]=="home"): ?>

<div class="preview">
	<img class="cover" src="<?=$comm->get_cover()?>">
	<div class="infos">
		<p><?=$comm->get_display_name()?></p>
		<p><?=$comm->get_nb_members()?></p>
	</div>
</div>

<div class="descCommuContainer">
		<p id="descriptionCommu"><?=$comm->get_description()?></p>
		<?php if($isAdmin){ ?>
			<a class="editCommubtn" href="<?= Routes::url_for('/modify-community')?>">Modifier la communauté<img  src="<?= Routes::url_for('/img/svg/edit.svg')?>"></a>
		<?php } ?>
</div>
<section id="communityContentContainer">
<?php load_admin_container(); ?>

</section>


<?php elseif($_GET["page"]=="users"): ?>

<!-- page admin users -->

<?php elseif($_GET["page"]=="posts"): ?>

<!-- page admin posts -->

<?php elseif($_GET["page"]=="coms"): ?>

<!-- page admin commentaires -->


<?php endif ?>
</section>




<?php include 'bottomnavAdmin.php'; ?>
</body>
</html>
	























<?php
}else{
	header("Location: ./feed");
}

?>