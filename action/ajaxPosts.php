<?php 

function load_post(Post $post, $isComment = false) {
    $publisher = $post->publisher();
    $titrePost = $post->title();
    $description = $post->description();
    $pName = $publisher->nickname();
    $profile_pic = $publisher->profile_pic();
    $docs = $post->get_documents();
    $voted = $post->hasUserVoted(User::current());
    $prct = $post->get_percent_up_down();
    $urlComment = Routes::url_for('/c/' . $post->id_community()->get_name() . '/post/' . $post->id());
    foreach ($docs as $doc) {
        if($doc->is_visible()) {
            $urlIMG = $doc->url();
            break;
        }
    }
    include "page/post_standalone.php";
}

function more_posts(?array $match) {
    $comm = $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]);
    $posts = $GLOBALS["posts"]->get_by_community($comm, true, 2, (int) $_POST['offset']);

    $result = array();
    foreach($posts as $post) {
        if (ob_get_length()) ob_end_clean();
        ob_start();
        load_post($post);
        $content = ob_get_clean();
        $result[$post->id()] = $content;
    }
    ob_start();

    echo json_encode($result);
}
