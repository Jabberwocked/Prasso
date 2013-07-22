<?php
include_once ("config.php");
?>


<?php

session_start();

if (isset($_SESSION['HTTP_USER_AGENT']))
{
	if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
	{ ?>
		
		<!DOCTYPE html>
		<html>
		<head>
		<title>Welcome to Prasso. Please log in.</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		</head>
		
		<body>
		
			<header id="head">
				<p>Prasso: User Login</p>
				<p>
					<a href="register.php"><span id="register">Register</span></a>
				</p>
			</header>
		
			<div id="main-wrapper">
				<div id="login-wrapper">
				</div>
			</div>
		</body>
		</html>

		<?php 
	}
}
else
{
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	?>
			
	<!DOCTYPE html>
	<html>
	<head>
	<title>Welcome to Prasso.</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	<body>
	
		<header id="head">
			<p>Prasso</p>
			<p>
				<a href="register.php"><span id="register">Register</span></a>
			</p>
		</header>
	
		<div id="main-wrapper">
			<div id="login-wrapper">
			<p> welcome </p>
			</div>
		</div>
	</body>
	</html>

	<?php 
}

?>