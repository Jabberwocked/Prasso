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
 * CHECK A RANDOM TEST
 */
 elseif($_SESSION['test']->testname == "random")
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
	
	$userscores = $_SESSION['test']->checkanswers($useranswers);
	//save the random test for future reference and to be able to save results
	$_SESSION['test']->savetesttodbtests( ); 
	$_SESSION['test']->saveresultstodb($useranswers, $userscores);
	$_SESSION['test']->showresults($useranswers, $userscores);

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
	
	$userscores = $_SESSION['test']->checkanswers($useranswers);
	$_SESSION['test']->saveresultstodb($useranswers, $userscores);
	$_SESSION['test']->showresults($useranswers, $userscores);
}


?>
</div>
<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>