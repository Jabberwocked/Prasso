<?php 

	
/**
 * Class question
 */


class question {
	public $questionno;
	public $question;
	public $type;
	public $answer1;

	function __construct($questionno, $question, $type, $answers)
	{
		$this->questionno = $questionno;
		$this->question = $question;
		$this->type = $type;
		$this->answers = $answers;
		
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
		<form><button style='
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
			-webkit-appearance: none;'>
		<p style='font-weight:bold'>
		<?php echo $this->questionno . " " . $this->question ; ?>
		<span style='font-weight:normal'> (
		<?php echo $this->typeshort ?>
		)</span></p>
		<?php ;
		echo "<p>Answers: " ;
		$n = 1;
		foreach($this->answers as $answer) 
		{
    	if ($n > 1)
    	{
    		echo ", ";
    	}
    	$n ++;
		echo $answer;
		}
		?>
		</button></form><br>
		<?php 
	}
}


?>