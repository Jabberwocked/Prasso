<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_mytests.php");
?>



<div style="width: 500px; margin: 0px auto; border: 1px dotted; padding: 20px 170px 100px 170px">

<?php 
$_SESSION['test'] = new test;
print_r($_SESSION['test']);
$testid = $_POST['testtotake'];
print_r($testid);
$_SESSION['test']->pullfromdb($testid);
print_r($_SESSION['test']);
$_SESSION['test']->showastest();
	


?>
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>