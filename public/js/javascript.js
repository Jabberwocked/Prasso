$(document).ready(function(){

	
	$(function() {
		   $('.selectall').change(function() {
		      $(this).siblings('input[type=checkbox]').prop('checked', this.checked);
		   });
		});

	
	
	$("#addOption").click (function(){
		$("form").append('<input type="text">');
		});
		
	
});