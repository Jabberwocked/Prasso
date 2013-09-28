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
    	header('Location: ./loginpage.php');
    	exit();   
	}
	else
	{
		if( !(isset( $_POST['login'] ) ) )
		{
		header('Location: ./loginpage.php');
		}
		else
		{
			echo ("logged in");
		}
	}
}
else
{
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	
	// This is a new session. Check if logged in.
	header('Location: ./main.php');
    exit();
}
?>
