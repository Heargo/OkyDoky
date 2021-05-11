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
	  <img onclick="window.history.back();" class="backArrow cursor" src="<?= Routes::url_for('/img/svg/arrow-back-fill.svg')?>">
	  <h1 class="noselect shareTitle">Favoris</h1>
	</div>

	<?php include 'backgroundItems.php'; ?>


<section id="verticalScrollContainer">
</section>

</body>
<script type="text/javascript">
	var page = "favoris";
	var route = "<?=Config::URL_SUBDIR(false)?>";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/favoris.js')?>"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
</html>
