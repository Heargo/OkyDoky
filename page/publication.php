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
<div class="commentaires" style="width : 100%;">
    <?php foreach($GLOBALS['page']['post']->comments() as $c){ ?>
	<div>
		<a href="#">
			<img class="comment-img" src="<?= $c->author()->profile_pic() ?>" alt="profil">
		</a>
        <p class="comment">
            <span class="comment-pseudo"><?= $c->author()->nickname()?></span>
            <?= $c->text() ?>
		<br>
		<span class="comment-like" >
            <img src="<?= Routes::url_for('/img/svg/like.svg') //handle red heart ?>">
            <?= $c->nb_likes() ?>
            <i style='position: absolute; right:0;'><?=$c->date()?></i>
		</span>
		</p>
		
	</div>
    <?php } ?>
</div>
</section>


</body>
</html>
