<?php

function set_community(?array $match) {
    $_SESSION["current_community"] = (int) $_POST['id'];
    
}
function join_community(?array $match) {
    $id = (int) $_POST['id'];
    $tempcomm = new Community($DB, $id);
    $tempcomm->recruit(User::current());
}