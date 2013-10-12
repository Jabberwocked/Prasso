<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
/* Checks answers. Doesn't work yet. */
$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$questionids = $_SESSION['QuestionIds'];
$questionidssql = "'".implode("','", $_SESSION['QuestionIds'])."'";
$testquestions = $db->query("SELECT * FROM Questions WHERE QuestionId IN (".$questionidssql.")");
$answers = $db->query("SELECT * FROM Answers WHERE QuestionId IN (".$questionidssql.")");
$useranswers = $_POST;
print_r($useranswers);


$questions = array();

foreach($testquestions as $questionrow)
{
	$testquestions[$questionrow['QuestionId']=$questionrow['Question']];
}
print_r($questions);



foreach($questionids as $n => $id)
{
	echo "<p style='font-weight:bold;'>Question " . $n . "</p><br>";
// 	echo "<p>" . $testquestions[$id]['Question'] . "</p><br><br>";
// 	echo "<p>" . $answers[$id]['Answer1'] . "</p><br><br>";
}
	
?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>