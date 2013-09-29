<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<?php


/* $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM Question WHERE QuestionId = 1";

$stmt = $con->prepare($sql);

echo $stmt;
echo 'hi';

$con = null;

echo "hello hello"
 */

echo 'hello1';

$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

$sql = "SELECT * FROM Question";
$results = $db->query($sql);

foreach($results as $row)
{
	echo $row['Question'].'<br>';
}

echo 'hello2';

?>




<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>