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
		$this->questionids = array(); // orderno => questionid
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
			$orderno = $dbrelation['OrderNo'];
			$this->questionids[$orderno] = $dbrelation['QuestionId'];
		}
		
		/**
		 * Pull questions and answers to questionobjects in object (session)
		 */
		
		
		foreach ($this->questionids as $orderno => $questionid)
		{
			$this->questionobjects[$orderno] = new questionobject;
			$this->questionobjects[$orderno]->pullfromdb($orderno, $questionid);
		}	
	}
	
	
	
	
	
	
	
	
	/** 
	 * Save question or test name to object (session)
	 */
	
	function saveitem()
	{
		if (isset($_POST['testname']))
		{
			$this->testname = $_POST['testname'];
		}
		else
		{
			$this->questionobjects[$_POST['orderno']] = new questionobject($_POST);
		
// 			header("Location: mytests_edit.php");
		}
	}
	
	
	
	
	
	
	/**
	 * Add object properties to database tables
	 */
	function add()
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
				
			foreach ($this->questionobjects as $orderno => $questionobject)
			{
				$qry = $db->prepare("INSERT INTO Questions (Question, Type) VALUES (:question,:type)");
				$qry->execute(array(':question'=>$questionobject->question,
									':type'=>$questionobject->type));
					
				//		save ids to array for later use...
				$this->questionids[$orderno] = $db->lastInsertId();
					
			}
				
		
			/**
			 * Save answers from object to table ANSWERS
			 */
			$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
			foreach ($this->questionobjects as $orderno => $questionobject)
			{
				$questionid = $this->questionids[$orderno];
				foreach ($questionobject->answers as $answer)
				{
					$qry = $db->prepare("INSERT INTO Answers (QuestionId, Answer) VALUES (:questionid,:answer)");
					$qry->execute(array(':questionid'=>$questionid,':answer'=>$answer));
				}
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
			foreach ($this->questionids as $orderno=>$QuestionId)
			{
				$qry3->execute(array(':QuestionId'=>$QuestionId,':TestId'=>$TestId, ':OrderNo'=>$orderno));
			}
		
			
			echo "<br><p style='font-weight:bold; color:green'>Test is saved.</p>"; // echo success (useless)
					
			header('location:mytests.php');
		
			/**
			 * End connection
			*/
			mysqli_close($db);
		
		
		}
		
	}
	
	
	
	
	
	
	
	/**
	 * Update database tables with changed object properties. NOT WORKING YET
	 */
	function update()
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
				
			foreach ($this->questionobjects as $orderno => $questionobject)
			{
// 				$qry = $db->prepare("UPDATE Questions SET Question=:question,Type=:type WHERE QuestionId=:questionid");
// 				DISCONTINUED: RETHINK. SAVED QUESTIONS MUST NOT BE CHANGED.
				$qry->execute(array(':question'=>$questionobject->question,
									':type'=>$questionobject->type));
					
				//		save ids to array for later use...
				$this->questionids[$orderno] = $db->lastInsertId();
					
			}
				
		
			/**
			 * Save answers from object to table ANSWERS
			 */
			$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
			$n = 0;
			foreach ($this->questionobjects as $orderno => $questionobject)
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
			foreach ($this->questionids as $orderno=>$QuestionId)
			{
				$qry3->execute(array(':QuestionId'=>$QuestionId,':TestId'=>$TestId, ':OrderNo'=>$orderno));
			}
		
			
			echo "<br><p style='font-weight:bold; color:green'>Test is saved.</p>"; // echo success (useless)
					
			header('location:mytests.php');
		
			/**
			 * End connection
			*/
			mysqli_close($db);
		
		
		}
		
	}
	
	
	
	
	
	
	
	
	
	/**
	 * Print test name and questionobjects as buttons and a form for the item that's being edited
	 */
	
	function show()
	{
		
		/**
		 * Set which item is being edited. If none then new question.
		 */
		
		if (!isset($_SESSION['itemtoedit']))
		{
			$itemtoedit = count($this->questionobjects) + 1;
		}
		else
		{
			$itemtoedit = $_SESSION['itemtoedit'];
		}

		
		echo "lala<br>";
		echo "post" . $_POST['itemtoedit'] . "<br>";
		echo "session" . $_SESSION['itemtoedit'] . "<br>";
		echo "var" . $itemtoedit . "<br>";
		
		/** 
		 * Output form
		 */

		?>
				
		<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
<!-- 	First button needs to have the default value. When enter is pressed this value for itemtoedit is used. -->
		<button type=hidden type="submit" name="itemtoedit" value=<?php echo count($_SESSION['test']->questionobjects) + 1; ?> ></button>
		
		<?php 
		/**
		 * Test name 
		 */
		
		if ($itemtoedit == "testname") { 	?>
					
			<input type="text" name="testname" <?php if (isset($this->testname)){echo "value=".$this->testname;}?> placeholder="Give your test a name." autofocus style="display:inline; width:55%"><br>
	
		
		<?php } else { ?>
		
			
			<button class='textlayout' type="submit" name="itemtoedit" value="testname" >
				<p><?php if (isset($this->testname)){ echo "Test name: <span style='font-weight:bold'>".$this->testname."</span>"; } else { echo "Test name"; }; ?></p>
			</button><br>
		
		<?php }
	
		/**
		 * Then output all questions that come before the edited question.
		 */
		
		foreach ($this->questionobjects as $orderno => $questionobject)
		{
			if ($orderno < $itemtoedit)
			{
				$questionobject->show();
			}
		};
			
		/**
		 * Then output editing fields for the chosen question.
		 */
		
		if ($itemtoedit != "testname")
		{ ?>
				<input type="hidden" name="orderno" value='<?php echo $itemtoedit; ?>'>
				<input type="text" name="question" value='<?php echo $this->questionobjects[$itemtoedit]->question ?>' placeholder="Question <?php echo $itemtoedit ?>" autofocus style="display:inline; width:70%; font-weight:bold">
				<select name="type" style="width:45px;">
					<option value="shortanswer" <?php if ($this->questionobjects[$itemtoedit]->type == 'shortanswer' OR !isset($this->questionobjects[$itemtoedit])){echo 'selected';} ?>>SA: Short Answer</option>
					<option value="multichoice" <?php if ($this->questionobjects[$itemtoedit]->type == 'multichoice'){echo 'selected';} ?>>MC: Multiple Choice</option>
				</select> 
				<?php $answerno = 1; foreach ($this->questionobjects[$itemtoedit]->answers as $answer){	?>
				<input type="text" name="answers[]" class="answers" value='<?php echo $answer ?>' placeholder="Answer <?php echo $answerno ?>" style="display:inline; width:60%">
				<?php $answerno ++;} if ($answerno == 1){ ?>
				<input type="text" name="answers[]" class="answers" placeholder="Answer <?php echo $answerno ?>" style="display:inline; width:60%">
				<?php $answerno ++;}?><script> var answernojs = <?php echo json_encode($answerno); ?>;</script>	
				<button type="button" id="addOption" value="Add" >+</button>
			 	<input type="hidden" name="action" value="save"> 
				<br>
			
		<?php 
		};
		
		/**
		 * Then output all questions that come after the edited question.
		 */
		
		foreach ($this->questionobjects as $orderno => $questionobject)
		{
			if ($orderno > $itemtoedit)
			{
				$questionobject->show();
			}
		};
		
		
		
		/** 
		 * Show Add Question button if not editing new question
		 */
		
		if ($itemtoedit != count($this->questionobjects) + 1)
		{ ?>
			<button type="submit" name="itemtoedit" value="<?php echo count($this->questionobjects) + 1 ?>" >Add question</button><br>
				<br>
		<?php }  
		
		
		/** 
		 * Buttons: Save test or delete questions
		 */

 		?>	
	
		<button type="submit" name="action" value="savetest" >Save</button> |
		<button type="submit" name="action" value="reset" >Reset</button>
		
		</form>
		<br>
		<br>
	
	
	<?php 
	}
	
	
}

?>