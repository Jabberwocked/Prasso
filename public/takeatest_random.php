<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">


	<form action="takeatest_random.php" method="get">
		Filter by type<br> 
		<input type="checkbox" style="display:inline; width:20px;" class="selectall">All<br>
		<input type="checkbox" style="display:inline; width:20px;" name="type[]" value="shortanswer" class="chk_boxes1" <? if(in_array("shortanswer", $_GET['type'])){ echo 'checked';}?>>Short Answer<br>
		<input type="checkbox" style="display:inline; width:20px;" name="type[]" value="multichoice" class="chk_boxes1" <? if(in_array("multichoice", $_GET['type'])){ echo 'checked';}?>>Multiple Choice<br>
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

	$type = "'".implode("','", $_GET["type"])."'";
	$number = $_GET["number"];
	
	$sql = "SELECT * FROM Questions WHERE Type IN (".$type.") ORDER BY RAND() LIMIT $number";
	
	
	$results = $db->query($sql);
	$n = 0;
	
	foreach ($results as $row)
	{
		$n ++;
		echo "<p style='font-weight:bold;'>Question " . $n . "</p><br>";
		echo "<p>" . $row['Question'] . "</p><br><br>";
		echo "<input type='text' name='" . $row['QuestionId'] . "' ><br>";
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