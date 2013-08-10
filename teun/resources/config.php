<?php

/*
 The important thing to realize is that the config file should be included in every
page of your project, or at least any page you want access to these settings.
This allows you to confidently use these settings throughout a project because
if something changes such as your database credentials, or a path to a specific resource,
you'll only need to update it here.
*/


$config = array(
	"urls" => array(
		"baseUrl" => "http://prasso.com"
	),
	"paths" => array(
		"resources" => "/teun/resources",
		"images" => array(
			"content" => $_SERVER["DOCUMENT_ROOT"] . "/img/content",
			"layout" => $_SERVER["DOCUMENT_ROOT"] . "/img/layout"
		)
	)
);



/*
 Creating constants for heavily used paths makes things a lot easier.
ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
defined("LIBRARY_PATH")
or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

defined("TEMPLATES_PATH")
or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("MENU_PATH")
or define("MENU_PATH", realpath(dirname(__FILE__) . '/templates/menu'));


/*
 * Useful for more. See Google.
 */


?>