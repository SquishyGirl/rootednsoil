<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPKoi_Particles_Extension' ) ) {

	/**
	 * Define WPKoi_Particles_Extension class
	 */
	class WPKoi_Particles_Extension {
		
		/**
		 * Sections Data
		 */
		public $sections_data = array();

		/**
		 * Columns Data
		 */
		public $columns_data = array();

		/**
		 * Widgets Data
		 */
		public $widgets_data = array();

		public $default_section_settings = array(
			'section_wpkoi_tricks_particles'      => false,
			'section_wpkoi_tricks_particles_json' => '',
		);

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Init Handler
		 */
		public function init() {

			add_action( 'elementor/element/section/section_advanced/after_section_end', array( $this, 'after_section_advanced' ), 10, 2 );

			add_action( 'elementor/frontend/section/before_render', array( $this, 'section_before_render' ) );

			add_action( 'elementor/frontend/element/before_render', array( $this, 'section_before_render' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
		}

		public function after_section_advanced( $obj, $args ) {

			$obj->start_controls_section(
				'section_wpkoi_tricks_settings',
				array(
					'label' => esc_html__( 'Particles (WPKoi)', 'wpkoi-elements' ),
					'tab'   => Elementor\Controls_Manager::TAB_STYLE,
				)
			);

			$obj->add_control(
				'section_wpkoi_tricks_particles',
				array(
					'label'        => esc_html__( 'Enable Particles', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'default'      => 'false',
					'label_on'     => 'Yes',
					'label_off'    => 'No',
					'return_value' => 'true',
					'description'  => esc_html__( 'Switch on to enable & access Particles options! Z-index will be 2 for this layer at the front-end, 0 at the editor for the easier editing. If You want to use button or any action element above the particles, add a higher z-index for that!', 'wpkoi-elements' ),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'section_wpkoi_tricks_particles_json',
				array(
					'label'                        => esc_html__( 'Particles JSON', 'wpkoi-elements' ),
					'type'                         => Elementor\Controls_Manager::TEXTAREA,
					'condition'                    => array(
						'section_wpkoi_tricks_particles' => 'true',
					),
					'description'                  => __( 'Paste your particles JSON code here - Generate it from <a href="http://vincentgarreau.com/particles.js/#default" target="_blank">Here!</a>', 'wpkoi-elements' ),
					'default'                      => '',
					'render_type'                  => 'template',
				)
			);

			$obj->end_controls_section();
		}

		public function section_before_render( $element ) {
			$data     = $element->get_data();
			$type     = isset( $data['elType'] ) ? $data['elType'] : 'section';
			$settings = $data['settings'];

			if ( 'section' !== $type ) {
				return false;
			}

			$section_id = $data['id'];

			$settings = wp_parse_args( $settings, $this->default_section_settings );

			if ( filter_var( $settings['section_wpkoi_tricks_particles'], FILTER_VALIDATE_BOOLEAN ) ) {
				$element->add_render_attribute( '_wrapper', array(
					'class' => 'wpkoi-tricks-particles-section',
				) );
			}

			$section_settings = array(
				'particles'      => filter_var( $settings['section_wpkoi_tricks_particles'], FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
				'particles_json' => $settings['section_wpkoi_tricks_particles_json'],
			);

			$this->sections_data[ $data['id'] ] = $section_settings;
		}

		public function enqueue_scripts() {

			wp_enqueue_script( 'wpkoi-particle-js', WPKOI_ELEMENTS_URL . 'elements/particles/assets/particles.min.js', array(), '2.0.0', true);
			
			wp_enqueue_script( 'wpkoi-particles', WPKOI_ELEMENTS_URL . 'elements/particles/assets/wpkoi-particles.js', array( 'jquery', 'elementor-frontend' ), WPKOI_ELEMENTS_VERSION, true );
			
			wpkoi_elements_integration()->elements_data['sections'] = $this->sections_data;
			
		}

		/**
		 * Returns the instance.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}
}

/**
 * Returns instance of WPKoi_Particles_Extension
 */
function wpkoi_particles_extension() {
	return WPKoi_Particles_Extension::get_instance();
}

wpkoi_particles_extension()->init();