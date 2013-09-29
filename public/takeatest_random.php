<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>



<form action="takeatest_random.php" method="get">
	Filter by type<br> 
	<input type="radio" style="display:inline; width:20px;" name="type" value="all">All<br>
	<input type="radio" style="display:inline; width:20px;" name="type" value="shortanswer">Short Answer<br>
	<input type="radio" style="display:inline; width:20px;" name="type" value="multichoice">Multiple Choice<br>
	<br>
	How many questions would you like to answer?<br> 
	<input type="text" name="number" value="0"> 
	<br> 
	<input type="submit" value="Generate Test">
</form>
<br>
<br>

<form>


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
		if ($type == "all" or $row['Type'] == $type)
		{
			$n ++;
			echo "<b>Question " . $n . "</b><br>";
			echo $row['Question'] . "<br><br>";
			echo "<input type='text' name='" . $row['QuestionId'] . "' ><br>" 			
		}
	}
	else
	{
		break;
	}
}

?>

</form>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>