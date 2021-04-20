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

<form id="searchFormCommu" class="noselect" enctype="multipart/form-data">
	<!-- searchBar -->
	<input id="searchBar" type="search" name="search" placeholder="Utilisateurs de la communauté...">
	<input type="hidden" name="searchFormCommu">
</form>

<section id="verticalScrollContainer" class="inAdminPanel">
	<div class="profilPreviewSearch">
		<div class="profilPreviewSearchAdmin cursor" onclick="location.href='/user/user/hearstgo'">
			<img class="pictprofilPreviewSearch" src="/user/data/user/77fdd05413d64f48614a5bbd8ad2fbaa8e256c94.jpg" alt="NAME">
			<div>
				<h4 class="nameSearchPreview">Exemple</h4>
				<h4 class="nicknameSearchPreview">@exemple</h4>
			</div>
		</div>
		<!-- POUR TEST LE VISUEL -->
		<?php 
		$userID=1; //à generer via la recherche ajax 
		?>
		<img onclick="toogleSettingsOfUser(<?=$userID?>);" class="userManageButton cursor" src="<?= Routes::url_for('/img/svg/user-cog.svg')?>" alt="manageUser">
		<ul id="Settings-<?=$userID?>" class="menuSettings hidden">
			<?php if($isOwner): ?>
			<a href="">Ajouter a l'équipe</a>
			<?php endif ?>
			<a href="">Bannir</a>
		</ul>
	</div>
</section>

<?php elseif($_GET["page"]=="posts"): ?>

<!-- page admin posts -->

<?php elseif($_GET["page"]=="coms"): ?>

<!-- page admin commentaires -->


<?php endif ?>
</section>




<?php include 'bottomnavAdmin.php'; ?>
</body>

<script type="text/javascript">
	
function toogleSettingsOfUser(id){
    //on cache tout le autres menus
    var allMenus = document.getElementsByClassName("menuSettings");
    var menu = document.getElementById("Settings-"+id);
    for (var i = 0; i < allMenus.length; i++) {
      if (allMenus[i] !=menu){
        allMenus[i].classList.add("hidden")
      }
    }
    //on affiche le bon
    menu.classList.toggle("hidden");

}

</script>

</html>
	























<?php
}else{
	header("Location: ./feed");
}

?>