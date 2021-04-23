<?php
function delete_comment(?array $match){
    return $GLOBALS['comments']->deleteComment($GLOBALS['comments']->get_by_id($_POST['id']));
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