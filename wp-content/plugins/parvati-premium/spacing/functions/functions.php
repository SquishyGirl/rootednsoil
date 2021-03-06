<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Add any necessary functions
require_once plugin_dir_path( __FILE__ ) . 'migration.php';
require_once plugin_dir_path( __FILE__ ) . 'customizer/secondary-nav-spacing.php';

if ( ! function_exists( 'parvati_spacing_customize_register' ) ) {
	add_action( 'customize_register', 'parvati_spacing_customize_register', 99 );
	/*
	 * Add our spacing Customizer options 
	 */
	function parvati_spacing_customize_register( $wp_customize ) {

		// Bail if we don't have our defaults
		if ( ! function_exists( 'parvati_spacing_get_defaults' ) ) {
			return;
		}

		// Add our controls
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Get our defaults
		$defaults = parvati_spacing_get_defaults();

		// Register our custom control types
		if ( method_exists( $wp_customize,'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Parvati_Pro_Range_Slider_Control' );
			$wp_customize->register_control_type( 'Parvati_Spacing_Control' );
		}

		// Add our Spacing panel
		// This is only used if the Layout panel in the free theme doesn't exist
		if ( class_exists( 'WP_Customize_Panel' ) ) {
			if ( ! $wp_customize->get_panel( 'parvati_spacing_panel' ) ) {
				$wp_customize->add_panel( 'parvati_spacing_panel', array(
					'capability'     => 'edit_theme_options',
					'theme_supports' => '',
					'title'          => __( 'Spacing', 'parvati-premium' ),
					'description'    => __( 'Change the spacing for various elements using pixels.', 'parvati-premium' ),
					'priority'		 => 35
				) );
			}
		}

		require_once plugin_dir_path( __FILE__ ) . 'customizer/top-bar-spacing.php';
		require_once plugin_dir_path( __FILE__ ) . 'customizer/header-spacing.php';
		require_once plugin_dir_path( __FILE__ ) . 'customizer/content-spacing.php';
		require_once plugin_dir_path( __FILE__ ) . 'customizer/fixed-side-spacing.php';
		require_once plugin_dir_path( __FILE__ ) . 'customizer/sidebar-spacing.php';
		require_once plugin_dir_path( __FILE__ ) . 'customizer/navigation-spacing.php';
		require_once plugin_dir_path( __FILE__ ) . 'customizer/footer-spacing.php';

	}
}

if ( ! function_exists( 'parvati_right_sidebar_width' ) ) {
	add_filter( 'parvati_right_sidebar_width', 'parvati_right_sidebar_width' );
	/*
	 * Set our right sidebar width
	 */
	function parvati_right_sidebar_width( $width ) {
		// Bail if we don't have our defaults
		if ( ! function_exists( 'parvati_spacing_get_defaults' ) ) {
			return $width;
		}

		$spacing_settings = wp_parse_args(
			get_option( 'parvati_spacing_settings', array() ),
			parvati_spacing_get_defaults()
		);

		return absint( $spacing_settings['right_sidebar_width'] );
	}
}

if ( ! function_exists( 'parvati_left_sidebar_width' ) ) {
	add_filter( 'parvati_left_sidebar_width', 'parvati_left_sidebar_width' );
	/*
	 * Set our left sidebar width
	 */
	function parvati_left_sidebar_width( $width ) {
		// Bail if we don't have our defaults
		if ( ! function_exists( 'parvati_spacing_get_defaults' ) ) {
			return $width;
		}

		$spacing_settings = wp_parse_args(
			get_option( 'parvati_spacing_settings', array() ),
			parvati_spacing_get_defaults()
		);

		return absint( $spacing_settings['left_sidebar_width'] );
	}
}

if ( ! function_exists( 'parvati_spacing_customizer_live_preview' ) ) {
	add_action( 'customize_preview_init', 'parvati_spacing_customizer_live_preview' );
	/*
	 * Add our live preview JS
	 */
	function parvati_spacing_customizer_live_preview() {
		wp_enqueue_script(
			  'parvati-spacing-customizer',
			  trailingslashit( plugin_dir_url( __FILE__ ) ) . 'customizer/js/customizer.js',
			  array( 'jquery','customize-preview' ),
			  PARVATI_SPACING_VERSION,
			  true
		);

		wp_localize_script( 'parvati-spacing-customizer', 'gp_spacing', array(
			'mobile' => apply_filters( 'parvati_mobile_media_query', '(max-width:768px)' ),
			'tablet' => apply_filters( 'parvati_tablet_media_query', '(min-width: 769px) and (max-width: 1024px)' ),
			'desktop' => apply_filters( 'parvati_desktop_media_query', '(min-width:1025px)' ),
		) );
	}
}

if ( ! function_exists( 'parvati_include_spacing_defaults' ) ) {
	/**
	 * Check if we should include our default.css file 
	 */
	function parvati_include_spacing_defaults() {
		return true;
	}
}

if ( ! function_exists( 'parvati_spacing_premium_css' ) ) {
	add_filter( 'parvati_spacing_css_output', 'parvati_spacing_premium_css' );
	/**
	 * Add premium spacing CSS
	 *
	 */
	function parvati_spacing_premium_css( $css ) {

		// Bail if we don't have our defaults
		if ( ! function_exists( 'parvati_spacing_get_defaults' ) ) {
			return $css;
		}

		$spacing_settings = wp_parse_args(
			get_option( 'parvati_spacing_settings', array() ),
			parvati_spacing_get_defaults()
		);

		require_once PARVATI_LIBRARY_DIRECTORY . 'class-make-css.php';
		$premium_css = new Parvati_Pro_CSS;

		// Mobile spacing
		$premium_css->start_media_query( apply_filters( 'parvati_mobile_media_query', '(max-width:768px)' ) );

			if ( '' !== $spacing_settings[ 'mobile_menu_item' ] ) {
				$premium_css->set_selector( '.main-navigation .main-nav ul li a,.menu-toggle,.main-navigation .mobile-bar-items a' );
				$premium_css->add_property( 'padding-left', absint( $spacing_settings['mobile_menu_item'] ), false, 'px' );
				$premium_css->add_property( 'padding-right', absint( $spacing_settings['mobile_menu_item'] ), false, 'px' );

				$premium_css->set_selector( '.menu-item-has-children .dropdown-menu-toggle' );
				if ( is_rtl() ) {
					$premium_css->add_property( 'padding-left', absint( $spacing_settings[ 'mobile_menu_item' ] ), false, 'px' );
				} else {
					$premium_css->add_property( 'padding-right', absint( $spacing_settings[ 'mobile_menu_item' ] ), false, 'px' );
				}

				if ( is_rtl() ) {
					$premium_css->set_selector( '.main-navigation .main-nav ul li.menu-item-has-children > a' );
					$premium_css->add_property( 'padding-right', absint( $spacing_settings[ 'mobile_menu_item' ] ), false, 'px' );
				}

				$premium_css->set_selector( '.main-navigation .main-nav ul ul li a' );
				$premium_css->add_property( 'padding-left', absint( $spacing_settings['mobile_menu_item'] ), false, 'px' );
				$premium_css->add_property( 'padding-right', absint( $spacing_settings['mobile_menu_item'] ), false, 'px' );
			}

			if ( '' !== $spacing_settings[ 'mobile_menu_item_height' ] ) {
				$premium_css->set_selector( '.main-navigation .main-nav ul li a,.menu-toggle,.main-navigation .mobile-bar-items a' );
				$premium_css->add_property( 'line-height', absint( $spacing_settings['mobile_menu_item_height'] ), false, 'px' );
				$premium_css->set_selector( '.main-navigation .site-logo.navigation-logo img, .mobile-header-navigation .site-logo.mobile-header-logo img' );
				$premium_css->add_property( 'height', absint( $spacing_settings['mobile_menu_item_height'] ), false, 'px' );
			}

		$premium_css->stop_media_query();

		if ( ( function_exists( 'parvati_menu_plus_get_defaults' ) ) && ( function_exists( 'parvati_menu_plus_customize_register' ) ) ) {
			$menu_plus = wp_parse_args(
				get_option( 'parvati_menu_plus_settings', array() ),
				parvati_menu_plus_get_defaults()
			);

			if ( 'false' !== $menu_plus[ 'sticky_menu' ] && '' !== $spacing_settings[ 'sticky_menu_item_height' ] ) {
				$premium_css->start_media_query( apply_filters( 'parvati_tablet_media_query', '(min-width: 769px) and (max-width: 1024px)' ) . ',' . apply_filters( 'parvati_desktop_media_query', '(min-width:1025px)' ) );

					$premium_css->set_selector( '.main-navigation.sticky-navigation-transition .main-nav > ul > li > a,.sticky-navigation-transition .menu-toggle,.main-navigation.sticky-navigation-transition .mobile-bar-items a' );
					$premium_css->add_property( 'line-height', absint( $spacing_settings[ 'sticky_menu_item_height' ] ), false, 'px' );

					$premium_css->set_selector( '.main-navigation.sticky-navigation-transition .navigation-logo img' );
					$premium_css->add_property( 'height', absint( $spacing_settings[ 'sticky_menu_item_height' ] ), false, 'px' );

				$premium_css->stop_media_query();
			}

			if ( 'false' !== $menu_plus[ 'slideout_menu' ] ) {
				$premium_css->set_selector( '.main-navigation.slideout-navigation .main-nav > ul > li > a' );
				if ( '' !== $spacing_settings['off_canvas_menu_item_height'] ) {
					$premium_css->add_property( 'line-height', absint( $spacing_settings['off_canvas_menu_item_height'] ), false, 'px' );
				}
			}
		}

		// Added in here for now until 1.4 is released
		$premium_css->set_selector( '.navigation-search, .navigation-search input' );
		$premium_css->add_property( 'height', '100%' );

		return $css . $premium_css->css_output();
	}
}
