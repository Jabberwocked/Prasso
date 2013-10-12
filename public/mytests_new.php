<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
// include_once (MENU_PATH . "/menu_mytests_new.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">
		
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
		echo "<p style='font-weight:bold'>Question " . $this->questionno . "</p>";
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
};


if ($_POST['action'] == "deleteall")
{
	$_SESSION['questions'] = array();
	$_SESSION['questionno'] = 1;
}
elseif ($_POST['action'] == "addquestion")
{
	$_SESSION['questions'][] = new question($_SESSION['questionno'], $_POST['question'], $_POST['type'], $_POST['answer1']);
	$_SESSION['questionno'] ++;
}
elseif ($_POST['action'] == "save")
{
	echo "saving?";
	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
		
	
	foreach ($_SESSION['questions'] as $question)
	{
		echo "lalal";
		$question = $question['question'];
		echo $question;
		$type = $question['type'];
		$sql="INSERT INTO Questions (Question, Type) VALUES ('$question','$type')";
		if (!mysqli_query($db,$sql))
		{
			die('Error: ' . mysqli_error($db));
		}
		echo "1 record added";
	}
		
	
	mysqli_close($db);
	echo "<p color=green>Test is saved.</p>";
	
};



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
		<button type="submit" name="action" value="addquestion">Add Question</button>
		<button type="submit" name="action" value="save" >Save</button>
		<button type="submit" name="action" value="deleteall" >Delete All</button><br>
	</form>
	<br>
	<br>




</div>

<?php 
include_once (TEMPLATES_PATH . "/footer.php");
?>