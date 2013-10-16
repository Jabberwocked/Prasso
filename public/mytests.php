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
				<button type="submit" name="editquestion" value="<?php echo $testid ?>" style='
					width:auto; 
					height:auto; 
					margin:0; 
					padding:0; 
					border: 0;
					background:none; 
					color:#666; 
					text-align:left; 
					-moz-border-radius: 0px;
					-webkit-border-radius: 0px;
					border-radius: 0px;
					-moz-box-shadow: 0;
					-webkit-box-shadow: 0;
					box-shadow: none;
					-webkit-appearance: none;
					text-transform: none;
					letter-spacing: 1px;'>
				Take</button>
				<a href='mytests_edit.php' style='font-size: small; margin: 0px 2px'>Edit</a>
				<a href='' style='font-size: small; margin: 0px 2px'>Results</a>
				<a href='' style='font-size: small; margin: 0px 2px'>Administer</a>
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
