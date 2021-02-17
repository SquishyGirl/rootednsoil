var wpkoi_repeating_sortable_init = function( selector ) {
	if ( typeof selector === 'undefined' ) {
		jQuery('.wpkoi-repeating-fields .inner').sortable({ placeholder: 'ui-state-highlight' });
	} else {
		jQuery('.wpkoi-repeating-fields .inner', selector).sortable({ placeholder: 'ui-state-highlight' });
	}
};

var wpkoi_repeating_colorpicker_init = function( selector ) {
	if ( selector === undefined ) {
		var ciColorPicker = jQuery( '#widgets-right .wpkoi-color-picker, #wp_inactive_widgets .wpkoi-color-picker' ).filter( function() {
			return !jQuery( this ).parents( '.field-prototype' ).length;
		} );

		ciColorPicker.wpColorPicker();
	} else {
		jQuery( '.wpkoi-color-picker', selector ).wpColorPicker();
	}
};

jQuery(document).ready(function($) {
	"use strict";
	var $body = $( 'body' );

	// Repeating fields
	wpkoi_repeating_sortable_init();

	$body.on( 'click', '.wpkoi-repeating-add-field', function( e ) {
		var repeatable_area = $( this ).siblings( '.inner' );
		var fields = repeatable_area.children( '.field-prototype' ).clone( true ).removeClass( 'field-prototype' ).removeAttr( 'style' ).appendTo( repeatable_area );
		wpkoi_repeating_sortable_init();
		wpkoi_repeating_colorpicker_init();
		e.preventDefault();
	} );


	$body.on( 'click', '.wpkoi-repeating-remove-field', function( e ) {
		var field = $(this).parents('.post-field');
		field.remove();
		e.preventDefault();
	});
});
