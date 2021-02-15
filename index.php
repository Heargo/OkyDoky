<?php

session_start();

/// Errors reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/// Managers
require('db.php');
require('class/DocumentManager.php');
$GLOBALS["docs"] = new DocumentManager($DB);

/// Routes
require('class/Routes.php');
$ROUTES = new Routes();
include('view.php');
include('action.php');
$ROUTES->execute();

