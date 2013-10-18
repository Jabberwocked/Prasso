<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
	


/**
 * If a test is selected to edit, copy questions from db to session.
 */

if (isset($_POST['edittest']))
{
	$test->testing();
	$test->edit($_POST['edittest']);

} 



/**
 * Process form depending on button pressed.
 */
/**
 * DELETE ALL
 */


if ($_POST['action'] == "deleteall")
{
	$_SESSION['questionobjects'] = array();
	unset($_SESSION['testname']);
	
	header("Location: mytests_edit.php");
}

/**
 * SAVE QUESTION or TEST NAME to session
 */


elseif ($_POST['action'] == "save")
{
	if (isset($_POST['testname']))
	{
		$_SESSION['testname'] = $_POST['testname'];
	}
	else 
	{
		$_SESSION['questionobjects'][$_POST['questionno']-1] = new questionobject($_POST);
	
		header("Location: mytests_edit.php");
	}
}
/**
 * SAVE to database
 */

elseif ($_POST['action'] == "savetest")
{
	/**
	 * Check if test name is given
	 */
	if ($_SESSION['testname'] == false)
	{
		echo "<p style='color:red'>Please insert a test name</p><br>";
	}
	else 
	{
		
	/**
	 * Save questionobjects from SESSION to table QUESTIONS
	 */
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
		foreach ($_SESSION['questionobjects'] as $questionobject)
		{
			$question = $questionobject->question;
			$type = $questionobject->type;
			$qry = $db->prepare("INSERT INTO Questions (Question, Type) VALUES (:question,:type)");
			$qry->execute(array(':question'=>$question,':type'=>$type));
			
	//		save ids to array for later use...
			$questionids[] = $db->lastInsertId();
			
		}
			
		
		/**
		 * Save answers from SESSION to table ANSWERS
		 */
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
		$n = 0;
		foreach ($_SESSION['questionobjects'] as $questionobject)
		{
			$questionid = $questionids[$n];
			foreach ($questionobject->answers as $answer)
			{
				$qry = $db->prepare("INSERT INTO Answers (QuestionId, Answer) VALUES (:questionid,:answer)");
				$qry->execute(array(':questionid'=>$questionid,':answer'=>$answer));
			}
			
				
			$n ++;				
		}
			
		
		/**
		 * Save test to table TESTS
		 */
		
		$TestName = $_SESSION['testname'];
		$UserId_Owner = $_SESSION['userid'];
		$qry2 = $db->prepare("INSERT INTO Tests (TestName, UserId_Owner) VALUES (:TestName,:UserId_Owner)");
		$qry2->execute(array(':TestName'=>$TestName,':UserId_Owner'=>$UserId_Owner));
		
	// 	save testid for later use
		$TestId = $db->lastInsertId();
		
	//	Test name and owner are saved. Now save which questionids belong to testid.
		$qry3 = $db->prepare("INSERT INTO Question_Test (QuestionId, TestId, Orderno) VALUES (:QuestionId,:TestId,:OrderNo)");
		foreach ($questionids as $OrderNo=>$QuestionId)
		{
			$OrderNo ++;
			$qry3->execute(array(':QuestionId'=>$QuestionId,':TestId'=>$TestId, ':OrderNo'=>$OrderNo));
		}
		
		// echoes useless?
		echo "<br><p style='font-weight:bold; color:green'>Test is saved.</p>"; // echo success
		echo "<p>Go to <a href='mytests.php'>My Tests</a></p>";
		echo "<br><br>";
		echo "<p>Test name: <span style='font-weight:bold; font-style:italic'>".$_POST['testname']."</span></p><br>";
		
		
		header('location:mytests.php');
		
		/**
		 * End connection
		 */
		mysqli_close($db);
	

	}	
	

};



/** 
 * Print test name, questionobjects and form
 */

if (!isset($_POST['edit']))
{
	$questionno = count($_SESSION['questionobjects']) + 1;
}
else 
{
	$questionno = $_POST['edit'];
}


if ($questionno == "testname")
{
?>	

<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">	
	<input type="text" name="testname" <?php if (isset($_SESSION['testname'])){echo "value=".$_SESSION['testname'];}?> placeholder="Give your test a name." style="display:inline; width:55%">
	<button type="submit" name="action" value="save" >Save</button>
</form>
<br>

<?php 
}
else
{
?>

	<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
		<button type="submit" name="edit" value="testname" style='
			width:auto; 
			height:auto; 
			margin:0; 
			padding:0; 
			border: 0;
			background:none; 
			color:#666; 
			text-align:left; 
			-moz-border-radius: 0px;
			-webkit-border-radius: 0px;
			border-radius: 0px;
			-moz-box-shadow: 0;
			-webkit-box-shadow: 0;
			box-shadow: none;
			-webkit-appearance: none;
			text-transform: none;
			letter-spacing: 1px;'>
	
			<p><?php if (isset($_SESSION['testname'])){ echo "Test name: <span style='font-weight:bold'>".$_SESSION['testname']."</span>"; } else { echo "Test name"; }; ?></p>
		</button>	
	</form>	
	<br>
<?php 

}

foreach ($_SESSION['questionobjects'] as $key => $questionobject)
{
	if ($key + 1 < $questionno)
	{
		$questionobject->show();
	}
};
	

if ($questionno != "testname")
{
?>
	
	<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
		<input type="hidden" name="questionno" value='<?php echo $questionno ?>'>
		<input type="text" name="question" value='<?php echo $_SESSION['questionobjects'][$questionno-1]->question ?>' placeholder="Question <?php echo $questionno ?>" style="display:inline; width:70%; font-weight:bold">
			<select name="type" style="width:45px;">
				<option value="shortanswer" <?php if ($_SESSION['questionobjects'][$questionno-1]->type == 'shortanswer' OR !isset($_SESSION['questionobjects'][$questionno-1])){echo 'selected';} ?>>SA: Short Answer</option>
				<option value="multichoice" <?php if ($_SESSION['questionobjects'][$questionno-1]->type == 'multichoice'){echo 'selected';} ?>>MC: Multiple Choice</option>
			</select> 
				
<?php 
		
	$answerno = 1; 
		
	foreach ($_SESSION['questionobjects'][$questionno-1]->answers as $answer)
	{ 
?>
	
		<input type="text" name="answers[]" class="answers" value='<?php echo $answer ?>' placeholder="Answer <?php echo $answerno ?>" style="display:inline; width:60%">
<?php 
		$answerno ++;
	}
	if ($answerno == 1)
	{ 
?>
		<input type="text" name="answers[]" class="answers" placeholder="Answer <?php echo $answerno ?>" style="display:inline; width:60%">
<?php 
		$answerno ++;
	}
?>
	<script>
	   	var answernojs = <?php echo json_encode($answerno); ?>;
	</script>	
				
	<button type="button" id="addOption" value="Add" >+</button> |
	<button type="submit" name="action" value="save" >Save</button><br>
	<br>
	</form>
				
		
<?php 
};


foreach ($_SESSION['questionobjects'] as $key => $question)
{
	if ($key + 1 > $questionno)
	{
		$question->show();
	}
};



/** 
 * Show Add button if not editing new question
 */

if ($questionno != count($_SESSION['questionobjects']) + 1)
{ ?>
	<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
		<button type="submit" name="edit" value="<?php echo count($_SESSION['questionobjects']) + 1 ?>" >Add</button>
	</form>
		<br>
		<br>
<?php 
} 


/** 
 * Buttons: Save test or delete questions
 */

 
 ?>	

	
<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">	
	<button type="submit" name="action" value="savetest" >Save</button> |
	<button type="submit" name="action" value="deleteall" >Delete</button>
</form>
<br>
<br>
	
	
	
	
</div>

<?php

include_once (TEMPLATES_PATH . "/footer.php");
?>