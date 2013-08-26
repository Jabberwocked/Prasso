<?php
/**
 * GIT DEPLOYMENT SCRIPT
 *
 * Used for automatically deploying website via github.
 */

define('SECRET_ACCESS_TOKEN', 'Changedit');

if (! isset($_GET['sat']) || $_GET['sat'] !== SECRET_ACCESS_TOKEN)
{
	die('<h2>ACCESS DENIED!</h2>');
}

header('Location: http://85.150.134.32/myphpadmin/');
 
?>
