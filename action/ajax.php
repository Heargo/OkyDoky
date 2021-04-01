<?php

function set_community(?array $match) {
    $_SESSION["current_community"] = (int) $_POST['id'];
    
}
function join_community(?array $match) {
    $id = (int) $_POST['id'];
    $tempcomm = new Community($DB, $id);
    $tempcomm->recruit(User::current());
}

// function more_posts(?array $match) {
    // $comm = $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]);
    // $posts = $GLOBALS["posts"]->get_by_community($comm, true, 10, (int) $match["offset"]);
//
    // $result = array();
    // foreach($posts as $post) {
        // $result[$post->id()] =
    // }
//
    // echo json_encode();
// }
