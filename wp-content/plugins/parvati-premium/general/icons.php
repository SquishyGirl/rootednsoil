<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'parvati_enqueue_premium_icons' );
/**
 * Register our Parvati Premium icons.
 *
 */
function parvati_enqueue_premium_icons() {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_style( 'parvati-premium-icons', plugin_dir_url( __FILE__ ) . "icons/icons{$suffix}.css", array(), PARVATI_PREMIUM_VERSION );
}
