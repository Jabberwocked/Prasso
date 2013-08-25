
<?php if( !(isset( $_POST['login'] ) ) ) { ?>


<?php	
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

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

<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>


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