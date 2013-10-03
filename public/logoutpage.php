<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>



<?php 
/** 
 * The redirect after the session_destroy is necessary to refresh the page.
 * The echo might be useless here.  
 */

session_destroy();
echo "You are logged out.";
header("Location:main.php");
?>



<?php include_once (TEMPLATES_PATH . "/footer.php"); ?>