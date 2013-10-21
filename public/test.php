<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_tests.php");
?>



<div style="width: 500px; margin: 0px auto; border: 1px dotted; padding: 20px 170px 100px 170px">

<?php 

$_SESSION['test'] = new test;

if (isset($_POST['testtotake']))
{
	$testid = $_POST['testtotake'];
	$_SESSION['test']->pullfromdb($testid);
	$_SESSION['test']->showastest();
}

if (isset($_GET['generaterandom']))
{
	$_SESSION['test']->pullrandomfromdb();
	$_SESSION['test']->showastest();
}




?>
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>