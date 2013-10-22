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
	<div style="text-align:center">
		<nav style="margin:0px auto;">
			<a href="" style="font-size: small; margin-top:0px">Show all tests</a>
			<a href="" style="font-size: small; margin-top:0px">Show in folders</a>
			<div style="display:inline; margin: 0px 0px 0px 20px">Filter by:</div>
			<a href="" style="font-size: small; margin: 0px 2px">topic</a>
			<a href="" style="font-size: small; margin: 0px 2px">label</a>
		</nav>
	</div>
	<br>
	<table>
		<tr style="font-weight: bold; margin-bottom: 20px;">
			<td>Test</td>
			<td>Topic</td>
			<td>Labels</td>
			<td></td>
			<td></td>
		</tr>
			
<?php 

	$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
	
	$testsquery = $db->prepare("SELECT * FROM Tests WHERE UserId_Owner=:UserId ORDER BY TestId");
	$testsquery->execute(array(
		':UserId' => $_SESSION['userid'],
	));
	$tests = $testsquery->fetchAll();
	
	
	if (!$tests)
	{ ?>
		</table>
		<br><br><br><p style='font-style:italic'>You have no tests.</p>
	<?php  }
	
	else 
	{
		foreach ($tests as $testrow)
		{
			$testid = $testrow['TestId'];
			$testname = $testrow['TestName'];
			$topic = "";
			$labels = "";
			
			?>
				
			<tr>
			<td><?php echo $testname ?></td>
			<td><?php echo $topic ?></td>
			<td><?php echo $labels ?></td>
			<td>
				<form style="display:inline" action=<?php echo htmlspecialchars('test.php');?> method="post"><button type="submit" name="testtotake" value="<?php echo $testid ?>" >Take</button></form> |
				<form style="display:inline" action=<?php echo htmlspecialchars('test_edit.php');?> method="post"><button type="submit" name="testtoedit" value="<?php echo $testid ?>" >Edit</button></form> |
				<form style="display:inline"><button type="submit" name="" value="<?php echo $testid ?>" >Results</button></form> |
				<Form style="display:inline"><button type="submit" name="" value="<?php echo $testid ?>" >Administer</button></Form>
			<!--<button>Discuss</button>			-->
			</td>
			</tr>
		
			
			
	<?php 
		}
	} ?>
		
	</table>
	<br>
	<br>
	<nav><a href="test_edit.php" style="margin:0px; color:black;">New</a></nav>
	
	</div>
	

	
	
	
<?php include_once (TEMPLATES_PATH . "/footer.php"); ?>
