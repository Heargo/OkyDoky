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
<?php include 'bottomnav.php'; ?>

<?php include 'backgroundItems.php'; ?>


<form id="searchForm" class="noselect" enctype="multipart/form-data">
	<!-- searchBar -->
	<input id="searchBar" type="search" name="search" placeholder="Cherchez une communauté, un doc ou vos amis...">
	<!-- checkboxes -->
	<div class="checkboxList">
		<div>
			<input type="checkbox" id="commu" name="commu" value="commu" checked>
			<label for="commu">Communauté</label>
		</div>
		<div>
			<input type="checkbox" id="profil" name="profil" value="profil">
			<label for="profil">Profil</label>
		</div>
		<div>
			<input type="checkbox" id="doc" name="doc" value="doc">
			<label for="doc">Document</label>
		</div>
	</div>
</form>

<section id="verticalScrollContainer">
</section>




</body>
<script src="<?= Routes::url_for('/js/searchAjax.js')?>"></script>

</html>