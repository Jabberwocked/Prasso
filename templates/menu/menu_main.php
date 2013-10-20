
			<div style="text-align:center">
				<nav>
					<a href="takeatest_random.php">Tests</a><br>
					<br>
					<br>
					<?php if (!isset($_SESSION['username'])) { ?>
					<a href="results.php" style="color:lightgrey">Results</a><br>
					<?php } else { ?>
					<a href="results.php">Results</a><br>		
					<?php } ?>	
				</nav>
			</div>
		

	
