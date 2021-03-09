<?php
/*
Addon Name: Parvati EVENTS post type
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_WIDGETS_VERSION' ) ) {
	define( 'PARVATI_WIDGETS_VERSION', PARVATI_PREMIUM_VERSION );
}

require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
require plugin_dir_path( __FILE__ ) . 'functions/wpkoi-buttons-widget.php';
require plugin_dir_path( __FILE__ ) . 'functions/wpkoi-contact-widget.php';
require plugin_dir_path( __FILE__ ) . 'functions/wpkoi-hero-widget.php';
require plugin_dir_path( __FILE__ ) . 'functions/wpkoi-posts-widget.php';