<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_mytests.php");
?>


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
		<tr>
			<td>Chapter 3</td>
			<td>Mixed</td>
			<td>-</td>
			</td>
			<td><nav>
				<a href="" style="font-size: small; margin: 0px 2px">Take</a>
				<a href="" style="font-size: small; margin: 0px 2px">Edit</a>
				<a href="" style="font-size: small; margin: 0px 2px">Results</a>
				<a href="" style="font-size: small; margin: 0px 2px">Administer</a>
			</nav></td>
			<!--		<a href="">Discuss</a>			-->
		</tr>
		<tr>
			<td>Random</td>
			<td>Present continuous</td>
			<td>-</td>
			</td>
			<td><nav>
				<a href="" style="font-size: small; margin: 0px 2px">Take</a>
				<a href="" style="font-size: small; margin: 0px 2px">Edit</a>
				<a href="" style="font-size: small; margin: 0px 2px">Results</a>
				<a href="" style="font-size: small; margin: 0px 2px">Administer</a>
			</nav></td>
			<!--		<a href="">Discuss</a>			-->		
			</tr>
	</table>
</div>


<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>