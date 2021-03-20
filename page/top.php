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


<section id="verticalScrollContainer">

<div class="BestUserContainer">
	<div class="profilMisEnAvant">
		<h3>Certifiés</h3>
		<ul>
			<li onclick="document.location.href='./user/Bouba'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/JeSuisMalin'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/LesFous'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/LesFous'"><img src="./img/img1.jpg"></li>
		</ul>
		<h3>Les + actifs</h3>
		<ul>
			<li onclick="document.location.href='./user/Bouba'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/JeSuisMalin'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/LesFous'"><img src="./img/img1.jpg"></li>
			<li onclick="document.location.href='./user/LesFous'"><img src="./img/img1.jpg"></li>
		</ul>
	</div>
</div>





<!-- fil actu du plus au moins liké -->

<?php foreach($GLOBALS["docs"]->get_documents(true) as $doc) { 
	if ($doc->is_visible()){
		$urlIMG=$doc->url(); /*"./data/document" . */
	?>
        
        <div class="postImg">
		<!-- user -->
		<div class="postEnTete">
			<a href="#"><img src="./img/img1.jpg" alt="profil"></a>
			<a href="#">Pseudo</a>
		</div>
		<!-- content -->
		<div class="content">
			<?php 
			echo "<img src='$urlIMG' alt='content'>";
			?>
			
		</div>
		<!-- reactions -->
		<div class="postReactions">
			<div class="left">
				<a href="#"><img src="./img/svg/comment.svg"></a>
				<a href="#"><img src="./img/svg/like.svg"></a>
				<p>12</p>
			</div>
			<div class="right">
				<a href="#"><img src="./img/svg/share.svg"></a>
				<a href="#"><img src="./img/svg/bookmark.svg"></a>
			</div>
			
		</div>
	</div>

<?php
	} 
}
?>

</section>


<?php include 'bottomnav.php'; ?>

<?php include 'backgroundItems.php'; ?>

</body>
<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
</html>