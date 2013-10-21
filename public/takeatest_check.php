<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 

/** 
 * Get questionids from SESSION and user answers from POST
 */

$questionids = $_SESSION['questionids']; // array(questionno => questionid)
$useranswers = $_POST; // array(questionid => answer)


/**
 * Query db
 */

$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$questionidssql = "'".implode("','", $questionids)."'";
$questionsquery = $db->query("SELECT * FROM Questions WHERE QuestionId IN (".$questionidssql.")");
foreach ($questionids as $questionid)
{
	$answersqueryarray[$questionid] = $db->query("SELECT * FROM Answers WHERE QuestionId=".$questionid);
}



/** 
 * Save questions in array(id => question)
 */

$questions = array();

foreach($questionsquery as $questionrow)
{
	$id = $questionrow['QuestionId'];
	$question = $questionrow['Question'];
	$questions[$id] = $question;
}



/**
 * Save answers in array(id => answer)
 */

$answers = array();

foreach($answersqueryarray as $questionid => $answerquery)
{
	foreach($answerquery as $answerrow)	
	{
		$answer = $answerrow['Answer'];
		$answers[$questionid][] = $answer;
	}
}






/**
 * Score berekenen en
 * Output question, answer, user answer and score
 */

$totalscore = 0;

foreach($questionids as $orderno => $id)
{
	if (in_array($useranswers[$id], $answers[$id]))
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
	
	
	echo "<p style='background-color:" . $colour . "'><span style='font-weight:bold;'> ".$orderno.". ".$questions[$id]."</span><br>";
	echo "<span>" . $useranswers[$id] . "</span><br>";
	echo "<div style='float:right'> Score: " . $score . "</span> | <span> Answer: "; $n = 1; foreach ($answers[$id] as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;};echo "</div></p>";

	
}

echo "<p style='font-weight:bold'> Totalscore: " . $totalscore . "</p><br><br>";

?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>