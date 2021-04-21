<?php

function add_label(?array $match){
    $user = $GLOBALS['users']->get_by_nickname($match['user']);
    $currentComm = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
    $currentComm->set_label($user,$_POST['label_text'],$_POST['color']);
    $root = Config::URL_SUBDIR(false);
    $nicknameUser = $user->nickname();
    header("Location: $root/user/$nicknameUser");
}