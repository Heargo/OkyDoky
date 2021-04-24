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
    $average = new Permission(P::AVERAGE);
    $comm->promote($user,$average);
}