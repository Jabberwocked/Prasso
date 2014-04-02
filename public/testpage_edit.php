<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_tests.php");
?>


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

if ($_POST['question'] == "" AND $_POST['answers'][0] == "" AND $_POST['testname'] == "" AND $_SESSION['itemtoedit'] == count($_SESSION['test']->questionobjects) + 1 AND $_POST['itemtoedit'] == count($_SESSION['test']->questionobjects) + 2)
{
	// 		Don't change itemtoedit in session
}
elseif (isset($_POST['itemtoedit']))
{
	$_SESSION['itemtoedit'] = $_POST['itemtoedit'];
}

if (!isset($_SESSION['test']))
{
	$_SESSION['test'] = new test();
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
	unset($_SESSION['itemtoedit']);
}

/**
 * SAVE
 */

elseif ($_POST['action'] == "save")
{
	if ($_POST['question'] == "" AND $_POST['answers'][0] == "" AND $_POST['testname'] == "")
	{
// 		Don't save 
	}
	else 
	{
		$_SESSION['test']->saveitemtosession();
	}
}

/**
 * SAVE to database
 */

if ($_POST['action2'] == "savetest")
{
	echo "lulu";
	if ($_SESSION['test']->testname == false)
	{
		echo "<p style='color:red'>Please insert a test name</p><br>";
	}
	else
	{
		echo "lala";
		$_SESSION['test']->savequestionstodbquestions();
		$_SESSION['test']->savetesttodbtests();
	}

// 	if (isset($_SESSION['test']->testid))
// 	{
// 		$_SESSION['test']->update();
// 	}
 	
	
}



/** 
 * Print test name and questionobjects as buttons and a form for the item that's being edited
 */
?>

<div style="position:relative; width: 500px; margin: 0px auto; border: 1px dotted; padding: 20px 170px 100px 170px">

<?php 
$_SESSION['test']->showeditabletest(); 
?>

</div>




<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>