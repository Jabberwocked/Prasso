<?php
/**
 * Class test
 */

class test 
{
	public $testid;
	public $testname;
	public $questionids = array();
	public $questionobjects = array();
	
	function __construct()
	{

	}
	
	/** 
	 * Pull test details to object (which will usually be saved as $_SESSION['test'])
	 */
	
	function pullfromdb()
	{
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
				$this->questionobjects[$questionno] = new questionobject(array(	'question' => $tempquestionobject['Question'],
																		'type' => $tempquestionobject['Type'],
																		'answers' => $tempanswersarray));
			}
		
		}	
	}
	
	
	/** 
	 * Delete test details from object
	 */
	
	function reset()
	{
		unset($this->testname);
		$questionids = array();
		$this->questionobjects = array();
			
		header("Location: mytests_edit.php");
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
		
	}
}

?>