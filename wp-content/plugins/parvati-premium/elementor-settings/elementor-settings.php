<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Set our root directory
define( 'WPKOI_ELEMENTS_FOR_ELEMENTOR_DIRECTORY', plugin_dir_path( __FILE__ ) );
define( 'WPKOI_ELEMENTS_FOR_ELEMENTOR_URL', plugins_url( '/', __FILE__ ) );

// Add script to Editor
add_action( 'admin_enqueue_scripts', 'wpkoi_elements_for_elementor_admin_add_scripts');
function wpkoi_elements_for_elementor_admin_add_scripts(){
	
	wp_register_style( 'wpkoi-elements-for-elementor-css',  WPKOI_ELEMENTS_FOR_ELEMENTOR_URL . 'assets/css/wpkoi-elements-for-elementor.css' , WPKOI_ELEMENTS_VERSION );
	wp_enqueue_style( 'wpkoi-elements-for-elementor-css');

}

// Element options
require WPKOI_ELEMENTS_FOR_ELEMENTOR_DIRECTORY . 'inc/element-options.php';

// Add admin page
if ( ! function_exists( 'wpkoi_elements_for_elementor_create_menu' ) ) {
	add_action( 'admin_menu', 'wpkoi_elements_for_elementor_create_menu' );
	/**
	 * Adds our "WPKoi Templates for Elementor Activation" dashboard menu item
	 *
	 */
	function wpkoi_elements_for_elementor_create_menu() {
		add_menu_page( 'WPKoi Elements for Elementor', 'WPKoi Elements', 'manage_options', WPKOI_ELEMENTS_FOR_ELEMENTOR_DIRECTORY . 'wpkoi-elements.php', '', '', 59 );
	}
}