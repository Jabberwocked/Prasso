$(document).ready(function(){
	$( '.selectall' ).click( function () {
	    $( this ).closest( 'form' ).find( ':checkbox' ).attr( 'checked' , this.checked );
	});
});