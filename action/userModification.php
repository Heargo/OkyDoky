<?php 

function modify_profil(?array $match) {
    
    if (!empty(trim($_POST["display_name"]))){
    	$dis = filter_var($_POST["display_name"], FILTER_SANITIZE_SPECIAL_CHARS);
    }
    if (!empty(trim($_POST["description"]))){
    	$desc = filter_var($_POST["description"], FILTER_SANITIZE_SPECIAL_CHARS);
    }
	User::current()->set_display_name($dis);
	User::current()->set_description($desc);

	//photo de profil : $_POST["file"]
	
    $root = Config::URL_SUBDIR();
    $root = empty($root) ? '/' : $root;
    header('Location: ' . $root . "profil");
}


?>