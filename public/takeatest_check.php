<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 

/** 
 * Get questionids from SESSION and user answers from POST
 */

$questionids = $_SESSION['test']->questionids; // array(questionno => questionid)
$useranswers = $_POST; // array(questionid => answer)

// /**
//  * Query db
//  */

// $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

// $questionidssql = "'".implode("','", $questionids)."'";
// $questionsquery = $db->query("SELECT * FROM Questions WHERE QuestionId IN (".$questionidssql.")");
// foreach ($questionids as $questionid)
// {
// 	$answersqueryarray[$questionid] = $db->query("SELECT * FROM Answers WHERE QuestionId=".$questionid);
// }



// /** 
//  * Save questions in array(id => question)
//  */

// $questions = array();

// foreach($questionsquery as $questionrow)
// {
// 	$id = $questionrow['QuestionId'];
// 	$question = $questionrow['Question'];
// 	$questions[$id] = $question;
// }



// /**
//  * Save answers in array(id => answer)
//  */

// $answers = array();

// foreach($answersqueryarray as $questionid => $answerquery)
// {
// 	foreach($answerquery as $answerrow)	
// 	{
// 		$answer = $answerrow['Answer'];
// 		$answers[$questionid][] = $answer;
// 	}
// }






/**
 * Score berekenen en
 * Output question, answer, user answer and score
 */

$totalscore = 0;

foreach($questionids as $orderno => $questionid)
{	
	
	echo "Debugging";
	print_r($questionid);
	print_r($_SESSION['test']->questionobjects);
	print_r($_SESSION['test']->questionobjects['$questionid']);
	print_r($_SESSION['test']->questionobjects[$questionid]->answers);
	
	
	if (in_array($useranswers[$questionid], $_SESSION['test']->questionobjects[$questionid]->answers))
	{
		$correct = true;
		$score = 1;
		$totalscore ++;
		$colour = "lightgreen";
	}
	else 
	{
		$correct = false;
		$score = 0;
		$colour = "lightcoral";
	}
	
	echo "<p style='background-color:" . $colour . "'>";
	echo "<span style='font-weight:bold;'> ".$orderno.". ".$_SESSION['test']->questionobjects[$questionid]->question."</span><span style='display: block; float:right'> Score: " . $score . "</span><br>";
	echo "<span>>" . $useranswers[$id] . "</span><span style='display: block; float:right'> Answer: "; $n = 1; foreach ($_SESSION['test']->questionobjects[$questionid]->answers as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;};echo "</span>";
	echo "</p>";
	

	
}

echo "<p style='font-weight:bold'> Totalscore: " . $totalscore . "</p><br><br>";

?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>