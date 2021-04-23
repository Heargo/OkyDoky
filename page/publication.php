<!DOCTYPE html>
<html>
<head>
	<title>Post</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>


<section class="uniquePost">
<?php load_post($GLOBALS['page']['post'],true); ?>

<?php 
$r = Routes::url_for('/c/'. $GLOBALS['page']['post']->id_community()->get_name().'/post/'.$GLOBALS['page']['post']->id().'/new');
?>



<div class="commentaires">
	<div>
	<img class="comment-img" src="<?= User::current()->profile_pic() ?>" alt="profil">
    <p class="commentForm">
        <form class="commentaire-form" enctype="multipart/form-data" action="<?=$r?>" method="post"> 
			<textarea class="commentaire-form-textarea" type="text" name="commentaire" placeholder="Ecrivez un commentaire"></textarea>
			<label class="submit-comm-label" for="submit-comment">
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
</script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/likesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/comments.js')?>"></script>

</html>
