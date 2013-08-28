<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<?php
// Create connection
$con = mysqli_connect("jabberwocked.diskstation.me", "root", "miljoen", "Question");

// Check connection
if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo 'hi';
?>




<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>