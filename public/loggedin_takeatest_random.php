<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<?php

$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM Question WHERE QuestionId = 1";

$stmt = $con->prepare($sql);
$stmt->bindValue("username", $this->username, PDO::PARAM_STR);

echo $stmt;
echo 'hi';

$con = null;




?>




<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>