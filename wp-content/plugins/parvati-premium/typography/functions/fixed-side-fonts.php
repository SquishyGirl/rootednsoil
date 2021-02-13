<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'parvati_fonts_fixed_side_customizer' ) ) {
	add_action( 'customize_register', 'parvati_fonts_fixed_side_customizer', 1000 );
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
	function parvati_fonts_fixed_side_customizer( $wp_customize ) {

		// Bail if we don't have our defaults function
		if ( ! function_exists( 'parvati_fixed_side_content_customize_register' ) ) {
			return;
		}

		// Get our controls
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Get our defaults
		$defaults = parvati_get_default_fonts();

		// Register our custom controls
		if ( method_exists( $wp_customize,'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Parvati_Pro_Typography_Customize_Control' );
			$wp_customize->register_control_type( 'Parvati_Pro_Range_Slider_Control' );
		}

		// Add our section
		$wp_customize->add_section(
			'fixed_side_font_section',
			array(
				'title' => __( 'Fixed Side Content', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'description' => '',
				'priority' => 51,
				'panel' => 'parvati_typography_panel'
			)
		);

		// Font family
		$wp_customize->add_setting(
			'parvati_settings[font_fixed_side]',
			array(
				'default' => $defaults['font_fixed_side'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		// Category
		$wp_customize->add_setting(
			'font_fixed_side_category',
			array(
				'default' => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		// Variants
		$wp_customize->add_setting(
			'font_fixed_side_variants',
			array(
				'default' => '',
				'sanitize_callback' => 'parvati_premium_sanitize_variants'
			)
		);

		// Font weight
		$wp_customize->add_setting(
			'parvati_settings[fixed_side_font_weight]',
			array(
				'default' => $defaults['fixed_side_font_weight'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		// Font transform
		$wp_customize->add_setting(
			'parvati_settings[fixed_side_font_transform]',
			array(
				'default' => $defaults['fixed_side_font_transform'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key'
			)
		);

		$wp_customize->add_control(
			new Parvati_Pro_Typography_Customize_Control(
				$wp_customize,
				'google_font_site_fixed_side_control',
				array(
					'section' => 'fixed_side_font_section',
					'settings' => array(
						'family' => 'parvati_settings[font_fixed_side]',
						'variant' => 'font_fixed_side_variants',
						'category' => 'font_fixed_side_category',
						'weight' => 'parvati_settings[fixed_side_font_weight]',
						'transform' => 'parvati_settings[fixed_side_font_transform]',
					),
				)
			)
		);

		// Font size
		$wp_customize->add_setting(
			'parvati_settings[fixed_side_font_size]',
			array(
				'default' => $defaults['fixed_side_font_size'],
				'type' => 'option',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			new Parvati_Pro_Range_Slider_Control(
				$wp_customize,
				'parvati_settings[fixed_side_font_size]',
				array(
					'description' => __( 'Font size', 'parvati-premium' ),
					'section' => 'fixed_side_font_section',
					'priority' => 165,
					'settings' => array(
						'desktop' => 'parvati_settings[fixed_side_font_size]',
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
