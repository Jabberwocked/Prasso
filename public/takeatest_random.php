<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>



<form action="takeatest_random.php" method="get">
	Filter by type<br> 
	<input type="radio" style="display:inline; width:20px;" name="type" value="*">All<br>
	<input type="radio" style="display:inline; width:20px;" name="type" value="shortanswer">Short Answer<br>
	<input type="radio" style="display:inline; width:20px;" name="type" value="multichoice">Multiple Choice<br>
	<br>
	How many questions would you like to answer?<br> 
	<input type="text" name="number" value="0"> 
	<br> 
	<input type="submit" value="Submit">
</form>
<br>
<br>

<?php
$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$sql = "SELECT * FROM Questions";
$results = $db->query($sql);

$n = 0;
$number = $_GET["number"];
$type = $_GET["type"];

foreach ($results as $row)
{
	if ($n < $number)
	{
		if ($row['Type'] == $type)
		{
			echo $row['Question'] . '<br>';
			$n ++;
		}
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