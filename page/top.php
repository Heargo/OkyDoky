<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>

<?php include 'topnav.php'; ?>


<section id="verticalScrollContainer">

<div class="BestUserContainer">
	<div class="profilMisEnAvant">
		<h3 class="hidden">Certifiés</h3>
		<ul class="hidden">
			<li onclick="document.location.href='./user/Bouba'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/JeSuisMalin'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/LesFous'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/LesFous'"><img src="./img/img1.jpg"></li>
		</ul>
		<h3>Les + actifs</h3>
		<?php
			echo "<ul>";
			if(!empty(User::current()->get_communities())) {
				$currentComm = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
				$active_members = $currentComm->get_active_members();
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
				
			}
			echo "</ul>";
		?>
	</div>
</div>


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
<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
</html>
