<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'parvati_copyright_customize_register' ) ) {
	add_action( 'customize_register', 'parvati_copyright_customize_register' );
	/**
	 * Add our copyright options to the Customizer
	 */
	function parvati_copyright_customize_register( $wp_customize ) {
		// Get our custom control
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Register our custom control
		if ( method_exists( $wp_customize,'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Parvati_Copyright_Customize_Control' );
		}

		// Copyright
		$wp_customize->add_setting(
			'parvati_copyright',
			array(
				'default' => '',
				'type' => 'theme_mod',
				'sanitize_callback' => 'wp_kses_post'
			)
		);

		$wp_customize->add_control(
			new Parvati_Copyright_Customize_Control(
			$wp_customize,
			'parvati_copyright',
			array(
				'label'      => __( 'Copyright', 'parvati-premium' ),
				'section'    => 'parvati_layout_footer',
				'settings'   => 'parvati_copyright',
				'priority' => 500,
			) )
		);

		// Initiate selective refresh
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'parvati_copyright', array(
				'selector' => '.copyright-bar',
				'settings' => array( 'parvati_copyright' ),
				'render_callback' => 'parvati_copyright_selective_refresh',
			) );
		}
	}
}

if ( ! function_exists( 'parvati_copyright_selective_refresh' ) ) {
	/**
	 * Return our copyright on selective refresh
	 */
	function parvati_copyright_selective_refresh() {
		$options = array(
			'%current_year%',
			'%copy%'
		);

		$replace = array(
			date('Y'),
			'&copy;'
		);

		$new_copyright = get_theme_mod( 'parvati_copyright' );
		$new_copyright = str_replace( $options, $replace, get_theme_mod( 'parvati_copyright' ) );

		return do_shortcode( $new_copyright );
	}
}

if ( ! function_exists( 'parvati_copyright_remove_default' ) ) {
	add_action( 'wp', 'parvati_copyright_remove_default' );
	/**
	 * Remove the default copyright
	 */
	function parvati_copyright_remove_default() {

		if ( get_theme_mod( 'parvati_copyright' ) && '' !== get_theme_mod( 'parvati_copyright' ) ) {
			remove_action( 'parvati_credits', 'parvati_add_footer_info' );
		}
	}
}

if ( ! function_exists( 'parvati_copyright_add_custom' ) ) {
	add_action( 'parvati_credits', 'parvati_copyright_add_custom' );
	/**
	 * Add the custom copyright
	 */
	function parvati_copyright_add_custom() {
		$options = array(
			'%current_year%',
			'%copy%'
		);

		$replace = array(
			date('Y'),
			'&copy;'
		);

		$new_copyright = get_theme_mod( 'parvati_copyright' );
		$new_copyright = str_replace( $options, $replace, get_theme_mod( 'parvati_copyright' ) );

		if ( get_theme_mod( 'parvati_copyright' ) && '' !== get_theme_mod( 'parvati_copyright' ) ) {
			echo do_shortcode( $new_copyright );
		}
	}
}

if ( ! function_exists( 'parvati_apply_custom_copyright' ) ) {
	add_filter( 'parvati_copyright', 'parvati_apply_custom_copyright' );
	/**
	 * Add the custom copyright
	 */
	function parvati_apply_custom_copyright( $copyright ) {

		$options = array(
			'%current_year%',
			'%copy%'
		);

		$replace = array(
			date('Y'),
			'&copy;'
		);

		$new_copyright = get_theme_mod( 'parvati_copyright' );
		$new_copyright = str_replace( $options, $replace, get_theme_mod( 'parvati_copyright' ) );

		if ( get_theme_mod( 'parvati_copyright' ) && '' !== get_theme_mod( 'parvati_copyright' ) ) {
			return do_shortcode( $new_copyright );
		}

		return $copyright;

	}
}

if ( ! function_exists( 'parvati_update_copyright' ) ) {
	add_action( 'admin_init', 'parvati_update_copyright' );
	/**
	 * Our copyright use to have it's own setting
	 * If we have the old setting, move it into our theme_mod
	 */
	function parvati_update_copyright() {
		// If we already have a custom logo, bail.
		if ( get_theme_mod( 'parvati_copyright' ) ) {
			return;
		}

		// Get the old logo value.
		$old_value = get_option( 'parvati_p_custom_copyright' );

		// If there's no old value, bail.
		if ( empty( $old_value ) ) {
			return;
		}

		// Now let's update the new logo setting with our ID.
		set_theme_mod( 'parvati_copyright', $old_value );

		// Got our custom logo? Time to delete the old value
		if ( get_theme_mod( 'parvati_copyright' ) ) {
			delete_option( 'parvati_p_custom_copyright' );
		}
	}
}
