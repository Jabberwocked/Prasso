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
	
	var $answerno = 1;  
	
	$("#addOption").click (function(){
		$answerno ++;  
		$("<input type='text' value='' style='display:inline; width:50%' />")
		 .attr("name", "answer" + $answerno)
		 .attr("class", "answers")
	     .insertAfter(".answers:last");
	});
		
		
});