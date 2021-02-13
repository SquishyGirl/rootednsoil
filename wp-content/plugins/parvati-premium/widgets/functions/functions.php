<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

function wpkoi_widget_admin($hook) {
 	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script('wpkoi-repeating-fields', plugin_dir_url(__FILE__) . 'js/repeating-fields.js', array( 'jquery', 'jquery-ui-sortable' ));
}

add_action('admin_enqueue_scripts', 'wpkoi_widget_admin');