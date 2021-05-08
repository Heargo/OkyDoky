<?php

session_start();

/// Errors reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/// Autoinclude class
spl_autoload_register(function ($class_name) {
    $class = 'class/' . $class_name . '.php';
    $library = 'lib/' . str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($class)) include $class;
    if (file_exists($library)) include $library;
});
require 'class/tools.php';
class_alias('Permission', 'P');

$GLOBALS['page'] = [];

/// Managers
require('db.php');
$GLOBALS['docs'] = new DocumentManager($DB);
$GLOBALS['users'] = new UserManager($DB);
$GLOBALS['communities'] = new CommunityManager($DB);
$GLOBALS['posts'] = new PostManager($DB);
$GLOBALS['comments'] = new CommentManager($DB);
$GLOBALS['messages'] = new MessageManager($DB);
$GLOBALS['notifications'] = new NotificationManager($DB);
$GLOBALS['db'] = $DB;

if(!isset($_SESSION["current_community"])){
    $_SESSION["current_community"]=0;
}


if(User::current() != null && $_SESSION["current_community"] != 0){
    if(!isset($_SESSION["current_community"]) || !$GLOBALS['communities']->get_by_id($_SESSION['current_community'])->user_in(User::current())){
        $allcomsOfUser= User::current()->get_communities();
        if(sizeof($allcomsOfUser) > 0){
		    $_SESSION["current_community"] = $allcomsOfUser[0]->id();
        }
        else{
            $_SESSION["current_community"]=0;
        }
    }
}

/// Routes
foreach (glob("action/*.php") as $filename) {
    include $filename;
}
if (php_sapi_name() != 'cli') {
    $ROUTES = new Routes();
    include('action.php');
    include('view.php');
    $ROUTES->error(404, '/404', 'page/404.php');
    $ROUTES->execute();
}

