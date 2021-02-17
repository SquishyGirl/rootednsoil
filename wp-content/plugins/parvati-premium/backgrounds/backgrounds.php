<?php
/*
Addon Name: Parvati Backgrounds
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_BACKGROUNDS_VERSION' ) ) {
	define( 'PARVATI_BACKGROUNDS_VERSION', PARVATI_PREMIUM_VERSION );
}

// Include functions identical between standalone addon and Parvati Premium
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
