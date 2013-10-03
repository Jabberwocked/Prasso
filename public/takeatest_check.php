<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
/* Checks answers. Doesn't work yet. */

$answers = $_POST;
$n = 0;

foreach($answers as $answer)
{
	$n ++;
	echo "<p style='font-weight:bold;'>Question " . $n . "</p><br>";
	echo "<p>" . $row['Question'] . "</p><br><br>";
	// NEEDS SESSION OR STH
	echo "<p>" . $answer . "</p><br><br>";
}
	
?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>