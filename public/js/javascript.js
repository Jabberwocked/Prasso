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
	 
	var $answernojs = $_SESSION['answerno'];
	
	$("#addOption").click (function(){
		$answernojs ++;  
		$("<input type='text' value='' style='display:inline; width:60%' />")
		 .attr("name", "answers[]")
		 .attr("class", "answers")
		 .attr("placeholder", "Answer " + $answernojs)
	     .insertAfter(".answers:last");
	});
		
		
});