<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
  <!-- prism -->
  <link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/prism.css')?>">


</head>
<body>

<div class="topBar conv" style="background-color: #4bc0c8;height: 50px">
  <img onclick="window.history.back();" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
</div>

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

</body>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<script src="<?= Routes::url_for('/js/message.js')?>"></script>
</html>