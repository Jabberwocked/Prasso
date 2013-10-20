<form action=mytests_edit.php method="post">
		
	<button class='textlayout' type="submit" name="itemtoedit" value="testname" >
		<p>Test name: <span style='font-weight:bold'>111</span></p>
	</button><br>
		
	<!-- 	<input type="hidden" name="action" value="save"> -->
	
	<button class='textlayout' type="submit" name="itemtoedit" value="1" >
		<p>
			<span style='font-weight:bold'>1. 1111</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>11</span>
	</button><br>
		
	<!-- 	<input type="hidden" name="action" value="save"> -->
	
	<button class='textlayout' type="submit" name="itemtoedit" value="2" >
		<p>
			<span style='font-weight:bold'>2. 2222</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>22</span>
	</button><br>
		
	<!-- 	<input type="hidden" name="action" value="save"> -->
	<button class='textlayout' type="submit" name="itemtoedit" value="3" >
		<p>
			<span style='font-weight:bold'>3. 3333</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>3</span>
	</button><br>
		
	<!-- 	<input type="hidden" name="action" value="save"> -->
	<button class='textlayout' type="submit" name="itemtoedit" value="4" >
		<p>
			<span style='font-weight:bold'>4. 44444</span>
			<span style='font-weight:normal'>(SA)</span><br>
			<span>4</span>
	</button><br>
		
	<input type="hidden" name="orderno" value='5'>
	<input type="text" name="question" value='' placeholder="Question 5" autofocus style="display:inline; width:70%; font-weight:bold">
	<select name="type" style="width:45px;">
		<option value="shortanswer" selected>SA: Short Answer</option>
		<option value="multichoice" >MC: Multiple Choice</option>
	</select> 
	<input type="text" name="answers[]" class="answers" placeholder="Answer 1" style="display:inline; width:60%">
	<script> var answernojs = 2;</script>	
	<button type="button" id="addOption" value="Add" >+</button> |
	<button type="submit" name="action" value="save" >Save</button><br>
	<br>
			
			
	
	<button type="submit" name="action" value="savetest" >Save</button> |
	<button type="submit" name="action" value="reset" >Reset</button>
</form>
<br>
<br>
