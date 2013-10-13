<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");


if (!isset($_SESSION['username']))
{
	header("Location:loginpage.php?location=" . urlencode($_SERVER['REQUEST_URI']));

}
else
{ 


	
	include_once (MENU_PATH . "/menu_other.php");



}




include_once (TEMPLATES_PATH . "/footer.php");
?>