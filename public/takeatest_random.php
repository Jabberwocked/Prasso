<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<div style="margin-left: auto; margin-right: auto; width: 500px">
	
	<form action="takeatest_random.php" method="get">
		Filter by type<br> 
		<input type="radio" style="display:inline; width:20px;" name="type" value="all" checked>All<br>
		<input type="radio" style="display:inline; width:20px;" name="type" value="shortanswer" <? if($_GET['type'] == "shortanswer"){ echo 'checked';}?>>Short Answer<br>
		<input type="radio" style="display:inline; width:20px;" name="type" value="multichoice" <? if($_GET['type'] == "multichoice"){ echo 'checked';}?>>Multiple Choice<br>
		<br>
		How many questions would you like to answer?<br> 
		<input type="text" name="number" value="<?php echo $_GET['number']; ?>"> 
		<br> 
		<input type="submit" value="Generate Test">
	</form>
	<br>
	<br>
	
	<form>
	
	
	<?php
	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

	If ($_GET["type"] == "All"){
		$type = "*";
	}
	else {
		$type = $_GET["type"];
	}
	$number = $_GET["number"];
	
//	$sql = "SELECT * FROM Questions"; 
// 	$sql = "SELECT * FROM Questions WHERE QuestionId >= RAND() * (SELECT MAX(QuestionId) FROM Questions)";
	$sql = "SELECT * FROM Questions WHERE Type = '".$type."' LIMIT '".$number."'";
	$results = $db->query($sql);
	
	echo $results;
	
	$n = 0;
	
	
	foreach ($results as $row)
	{
		if ($n < $number)
		{
			if ($type == "all" or $row['Type'] == $type)
			{
				$n ++;
				echo "<p style='font-weight:bold;'>Question " . $n . "</p><br>";
				echo "<p>" . $row['Question'] . "</p><br><br>";
				echo "<input type='text' name='" . $row['QuestionId'] . "' ><br>"; 			
			}
		}
		else
		{
			break;
		}
	}
	if($n < $number)
	{
		echo "<p style='color:red'>There are no more questions of that type.</p><br><br>";
	}
	
	if($number > 0)
	{
		echo "<input type='submit' value='Submit Answers'>";
	}
	?>
	
</form>
<br><br><br>
	
</div>

<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>