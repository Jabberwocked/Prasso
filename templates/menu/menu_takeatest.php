


	<div style="text-align:center">
		<nav>
			<a href="takeatest_random.php">Random by topic</a><br>
			<a href="">Administered tests</a><br>
			<br>
			<?php if (!isset($_SESSION['username'])) { ?>
			<a href="mytests.php" style="color:lightgrey">My tests</a><br>
			<?php } else { ?>
			<a href="mytests.php">My tests</a><br>
			<?php } ?>
		</nav>
	</div>






	
	