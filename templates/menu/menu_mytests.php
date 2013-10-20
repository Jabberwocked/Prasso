<!-- NAV STYLE IF HREF IS CURRENT -->
<style>
	nav a[href="<?php echo str_replace('/', '', $_SERVER['PHP_SELF']); ?>"] {
	color: orange;
	outline: none;
	border-bottom: 2px solid #eee;
}
</style>


		<nav>
			<a href="takeatest_random.php">Selftest</a>
			<?php if (!isset($_SESSION['username'])) { ?>
			<a href="mytests.php" style="color:lightgrey">My Tests</a>
			<a href="mytests_edit.php" style="color:lightgrey">New</a><br>
			<?php } else { ?>
			<a href="mytests.php">My Tests</a>
			<a href="mytests_edit.php">New</a><br>
			<?php } ?>
			
<!-- 		TEMP	 -->
			<?php if ($invitation) {?>
			<a href="">Invitations</a>
			<?php };?>
			
		</nav>
	
