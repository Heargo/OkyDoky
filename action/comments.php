<?php

function add_comment(?array $match) {
    $post = $GLOBALS['posts']->get_by_id((int) $match['id']);

    if (!isset($post)) {
        header("Location: " . Config::URL_SUBDIR(false) . '/feed');
        return;
    }

    $comm = $post->id_community();
    
    if ($comm->get_name() != $match['comm']) {
        header("Location: " . Config::URL_SUBDIR(false) . '/feed');
        return;
    }

    //Sanitize is done inside
    $GLOBALS['comments']->add_comment(User::current(), $post, $_POST['commentaire']);

    $root = Config::URL_SUBDIR(false);
    header("Location: $root" . '/c/' . $post->id_community()->get_name() . '/post/' . $post->id());
}
