
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Prasso</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/javascript.js"></script>


</head>
<body>
	<header>
		<a href="index.php"><h1 id='title'>PRASSO</h1></a>
	
		<a href='profile.php' style='position:absolute; top:55px; right:0px; font-size:15px'>Teun</a>		
		
		
	</header>
	

</body>
</html><!-- NAV STYLE IF HREF IS CURRENT -->
<style>
	nav a[href="mytests_edit.php"] {
	color: orange;
	outline: none;
	border-bottom: 2px solid #eee;
}
</style>


		<nav>
			<a href="takeatest_random.php">Selftest</a>
						<a href="mytests.php">My Tests</a>
			<a href="mytests_edit.php">New</a><br>
						
<!-- 		TEMP	 -->
						
		</nav>
	


<div style="margin-left: auto; margin-right: auto; width: 500px">

lala17				
		<form action=test123.php method="post">
		
				
			<button class='textlayout' type="submit" name="itemtoedit" value="testname" >
				<p>Test name: <span style='font-weight:bold'>111</span></p>
			</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="1" >
			<p>
			<span style='font-weight:bold'>1. 1111</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>11</span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="2" >
			<p>
			<span style='font-weight:bold'>2. 2222</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>22</span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="3" >
			<p>
			<span style='font-weight:bold'>3. 3333</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>3</span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="4" >
			<p>
			<span style='font-weight:bold'>4. 44444</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>4</span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="5" >
			<p>
			<span style='font-weight:bold'>5. 555</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>55</span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="6" >
			<p>
			<span style='font-weight:bold'>6. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="7" >
			<p>
			<span style='font-weight:bold'>7. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="8" >
			<p>
			<span style='font-weight:bold'>8. 8888</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>88</span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="9" >
			<p>
			<span style='font-weight:bold'>9. 999</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="10" >
			<p>
			<span style='font-weight:bold'>10. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="11" >
			<p>
			<span style='font-weight:bold'>11. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="12" >
			<p>
			<span style='font-weight:bold'>12. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="13" >
			<p>
			<span style='font-weight:bold'>13. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="14" >
			<p>
			<span style='font-weight:bold'>14. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="15" >
			<p>
			<span style='font-weight:bold'>15. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
		
		<button class='textlayout' type="submit" name="itemtoedit" value="16" >
			<p>
			<span style='font-weight:bold'>16. </span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span></span>
		</button><br>
		
						<input type="hidden" name="orderno" value='17'>
				<input type="text" name="question" value='' placeholder="Question 17" autofocus style="display:inline; width:70%; font-weight:bold">
				<select name="type" style="width:45px;">
					<option value="shortanswer" selected>SA: Short Answer</option>
					<option value="multichoice" >MC: Multiple Choice</option>
				</select> 
								<input type="text" name="answers[]" class="answers" placeholder="Answer 1" style="display:inline; width:60%">
				<script> var answernojs = 2;</script>	
				<button type="button" id="addOption" value="Add" >+</button> |
			 	<input type="hidden" name="action" value="save"> 
				<button type="submit">Save</button><br>
				<br>
			
			
	
		<button type="submit" name="action" value="savetest" >Save</button> |
		<button type="submit" name="action" value="reset" >Reset</button>
		</form>
		<br>
		<br>
	
	
		
	
</div>


</body>
</html>
