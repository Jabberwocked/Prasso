<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_main_loggedin.php");

echo "test";
print_r($_SESSION['test']);

include_once (TEMPLATES_PATH . "/footer.php");
?>