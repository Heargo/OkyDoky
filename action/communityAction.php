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

function modify_commu(?array $match){
	$commu = $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]);
    if (!empty(trim($_POST["description"]))){
    	$desc = filter_var($_POST["description"], FILTER_SANITIZE_SPECIAL_CHARS);
        $commu->set_description($desc);
    }
    if($_FILES['file']["size"]>0){
        $commu->set_cover($_FILES['file']);
    }    

    $root = Config::URL_SUBDIR(false);
    header("Location: $root/panel-admin");
}