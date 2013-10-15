<?php 

	
/**
 * Class question
 */


class question {
	public $questionno;
	public $question;
	public $type;
	public $answer1;

	function __construct($questionno, $question, $type, $answer1)
	{
		$this->questionno = $questionno;
		$this->question = $question;
		$this->type = $type;
		$this->answer1 = $answer1;
	}

	function show()
	{
		echo "<p style='font-weight:bold'>" . $this->questionno . " " . $this->question . " (" . $this->type . ") </p>";
		echo "<p>Answers: " . $this->answer1 . "</p>";
		echo "<br><br>";
	}
}


?>