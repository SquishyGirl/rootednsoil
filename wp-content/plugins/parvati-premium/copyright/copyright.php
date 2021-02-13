<?php
/*
Addon Name: Copyright
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_COPYRIGHT_VERSION' ) ) {
	define( 'PARVATI_COPYRIGHT_VERSION', PARVATI_PREMIUM_VERSION );
}

// Include functions
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
