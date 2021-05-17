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

<?php 
	$comm=$GLOBALS['page']['post']->community();
	$user=$GLOBALS['page']['post']->publisher();
	if ($comm->is_banned(User::current())) {
		?>
		<p class="warningPublication">Vous êtes bannis de cette communauté, vous ne pouvez pas voir les publications.</p>
		<?php
	}
	elseif($comm->is_banned($user)) {
		?>
		<p class="warningPublication">Utilisateur banni de cette communauté.</p>
		<?php
	}
	elseif (!$GLOBALS['page']['post']->is_visible()) {
		?>
		<p class="warningPublication">La publication a été supprimée.</p>
		<?php
	}
	else{
?>
<section class="uniquePost">
<?php load_post($GLOBALS['page']['post'],true); ?>

<?php 
$r = Routes::url_for('/c/'. $GLOBALS['page']['post']->community()->get_name().'/post/'.$GLOBALS['page']['post']->id().'/new');
?>



<div class="commentaires" id="commentairesContainer">
	<?php if($comm->user_in(User::current())){ ?>
	<div id="formulaireForCommentToSend">
	<img class="comment-img" src="<?= User::current()->profile_pic() ?>" alt="profil">
        <div class="commentaire-form"> 
			<textarea id="commentaireContentPost" class="commentaire-form-textarea" type="text" name="commentaire" placeholder="Ecrivez un commentaire"></textarea>
			<label onclick="sendComment('<?=$r?>')" class="submit-comm-label cursor">
				<img src="<?=Routes::url_for('/img/svg/send.svg')?>">
			</label>
		</div>	
	</div>
<?php } ?>
    <?php foreach($GLOBALS['page']['post']->comments() as $c){
        load_comment($c); 
        }
        ?>
</div>
</section>


</body>
<script type="text/javascript">
	var route="<?=Config::URL_SUBDIR(false)?>";
    var current_community = "<?= $_SESSION['current_community'] ?>";

	try {
		var input = document.getElementById("nbjetonstogive");
		var maxi = parseInt(input.max);
		input.addEventListener("input", function(){
			if (input.value>maxi) {
				input.classList.add("badinput")
			}else{
				input.classList.remove("badinput")
			}
		});
	} catch {
		//ignore
	}
	

	function enableRestore() {
		localStorage.setItem('shouldBeRestored', "true");
		//document.cookie="shouldBeRestored=1;SameSite=Lax;path=<?= Config::URL_SUBDIR(true) ?>";
	}
</script>

<script src="<?= Routes::url_for('/js/theCross.js')?>"></script>
<?php if($comm->user_in(User::current())){ ?>
	<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
	<script src="<?= Routes::url_for('/js/likesAjax.js')?>"></script>
	<script src="<?= Routes::url_for('/js/comments.js')?>"></script>
<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/favoris.js')?>"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
<?php 
}
?>

</html>
