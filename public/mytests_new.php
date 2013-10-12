<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_mytests_new.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">
		
	<form action=<?php echo htmlspecialchars('mytests_new.php');?> method="post">
		Question<br> 
		<input type="text" name="question"><br>
		<input type="radio" style="display:inline; width:20px;" name="type" value="shortanswer" checked>Short Answer<br>
		<input type="radio" style="display:inline; width:20px;" name="type" value="multichoice" >Multiple Choice<br>
		Answers<br> 
		<input type="text" name="answers" id="answers">
		<input type="button" id="addOption" value="Add" />
		<br> 
		<input type="submit" value="Add question">
	</form>
	<br>
	<br>





<?php 
include_once (TEMPLATES_PATH . "/footer.php");
?>