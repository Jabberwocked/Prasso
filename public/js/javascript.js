$(document).ready(function(){

	/**
	 * Used in takeatest_random to select all checkboxes
 	 */
	
	$(function() {
		   $('.selectall').change(function() {
		      $(this).siblings('input[type=checkbox]').prop('checked', this.checked);
		   });
		});

	
	/**
	 * Used in mytests_new to add fields to the form
 	 */
	
//	click + to add another field
	$("#addOption").click (function(){
		$("<input type='text' value='' autofocus style='display:inline; width:60%' />")
		 .attr("name", "answers[]")
		 .attr("class", "answers")
		 .attr("placeholder", "Answer " + answernojs)
	     .insertAfter(".answers:last");
		answernojs ++;  
	});
	
//	or press tab twice to add another field
	$('#addOption').keydown(function(e) {
		var code = e.keyCode || e.which;
		if (code == 9) {
			$("<input type='text' value='' autofocus style='display:inline; width:60%' />")
			 .attr("name", "answers[]")
			 .attr("class", "answers")
			 .attr("placeholder", "Answer " + answernojs)
		     .insertAfter(".answers:last");
			answernojs ++;  
		}
		return false;
	});
	
	$(document).click(function() {
		  $("#questionform").submit();
		});
		$("#questionform").click(function(e) {
		  e.stopPropagation();
	});
		
});