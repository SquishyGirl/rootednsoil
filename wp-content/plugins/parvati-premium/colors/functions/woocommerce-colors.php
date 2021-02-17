<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'parvati_colors_wc_customizer' ) ) {
	add_action( 'customize_register', 'parvati_colors_wc_customizer', 100 );
	/**
	 * Adds our WooCommerce color options
	 */
	function parvati_colors_wc_customizer( $wp_customize ) {
		// Bail if WooCommerce isn't activated
		if ( ! $wp_customize->get_section( 'parvati_woocommerce_colors' ) ) {
			return;
		}

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

		$wp_customize->add_setting(
			'parvati_settings[wc_product_title_color]', array(
				'default' => $defaults['wc_product_title_color'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_product_title_color]',
				array(
					'label' => __( 'Product Title', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_product_title_color]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_product_title_color_hover]', array(
				'default' => $defaults['wc_product_title_color_hover'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_product_title_color_hover]',
				array(
					'label' => __( 'Product Title Hover', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_product_title_color_hover]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_alt_button_background]',
			array(
				'default'     => $defaults['wc_alt_button_background'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[wc_alt_button_background]',
				array(
					'label'     => __( 'Alt Button Background', 'parvati-premium' ),
					'section'   => 'parvati_woocommerce_colors',
					'settings'  => 'parvati_settings[wc_alt_button_background]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_alt_button_background_hover]',
			array(
				'default'     => $defaults['wc_alt_button_background_hover'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[wc_alt_button_background_hover]',
				array(
					'label'     => __( 'Alt Button Background Hover', 'parvati-premium' ),
					'section'   => 'parvati_woocommerce_colors',
					'settings'  => 'parvati_settings[wc_alt_button_background_hover]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_alt_button_text]', array(
				'default' => $defaults['wc_alt_button_text'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_alt_button_text]',
				array(
					'label' => __( 'Alt Button Text', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_alt_button_text]',
				)
			)
		);


		$wp_customize->add_setting(
			'parvati_settings[wc_alt_button_text_hover]', array(
				'default' => $defaults['wc_alt_button_text_hover'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_alt_button_text_hover]',
				array(
					'label' => __( 'Alt Button Text Hover', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_alt_button_text_hover]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_rating_stars]',
			array(
				'default'     => $defaults['wc_rating_stars'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => '',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[wc_rating_stars]',
				array(
					'label'     => __( 'Star Ratings', 'parvati-premium' ),
					'section'   => 'parvati_woocommerce_colors',
					'settings'  => 'parvati_settings[wc_rating_stars]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_sale_sticker_background]',
			array(
				'default'     => $defaults['wc_sale_sticker_background'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[wc_sale_sticker_background]',
				array(
					'label'     => __( 'Sale Sticker Background', 'parvati-premium' ),
					'section'   => 'parvati_woocommerce_colors',
					'settings'  => 'parvati_settings[wc_sale_sticker_background]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_sale_sticker_text]', array(
				'default' => $defaults['wc_sale_sticker_text'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_sale_sticker_text]',
				array(
					'label' => __( 'Sale Sticker Text', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_sale_sticker_text]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_price_color]', array(
				'default' => $defaults['wc_price_color'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_price_color]',
				array(
					'label' => __( 'Price', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_price_color]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_product_tab]', array(
				'default' => $defaults['wc_product_tab'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_product_tab]',
				array(
					'label' => __( 'Product Tab Text', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_product_tab]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_product_tab_highlight]', array(
				'default' => $defaults['wc_product_tab_highlight'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_product_tab_highlight]',
				array(
					'label' => __( 'Product Tab Active', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_product_tab_highlight]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_success_message_background]',
			array(
				'default'     => $defaults['wc_success_message_background'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[wc_success_message_background]',
				array(
					'label'     => __( 'Success Message Background', 'parvati-premium' ),
					'section'   => 'parvati_woocommerce_colors',
					'settings'  => 'parvati_settings[wc_success_message_background]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_success_message_text]', array(
				'default' => $defaults['wc_success_message_text'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_success_message_text]',
				array(
					'label' => __( 'Success Message Text', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_success_message_text]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_info_message_background]',
			array(
				'default'     => $defaults['wc_info_message_background'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[wc_info_message_background]',
				array(
					'label'     => __( 'Info Message Background', 'parvati-premium' ),
					'section'   => 'parvati_woocommerce_colors',
					'settings'  => 'parvati_settings[wc_info_message_background]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_info_message_text]', array(
				'default' => $defaults['wc_info_message_text'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_info_message_text]',
				array(
					'label' => __( 'Info Message Text', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_info_message_text]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_error_message_background]',
			array(
				'default'     => $defaults['wc_error_message_background'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[wc_error_message_background]',
				array(
					'label'     => __( 'Error Message Background', 'parvati-premium' ),
					'section'   => 'parvati_woocommerce_colors',
					'settings'  => 'parvati_settings[wc_error_message_background]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[wc_error_message_text]', array(
				'default' => $defaults['wc_error_message_text'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'parvati_settings[wc_error_message_text]',
				array(
					'label' => __( 'Error Message Text', 'parvati-premium' ),
					'section' => 'parvati_woocommerce_colors',
					'settings' => 'parvati_settings[wc_error_message_text]',
				)
			)
		);

	}
}
