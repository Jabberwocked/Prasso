<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_mytests.php");
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
 * If an item to edit was selected, update session, but not if the fields are empty.
 */

if ($_POST['question'] == "" AND $_POST['answers'][0] == "" AND $_SESSION['itemtoedit'] == count($_SESSION['test']->questionobjects) + 1 AND $_POST['itemtoedit'] == count($_SESSION['test']->questionobjects) + 2)
{
	// 		Don't change itemtoedit in session
}
elseif (isset($_POST['itemtoedit']))
{
	$_SESSION['itemtoedit'] = $_POST['itemtoedit'];
}
elseif (!isset($_SESSION['itemtoedit'])) 
{
	$_SESSION['itemtoedit'] = count($_SESSION['test']->questionobjects) + 1;
};

/**
 * Process forms depending on button pressed.
 */
/**
 * RESET
 */

if ($_POST['action'] == "reset")
{
	$_SESSION['test'] = new test();
	unset($_SESSION['itemtoedit']);
}

/**
 * SAVE
 */

elseif ($_POST['action'] == "save")
{
	if ($_POST['question'] == "" AND $_POST['answers'][0] == "")
	{
// 		Don't save 
	}
	else 
	{
		$_SESSION['test']->saveitem();
	}
}

/**
 * SAVE to database
 */

elseif ($_POST['action2'] == "savetest")
{
// 	if (isset($_SESSION['test']->testid))
// 	{
// 		$_SESSION['test']->update();
// 	}
// 	else 
// 	{
		$_SESSION['test']->add();
// 	}
	
}



/** 
 * Print test name and questionobjects as buttons and a form for the item that's being edited
 */

$_SESSION['test']->show();



?>
	
	
</div>

<?php

include_once (TEMPLATES_PATH . "/footer.php");
?>