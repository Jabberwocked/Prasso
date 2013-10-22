<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_tests.php");
?>


<div style="width: 500px; margin: 0px auto; border: 1px dotted; padding: 20px 170px 100px 170px">

<?php 

/** 
 * Get questionids from SESSION and user answers from POST
 */

$questionids = $_SESSION['test']->questionids; // array(orderno => questionid)
$useranswers = $_POST; // array(questionid => answer)

/**
 * Save useranswers and test to db
 * TODO fix
 */

$scoresearned = $_SESSION['test']->saveresultstodb($checkanswers);
$_SESSION['test']->saveresultstodb($useranswers, $scoresearned);
$_SESSION['test']->showresults($useranswers, $scoresearned);



// /**
//  * Score berekenen en
//  * Output question, answer, user answer and score
//  */

// $totalscore = 0;

// foreach($questionids as $orderno => $questionid)
// {	
	
// 	if (in_array($useranswers[$questionid], $_SESSION['test']->questionobjects[$orderno]->answers))
// 	{
// 		$correct = true;
// 		$score = 1;
// 		$totalscore ++;
// 		$colour = "lightgreen";
// 	}
// 	else 
// 	{
// 		$correct = false;
// 		$score = 0;
// 		$colour = "lightcoral";
// 	}
	
// 	echo "<p style='background-color:" . $colour . "'>";
// 	echo "<span style='font-weight:bold;'> ".$orderno.". ".$_SESSION['test']->questionobjects[$orderno]->question."</span><span style='display: block; float:right'> Score: " . $score . "</span><br>";
// 	echo "<span>>" . $useranswers[$questionid] . "</span><span style='display: block; float:right'> Answer: "; $n = 1; foreach ($_SESSION['test']->questionobjects[$orderno]->answers as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;};echo "</span>";
// 	echo "</p>";
	

	
// }

// echo "<p style='font-weight:bold'> Totalscore: " . $totalscore . "</p><br><br>";

?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>