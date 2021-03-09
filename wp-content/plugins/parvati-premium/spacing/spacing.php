<?php
/*
Addon Name: Parvati Spacing
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_SPACING_VERSION' ) ) {
	define( 'PARVATI_SPACING_VERSION', PARVATI_PREMIUM_VERSION );
}

// Include functions identical between standalone addon and Parvati Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
