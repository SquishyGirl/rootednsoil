<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'parvati_smooth_scroll_scripts' );
/**
 * Add the smooth scroll script if enabled.
 *
 */
function parvati_smooth_scroll_scripts() {
	if ( ! function_exists( 'parvati_get_defaults' ) ) {
		return;
	}

	$settings = wp_parse_args(
		get_option( 'parvati_settings', array() ),
		parvati_get_defaults()
	);

	if ( ! $settings['smooth_scroll'] ) {
		return;
	}

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'parvati-smooth-scroll', plugin_dir_url( __FILE__ ) . "js/smooth-scroll{$suffix}.js", array(), PARVATI_PREMIUM_VERSION, true );

	wp_localize_script(
		'parvati-smooth-scroll',
		'smooth',
		array(
			'duration' => apply_filters( 'parvati_smooth_scroll_duration', 800 )
		)
	);
}

add_filter( 'parvati_option_defaults', 'parvati_smooth_scroll_default' );
/**
 * Add the smooth scroll option to our defaults.
 *
 *
 * @param array $defaults Existing defaults.
 * @return array New defaults.
 */
function parvati_smooth_scroll_default( $defaults ) {
	$defaults['smooth_scroll'] = false;

	return $defaults;
}

add_action( 'customize_register', 'parvati_smooth_scroll_customizer', 99 );
/**
 * Add our smooth scroll option to the Customizer.
 *
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function parvati_smooth_scroll_customizer( $wp_customize ) {
	if ( ! function_exists( 'parvati_get_defaults' ) ) {
		return;
	}

	$defaults = parvati_get_defaults();

	require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

	$wp_customize->add_setting(
		'parvati_settings[smooth_scroll]',
		array(
			'default' => $defaults['smooth_scroll'],
			'type' => 'option',
			'sanitize_callback' => 'parvati_premium_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'parvati_settings[smooth_scroll]',
		array(
			'type' => 'checkbox',
			'label' => __( 'Smooth scroll', 'parvati-premium' ),
			'description' => __( 'Initiate smooth scroll on anchor links using the <code>smooth-scroll</code> class.', 'parvati-premium' ),
			'section' => 'parvati_general_section',
		)
	);
}
