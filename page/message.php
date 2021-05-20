<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<link rel="shortcut icon" href="<?= Routes::url_for('/img/favicon.ico')?>" type="image/x-icon" />
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
  <!-- prism -->
  <link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/prism.css')?>">


</head>
<body>
<?php 
$has_community = sizeof(User::current()->get_communities()) > 0 ? true : false;
if($has_community){
	$is_banned = $GLOBALS['communities']->get_by_id($_SESSION['current_community'])->is_banned(User::current());
}
else{
	$is_banned = false;
}


?>
<div class="topBar conv" style="background-color: #4bc0c8;height: 50px">
  <img onclick="window.history.back();" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
  <h1 class="chatTitle"><?=$has_community ? $GLOBALS['communities']->get_by_id($_SESSION['current_community'])->get_display_name() : "Tchat" ?></h1>
</div>
<?php
if(!$is_banned && $has_community){
	?>
	<section class="containerConv">
	<div class="conv" style="background: center/200vh url(<?=Routes::url_for('/img/svg/bgmsg.svg')?>)">
		<!-- en php on recup les 100 derniers et on les met de base (trié du plus ancien au plus récent) -->
		
		<div id="contentOfConv">
			<?php 
			$last100msg=$GLOBALS['messages']->load_last_100();
			foreach ($last100msg as $key => $msg) {
				affichemsg($msg);
			}

			?>
		</div>

		<div class="champSaisieMSG">
			<input id="inputMessage" type="text" placeholder="Votre message..." onkeypress="if(event.keyCode==13){send()}" >
			<img src="<?=Routes::url_for('/img/svg/send.svg')?>" onclick="send();">
		</div>
	</div>

	</section>
	<script
		src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		crossorigin="anonymous"></script>
	<script src="<?= Routes::url_for('/js/message.js')?>"></script>
	<?php
}
else if(!$has_community){
	?>
	<h2 class="banniinfomessage">Vous n'avez pas de communauté</h2>
	<?php
}
else{
	?>
	<h2 class="banniinfomessage">Vous êtes bannis de cette communauté...</h2>
	<?php
}
?>

</body>

</html>