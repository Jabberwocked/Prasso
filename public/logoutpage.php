<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>



<?php
session_destroy();
header("Location:index.php");
?>



<?php include_once (TEMPLATES_PATH . "/footer.php"); ?>