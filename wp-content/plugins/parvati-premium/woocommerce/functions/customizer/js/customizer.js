jQuery( document ).ready( function($) {
	$( '#customize-control-parvati_woocommerce_primary_button_message a' ).on( 'click', function( e ) {
		e.preventDefault();
		wp.customize.control( 'parvati_settings[form_button_background_color]' ).focus();
	});
});