<section class="topNav">
	<h1 class="noselect">OkyDoky</h1>
	<p><?= User::is_connected() ? User::current()->nickname() : "anonyme" ?></p>	
	<a href="#">
		<img class="small-bubble-2 noselect" src="./img/img1.jpg" alt="communauté">
	</a>
</section>