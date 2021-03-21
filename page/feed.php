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


<?php 
	if($_SESSION["current_community"] == 0) {
		echo "<p>Aucune communauté rejointe !</p>";
	}
	else {

		$commTmp = $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]);
		$postsToShow = $GLOBALS["posts"]->get_by_community($commTmp);
		$cHasPosts = false;
		foreach ($postsToShow as $post) {
			$cHasPosts = true; 
			$publisher = $post->publisher();
			$titrePost = $post->title();
			$pName = $publisher->nickname();
			$profile_pic = $publisher->profile_pic();
			$docs = $post->get_documents();
			foreach ($docs as $doc) {
				if($doc->is_visible()) {
					$urlIMG = $doc->url();
					break;
				}
			}
		?>
        
    <div class="postImg">
		<!-- user -->
		<div class="postEnTete">
			<a href="#"><?php echo "<img src='$profile_pic' alt='profil'>"; ?></a>
			<a href="#"><?= $pName ?></a>
		</div>
		<!-- <div class="postTitre">
			<p>
				<?= $titrePost ?>
			</p>
		</div> -->
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
if(!$cHasPosts) {
	echo "<p>Aucun post dans cette communauté !</p>";
}
}
?>

</section>




<?php include 'bottomnav.php'; ?>

<?php include 'backgroundItems.php'; ?>
</body>
<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
</html>