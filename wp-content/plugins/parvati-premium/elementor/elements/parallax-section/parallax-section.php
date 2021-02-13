<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPKoi_Elements_Ext_Section' ) ) {

	/**
	 * Define WPKoi_Elements_Ext_Section class
	 */
	class WPKoi_Elements_Ext_Section {

		public $parallax_sections = array();

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Init Handler
		 */
		public function init() {

			add_action( 'elementor/element/section/section_layout/after_section_end', array( $this, 'after_section_end' ), 10, 2 );

			add_action( 'elementor/frontend/element/before_render', array( $this, 'section_before_render' ) );

			add_action( 'elementor/frontend/section/before_render', array( $this, 'section_before_render' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
		}

		/**
		 * After section_layout callback
		 */
		public function after_section_end( $obj, $args ) {

			if ( class_exists( 'WPKoi_Parallax' ) ) {
				return false;
			}

			$obj->start_controls_section(
				'wpkoi_section_parallax',
				array(
					'label' => esc_html__( 'Parallax effect (WPKoi)', 'wpkoi-elements' ),
					'tab'   => Elementor\Controls_Manager::TAB_LAYOUT,
				)
			);

			$obj->add_control(
				'wpkoi_parallax_items_heading',
				array(
					'label'     => esc_html__( 'If You used an earlier version of Parallax section, here You can replace Your image!', 'wpkoi-elements' ),
					'type'      => Elementor\Controls_Manager::HEADING,
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_image',
				array(
					'label'   => esc_html__( 'Image', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::MEDIA,
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_speed',
				array(
					'label'      => esc_html__( 'Parallax Speed(%)', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array( '%' ),
					'range'      => array(
						'%' => array(
							'min'  => 1,
							'max'  => 100,
						),
					),
					'default' => array(
						'size' => 50,
						'unit' => '%',
					),
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_type',
				array(
					'label'   => esc_html__( 'Type', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'scroll',
					'options' => array(
						'none'   => esc_html__( 'None', 'wpkoi-elements' ),
						'scroll' => esc_html__( 'Scroll', 'wpkoi-elements' ),
						'mouse'  => esc_html__( 'Mouse Move', 'wpkoi-elements' ),
						'zoom'   => esc_html__( 'Scrolling Zoom', 'wpkoi-elements' ),
						'matrix' => esc_html__( '3D Matrix', 'wpkoi-elements' ),
					),
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_scale',
				array(
					'label'      => esc_html__( 'Mouse move scale (%)', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array( '%' ),
					'range'      => array(
						'%' => array(
							'min'  => 1,
							'max'  => 300,
						),
					),
					'default' => array(
						'size' => 100,
						'unit' => '%',
					),
					'condition' => array(
						'wpkoi_parallax_layout_type' => 'mouse'
					)
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_bg_x',
				array(
					'label'   => esc_html__( 'X Position(%)', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => -200,
					'max'     => 200,
					'step'    => 1,
					'condition' => array(
						'wpkoi_parallax_layout_type' =>  array('scroll', 'zoom', 'mouse' )
					)
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_bg_y',
				array(
					'label'   => esc_html__( 'Y Position(%)', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => -200,
					'max'     => 200,
					'step'    => 1,
					'condition' => array(
						'wpkoi_parallax_layout_type' =>  array('scroll', 'zoom', 'mouse' )
					)
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_z_index',
				array(
					'label'    => esc_html__( 'z-Index', 'wpkoi-elements' ),
					'type'     => Elementor\Controls_Manager::NUMBER,
					'min'      => 0,
					'max'      => 99,
					'step'     => 1,
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_bg_size',
				array(
					'label'   => esc_html__( 'Bg Size', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'auto',
					'options' => array(
						'auto'    => esc_html__( 'Auto', 'wpkoi-elements' ),
						'cover'   => esc_html__( 'Cover', 'wpkoi-elements' ),
						'contain' => esc_html__( 'Contain', 'wpkoi-elements' ),
					),
					'condition' => array(
						'wpkoi_parallax_layout_type' =>  array('scroll', 'zoom', 'mouse' )
					)
				)
			);

			$obj->add_control(
				'wpkoi_parallax_layout_animation_prop',
				array(
					'label'   => esc_html__( 'Property', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'transform',

					'options' => array(
						'bgposition'  => esc_html__( 'Background Position', 'wpkoi-elements' ),
						'transform'   => esc_html__( 'Transform', 'wpkoi-elements' ),
						'transform3d' => esc_html__( 'Transform 3D', 'wpkoi-elements' ),
					),
					'condition' => array(
						'wpkoi_parallax_layout_type' =>  'scroll'
					)
				)
			);

			$obj->end_controls_section();
		}

		/**
		 * Elementor before section render callback
		 */
		public function section_before_render( $obj ) {
			$data     = $obj->get_data();
			$type     = isset( $data['elType'] ) ? $data['elType'] : 'section';
			$settings = $data['settings'];

			if ( 'section' === $type ) {

				if ( ( isset( $settings['wpkoi_parallax_layout_list'] ) ) && ( !isset( $settings['wpkoi_parallax_layout_image'] ) ) ) {
					$this->parallax_sections[ $data['id'] ] = $settings['wpkoi_parallax_layout_list'];
				} elseif ( isset( $settings['wpkoi_parallax_layout_image'] ) ) {
					
					$wpkoi_parallax_layout_type = isset( $settings['wpkoi_parallax_layout_type'] ) ? $settings['wpkoi_parallax_layout_type'] : 'scroll';
					$wpkoi_parallax_layout_speed = isset( $settings['wpkoi_parallax_layout_speed'] ) ? $settings['wpkoi_parallax_layout_speed'] : array( 'size' => 50 );
					$wpkoi_parallax_layout_scale = isset( $settings['wpkoi_parallax_layout_scale'] ) ? $settings['wpkoi_parallax_layout_scale'] : array( 'size' => 100 );
					$wpkoi_parallax_layout_bg_x = isset( $settings['wpkoi_parallax_layout_bg_x'] ) ? $settings['wpkoi_parallax_layout_bg_x'] : 50;
					$wpkoi_parallax_layout_bg_y = isset( $settings['wpkoi_parallax_layout_bg_y'] ) ? $settings['wpkoi_parallax_layout_bg_y'] : 50;
					$wpkoi_parallax_layout_z_index = isset( $settings['wpkoi_parallax_layout_z_index'] ) ? $settings['wpkoi_parallax_layout_z_index'] : false;
					$wpkoi_parallax_layout_bg_size = isset( $settings['wpkoi_parallax_layout_bg_size'] ) ? $settings['wpkoi_parallax_layout_bg_size'] : 'auto';
					$wpkoi_parallax_layout_animation_prop = isset( $settings['wpkoi_parallax_layout_animation_prop'] ) ? $settings['wpkoi_parallax_layout_animation_prop'] : 'transform';
					$randomid = 'koi55555';
					
					
					$this->parallax_sections[ $data['id'] ] =  
					array( 
						array( 
							'wpkoi_parallax_layout_image' => $settings['wpkoi_parallax_layout_image'],
							'wpkoi_parallax_layout_speed' => $wpkoi_parallax_layout_speed, 
							'wpkoi_parallax_layout_type' => $wpkoi_parallax_layout_type, 
							'wpkoi_parallax_layout_scale' => $wpkoi_parallax_layout_scale, 
							'wpkoi_parallax_layout_bg_x' => $wpkoi_parallax_layout_bg_x, 
							'wpkoi_parallax_layout_bg_y' => $wpkoi_parallax_layout_bg_y, 
							'wpkoi_parallax_layout_z_index' => $wpkoi_parallax_layout_z_index, 
							'wpkoi_parallax_layout_bg_size' => $wpkoi_parallax_layout_bg_size, 
							'wpkoi_parallax_layout_animation_prop' => $wpkoi_parallax_layout_animation_prop,
							'_id' => $randomid,
							'sectionid' => $data['id']
						) 
					);
				}
			}
		}

		public function enqueue_scripts() {
			
			wp_enqueue_style( 'wpkoi-perspectiveRules', WPKOI_ELEMENTS_URL . 'elements/parallax-section/assets/perspectiveRules.css', false, WPKOI_ELEMENTS_VERSION );
			
			wp_enqueue_script( 'wpkoi-logosdistort', WPKOI_ELEMENTS_URL . 'elements/parallax-section/assets/jquery.logosDistort.js', array( 'jquery', 'elementor-frontend' ), WPKOI_ELEMENTS_VERSION, true );

			wp_enqueue_script( 'wpkoi-parallax-section', WPKOI_ELEMENTS_URL . 'elements/parallax-section/assets/parallax-section.js', array( 'jquery', 'elementor-frontend' ), WPKOI_ELEMENTS_VERSION, true );
			if ( ! array_key_exists( 'wpkoiParallaxSections', wpkoi_elements_integration()->localize_data ) ) {
				wpkoi_elements_integration()->localize_data['wpkoiParallaxSections'] = $this->parallax_sections;
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
 * Returns instance of WPKoi_Elements_Ext_Section
 */
function wpkoi_elements_ext_section() {
	return WPKoi_Elements_Ext_Section::get_instance();
}
wpkoi_elements_ext_section()->init();
