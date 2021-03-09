<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPKoi_Background_Change_Extension' ) ) {

	/**
	 * Define WPKoi_Background_Change_Extension class
	 */
	class WPKoi_Background_Change_Extension {
				
		public $bgchange_sections = array();
		
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
			'section_wpkoi_background_change' => false
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
				'section_wpkoi_background_change_settings',
				array(
					'label' => esc_html__( 'Background Cahnge (WPKoi)', 'wpkoi-elements' ),
					'tab'   => Elementor\Controls_Manager::TAB_STYLE,
				)
			);

			$obj->add_control(
				'section_wpkoi_background_change',
				array(
					'label'        => esc_html__( 'Enable Background Cahnge', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'default'      => 'false',
					'label_on'     => 'Yes',
					'label_off'    => 'No',
					'return_value' => 'true',
					'render_type'  => 'template',
					'description'  => esc_html__( 'The result of the effects are not visible in the editor, only on the live page! It will change the body background color with a pretty transition to the section background color. If You use this option at a section, it is recommended to use it at all section.', 'wpkoi-elements' ),
					'render_type'  => 'template',
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
			$background_color = isset( $data['settings']['background_color'] ) ? $data['settings']['background_color'] : '#fff';

			$settings = wp_parse_args( $settings, $this->default_section_settings );

			if ( filter_var( $settings['section_wpkoi_background_change'], FILTER_VALIDATE_BOOLEAN ) ) {
				
				$this->bgchange_sections[ $data['id'] ] =  
				array( 
					array( 
						'wpkoi_bgc_section_id' => $section_id,
						'wpkoi_bgc_background_color' => $background_color,
						'section_wpkoi_background_change' => $settings['section_wpkoi_background_change'],
						'sectionid' => $data['id']
					) 
				);
			}
			
		}

		public function enqueue_scripts() {
			
			wp_enqueue_script( 'wpkoi-background-change-section', WPKOI_ELEMENTS_URL . 'elements/background-change/assets/background-change.js', array( 'jquery', 'elementor-frontend' ), WPKOI_ELEMENTS_VERSION, true );
			if ( ! array_key_exists( 'wpkoiBGChangeSections', wpkoi_elements_integration()->localize_data ) ) {
				wpkoi_elements_integration()->localize_data['wpkoiBGChangeSections'] = $this->bgchange_sections;
			}

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
 * Returns instance of WPKoi_Background_Change_Extension
 */
function wpkoi_background_change_extension() {
	return WPKoi_Background_Change_Extension::get_instance();
}

wpkoi_background_change_extension()->init();