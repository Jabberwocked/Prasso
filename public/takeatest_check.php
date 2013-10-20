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

foreach($answersqueryarray as $questionid)
{
	foreach($questionid as $answerrow)	
	{
// 		echo $questionid;
// 		echo $answerrow;
		$answer = $answerrow['Answer'];
		$answers[$questionid][] = $answer;
	}
}

print_r($answers);

// $answers = array();

// foreach($answersquery as $answersrow)
// {
// 	$id = $answersrow['QuestionId'];
// 	$multipleanswers = array();
// 	foreach($answersrow as $column => $value)
// 	{
// 		if (strpos($column,'Answer') !== false)
// 		{
// 			$multipleanswers[] = $value;
// 		}
// 	}
// 	$answers[$id] = $multipleanswers;
// }


/**
 * Score berekenen en
 * Output question, answer, user answer and score
 */

$totalscore = 0;

foreach($questionids as $n => $id)
{
	if ($useranswers[$id] == $answers[$id])
	{
		$correct = true;
		$score = 1;
		$totalscore ++;
		$colour = "green";
	}
	else 
	{
		$correct = false;
		$score = 0;
		$colour = "red";
	}
	
	
	echo "<p><span style='font-weight:bold;'>$n " . $questions[$id] . "</span><br>";
	echo "<span style='display:inline-block; min-width:100px; background-color:" . $colour . "'>x" . $useranswers[$id] . "</span><br>";
	echo "<span> Score: " . $score . "</span> | <span> Answer: " . $answers[$id] . "</span></p>";
	
}

echo "<p style='font-weight:bold'> Totalscore: " . $totalscore . "</p><br><br>";

?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>