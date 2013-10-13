<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_main_loggedin.php");

echo "test<br>";
print_r($_SESSION['userid']);
print_r($_SESSION['username']);
// echo "<br>" . $_SESSION['test'];

include_once (TEMPLATES_PATH . "/footer.php");
?>