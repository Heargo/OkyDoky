<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<link rel="shortcut icon" href="<?= Routes::url_for('/img/favicon.ico')?>" type="image/x-icon" />
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/prism.css')?>">
</head>
<body>

<?php include 'topnav.php'; ?>


<section class="BestUserContainerVertical">
	<div class="BestUserContainer">
		<h2>Le top de nos membres</h2>
		<div class="profilMisEnAvant">
			<?php
				if(!empty(User::current()->get_communities())) {
					echo "<h3>Plus actifs</h3><ul>";
					$currentComm = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
					$active_members = $currentComm->get_active_members(5);
					if(sizeof($active_members) != 0){
						foreach($active_members as $key => $value){
							$tmpUser = new User($GLOBALS['db'], $key);
							?>
							<li onclick="document.location.href='./user/<?=$tmpUser->nickname()?>'"><img src=<?=$tmpUser->profile_pic()?>></li>
							<?php
						}
					}
					else{
						echo "<p>Aucun utilisateur n'est actif... Quel dommage...</p>";
					}
					
					echo "</ul>";
			?>
			<h3>Mieux notés</h3>
			<?php
					echo "<ul>";
					$liked_members = $GLOBALS['users']->get_user_by_most_likes_in_community($currentComm, 5);
					
					if(sizeof($liked_members) != 0){
						foreach($liked_members as $m){
							$tmpUser = $m;
							?>
							<li onclick="document.location.href='./user/<?=$tmpUser->nickname()?>'"><img src=<?=$tmpUser->profile_pic()?>></li>
							<?php
						}
					}
					else{
						echo "<p>Aucun utilisateur n'a posté de posts... Quel dommage...</p>";
					}
					
					echo "</ul>";
			?>
			<h3>Haut niveaux</h3>
			<?php
					echo "<ul>";
					$ancient_members = $GLOBALS['users']->get_by_levelness_community($currentComm, 5);
					if(sizeof($ancient_members) != 0){
						foreach($ancient_members as $m){
							$tmpUser = $m;
							?>
							<li onclick="document.location.href='./user/<?=$tmpUser->nickname()?>'"><img src=<?=$tmpUser->profile_pic()?>></li>
							<?php
						}
					}
					else{
						echo "<p>Erreur : veuillez contacter un développeur afin qu'ils règlent le problème</p>";
					}
					echo "</ul>";
			?>
			<h3>Plus riches</h3>
			<?php
					echo "<ul>";
					$ancient_members = $GLOBALS['users']->get_by_richness_community($currentComm, 5);
					if(sizeof($ancient_members) != 0){
						foreach($ancient_members as $m){
							$tmpUser = $m;
							?>
							<li onclick="document.location.href='./user/<?=$tmpUser->nickname()?>'"><img src=<?=$tmpUser->profile_pic()?>></li>
							<?php
						}
					}
					else{
						echo "<p>Erreur : veuillez contacter un développeur afin qu'ils règlent le problème</p>";
					}
					echo "</ul>";
			?>
			<h3>Les anciens</h3>
			<?php
					echo "<ul>";
					$ancient_members = $GLOBALS['users']->get_by_ancienty_community($currentComm, 5);
					if(sizeof($ancient_members) != 0){
						foreach($ancient_members as $m){
							$tmpUser = $m;
							?>
							<li onclick="document.location.href='./user/<?=$tmpUser->nickname()?>'"><img src=<?=$tmpUser->profile_pic()?>></li>
							<?php
						}
					}
					else{
						echo "<p>Erreur : veuillez contacter un développeur afin qu'ils règlent le problème</p>";
					}
					echo "</ul>";
				}
			?>
		</div>
	</div>
</section>

<section id="verticalScrollContainer">




<!-- du + au - like (a faire) -->
<?php 
	if(empty(User::current()->get_communities())) {
		echo "<p>Aucune communauté rejointe !</p>";
	} else {		
		$commTmp = $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]);
		$postsToShow = $GLOBALS["posts"]->get_by_most_votes($commTmp);
		$cHasPosts = false;
		foreach ($postsToShow as $post) {
			$cHasPosts = true; 
			$publisher = $post->publisher();
			$titrePost = $post->title();
			$pName = $publisher->nickname();
			$profile_pic = $publisher->profile_pic();
			$docs = $post->get_documents();
			$voted = $post->hasUserVoted(User::current());
			$prct = $post->get_percent_up_down();
			foreach ($docs as $doc) {
				if($doc->is_visible()) {
					$urlIMG = $doc->url();
					break;
				}
			}
            //include "post_standalone.php";
            //ne doit plus exister à terme, tout en JS
        }

        if(!$cHasPosts) {
            echo "<p>Aucun post dans cette communauté !</p>";
        }
    }
?>

</section>


<?php include 'bottomnav.php'; ?>

<?php include 'backgroundItems.php'; ?>

</body>
<script type="text/javascript">
	var page = "top";
	var user = "none";
	var comm = "current";
</script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/favoris.js')?>"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
</html>
