<?php

function format_publication(?array $match) {
    $post = $GLOBALS['posts']->get_by_id((int) $match['id']);

    if (!isset($post)) {
        header("Location: " . Config::URL_SUBDIR(false) . '/feed');
        return;
    }

    $comm = $post->community();
    
    if ($comm->get_name() != $match['comm']) {
        header("Location: " . Config::URL_SUBDIR(false) . '/feed');
        return;
    }

    $GLOBALS['page']['post']= $post;
    return $post;
}
