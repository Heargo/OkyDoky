<?php

function convert_coins(?array $match) {
	$u = User::current();
	$c = new Community($GLOBALS['db'],$_SESSION["current_community"]);
	$coinsToConvert = $_POST['nb_coins'];
	if (!($coinsToConvert<=0 || $coinsToConvert>$u->coins_in_community($c))) {
		$u->add_coins_in_community($c, -$coinsToConvert);
		$u->add_points_in_community($c, 10*$coinsToConvert);
	}
	$root = Config::URL_SUBDIR(false);
	header("Location: $root/bank");
}

function collect_all(?array $match) {
	User::current()->collect_all_dailies();
	$root = Config::URL_SUBDIR(false);
	header("Location: $root/bank");
}