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
	public $grade;
	public $answers;
	public $gradepercentages;

/**
 * To make a new questionobject with orderno, question, type, answers
 * based on array-input (e.g. form)
 */
	
	function __construct( $data = array() )
	{
		if (isset($data['orderno'])) $this->orderno = $data['orderno'];
		if (isset($data['question'])) $this->question = $data['question'];
		if (isset($data['type'])) $this->type = $data['type'];
		if (isset($data['grade'])) $this->grade = $data['grade'];
		if (isset($data['answers'])) $this->answers = $data['answers'];
		if (isset($data['gradepercentages'])) $this->gradepercentages = $data['gradepercentages'];
		
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
		
		$sql = "SELECT * FROM answers WHERE questionid=".$questionid;
		$resultanswers = $db->query($sql);
		
		foreach ($resultanswers as $tempanswersobject)
		{
			$tempanswersarray[] = $tempanswersobject['answer'];
			$tempgradepercentagesarray[] = $tempanswersobject['gradepercentage'];
		}
		
		
		
		foreach ($resultquestions as $tempquestionobject)
		{
			$this->orderno = $orderno;
			$this->questionid = $questionid;
			$this->question = $tempquestionobject['question'];
			$this->type = $tempquestionobject['type'];
// 			$this->$grade = ""; // Set in class test
			$this->answers = $tempanswersarray;
			$this->gradepercentages = $tempgradepercentagesarray;
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
			<span><?php $n = 1; foreach($this->answers as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;}?></span>
			</p>
		</button><br>
		
		<?php 
	}
	
	

	
	
}


?>