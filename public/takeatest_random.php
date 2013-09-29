<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>



<form action="takeatest_random.php" method="get">
<input type="text" name="Numberofquestions" value="max 5">
<input type="submit" value="Submit">
</form>


<?php 
$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$sql = "SELECT * FROM Questions";
$results = $db->query($sql);


$number = $_GET["Numberofquestions"];
$n = 0;

foreach ($results as $row)
{
	if ($n < $number)
	{
		echo $row['Question'] . '<br>';
		$n ++;
		echo $n;
	}
	else
	{
		break;
	}
}

?>




<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>