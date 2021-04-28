<section class="topNav">
	<h1 class="noselect">OkyDoky</h1>
	<!-- <p><?= User::is_connected() ? User::current()->nickname() : "anonyme" ?></p> -->	
	<div class="uprightcontainer">
		<a href="./bank">
			<!-- animation qui si argent pas collecté -->
			<img class="coinIcon animate noselect" src="<?=Routes::url_for("/img/svg/coin.svg")?>" alt="bank">
		</a>
		<a href="./user/<?= User::is_connected() ? User::current()->nickname() : "anonyme" ?>">
			<img class="small-bubble-2 noselect" src="<?= User::is_connected() ? User::current()->profile_pic() : "anonyme" ?>" alt="profil">
		</a>
	</div>
	
</section>