<?php	
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
echo $_SESSION['registrationsuccessful']; // Echoes a line after registration (when applicable)
include_once (LIBRARY_PATH . "/login.php");
include_once (TEMPLATES_PATH . "/footer.php");
?>

