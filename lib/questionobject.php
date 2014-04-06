<?php 

	
/**
 * Class questionobject
 */


class questionobject {
	public $orderno;
	public $itemid;
	public $questionid;
	public $question;
	public $type;
	public $typeshort;
	public $maxscore;
	public $answers; //array with answerobjects, containing answerid, answer, scorepercentage
	

/**
 * To make a new questionobject with orderno, question, type, answers
 * based on array-input (e.g. form)
 */
	
	function __construct( $data = array() )
	{
		if (isset($data['orderno'])) $this->orderno = $data['orderno'];
		if (isset($data['question'])) $this->question = $data['question'];
		if (isset($data['type'])) $this->type = $data['type'];
		if (isset($data['maxscore'])) $this->maxscore = $data['maxscore'];
		if (isset($data['answers'])) 
		{
			foreach ($data['answers'] as $key => $answer)
			{
				$this->answers[$key]->answer = $answer;
			}
		}
		if (isset($data['scorepercentages'])) 
		{
			foreach ($data['scorepercentages'] as $key => $scorepercentage)
			{
				$this->answers[$key]->scorepercentage = $scorepercentage;
			}
		}
		
		if ($this->type == "shortanswer")
		{
			$this->typeshort = "SA";
		}
		if ($this->type == "multichoice")
		{
			$this->typeshort = "MC";
		}
		
	}

/**
 * Update based on array-input (e.g. form)
 */
	
	function update( $data = array() )
	{
		if (isset($data['orderno'])) $this->orderno = $data['orderno'];
		if (isset($data['question']) and $data['question']!=$this->question)
		{
			$this->question = $data['question'];
			unset($this->questionid);
		}
		if (isset($data['type']) and $data['type']!=$this->type) 
		{
			$this->type = $data['type'];
			unset($this->questionid);
		}
		if (isset($data['maxscore'])) $this->maxscore = $data['maxscore'];
		if (isset($data['answers'])) 
		{
			foreach ($data['answers'] as $key => $answer)
			{
				$this->answers[$key]->answer = $answer;
			}
		}
		if (isset($data['scorepercentages'])) 
		{
			foreach ($data['scorepercentages'] as $key => $scorepercentage)
			{
				$this->answers[$key]->scorepercentage = $scorepercentage;
			}
		}
	
		if ($this->type == "shortanswer")
		{
			$this->typeshort = "SA";
		}
		if ($this->type == "multichoice")
		{
			$this->typeshort = "MC";
		}
	
	}
	
/**
 * To make a new questionobject with questionno, question, type, answers
 * based on questionid and pulled from db
 * orderno given manually
 */
	
	function pullfromdb($orderno, $questionid)
	{
		$db = new PDO(DB_QUESTIONS, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM questions WHERE questionid=".$questionid;
		$resultquestions = $db->query($sql);
		
	//	itemid nog ergens vandaan halen
	//	$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
	//	$sql = "SELECT * FROM test_answers WHERE itemid=".$itemid;
		
		$db = new PDO(DB_QUESTIONS, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM answers WHERE questionid=".$questionid;
		$resultanswers = $db->query($sql);
		
		foreach ($resultanswers as $key => $tempanswersobject)
		{
			$tempanswers[$key]->answerid = $tempanswersobject['answerid'];
			$tempanswers[$key]->answer = $tempanswersobject['answer'];
			$tempanswers[$key]->scorepercentage = $tempanswersobject['scorepercentage'];
		}
		
		
		
		foreach ($resultquestions as $tempquestionobject)
		{
			$this->orderno = $orderno;
			$this->questionid = $questionid;
			$this->question = $tempquestionobject['question'];
			$this->type = $tempquestionobject['type'];
// 			$this->$maxscore = ""; // Set in class test
			$this->answers = $tempanswers;
		}
		
		
		if ($this->type == "shortanswer")
		{
			$this->typeshort = "SA";
		}
		if ($this->type == "multichoice")
		{
			$this->typeshort = "MC";
		}
	}
	
	
	
/**
 * Show a questionobject as a clickable button.
 */
		
	function show()
	{
		?>

		<button class='textlayout' type="submit" name="itemtoedit" value="<?php echo $this->orderno ?>" >
			<p>
			<span style='font-weight:bold'><?php echo $this->orderno . ". " . $this->question ; ?></span>
			<span style='font-weight:normal'>(<?php echo $this->typeshort; ?>)</span><br>
			<span><?php $n = 1; foreach($this->answers as $answerobject){if ($n > 1){echo ", ";}$n ++;echo $answerobject->answer;}?></span>
			</p>
		</button><br>
		
		<?php 
	}
	
	

	
	
}


?>