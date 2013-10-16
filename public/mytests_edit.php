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
	 * Process form depending on button pressed.
	 */
	/**
	 * DELETE ALL
	 */
	
	
	if ($_POST['action'] == "deleteall")
	{
		$_SESSION['questions'] = array();
		
		header("Location: mytests_edit.php");
	}
	
	/**
	 * SAVE QUESTION to session
	 */
	
	elseif ($_POST['action'] == "savequestion")
	{
		$_SESSION['questions'][$_POST['questionno']-1] = new question($_POST['questionno'], $_POST['question'], $_POST['type'], $_POST['answers']);
	
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
				
		//		save ids to array for later use...
				$questionids[] = $db->lastInsertId();
				
		// 		echo inserts to screen
				echo "1 record added: id = " . $db->lastInsertId() . "<br>";
			}
				
			echo "</p>"; // end p style for echos in foreach
			
			/**
			 * Save test to table TESTS
			 */
			
			$TestName = $_POST['testname'];
			$UserId_Owner = $_SESSION['userid'];
			$qry2 = $db->prepare("INSERT INTO Tests (TestName, UserId_Owner) VALUES (:TestName,:UserId_Owner)");
			$qry2->execute(array(':TestName'=>$TestName,':UserId_Owner'=>$UserId_Owner));
			
		// 	save testid for later use
			$TestId = $db->lastInsertId();
			
// 			Test name and owner are saved. Now save which questionids belong to testid.
			$qry3 = $db->prepare("INSERT INTO Question_Test (QuestionId, TestId, Orderno) VALUES (:QuestionId,:TestId,:OrderNo)");
			foreach ($questionids as $OrderNo=>$QuestionId)
			{
				$OrderNo ++;
				$qry3->execute(array(':QuestionId'=>$QuestionId,':TestId'=>$TestId, ':OrderNo'=>$OrderNo));
			}
			
			echo "<br><p style='font-weight:bold; color:green'>Test is saved.</p><br><br>"; // echo success
			
			/**
			 * End connection
			 */
			mysqli_close($db);
		
		}	
		
		$_SESSION['questions'] = array();
		header("Location: mytests.php");
	};
	
	
	
	/** 
	 * Print questions
	 */
	if (!isset($_POST['edit']))
	{
		$questionno = count($_SESSION['questions']) + 1;
	}
	if (isset($_POST['edit']))
	{
		$questionno = $_POST['edit'];
	}
	foreach ($_SESSION['questions'] as $key => $question)
	{
		if ($key + 1 < $questionno)
		{
			$question->show();
		}
	};
		
	
		?>
		
		
		<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
			<input type="hidden" name="questionno" value='<?php echo $questionno ?>'>
			<input type="text" name="question" value='<?php echo $_SESSION['questions'][$questionno-1]->question ?>' placeholder="Question <?php echo $questionno ?>" style="display:inline; width:70%; font-weight:bold">
			<select name="type" style="width:45px;">
				<option value="shortanswer" <?php if ($_SESSION['questions'][$questionno-1]->type == 'shortanswer' OR !isset($_SESSION['questions'][$questionno-1])){echo 'selected';} ?>>SA: Short Answer</option>
				<option value="multichoice" <?php if ($_SESSION['questions'][$questionno-1]->type == 'multichoice'){echo 'selected';} ?>>MC: Multiple Choice</option>
			</select> 
			
		<?php 
		$amountanswers = 0;
		foreach ($_SESSION['questions'][$questionno-1]->answers as $answer)
		{ 
		$amountanswers ++;
		?>
			<input type="text" name="answers[]" class="answers" value='<?php echo $answer ?>' placeholder="Answer 1" style="display:inline; width:60%">
		<?php 
		}
		if ($amountanswers == 0)
		{ ?>
			<input type="text" name="answers[]" class="answers" value='<?php echo $answer ?>' placeholder="Answer 1" style="display:inline; width:60%">
		<?php 
		}
		?>	
			
			<button type="button" id="addOption" value="Add" style="width:2em; height:2em; margin:0 0 0 0; padding:0 0 0 0; border: 0 0 0 0; ">+</button> 
			
			<button type="submit" name="action" value="savequestion" style="width:5em; height:2.5em; margin:0 0 0 0; padding:0 0 0 0; border: 0 0 0 0;">Save</button><br>
		</form>
				
		
		<?php 
		
	foreach ($_SESSION['questions'] as $key => $question)
	{
		if ($key + 1 > $questionno)
		{
			$question->show();
		}
	};
	
	
	
	/** 
	 * Form
	 */
	
	?>		
	
		<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
		<?php if($questionno != count($_SESSION['questions']) + 1){ ?>
		<button type="submit" name="edit" value="<?php echo count($_SESSION['questions']) + 1 ?>" style="width:4em; height:2.5em; margin:0 0 0 0; padding:0 0 0 0; border: 0 0 0 0;">Add</button>
		<?php } ?>
		<br>
		<br>
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