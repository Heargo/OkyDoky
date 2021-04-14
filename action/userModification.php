<?php 

function modify_profil(?array $match) {
    
    if (!empty(trim($_POST["display_name"]))){
    	$dis = filter_var($_POST["display_name"], FILTER_SANITIZE_SPECIAL_CHARS);
        User::current()->set_display_name($dis);
    }
    if (!empty(trim($_POST["description"]))){
    	$desc = filter_var($_POST["description"], FILTER_SANITIZE_SPECIAL_CHARS);
        User::current()->set_description($desc);
    }
    User::current()->set_profile_picture($_FILES['file']);

	//photo de profil : $_POST["file"]
	$n=User::current()->nickname();
    $root = Config::URL_SUBDIR(false);
    header("Location: $root/user/$n");
}


?>
