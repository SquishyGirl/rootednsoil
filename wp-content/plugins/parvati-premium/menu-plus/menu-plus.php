<?php
/*
Add-on Name: Generate Menu Plus
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_MENU_PLUS_VERSION' ) ) {
	define( 'PARVATI_MENU_PLUS_VERSION', PARVATI_PREMIUM_VERSION );
}

// Include functions identical between standalone add-on and Parvati Premium
require plugin_dir_path( __FILE__ ) . 'functions/menu-plus.php';

// Set up language files
if ( ! function_exists( 'parvati_menu_plus_init' ) ) {
	add_action( 'plugins_loaded', 'parvati_menu_plus_init' );

	function parvati_menu_plus_init() {
		load_plugin_textdomain( 'menu-plus', false, 'parvati-premium/langs/menu-plus/' );
	}
}
