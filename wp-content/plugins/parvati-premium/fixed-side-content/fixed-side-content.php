<?php
/*
Addon Name: Parvati Secondary Nav
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_FIXED_SIDE_CONTENT_VERSION' ) ) {
	define( 'PARVATI_FIXED_SIDE_CONTENT_VERSION', PARVATI_PREMIUM_VERSION );
}

// Include functions identical between standalone addon and Parvati Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
