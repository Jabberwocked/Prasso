<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
	

/**
 * If a test is selected to edit, copy questions from db to session.
 */

if (isset($_POST['editquestion']))
{
	$testid = $_POST['editquestion'];

	$_SESSION['questions'] = array();
	
	
	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	$sql = "SELECT * FROM Question_Test WHERE TestId=".$testid." ORDER BY OrderNo";
	$result = $db->query($sql);
	
	
	foreach ($result as $relation)
	{
		$questionids[] = $relation['QuestionId'];
	}
	$questionidsqry = "'".implode("','", $questionids)."'";
	
	$sql2 = "SELECT * FROM Questions WHERE QuestionId IN (".$questionidsqry.")";
	$result2 = $db->query($sql2);
	
	$questionno = 1;
	
	foreach ($result2 as $questionobject)
	{
				
		$question = $questionobject['question'];
		$type = $questionobject['type'];
		$answers = $questionobject['answer'];
		$_SESSION['questions'][] = new question($questionno, $question, $type, $answers);
		
		
		$questionno ++;
	}
} 
// temp
print_r($_SESSION['questions']);
foreach ($_SESSION['questions'] as $key => $question)
{
	$question->show();
}


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
	$answerno = 1; 
	
	foreach ($_SESSION['questions'][$questionno-1]->answers as $answer)
	{ 
?>

	<input type="text" name="answers[]" class="answers" value='<?php echo $answer ?>' placeholder="Answer <?php echo $answerno ?>" style="display:inline; width:60%">
		<?php 
		$answerno ++;
		}
		if ($answerno == 1)
		{ ?>
			<input type="text" name="answers[]" class="answers" value='<?php echo $answer ?>' placeholder="Answer <?php echo $answerno ?>" style="display:inline; width:60%">
		<?php 
		}
		?>
		<script>
    	var answernojs = <?php echo json_encode($answerno); ?>;
		</script>	
			
			<button type="button" id="addOption" value="Add" >+</button> |
			
			<button type="submit" name="action" value="savequestion" >Save</button><br>
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
	<button type="submit" name="edit" value="<?php echo count($_SESSION['questions']) + 1 ?>" >Add</button>
<?php } ?>
	<br>
	<br>
	<input type="text" name="testname" placeholder="Give your test a name." style="display:inline; width:55%">
	<button type="submit" name="action" value="save" >Save</button> |
	<button type="submit" name="action" value="deleteall" >Delete</button>
</form>
<br>
<br>
	
	
	
	
</div>

<?php

include_once (TEMPLATES_PATH . "/footer.php");
?>