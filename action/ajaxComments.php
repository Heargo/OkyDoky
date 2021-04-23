<?php
function delete_comment(?array $match){
    $comment = $GLOBALS['comments']->get_by_id($_POST['id']);
    return $GLOBALS['comments']->deleteComment($comment);
}