<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_results.php");



if (isset($_POST['testid']))
{
	echo "hello";
}

else {
?>




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


<?php } ?>



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