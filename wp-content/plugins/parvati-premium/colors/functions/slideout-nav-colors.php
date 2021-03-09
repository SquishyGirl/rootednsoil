<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please
}

add_action( 'customize_preview_init', 'parvati_menu_plus_live_preview_scripts', 20 );
function parvati_menu_plus_live_preview_scripts() {
	wp_enqueue_script( 'parvati-menu-plus-colors-customizer' );
}

add_action( 'customize_register', 'parvati_slideout_navigation_color_controls', 150 );
/**
 * Adds our Slideout Nav color options
 *
 */
function parvati_slideout_navigation_color_controls( $wp_customize ) {
	// Bail if Secondary Nav isn't activated
	if ( ! $wp_customize->get_section( 'menu_plus_slideout_menu' ) ) {
		return;
	}

	// Bail if we don't have our color defaults
	if ( ! function_exists( 'parvati_get_color_defaults' ) ) {
		return;
	}

	// Add our controls
	require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

	// Get our defaults
	$defaults = parvati_get_color_defaults();

	// Add control types so controls can be built using JS
	if ( method_exists( $wp_customize, 'register_control_type' ) ) {
		$wp_customize->register_control_type( 'Parvati_Alpha_Color_Customize_Control' );
	}

	// Get our palettes
	$palettes = parvati_get_default_color_palettes();

	// Add Secondary Navigation section
	$wp_customize->add_section(
		'slideout_color_section',
		array(
			'title' => __( 'Slideout Navigation', 'parvati-premium' ),
			'capability' => 'edit_theme_options',
			'priority' => 73,
			'panel' => 'parvati_colors_panel',
		)
	);

	$wp_customize->add_control(
		new Parvati_Title_Customize_Control(
			$wp_customize,
			'parvati_slideout_navigation_items',
			array(
				'section'     => 'slideout_color_section',
				'type'        => 'parvati-customizer-title',
				'title'			=> __( 'Parent Items', 'parvati-premium' ),
				'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
			)
		)
	);

	// Background
	$wp_customize->add_setting(
		'parvati_settings[slideout_background_color]', array(
			'default' => $defaults['slideout_background_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_rgba'
		)
	);

	$wp_customize->add_control(
		new Parvati_Alpha_Color_Customize_Control(
			$wp_customize,
			'parvati_settings[slideout_background_color]',
			array(
				'label' => __( 'Background', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_background_color]',
				'palette'   => $palettes,
			)
		)
	);

	// Text
	$wp_customize->add_setting(
		'parvati_settings[slideout_text_color]', array(
			'default' => $defaults['slideout_text_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parvati_settings[slideout_text_color]',
			array(
				'label' => __( 'Text', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_text_color]',
			)
		)
	);

	// Background hover
	$wp_customize->add_setting(
		'parvati_settings[slideout_background_hover_color]', array(
			'default' => $defaults['slideout_background_hover_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_rgba'
		)
	);

	$wp_customize->add_control(
		new Parvati_Alpha_Color_Customize_Control(
			$wp_customize,
			'parvati_settings[slideout_background_hover_color]',
			array(
				'label' => __( 'Background Hover', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_background_hover_color]',
				'palette'   => $palettes,
			)
		)
	);

	// Text hover
	$wp_customize->add_setting(
		'parvati_settings[slideout_text_hover_color]', array(
			'default' => $defaults['slideout_text_hover_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parvati_settings[slideout_text_hover_color]',
			array(
				'label' => __( 'Text Hover', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_text_hover_color]',
			)
		)
	);

	// Background current
	$wp_customize->add_setting(
		'parvati_settings[slideout_background_current_color]', array(
			'default' => $defaults['slideout_background_current_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_rgba'
		)
	);

	$wp_customize->add_control(
		new Parvati_Alpha_Color_Customize_Control(
			$wp_customize,
			'parvati_settings[slideout_background_current_color]',
			array(
				'label' => __( 'Background Current', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_background_current_color]',
				'palette'   => $palettes,
			)
		)
	);

	// Text current
	$wp_customize->add_setting(
		'parvati_settings[slideout_text_current_color]', array(
			'default' => $defaults['slideout_text_current_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parvati_settings[slideout_text_current_color]',
			array(
				'label' => __( 'Text Current', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_text_current_color]',
			)
		)
	);

	$wp_customize->add_control(
		new Parvati_Title_Customize_Control(
			$wp_customize,
			'parvati_slideout_navigation_sub_menu_items',
			array(
				'section'     => 'slideout_color_section',
				'type'        => 'parvati-customizer-title',
				'title'			=> __( 'Sub-Menu Items', 'parvati-premium' ),
				'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
			)
		)
	);

	// Background
	$wp_customize->add_setting(
		'parvati_settings[slideout_submenu_background_color]', array(
			'default' => $defaults['slideout_submenu_background_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_rgba'
		)
	);

	$wp_customize->add_control(
		new Parvati_Alpha_Color_Customize_Control(
			$wp_customize,
			'parvati_settings[slideout_submenu_background_color]',
			array(
				'label' => __( 'Background', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_submenu_background_color]',
				'palette'   => $palettes,
			)
		)
	);

	// Text
	$wp_customize->add_setting(
		'parvati_settings[slideout_submenu_text_color]', array(
			'default' => $defaults['slideout_submenu_text_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parvati_settings[slideout_submenu_text_color]',
			array(
				'label' => __( 'Text', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_submenu_text_color]',
			)
		)
	);

	// Background hover
	$wp_customize->add_setting(
		'parvati_settings[slideout_submenu_background_hover_color]', array(
			'default' => $defaults['slideout_submenu_background_hover_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_rgba'
		)
	);

	$wp_customize->add_control(
		new Parvati_Alpha_Color_Customize_Control(
			$wp_customize,
			'parvati_settings[slideout_submenu_background_hover_color]',
			array(
				'label' => __( 'Background Hover', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_submenu_background_hover_color]',
				'palette'   => $palettes,
			)
		)
	);

	// Text hover
	$wp_customize->add_setting(
		'parvati_settings[slideout_submenu_text_hover_color]', array(
			'default' => $defaults['slideout_submenu_text_hover_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parvati_settings[slideout_submenu_text_hover_color]',
			array(
				'label' => __( 'Text Hover', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_submenu_text_hover_color]',
			)
		)
	);

	// Background current
	$wp_customize->add_setting(
		'parvati_settings[slideout_submenu_background_current_color]', array(
			'default' => $defaults['slideout_submenu_background_current_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_rgba'
		)
	);

	$wp_customize->add_control(
		new Parvati_Alpha_Color_Customize_Control(
			$wp_customize,
			'parvati_settings[slideout_submenu_background_current_color]',
			array(
				'label' => __( 'Background Current', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_submenu_background_current_color]',
				'palette'   => $palettes,
			)
		)
	);

	// Text current
	$wp_customize->add_setting(
		'parvati_settings[slideout_submenu_text_current_color]', array(
			'default' => $defaults['slideout_submenu_text_current_color'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'parvati_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'parvati_settings[slideout_submenu_text_current_color]',
			array(
				'label' => __( 'Text Current', 'parvati-premium' ),
				'section' => 'slideout_color_section',
				'settings' => 'parvati_settings[slideout_submenu_text_current_color]',
			)
		)
	);
}
