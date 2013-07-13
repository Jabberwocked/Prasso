<?php
<<<<<<< HEAD
	/**
	 * GIT DEPLOYMENT SCRIPT
	 *
	 * Used for automatically deploying websites via github or bitbucket, more deets here:
	 *
	 *		https://gist.github.com/1809044
	 */
 
	// The commands
	$commands = array(
		'echo $PWD',
		'whoami',
		'git pull',
		'git status',
		'git submodule sync',
		'git submodule update',
		'git submodule status',
	);
 
	// Run the commands for output
	$output = '';
	foreach($commands AS $command){
		// Run it
		$tmp = shell_exec($command);
		// Output
		$output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
		$output .= htmlentities(trim($tmp)) . "\n";
	}
 
	// Make it pretty for manual user access (and why not?)
=======
/**
 * Simple PHP GIT deploy script
 *
 * Automatically deploy the code using php and git.
 *
 * @version 1.0.8
 * @link    https://github.com/markomarkovic/simple-php-git-deploy/
 */

// =========================================[ Configuration start ]===

/**
 * Protect the script from unauthorized access by using a secret string.
 * If it's not present in the access URL as a GET variable named `sat`
 * e.g. deploy.php?sat=Bett...s the script is going to fail.
 *
 * @var string
 */
define('SECRET_ACCESS_TOKEN', 'onceinamillion');

/**
 * The address of the remote GIT repository that contains the code we're
 * updating.
 *
 * @var string
 */
define('REMOTE_REPOSITORY', 'https://github.com/Jabberwocked/Miljoenenidee.git');

/**
 * Which branch are we going to use for deployment.
 *
 * @var string
 */
define('BRANCH', 'master');

/**
 * This is where the code resides on the local machine.
 * Don't forget the trailing slash!
 *
 * @var string Full path including the trailing slash
 */
define('TARGET_DIR', '/volume1/web/Miljoenenidee/');

/**
 * Weather to delete the files that are not in the repository but are on the
 * local machine.
 *
 * !!! WARNING !!! This can lead to a serious loss of data if you're not
 * careful. All files that are not in the repository are going to be deleted,
 * except the ones defined in EXCLUDE section! BE CAREFUL!
 *
 * @var boolean
 */
define('DELETE_FILES', false);

/**
 * The directories and files that are to be excluded when updating the code.
 * Normally, these are the directories containing files that are not part of
 * code base, for example user uploads or server-specific configuration files.
 * Use rsync exclude pattern syntax for each element.
 *
 * @var serialized array of strings
 */
define('EXCLUDE', serialize(array(
	'.git',
	'webroot/uploads',
	'app/config/database.php',
)));

/**
 * Temporary directory we'll use to stage the code before the update.
 *
 * @var string Full path including the trailing slash
 */
define('TMP_DIR', '/tmp/spgd-'.md5(REMOTE_REPOSITORY).'-'.time().'/');

/**
 * Output the version of the deployed code.
 *
 * @var string Full path to the file name
 */
define('VERSION_FILE', TMP_DIR.'DEPLOYED_VERSION.txt');

/**
 * Time limit for each command.
 *
 * @var int Time in seconds
 */
define('TIME_LIMIT', 30);

/**
 * OPTIONAL
 * Backup the TARGET_DIR into BACKUP_DIR before deployment
 *
 * @var string Full backup directory path e.g. '/tmp/'
 */
define('BACKUP_DIR', false);

// ===========================================[ Configuration end ]===

>>>>>>> bca99ef97aefb05e986024a0f804775999f72628
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
 .  ____  .    ____________________________
 |/      \|   |                            |
[| <span style="color: #FF0000;">&hearts;    &hearts;</span> |]  | Git Deployment Script v0.1 |
 |___==___|  /              &copy; oodavid 2012 |
              |____________________________|
 
<?php echo $output; ?>
</pre>
</body>
</html>