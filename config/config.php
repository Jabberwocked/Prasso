<?php
// set off all error for security purposes
error_reporting(E_ALL);

// define some constants

define("DB_DSN", "mysql:host=localhost;dbname=miljoenenidee");	// Should this be local host?
define("DB_USERNAME", "root");
define("DB_PASSWORD", "miljoen");
define("CLS_PATH", "class");

// Creating constants for heavily used paths makes things a lot easier e.g. when folder structure changes.
// ex. require_once(LIBRARY_PATH . "user.php")

defined("LIBRARY_PATH")
or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/lib'));

defined("TEMPLATES_PATH")
or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("MENU_PATH")
or define("MENU_PATH", realpath(dirname(__FILE__) . '/templates/menu'));

// Or use
$config = array(
	"urls" => array(
		"baseUrl" => "http://prasso.com"
	),
	"paths" => array(
		"library" => "/lib",
		"images" => array(
			"content" => $_SERVER["DOCUMENT_ROOT"] . "/img/content",
			"layout" => $_SERVER["DOCUMENT_ROOT"] . "/img/layout"
		)
	)
);

// include the classes
include_once (CLS_PATH . "/login/user.php");







/*
 * Useful for more. See Google.
*/

?>