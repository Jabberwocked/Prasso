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
			$tempmaxscoreperquestion[$orderno] = $test_item['maxscore']; //see below
			$tempitemids[$orderno] = $test_item['itemid']; //see below
		}
		
		/**
		 * Pull questions and answers to questionobjects in object (session)
		 */
		
		foreach ($this->questionids as $orderno => $questionid)
		{
			$this->questionobjects[$orderno] = new questionobject();
			$this->questionobjects[$orderno]->pullfromdb($orderno, $questionid);
			$this->questionobjects[$orderno]->maxscore = $tempmaxscoreperquestion[$orderno];
			$this->questionobjects[$orderno]->itemid = $tempitemids[$orderno];
		}
	}


	/**
	 * Pull random questions from db and output as test
	 */
	function pullrandomfromdb( $data ) // $data from $_GET
	{
	
	
		/**
		 * Query based on criteria
		 */
	
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
			$this->questionobjects[$orderno]->maxscore = 1;
		}
	}
	


	/**
	 * Output as test
	 */
	function showastest( )
	{
		echo "<form action=" . htmlspecialchars('testpage_check.php') . " method='post'>";
		if (isset($this->testname) and $this->testname!="random")
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
	 * Shows questions for editing: Prints test name and questionobjects as buttons and a form for the item that's being edited
	 */
	function showeditabletest( )
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
					<input type="hidden" name="orderno" value='<?php echo $itemtoedit; ?>'> 
					<input type="text" name="question" 	value='<?php echo $this->questionobjects[$itemtoedit]->question ?>' placeholder="Question <?php echo $itemtoedit ?>" autofocus style="display: inline; width: 70%; font-weight: bold"> 
					<select name="type" style="width: 45px;">
						<option value="shortanswer" <?php if ($this->questionobjects[$itemtoedit]->type == 'shortanswer' OR !isset($this->questionobjects[$itemtoedit])){echo 'selected';} ?>>SA: Short Answer</option>
						<option value="multichoice" <?php if ($this->questionobjects[$itemtoedit]->type == 'multichoice'){echo 'selected';} ?>>MC: Multiple Choice</option>
					</select> 
					<?php $answerno = 1; foreach ($this->questionobjects[$itemtoedit]->answers as $answer){	?>
					<input type="text" name="answers[]" class="answers" value='<?php echo $answer ?>' placeholder="Answer <?php echo $answerno ?>" style="display: inline; width: 60%">
					<?php $answerno ++;} if ($answerno == 1){ ?>
					<input type="text" name="answers[]" class="answers" placeholder="Answer <?php echo $answerno ?>" style="display: inline; width: 60%">
					<?php $answerno ++;}?>
					<script> var answernojs = <?php echo json_encode($answerno); ?>;</script>
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
			 * Show Add Question button
			 */

			unset($_SESSION['itemtoedit']);
			?>
			<br>
			<button type="submit">Add question</button>
			<br> <br>				
			<?php


			
			/**
			 * Buttons: Save test or delete questions
			 */
			
			?>	
			
			<br>
		<div style="position: absolute; bottom: 50px">
			<?php if ($_POST['action2'] == "savetest") { ?>
			<p style='font-weight:bold; color:green'>Test is saved.</p>
			<?php } ?>
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
	 * Save question or test name to object (session)
	 */
	function saveitemtosession( )
	{
		if (isset($_POST['testname']))
		{
			$this->testname = $_POST['testname'];
		}
		else
		{
			// if new then add, else update
			if (!isset($this->questionobjects[$_POST['orderno']]))
			{	
				$this->questionobjects[$_POST['orderno']] = new questionobject($_POST);
			}
			else 
			{
				$this->questionobjects[$_POST['orderno']]->update($_POST);
			}
			// remove empty answer strings
			$temp = $this->questionobjects[$_POST['orderno']]->answers;
			$temp = array_diff($temp, array(""));
			$temp = array_values($temp);
			$this->questionobjects[$_POST['orderno']]->answers = $temp;
		}
	}


	/**
	 * Add questions from SESSION to db questions
	 */
	function savequestionstodbquestions( )
	{
			
		/**
		 * Save questionobjects from object to table QUESTIONS
		 */
		$db = new PDO(DB_QUESTIONS, DB_USERNAME, DB_PASSWORD);
		
		foreach ($this->questionobjects as $orderno => $questionobject)
		{
			if (!isset($questionobject->questionid))
			{
				$qry = $db->prepare("INSERT INTO questions (question, type) VALUES (:question,:type)");
				$qry->execute(array(
					':question' => $questionobject->question,
					':type' => $questionobject->type));
			
				// save ids to array for later use...
				$this->questionids[$orderno] = $db->lastInsertId();
				$questionobject->questionid = $db->lastInsertId();
			}
			else 
			{
				
				// WORKING ON IT. Update formulering nog aanpassen:
				
				$qry = $db->prepare("INSERT INTO questions (question, type) VALUES (:question,:type)");
				$qry->execute(array(
					':question' => $questionobject->question,
					':type' => $questionobject->type));
					
				// save ids to array for later use...
				$this->questionids[$orderno] = $db->lastInsertId();
				$this->questionobjects[$orderno]->questionid = $db->lastInsertId();
			}
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
	}

	/** 
	 * save test properties from SESSION to db tests
	 * UPDATES NOT WORKING YET
	 */
	function savetesttodbtests( )
	{
		
			
		/**
		 * Save or update test name and owner in table TESTS.
		 */
		
		$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
		
		if(!isset($this->testid))
		{
			$qry2 = $db->prepare("INSERT INTO tests (testname, userid_owner) VALUES (:testname,:userid_owner)");
			$qry2->execute(array(
				':testname' => $this->testname,
				':userid_owner' => $_SESSION['userid']));

			$this->testid = $db->lastInsertId(); // saves testid for later use
		}
		else 
		{
			$qry2 = $db->prepare("UPDATE tests SET testname=:testname WHERE testid=:testid");
			$qry2->execute(array(
				':testid' => $this->testid,
				':testname' => $this->testname));
		}	
	

				
			
		/**
		 * Now save or update which questionids belong to testid in table TEST_ITEMS.
		 */
				
	
		foreach ($this->questionids as $orderno => $questionid)
		{

			if(!isset($this->questionobjects[$orderno]->itemid))
			{
				$qry3 = $db->prepare("INSERT INTO test_items (questionid, testid, orderno) VALUES (:questionid,:testid,:orderno)");
				$qry3->execute(array(
					':questionid' => $questionid,
					':testid' => $this->testid,
					':orderno' => $orderno));
			
				$this->questionobjects[$orderno]->itemid = $db->lastInsertId(); //update SESSION with new itemid
			}
			else 
			{
				$qry3 = $db->prepare("UPDATE test_items SET questionid=:questionid, orderno=:orderno WHERE itemid=:itemid");
				$qry3->execute(array(
					':questionid' => $questionid,
					':orderno' => $orderno,
					':itemid' => $this->questionobjects[$orderno]->itemid));
			}
				
		}

		
		/**
		 * End connection
		 */
		mysqli_close($db);	
	
	}



/**
 * Returns array userscores
 */
	function checkanswers($useranswers)
	{
		$userscores = array();
		$sumscores = 0;
		foreach ($this->questionids as $orderno => $questionid)
		{
			$answerkey = array_search($useranswers[$questionid], $this->questionobjects[$orderno]->answers);
			if (is_int($answerkey))
			{
				$userscores[$questionid] = $this->questionobjects[$orderno]->scorepercentages[$answerkey] / 100 * $this->questionobjects[$orderno]->maxscore;
			}
			else
			{
				$userscores[$questionid] = 0;
			};
			$sumscores += $userscores[$questionid];
		}
		$userscores['sumscores'] = $sumscores;
		
		return $userscores;
	}	

/** 
 * Saves user answers, score and test data to table TESTS 
 */
	function saveresultstodb($useranswers, $userscores)
	{
		
		$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);

		$qry = $db->prepare("INSERT INTO test_attempts (testid, userid, sumscores) VALUES (:testid, :userid, :sumscores)");
		$qry->execute(array(
			':testid' => $this->testid,
			':userid' => $_SESSION['userid'],
			':sumscores' => $userscores['sumscores']));
		$attemptid = $db->lastInsertId();

		foreach ($this->questionids as $orderno => $questionid)
		{
			
			$qry = $db->prepare("INSERT INTO test_responses (attemptid, itemid, useranswer, userscore, question_logged, answers_logged, maxscore_logged) VALUES (:attemptid, :itemid, :useranswer, :userscore, :question_logged, :answers_logged, :maxscore_logged)");
			$qry->execute(array(
				':attemptid' => $attemptid,
				':itemid' => $this->questionobjects[$orderno]->itemid,
				':useranswer' => $useranswers[$questionid], 
				':userscore' => $userscores[$questionid],
				':question_logged' => $this->questionobjects[$orderno]->question, 
				':answers_logged' => implode("','", $this->questionobjects[$orderno]->answers), 
				':maxscore_logged' => $this->questionobjects[$orderno]->maxscore));		
			
			$responseid = $db->lastInsertId();
			
					
		};
	}	

/** 
 * Echo question, answer, useranswer, score and sumscores
 */
	function showresults($useranswers, $userscores)
	{
	
		foreach ($this->questionids as $orderno => $questionid)
		{
	
			if ($userscores[$questionid] == $this->questionobjects[$orderno]->maxscore)
			{
				$colour = "lightgreen";
			}
			elseif ($userscores[$questionid] == 0)
			{
				$colour = "lightcoral";
			}
			else 
			{
				$colour = "yellow";
			};
			
			echo "<p style='background-color:" . $colour . "'>";
			echo "<span style='font-weight:bold; max-width:200px;'> ".$orderno.". ".$this->questionobjects[$orderno]->question."</span><span style='display: block; float:right'> Score: " . $userscores[$questionid] . "</span><br>";
			echo "<span>>" . $useranswers[$questionid] . "</span><span style='display: block; float:right'> Answer: "; $n = 1; foreach ($this->questionobjects[$orderno]->answers as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;};echo "</span>";
			echo "</p>";
		};
		echo "<p style='font-weight:bold'> Totalscore: " . $userscores['sumscores'] . "</p>";
		echo "<p style='font-weight:bold'> Percentage: " . $userscores['sumscores'] . "</p>";
		echo "<br><br>";
	}


	/**
	 * Pull logged test details from old attempt to object (which will usually be saved as $_SESSION['test'])
	 */
	function showoldattempt( $attemptid )
	{
		$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM test_responses WHERE attemptid=" . $attemptid . " ORDER BY responseid";
		$dbresponses = $db->query($sql);
	
		$orderno = 0;
		$summaxscore = 0;
		foreach ($dbresponses as $dbresponse)
		{
				
			$orderno ++;
			$useranswer = $dbresponse['useranswer'];
			$userscore = $dbresponse['userscore'];
			$question_logged = $dbresponse['question_logged'];
			$answers_logged = $dbresponse['answers_logged'];
			$maxscore_logged = $dbresponse['maxscore_logged'];
			$summaxscore += $maxscore_logged;
				
			if ($userscore == $maxscore_logged )
			{
				$colour = "lightgreen";
			}
			elseif ($userscore == 0)
			{
				$colour = "lightcoral";
			}
			else
			{
				$colour = "yellow";
			};
	
			echo "<p style='background-color:" . $colour . "'>";
			echo "<span style='font-weight:bold; max-width:200px;'> ".$orderno.". ".$question_logged."</span><span style='display: block; float:right'> Score: " . $userscore . "/" . $maxscore_logged . "</span><br>";
			echo "<span>>" . $useranswer . "</span><span style='display: block; float:right'> Answer: " . $answers_logged . "</span>";
			echo "</p>";
		}
	
		$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM test_attempts WHERE attemptid=" . $attemptid;
		$dbattempts = $db->query($sql);
		foreach ($dbattempts as $dbattempt)
		{
			$sumscores = $dbattempt['sumscores'];
			echo "<p style='font-weight:bold'>Totalscore: " . $sumscores . "/" . $summaxscore . "</p>";
			echo "<p style='font-weight:bold'>Percentage: " . round($sumscores / $summaxscore * 100,0) . " %</p>";
			echo "<br><br>";
		}
			
	}
		
	
	
};
?>