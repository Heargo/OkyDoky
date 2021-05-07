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
/*  foreach ($notifs as $key => $notif) {
     $user=$notif->user(); 
  }*/
  $user=User::current(); 
  $url=Routes::url_for("/user/".$user->nickname());
  $comm=$GLOBALS['communities']->get_by_id($_SESSION['current_community']);
  ?>
  <!-- NOTIFICATION 1 -->
  <div class="card-notif">

    <img class="imgleft" src="<?=$comm->get_cover()?>">
    <div class="contentNotif interaction">
      <a class="previewSenderContainer2" href="<?=$url?>">
        <img class="previewSender" src="<?=$user->profile_pic()?>">
        <p class="nameOfSender"><?=$user->display_name()?></p>
      </a>
      
      <p class="contentNotifMsg">vous a envoyé une demande d'ami</p>
    </div>
    <div class="interactionBox">
      <img class="crossRED cursor" src="<?= Routes::url_for('/img/svg/crossRED.svg')?>">
      <img class="check cursor" src="<?= Routes::url_for('/img/svg/check.svg')?>">
    </div>
  </div>
  <!-- NOTIFICATION 2 -->
  <div class="card-notif">

    <img class="imgleft" src="<?=$comm->get_cover()?>">
    <div class="contentNotif interaction">
      <a class="previewSenderContainer2" href="<?=$url?>">
        <img class="previewSender" src="<?=$user->profile_pic()?>">
        <p class="nameOfSender"><?=$user->display_name()?></p>
      </a>
      
      <p class="contentNotifMsg">vous a donné 20 jetons !</p>
    </div>
    <div class="interactionBox">
      <img class="crossRED cursor" src="<?= Routes::url_for('/img/svg/cross.svg')?>">
    </div>
  </div>


</section>


<?php include 'backgroundItems.php'; ?>
</body>
</html>