<?php

/**
 * Class test
 */

class test 
{
	function testing()
	{
		echo "lalalala";
	}
	
	function edit($testid)
	{
		/** 
		 * Pull test name to session
		 */
		
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM Tests WHERE TestId=".$testid;
		$result = $db->query($sql);
		foreach ($result as $test)
		{
			$_SESSION['testname'] = $test['TestName'];
		}
		
		/**
		 * Pull questionids to session
		 */
		
		$_SESSION['questionobjects'] = array();
		
		$sql = "SELECT * FROM Question_Test WHERE TestId=".$testid." ORDER BY OrderNo";
		$result = $db->query($sql);
		
		foreach ($result as $relation)
		{
			$questionids[] = $relation['QuestionId'];
		}
		
		/**
		 * Pull questions and answers to session and save as questionobjects
		 */
		
		$questionno = 1;
		foreach ($questionids as $questionid)
		{
			$sql = "SELECT * FROM Questions WHERE QuestionId=".$questionid;
			$resultquestions = $db->query($sql);
		
			$sql = "SELECT * FROM Answers WHERE QuestionId=".$questionid;
			$resultanswers = $db->query($sql);
		
			$answerarray = array();
			foreach ($resultanswers as $tempanswersobject)
			{
				$tempanswersarray[] = $tempanswersobject['Answer'];
			}
		
		
			foreach ($resultquestions as $tempquestionobject)
			{
				$_SESSION['questionobjects'][] = new questionobject(array(	'questionno' => $questionno,
					'question' => $tempquestionobject['Question'],
					'type' => $tempquestionobject['Type'],
					'answers' => $tempanswersarray));
			}
			$questionno ++;
		
		}	
	}
	
	
	
	
	
}

?>