<?php include_once (LIBRARY_PATH . "/user.php"); ?>
<?php if( !(isset( $_POST['login'] ) ) ) { ?>



	<div id="main-wrapper" style="margin-top:50px;">
		
		<?php 	if (isset($_SESSION['registrationsuccessful']))
				{
					// Echoes a line after registration (when applicable)
					echo "<p style='color:green; text-align:center'>" . $_SESSION['registrationsuccessful'] . "</p><br><br>"; 
					unset($_SESSION['registrationsuccessful']);
				}
		?>
		
		<div id="login-wrapper">
			<form method="post" action="">
				<label for="usn">Username : </label> 
				<input type="text" maxlength="30" required autofocus name="username" />
				<br>
				<label for="passwd">Password : </label> 
				<input type="password" maxlength="30" required name="password" />
				<br>
				<input type="hidden" name="location" value="<?php if(isset($_GET['location'])) { echo htmlspecialchars($_GET['location']); } ?>"  />
				<button type="submit" name="login" value="Log me in" >Log me in</button> |
				<button type="button" name="register" value="Register" onclick="document.location.href='registerpage.php';">Register</button>
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
		 * The redirect redirects to previous location or index.php.
		 */
		
		$redirect = "index.php";
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
