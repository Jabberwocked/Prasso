$(document).ready(function(){

	
	$(function() {
		   $('.selectall').change(function() {
		      $(this).siblings('input[type=checkbox]').prop('checked', this.checked);
		   });
		});

	
	
	var $answerno = 1;
	
	$("#addOption").click (function(){
		$answerno ++;
		$("#answer1").after('<input type="text" name=answer' + $answerno + '>');
		});
		
	
});