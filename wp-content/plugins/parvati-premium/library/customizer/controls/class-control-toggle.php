<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Parvati_Control_Toggle_Customize_Control' ) ) :
/**
 * Add a button to initiate refresh when changing featured image sizes
 */
class Parvati_Control_Toggle_Customize_Control extends WP_Customize_Control {
	public $type = 'control_section_toggle';
	public $targets = '';
	
	public function enqueue() {
		wp_enqueue_script( 'parvati-pro-control-target', trailingslashit( plugin_dir_url( __FILE__ ) )  . 'js/control-toggle-customizer.js', array( 'customize-controls', 'jquery' ), PARVATI_PREMIUM_VERSION, true );
		wp_enqueue_style( 'parvati-pro-control-target', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/control-toggle-customizer.css', array(), PARVATI_PREMIUM_VERSION );
	}
	
	public function to_json() {
		parent::to_json();
		
		$this->json[ 'targets' ] = $this->targets;

	}
	
	public function content_template() {
		?>
		<div class="parvati-control-toggles">
			<# jQuery.each( data.targets, function( index, value ) { #>
				<button data-target="{{ index }}">{{ value }}</button>
			<# } ); #>
		</div>
		<?php
	}
}
endif;