<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
/* Checks answers. Doesn't work yet. */


/** 
 * Get questionids from SESSION and user answers from POST
 */

$questionids = $_SESSION['questionids']; // array(questionno => questionid)
$useranswers = $_POST; // array(questionid => answer)

/**
 * Query db
 */

$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$questionidssql = "'".implode("','", $_SESSION['QuestionIds'])."'";
$questionsquery = $db->query("SELECT * FROM Questions WHERE QuestionId IN (".$questionidssql.")");
$answersquery = $db->query("SELECT * FROM Answers WHERE QuestionId IN (".$questionidssql.")");


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

foreach($answersquery as $answersrow)
{
	$id = $answersrow['QuestionId'];
	$multipleanswers = array();
	foreach($answersrow as $column => $value)
	{
		if (strpos($column, 'Answer'))
		{
			$multipleanswers[] = $value;
		}
	}
	$answers[$id] = $multipleanswer;
}


/**
 * Output question, answer and user answer
 */

foreach($questionids as $n => $id)
{
	echo "<p style='font-weight:bold;'>Question " . $n . "</p><br>";
	echo "<p>" . $questions[$id] . "</p><br><br>";
	echo "<p>" . print_r($answers[$id]) . "</p><br><br>";
	echo "<p>" . $useranswers[$id] . "</p><br><br>";
}
	
?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>