<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<?php

$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$sql = "SELECT * FROM Questions";
$results = $db->query($sql);

$number = 3;
$n = 0;
while ($n < $number)
{
	foreach ($results as $row)
	{
		echo $row['Question'] . '<br>';
		$n++;
	}
}

?>




<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>