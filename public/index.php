<?php
include_once ("config.php");													 // Shouldn't this be class/config.php? [Teun]

// Start the session
session_start();

// When the session has been started check if it is the same as stored before.
if (isset($_SESSION['HTTP_USER_AGENT']))
{
	if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
	{
		// Someone is attempting hijacking of the user agent.
		session_destroy();
    	header('Location: ./login.php');	// Shouldn't this be login/login.php? [Teun]
    	exit();   
	}
	else
	{
		if( !(isset( $_POST['login'] ) ) )
		{
		header('Location: ./login.php');	// Shouldn't this be login/login.php? [Teun]
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
	header('Location: ./login.php');	// Shouldn't this be login/login.php? [Teun]
    exit();
}
?>
