<?php

// Start the session
session_start();

// When the session has been started check if it is the same as stored before.
if (isset($_SESSION['HTTP_USER_AGENT']))
{
	if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
	{
		// Someone is attempting hijacking of the user agent.
		session_destroy();
    	header('Location: ./index.php');
    	exit();   
	}
	else
	{
		// Continue session. Check if logged in on certain pages.
		if ($_SERVER['REQUEST_URI'] == "/mytests_edit.php")
		{
			if (!isset($_SESSION['username']))
				{
					header("Location:loginpage.php?location=" . urlencode($_SERVER['REQUEST_URI']));
				}
		}	
	}
}
else
// New session.
{
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

	header('Location: ./index.php');
    exit();
}
?>
