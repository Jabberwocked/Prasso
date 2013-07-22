<?php
include_once ("config.php");
?>


<?php

session_start();

if (isset($_SESSION['HTTP_USER_AGENT']))
{
	if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
	{
		exit;
	}
}
else
{
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
}

?>