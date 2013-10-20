<style>
	nav a[href=<?php echo $_SERVER['PHP_SELF']?>] {
	color: orange;
	outline: none;
	border-bottom: 2px solid #eee; /* Bottom border style on hover */
}
</style>
<?php echo $_SERVER['PHP_SELF']?>
		<nav>
			<a href="takeatest_random.php">Selftest</a>
			<a href="">Code</a>
			<?php if (!isset($_SESSION['username'])) { ?>
			<a href="mytests.php" style="color:lightgrey">My Tests</a>
			<a href="mytests_edit.php" style="color:lightgrey">New</a><br>
			<?php } else { ?>
			<a href="mytests.php">My Tests</a>
			<a href="mytests_edit.php">New</a><br>
			<?php } ?>
		</nav>
	
