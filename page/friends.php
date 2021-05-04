<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>

<div class="topBar">
	<img onclick="window.history.back();" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
	<h1 class="noselect shareTitle">Mes amis</h1>
</div>


<form id="searchFormCommu" class="noselect" enctype="multipart/form-data">
		<!-- searchBar -->
		<input id="searchBar" type="search" name="search" placeholder="Utilisateurs de la communauté...">
		<input type="hidden" name="searchFormCommu">
</form>
	
<section id="verticalScrollContainer" class="inAdminPanel">
</section>

</body>
<script src="<?= Routes::url_for('/js/searchFriends.js')?>"></script>

</html>