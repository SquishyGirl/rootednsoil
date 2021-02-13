<?php
namespace Elementor;

function wpkoi_elements_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'wpkoi-addons-for-elementor',
        [
            'title'  => 'WPKoi Addons for Elementor',
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','Elementor\wpkoi_elements_elementor_init');

function wpkoi_elements_s_template_path() {
	return apply_filters( 'wpkoi-elements/template-path', 'wpkoi-elements/' );
}

/**
 * Returns path to template file.
 */
function wpkoi_elements_s_get_template( $name = null ) {

	$template = locate_template( wpkoi_elements_s_template_path() . $name );

	if ( ! $template ) {
		$template = WPKOI_ELEMENTS_PATH . 'templates/' . $name;
	}

	if ( file_exists( $template ) ) {
		return $template;
	} else {
		return false;
	}
}

/**
 * Editor Css
 */
add_action( 'elementor/editor/before_enqueue_scripts', function() {

   wp_register_style( 'wpkoi_elements_elementor_editor-css', WPKOI_ELEMENTS_URL .'/assets/css/addons-editor.css');
   wp_enqueue_style( 'wpkoi_elements_elementor_editor-css' );

} );
