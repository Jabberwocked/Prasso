<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_tests.php");
?>



<div style="width: 500px; margin: 0px auto; border: 1px dotted; padding: 20px 170px 100px 170px">

	<form action=<?php echo htmlspecialchars('testpage.php');?> method="get">
		Filter by type<br> 
		<input type="checkbox" style="display:inline; width:20px;" name="selectall" value="yes" class="selectall" <? if($_GET['selectall'] == 'yes'){ echo 'checked';}?>>All<br>
		<input type="checkbox" style="display:inline; width:20px;" name="type[]" value="shortanswer" <? if(in_array("shortanswer", $_GET['type'])){ echo 'checked';}?>>Short Answer<br>
		<input type="checkbox" style="display:inline; width:20px;" name="type[]" value="multichoice" <? if(in_array("multichoice", $_GET['type'])){ echo 'checked';}?>>Multiple Choice<br>
		<br>
		How many questions would you like to answer?<br> 
		<input type="number" name="number" value="<?php if($_GET['number'] > 0) { echo $_GET['number']; } else { echo 10; } ?>">

		<br> 
		<button type="submit" name="generaterandom" value="yes">Generate Test</button>
	</form>
	<br>
	<br>
	
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>