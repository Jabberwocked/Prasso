<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Prasso</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/checkall.js"></script>


</head>
<body>
	<header>
		<a href="main.php"><h1 id='title'>PRASSO</h1></a>
	
		<?php
		/**
		 * Show if logged in, or not. 
		 */
				
		if (isset($_SESSION['username']))
		{
		echo "<a href='profile.php' style='position:absolute; top:55px; right:0px; font-size:15px'>" . $_SESSION['username'] . "</a>";
		}
		else 
		{
		echo "<a href='loginpage.php' style='position:absolute; top:55px; right:0px; font-size:15px'>" . "LOG IN" . "</a>";
		}
		?>
		
		
		
	</header>
	<br>
	<br>
	<br>
	<br>
</body>
</html>