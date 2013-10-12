<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_mytests_new.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">
		
<?php 


echo $_POST['action'];


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
		echo "<p>Question " . $this->questionno . "</p>";
		echo "<p>Question: " . $this->question . "</p>";
		echo "<p>Type: " . $this->type . "</p>";
		echo "<p>Answer1: " . $this->answer1 . "</p>";
		echo "<br><br>";
	}
}



/**
 * Process form
 */



if ($_SESSION['questionno'] == false)
{
	$_SESSION['questionno'] = 1;
}

if ($_POST('action') == "Delete_All")
{
	$_SESSION['questions'] = array();
	$_SESSION['questionno'] = 1;
}

// if ($_POST('action') == "Add Question")
// {
	$_SESSION['questions'][] = new question($_SESSION['questionno'], $_POST['question'], $_POST['type'], $_POST['answer1']);
	$_SESSION['questionno'] ++;
// }



/** 
 * Print questions
 */


foreach ($_SESSION['questions'] as $question)
{
	$question->show();
}




/** 
 * Form
 */

?>		
	<form action=<?php echo htmlspecialchars('mytests_new.php');?> method="post">
		Question<br> 
		<input type="text" name="question"><br>
		<input type="radio" style="display:inline; width:20px;" name="type" value="shortanswer" checked>Short Answer<br>
		<input type="radio" style="display:inline; width:20px;" name="type" value="multichoice" >Multiple Choice<br>
		Answers<br> 
		<input type="text" name="answer1" class="answers"><br>
		<br>
		<input type="button" id="addOption" value="Add" /><br>
		<br>
		<br> 
		<button type="submit" name="action" value="Add Question">
		<button type="submit" name="action" value="Save" /><br>
		<button type="submit" name="action" value="Delete_All" /><br>
	</form>
	<br>
	<br>





<?php 
include_once (TEMPLATES_PATH . "/footer.php");
?>