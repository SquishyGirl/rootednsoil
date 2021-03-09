( function( api ) {

	api.controlConstructor['gp-background-images'] = api.Control.extend( {
		ready: function() {
			var control = this;
			
			control.container.on( 'change', '.parvati-backgrounds-repeat select',
				function() {
					control.settings['repeat'].set( jQuery( this ).val() );
				}
			);
			
			control.container.on( 'change', '.parvati-backgrounds-size select',
				function() {
					control.settings['size'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'change', '.parvati-backgrounds-attachment select',
				function() {
					control.settings['attachment'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'input', '.parvati-backgrounds-position input',
				function() {
					control.settings['position'].set( jQuery( this ).val() );
				}
			);

		}
	} );

} )( wp.customize );