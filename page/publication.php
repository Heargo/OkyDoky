<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/prism.css')?>">
</head>
<body>


<section class="uniquePost">
<?php load_post($GLOBALS['page']['post'],true); ?>

<?php 
$r = Routes::url_for('/c/'. $GLOBALS['page']['post']->community()->get_name().'/post/'.$GLOBALS['page']['post']->id().'/new');
?>



<div class="commentaires" id="commentairesContainer">
	<div>
	<img class="comment-img" src="<?= User::current()->profile_pic() ?>" alt="profil">
    <p class="commentForm">
        <form class="commentaire-form" enctype="multipart/form-data" action="<?=$r?>" method="post"> 
			<textarea class="commentaire-form-textarea" type="text" name="commentaire" placeholder="Ecrivez un commentaire"></textarea>
			<label class="submit-comm-label cursor" for="submit-comment">
				<img src="<?=Routes::url_for('/img/svg/send.svg')?>">
			</label>
			<input class="hidden" type="submit" id="submit-comment" name="submit">
		</form>	
</div>

    <?php foreach($GLOBALS['page']['post']->comments() as $c){
        load_comment($c); 
        }
        ?>
</div>
</section>


</body>
<script type="text/javascript">
	var route="<?=Config::URL_SUBDIR(false)?>";

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
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/likesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/favoris.js')?>"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/comments.js')?>"></script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>

</html>
