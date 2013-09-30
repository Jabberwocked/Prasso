$(document).ready(function(){

	
	
//	$( '.selectall' ).click( function () {
//	    $( this ).closest( 'form' ).find( ':checkbox' ).attr( 'checked' , this.checked );
//	});


//	$('.selectall').change(function() {
//	    var checkboxes = $(this).closest('form').find(':checkbox');
//	    if($(this).is(':checked')) {
//	        checkboxes.attr('checked', 'checked');
//	    } else {
//	        checkboxes.removeAttr('checked');
//	    }
//	});


	$(function() {
		   $('.selectall').change(function() {
		      $(this).siblings('input[type=checkbox]').prop('checked', this.checked);
		      // $(this).closest('section').find('input[type=checkbox]').prop('checked', this.checked);
		   });
		});

});