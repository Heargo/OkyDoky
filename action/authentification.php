<?php

function signin(?array $match) {
    $email = filter_var($_POST['login'], FILTER_SANITIZE_EMAIL);
    //Later, we should sanitize better, and handle SQL injection attack
    $password = strtolower(trim($_POST['password']));

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
        header("Location: $root/feed");
    } else {
        $GLOBALS['page']['error_signin'] = true;
        header("Location: $root/login");
    }
}

function signup(?array $match) {
    $nickname = strtolower(trim($_POST['nickname']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pwd = trim($_POST['password']);

    $success=false;
    if (trim($nickname) && filter_var($email, FILTER_VALIDATE_EMAIL) && trim($pwd)) {
        $success = $GLOBALS['users']->add_user($email, $nickname, $pwd);
    }

    if (!$success) { $GLOBALS['page']['error_signup'] = true; }

    $root = Config::URL_SUBDIR(false);
    header("Location: $root/login");
}