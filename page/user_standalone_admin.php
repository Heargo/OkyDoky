<?php 
$n=$user->nickname();
$userID=$user->id();
$url=Routes::url_for("/user/$n");
$comm = $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]);
$isItself=User::current()->id() == $userID;
$isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
$isOwner=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::OWNER);
$id = $_SESSION["current_community"];
?>
<div class="profilPreviewSearch" id="profil-<?=$userID?>">
	<div class="profilPreviewSearchAdmin cursor" onclick="location.href='location.href='<?=$url?>'">
		<img class="pictprofilPreviewSearch" src="<?=$user->profile_pic()?>" alt="<?=$user->display_name()?>">
		<div>
			<h4 class="nameSearchPreview"><?=$user->display_name()?></h4>
			<h4 class="nicknameSearchPreview">@<?=$user->nickname()?></h4>
		</div>
	</div>
	<!-- POUR TEST LE VISUEL -->
	<?php 
	
	$actualUser = $GLOBALS['users']->get_by_id($userID);
	$isInTeam= $actualUser->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
	$isCertified = $actualUser->is_certified($comm);
	$isBanned = $comm->is_banned($actualUser);
	?>
	<img onclick="toogleSettingsOfUser(<?=$userID?>);" class="userManageButton cursor" src="<?= Routes::url_for('/img/svg/user-cog.svg')?>" alt="manageUser">
	<ul id="Settings-<?=$userID?>" class="menuSettings hidden">
		<?php if($isOwner): ?>
			<?php if($isInTeam): ?>
			<li onclick="unpromote_user(<?= $id ?>,<?=$userID?>)" id="unpromote-button-<?=$userID?>">Supprimer de l'équipe</li>
			<li onclick="promote_user(<?= $id ?>,<?=$userID?>)" id="promote-button-<?=$userID?>" class="hidden">Ajouter à l'équipe</li>
			<?php else: ?>
			<li onclick="unpromote_user(<?= $id ?>,<?=$userID?>)" id="unpromote-button-<?=$userID?>" class="hidden">Supprimer de l'équipe</li>
			<li onclick="promote_user(<?= $id ?>,<?=$userID?>)" id="promote-button-<?=$userID?>">Ajouter à l'équipe</li>
			<?php endif ?>
		<?php endif ?>
		<?php if($isCertified): ?>
			<li onclick="uncertify_user(<?= $id ?>,<?=$userID?>)" id="uncertify-button-<?=$userID?>">Décertifier</li>
			<li onclick="certify_user(<?= $id ?>,<?=$userID?>)" id="certify-button-<?=$userID?>" class="hidden">Certifier</li>
			<?php else: ?>
			<li onclick="uncertify_user(<?= $id ?>,<?=$userID?>)" id="uncertify-button-<?=$userID?>" class="hidden">Décertifier</li>
			<li onclick="certify_user(<?= $id ?>,<?=$userID?>)" id="certify-button-<?=$userID?>">Certifier</li>
		<?php endif ?>
		<?php if(!$isOwner || !$isItself): ?>
		<li onclick="kick_user(<?= $id ?>,<?=$userID?>)" >Kick</li>
		<?php if(!$isBanned): ?>
		<li onclick="ban_user(<?= $id ?>,<?=$userID?>)" >Bannir</li>
		<?php else: ?>
		<li onclick="unban_user(<?= $id ?>,<?=$userID?>)" >Débannir</li>
		<?php endif ?>
		<?php endif ?>
	</ul>
</div>