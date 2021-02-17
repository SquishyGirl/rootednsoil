<?php
/*
Addon Name: Parvati EVENTS post type
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_EVENTS_VERSION' ) ) {
	define( 'PARVATI_EVENTS_VERSION', PARVATI_PREMIUM_VERSION );
}

require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
require plugin_dir_path( __FILE__ ) . 'functions/meta-box.php';
require plugin_dir_path( __FILE__ ) . 'functions/sidebars.php';