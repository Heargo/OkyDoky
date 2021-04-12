<?php

function create_community(?array $match){
    $name = strtolower(str_replace(' ', '-',trim($_POST['name'])));
    $disp_name = $_POST['name'];
    $description = $_POST['description'];
    $user = User::current();
    $GLOBALS['communities']->add_community($name,$disp_name,$description,$user,$_FILES['file']);
    $root = Config::URL_SUBDIR(false);
    header("Location: $root/feed");
}