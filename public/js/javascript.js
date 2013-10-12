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
	var $lastanswer = 'answer' + $answerno;  
	
	$("#addOption").click (function(){
		$answerno ++;
		$("#" + $lastanswer).after('<input type="text" name=' + $lastanswer + ' id=' + $lastanswer + '>');
		});
		
	
});