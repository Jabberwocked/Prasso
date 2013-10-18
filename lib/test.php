<?php
/**
 * Class test
 */

class test 
{
		
	function __construct()
	{
		$this->testid;
		$this->testname;
		$this->questionids = array();
		$this->questionobjects = array();
	}
	

	
	/** 
	 * Pull test details to object (which will usually be saved as $_SESSION['test'])
	 */
	
	function pullfromdb($testid)
	{
		$this->testid = $testid;
		/** 
		 * Pull test name to object
		 */
		
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM Tests WHERE TestId=".$this->testid;
		$result = $db->query($sql);
		foreach ($result as $dbtest)
		{
			$this->testname = $dbtest['TestName'];
		}
		
		/**
		 * Pull questionids to object
		 */
		
		$sql = "SELECT * FROM Question_Test WHERE TestId=".$this->testid." ORDER BY OrderNo";
		$result = $db->query($sql);
		
		foreach ($result as $dbrelation)
		{
			$questionno = $dbrelation['OrderNo'];
			$this->questionids[$questionno] = $dbrelation['QuestionId'];
		}
		
		/**
		 * Pull questions and answers to questionobjects in object
		 */
		
		
		foreach ($this->questionids as $questionno => $questionid)
		{
			$sql = "SELECT * FROM Questions WHERE QuestionId=".$questionid;
			$resultquestions = $db->query($sql);
		
			$sql = "SELECT * FROM Answers WHERE QuestionId=".$questionid;
			$resultanswers = $db->query($sql);
		
			foreach ($resultanswers as $tempanswersobject)
			{
				$tempanswersarray[] = $tempanswersobject['Answer'];
			}
		
		
			foreach ($resultquestions as $tempquestionobject)
			{
				$this->questionobjects[$questionno] = new questionobject(array(	'questionno' => $questionno,
																				'question' => $tempquestionobject['Question'],
																				'type' => $tempquestionobject['Type'],
																				'answers' => $tempanswersarray));
			}
		
		}	
	}
	
	
	/** 
	 * Save question or test name to object
	 */
	
	function saveitem()
	{
		if (isset($_POST['testname']))
		{
			$this->testname = $_POST['testname'];
		}
		else
		{
			$this->questionobjects[$_POST['questionno']] = new questionobject($_POST);
		
			header("Location: mytests_edit.php");
		}
	}
	
	/**
	 * Save object properties to database tables
	 */
	function save()
	{
		/**
		 * Check if test name is given
		 */
		if ($this->testname == false)
		{
			echo "<p style='color:red'>Please insert a test name</p><br>";
		}
		else
		{
		
			/**
			 * Save questionobjects from object to table QUESTIONS
			 */
			$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
				
			foreach ($this->questionobjects as $questionno => $questionobject)
			{
				$qry = $db->prepare("INSERT INTO Questions (Question, Type) VALUES (:question,:type)");
				$qry->execute(array(':question'=>$questionobject->question,
									':type'=>$questionobject->type));
					
				//		save ids to array for later use...
				$this->questionids = array();
				$this->questionids[] = $db->lastInsertId();
					
			}
				
		
			/**
			 * Save answers from object to table ANSWERS
			 */
			$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
			$n = 0;
			foreach ($this->questionobjects as $questionno => $questionobject)
			{
				$questionid = $this->questionids[$n];
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
		
			$qry2 = $db->prepare("INSERT INTO Tests (TestName, UserId_Owner) VALUES (:TestName,:UserId_Owner)");
			$qry2->execute(array(	':TestName'=>$this->testname,
									':UserId_Owner'=>$_SESSION['userid']));
		
			// 	save testid for later use
			$TestId = $db->lastInsertId();
		
			/**
			 * Test name and owner are saved. Now save which questionids belong to testid in table QUESTION_TEST.
			 */
			//	
			$qry3 = $db->prepare("INSERT INTO Question_Test (QuestionId, TestId, OrderNo) VALUES (:QuestionId,:TestId,:OrderNo)");
			foreach ($this->questionids as $questionno=>$QuestionId)
			{
				$qry3->execute(array(':QuestionId'=>$QuestionId,':TestId'=>$TestId, ':OrderNo'=>$questionno));
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
		
	}
	
	/**
	 * Print test name, questionobjects and form
	 */
	
	function show()
	{
		if (!isset($_POST['itemtoedit']))
		{
			$itemtoedit = count($this->questionobjects) + 1;
		}
		else
		{
			$itemtoedit = $_POST['itemtoedit'];
		}
		
		
		if ($itemtoedit == "testname")
		{
			?>
		
		<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">	
			<input type="text" name="testname" <?php if (isset($this->testname)){echo "value=".$this->testname;}?> placeholder="Give your test a name." style="display:inline; width:55%">
			<button type="submit" name="action" value="save" >Save</button>
		</form>
		<br>
		
		<?php 
		}
		else
		{
		?>
		
			<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
				<button type="submit" name="itemtoedit" value="testname" style='
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
			
					<p><?php if (isset($this->testname)){ echo "Test name: <span style='font-weight:bold'>".$this->testname."</span>"; } else { echo "Test name"; }; ?></p>
				</button>	
			</form>	
			<br>
		<?php 
		
		}
	
		foreach ($this->questionobjects as $questionno => $questionobject)
		{
			if ($questionno < $itemtoedit)
			{
				$questionobject->show();
			}
		};
			
		
		if ($itemtoedit != "testname")
		{
		?>
			
			<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
				<input type="hidden" name="questionno" value='<?php echo $itemtoedit; ?>'>
				<input type="text" name="question" value='<?php echo $this->questionobjects[$itemtoedit]->question ?>' placeholder="Question <?php echo $itemtoedit ?>" style="display:inline; width:70%; font-weight:bold">
					<select name="type" style="width:45px;">
						<option value="shortanswer" <?php if ($this->questionobjects[$itemtoedit]->type == 'shortanswer' OR !isset($this->questionobjects[$itemtoedit])){echo 'selected';} ?>>SA: Short Answer</option>
						<option value="multichoice" <?php if ($this->questionobjects[$itemtoedit]->type == 'multichoice'){echo 'selected';} ?>>MC: Multiple Choice</option>
					</select> 
						
		<?php 
				
			$answerno = 1; 
				
			foreach ($this->questionobjects[$itemtoedit]->answers as $answer)
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
		
		
		foreach ($this->questionobjects as $questionno => $questionobject)
		{
			if ($questionno > $itemtoedit)
			{
				$questionobject->show();
			}
		};
		
		
		
		/** 
		 * Show Add button if not editing new question
		 */
		
		if ($itemtoedit != count($this->questionobjects) + 1)
		{ ?>
			<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
				<button type="submit" name="edit" value="<?php echo count($this->questionobjects) + 1 ?>" >Add</button>
			</form>
				<br>
				<br>
		<?php 
		} 
		
	}
	
	
}

?>