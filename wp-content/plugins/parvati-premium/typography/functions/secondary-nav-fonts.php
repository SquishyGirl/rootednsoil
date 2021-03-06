<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'parvati_fonts_secondary_nav_customizer' ) ) {
	add_action( 'customize_register', 'parvati_fonts_secondary_nav_customizer', 1000 );
	/**
	 * Adds our Secondary Nav typography options
	 *
	 * These options are in their own function so we can hook it in late to
	 * make sure Secondary Nav is activated.
	 *
	 * 1000 priority is there to make sure Secondary Nav is registered (999)
	 * as we check to see if the layout control exists.
	 *
	 * Secondary Nav now uses 100 as a priority.
	 */
	function parvati_fonts_secondary_nav_customizer( $wp_customize ) {

		// Bail if we don't have our defaults function
		if ( ! function_exists( 'parvati_secondary_nav_get_defaults' ) ) {
			return;
		}

		// Make sure Secondary Nav is activated
		if ( ! $wp_customize->get_section( 'secondary_nav_section' ) ) {
			return;
		}

		// Get our controls
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Get our defaults
		$defaults = parvati_secondary_nav_get_defaults();

		// Register our custom controls
		if ( method_exists( $wp_customize,'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Parvati_Pro_Typography_Customize_Control' );
			$wp_customize->register_control_type( 'Parvati_Pro_Range_Slider_Control' );
		}

		// Add our section
		$wp_customize->add_section(
			'secondary_font_section',
			array(
				'title' => __( 'Secondary Navigation', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'description' => '',
				'priority' => 51,
				'panel' => 'parvati_typography_panel'
			)
		);

		// Font family
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[font_secondary_navigation]',
			array(
				'default' => $defaults['font_secondary_navigation'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		// Category
		$wp_customize->add_setting(
			'font_secondary_navigation_category',
			array(
				'default' => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		// Variants
		$wp_customize->add_setting(
			'font_secondary_navigation_variants',
			array(
				'default' => '',
				'sanitize_callback' => 'parvati_premium_sanitize_variants'
			)
		);

		// Font weight
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[secondary_navigation_font_weight]',
			array(
				'default' => $defaults['secondary_navigation_font_weight'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
				'transport' => 'postMessage'
			)
		);

		// Font transform
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[secondary_navigation_font_transform]',
			array(
				'default' => $defaults['secondary_navigation_font_transform'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
				'transport' => 'postMessage'
			)
		);

		$wp_customize->add_control(
			new Parvati_Pro_Typography_Customize_Control(
				$wp_customize,
				'google_font_site_secondary_navigation_control',
				array(
					'section' => 'secondary_font_section',
					'settings' => array(
						'family' => 'parvati_secondary_nav_settings[font_secondary_navigation]',
						'variant' => 'font_secondary_navigation_variants',
						'category' => 'font_secondary_navigation_category',
						'weight' => 'parvati_secondary_nav_settings[secondary_navigation_font_weight]',
						'transform' => 'parvati_secondary_nav_settings[secondary_navigation_font_transform]',
					),
				)
			)
		);

		// Font size
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[secondary_navigation_font_size]',
			array(
				'default' => $defaults['secondary_navigation_font_size'],
				'type' => 'option',
				'sanitize_callback' => 'absint',
				'transport' => 'postMessage'
			)
		);

		$wp_customize->add_control(
			new Parvati_Pro_Range_Slider_Control(
				$wp_customize,
				'parvati_secondary_nav_settings[secondary_navigation_font_size]',
				array(
					'description' => __( 'Font size', 'parvati-premium' ),
					'section' => 'secondary_font_section',
					'priority' => 165,
					'settings' => array(
						'desktop' => 'parvati_secondary_nav_settings[secondary_navigation_font_size]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 6,
							'max' => 30,
							'step' => 1,
							'edit' => true,
							'unit' => 'px',
						),
					),
				)
			)
		);
	}
}
