<?php include_once (LIBRARY_PATH . "/user.php"); ?>
<?php if( !(isset( $_POST['login'] ) ) ) { ?>



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
						value="Register" onclick="location.href='registerpage.php'" /></li>

				</ul>
			</form>

		</div>
	</div>


<?php 
}
else
{
	$usr = new User();
	$usr->storeFormValues($_POST);

	if ($usr->userLogin())
	{
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		$_SESSION['username'] = $usr['username'];
		echo $usr['username'];
	}
	else
	{
		echo "Incorrect Username/Password";
	}
}
?>
