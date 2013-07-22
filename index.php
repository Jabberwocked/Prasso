<?php
include_once ("config.php");

// Start the session
session_start();

// When the session has been started check if it is the same as stored before.
if (isset($_SESSION['HTTP_USER_AGENT']))
{
	if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
	{
		// Someone is attempting hijacking of the user agent.
		quit;
	}
	else
	{
		// Ckeck if the user is logged in.
		if( !(isset( $_POST['login'] ) ) ) { ?>

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
					<form method="post" action="">
						<ul>
							<li><label for="usn">Username : </label> <input type="text"
								maxlength="30" required autofocus name="username" /></li>
		
							<li><label for="passwd">Password : </label> <input type="password"
								maxlength="30" required name="password" /></li>
							<li class="buttons"><input type="submit" name="login"
								value="Log me in" /> <input type="button" name="register"
								value="Register" onclick="location.href='register.php'" /></li>
		
						</ul>
					</form>
		
				</div>
			</div>
		
		</body>
		</html>
		
		<?php
		}
		else
		{
			$usr = new Users();
			$usr->storeFormValues($_POST);
			
			if ($usr->userLogin())
			{
				echo "Welcome";
			}
			else
			{
				echo "Incorrect Username/Password";
			}
		}
		?>
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
			<p>welcome</p>
		</div>
	</body>
	</html>

<?php
}

?>