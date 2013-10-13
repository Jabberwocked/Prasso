
<?php if (!isset($_SESSION['username'])) { ?>

	<div style="text-align:center">
		<nav>
			<a href="takeatest_random.php">Random by topic</a><br>
			<a href="">Administered tests</a><br>
			<br>
			<br>
			<a href="loginpage.php" style="color:lightgrey">My tests <!-- and shared tests --> </a><br>
		</nav>
	</div>


<?php } else { ?>


	<div style="text-align:center">
		<nav>
			<a href="takeatest_random.php">Random by topic</a><br>
			<a href="">Administered tests</a><br>
			<br>
			<br>
			<a href="mytests.php">My tests <!-- and shared tests --> </a><br>
		</nav>
	</div>

		
<?php } ?>	
	