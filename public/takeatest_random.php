<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_mytests.php");
?>



<div style="width: 500px; margin: 0px auto; border: 1px dotted; padding: 20px 170px 100px 170px">

<!-- Form to generate a test -->

	<form action=<?php echo htmlspecialchars('takeatest_random.php');?> method="get">
		Filter by type<br> 
		<input type="checkbox" style="display:inline; width:20px;" name="selectall" value="yes" class="selectall" <? if($_GET['selectall'] == 'yes'){ echo 'checked';}?>>All<br>
		<input type="checkbox" style="display:inline; width:20px;" name="type[]" value="shortanswer" <? if(in_array("shortanswer", $_GET['type'])){ echo 'checked';}?>>Short Answer<br>
		<input type="checkbox" style="display:inline; width:20px;" name="type[]" value="multichoice" <? if(in_array("multichoice", $_GET['type'])){ echo 'checked';}?>>Multiple Choice<br>
		<br>
		How many questions would you like to answer?<br> 
		<input type="number" name="number" value="<?php if($_GET['number'] > 0) { echo $_GET['number']; } else { echo 10; } ?>">

		<br> 
		<input type="submit" value="Generate Test">
	</form>
	<br>
	<br>
	
<!-- The test itself -->
		
	<form action="<?php echo htmlspecialchars('takeatest_check.php');?>" method="post">
		
		<?php
			
		/**
		 * Query based on criteria 
		 */
		
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
		$type = "'".implode("','", $_GET["type"])."'";
		$number = $_GET["number"];
		$sql = "SELECT * FROM Questions WHERE Type IN (".$type.") ORDER BY RAND() LIMIT $number";
		$questionsquery = $db->query($sql);
		
		
		/**
		 * Save some arrays 
		 */
		
		$n = 0;
		$questionids = array();
		$questions = array();
		
		foreach ($questionsquery as $questionrow)
		{
			$n ++;
			$id = $questionrow['QuestionId'];
			$question = $questionrow['Question'];
			
			$questionids[$n] = $id;	// Save questionids in array(questionno => id)
			$questions[$id] = $question;	// Save questions in array(id => question)
			
			$_SESSION['questionids'] = $questionids;	// Save questionids in SESSION
		}
		
		
		
		/**
		 * Output questions and form
		 */
		
		foreach($questionids as $n => $id)
		{
			echo "<p><span style='font-weight:bold;'>".$n.".</span> ".$questions[$id]." </p>";
			echo "<input type='text' name='".$id."' ><br>";
		
		}
		
				
		
		/**
		 * Error message 
		 */
		
		if($n < $number)
		{
			echo "<p style='color:red'>There are no more questions of that type.</p><br><br>";
		}
		
		/**
		 * Submit button 
		 */
		
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