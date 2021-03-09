<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Options for events
if ( ! function_exists('wpkoi_events_metabox_create_metabox') ) {
	function wpkoi_events_metabox_create_metabox() {
		add_meta_box(
			'wpkoi_events_metabox', // Metabox ID
			'Event Options', // Title to display
			'wpkoi_events_metabox_render_metabox', // Function to call that contains the metabox content
			'wpkoi-events', // Post type to display metabox on
			'normal', // Where to put it (normal = main colum, side = sidebar, etc.)
			'high' // Priority relative to other metaboxes
		);
	
	}
	add_action( 'add_meta_boxes', 'wpkoi_events_metabox_create_metabox' );
}

if ( ! function_exists('wpkoi_events_metabox_render_metabox') ) {
	function wpkoi_events_metabox_render_metabox() {
		global $post; // Get the current post data
		$wpkoi_events_metabox_location = get_post_meta( $post->ID, 'wpkoi_events_metabox_location', true );
		$wpkoi_events_metabox_address  = get_post_meta( $post->ID, 'wpkoi_events_metabox_address', true );
		$wpkoi_events_metabox_date     = get_post_meta( $post->ID, 'wpkoi_events_metabox_date', true );
		$wpkoi_events_metabox_hour     = get_post_meta( $post->ID, 'wpkoi_events_metabox_hour', true );
		$wpkoi_events_metabox_minute   = get_post_meta( $post->ID, 'wpkoi_events_metabox_minute', true );
		$wpkoi_events_metabox_format   = get_post_meta( $post->ID, 'wpkoi_events_metabox_format', true );
		?>
			<fieldset class="wpkoi-event-metabox">
					<label for="wpkoi_events_metabox_location">
						<?php
							_e( 'Location', 'parvati-premium' );
						?>
					</label>
					<input type="text" name="wpkoi_events_metabox_location" id="wpkoi_events_metabox_location" value="<?php echo wp_kses_post( $wpkoi_events_metabox_location ); ?>">
			</fieldset>
			<fieldset class="wpkoi-event-metabox">
					<label for="wpkoi_events_metabox_address">
						<?php
							_e( 'Address', 'parvati-premium' );
						?>
					</label>
					<input type="text" name="wpkoi_events_metabox_address" id="wpkoi_events_metabox_address" value="<?php echo wp_kses_post( $wpkoi_events_metabox_address ); ?>">
			</fieldset>
			<fieldset class="wpkoi-event-metabox">
					<label for="wpkoi_events_metabox_date">
						<?php
							_e( 'Date', 'parvati-premium' );
						?>
					</label>
					<input type="date" id="datepicker" name="wpkoi_events_metabox_date" value="<?php echo $wpkoi_events_metabox_date ; ?>" class="datepicker" />
			</fieldset>
			<fieldset class="wpkoi-event-metabox">
					<label for="wpkoi_events_metabox_hour">
						<?php
							_e( 'Time', 'parvati-premium' );
						?>
					</label>
					<select name="wpkoi_events_metabox_hour" id="wpkoi_events_metabox_hour">
                        <option value=""<?php if ( $wpkoi_events_metabox_hour == '' ) { ?> selected<?php } ?>></option>
                        <option value="00"<?php if ( $wpkoi_events_metabox_hour == '00' ) { ?> selected<?php } ?>><?php echo __( '00', 'parvati-premium' ); ?></option>
                        <option value="01"<?php if ( $wpkoi_events_metabox_hour == '01' ) { ?> selected<?php } ?>><?php echo __( '01', 'parvati-premium' ); ?></option>
                        <option value="02"<?php if ( $wpkoi_events_metabox_hour == '02' ) { ?> selected<?php } ?>><?php echo __( '02', 'parvati-premium' ); ?></option>
                        <option value="03"<?php if ( $wpkoi_events_metabox_hour == '03' ) { ?> selected<?php } ?>><?php echo __( '03', 'parvati-premium' ); ?></option>
                        <option value="04"<?php if ( $wpkoi_events_metabox_hour == '04' ) { ?> selected<?php } ?>><?php echo __( '04', 'parvati-premium' ); ?></option>
                        <option value="05"<?php if ( $wpkoi_events_metabox_hour == '05' ) { ?> selected<?php } ?>><?php echo __( '05', 'parvati-premium' ); ?></option>
                        <option value="06"<?php if ( $wpkoi_events_metabox_hour == '06' ) { ?> selected<?php } ?>><?php echo __( '06', 'parvati-premium' ); ?></option>
                        <option value="07"<?php if ( $wpkoi_events_metabox_hour == '07' ) { ?> selected<?php } ?>><?php echo __( '07', 'parvati-premium' ); ?></option>
                        <option value="08"<?php if ( $wpkoi_events_metabox_hour == '08' ) { ?> selected<?php } ?>><?php echo __( '08', 'parvati-premium' ); ?></option>
                        <option value="09"<?php if ( $wpkoi_events_metabox_hour == '09' ) { ?> selected<?php } ?>><?php echo __( '09', 'parvati-premium' ); ?></option>
                        <option value="10"<?php if ( $wpkoi_events_metabox_hour == '10' ) { ?> selected<?php } ?>><?php echo __( '10', 'parvati-premium' ); ?></option>
                        <option value="11"<?php if ( $wpkoi_events_metabox_hour == '11' ) { ?> selected<?php } ?>><?php echo __( '11', 'parvati-premium' ); ?></option>
                        <option value="12"<?php if ( $wpkoi_events_metabox_hour == '12' ) { ?> selected<?php } ?>><?php echo __( '12', 'parvati-premium' ); ?></option>
                        <option value="13"<?php if ( $wpkoi_events_metabox_hour == '13' ) { ?> selected<?php } ?>><?php echo __( '13', 'parvati-premium' ); ?></option>
                        <option value="14"<?php if ( $wpkoi_events_metabox_hour == '14' ) { ?> selected<?php } ?>><?php echo __( '14', 'parvati-premium' ); ?></option>
                        <option value="15"<?php if ( $wpkoi_events_metabox_hour == '15' ) { ?> selected<?php } ?>><?php echo __( '15', 'parvati-premium' ); ?></option>
                        <option value="16"<?php if ( $wpkoi_events_metabox_hour == '16' ) { ?> selected<?php } ?>><?php echo __( '16', 'parvati-premium' ); ?></option>
                        <option value="17"<?php if ( $wpkoi_events_metabox_hour == '17' ) { ?> selected<?php } ?>><?php echo __( '17', 'parvati-premium' ); ?></option>
                        <option value="18"<?php if ( $wpkoi_events_metabox_hour == '18' ) { ?> selected<?php } ?>><?php echo __( '18', 'parvati-premium' ); ?></option>
                        <option value="19"<?php if ( $wpkoi_events_metabox_hour == '19' ) { ?> selected<?php } ?>><?php echo __( '19', 'parvati-premium' ); ?></option>
                        <option value="20"<?php if ( $wpkoi_events_metabox_hour == '20' ) { ?> selected<?php } ?>><?php echo __( '20', 'parvati-premium' ); ?></option>
                        <option value="21"<?php if ( $wpkoi_events_metabox_hour == '21' ) { ?> selected<?php } ?>><?php echo __( '21', 'parvati-premium' ); ?></option>
                        <option value="22"<?php if ( $wpkoi_events_metabox_hour == '22' ) { ?> selected<?php } ?>><?php echo __( '22', 'parvati-premium' ); ?></option>
                        <option value="23"<?php if ( $wpkoi_events_metabox_hour == '23' ) { ?> selected<?php } ?>><?php echo __( '23', 'parvati-premium' ); ?></option>
                    </select>
					<select name="wpkoi_events_metabox_minute" id="wpkoi_events_metabox_minute">
                        <option value=""<?php if ( $wpkoi_events_metabox_minute == '' ) { ?> selected<?php } ?>></option>
                        <option value="00"<?php if ( $wpkoi_events_metabox_minute == '00' ) { ?> selected<?php } ?>><?php echo __( '00', 'parvati-premium' ); ?></option>
                        <option value="01"<?php if ( $wpkoi_events_metabox_minute == '01' ) { ?> selected<?php } ?>><?php echo __( '01', 'parvati-premium' ); ?></option>
                        <option value="02"<?php if ( $wpkoi_events_metabox_minute == '02' ) { ?> selected<?php } ?>><?php echo __( '02', 'parvati-premium' ); ?></option>
                        <option value="03"<?php if ( $wpkoi_events_metabox_minute == '03' ) { ?> selected<?php } ?>><?php echo __( '03', 'parvati-premium' ); ?></option>
                        <option value="04"<?php if ( $wpkoi_events_metabox_minute == '04' ) { ?> selected<?php } ?>><?php echo __( '04', 'parvati-premium' ); ?></option>
                        <option value="05"<?php if ( $wpkoi_events_metabox_minute == '05' ) { ?> selected<?php } ?>><?php echo __( '05', 'parvati-premium' ); ?></option>
                        <option value="06"<?php if ( $wpkoi_events_metabox_minute == '06' ) { ?> selected<?php } ?>><?php echo __( '06', 'parvati-premium' ); ?></option>
                        <option value="07"<?php if ( $wpkoi_events_metabox_minute == '07' ) { ?> selected<?php } ?>><?php echo __( '07', 'parvati-premium' ); ?></option>
                        <option value="08"<?php if ( $wpkoi_events_metabox_minute == '08' ) { ?> selected<?php } ?>><?php echo __( '08', 'parvati-premium' ); ?></option>
                        <option value="09"<?php if ( $wpkoi_events_metabox_minute == '09' ) { ?> selected<?php } ?>><?php echo __( '09', 'parvati-premium' ); ?></option>
                        <option value="10"<?php if ( $wpkoi_events_metabox_minute == '10' ) { ?> selected<?php } ?>><?php echo __( '10', 'parvati-premium' ); ?></option>
                        <option value="11"<?php if ( $wpkoi_events_metabox_minute == '11' ) { ?> selected<?php } ?>><?php echo __( '11', 'parvati-premium' ); ?></option>
                        <option value="12"<?php if ( $wpkoi_events_metabox_minute == '12' ) { ?> selected<?php } ?>><?php echo __( '12', 'parvati-premium' ); ?></option>
                        <option value="13"<?php if ( $wpkoi_events_metabox_minute == '13' ) { ?> selected<?php } ?>><?php echo __( '13', 'parvati-premium' ); ?></option>
                        <option value="14"<?php if ( $wpkoi_events_metabox_minute == '14' ) { ?> selected<?php } ?>><?php echo __( '14', 'parvati-premium' ); ?></option>
                        <option value="15"<?php if ( $wpkoi_events_metabox_minute == '15' ) { ?> selected<?php } ?>><?php echo __( '15', 'parvati-premium' ); ?></option>
                        <option value="16"<?php if ( $wpkoi_events_metabox_minute == '16' ) { ?> selected<?php } ?>><?php echo __( '16', 'parvati-premium' ); ?></option>
                        <option value="17"<?php if ( $wpkoi_events_metabox_minute == '17' ) { ?> selected<?php } ?>><?php echo __( '17', 'parvati-premium' ); ?></option>
                        <option value="18"<?php if ( $wpkoi_events_metabox_minute == '18' ) { ?> selected<?php } ?>><?php echo __( '18', 'parvati-premium' ); ?></option>
                        <option value="19"<?php if ( $wpkoi_events_metabox_minute == '19' ) { ?> selected<?php } ?>><?php echo __( '19', 'parvati-premium' ); ?></option>
                        <option value="20"<?php if ( $wpkoi_events_metabox_minute == '20' ) { ?> selected<?php } ?>><?php echo __( '20', 'parvati-premium' ); ?></option>
                        <option value="21"<?php if ( $wpkoi_events_metabox_minute == '21' ) { ?> selected<?php } ?>><?php echo __( '21', 'parvati-premium' ); ?></option>
                        <option value="22"<?php if ( $wpkoi_events_metabox_minute == '22' ) { ?> selected<?php } ?>><?php echo __( '22', 'parvati-premium' ); ?></option>
                        <option value="23"<?php if ( $wpkoi_events_metabox_minute == '23' ) { ?> selected<?php } ?>><?php echo __( '23', 'parvati-premium' ); ?></option>
                        <option value="24"<?php if ( $wpkoi_events_metabox_minute == '24' ) { ?> selected<?php } ?>><?php echo __( '24', 'parvati-premium' ); ?></option>
                        <option value="25"<?php if ( $wpkoi_events_metabox_minute == '25' ) { ?> selected<?php } ?>><?php echo __( '25', 'parvati-premium' ); ?></option>
                        <option value="26"<?php if ( $wpkoi_events_metabox_minute == '26' ) { ?> selected<?php } ?>><?php echo __( '26', 'parvati-premium' ); ?></option>
                        <option value="27"<?php if ( $wpkoi_events_metabox_minute == '27' ) { ?> selected<?php } ?>><?php echo __( '27', 'parvati-premium' ); ?></option>
                        <option value="28"<?php if ( $wpkoi_events_metabox_minute == '28' ) { ?> selected<?php } ?>><?php echo __( '28', 'parvati-premium' ); ?></option>
                        <option value="29"<?php if ( $wpkoi_events_metabox_minute == '29' ) { ?> selected<?php } ?>><?php echo __( '29', 'parvati-premium' ); ?></option>
                        <option value="30"<?php if ( $wpkoi_events_metabox_minute == '30' ) { ?> selected<?php } ?>><?php echo __( '30', 'parvati-premium' ); ?></option>
                        <option value="31"<?php if ( $wpkoi_events_metabox_minute == '31' ) { ?> selected<?php } ?>><?php echo __( '31', 'parvati-premium' ); ?></option>
                        <option value="32"<?php if ( $wpkoi_events_metabox_minute == '32' ) { ?> selected<?php } ?>><?php echo __( '32', 'parvati-premium' ); ?></option>
                        <option value="33"<?php if ( $wpkoi_events_metabox_minute == '33' ) { ?> selected<?php } ?>><?php echo __( '33', 'parvati-premium' ); ?></option>
                        <option value="34"<?php if ( $wpkoi_events_metabox_minute == '34' ) { ?> selected<?php } ?>><?php echo __( '34', 'parvati-premium' ); ?></option>
                        <option value="35"<?php if ( $wpkoi_events_metabox_minute == '35' ) { ?> selected<?php } ?>><?php echo __( '35', 'parvati-premium' ); ?></option>
                        <option value="36"<?php if ( $wpkoi_events_metabox_minute == '36' ) { ?> selected<?php } ?>><?php echo __( '36', 'parvati-premium' ); ?></option>
                        <option value="37"<?php if ( $wpkoi_events_metabox_minute == '37' ) { ?> selected<?php } ?>><?php echo __( '37', 'parvati-premium' ); ?></option>
                        <option value="38"<?php if ( $wpkoi_events_metabox_minute == '38' ) { ?> selected<?php } ?>><?php echo __( '38', 'parvati-premium' ); ?></option>
                        <option value="39"<?php if ( $wpkoi_events_metabox_minute == '39' ) { ?> selected<?php } ?>><?php echo __( '39', 'parvati-premium' ); ?></option>
                        <option value="40"<?php if ( $wpkoi_events_metabox_minute == '40' ) { ?> selected<?php } ?>><?php echo __( '40', 'parvati-premium' ); ?></option>
                        <option value="41"<?php if ( $wpkoi_events_metabox_minute == '41' ) { ?> selected<?php } ?>><?php echo __( '41', 'parvati-premium' ); ?></option>
                        <option value="42"<?php if ( $wpkoi_events_metabox_minute == '42' ) { ?> selected<?php } ?>><?php echo __( '42', 'parvati-premium' ); ?></option>
                        <option value="43"<?php if ( $wpkoi_events_metabox_minute == '43' ) { ?> selected<?php } ?>><?php echo __( '43', 'parvati-premium' ); ?></option>
                        <option value="44"<?php if ( $wpkoi_events_metabox_minute == '44' ) { ?> selected<?php } ?>><?php echo __( '44', 'parvati-premium' ); ?></option>
                        <option value="45"<?php if ( $wpkoi_events_metabox_minute == '45' ) { ?> selected<?php } ?>><?php echo __( '45', 'parvati-premium' ); ?></option>
                        <option value="46"<?php if ( $wpkoi_events_metabox_minute == '46' ) { ?> selected<?php } ?>><?php echo __( '46', 'parvati-premium' ); ?></option>
                        <option value="47"<?php if ( $wpkoi_events_metabox_minute == '47' ) { ?> selected<?php } ?>><?php echo __( '47', 'parvati-premium' ); ?></option>
                        <option value="48"<?php if ( $wpkoi_events_metabox_minute == '48' ) { ?> selected<?php } ?>><?php echo __( '48', 'parvati-premium' ); ?></option>
                        <option value="49"<?php if ( $wpkoi_events_metabox_minute == '49' ) { ?> selected<?php } ?>><?php echo __( '49', 'parvati-premium' ); ?></option>
                        <option value="50"<?php if ( $wpkoi_events_metabox_minute == '50' ) { ?> selected<?php } ?>><?php echo __( '50', 'parvati-premium' ); ?></option>
                        <option value="51"<?php if ( $wpkoi_events_metabox_minute == '51' ) { ?> selected<?php } ?>><?php echo __( '51', 'parvati-premium' ); ?></option>
                        <option value="52"<?php if ( $wpkoi_events_metabox_minute == '52' ) { ?> selected<?php } ?>><?php echo __( '52', 'parvati-premium' ); ?></option>
                        <option value="53"<?php if ( $wpkoi_events_metabox_minute == '53' ) { ?> selected<?php } ?>><?php echo __( '53', 'parvati-premium' ); ?></option>
                        <option value="54"<?php if ( $wpkoi_events_metabox_minute == '54' ) { ?> selected<?php } ?>><?php echo __( '54', 'parvati-premium' ); ?></option>
                        <option value="55"<?php if ( $wpkoi_events_metabox_minute == '55' ) { ?> selected<?php } ?>><?php echo __( '55', 'parvati-premium' ); ?></option>
                        <option value="56"<?php if ( $wpkoi_events_metabox_minute == '56' ) { ?> selected<?php } ?>><?php echo __( '56', 'parvati-premium' ); ?></option>
                        <option value="57"<?php if ( $wpkoi_events_metabox_minute == '57' ) { ?> selected<?php } ?>><?php echo __( '57', 'parvati-premium' ); ?></option>
                        <option value="58"<?php if ( $wpkoi_events_metabox_minute == '58' ) { ?> selected<?php } ?>><?php echo __( '58', 'parvati-premium' ); ?></option>
                        <option value="59"<?php if ( $wpkoi_events_metabox_minute == '59' ) { ?> selected<?php } ?>><?php echo __( '59', 'parvati-premium' ); ?></option>
                    </select>
			</fieldset>
			<fieldset class="wpkoi-event-metabox">
					<label for="wpkoi_events_metabox_format">
						<?php
							_e( 'Date format', 'parvati-premium' );
						?>
					</label>
					<select name="wpkoi_events_metabox_format" id="wpkoi_events_metabox_format">  
                        <option value="M d, Y"<?php if ( $wpkoi_events_metabox_format == 'M d, Y' ) { ?> selected<?php } ?>><?php echo __( 'Dec 31, 1999', 'parvati-premium' ); ?></option> 
                        <option value="Y M d"<?php if ( $wpkoi_events_metabox_format == 'Y M d' ) { ?> selected<?php } ?>><?php echo __( '1999 Dec 31', 'parvati-premium' ); ?></option> 
                        <option value="Y.m.d."<?php if ( $wpkoi_events_metabox_format == 'Y.m.d.' ) { ?> selected<?php } ?>><?php echo __( '1999.12.31.', 'parvati-premium' ); ?></option> 
                        <option value="d F Y"<?php if ( $wpkoi_events_metabox_format == 'd F Y' ) { ?> selected<?php } ?>><?php echo __( '12 December 1999', 'parvati-premium' ); ?></option> 
                        <option value="d/m/Y"<?php if ( $wpkoi_events_metabox_format == 'd/m/Y' ) { ?> selected<?php } ?>><?php echo __( '31/12/1999', 'parvati-premium' ); ?></option>  
                    </select>
			</fieldset>
	
		<?php
		wp_nonce_field( 'wpkoi_events_form_metabox_nonce', 'wpkoi_events_form_metabox_process' );
	}
}

if ( ! function_exists('wpkoi_events_metabox_save_metabox') ) {
	function wpkoi_events_metabox_save_metabox( $post_id, $post ) {
	
		if ( !isset( $_POST['wpkoi_events_form_metabox_process'] ) ) return;
		if ( !wp_verify_nonce( $_POST['wpkoi_events_form_metabox_process'], 'wpkoi_events_form_metabox_nonce' ) ) {
			return $post->ID;
		}
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}
	
		$sanitized_wpkoi_events_metabox_location = wp_filter_post_kses( $_POST['wpkoi_events_metabox_location'] );
		$sanitized_wpkoi_events_metabox_address  = wp_filter_post_kses( $_POST['wpkoi_events_metabox_address'] );
		$sanitized_wpkoi_events_metabox_date     = wp_filter_post_kses( $_POST['wpkoi_events_metabox_date'] );
		$sanitized_wpkoi_events_metabox_hour     = wp_filter_post_kses( $_POST['wpkoi_events_metabox_hour'] );
		$sanitized_wpkoi_events_metabox_minute   = wp_filter_post_kses( $_POST['wpkoi_events_metabox_minute'] );
		$sanitized_wpkoi_events_metabox_format   = wp_filter_post_kses( $_POST['wpkoi_events_metabox_format'] );
		// Save our submissions to the database
		update_post_meta( $post->ID, 'wpkoi_events_metabox_location', $sanitized_wpkoi_events_metabox_location );
		update_post_meta( $post->ID, 'wpkoi_events_metabox_address', $sanitized_wpkoi_events_metabox_address );
		update_post_meta( $post->ID, 'wpkoi_events_metabox_date', $sanitized_wpkoi_events_metabox_date );
		update_post_meta( $post->ID, 'wpkoi_events_metabox_hour', $sanitized_wpkoi_events_metabox_hour );
		update_post_meta( $post->ID, 'wpkoi_events_metabox_minute', $sanitized_wpkoi_events_metabox_minute );
		update_post_meta( $post->ID, 'wpkoi_events_metabox_format', $sanitized_wpkoi_events_metabox_format );
	
	}
	add_action( 'save_post', 'wpkoi_events_metabox_save_metabox', 1, 2 );
}