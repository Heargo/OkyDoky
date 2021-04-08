<?php 

function modify_profil(?array $match) {
    
	User::current()->set_nickname($_POST["nickname"]);
	User::current()->set_display_name($_POST["display_name"]);
	User::current()->set_description($_POST["description"]);
	
    $root = Config::URL_SUBDIR();
    $root = empty($root) ? '/' : $root;
    header('Location: ' . $root . "profil");
}


?>