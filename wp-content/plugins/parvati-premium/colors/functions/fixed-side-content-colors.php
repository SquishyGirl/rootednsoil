<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please
}

if ( ! function_exists( 'parvati_colors_fixed_side_content_customizer' ) ) {
	add_action( 'customize_register', 'parvati_colors_fixed_side_content_customizer', 1000 );
	/**
	 * Adds our Secondary Nav color options
	 *
	 * These options are in their own function so we can hook it in late to
	 * make sure Secondary Nav is activated.
	 *
	 * 1000 priority is there to make sure Secondary Nav is registered (999)
	 * as we check to see if the layout control exists.
	 *
	 * Secondary Nav now uses 100 as a priority.
	 */
	function parvati_colors_fixed_side_content_customizer( $wp_customize ) {

		// Bail if we don't have our color defaults
		if ( ! function_exists( 'parvati_fixed_side_content_customize_register' ) ) {
			return;
		}

		// Add our controls
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Get our defaults
		$defaults = parvati_get_color_defaults();

		// Add control types so controls can be built using JS
		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Parvati_Alpha_Color_Customize_Control' );
			$wp_customize->register_control_type( 'Parvati_Title_Customize_Control' );
		}

		// Get our palettes
		$palettes = parvati_get_default_color_palettes();

		// Add Secondary Navigation section
		$wp_customize->add_section(
			'fixed_side_content_color_section',
			array(
				'title' => __( 'Fixed Side Content', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 71,
				'panel' => 'parvati_colors_panel',
			)
		);

		// Background
		$wp_customize->add_setting(
			'parvati_settings[fixed_side_content_background_color]', array(
				'default' => $defaults['fixed_side_content_background_color'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba'
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'fixed_side_content_background_color',
				array(
					'label' => __( 'Background', 'parvati-premium' ),
					'section' => 'fixed_side_content_color_section',
					'settings' => 'parvati_settings[fixed_side_content_background_color]',
					'palette'   => $palettes,
				)
			)
		);

		// Text
		$wp_customize->add_setting(
			'parvati_settings[fixed_side_content_text_color]', array(
				'default' => $defaults['fixed_side_content_text_color'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fixed_side_content_text_color',
				array(
					'label' => __( 'Text', 'parvati-premium' ),
					'section' => 'fixed_side_content_color_section',
					'settings' => 'parvati_settings[fixed_side_content_text_color]',
				)
			)
		);

		// Link
		$wp_customize->add_setting(
			'parvati_settings[fixed_side_content_link_color]', array(
				'default' => $defaults['fixed_side_content_link_color'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'fixed_side_content_link_color',
				array(
					'label' => __( 'Link', 'parvati-premium' ),
					'section' => 'fixed_side_content_color_section',
					'settings' => 'parvati_settings[fixed_side_content_link_color]',
					'palette'   => $palettes,
				)
			)
		);

		// Link hover
		$wp_customize->add_setting(
			'parvati_settings[fixed_side_content_link_hover_color]', array(
				'default' => $defaults['fixed_side_content_link_hover_color'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'fixed_side_content_link_hover_color',
				array(
					'label' => __( 'Text Hover', 'parvati-premium' ),
					'section' => 'fixed_side_content_color_section',
					'settings' => 'parvati_settings[fixed_side_content_link_hover_color]',
				)
			)
		);
	}
}
