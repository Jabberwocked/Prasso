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
		
		$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM tests WHERE testid=" . $this->testid;
		$dbtests = $db->query($sql);
		foreach ($dbtests as $dbtest)
		{
			$this->testname = $dbtest['testname'];
		}
		
		/**
		 * Pull questionids to object
		 */
		
		$sql = "SELECT * FROM test_items WHERE testid=" . $this->testid . " ORDER BY orderno";
		$test_items = $db->query($sql);
		
		foreach ($test_items as $test_item)
		{
			$orderno = $test_item['orderno'];
			$this->questionids[$orderno] = $test_item['questionid'];
			$tempgradeperquestion[$orderno] = $test_item['grade']; //see below
		}
		
		/**
		 * Pull questions and answers to questionobjects in object (session)
		 */
		
		foreach ($this->questionids as $orderno => $questionid)
		{
			$this->questionobjects[$orderno] = new questionobject();
			$this->questionobjects[$orderno]->pullfromdb($orderno, $questionid);
			$this->questionobjects[$orderno]->grade = $tempgradeperquestion[$orderno]; 
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
			
			// header("Location: testpage_edit.php");
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
			$db = new PDO(DB_QUESTIONS, DB_USERNAME, DB_PASSWORD);
			
			foreach ($this->questionobjects as $orderno => $questionobject)
			{
				$qry = $db->prepare("INSERT INTO questions (question, type) VALUES (:question,:type)");
				$qry->execute(array(
					':question' => $questionobject->question,
					':type' => $questionobject->type));
				
				// save ids to array for later use...
				$this->questionids[$orderno] = $db->lastInsertId();
			}
			
			/**
			 * Save answers from object to table ANSWERS
			 */
			$db = new PDO(DB_QUESTIONS, DB_USERNAME, DB_PASSWORD);
			
			foreach ($this->questionobjects as $orderno => $questionobject)
			{
				$questionid = $this->questionids[$orderno];
				foreach ($questionobject->answers as $answer)
				{
					$qry = $db->prepare("INSERT INTO answers (questionid, answer) VALUES (:questionid,:answer)");
					$qry->execute(array(
						':questionid' => $questionid,
						':answer' => $answer));
				}
			}
			
			/**
			 * Save test to table TESTS
			 */
					
			$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
			
			$qry2 = $db->prepare("INSERT INTO tests (testname, userid_owner) VALUES (:testname,:userid_owner)");
			$qry2->execute(array(
				':testname' => $this->testname,
				':userid_owner' => $_SESSION['userid']));
			
			// save testid for later use
			$testid = $db->lastInsertId();
			
			/**
			 * Test name and owner are saved.
			 * Now save which questionids belong to testid in table TEST_ITEMS.
			 */
			//
			$qry3 = $db->prepare("INSERT INTO test_items (questionid, testid, orderno) VALUES (:questionid,:testid,:orderno)");
			foreach ($this->questionids as $orderno => $questionid)
			{
				$qry3->execute(array(
					':questionid' => $questionid,
					':testid' => $testid,
					':orderno' => $orderno));
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
			$db = new PDO(DB_QUESTIONS, DB_USERNAME, DB_PASSWORD);
			
			foreach ($this->questionobjects as $orderno => $questionobject)
			{
				// $qry = $db->prepare("UPDATE questions SET question=:question,type=:type WHERE questionid=:questionid");
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
			$db = new PDO(DB_QUESTIONS, DB_USERNAME, DB_PASSWORD);
			
			$n = 0;
			foreach ($this->questionobjects as $orderno => $questionobject)
			{
				$questionid = $this->questionids[$n];
				foreach ($questionobject->answers as $answer)
				{
					$qry = $db->prepare("INSERT INTO answers (questionid, answer) VALUES (:questionid,:answer)");
					$qry->execute(array(
						':questionid' => $questionid,
						':answer' => $answer));
				}
				
				$n ++;
			}
			
			/**
			 * Save test to table TESTS
			 */
			
			$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
			
			$qry2 = $db->prepare("INSERT INTO tests (testname, userid_owner) VALUES (:testname,:userid_owner)");
			$qry2->execute(array(
				':testname' => $this->testname,
				':userid_owner' => $_SESSION['userid']));
			
			// save testid for later use
			$testid = $db->lastInsertId();
			
			/**
			 * Test name and owner are saved.
			 * Now save which questionids belong to testid in table TEST_ITEMS.
			 */
			//
			$qry3 = $db->prepare("INSERT INTO test_items (questionId, testid, orderno) VALUES (:questionid,:testid,:orderno)");
			foreach ($this->questionids as $orderno => $questionid)
			{
				$qry3->execute(array(
					':questionid' => $questionid,
					':testid' => $testid,
					':orderno' => $orderno));
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

<form action=<?php echo htmlspecialchars('testpage_edit.php');?>
	method="post">
	<!-- 	First button needs to have the default value. When enter is pressed this value for itemtoedit is used. -->
	<button type=hidden type="submit" name="itemtoedit"
		value=<?php if ($itemtoedit == count($this->questionobjects) + 1){echo count($this->questionobjects) + 2; } else {echo count($this->questionobjects) + 1; }; ?>></button>
		
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
		echo "<form action=" . htmlspecialchars('testpage_check.php') . " method='post'>";
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
		
		$this->testid = 0;
		$db = new PDO(DB_QUESTIONS, DB_USERNAME, DB_PASSWORD);
		
		$type = "'" . implode("','", $data["type"]) . "'";
		$number = $data["number"];
		$sql = "SELECT * FROM questions WHERE type IN (" . $type . ") ORDER BY RAND() LIMIT $number";
		$questionsquery = $db->query($sql);
		
		foreach ($questionsquery as $orderno => $questionrow)
		{
			$orderno ++; // now starts at 1
			$this->questionids[$orderno] = $questionrow['questionid'];
			$this->questionobjects[$orderno] = new questionobject();
			$this->questionobjects[$orderno]->pullfromdb($orderno, $questionrow['questionid']);
			$this->questionobjects[$orderno]->grade = 1;
		}
	}

/**
 * Returns array grades_logged
 */
	function checkanswers($useranswers)
	{
		$grades_logged = array();
		$sumgrades = 0;
		foreach ($this->questionids as $orderno => $questionid)
		{
			$answerkey = array_search($useranswers[$questionid], $this->questionobjects[$orderno]->answers);
			if (is_int($answerkey))
			{
				$grades_logged[$questionid] = $this->questionobjects[$orderno]->gradepercentages[$answerkey] / 100 * $this->questionobjects[$orderno]->grade;
			}
			else
			{
				$grades_logged[$questionid] = 0;
			};
			$sumgrades += $grades_logged[$questionid];
		}
		$grades_logged['sumgrades'] = $sumgrades;
		
		return $grades_logged;
	}	

/** 
 * Saves user answers, grade and test data to table TESTS 
 */
	function saveresultstodb($useranswers, $grades_logged)
	{
		$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
			
		$qry = $db->prepare("INSERT INTO test_attempts (testid, userid, sumgrades) VALUES (:testid, :userid, :sumgrades)");
		$qry->execute(array(
			':testid' => $this->testid,
			':userid' => $_SESSION['userid'],
			':sumgrades' => $grades_logged['sumgrades']));
		$resultid = $db->lastInsertId();

		foreach ($this->questionids as $orderno => $questionid)
		{
			
			$qry = $db->prepare("INSERT INTO test_responses (useranswer, gradepercentage_logged, questionid, question_logged, answer_logged, grade_logged) VALUES (:useranswer, :gradepercentage_logged, :questionid, :question_logged, :answer_logged, :grade_logged)");
			$qry->execute(array(
				':useranswer' => $useranswers[$questionid], 
				':gradepercentage_logged' => $grades_logged[$questionid], 
				':questionid' => $questionid, 
				':question_logged' => $this->questionobjects[$orderno]->question, 
				':answer_logged' => implode("','", $this->questionobjects[$orderno]->answers), 
				':grade_logged' => $this->questionobjects[$orderno]->grade));		
			
			$useranswerid = $db->lastInsertId();
			
					
		};
	}	

/** 
 * Echo question, answer, useranswer, grades and sumgrades
 */
	function showresults($useranswers, $grades_logged)
	{
	
		foreach ($this->questionids as $orderno => $questionid)
		{
	
			if ($grades_logged[$questionid] == $this->questionobjects[$orderno]->grade)
			{
				$colour = "lightgreen";
			}
			elseif ($grade_logged[$questionid] == 0)
			{
				$colour = "lightcoral";
			}
			else 
			{
				$colour = "yellow";
			};
			
			echo "<p style='background-color:" . $colour . "'>";
			echo "<span style='font-weight:bold; max-width:200px;'> ".$orderno.". ".$this->questionobjects[$orderno]->question."</span><span style='display: block; float:right'> Score: " . $grades_logged[$questionid] . "</span><br>";
			echo "<span>>" . $useranswers[$questionid] . "</span><span style='display: block; float:right'> Answer: "; $n = 1; foreach ($this->questionobjects[$orderno]->answers as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;};echo "</span>";
			echo "</p>";
		};
		echo "<p style='font-weight:bold'> Totalscore: " . $grades_logged['sumgrades'] . "</p><br><br>";
	}

	
	
};
?>