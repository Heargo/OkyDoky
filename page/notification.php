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

<div class="topBar">
  <img onclick="window.history.back();" class="backArrow cursor" src="./img/svg/arrow-back-fill.svg">
  <h1 class="noselect shareTitle">Notifications</h1>
</div>

<section id="verticalScrollContainer">
  <?php 
  $notifs = $GLOBALS["notifications"]->load_all_notifs();
  foreach ($notifs as $key => $notif) {
    $sender=$notif->sender(); 
    $receiver=$notif->receiver(); 
    $url=Routes::url_for("/user/".$sender->nickname());
    $id=$notif->id();
  include "notification_standalone.php";
  }
  
  ?>
  


</section>


<?php include 'backgroundItems.php'; ?>
<script src="<?= Routes::url_for('/js/profil.js')?>"></script>
</body>
</html>