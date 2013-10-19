<?php if (!isset($_SESSION['username'])) { ?>

			<div style="text-align:center">
				<nav>
					<a href="takeatest.php">Tests</a><br>
					<br>
					<br>
					<a href="loginpage.php">Log in</a><br>
				</nav>
			</div>

<?php } else { ?>

			<div style="text-align:center">
				<nav>
					<a href="takeatest.php">Tests</a><br>
					<br>
					<br>
					<a href="results.php">Results</a><br>		
		<!-- 		<a href="other.php">Other</a><br>		-->
				</nav>
			</div>
		
<?php } ?>	
	
