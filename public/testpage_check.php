<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_tests.php");
?>


<div style="width: 500px; margin: 0px auto; border: 1px dotted; padding: 20px 170px 100px 170px">

<?php 


/**
 * VIEW OLD ATTEMPT
 */
if (isset($_POST['attemptid']))
{
	$attemptid=$_POST['attemptid'];
	$_SESSION['test'] = new  test(); //is this necessary?
	$_SESSION['test']->showoldattempt( $attemptid );
}


/** 
 * REVIEW A NEW TEST SUBMISSION
 */
else 
{		
	/** 
	 * Get questionids from SESSION and user answers from POST
	 */
	
	$questionids = $_SESSION['test']->questionids; // array(orderno => questionid)
	$useranswers = $_POST; // array(questionid => answer)
	
	/**
	 * Check answers
	 * Save useranswers, scores and test data to db
	 * Show results
	 */
	echo "hallo";
	$userscores = $_SESSION['test']->checkanswers($useranswers);
	$_SESSION['test']->saveresultstodb($useranswers, $userscores);
	$_SESSION['test']->showresults($useranswers, $userscores);
}


?>
</div>
<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>