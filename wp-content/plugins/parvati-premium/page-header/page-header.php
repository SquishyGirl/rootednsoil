<?php
/*
Addon Name: Parvati Page Header
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_PAGE_HEADER_VERSION' ) ) {
	define( 'PARVATI_PAGE_HEADER_VERSION', PARVATI_PREMIUM_VERSION );
}

// Include assets unique to this addon
require plugin_dir_path( __FILE__ ) . 'functions/functions.php';
