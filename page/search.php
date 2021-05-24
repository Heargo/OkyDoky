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
<?php include 'bottomnav.php'; ?>

<?php include 'backgroundItems.php'; ?>


<form id="searchForm" class="noselect" enctype="multipart/form-data">
	<!-- searchBar -->
	<input id="searchBar" type="search" name="search" placeholder="Cherchez une communauté, un doc ou vos amis...">
	<!-- checkboxes -->
	<div class="checkboxList">
		<div>
			<input type="radio" id="commu" name="typeSearch" value="commu" checked>
			<label for="commu">Communauté</label>
		</div>
		<div>
			<input type="radio" id="profil" name="typeSearch" value="profil">
			<label for="profil">Profil</label>
		</div>
		<div>
			<input type="radio" id="post" name="typeSearch" value="post">
			<label for="post">Post</label>
		</div>
	</div>
</form>

<section id="verticalScrollContainer">
</section>




</body>
<script src="<?= Routes::url_for('/js/searchAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/favoris.js')?>"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/post.js')?>"></script>
</html>
