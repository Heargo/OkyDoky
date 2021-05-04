<!DOCTYPE html>
<html>
<head>
	<title>Community</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
	<!-- prism -->
  	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/prism.css')?>">
</head>
<body>
<div id="background-to-blur" class="">

	<?php include 'topnav.php'; ?>

<?php

$communities = User::current()->get_communities();
if(!empty($communities)){
	$isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
}

if (sizeof($communities)>0){ ?>
	<div id ="carroussel" class="carroussel" data-current="<?=$_SESSION["current_community"]?>">
			<?php 
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
			  <img onclick="switchComs();" class="dotsButton cursor" src="./img/svg/three-dots.svg">			  <!-- Image text -->
			  <div class="caption-container">
			    <p id="caption"></p>
			    <p id="number"></p>
			  </div>
	</div>
	<div class="descCommuContainer">
		<p id="descriptionCommu"></p>

		<?php if($isAdmin){ ?>
			<a class="editCommubtn" href="<?= Routes::url_for('/panel-admin')?>">Panel administrateur<img  src="<?= Routes::url_for('/img/svg/edit.svg')?>"></a>
		<?php } ?>
	</div>
	<section id="communityContentContainer">
		<h2 class="communityTitle">Mis en avant</h2>
		<?php
			$currentCom = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
			$highlight_post = $currentCom->get_highlight_post();
			if(isset($highlight_post) && $highlight_post->is_visible()){
				load_post($highlight_post);
			}
			else{
				echo "<p>Pas de posts mis en avant... C'est triste</p>";
			}
			
			load_admin_container();

			get_rules(array());
		?>
		
	</section>


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
<?php
}
else{
	?>
	<section id="verticalScrollContainer">
	<?php 
	$allcoms=$GLOBALS["communities"]->search_community("");
	foreach ($allcoms as $key => $com) {?>

	<div id="idCom-<?=$com->id()?>" class="communityPreviewSearch">
		<div>
			<img class="communityImgSearch" src="<?=$com->get_cover();?>" alt="<?=$com->get_display_name();?>">
			<div class="communityLabelSearch">
				<p class="title"><?=$com->get_display_name();?></p>
				<p><?=$com->get_description();?></p>
			</div>
		</div>
		<button onclick="joinOrLeave(<?=$com->id()?>);">Join</button>
	</div>
	<?php 
	}
	?>
</section>
<script src="<?= Routes::url_for('/js/searchAjax.js')?>"></script>
<?php 
}
?>

<?php include 'bottomnav.php'; ?>


<script src="<?= Routes::url_for('/js/community.js')?>"></script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.1/showdown.min.js" integrity="sha512-L03kznCrNOfVxOUovR6ESfCz9Gfny7gihUX/huVbQB9zjODtYpxaVtIaAkpetoiyV2eqWbvxMH9fiSv5enX7bw==" crossorigin="anonymous"></script>
</body>
</html>
