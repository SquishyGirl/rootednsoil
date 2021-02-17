<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', 'parvati_slideout_typography_customizer', 150 );
/**
 * Adds our WooCommerce color options
 */
function parvati_slideout_typography_customizer( $wp_customize ) {

	// Bail if we don't have our defaults function
	if ( ! function_exists( 'parvati_get_default_fonts' ) ) {
		return;
	}

	// Get our custom controls
	require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

	// Get our defaults
	$defaults = parvati_get_default_fonts();

	// Register our custom control types
	if ( method_exists( $wp_customize,'register_control_type' ) ) {
		$wp_customize->register_control_type( 'Parvati_Pro_Range_Slider_Control' );
		$wp_customize->register_control_type( 'Parvati_Pro_Typography_Customize_Control' );
	}

	// Bail if Menu Plus isn't activated
	if ( ! $wp_customize->get_section( 'menu_plus_slideout_menu' ) ) {
		return;
	}

	$wp_customize->add_section(
		'parvati_slideout_typography',
		array(
			'title' => __( 'Slideout Navigation', 'parvati-premium' ),
			'capability' => 'edit_theme_options',
			'priority' => 52,
			'panel' => 'parvati_typography_panel'
		)
	);

	$wp_customize->add_setting(
		'parvati_settings[slideout_font_weight]',
		array(
			'default' => $defaults['slideout_font_weight'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_key',
			'transport' => 'postMessage'
		)
	);

	// Text transform
	$wp_customize->add_setting(
		'parvati_settings[slideout_font_transform]',
		array(
			'default' => $defaults['slideout_font_transform'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_key',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control(
		new Parvati_Pro_Typography_Customize_Control(
			$wp_customize,
			'slideout_navigation_typography',
			array(
				'section' => 'parvati_slideout_typography',
				'settings' => array(
					'weight' => 'parvati_settings[slideout_font_weight]',
					'transform' => 'parvati_settings[slideout_font_transform]',
				),
			)
		)
	);

	// Font size
	$wp_customize->add_setting(
		'parvati_settings[slideout_font_size]',
		array(
			'default' => $defaults['slideout_font_size'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_setting(
		'parvati_settings[slideout_mobile_font_size]',
		array(
			'default' => $defaults['slideout_mobile_font_size'],
			'type' => 'option',
			'sanitize_callback' => 'parvati_premium_sanitize_empty_absint',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control(
		new Parvati_Pro_Range_Slider_Control(
			$wp_customize,
			'parvati_settings[slideout_font_size]',
			array(
				'description' => __( 'Font size', 'parvati-premium' ),
				'section' => 'parvati_slideout_typography',
				'settings' => array(
					'desktop' => 'parvati_settings[slideout_font_size]',
					'mobile' => 'parvati_settings[slideout_mobile_font_size]',
				),
				'choices' => array(
					'desktop' => array(
						'min' => 10,
						'max' => 80,
						'step' => 1,
						'edit' => true,
						'unit' => 'px',
					),
					'mobile' => array(
						'min' => 10,
						'max' => 80,
						'step' => 1,
						'edit' => true,
						'unit' => 'px',
					),
				),
			)
		)
	);
}
