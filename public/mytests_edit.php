<?php

include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
// include_once (MENU_PATH . "/menu_mytests_new.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">
		
<?php 

/**
 * Set questionno to 1 if not set yet. (Specific for this test, i.e. not database related.)
 */

if ($_SESSION['questionno'] == false)
{
	$_SESSION['questionno'] = 1;
};


/**
 * Process form depending on button pressed.
 */
/**
 * DELETE ALL
 */


if ($_POST['action'] == "deleteall")
{
	$_SESSION['questions'] = array();
	$_SESSION['questionno'] = 1;
}

/**
 * ADD QUESTION to session
 */

elseif ($_POST['action'] == "addquestion")
{
	$_SESSION['questions'][] = new question($_SESSION['questionno'], $_POST['question'], $_POST['type'], $_POST['answer1']);
	$_SESSION['questionno'] ++;
}

/**
 * SAVE
 */

elseif ($_POST['action'] == "save")
{
	/**
	 * Check if test name is given
	 */
	if ($_POST['testname'] == false)
	{
		echo "<p style='color:red'>Please insert a test name</p>";
	}
	else 
	{
		/**
		 * Save questions from SESSION to table QUESTIONS
		 */
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
		echo "<p style='color:green'>"; // set p style for echo in foreach
		
		foreach ($_SESSION['questions'] as $questionobject)
		{
			$question = $questionobject->question;
			$type = $questionobject->type;
			$qry = $db->prepare("INSERT INTO Questions (Question, Type) VALUES (:question,:type)");
			$qry->execute(array(':question'=>$question,':type'=>$type));
			
	// 		echo inserts to screen
			$insert_id=$db->lastInsertId();
			echo "1 record added: id = $insert_id<br>";
		}
			
		echo "</p>"; // end p style for echos in foreach
		
// 		/**
// 		 * Save test to table TESTS
// 		 */
		
// 		$TestName = $_POST['testname'];
// 		$UserId_Owner = $_SESSION['username'];
// 		$qry2 = $db->prepare("INSERT INTO Tests (TestName, UserId_Owner) VALUES (:TestName,:UserId_Owner)");
// 		$qry2->execute(array(':TestName'=>$TestName,':UserId_Owner'=>$UserId_Owner));
		
// 		echo "<br><p style='font-weight:bold; color:green'>Test is saved.</p><br><br>"; // echo success
		
		/**
		 * End connection
		 */
		mysqli_close($db);
	
	}	
	
};



/** 
 * Print questions
 */

foreach ($_SESSION['questions'] as $question)
{
	$question->show();
};




/** 
 * Form
 */

?>		
	<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
		Question<br> 
		<input type="text" name="question"><br>
		<input type="radio" style="display:inline; width:20px;" name="type" value="shortanswer" checked>Short Answer<br>
		<input type="radio" style="display:inline; width:20px;" name="type" value="multichoice" >Multiple Choice<br>
		Answers<br> 
		<input type="text" name="answer1" class="answers"><br>
		<br>
		<input type="button" id="addOption" value="Add" /><br>
		<br>
		<br> 
		<button type="submit" name="action" value="addquestion">Add Question</button>
		<button type="submit" name="action" value="deleteall" >Delete All</button><br>
	</form>
	<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
	<input type="text" name="testname"><br>
	<button type="submit" name="action" value="save" >Save</button>
	</form>
	<br>
	<br>




</div>

<?php 
include_once (TEMPLATES_PATH . "/footer.php");
?>