<?php
// set off all error for security purposes
error_reporting(E_ALL);

// define some constants
// Creating constants for heavily used paths makes things a lot easier e.g. when folder structure changes.
// ex. require_once(LIBRARY_PATH . "user.php")

define("DB_DSN", "mysql:host=localhost;dbname=miljoenenidee");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "miljoen");
define("LIBRARY_PATH", "../lib/");
define("TEMPLATES_PATH", "../templates");
define("MENU_PATH", "../templates/menu");

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
include_once (LIBRARY_PATH . "user.php");







/*
 * Useful for more. See Google.
*/

?>