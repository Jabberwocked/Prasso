<?php
include_once ("../config/config.php");

// Start the session
session_start();

// When the session has been started check if it is the same as stored before.
if (isset($_SESSION['HTTP_USER_AGENT']))
{
	if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
	{
		// Someone is attempting hijacking of the user agent.
		session_destroy();
    	header('Location: ./main.php');
    	exit();   
	}
	else
	{
		// User is already logged in. Continue session.
	}
}
else
// New session.
{
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

	header('Location: ./main.php');
    exit();
}
?>
