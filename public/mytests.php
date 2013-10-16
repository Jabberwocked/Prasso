<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_mytests.php");



if (!isset($_SESSION['username'])) 
{ 
header("Location:loginpage.php?location=" . urlencode($_SERVER['REQUEST_URI']));

} 
else 
{ ?>

		<style type="text/css">
		td {
			padding: 0px 10px
		}
		</style>
		
		<div
			style="width: 800px; margin-left: auto; margin-right: auto; border: 1px dotted; padding: 20px 20px 100px 20px">
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
	
	$testsquery = $db->prepare("SELECT * FROM Tests WHERE UserId_Owner=:UserId");
	$testsquery->execute(array(
		':UserId' => $_SESSION['userid'],
	));
	$tests = $testsquery->fetchAll();
	
	
	if (!$tests)
	{ ?>
		</table>
		<br><br><br><p style='font-style:italic'>You have no tests.</p>
		</div>
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
				<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
				<button type="submit" name="editquestion" value="<?php echo $testid ?>" >Take</button> |
				<button type="submit" name="" value="<?php echo $testid ?>" >Edit</button> |
				<button type="submit" name="" value="<?php echo $testid ?>" >Results</button> |
				<button type="submit" name="" value="<?php echo $testid ?>" >Administer</button>
			</nav></td>
			<!--		<a href=''>Discuss</a>			-->
			</tr>
		
			</button>
			</form>
		<?php 
		} ?>
			
		</table></div>
		
		<?php 
	}
}

?>
	
	
	
<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>
