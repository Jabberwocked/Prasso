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
		$("<input type='text' value='' />")
	     .attr("id", "answer" + $answerno)
	     .attr("name", "answer" + $answerno)
	     .insertAfter("#answer1");
	});
		
		
});