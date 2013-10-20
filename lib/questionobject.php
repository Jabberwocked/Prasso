<?php 

	
/**
 * Class questionobject
 */


class questionobject {
	public $orderno;
	public $questionid;
	public $question;
	public $type;
	public $typeshort;
	public $answers;

	function __construct( $data = array() ) //input an array, usually from a post
	{
		if (isset($data['orderno'])) $this->orderno = $data['orderno'];
		if (isset($data['question'])) $this->question = $data['question'];
		if (isset($data['type'])) $this->type = $data['type'];
		if (isset($data['answers'])) $this->answers = $data['answers'];
		
		if ($this->type == "shortanswer")
		{
			$this->typeshort = "SA";
		}
		if ($this->type == "multichoice")
		{
			$this->typeshort = "MC";
		}
		
	}

	
	
	
	function pullfromdb($orderno, $questionid)
	{
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
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
			$this->orderno = $orderno;
			$this->questionid = $questionid;
			$this->question = $tempquestionobject['Question'];
			$this->type = $tempquestionobject['Type'];
			$this->answers = $tempanswersarray;
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
	
	
	
	
	
	
	
	function show()
	{
		?>
		<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
			<button type="submit" name="itemtoedit" value="<?php echo $this->orderno ?>" style='
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
					<p>
					<span style='font-weight:bold'><?php echo $this->orderno . ". " . $this->question ; ?></span>
					<span style='font-weight:normal'>(<?php echo $this->typeshort; ?>)</span><br>
					<span><?php echo $n = 1; foreach($this->answers as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;}?></span>
			</button>
		</form>
		<br>
		<?php 
	}
}


?>