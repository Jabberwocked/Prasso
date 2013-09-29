<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<?php

echo 'test1';

$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$sql = "SELECT * FROM Questions";
$results = $db->query($sql);

$number = 1;
$n = 0;
while ($n < $number)
{
	foreach ($results as $row)
	{
		echo $row['Question'] . '<br>';
		$n++;
		echo $n;
	}
}

?>




<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>