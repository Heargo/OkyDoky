<!DOCTYPE html>
<html>
<head>
	<title>Community</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>
<div id="background-to-blur" class="">

	<?php include 'topnav.php'; ?>

	<div id ="carroussel" class="carroussel" data-current="<?=$_SESSION["current_community"]?>">
			<?php 
			$communities = User::current()->get_communities();
			foreach($communities as $comm){
				?>
				<div class="mySlides">
			      <img src="<?=$comm->get_cover()?>" alt ="<?=$comm->get_display_name()?>" data-number="<?=$comm->get_nb_members()?>" data-description="<?=$comm->get_description()?>" data-idCommu="<?=$comm->id()?>">
			  </div>
			  <?php
			}
			?>

			  <!-- Next and previous buttons -->
			  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
			  <a class="next" onclick="plusSlides(1)">&#10095;</a>

			  <!-- dots -->
			  <img onclick="switchComs();" class="dotsButton cursor" src="./img/svg/three-dots.svg">
			  <!-- Image text -->
			  <div class="caption-container">
			    <p id="caption"></p>
			    <p id="number"></p>
			  </div>
	</div>
	<div class="descCommuContainer">
		<p id="descriptionCommu"></p>
	</div>
	<section id="communityContentContainer" class="hidden">
		<h2 class="communityTitle">Mis en avant</h2>
		<div class="postImg">
			<!-- user -->
			<div class="postEnTete">
				<a href="#"><img src="./img/img1.jpg" alt="profil"></a>
				<a href="#">Pseudo</a>
			</div>
			<!-- content -->
			<div class="content">
				<img src="./img/img_5terre_wide.jpg" alt="content">
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
		<div class="adminTeamContainer">
			<!-- createur -->
			<div class="creator" onclick="document.location.href='./user/pseudo'">
				<h3>Créateur</h3>
				<img src="./img/img1.jpg" alt="profil">
				<p>Pseudo</p>
			</div>
			<!-- equipe -->
			<div class="team">
				<h3>L'équipe</h3>
				<ul>
					<li onclick="document.location.href='./user/Bouba'"><img src="./img/img1.jpg"><p>B.</p></li> <!-- B. est l'initiale du pseudo (Bouba) -->
					<li onclick="document.location.href='./user/JeSuisMalin'"><img src="./img/img1.jpg"><p>J.</p></li> <!-- J. est l'initiale du pseudo (JeSuisMalin) -->
					<li onclick="document.location.href='./user/LesFous'"><img src="./img/img1.jpg"><p>L.</p></li> <!-- etc -->
				</ul>

			</div>
			
		</div>
	</section>

<?php include 'bottomnav.php'; ?>

</div>

<section id="communitiesContainer" class="communityList hidden">
	<img onclick="switchComs();" class="cross" src="./img/svg/cross.svg">
	<h3>My communities</h3>	
	<!-- faire un tableau -->
	<div class="flex-coms-container">
	<?php
	$i = 1;
	foreach($communities as $comm){
		?>
		<div onclick="showSpecificSlide(<?php echo "$i"; ?>);switchComs();">
			<img class="communityPreview" src="<?=$comm->get_cover()?>">
			<p class="communityPreviewLabel"><?=$comm->get_display_name()?></p>
		</div>
		<?php
		$i++;
	}
		?>
	</div>
</section>


<script src="<?= Routes::url_for('/js/community.js')?>"></script>
</body>
</html>