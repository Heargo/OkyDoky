<?php

session_start();

/// Errors reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/// Autoinclude class
spl_autoload_register(function ($class_name) {
    include 'class/' . $class_name . '.php';
});
require 'class/tools.php';

$GLOBALS['page'] = [];

/// Managers
require('db.php');
$GLOBALS['docs'] = new DocumentManager($DB);
$GLOBALS['users'] = new UserManager($DB);
$GLOBALS['db'] = $DB;

/// Routes
$ROUTES = new Routes();
include('view.php');
include('action.php');
$ROUTES->execute();

