<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_tests.php");
?>



<style type="text/css">
td {
	padding: 0px 10px
}
</style>

<div style="width: 800px; margin: 0px auto; border: 1px dotted; padding: 20px 20px 100px 20px">

<!-- TO DO
	<div style="text-align:center">
		<nav style="margin:0px auto;">
			<a href="" style="font-size: small; margin-top:0px">Show all results</a>
			<a href="" style="font-size: small; margin-top:0px">Show in folders</a>
			<div style="display:inline; margin: 0px 0px 0px 20px">Filter by:</div>
			<a href="" style="font-size: small; margin: 0px 2px">topic</a>
			<a href="" style="font-size: small; margin: 0px 2px">label</a>
			<a href="" style="font-size: small; margin: 0px 2px">user</a>
			<a href="" style="font-size: small; margin: 0px 2px">test</a>
		</nav>
	</div>
-->

<br>
<table>
	<tr style="font-weight: bold; margin-bottom: 20px;">
		<td>Date</td>
		<td>Test</td>
		<td>User</td>
		<td>Owner</td>
<!--  TO DO
		<td>Topic</td>
		<td>Labels</td>
-->
		<td>Result</td>
		<td></td>
		<td></td>
	</tr>
	
<?php

$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);

$testsquery = $db->prepare("SELECT * FROM test_attempts WHERE userid=:userid ORDER BY attemptid");
$testsquery->execute(array(
	':userid' => $_SESSION['userid'],
));
$results = $testsquery->fetchAll();


if (!$results)
	{ ?>

</table>
<br><br><br><p style='font-style:italic'>You have no saved results.</p>

	<?php  }
	
	else 
	{
		foreach ($results as $resultrow)
		{
			$attemptid = $resultrow['attemptid'];
			$testid = $resultrow['testid'];
			$userid = $resultrow['userid'];
			$date = $resultrow['datetime'];
			$sumgrades = $resultrow['sumgrades'];
			
			
			$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
			$sql = "SELECT * FROM tests WHERE testid=" . $testid;
			$tests = $db->query($sql);
			foreach ($tests as $test)
			{
				$testname = $test['testname'];
				$userid_owner = $test['userid_owner'];
			}
			
			$db = new PDO(DB_USERS, DB_USERNAME, DB_PASSWORD);
			$sql = "SELECT * FROM users WHERE userid=" . $userid_owner;
			$dbusers = $db->query($sql);
			foreach ($dbusers as $dbuser)
			{
				$owner = $dbuser['username'];
			}
			$sql = "SELECT * FROM users WHERE userid=" . $userid;
			$dbusers = $db->query($sql);
			foreach ($dbusers as $dbuser)
			{
				$user = $dbuser['username'];
			}	
				
			
			$topic = "";
			$labels = "";
			
			?>
				
			<tr>
			<td><?php echo $date ?></td>
			<td><?php echo $testname ?></td>
			<td><?php echo $user ?></td>
			<td><?php echo $owner ?></td>
			<td><?php echo $sumgrades ?></td>
			<td><?php echo $topic ?></td>
			<td><?php echo $labels ?></td>
			<td>
				<form style="display:inline" action=<?php echo htmlspecialchars('results.php');?> method="post"><button type="submit" name="resultid" value="<?php echo $resultid ?>" >View</button></form>
			</td>
			</tr>
		
			
			
	<?php 
		}
	} ?>
		
	</table>
	</div>
	

	
<?php 	
/*  Backup
 
 
 
if (isset($_POST['testid']))
{
	echo "hello";
}

else {
?>



	<nav>
		<a href="" style="font-size: small">Show all results</a>
		<a href="" style="font-size: small">Show in folders</a>
		<!-- <a href="" style="font-size: small">Show paths</a> -->
		<div style="display:inline; margin: 0px 0px 0px 20px">Filter by:</div>
		<a href="" style="font-size: small; margin: 10px 2px">topic</a>
		<a href="" style="font-size: small; margin: 10px 2px">label</a>
		<a href="" style="font-size: small; margin: 10px 2px">user</a>
		<a href="" style="font-size: small; margin: 10px 2px">test</a>
	</nav>
	
<!-- PLACEHOLDER -->
	
	
<style type="text/css">
	td {
		padding: 0px 10px
	}
</style>
	
<div style="width: 800px; margin-left: auto; margin-right: auto; border: 1px dotted; padding: 20px 20px 100px 20px">
	<table>
		<tr style="font-weight: bold; margin-bottom: 20px;">
			<td>Date</td>
			<td>User</td>
			<td>Owner</td>
			<td>Test</td>
			<td>Topic</td>
			<td>Labels</td>
			<td>Result</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>4-8-2013</td>
			<td>Me</td>
			<td>Teun Cortooms</td>
			<td>Chapter 5</td>
			<td>Present continuous</td>
			<td>-</td>
			<td>70% <!--		 		(<a href="">Share</a>)			-->
			</td>
			<td><a href="">View</a></td>
			<!--		<td><a href="">Discuss</a></td>			-->
		</tr>
		<tr>
			<td>4-8-2013</td>
			<td>Pietje</td>
			<td>Teun Cortooms</td>
			<td>Chapter 5</td>
			<td>Present continuous</td>
			<td>-</td>
			<td>95% <!--		 		(<a href="">Share</a>)			-->
			</td>
			<td><a href="">View</a></td>
			<!--		<td><a href="">Discuss</a></td>			-->
		</tr>
		<tr>
			<td>2-8-2013</td>
			<td>Me</td>
			<td>Me</td>
			<td>Random</td>
			<td>Present continuous</td>
			<td>-</td>
			<td>70% <!--		 		(<a href="">Share</a>)			-->
			</td>
			<td><a href="">View</a></td>
			<!--		<td><a href="">Discuss</a></td>			-->
		</tr>
	</table>
</div>


<?php } 

end backup */

?>



<!-- The code below is placeholder code for *following* options, to be added later.
	 	
<center>
<br> <br> <br> <br> <br> <br> <br> <br>

<nav>
	<div style="text-align: left; margin: 0px 40px">
		<h1 style="font-weight: bold">Following</h1>
		<p>Pietje</p>
		<br>
		<h1 style="font-weight: bold">Followed by</h1>
		<p>Teun Cortooms</p>
	</div>
	<div style="text-align: left; margin: 0px 40px">
		<a href="" >Follow a user</a><br>
		<a href="" >Invite follower</a>
	</div>
	<br>
</nav>
	
</center>
-->

<?php
include_once (TEMPLATES_PATH . "/footer.php");
?> 