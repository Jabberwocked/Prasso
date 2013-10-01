<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
$answers = $_POST;
$n = 0;

echo $results;

foreach($answers as $answer)
{
	$n ++;
	echo "<p style='font-weight:bold;'>Question " . $n . "</p><br>";
	echo "<p>" . $row['Question'] . "</p><br><br>";
	echo "<input type='text' name='" . $row['QuestionId'] . "' ><br>";
	
	echo $answer . "<br>";
}
	
?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>