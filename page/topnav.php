<section class="topNav">
	<h1 class="noselect">OkyDoky</h1>
	<!-- <p><?= User::is_connected() ? User::current()->nickname() : "anonyme" ?></p> -->	
	<a href="./profil">
		<img class="small-bubble-2 noselect" src="<?= User::is_connected() ? User::current()->profile_pic() : "anonyme" ?>" alt="profil">
	</a>
</section>