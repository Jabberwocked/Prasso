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
		echo "<form><p style='font-weight:bold'>" . $this->questionno . " " . $this->question ;
		echo " <span style='font-weight:normal'> (" . $this->typeshort ;
		echo ") - <button style='width:2em; height:2em; margin:0 0 0 0; padding:0 0 0 0; border: 0 0 0 0;'>e<p style='font-style:italic'>d</p></button></span></p>";
		
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
		echo "</form><br><br>";
	}
}


?>