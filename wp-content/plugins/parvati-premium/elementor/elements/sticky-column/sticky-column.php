<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPKoi_Sticky_Column_Extension' ) ) {

	/**
	 * Define WPKoi_Sticky_Column_Extension class
	 */
	class WPKoi_Sticky_Column_Extension {

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

		public $view_more_sections = array();

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Init Handler
		 */
		public function init() {

			add_action( 'elementor/element/column/section_advanced/after_section_end', array( $this, 'after_column_section_layout' ), 10, 2 );

			add_action( 'elementor/frontend/column/before_render', array( $this, 'column_before_render' ) );

			add_action( 'elementor/frontend/element/before_render', array( $this, 'column_before_render' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'column_enqueue_scripts' ), 9 );
		}


		/**
		 * After column_layout callback
		 */
		public function after_column_section_layout( $obj, $args ) {

			$obj->start_controls_section(
				'column_wpkoi_tricks',
				array(
					'label' => esc_html__( 'Sticky Column (WPKoi)', 'wpkoi-elements' ),
					'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
				)
			);

			$obj->add_control(
				'wpkoi_tricks_column_sticky',
				array(
					'label'        => esc_html__( 'Use Sticky Column?', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
					'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
					'return_value' => 'true',
					'default'      => 'false',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_top_spacing',
				array(
					'label'   => esc_html__( 'Top Spacing', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => 0,
					'max'     => 500,
					'step'    => 1,
					'condition' => array(
						'wpkoi_tricks_column_sticky' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_bottom_spacing',
				array(
					'label'   => esc_html__( 'Bottom Spacing', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => 0,
					'max'     => 500,
					'step'    => 1,
					'condition' => array(
						'wpkoi_tricks_column_sticky' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_column_sticky_on',
				array(
					'label'    => __( 'Sticky On', 'wpkoi-elements' ),
					'type'     => Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'label_block' => 'true',
					'default' => array(
						'desktop',
						'tablet',
					),
					'options' => array(
						'desktop' => __( 'Desktop', 'wpkoi-elements' ),
						'tablet'  => __( 'Tablet', 'wpkoi-elements' ),
						'mobile'  => __( 'Mobile', 'wpkoi-elements' ),
					),
					'condition' => array(
						'wpkoi_tricks_column_sticky' => 'true',
					),
					'render_type'        => 'none',
				)
			);

			$obj->end_controls_section();
		}


		public function column_before_render( $element ) {
			$data     = $element->get_data();
			$type     = isset( $data['elType'] ) ? $data['elType'] : 'column';
			$settings = $data['settings'];

			if ( 'column' !== $type ) {
				return false;
			}

			if ( isset( $settings['wpkoi_tricks_column_sticky'] ) ) {
				$column_settings = array(
					'id'            => $data['id'],
					'sticky'        => filter_var( $settings['wpkoi_tricks_column_sticky'], FILTER_VALIDATE_BOOLEAN ),
					'topSpacing'    => isset( $settings['wpkoi_tricks_top_spacing'] ) ? $settings['wpkoi_tricks_top_spacing'] : 50,
					'bottomSpacing' => isset( $settings['wpkoi_tricks_bottom_spacing'] ) ? $settings['wpkoi_tricks_bottom_spacing'] : 50,
					'stickyOn'      => isset( $settings['wpkoi_tricks_column_sticky_on'] ) ? $settings['wpkoi_tricks_column_sticky_on'] : array( 'desktop', 'tablet' ),
				);

				if ( filter_var( $settings['wpkoi_tricks_column_sticky'], FILTER_VALIDATE_BOOLEAN ) ) {

					$element->add_render_attribute( '_wrapper', array(
						'class'         => 'wpkoi-sticky-column',
						'data-settings' => json_encode( $column_settings ),
					) );
				}

				$this->columns_data[ $data['id'] ] = $column_settings;
			}
		}


		public function column_enqueue_scripts() {

			wp_enqueue_script(
				'wpkoi-sticky-sidebar',
				WPKOI_ELEMENTS_URL . 'elements/sticky-column/assets/sticky-sidebar.min.js',
				array( 'jquery' ),
				'3.3.1',
				true
			);
			
			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, '3.0', '>=' ) ) {
				wp_enqueue_script(
					'wpkoi-sticky-column',
					WPKOI_ELEMENTS_URL . 'elements/sticky-column/assets/sticky-column.js',
					array( 'jquery', 'elementor-frontend' ),
					WPKOI_ELEMENTS_VERSION,
					true
				);
			} else {
				wp_enqueue_script(
					'wpkoi-sticky-column',
					WPKOI_ELEMENTS_URL . 'elements/sticky-column/assets/sticky-column-3.js',
					array( 'jquery', 'elementor-frontend' ),
					WPKOI_ELEMENTS_VERSION,
					true
				);
			}

			wpkoi_elements_integration()->elements_data['columns'] = $this->columns_data;
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
 * Returns instance of WPKoi_Sticky_Column_Extension
 */
function wpkoi_sticky_column_extension() {
	return WPKoi_Sticky_Column_Extension::get_instance();
}

wpkoi_sticky_column_extension()->init();