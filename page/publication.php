<!DOCTYPE html>
<html>
<head>
	<title>Post</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>

<div class="topBar">
	
</div>

<section class="uniquePost">
<div class="postImg">
	<!-- user -->
	<div class="postEnTete">
		<a href="#"><img src="<?= Routes::url_for('/img/img1.jpg')?>" alt="profil"></a>
		<a href="#">Pseudo</a>
		<img onclick="window.history.back();" class="cursor crossForPost" src="<?= Routes::url_for('/img/svg/cross.svg')?>">
	</div>
	<!-- content -->
	<div class="content">
		<img src='<?= Routes::url_for('/img/img_5terre_wide.jpg')?>' alt='content'>
		<h4>test</h4>
		<p>
		Voici la description de cette image, c'est une jolie ville avec de jolies maison...
		</p>
	</div>
	
	<!-- reactions -->
	<div class="postReactions">
		<div class="left">
			<a href="#"><img src="<?= Routes::url_for('/img/svg/like.svg')?>"></a>
			<p>12</p>
		</div>
		<div class="right">
			<a href="#"><img src="<?= Routes::url_for('/img/svg/share.svg')?>"></a>
			<a href="#"><img src="<?= Routes::url_for('/img/svg/bookmark.svg')?>"></a>
		</div>
	</div>
</div>	
<div class="commentaires hidden">
	<div>
		<a href="#">
			<img class="comment-img" src="<?= Routes::url_for('/img/img1.jpg')?>" alt="profil">
		</a>
		<p class="comment"><span class="comment-pseudo">Pseudo</span>Trop belle cette photo !!
		<br>
		<span class="comment-like" >
			<img src="<?= Routes::url_for('/img/svg/like.svg')?>">12
		</span>
		</p>
		
	</div>
	<div>
		<a href="#">
			<img class="comment-img" src="<?= Routes::url_for('/img/img1.jpg')?>" alt="profil">
		</a>
		<p class="comment"><span class="comment-pseudo">Pseudo</span>Trop belle cette photo !! Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		<br>
		<span class="comment-like" >
			<img src="<?= Routes::url_for('/img/svg/like.svg')?>">12
		</span>
		</p>
		
	</div>
	<div>
		<a href="#">
			<img class="comment-img" src="<?= Routes::url_for('/img/img1.jpg')?>" alt="profil">
		</a>
		<p class="comment"><span class="comment-pseudo">Pseudo</span>Trop belle cette photo !! Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.
		<br>
		<span class="comment-like" >
			<img src="<?= Routes::url_for('/img/svg/like.svg')?>">12
		</span>
		
		</p>
		
		
	</div>
</div>
</section>


</body>
</html>