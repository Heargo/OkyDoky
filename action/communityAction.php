<?php

function create_community(?array $match){
    $name = strtolower(str_replace("'", "",str_replace(' ', '-',trim($_POST['name']))));
    $name = removeaccents($name);
    $root = Config::URL_SUBDIR(false);
    $error=false;
    if(!empty(trim($name))){
        $disp_name = $_POST['name'];
        $description = $_POST['description'];
        $user = User::current();
        $id = $GLOBALS['communities']->add_community($name,$disp_name,$description,$user,$_FILES['file']);
    }else{
        $error=true;
    }
    
    if($id==null || $error){
        header("Location: $root/createCommunity");
    }else{
        header("Location: $root/community");
    }
}

function modify_commu(?array $match){
	$commu = $GLOBALS["communities"]->get_by_id($_SESSION["current_community"]);
    
    $desc = filter_var($_POST["description"], FILTER_SANITIZE_SPECIAL_CHARS);
    $commu->set_description($desc);

    $rules = filter_var($_POST["rules"], FILTER_SANITIZE_SPECIAL_CHARS);
    $commu->set_rules($rules);
    
    if($_FILES['file']["size"]>0){
        $commu->set_cover($_FILES['file']);
    }    

    $root = Config::URL_SUBDIR(false);
    header("Location: $root/panel-admin");
}