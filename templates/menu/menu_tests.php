<!-- NAV STYLE IF HREF IS CURRENT -->
<style>
	nav a[href="<?php echo str_replace('/', '', $_SERVER['PHP_SELF']); ?>"] {
	color: black;
	outline: none;
	border-bottom: 2px solid #eee;
}
</style>


		<nav>
			<a href="testpage_generate.php">Quick Test</a>
			<?php if (!isset($_SESSION['username'])) { ?>
			<a href="mytests.php" style="color:lightgrey">My Tests</a>
			<a href="results.php" style="color:lightgrey">My Results</a>
			<?php } else { ?>
			<a href="mytests.php">My Tests</a>
			<a href="results.php">My Results</a>
			<?php } ?>
			
			
<!-- 		TEMP	 -->
			<?php if ($invitation) {?>
			<a href="">Invitations</a>
			<?php };?>
			
		</nav>
	
