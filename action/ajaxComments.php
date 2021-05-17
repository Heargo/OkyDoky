<?php



function delete_comment(?array $match){
    $ctd = $GLOBALS['comments']->get_by_id($_POST['id']);
    if (User::current()->id() != $ctd->author()->id()) {
        $ctd->author()->add_points_in_community($ctd->post()->community(),-25);
    }
    return $GLOBALS['comments']->deleteComment($ctd);
}
function restore_comment(?array $match) {
    $isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
    $isOwner=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::OWNER);
    if ($isAdmin ||$isOwner){
        $ctr = $GLOBALS['comments']->get_by_id($_POST['id']);
        $ctr->author()->add_points_in_community($ctr->post()->community(),+25);
        $done=$ctr->set_visible(true);
    }
    return $done;
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
        $community = $post->community();
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