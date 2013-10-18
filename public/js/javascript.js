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
	
	
	$("#addOption").click (function(){
		$("<input type='text' value='' autofocus style='display:inline; width:60%' />")
		 .attr("name", "answers[]")
		 .attr("class", "answers")
		 .attr("placeholder", "Answer " + answernojs)
	     .insertAfter(".answers:last");
		answernojs ++;  
	});
	
	$('.answers').keydown(function(e) {
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
		
});