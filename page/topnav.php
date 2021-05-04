<section class="topNav">
	<h1 class="noselect">OkyDoky</h1>
	<!-- <p><?= User::is_connected() ? User::current()->nickname() : "anonyme" ?></p> -->	
	<div class="uprightcontainer">
		<a href="./notifications">
			<div class="notificationIconContainer">
				<img src="<?= Routes::url_for('/img/svg/bell.svg')?>">
				<p>99</p><!-- todo nb notif : affiche 99 au max -->
			</div>
		</a>
		<a href="./bank">
			<!-- animation qui si argent pas collecté -->
				<?php 
				$can_collect =User::current()->can_collect_daily_coins_at_least_one();
				if ($can_collect) {
					$animate="animate";
				}else{
					$animate="";
				}
				?>
			<img class="coinIcon intopnav <?=$animate?> noselect" src="<?=Routes::url_for("/img/svg/coin.svg")?>" alt="bank">
		</a>
		<a href="./user/<?= User::is_connected() ? User::current()->nickname() : "anonyme" ?>">
			<img class="small-bubble-2 noselect" src="<?= User::is_connected() ? User::current()->profile_pic() : "anonyme" ?>" alt="profil">
		</a>
	</div>
	
</section>