<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPKOI_ELEMENTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPKOI_ELEMENTS_URL', plugins_url( '/', __FILE__ ) );
define( 'WPKOI_ELEMENTS_VERSION', '2.4.0' );

// Includes
require_once plugin_dir_path( __FILE__ ) . 'includes/elementor-helper.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/queries.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpkoi-elements-tools.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpkoi-elements-integration.php';

// options for effects
$wtfe_parallax_section 		= get_option( 'wtfe_parallax_section', '' );
$wtfe_element_effects 		= get_option( 'wtfe_element_effects', '' );
$wtfe_particles 			= get_option( 'wtfe_particles', '' );
$wtfe_background_change 	= get_option( 'wtfe_background_change', '' );
$wtfe_sticky_column			= get_option( 'wtfe_sticky_column', '' );

if ( $wtfe_parallax_section != true ) {
	require_once plugin_dir_path( __FILE__ ) . 'elements/parallax-section/parallax-section.php';
}
if ( $wtfe_element_effects  != true ) {
	require_once plugin_dir_path( __FILE__ ) . 'elements/effects/effects.php';
}
if ( $wtfe_particles != true ) {
	require_once plugin_dir_path( __FILE__ ) . 'elements/particles/particles.php';
}
if ( $wtfe_background_change != true ) {
	require_once plugin_dir_path( __FILE__ ) . 'elements/background-change/background-change.php';
}
if ( $wtfe_sticky_column != true ) {
	require_once plugin_dir_path( __FILE__ ) . 'elements/sticky-column/sticky-column.php';
}