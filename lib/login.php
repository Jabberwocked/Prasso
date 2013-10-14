<?php include_once (LIBRARY_PATH . "/user.php"); ?>
<?php if( !(isset( $_POST['login'] ) ) ) { ?>



	<div id="main-wrapper">
		<div id="login-wrapper">
			<form method="post" action="">
				<label for="usn">Username : </label> 
				<input type="text" maxlength="30" required autofocus name="username" />
				<br>
				<label for="passwd">Password : </label> 
				<input type="password" maxlength="30" required name="password" />
				<br>
				<input type="hidden" name="location" value="<?php if(isset($_GET['location'])) { echo htmlspecialchars($_GET['location']); } ?>"  />;
				<button type="submit" name="login" value="Log me in" style="margin: 0 0 0 -1em">Log me in</button> 
				<button type="button" name="register" value="Register" onclick="location.href('registerpage.php')">Register</button>
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

		/**
		 * The redirect redirects to previous location or main.php.
		 */
		
		$redirect = "main.php";
		if($_POST['location'] != '') {
			$redirect = $_POST['location'];
		}
		header('Location: ' . $redirect);
		
	}
	else
	{
		echo "Incorrect Username/Password";
	}
}
?>
