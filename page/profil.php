<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<link rel="shortcut icon" href="<?= Routes::url_for('/img/favicon.ico')?>" type="image/x-icon" />
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
  	<link rel="stylesheet" href="<?= Routes::url_for('/styles/styleApp.css')?>">
  	<!-- prism -->
  	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/prism.css')?>">
</head>

<body>

<?php 
$myprofil=User::current()->equals($GLOBALS["page"]["userOfUrl"]);
$CU = User::current()->nickname();
$user=$GLOBALS["page"]["userOfUrl"];
if($_SESSION['current_community']>0){
	$isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
}else{
	$isAdmin=false;
}

?>
<?php if($myprofil){ ?>
<!-- DANS LES PARAMETRES ...  -->
<div id="pageparametres" class="cadre">
		<img onclick="closeparametre()" src="<?= Routes::url_for('/img/svg/cross.svg')?>"/>
		<h4>Settings</h4>
		<div class="options">
			<a href="<?= Routes::url_for("/profil-edit?type=mail")?>"> Changer mon adresse mail </a>
			<a href="<?= Routes::url_for("/profil-edit?type=password")?>"> Changer mon mot de passe </a>
			<a href="<?= Routes::url_for('/disconnect')?>"> Déconnexion  </a>
			<a href="<?= Routes::url_for("/profil-edit?type=delete")?>"> Supprimer mon compte </a>
			<a href="<?=Routes::url_for('/cgu');?>">Politique de confidentialité</a>
		</div>
</div>
<?php } ?>
<!-- RESTE DE LA PAGE -->
<div id="page">
	<div class="topBar">
	<img onclick="document.location.href='<?= Routes::url_for('/feed')?>'" class="backArrow cursor" src="<?= Routes::url_for('/img/svg/arrow-back-fill.svg')?>">
	<?php if($myprofil){ ?>
	<div class="right-container">
		<!-- AFFICHAGE DES FAVORIS -->
		<a href="<?= Routes::url_for("/user/$CU/favoris")?>"><img src="https://img.icons8.com/ios/50/000000/bookmark-ribbon--v2.png" name="favorilogo" class="logofavori"/></a>
		<!-- AFFICHAGE DES PARAMETRES -->
		<a href=javascript:void(0); onclick="afficheparameter()">
		<img src="https://img.icons8.com/ios/50/000000/settings--v1.png" class="logoparametre"/> </a>
	</div>
	<?php } ?>
	</div>

<!-- LA PAGE DE PROFIL -->
<section id="ProfilMainContainer">
	<div class="profilContainer">
		<div class="generalInfo">
			<div class="generalInfo-top">
				<div class="profil-img-modifier-container">
					<!-- IMG PROFIL -->
					<img class="pictprofil" src="<?=$user->profile_pic()?>" alt="profil">
					
					<?php if($myprofil){ ?>
					<!-- MODIF  -->
					<a href="<?= Routes::url_for("/profil-edit")?>"class="modiferprofil cursor"> Modifier <img src="https://img.icons8.com/fluent/48/000000/pencil-tip.png" /></a>
					<?php } ?>
				</div>
				
				<div class="profil-infos-container">
						<h2 class="nameprofil"><?=$user->display_name()?></h2>
					<?php if(sizeof($user->get_communities())>0){?>
					<div>
						<div class="containerBadge">
							<div class="badgeformat">
								<img src="" id="badgeIcon">
								<p id="badgeText"></p>
							</div>
						</div>
						<div class="barreXP">
							<span id="infosXpNumber">
							</span>
							<div id="prctXp" class="XpFilled" style=""></div>
						</div>
					</div>
					<?php }?>
					<div class="generalInfo-bottom">
						<!-- POSTS -->
						<div class="nbPostContainer">
							<img src="<?= Routes::url_for('/img/svg/document-outline.svg')?>" class="logocptpost"/>	
							<?=$GLOBALS["posts"]->get_num_by_publisher($user)?>
						</div>
						<?php if($myprofil){ ?>
						<!-- FRIENDS -->
						<a href="<?= Routes::url_for('/friends')?>" class="followersContainer">
							<img src="<?= Routes::url_for('/img/svg/user-outlined.svg')?>" class="logocptperso"/>
							<?=sizeof(User::current()->get_all_friends())?>
						</a>
					<?php }else{ ?>
						<?php 
						if(User::current()->asked_to_be_friend($user)){
							$class = "waiting";
						}else{
							$class = "";
						}
						

						?>
						
							<?php if(!User::current()->is_friend($user)){ ?>
								<label id="followBTN" onclick="toogleFriendship(<?=$user->id()?>)" class="followBTN <?=$class?> cursor">
								<img id="friendsubmit" src="<?=Routes::url_for('/img/svg/baseline-person-add-alt-1.svg')?>">
							<?php }else{ ?>
								<label id="followBTN" onclick="removeFriend(<?=$user->id()?>)" class="followBTN <?=$class?> cursor">
								<img id="friendsubmit" src="<?=Routes::url_for('/img/svg/round-person-remove-alt-1.svg')?>">
							<?php }?>
						</label>
					<?php }?>
					</div>

				</div>

				
			</div>
		</div>
		<?php if(strlen($user->description())>0):?>
			<p class="profilDescription"><?=$user->description()?></p>
		<?php else: ?>
			<br>
		<?php endif ?>
	</div>
<!-- RECUPERER LES COMMUNAUTES  -->
<?php

//on recupere tt les commu si c'est son profil
if ($myprofil){
	$communities = $user->get_communities();
}
//sinon on recupère que les commnautés en commun
else{
	$communities = $user->common_communities_with(User::current());
}
if (sizeof($communities)>0){ ?>
<div class="communitySelectorProfil">
    <div id="boxesContainer" class="horizontal-scroll">
    	<?php 
			foreach($communities as $comm){
				$idCom = $comm->id();
				?>
			   	<div onclick="switchFilter(<?=$idCom?>,'<?=$GLOBALS["page"]["userOfUrl"]->nickname()?>');">
					<img id="community-<?=$idCom?>" class="communityPreview-profil" src="<?=$comm->get_cover()?>"alt ="<?=$comm->get_display_name()?>">
					<p id="label-<?=$idCom?>" class="communityPreviewLabel-profil"><?=$comm->get_display_name()?></p>
					
					<?php if ($user->is_certified($comm)) {
						?>
						<img id="check-<?=$idCom?>" class="checkfilter-certif hidden" src="https://img.icons8.com/nolan/64/approval.png"/>
						<?php 
					}else{
						?>
						<img id="check-<?=$idCom?>" class="checkfilter hidden" src="<?= Routes::url_for('/img/svg/checkwhite.svg')?>">
						<?php 
					} ?>
				</div>
			  <?php
			}
			?>

	</div>
<?php
}
else{
	?>
<p>Aucune communauté rejointe</p>
<?php 
}
?>
</div>
<ul id="roleprofilContainer" class="roleprofil">
	
</ul>

<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
<form id="labelForm" class="labelForm hidden" enctype="multipart/form-data" action="<?=Routes::url_for('/addLabel/'.$GLOBALS["page"]["userOfUrl"]->nickname())?>" method="post">
	<!-- Nom label -->
	<input id="previewLabel" class="labelInput" type="text" name="label_text" placeholder="Nom de l'étiquette" autocomplete="off">
	<!-- idcommu -->
	<input id="idcommu" type="number" name="idcommu" hidden="">
	<!-- couleur -->
	<label class="colorLabel" id="color_front" for="colorpicker"></label>
	<input id="colorpicker" class="colorInput" type="color" name="color" ></input>	
	<label for="submit" class="submitUploadLabel cursor"><img src="<?=Routes::url_for('/img/svg/check.svg')?>"></label>
	<input id ="submit" type="submit" value="create" />	
</form>

</section>

<section id="verticalScrollContainer">
	
</section>

</div>
</body>
<script type="text/javascript">
	var page = "profil";
	var user = <?=$user->id()?>;
	var comm = -1;
	var route = "<?=Config::URL_SUBDIR(false)?>";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/favoris.js')?>"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/profil.js')?>"></script>
<script type="text/javascript">
	switchFilter(<?=$_SESSION["current_community"]?>,'<?=$GLOBALS["page"]["userOfUrl"]->nickname()?>')
</script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
<script src="<?= Routes::url_for('/js/post.js')?>"></script>

</html>

