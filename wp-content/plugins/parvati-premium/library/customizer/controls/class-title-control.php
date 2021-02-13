<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Parvati_Title_Customize_Control' ) ) :
/**
 * Create a control to display titles within our sections
 */
class Parvati_Title_Customize_Control extends WP_Customize_Control {
	public $type = 'parvati-customizer-title';
	public $title = '';
	
	public function enqueue() {
		wp_enqueue_style( 'parvati-title-customize-control', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/title-customizer.css', array(), PARVATI_PREMIUM_VERSION );
	}

	public function to_json() {
		parent::to_json();
		$this->json[ 'title' ] = esc_html( $this->title );
	}
	
	public function content_template() {
		?>
		<div class="parvati-customizer-title">
			<span>{{ data.title }}</span>
		</div>
		<?php
	}
}
endif;