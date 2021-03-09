<?php
/*
Addon Name: Parvati Demo Import
*/

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the version
if ( ! defined( 'PARVATI_DEMO_IMPORT' ) ) {
	define( 'PARVATI_DEMO_IMPORT', PARVATI_PREMIUM_VERSION );
}

// The great Parvati demo
function parvati_premium_import_files() {
  return array(
    array(
      'import_file_name'           => 'Parvati Premium',
      'import_file_url'            => plugins_url( 'demo-files/parvati.WordPress.2020-08-28.xml', __FILE__ ),
      'import_widget_file_url'     => plugins_url( 'demo-files/wpkoi.com-demos5-parvati-premium-widgets.wie', __FILE__ ),
      'import_customizer_file_url' => plugins_url( 'demo-files/parvati-export.dat', __FILE__ ),
	  'import_preview_image_url'   => 'https://wpkoi.com/wp-content/uploads/2018/12/parvati-premium.jpg',
      'import_notice'              => __( 'Please install "Elementor", "WooCommerce" and "Contact Form 7" plugins before the import! The importer will add the content and settings from <a href="https://wpkoi.com/demos5/parvati-premium/" target="_blank">the premium demo</a>!', 'parvati-premium' )
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'parvati_premium_import_files' );

function parvati_premium_after_import_setup() {
    // Assign menus to their locations.
    $menu 		 = get_term_by( 'name', 'Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary'  => $menu->term_id,
            'slideout'  => $menu->term_id
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( ( is_plugin_active( 'elementor/elementor.php' ) ) || ( is_plugin_active( 'elementor-pro/elementor-pro.php' ) ) )  {
		update_option( 'elementor_scheme_color', array(
			1 => '#151515',
			2 => '#252525',
			3 => '#252525',
			4 => '#E0A655'
		) );
		
		update_option( 'elementor_scheme_typography', array(
			1 => array( 
				'font_family' => 'Playfair Display',
				'font_weight' => '700',
			),
			2 => array( 
				'font_family' => 'Playfair Display',
				'font_weight' => '400',
			),
			3 => array( 
				'font_family' => 'Merriweather',
				'font_weight' => '300',
			),
			4 => array( 
				'font_family' => 'Playfair Display',
				'font_weight' => '400',
			)
		) );
	}

}
add_action( 'pt-ocdi/after_import', 'parvati_premium_after_import_setup' );