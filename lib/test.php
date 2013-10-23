<?php

/**
 * Class test
 */
class test
{
	public $testid;
	public $testname;
	public $questionids = array(); // orderno => questionid
	public $questionobjects = array(); //orderno => questionobject	

	/**
	 * New, also used to reset object
	 */
	function __construct( )
	{
		$this->testid;
		$this->testname;
		$this->questionids = array(); 
		$this->questionobjects = array();
	}


	/**
	 * Pull test details to object (which will usually be saved as $_SESSION['test'])
	 */
	function pullfromdb( $testid )
	{
		$this->testid = $testid;
		
		/**
		 * Pull test name to object
		 */
		
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM Tests WHERE TestId=" . $this->testid;
		$result = $db->query($sql);
		foreach ($result as $dbtest)
		{
			$this->testname = $dbtest['TestName'];
		}
		
		/**
		 * Pull questionids to object
		 */
		
		$sql = "SELECT * FROM Question_Test WHERE TestId=" . $this->testid . " ORDER BY OrderNo";
		$result = $db->query($sql);
		
		foreach ($result as $dbrelation)
		{
			$orderno = $dbrelation['OrderNo'];
			$this->questionids[$orderno] = $dbrelation['QuestionId'];
			$tempscoreperquestion[$orderno] = $dbrelation['Score']; //see below
		}
		
		/**
		 * Pull questions and answers to questionobjects in object (session)
		 */
		
		foreach ($this->questionids as $orderno => $questionid)
		{
			$this->questionobjects[$orderno] = new questionobject();
			$this->questionobjects[$orderno]->pullfromdb($orderno, $questionid);
			$this->questionobjects[$orderno]->questionscore = $tempscoreperquestion[$orderno]; 
		}
	}


	/**
	 * Save question or test name to object (session)
	 */
	function saveitem( )
	{
		if (isset($_POST['testname']))
		{
			$this->testname = $_POST['testname'];
		}
		else
		{
			$this->questionobjects[$_POST['orderno']] = new questionobject($_POST);
			
			// header("Location: test_edit.php");
		}
	}


	/**
	 * Add object properties to database tables
	 */
	function add( )
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
				$qry->execute(array(
					':question' => $questionobject->question,
					':type' => $questionobject->type));
				
				// save ids to array for later use...
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
					$qry->execute(array(
						':questionid' => $questionid,
						':answer' => $answer));
				}
			}
			
			/**
			 * Save test to table TESTS
			 */
			
			$qry2 = $db->prepare("INSERT INTO Tests (TestName, UserId_Owner) VALUES (:TestName,:UserId_Owner)");
			$qry2->execute(array(
				':TestName' => $this->testname,
				':UserId_Owner' => $_SESSION['userid']));
			
			// save testid for later use
			$TestId = $db->lastInsertId();
			
			/**
			 * Test name and owner are saved.
			 * Now save which questionids belong to testid in table QUESTION_TEST.
			 */
			//
			$qry3 = $db->prepare("INSERT INTO Question_Test (QuestionId, TestId, OrderNo) VALUES (:QuestionId,:TestId,:OrderNo)");
			foreach ($this->questionids as $orderno => $QuestionId)
			{
				$qry3->execute(array(
					':QuestionId' => $QuestionId,
					':TestId' => $TestId,
					':OrderNo' => $orderno));
			}
			
			echo "<br><p style='font-weight:bold; color:green'>Test is saved.</p>"; // echo success (useless)
			
			header('location:mytests.php');
			
			/**
			 * End connection
			 */
			mysqli_close($db);
			
			/* Reset test in session */
			$_SESSION['test'] = new test();
		}
	}


	/**
	 * Update database tables with changed object properties.
	 * NOT WORKING YET
	 */
	function update( )
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
				// $qry = $db->prepare("UPDATE Questions SET Question=:question,Type=:type WHERE QuestionId=:questionid");
				// DISCONTINUED: RETHINK. SAVED QUESTIONS MUST NOT BE CHANGED.
				$qry->execute(array(
					':question' => $questionobject->question,
					':type' => $questionobject->type));
				
				// save ids to array for later use...
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
					$qry->execute(array(
						':questionid' => $questionid,
						':answer' => $answer));
				}
				
				$n ++;
			}
			
			/**
			 * Save test to table TESTS
			 */
			
			$qry2 = $db->prepare("INSERT INTO Tests (TestName, UserId_Owner) VALUES (:TestName,:UserId_Owner)");
			$qry2->execute(array(
				':TestName' => $this->testname,
				':UserId_Owner' => $_SESSION['userid']));
			
			// save testid for later use
			$TestId = $db->lastInsertId();
			
			/**
			 * Test name and owner are saved.
			 * Now save which questionids belong to testid in table QUESTION_TEST.
			 */
			//
			$qry3 = $db->prepare("INSERT INTO Question_Test (QuestionId, TestId, OrderNo) VALUES (:QuestionId,:TestId,:OrderNo)");
			foreach ($this->questionids as $orderno => $QuestionId)
			{
				$qry3->execute(array(
					':QuestionId' => $QuestionId,
					':TestId' => $TestId,
					':OrderNo' => $orderno));
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
	 * Shows questions for editing: Prints test name and questionobjects as buttons and a form for the item that's being edited
	 */
	function show( )
	{
		
		/**
		 * Set which item is being edited.
		 * If none then new question.
		 */
		if (! isset($_SESSION['itemtoedit']))
		{
			$itemtoedit = count($this->questionobjects) + 1;
		}
		else
		{
			$itemtoedit = $_SESSION['itemtoedit'];
		}

		
		/**
		 * Output form
		 */
		
		?>

<form action=<?php echo htmlspecialchars('test_edit.php');?>
	method="post">
	<!-- 	First button needs to have the default value. When enter is pressed this value for itemtoedit is used. -->
	<button type=hidden type="submit" name="itemtoedit"
		value=<?php if ($itemtoedit == count($_SESSION['test']->questionobjects) + 1){echo count($_SESSION['test']->questionobjects) + 2; } else {echo count($_SESSION['test']->questionobjects) + 1; }; ?>></button>
		
		<?php
		/**
		 * Test name
		 */
		
		if ($itemtoedit == "testname")
		{
			?>
					
			<input type="text" name="testname"
		<?php if (isset($this->testname)){echo "value=".$this->testname;}?>
		placeholder="Give your test a name." autofocus
		style="display: inline; width: 55%"><br> <input type="hidden"
		name="action" value="save"> 
		
		<?php } else { ?>
		
			
			<button class='textlayout' type="submit" name="itemtoedit"
		value="testname">
		<p><?php if (isset($this->testname)){ echo "Test name: <span style='font-weight:bold'>".$this->testname."</span>"; } else { echo "Test name"; }; ?></p>
	</button>
	<br>
		
		<?php
		
}
		
		/**
		 * Then output all questions that come before the edited question.
		 */
		
		foreach ($this->questionobjects as $orderno => $questionobject)
		{
			if ($orderno < $itemtoedit)
			{
				$questionobject->show();
			}
		}
		;
		
		/**
		 * Then output editing fields for the chosen question.
		 */
		
		if ($itemtoedit != "testname")
		{
			?>
				<input type="hidden" name="orderno"
		value='<?php echo $itemtoedit; ?>'> <input type="text" name="question"
		value='<?php echo $this->questionobjects[$itemtoedit]->question ?>'
		placeholder="Question <?php echo $itemtoedit ?>" autofocus
		style="display: inline; width: 70%; font-weight: bold"> <select
		name="type" style="width: 45px;">
		<option value="shortanswer"
			<?php if ($this->questionobjects[$itemtoedit]->type == 'shortanswer' OR !isset($this->questionobjects[$itemtoedit])){echo 'selected';} ?>>SA:
			Short Answer</option>
		<option value="multichoice"
			<?php if ($this->questionobjects[$itemtoedit]->type == 'multichoice'){echo 'selected';} ?>>MC:
			Multiple Choice</option>
	</select> 
				<?php $answerno = 1; foreach ($this->questionobjects[$itemtoedit]->answers as $answer){	?>
				<input type="text" name="answers[]" class="answers"
		value='<?php echo $answer ?>'
		placeholder="Answer <?php echo $answerno ?>"
		style="display: inline; width: 60%">
				<?php $answerno ++;} if ($answerno == 1){ ?>
				<input type="text" name="answers[]" class="answers"
		placeholder="Answer <?php echo $answerno ?>"
		style="display: inline; width: 60%">
				<?php $answerno ++;}?><script> var answernojs = <?php echo json_encode($answerno); ?>;</script>
	<button type="button" id="addOption" value="Add">+</button>
	<input type="hidden" name="action" value="save"> <br>
				
				
		<?php
		}
		;
		
		/**
		 * Then output all questions that come after the edited question.
		 */
		
		foreach ($this->questionobjects as $orderno => $questionobject)
		{
			if ($orderno > $itemtoedit)
			{
				$questionobject->show();
			}
		}
		;
		
		/**
		 * Show Add Question button if not editing new question
		 */
		
		if ($itemtoedit != count($this->questionobjects) + 1)
		{
			?>
			<br>
	<button type="submit" name="itemtoedit"
		value="<?php echo count($this->questionobjects) + 1 ?>">Add question</button>
	<br> <br>
		<?php
		
}
		
		/**
		 * Buttons: Save test or delete questions
		 */
		
		?>	
		
		<br>
	<div style="position: absolute; bottom: 50px">
		<button type="submit" name="action2" value="savetest">Save Test</button>
		|
		<button type="submit" name="action" value="reset">Reset</button>
	</div>

</form>
<br>
<br>


<?php
	}


	/**
	 * Output as test
	 */
	function showastest( )
	{
		echo "<form action=" . htmlspecialchars('test_check.php') . " method='post'>";
		if (isset($this->testname))
		{
			echo "<p style='font-weight:bold;'> " . $this->testname . " </p><br>";
		}
		else
		{
			echo "<p style='font-weight:bold;'>Random Test</p><br>";
		}
		;
		
		/**
		 * Output questions and form
		 */
		
		foreach ($this->questionobjects as $orderno => $questionobject)
		{
			echo "<p><span style='font-weight:bold;'>" . $orderno . ".</span> " . $questionobject->question . " </p>";
			echo "<input type='text' name='" . $questionobject->questionid . "' ><br>";
		}
		;
		
		/**
		 * Error message for random tests
		 */
		
		if (isset($_GET['number']))
		{
			if ($orderno < $_GET['number'])
			{
				echo "<p style='color:red'>There are no more questions of that type.</p><br><br>";
			}
		}
		;
		
		/**
		 * Submit button
		 */
		
		echo "<input type='submit' value='Submit Answers'>";
		echo "</form>";
	}


/**
 * Pull random questions from db and output as test
 */
	function pullrandomfromdb( $data ) // $data from $_GET
	{
		
		/**
		 * Query based on criteria
		 */
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
		$type = "'" . implode("','", $data["type"]) . "'";
		$number = $data["number"];
		$sql = "SELECT * FROM Questions WHERE Type IN (" . $type . ") ORDER BY RAND() LIMIT $number";
		$questionsquery = $db->query($sql);
		
		foreach ($questionsquery as $orderno => $questionrow)
		{
			$orderno ++; // now starts at 1
			$this->questionids[$orderno] = $questionrow['QuestionId'];
			$this->questionobjects[$orderno] = new questionobject();
			$this->questionobjects[$orderno]->pullfromdb($orderno, $questionrow['QuestionId']);
		}
	}

/**
 * Returns array scoresearned
 */
	function checkanswers($useranswers)
	{
		$scoresearned = array();
		$totalscore = 0;
		foreach ($this->questionids as $orderno => $questionid)
		{
			$answerkey = array_search($useranswers[$questionid], $_SESSION['test']->questionobjects[$orderno]->answers);
			if (is_int($answerkey))
			{
				$scoresearned[$questionid] = $_SESSION['test']->questionobjects[$orderno]->scorepercentages[$answerkey] / 100 * $_SESSION['test']->questionobjects[$orderno]->questionscore;
			}
			else
			{
				$scoresearned[$questionid] = 0;
			};
			$totalscore += $scoresearned[$questionid];
		}
		$scoresearned['totalscore'] = $totalscore;
		print_r($scoresearned);
		return $scoresearned;
	}	

/** 
 * Saves user answers, score and test data to db 
 */
	function saveresultstodb($useranswers, $scoresearned)
	{
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
			
		$qry = $db->prepare("INSERT INTO Testresults (TestId, UserIdOwner) VALUES (:TestId, :UserIdOwner)");
		$qry->execute(array(
			':TestId' => $this->testid,
			':UserIdOwner' => $_SESSION['userid']));
		$resultid = $db->lastInsertId();

		foreach ($this->questionids as $orderno => $questionid)
		{
			
			$qry = $db->prepare("INSERT INTO UserAnswers (UserAnswer, ScoreEarned, QuestionId, QuestionLogged, AnswerLogged, MaxScoreLogged) VALUES (:UserAnswer, :ScoreEarned, :QuestionId, :QuestionLogged, :AnswerLogged, :MaxScoreLogged)");
			$qry->execute(array(
				':UserAnswer' => $useranswers[$questionid], 
				':ScoreEarned' => $scoresearned[$questionid], 
				':QuestionId' => $questionid, 
				':QuestionLogged' => $_SESSION['test']->questionobjects[$orderno]->question, 
				':AnswerLogged' => implode("','", $_SESSION['test']->questionobjects[$orderno]->answers), 
				':MaxScoreLogged' => $_SESSION['test']->questionobjects[$orderno]->questionscore));		
			
			$useranswerid = $db->lastInsertId();
			
			$qry = $db->prepare("INSERT INTO Testresults_UserAnswers (ResultId, UserAnswerId) VALUES (:ResultId, :UserAnswerId)");
			$qry->execute(array(
				':ResultId' => $resultid,
				':UserAnswerId' => $useranswerid));
		
		};
	}	

/** 
 * Echo question, answer, useranswer, score and totalscore
 * TODO update
 */
	function showresults($useranswers, $scoresearned)
	{
	
		foreach ($this->questionids as $orderno => $questionid)
		{
	
			if ($scoresearned[$questionid] == $_SESSION['test']->questionobjects[$orderno]->questionscore)
			{
				$colour = "lightgreen";
			}
			elseif ($scoresearned[$questionid] == 0)
			{
				$colour = "lightcoral";
			}
			else 
			{
				$colour = "yellow";
			};
			
			echo "<p style='background-color:" . $colour . "'>";
			echo "<span style='font-weight:bold; max-width:200px;'> ".$orderno.". ".$this->questionobjects[$orderno]->question."</span><span style='display: block; float:right'> Score: " . $scoresearned[$questionid] . "</span><br>";
			echo "<span>>" . $useranswers[$questionid] . "</span><span style='display: block; float:right'> Answer: "; $n = 1; foreach ($this->questionobjects[$orderno]->answers as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;};echo "</span>";
			echo "</p>";
		};
		echo "<p style='font-weight:bold'> Totalscore: " . $scoresearned['totalscore'] . "</p><br><br>";
	}

	
	
};
?>