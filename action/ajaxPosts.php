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
    elseif ($_POST['page']=="favoris"){
        $posts = $GLOBALS["favoris"]->get_by_user(10, (int) $_POST['offset']);
    }
    else{
        $posts = $GLOBALS["posts"]->get_by_community($comm, true, 2, (int) $_POST['offset']);
    }
    

    $result = array();
    for($i=0;$i<sizeof($posts);$i++) {
        $post=$posts[$i];
        if (ob_get_length()) ob_end_clean();
        ob_start();
        load_post($post);
        $content = ob_get_clean();
        $result[] = array($post->id(), $content);
    }
    ob_start();

    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
}

function del_post(?array $match){
    $ptd = $GLOBALS['posts']->get_by_id($_POST['id']);
    if (User::current()->id() != $ptd->publisher()->id()) {
        $ptd->publisher()->add_points_in_community($ptd->community(),-50);
    }
    return $GLOBALS['posts']->del_post($ptd);
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
