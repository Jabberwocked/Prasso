<?php
// set off all error for security purposes
error_reporting(E_ALL);

// define some constant
define("DB_DSN", "mysql:host=localhost;dbname=miljoenenidee");	// Should this be local host?
define("DB_USERNAME", "root");
define("DB_PASSWORD", "miljoen");
define("CLS_PATH", "class");

// include the classes
include_once (CLS_PATH . "/login/user.php");
// commentaar
?>