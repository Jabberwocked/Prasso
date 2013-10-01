<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>


<div style="margin-left: auto; margin-right: auto; width: 500px">

<?php 
$answers = $_POST;

foreach($answers as $answer)
{
	echo $answer . "<br>";
}
	
?>
	
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>