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
	}

	function show()
	{
		echo "<p style='font-weight:bold'>" . $this->questionno . " " . $this->question . " (" . $this->type . ") </p>";
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
		echo "<br><br>";
	}
}


?>