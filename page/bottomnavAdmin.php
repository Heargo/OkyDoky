<nav class="bottomNav">
	<!-- home -->
	<a class="bottomNavElement" href="?page=home">
	<img id="previewCommunityBottomNav" class="small-bubble noselect" src="<?= $GLOBALS["communities"]->get_by_id($_SESSION["current_community"])->get_cover();?>" alt="communauté">
	</a>
	<!-- users -->
	<a class="bottomNavElement" href="?page=users">
		<img class="adminBottomNavElement" src="<?= Routes::url_for('/img/svg/users.svg')?>">
	</a>
	<!-- posts -->
	<a class="bottomNavElement" href="?page=posts">
		<img class="adminBottomNavElement" src="<?= Routes::url_for('/img/svg/document-stack.svg')?>">
	</a>
	<!-- coms -->
	<a class="bottomNavElement" href="?page=coms">
		<img src="<?= Routes::url_for('/img/svg/comment.svg')?>">
	</a>
	
</nav>
