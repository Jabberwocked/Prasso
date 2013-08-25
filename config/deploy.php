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

// The commands
$commands = array(
	'echo $PWD',
	'whoami',
	'echo $PATH',
	'git pull 2>&1',
	'git status');

// Run the commands for output
$output = '';
foreach ($commands as $command)
{
	// Run it
	$tmp = shell_exec($command);
	// Output
	$output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
	$output .= htmlentities(trim($tmp)) . "\n";
}


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>Prasso deployement scriptt</title>
</head>
<body
	style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
	<pre>
 .  ____  .    ____________________________
 |/      \|   |                            |
[| <span style="color: #FF0000;">&hearts;    &hearts;</span> |]  | Prass Git Deployment Script v0.1 |
 |___==___|  /              &copy; oodavid 2012 |
              |____________________________|
 
<?php echo $output; ?>
</pre>
</body>
</html>
