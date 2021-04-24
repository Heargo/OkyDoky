<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/style.css')?>">
</head>
<body>
<nav>
	<a href="<?= Routes::url_for('')?>" class="top-left-name cursor">OkyDoky</a>
	<?php if (!User::is_connected()){ ?>
	<a href="<?= Routes::url_for('/login')?>" class="l-sButton">Sign-up/Login</a>
	<?php } ?>
</nav>
<svg class="bg-element-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#4bc0c8" d="M0,128L80,122.7C160,117,320,107,480,133.3C640,160,800,224,960,229.3C1120,235,1280,181,1360,154.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>	
</svg>
<section id="verticalScrollContainer">
	<img src="<?=Routes::url_for('/img/svg/404.svg')?>">
</section>

<?php include 'backgroundItems.php'; ?>
</body>
</html>