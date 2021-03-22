<?php 
function voteU(?array $match) {

	$user = User::current();
	$post =(int)$_POST["idpost"];
	$postobj = $GLOBALS["posts"]->get_by_id($post);
	$res =  $postobj->upvote($user);
	header("Location: ./feed#$post");

}
function voteD(?array $match) {

	$user = User::current();
	$post =(int)$_POST["idpost"];
	$postobj = $GLOBALS["posts"]->get_by_id($post);
	$res =  $postobj->downvote($user);
	header("Location: ./feed#$post");

}