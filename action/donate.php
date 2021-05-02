<?php

function giveTo(?array $match) {
	$to = $GLOBALS['users']->get_by_id((int) $_POST['to']);
	$in = $GLOBALS['communities']->get_by_id((int) $_POST['in']);
	$hmCoins = $_POST['number'];
	$from = User::current();
	if ($from->coins_in_community($in) >= $hmCoins && $hmCoins > 0 && $from->id() != $to->id()) {
		$to->add_coins_in_community($in, $hmCoins);
		$from->add_coins_in_community($in, -$hmCoins);
		$from->add_points_in_community($in, $hmCoins);
	} 
	$root = Config::URL_SUBDIR(false);
	var_dump($_POST['urlRedirect']);
	header("Location: $root".$_POST['urlRedirect']);
}