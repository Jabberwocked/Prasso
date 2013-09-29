<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<?php



$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$sql = "SELECT * FROM Question";
$results = $db->query($sql);

foreach($results as $row)
{
	echo $row['Question'].'<br>';
}



?>




<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>