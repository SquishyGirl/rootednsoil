<?php
/*
Plugin Name: Clever Fox
Plugin URI:
Description: Clever Fox plugin to enhance the functionality of WordPress themes made by Nayra Themes. Main motive behind this plugin is to boost up functionality of Nayra themes and focus on a smooth user experience. Clever Fox contains all features which are required to create a complete website. Clever Fox comes with everything you could ever need to build an amazing website that is suitable for business, portfolio, food & restaurant, gym & fitness, spa salon, medical practitioner & hospitals, WooCommerce Websites. You can see below listed free themes. 
Version: 3.5
Author: nayrathemes
Author URI: https://nayrathemes.com
Text Domain: clever-fox
*/
define( 'CLEVERFOX_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CLEVERFOX_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

function cleverfox_activate() {
	
	/**
	 * Load Custom control in Customizer
	 */
	define( 'CLEVERFOX_DIRECTORY', plugin_dir_url( __FILE__ ) . '/inc/custom-controls/' );
	define( 'CLEVERFOX_DIRECTORY_URI', plugin_dir_url( __FILE__ ) . '/inc/custom-controls/' );
	if ( class_exists( 'WP_Customize_Control' ) ) {
		require_once('inc/custom-controls/controls/range-validator/range-control.php');	
	}
	
	$theme = wp_get_theme(); // gets the current theme
		if ( 'StartKit' == $theme->name){	
			require_once('inc/startkit/startkit.php');
		}
		
		if ( 'StartBiz' == $theme->name){	
			require_once('inc/startbiz/startbiz.php');
		}
		
		if ('Arowana' == $theme->name){	
			 require_once('inc/arowana/arowana.php');
		}
		
		if ('Envira' == $theme->name){	
			 require_once('inc/envira/envira.php');			
		}
		
		if( 'Hantus' == $theme->name){
			require_once('inc/hantus/hantus.php');	
		}
		
		if( 'Conceptly' == $theme->name){
			require_once('inc/conceptly/conceptly.php');
		}
		
		if( 'Ameya' == $theme->name){
			require_once('inc/ameya/ameya.php');
		}
		
		if( 'Azwa' == $theme->name){
			require_once('inc/azwa/azwa.php');
		}
		
		if( 'Avril' == $theme->name){
			require_once('inc/avril/avril.php');
		}
		
		if( 'Aera' == $theme->name){
			require_once('inc/aera/aera.php');
		}
		
		if( 'Avail' == $theme->name){
			require_once('inc/avail/avail.php');
		}
		
	}
add_action( 'init', 'cleverfox_activate' );

$theme = wp_get_theme();

/**
 * The code during plugin activation.
 */
function activate_cleverfox() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/cleverfox-activator.php';
	Cleverfox_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_cleverfox' );