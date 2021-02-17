jQuery( document ).ready(function( $ ) {
	$( '#parvati-select-all' ).on( 'click', function( event ) {
		if ( this.checked ) {
			$( '.addon-checkbox' ).each( function() {
				this.checked = true;
			});
		} else {
			$( '.addon-checkbox' ).each( function() {
				this.checked = false;
			});
		}
	} );
});
