<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
	


/**
 * If a test is selected to edit (not new), copy questions from db to session.
 */

if (isset($_POST['testtoedit']))
{
	$_SESSION['test'] = new test();
	$testid = $_POST['testtoedit'];
	$_SESSION['test']->pullfromdb($testid);
} 

/**
 * Process forms depending on button pressed.
 */
/**
 * RESET
 */

if ($_POST['action'] == "reset")
{
	$_SESSION['test'] = new test();
}

/**
 * SAVE
 */

elseif ($_POST['action'] == "save")
{
	$_SESSION['test']->saveitem();
}

/**
 * SAVE to database
 */

elseif ($_POST['action'] == "savetest")
{
	echo "lalal";
	if (isset($this->testid))
	{
		$_SESSION['test']->update();
	}
	else 
	{
		$_SESSION['test']->add();
	}
	$_SESSION['test'] = new test();
}



/** 
 * Print test name, questionobjects and form
 */

$_SESSION['test']->show();



/** 
 * Buttons: Save test or delete questions
 */

 
 ?>	

	
<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">	
	<button type="submit" name="action" value="savetest" >Save</button> |
	<button type="submit" name="action" value="reset" >Reset</button>
</form>
<br>
<br>
	
	
	
	
</div>

<?php

include_once (TEMPLATES_PATH . "/footer.php");
?>