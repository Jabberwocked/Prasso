<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
/* Checks answers. Doesn't work yet. */
$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

print_r($_SESSION['QuestionIds']);
$testquestions = $db->query("SELECT * FROM Questions WHERE QuestionId IN (".$_SESSION['QuestionIds'].")");
$answers = $db->query("SELECT * FROM Answers WHERE QuestionId IN (".$_SESSION['QuestionIds'].")");
$useranswers = $_POST;
print_r($useranswers);

$n = 0;

foreach($testquestions as $questionrow)
{
	echo '3';
// 	$n ++;
// 	echo "<p style='font-weight:bold;'>Question " . $n . "</p><br>";
// 	echo "<p>" . $questionrow['Question'] . "</p><br><br>";
// 	echo "<p>" . $answers[$questionsrow['QuestionID']] . "</p><br><br>";
}
	
?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>