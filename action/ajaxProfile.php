<?php
function load_user(User $user) {
    include "page/user_standalone.php";
}


function searchProfil(?array $match){
    $allusers=$GLOBALS["users"]->search_user_by_nickname_or_display_name($_POST["tosearch"]);
    foreach ($allusers as $key => $user) {
        load_user($user); 
    }
}

function searchFriends(?array $match){
	/*TODO SEARCH BY FRIENDS*/
    $allusers=User::current()->search_by_friends($_POST["tosearch"]);
    foreach ($allusers as $key => $user) {
        load_user($user); 
    }
    if (trim($_POST["tosearch"])!="" && sizeof($allusers)==0) {
    	echo "<p>Aucun résultat !</p>";
    }
    if (sizeof(User::current()->get_all_friends())==0) {
    	echo "<p>Vous n'avez pas encore d'amis !</p>";
    }
}

function askFriendAjax(?array $match){
	User::current()->add_friend($GLOBALS["users"]->get_by_id($_POST["id"]));
}

function getLevel(?array $match){
	$user= $GLOBALS['users']->get_by_nickname($_POST['user']);

	$currentXpPoint = $user->level_in_community($GLOBALS['communities']->get_by_id($_POST['community']))[1];
	$currentLevel = $user->level_in_community($GLOBALS['communities']->get_by_id($_POST['community']))[0];
	$xpToNextLevel = User::hmptlvlup($user->level_in_community($GLOBALS['communities']->get_by_id($_POST['community']))[0]);
	$prctCurrentXp= $currentXpPoint / $xpToNextLevel *100;

	$res = array('level' =>$currentLevel ,
				'xp_points' =>$currentXpPoint,
				'xpToNextLevel' =>$xpToNextLevel,
				'prctCurrentXp' =>$prctCurrentXp );
	echo json_encode($res);
}
