<?php

include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
// include_once (MENU_PATH . "/menu_mytests_new.php");




if (!isset($_SESSION['username']))
{
	header("Location:loginpage.php?location=" . urlencode($_SERVER['REQUEST_URI']));

}
else
{ ?>


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
		
		header("Location: mytests_edit.php");
	}
	
	/**
	 * ADD QUESTION to session
	 */
	
	elseif ($_POST['action'] == "addquestion")
	{
		$_SESSION['questions'][] = new question($_SESSION['questionno'], $_POST['question'], $_POST['type'], $_POST['answers']);
		$_SESSION['questionno'] ++;
	
		header("Location: mytests_edit.php");
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
			echo "<p style='color:red'>Please insert a test name</p><br>";
		}
		else 
		{
			echo "<p style='font-weight:bold'>" . $_POST['testname'] . "</p><br>";
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
			
			/**
			 * Save test to table TESTS
			 */
			
			$TestName = $_POST['testname'];
			$UserId_Owner = $_SESSION['userid'];
			$qry2 = $db->prepare("INSERT INTO Tests (TestName, UserId_Owner) VALUES (:TestName,:UserId_Owner)");
			$qry2->execute(array(':TestName'=>$TestName,':UserId_Owner'=>$UserId_Owner));
			
			echo "<br><p style='font-weight:bold; color:green'>Test is saved.</p><br><br>"; // echo success
			
			/**
			 * End connection
			 */
			mysqli_close($db);
		
		}	
		
		$_SESSION['questions'] = array();
		$_SESSION['questionno'] = 1;
		header("Location: mytests.php");
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
			<input type="text" name="question" placeholder="Question <?php echo $_SESSION['questionno']?>" style="display:inline; width:70%">
			<select name="type" style="width:45px;">
				<option value="shortanswer" selected>SA: Short Answer</option>
				<option value="multichoice">MC: Multiple Choice</option>
			</select> 
			<input type="text" name="answers[]" class="answers" placeholder="Answer 1" style="display:inline; width:60%">
			<button type="button" id="addOption" value="Add" style="width:2em; height:2em; margin:0 0 0 0; padding:0 0 0 0; border: 0 0 0 0; ">+</button> 
			<button type="submit" name="action" value="addquestion" style="width:5em; height:2.5em; margin:0 0 0 0; padding:0 0 0 0; border: 0 0 0 0;">Add</button><br>
		</form>
		<br>
		<br>
		<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
		<input type="text" name="testname" placeholder="Give your test a name." style="display:inline; width:55%">
		<button type="submit" name="action" value="save" style="width:4em; height:2.5em; margin:0 0 0 0; padding:0 0 0 0; border: 0 0 0 0;">Save</button>
		<button type="submit" name="action" value="deleteall" style="width:5em; height:2.5em; margin:0 0 0 0; padding:0 0 0 0; border: 0 0 0 0;">Delete</button>
		</form>
		<br>
		<br>
	
	
	
	
	</div>

<?php
} 
include_once (TEMPLATES_PATH . "/footer.php");
?>