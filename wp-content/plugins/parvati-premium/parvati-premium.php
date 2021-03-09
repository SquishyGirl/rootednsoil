<?php
/*
Plugin Name: Parvati Premium
Plugin URI: https://wpkoi.com
Description: The entire collection of Parvati premium modules.
Version: 2.3.0
Author: WPKoi
Author URI: https://wpkoi.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: parvati-premium
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Set our version
define( 'PARVATI_PREMIUM_VERSION', '2.3.0' );

// Set our root directory
define( 'PARVATI_LIBRARY_DIRECTORY', plugin_dir_path( __FILE__ ) . 'library/' );
define( 'PARVATI_PREMIUM_URL', plugins_url( '/', __FILE__ ) );



if ( ! function_exists( 'parvati_premium_theme_information' ) ) {
	add_action( 'admin_notices', 'parvati_premium_theme_information' );
	/**
	 * Checks whether there's a theme update available and lets you know.
	 * Also checks to see if Parvati is the active theme. If not, tell them.
	 *
	 **/
	function parvati_premium_theme_information() {

		// Get our theme data
		$theme = wp_get_theme();

		// If we're using Parvati
		if ( 'Parvati' != $theme->name ) {
			if ( 'parvati' != $theme->template ) {
				// Parvati isn't the active theme, let them know Parvati Premium won't work.
				printf(
					'<div class="notice is-dismissible notice-warning">
						<p>%1$s <a href="https://wpkoi.com/" target="_blank">%2$s</a></p>
					</div>',
					esc_html__( 'Parvati Premium requires Parvati to be your active theme or parent theme.', 'parvati-premium' ),
					esc_html__( 'Install now.', 'parvati-premium' )
				);
			}
		}
	}
}

// Features only work with Parvati theme.
$activetheme = wp_get_theme();
if ( 'Parvati' != $activetheme->name ) {
	if ( 'parvati' != $activetheme->template ) {
		return;
	}
}

if ( ! function_exists( 'parvati_is_module_active' ) ) {
	/**
	 * Check to see if an add-ons is active
	 * module: Check the database entry
	 * definition: Check to see if defined in wp-config.php
	 **/
	function parvati_is_module_active( $module, $definition ) {
		// If we don't have the module or definition, bail.
		if ( ! $module && ! $definition ) {
			return false;
		}

		// If our module is active, return true.
		if ( 'activated' == get_option( $module ) || defined( $definition ) ) {
			return true;
		}

		// Not active? Return false.
		return false;
	}
}

if ( ! function_exists( 'parvati_package_setup' ) ) {
	add_action( 'plugins_loaded', 'parvati_package_setup' );
	/**
	 * Set up our translations
	 **/
	function parvati_package_setup() {
		load_plugin_textdomain( 'parvati-premium', false, 'parvati-premium/langs/' );
	}
}

// Default functions
require_once plugin_dir_path( __FILE__ ) . 'inc/defaults.php';

// Backgrounds
if ( parvati_is_module_active( 'parvati_package_backgrounds', 'PARVATI_BACKGROUNDS' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'backgrounds/backgrounds.php';
}

// Blog
if ( parvati_is_module_active( 'parvati_package_blog', 'PARVATI_BLOG' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'blog/blog.php';
}

// Colors
if ( parvati_is_module_active( 'parvati_package_colors', 'PARVATI_COLORS' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'colors/colors.php';
}

// Copyright
if ( parvati_is_module_active( 'parvati_package_copyright', 'PARVATI_COPYRIGHT' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'copyright/copyright.php';
}

// Disable Elements
if ( parvati_is_module_active( 'parvati_package_disable_elements', 'PARVATI_DISABLE_ELEMENTS' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'disable-elements/disable-elements.php';
}

// Demo Import
if ( parvati_is_module_active( 'parvati_package_demo_import', 'PARVATI_DEMO_IMPORT' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'demo-import/class-tgm-plugin-activation.php';
	require_once plugin_dir_path( __FILE__ ) . 'demo-import/functions.php';
}

// Hooks
if ( parvati_is_module_active( 'parvati_package_hooks', 'PARVATI_HOOKS' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'hooks/hooks.php';
}

// Page Header
if ( parvati_is_module_active( 'parvati_package_page_header', 'PARVATI_PAGE_HEADER' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'page-header/page-header.php';
}

// Fixed Side Content
if ( parvati_is_module_active( 'parvati_package_fixed_side_content', 'PARVATI_FIXED_SIDE_CONTENT' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'fixed-side-content/fixed-side-content.php';
}

// Secondary Navigation
if ( parvati_is_module_active( 'parvati_package_secondary_nav', 'PARVATI_SECONDARY_NAV' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'secondary-nav/secondary-nav.php';
}

// Spacing
if ( parvati_is_module_active( 'parvati_package_spacing', 'PARVATI_SPACING' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'spacing/spacing.php';
}

// Typography
if ( parvati_is_module_active( 'parvati_package_typography', 'PARVATI_TYPOGRAPHY' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'typography/fonts.php';
}

// Menu Plus
if ( parvati_is_module_active( 'parvati_package_menu_plus', 'PARVATI_MENU_PLUS' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'menu-plus/menu-plus.php';
}

// Events
if ( parvati_is_module_active( 'wpkoi_package_events', 'WPKOI_EVENTS' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'events/events.php';
}

// Widgets
if ( parvati_is_module_active( 'wpkoi_package_widgets', 'WPKOI_WIDGETS' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'widgets/widgets.php';
}

// Updater modul
if ( parvati_is_module_active( 'parvati_package_updater', 'WPKOI_UPDATER' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'inc/updater.php';
}

// WooCommerce
if ( parvati_is_module_active( 'parvati_package_woocommerce', 'PARVATI_WOOCOMMERCE' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'woocommerce/woocommerce.php';
	}
}

// Elementor
if ( parvati_is_module_active( 'parvati_package_elementor_addon', 'PARVATI_ELEMENTOR_ADDON' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( ( is_plugin_active( 'elementor/elementor.php' ) ) || ( is_plugin_active( 'elementor-pro/elementor-pro.php' ) ) )  {
		if ( !is_plugin_active( 'wpkoi-elements-for-elementor/wpkoi-elements-for-elementor.php' ) )  {
			if ( !is_plugin_active( 'wpkoi-templates-for-elementor-premium/wpkoi-templates-for-elementor-premium.php' ) )  {
				require_once plugin_dir_path( __FILE__ ) . 'elementor/elementor.php';
				require_once plugin_dir_path( __FILE__ ) . 'elementor-settings/elementor-settings.php';
			}
		}
	}
	if ( is_plugin_active( 'wpkoi-elements-for-elementor/wpkoi-elements-for-elementor.php' ) )  {
		update_option( 'parvati_package_elementor_addon', 'deactivated' );
	}
}

// General
require_once plugin_dir_path( __FILE__ ) . 'general/smooth-scroll.php';
require_once plugin_dir_path( __FILE__ ) . 'general/icons.php';

// Load admin-only files.
if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'inc/activation.php';
	require_once plugin_dir_path( __FILE__ ) . 'inc/dashboard.php';
}

if ( ! function_exists( 'parvati_premium_setup' ) ) {
	add_action( 'after_setup_theme', 'parvati_premium_setup' );
	/**
	 * Add useful functions to Parvati Premium
	 **/
	function parvati_premium_setup() {
		// This used to be in the theme but the WP.org review team asked for it to be removed.
		// Not wanting people to have broken shortcodes in their widgets on update, I added it into premium.
		add_filter( 'widget_text', 'do_shortcode' );
	}
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'parvati_add_configure_action_link' );
/**
 * Show a "Configure" link in the plugin action links.
 *
 */
function parvati_add_configure_action_link( $links ) {
	$configuration_link = '<a href="' . admin_url( 'themes.php?page=parvati-options' ) . '">' . __( 'Configure', 'parvati-premium' ) . '</a>';
	return array_merge( $links, array( $configuration_link ) );
}

// Check if Parvati Premium was active before
add_action( 'customize_register', 'parvati_premium_first_time_customizer', 999 );
function parvati_premium_first_time_customizer( $wp_customize ) {
	$wp_customize->add_setting(
		'first_time',
		array(
			'default' => false,
			'type' => 'option',
			'sanitize_callback' => 'parvati_premium_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'first_time',
		array(
			'type' => 'checkbox',
			'label' => __( 'Active before', 'parvati-premium' ),
			'section' => 'parvati_general_section',
		)
	);
	
	$wp_customize->add_setting(
		'update_first_time',
		array(
			'default' => false,
			'type' => 'option',
			'sanitize_callback' => 'parvati_premium_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'update_first_time',
		array(
			'type' => 'checkbox',
			'label' => __( 'Active before', 'parvati-premium' ),
			'section' => 'parvati_general_section',
		)
	);
}

// Activate the modules if it is the first time
if (!get_option( 'first_time' )) {
	
	update_option( 'parvati_package_backgrounds', 'activated' );
	update_option( 'parvati_package_blog', 'activated' );
	update_option( 'parvati_package_colors', 'activated' );
	update_option( 'parvati_package_copyright', 'activated' );
	update_option( 'parvati_package_disable_elements', 'activated' );
	update_option( 'parvati_package_demo_import', 'activated' );
	update_option( 'parvati_package_hooks', 'activated' );
	update_option( 'parvati_package_menu_plus', 'activated' );
	update_option( 'wpkoi_package_events', 'activated' );
	update_option( 'wpkoi_package_widgets', 'activated' );
	update_option( 'parvati_package_page_header', 'activated' );
	update_option( 'parvati_package_fixed_side_content', 'activated' );
	update_option( 'parvati_package_secondary_nav', 'activated' );
	update_option( 'parvati_package_spacing', 'activated' );
	update_option( 'parvati_package_typography', 'activated' );
	update_option( 'parvati_package_woocommerce', 'activated' );
	update_option( 'parvati_package_elementor_addon', 'activated' );
	update_option( 'parvati_package_updater', 'activated' );
	
	update_option( 'first_time', true );
	update_option( 'update_first_time', true );
}

if (!get_option( 'update_first_time' )) {
	
	update_option( 'parvati_package_updater', 'activated' );
	update_option( 'update_first_time', true );
}

/**
 * This function adds some styles to the WordPress Customizer
 */
function parvati_premium_first_time_customizer_styles() { ?>
	<style>
		#customize-control-first_time, #customize-control-update_first_time {
			display: none !important;
		}
	</style>
	<?php

}
add_action( 'customize_controls_print_styles', 'parvati_premium_first_time_customizer_styles', 999 );

