<?php 
session_destroy();
header("Location: main.php"); 
?>

<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<?php 
echo "You are logged out.";
?>



<?php include_once (TEMPLATES_PATH . "/footer.php"); ?>