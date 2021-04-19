<?php

function is_url_comment_valid(int $id_post, string $name_comm) : bool {
    $post = $GLOBALS['posts']->get_by_id($id_post);

    // Post exists
    if (!isset($post)) {
        return false;
    }

    $comm = $post->id_community();
    
    // Post belongs to $comm
    if ($comm->get_name() != $name_comm) {
        return false;
    }

    return true;
}

function add_comment(?array $match) {

    if (!is_url_comment_valid((int) $match['id'], $match['comm'])) {
        header("Location: " . Config::URL_SUBDIR(false) . '/feed');
        return;
    }

    $post = $GLOBALS['posts']->get_by_id($match['id']);

    if (!empty(trim($_POST['commentaire']))){
        //Sanitize is done inside
        $GLOBALS['comments']->add_comment(User::current(), $post, $_POST['commentaire']);
    }
   

    $root = Config::URL_SUBDIR(false);
    header("Location: $root" . '/c/' . $post->id_community()->get_name() . '/post/' . $post->id());
}

function like(?array $match) {

    if (!is_url_comment_valid((int) $match['id'], $match['comm'])) {
        header("Location: " . Config::URL_SUBDIR(false) . '/feed');
        return;
    }

    $cuser = User::current();
    $post = $GLOBALS['posts']->get_by_id($match['id']);

    $isLiked = false;
    $nbLikes = null;
    if (isset($cuser) && isset($post)) {
        $community = $post->id_community();
        $canInteract = $cuser->perm($community)->can(P::INTERACT);
        $comment = $GLOBALS['comments']->get_by_id((int) $_POST['id_comment']);
        if ($canInteract && isset($comment)) {
            $comment->like($cuser);
            $isLiked = $comment->hasUserLiked($cuser);
            $nbLikes = $comment->nb_likes();
        }
    }
    $heart_url = $isLiked ? Routes::url_for("/img/svg/heart-full.svg") : Routes::url_for("/img/svg/heart-empty.svg");
    header('Content-Type: application/json');
    echo json_encode(["heart" => $heart_url, "nblikes" => $nbLikes]);
}
