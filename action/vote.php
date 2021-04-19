<?php 
function voteU(?array $match) {
	$user = User::current();
	$post =(int)$_POST["idpost"];
	$postobj = $GLOBALS["posts"]->get_by_id($post);
	$res =  $postobj->upvote($user);
	$v = $postobj->hasUserVoted(User::current());
	$prct=$postobj->get_percent_up_down();
	$response = array($v,$prct);
    header('Content-Type: application/json');
	echo json_encode($response);
}

function voteD(?array $match) {
	$user = User::current();
	$post =(int)$_POST["idpost"];
	$postobj = $GLOBALS["posts"]->get_by_id($post);
	$res =  $postobj->downvote($user);
	$v = $postobj->hasUserVoted(User::current());
	$prct=$postobj->get_percent_up_down();
	$response = array($v,$prct);
    header('Content-Type: application/json');
	echo json_encode($response);
}
