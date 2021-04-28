<?php 

function load_post(Post $post, $isComment = false) {
    $publisher = $post->publisher();
    $titrePost = $post->title();
    $description = $post->description();
    $pName = $publisher->display_name();
    $profile_pic = $publisher->profile_pic();
    $docs = $post->get_documents();
    $voted = $post->hasUserVoted(User::current());
    $prct = $post->get_percent_up_down();
    $urlComment = Routes::url_for('/c/' . $post->community()->get_name() . '/post/' . $post->id());
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
    if ($_POST['page']=="top"){
        $posts = $GLOBALS["posts"]->get_by_most_votes($comm, true, 10, (int) $_POST['offset']);      
    }
    elseif ($_POST['page']=="profil"){
        $user=  $GLOBALS["users"]->get_by_id($_POST['user']);
        $comm=$GLOBALS["communities"]->get_by_id($_POST['comm']);
        $posts = $GLOBALS["posts"]->get_by_user_and_community($user,$comm, true, 10, (int) $_POST['offset']);
    }
    elseif ($_POST['page']=="admin"){
        $posts = $GLOBALS["posts"]->get_by_community($comm, false, 10, (int) $_POST['offset']);
    }
    else{
        $posts = $GLOBALS["posts"]->get_by_community($comm, true, 10, (int) $_POST['offset']);
    }
    

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

function del_post(?array $match){
    return $GLOBALS['posts']->del_post($GLOBALS['posts']->get_by_id($_POST['id']));
}
function send_highlight_post(?array $match){
    //@TODO Si l'utilisateur connecté a les droits
    $comm = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
    $hp = $comm->get_highlight_post();
    if(isset($hp) && $hp->is_visible()){
        load_post($hp);
    }
    else{
        echo "<p>Pas de posts mis en avant... C'est triste</p>";
    }
}
function set_highlight_post(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
    $comm->set_highlight_post($_POST['id']);
}

function remove_PMA(?array $match){
    $comm = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
    $comm->remove_highlight_post();
    header("Location: " . Routes::url_for('/panel-admin'));
}

function searchPost(?array $match){
    $allposts=$GLOBALS["posts"]->search_post_by_title($_POST["tosearch"]);
    foreach ($allposts as $key => $post) {
        echo load_post($post); 
    }
}

function load_admin_container($page="community"){
    $currentCom = $GLOBALS['communities']->get_by_id($_SESSION['current_community']);
    include "page/admin-team_standalone.php";
}
function send_admin_container(?array $match){
    load_admin_container();
}
