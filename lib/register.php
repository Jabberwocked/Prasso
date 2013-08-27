<?php include_once ("config.php"); ?>

<?php if( !(isset( $_POST['register'] ) ) ) { ?>


	<div id="main-wrapper">
		<div id="register-wrapper">
			<form method="post" action="">
				<ul>
					<li><label for="usn">Username : </label> <input type="text"
						id="usn" maxlength="30" required autofocus name="username" /></li>

					<li><label for="passwd">Password : </label> <input type="password"
						id="passwd" maxlength="30" required name="password" /></li>

					<li><label for="conpasswd">Confirm Password : </label> <input
						type="password" id="conpasswd" maxlength="30" required
						name="conpassword" /></li>
					<li class="buttons"><input type="submit" name="register"
						value="Register" /> <input type="button" name="cancel"
						value="Cancel" onclick="location.href='index.php'" /></li>

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
	
	if ($_POST['password'] == $_POST['conpassword'])
	{
		echo $usr->register($_POST);
	}
	else
	{
		echo "Password and Confirm password not match";
	}
}
?>