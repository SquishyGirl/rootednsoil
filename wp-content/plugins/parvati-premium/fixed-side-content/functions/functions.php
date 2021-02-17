<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'parvati_fixed_side_content_customize_register' ) ) {
	add_action( 'customize_register', 'parvati_fixed_side_content_customize_register', 100 );
	/**
	 * Register our options.
	 *
	 */
	function parvati_fixed_side_content_customize_register( $wp_customize ) {
		// Get our defaults
		$defaults = parvati_fixed_side_content_get_defaults();

		// Controls
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';
		
		// Auto hide on scroll down
		$wp_customize->add_setting(
			'parvati_fixed_side_settings[fixed_side_display_mobile]',
			array(
				'default' => $defaults['fixed_side_display_mobile'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'parvati_fixed_side_settings[fixed_side_display_mobile]',
			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Display on mobile', 'parvati-premium' ),
				'section' => 'parvati_layout_sidecontent',
				'settings' => 'parvati_fixed_side_settings[fixed_side_display_mobile]',
				'priority' => 120
			)
		);
	}
}

if ( ! function_exists( 'parvati_fixed_side_body_classes' ) ) {
	add_filter( 'body_class', 'parvati_fixed_side_body_classes' );
	/**
	 * Adds custom classes to body
	 *
	 */
	function parvati_fixed_side_body_classes( $classes ) {
		$settings = wp_parse_args(
			get_option( 'parvati_fixed_side_settings', array() ),
			parvati_fixed_side_content_get_defaults()
		);

		// Slide-out menu classes
		if ( $settings['fixed_side_display_mobile'] == true ) {
			$classes[] = 'fixed-side-mobile';
		}

		return $classes;

	}
}
