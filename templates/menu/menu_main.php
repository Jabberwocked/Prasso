<?php if (!isset($_SESSION['username'])) { ?>

			<div style="text-align:center">
				<nav>
					<a href="takeatest.php">Take a test</a><br>
					<a href="results.php">Results</a><br>
					<br>
					<br>
					<a href="mytests.php">My Tests</a><br>			
		<!-- 		<a href="other.php">Other</a><br>		-->
				</nav>
			</div>

<?php } else { ?>

			<div style="text-align:center">
				<nav>
					<a href="takeatest.php">Take a test</a><br>
					<a href="results.php">Results</a><br>
					<br>
					<br>
					<a href="mytests.php">My Tests</a><br>			
		<!-- 		<a href="other.php">Other</a><br>		-->
				</nav>
			</div>
		
<?php } ?>	
	
