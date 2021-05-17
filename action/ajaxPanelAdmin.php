<?php

function certify_ajax(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_POST['idComm']);
    $user = $GLOBALS['users']->get_by_id($_POST['idUser']);
    $comm->certify_user($user);
}

function uncertify_ajax(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_POST['idComm']);
    $user = $GLOBALS['users']->get_by_id($_POST['idUser']);
    $comm->uncertify_user($user);
}

function promote_ajax(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_POST['idComm']);
    $user = $GLOBALS['users']->get_by_id($_POST['idUser']);
    $admin = new Permission(P::ADMIN);
    $comm->promote($user,$admin);
}


function unpromote_ajax(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_POST['idComm']);
    $user = $GLOBALS['users']->get_by_id($_POST['idUser']);
    if(!$comm->get_owner()->equals($user)){
        $average = new Permission(P::AVERAGE);
        $comm->promote($user,$average);
    }
    
}

function kick_user(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_POST['idComm']);
    $user = $GLOBALS['users']->get_by_id($_POST['idUser']);
    $comm->leave($user);
}

function ban_user(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_POST['idComm']);
    $user = $GLOBALS['users']->get_by_id($_POST['idUser']);
    $comm->ban($user);
    $GLOBALS['posts']->delete_posts_from($user,$comm);
}

function unban_user(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_POST['idComm']);
    $user = $GLOBALS['users']->get_by_id($_POST['idUser']);
    $comm->unban($user);
}
function searchProfilAdmin(?array $match){
    $allusers=$GLOBALS["users"]->search_user_by_nickname_or_display_name_in_community($_POST["tosearch"], $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]));
    foreach ($allusers as $key => $user) {
        load_user_admin($user); 
    }
}

function load_user_admin(User $user) {
    include "page/user_standalone_admin.php";
}