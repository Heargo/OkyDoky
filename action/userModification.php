<?php 

function modify_profil(?array $match) {
    
    //display name
    if (!empty(trim($_POST["display_name"]))){
    	$dis = filter_var($_POST["display_name"], FILTER_SANITIZE_SPECIAL_CHARS);
        User::current()->set_display_name($dis);
    }
    //dscritpion
    if (!empty(trim($_POST["description"]))){
    	$desc = filter_var($_POST["description"], FILTER_SANITIZE_SPECIAL_CHARS);
        User::current()->set_description($desc);
    }
    //photo de profil
    User::current()->set_profile_picture($_FILES['file']);

    //retour au profil
	$n=User::current()->nickname();
    $root = Config::URL_SUBDIR(false);
    header("Location: $root/user/$n");
}

function modify_email(?array $match) {
    //modif du mail
    if (!empty(trim($_POST["newmail"])) && User::current()->email()!=trim($_POST["newmail"])){
        $mail = filter_var($_POST["newmail"], FILTER_SANITIZE_SPECIAL_CHARS);
        User::current()->set_email_to($mail);
         //on deco l'user
        User::current()->disconnect();
        //on vas sur la page de confirmation de mail
        header("Location: ./confirmation");
    }else{
        //retour au formulaire si le changement est pas bon
        header("Location: $root/user/profil-edit?type=mail");
    }
}

function modify_password(?array $match) {
    $changed=false;
    if (!empty(trim($_POST["oldpassword"])) && !empty(trim($_POST["newpassword"]))){
        $oldpassword=filter_var($_POST["oldpassword"], FILTER_SANITIZE_SPECIAL_CHARS);
        $newpassword =filter_var($_POST["newpassword"], FILTER_SANITIZE_SPECIAL_CHARS);
        $confirmation = filter_var($_POST["confirmation"], FILTER_SANITIZE_SPECIAL_CHARS);
        //on vérifie si l'ancien mdp est bon
        if (User::current()->is_pwd_correct($oldpassword)) {
            //si le new mdp et la verif correspondent
            if ($confirmation==$newpassword) {
                //on change le mdp
                User::current()->set_pwd($newpassword);
                //on deco l'user
                User::current()->disconnect();
                //on vas sur la page de connexion
                $changed=true;
                header("Location: ./login");
            }
        }
    }

    if (!$changed) {
        //retour au formulaire si le changement est pas bon
        header("Location: $root/user/profil-edit?type=password");
    }
    
}

?>
