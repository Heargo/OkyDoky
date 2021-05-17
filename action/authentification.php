<?php

function signin(?array $match) {
    $email = filter_var($_POST['login'], FILTER_SANITIZE_EMAIL);
    //Later, we should sanitize better, and handle SQL injection attack
    $password = $_POST['password'];

    $user = null;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $user = $GLOBALS['users']->get_by_email($email);
    } else { 
        $nickname = strtolower(trim($_POST['login']));
        $user = $GLOBALS['users']->get_by_nickname($nickname);
    }

    $success = isset($user) ? $user->connect($password) : false;

    $root = Config::URL_SUBDIR(false);

    if ($success) {
        if(!empty(User::current()->get_communities())){
            $_SESSION["current_community"]=User::current()->get_communities()[0]->id();
        }
        header("Location: $root/feed");
        
    } else {
        $GLOBALS['page']['error_signin'] = true;
        header("Location: $root/login");
    }
}

function signup(?array $match) {
    $nickname = strtolower(trim($_POST['nickname']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pwd = $_POST['password'];

    $success=false;
    if($GLOBALS['users']->is_nickname_free($nickname) &&$GLOBALS['users']->is_email_free($email) ){
        if (trim($nickname) && filter_var($email, FILTER_VALIDATE_EMAIL) && trim($pwd)) {
            $success = $GLOBALS['users']->add_user($email, $nickname, $pwd);
        }
    }
    

    if (!$success) { $GLOBALS['page']['error_signup'] = true; }

    $root = Config::URL_SUBDIR(false);
    if ($success) {
        header("Location: $root/confirmation");
    } else {
        header("Location: $root/login");
    }
}

function verify_user_email(?array $match) {
    if (!empty($match['user']) && !empty($match['token'])) {
        $user = $GLOBALS['users']->get_by_nickname($match['user']);
        if ($user) {
            $token_ok = $user->validate_email_token($match['token']);
            $GLOBALS['page']['error_validate_token'] = !$token_ok;
        } else {
            $GLOBALS['page']['error_validate_user'] = true;
        }
    } else {
        $GLOBALS['page']['error_validate'] = true;
    }
    $root = Config::URL_SUBDIR(false);
    header("Location: $root/login"); // @todo page/verify.php to replace this redirection
}
