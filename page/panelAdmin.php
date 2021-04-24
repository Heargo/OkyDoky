<?php 
$isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
$isOwner=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::OWNER);
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
			$userID=2; //à generer via la recherche ajax 
			$actualUser = $GLOBALS['users']->get_by_id($userID);
			$isInTeam= $actualUser->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
			$isCertified = $actualUser->is_certified($comm);
			?>
			<img onclick="toogleSettingsOfUser(<?=$userID?>);" class="userManageButton cursor" src="<?= Routes::url_for('/img/svg/user-cog.svg')?>" alt="manageUser">
			<ul id="Settings-<?=$userID?>" class="menuSettings hidden">
				<?php if($isOwner): ?>
					<?php if($isInTeam): ?>
					<li onclick="unpromote_user(<?= $id ?>,<?=$userID?>)" id="unpromote-button">Supprimmer de l'équipe</li>
					<li onclick="promote_user(<?= $id ?>,<?=$userID?>)" id="promote-button" class="hidden">Ajouter à l'équipe</li>
					<?php else: ?>
					<li onclick="unpromote_user(<?= $id ?>,<?=$userID?>)" id="unpromote-button" class="hidden">Supprimmer de l'équipe</li>
					<li onclick="promote_user(<?= $id ?>,<?=$userID?>)" id="promote-button">Ajouter à l'équipe</li>
					<?php endif ?>
				<?php endif ?>
				<?php if($isCertified): ?>
					<li onclick="uncertify_user(<?= $id ?>,<?=$userID?>)" id="uncertify-button">Décertifier</li>
					<li onclick="certify_user(<?= $id ?>,<?=$userID?>)" id="certify-button" class="hidden">Certifier</li>
					<?php else: ?>
					<li onclick="uncertify_user(<?= $id ?>,<?=$userID?>)" id="uncertify-button" class="hidden">Décertifier</li>
					<li onclick="certify_user(<?= $id ?>,<?=$userID?>)" id="certify-button">Certifier</li>
				<?php endif ?>
				<li >Bannir</li>
			</ul>
		</div>
	</section>
	<script src="<?= Routes::url_for('/js/panelAdmin.js')?>"></script>

<?php elseif($_GET["page"]=="posts"): ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script src="<?= Routes::url_for('/js/share.js')?>"></script>
    <section id="verticalScrollContainer" class="inAdminPanel">
		<h2 class="communityTitle">Mis en avant</h2>
		<?php
		$currentCom = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
		$highlight_post  = $GLOBALS['posts']->get_by_most_votes($currentCom);

		if(sizeof($highlight_post) != 0){
			load_post($highlight_post[0]);

			?>
			<form enctype="multipart/form-data" action="<?= Routes::url_for('')?>" method="post">
				<input type="submit" class="delInput cursor" name="delMiseAvant" value="Supprimer la mise en avant">
				<input type="number" name="idPost" value="<?=$highlight_post[0]->id()?>" hidden>
			</form>
			<?php 
		}
		else{
			echo "<p>Pas de posts mis en avant.</p>";
		}
		?>
		<br>
		<?php

		$hiddenPosts =$GLOBALS["posts"]->get_by_community($comm, false, 10, 0);
		if (sizeof($hiddenPosts)==0) {
			?>
			<p>Il n'y as aucun post modéré dans cette communauté.</p>
			<?php 
		}

		?>
	</section>
	<script type="text/javascript">
		var page = "admin";
		var user = -1;
		var comm = -1;
		var route = "<?=Config::URL_SUBDIR(false)?>";
	</script>
	<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
	<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>

<?php elseif($_GET["page"]=="coms"): ?>
	<section id="verticalScrollContainer" class="inAdminPanel">
		<div class="commentaires">
			<?php 
			$commentsDel = [];
			if(sizeof($commentsDel)!=0) {
				foreach ($commentsDel as $key => $c) {
					load_comment($c);
				}
			}else{
				?>
				<p class="centerTxt">Il n'y a aucun commentaire supprimé sur cette communauté.</p>
				<?php
			}

			?>
		</div>
	</section>

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
