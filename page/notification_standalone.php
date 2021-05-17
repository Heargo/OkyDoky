<?php
if($notif->type() == "friend"){
    ?>
    <div id="notif-<?=$id?>" class="card-notif">
        <a class="previewSenderContainer" href="<?=$url?>">
        <img class="imgleft profil" src="<?=$sender->profile_pic()?>">
        </a>
        <div class="contentNotif interaction">
            <p class="nameOfSender nopreview"><?=$sender->display_name()?></p>
        <p class="contentNotifMsg">vous a envoyé une demande d'ami</p>
        </div>
        <div class="interactionBox">
        <img class="crossRED cursor" onclick="denyFriend(<?=$sender->id()?>,<?=$id?>)" src="<?= Routes::url_for('/img/svg/crossRED.svg')?>">
        <img class="check cursor" onclick="acceptFriend(<?=$sender->id()?>,<?=$id?>)" src="<?= Routes::url_for('/img/svg/check.svg')?>">
        </div>
    </div>
    <?php
}
if($notif->type() == "don"){
    $comm=$notif->community();
    ?>
    <div id="notif-<?=$id?>" class="card-notif">

    <img class="imgleft" src="<?=$comm->get_cover()?>">
    <div class="contentNotif interaction">
        <a class="previewSenderContainer2" href="<?=$url?>">
        <img class="previewSender" src="<?=$sender->profile_pic()?>">
        <p class="nameOfSender"><?=$sender->display_name()?></p>
        </a>
      
        <p class="contentNotifMsg">vous a donné <?=$notif->amount()?> jetons !</p>
    </div>
    <div class="interactionBox">
        <img class="crossRED cursor" onclick="deleteNotif(<?=$id?>)" src="<?= Routes::url_for('/img/svg/cross.svg')?>">
    </div>
    </div>
    <?php
}
if($notif->type() == "commentaire"){
    $comm=$notif->community();
    $commnickname = $comm->get_name();
    $id_post = $notif->comment_post()->id();
    ?>
    <div id="notif-<?=$id?>" class="card-notif">

    <img class="imgleft" src="<?=$comm->get_cover()?>">
    <div class="contentNotif interaction">
        <a class="previewSenderContainer2" href="<?=$url?>">
        <img class="previewSender" src="<?=$sender->profile_pic()?>">
        <p class="nameOfSender"><?=$sender->display_name()?></p>
        </a>
      
        <p class="contentNotifMsg"><?=$sender->display_name()?> a commenté : <br/> <?=$notif->comment_text()?></p>
    </div>
    <div class="interactionBox">
        <img class="crossRED cursor" onclick="deleteNotif(<?=$id?>)" src="<?= Routes::url_for('/img/svg/cross.svg')?>">
        <img class="check cursor" onclick="location.href='<?=Routes::url_for('/c/'.$commnickname.'/post/'.$id_post)?>'" src="<?= Routes::url_for('/img/svg/check.svg')?>">
    </div>
    </div>
    <?php
}
