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
