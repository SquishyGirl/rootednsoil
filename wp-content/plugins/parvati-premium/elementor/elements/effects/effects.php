<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPKoi_Elements_Effects_Extension' ) ) {

	/**
	 * Define WPKoi_Elements_Effects_Extension class
	 */
	class WPKoi_Elements_Effects_Extension {

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


		public $default_widget_settings = array(
			'wpkoi_tricks_widget_parallax'           => 'false',
			'wpkoi_tricks_widget_parallax_invert'    => 'false',
			'wpkoi_tricks_widget_parallax_speed'     => array(
				'unit' => '%',
				'size' => 50
			),
			'wpkoi_tricks_widget_parallax_on'        => array(
				'desktop',
				'tablet',
				'mobile',
			),
			'wpkoi_tricks_widget_satellite'          => 'false',
			'wpkoi_tricks_widget_satellite_type'     => 'text',
			'wpkoi_tricks_widget_satellite_position' => 'top-center',
			'wpkoi_tricks_widget_satellite_icon'     => '',
			'wpkoi_tricks_widget_satellite_image'    => array(
				'url' => '',
				'id' => '',
			),
			'wpkoi_tricks_widget_tooltip'             => 'false',
			'wpkoi_tricks_widget_tooltip_description' => '',
			'wpkoi_tricks_widget_tooltip_placement'   => 'top',
			'wpkoi_tricks_widget_tooltip_x_offset'    => 0,
			'wpkoi_tricks_widget_tooltip_y_offset'    => 0,
			'wpkoi_tricks_widget_tooltip_animation'   => 'shift-toward',
			'wpkoi_tricks_widget_tooltip_z_index'     => 999,
		);

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Init Handler
		 */
		public function init() {
			add_action( 'elementor/element/common/_section_responsive/after_section_end', array( $this, 'after_common_section_responsive' ), 10, 2 );

			add_action( 'elementor/frontend/widget/before_render', array( $this, 'widget_before_render' ), 10, 1 );

			add_action( 'elementor/widget/before_render_content', array( $this, 'widget_before_render_content' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
		}


		/**
		 * After section_layout callback
		 */
		public function after_common_section_responsive( $obj, $args ) {
			$obj->start_controls_section(
				'widget_wpkoi_tricks',
				array(
					'label' => esc_html__( 'Effects (WPKoi)', 'wpkoi-elements' ),
					'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
				)
			);

			$obj->add_control(
				'rotate_heading',
				array(
					'label' => esc_html__( 'Rotate', 'wpkoi-elements' ),
					'type'  => Elementor\Controls_Manager::HEADING,
				)
			);
			
			$obj->add_control(
				'wpkoi_widget_rotate',
				[
					'label'        => esc_html__( 'Use Rotate?', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'prefix_class' => 'wpkoi-rotate-effect-',
				]
			);
			
			$obj->start_controls_tabs( 'wpkoi_widget_motion_effect_tabs' );

			$obj->start_controls_tab(
				'wpkoi_widget_motion_effect_tab_normal',
				[
					'label' => esc_html__( 'Normal', 'wpkoi-elements' ),
					'condition' => [
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
	
			$obj->add_control(
				'wpkoi_rotate_toggle_normal',
				[
					'label' 		=> __( 'Rotate', 'wpkoi-elements' ),
					'type' 			=> Elementor\Controls_Manager::POPOVER_TOGGLE,
					'return_value' 	=> 'yes',
					'condition' 	=> [
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
			$obj->start_popover();
	
	
			$obj->add_responsive_control(
				'wpkoi_widget_effect_rotatex_normal',
				[
					'label'      => esc_html__( 'Rotate X', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range'      => [
						'px' => [
							'min'  => -180,
							'max'  => 180,
						],
					],
					'condition' => [
						'wpkoi_rotate_toggle_normal' => 'yes',
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
			$obj->add_responsive_control(
				'wpkoi_widget_effect_rotatey_normal',
				[
					'label'      => esc_html__( 'Rotate Y', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range'      => [
						'px' => [
							'min'  => -180,
							'max'  => 180,
						],
					],
					'condition' => [
						'wpkoi_rotate_toggle_normal' => 'yes',
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
	
			$obj->add_responsive_control(
				'wpkoi_widget_effect_rotatez_normal',
				[
					'label'   => __( 'Rotate Z', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min'  => -180,
							'max'  => 180,
						],
					],
					'selectors' => [
						'(desktop){{WRAPPER}}.wpkoi-rotate-effect-yes.elementor-widget' => 'transform: translate( {{wpkoi_widget_effect_transx_normal.SIZE || 0}}px, {{wpkoi_widget_effect_transy_normal.SIZE || 0}}px) rotateX({{wpkoi_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{wpkoi_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{wpkoi_widget_effect_rotatez_normal.SIZE || 0}}deg);',
						'(tablet){{WRAPPER}}.wpkoi-rotate-effect-yes.elementor-widget' => 'transform: translate( {{wpkoi_widget_effect_transx_normal_tablet.SIZE || 0}}px, {{wpkoi_widget_effect_transy_normal_tablet.SIZE || 0}}px) rotateX({{wpkoi_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{wpkoi_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{wpkoi_widget_effect_rotatez_normal.SIZE || 0}}deg);',
						'(mobile){{WRAPPER}}.wpkoi-rotate-effect-yes.elementor-widget' => 'transform: translate( {{wpkoi_widget_effect_transx_normal_mobile.SIZE || 0}}px, {{wpkoi_widget_effect_transy_normal_mobile.SIZE || 0}}px) rotateX({{wpkoi_widget_effect_rotatex_normal.SIZE || 0}}deg) rotateY({{wpkoi_widget_effect_rotatey_normal.SIZE || 0}}deg) rotateZ({{wpkoi_widget_effect_rotatez_normal.SIZE || 0}}deg);',
					],
					'condition' => [
						'wpkoi_rotate_toggle_normal' => 'yes',
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
	
			$obj->end_popover();
	
			$obj->end_controls_tab();
	
			$obj->start_controls_tab(
				'wpkoi_widget_motion_effect_tab_hover',
				[
					'label' => esc_html__( 'Hover', 'wpkoi-elements' ),
					'condition' => [
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
			$obj->add_control(
				'wpkoi_rotate_toggle_hover',
				[
					'label' 		=> __( 'Rotate', 'wpkoi-elements' ),
					'type' 			=> Elementor\Controls_Manager::POPOVER_TOGGLE,
					'return_value' 	=> 'yes',
					'condition' 	=> [
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
			$obj->start_popover();
	
	
			$obj->add_responsive_control(
				'wpkoi_widget_effect_rotatex_hover',
				[
					'label'      => esc_html__( 'Rotate X', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range'      => [
						'px' => [
							'min'  => -180,
							'max'  => 180,
						],
					],
					'condition' => [
						'wpkoi_rotate_toggle_hover' => 'yes',
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
			$obj->add_responsive_control(
				'wpkoi_widget_effect_rotatey_hover',
				[
					'label'      => esc_html__( 'Rotate Y', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range'      => [
						'px' => [
							'min'  => -180,
							'max'  => 180,
						],
					],
					'condition' => [
						'wpkoi_rotate_toggle_hover' => 'yes',
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
	
			$obj->add_responsive_control(
				'wpkoi_widget_effect_rotatez_hover',
				[
					'label'   => __( 'Rotate Z', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min'  => -180,
							'max'  => 180,

						],
					],
					'selectors' => [
						'(desktop){{WRAPPER}}.wpkoi-rotate-effect-yes.elementor-widget:hover' => 'transform: translate( {{wpkoi_widget_effect_transx_hover.SIZE || 0}}px, {{wpkoi_widget_effect_transy_hover.SIZE || 0}}px) rotateX({{wpkoi_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{wpkoi_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{wpkoi_widget_effect_rotatez_hover.SIZE || 0}}deg);',
						'(tablet){{WRAPPER}}.wpkoi-rotate-effect-yes.elementor-widget:hover' => 'transform: translate( {{wpkoi_widget_effect_transx_hover_tablet.SIZE || 0}}px, {{wpkoi_widget_effect_transy_hover_tablet.SIZE || 0}}px) rotateX({{wpkoi_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{wpkoi_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{wpkoi_widget_effect_rotatez_hover.SIZE || 0}}deg);',
						'(mobile){{WRAPPER}}.wpkoi-rotate-effect-yes.elementor-widget:hover' => 'transform: translate( {{wpkoi_widget_effect_transx_hover_mobile.SIZE || 0}}px, {{wpkoi_widget_effect_transy_hover_mobile.SIZE || 0}}px) rotateX({{wpkoi_widget_effect_rotatex_hover.SIZE || 0}}deg) rotateY({{wpkoi_widget_effect_rotatey_hover.SIZE || 0}}deg) rotateZ({{wpkoi_widget_effect_rotatez_hover.SIZE || 0}}deg);',
					],
					'condition' => [
						'wpkoi_rotate_toggle_hover' => 'yes',
						'wpkoi_widget_rotate' => 'yes',
					],
				]
			);
	
	
			$obj->end_popover();
	
	
			$obj->end_controls_tab();
	
			$obj->end_controls_tabs();
			
			$obj->add_control(
				'adv_parallax_heading',
				array(
					'label' => esc_html__( 'Parallax', 'wpkoi-elements' ),
					'type'  => Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);
			
			$obj->add_control(
				'adv_parallax_effects_show',
				[
					'label'        => esc_html__( 'Use Parallax?', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
					'render_type'  => 'template',
				]
			);
			
			$obj->add_control(
				'adv_parallax_subheading',
				array(
					'label' => esc_html__( 'The result of the effects are not visible in the editor, only on the live page.', 'wpkoi-elements' ),
					'type'  => Elementor\Controls_Manager::HEADING,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
				)
			);
		
			$obj->add_control(
				'adv_parallax_effects_y',
				[
					'label' => __( 'Vertical Parallax', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type'  => 'template'
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_y_start',
				[
					'label'       => esc_html__( 'Start', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'   => -500,
							'max'   => 500,
							'step' => 10,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 50,
					],
					'render_type'  => 'template',
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->add_control(
				'adv_parallax_effects_y_end',
				[
					'label'       => esc_html__( 'End', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'   => -500,
							'max'   => 500,
							'step' => 10,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'render_type'  => 'template',
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
	
	
			$obj->end_popover();
	
	
			$obj->add_control(
				'adv_parallax_effects_x',
				[
					'label' => __( 'Horizontal Parallax', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_x_start',
				[
					'label'       => esc_html__( 'Start', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'   => -500,
							'max'   => 500,
							'step' => 10,
						],
					],
	
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->add_control(
				'adv_parallax_effects_x_end',
				[
					'label'       => esc_html__( 'End', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'   => -500,
							'max'   => 500,
							'step' => 10,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->end_popover();
			
			$obj->add_control(
				'adv_parallax_effects_opacity',
				[
					'label' => __( 'Opacity', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_opacity_start',
				[
					'label'       => esc_html__( 'Start', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'   => 1,
							'max'   => 100,
							'step' => 1,
						],
					],
	
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->add_control(
				'adv_parallax_effects_opacity_end',
				[
					'label'       => esc_html__( 'End', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'   => 1,
							'max'   => 100,
							'step' => 1,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->end_popover();
		
			$obj->add_control(
				'adv_parallax_effects_rotate',
				[
					'label' => __( 'Rotate', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_rotate_value_start',
				[
					'label'       => esc_html__( 'Start', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 5,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->add_control(
				'adv_parallax_effects_rotate_value_end',
				[
					'label'       => esc_html__( 'End', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 5,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->end_popover();
	
			$obj->add_control(
				'adv_parallax_effects_scale',
				[
					'label' => __( 'Scale', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_scale_value',
				[
					'label'       => esc_html__( 'Value', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'  => -10,
							'max'  => 10,
							'step' => 0.1,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->end_popover();
	
			$obj->add_control(
				'adv_parallax_effects_blur',
				[
					'label' => __( 'Blur', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_blur_start',
				[
					'label'       => esc_html__( 'Start', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'   => 0,
							'max'   => 20,
							'step' => 1,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->add_control(
				'adv_parallax_effects_blur_end',
				[
					'label'       => esc_html__( 'End', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'   => 0,
							'max'   => 20,
							'step' => 1,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->end_popover();
	
			$obj->add_control(
				'adv_parallax_effects_hue',
				[
					'label' => __( 'Hue', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_hue_value',
				[
					'label'       => esc_html__( 'Value', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'  => 0,
							'max'  => 360,
							'step' => 1,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
			$obj->end_popover();
	
	
			$obj->add_control(
				'adv_parallax_effects_grayscale',
				[
					'label' => __( 'Grayscale', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_grayscale_value',
				[
					'label'       => esc_html__( 'Value', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'%' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
	
			$obj->end_popover();
	
	
			$obj->add_control(
				'adv_parallax_effects_saturate',
				[
					'label' => __( 'Saturate', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_saturate_value',
				[
					'label'       => esc_html__( 'Value', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'%' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
	
			$obj->end_popover();
	
	
			$obj->add_control(
				'adv_parallax_effects_sepia',
				[
					'label' => __( 'Sepia', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::POPOVER_TOGGLE,
					'condition' => [
						'adv_parallax_effects_show' => 'yes',
					],
					'render_type' => 'template',
				]
			);
	
			$obj->start_popover();
	
			$obj->add_control(
				'adv_parallax_effects_sepia_value',
				[
					'label'       => esc_html__( 'Value', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'range'       => [
						'%' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'condition'    => [
						'adv_parallax_effects_show' => 'yes',
					],
				]
			);
	
	
			$obj->end_popover();
	
			
			$obj->add_control(
				'wpkoi_parallax_heading',
				array(
					'label' => esc_html__( 'Easy Parallax', 'wpkoi-elements' ),
					'type'  => Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_parallax',
				array(
					'label'        => esc_html__( 'Use Easy Parallax?', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
					'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
					'return_value' => 'true',
					'default'      => 'false',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_parallax_speed',
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
					'condition' => array(
						'wpkoi_tricks_widget_parallax' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_parallax_invert',
				array(
					'label'        => esc_html__( 'Invert', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
					'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
					'return_value' => 'true',
					'default'      => 'false',
					'condition' => array(
						'wpkoi_tricks_widget_parallax' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_parallax_on',
				array(
					'label'       => __( 'Sticky On', 'wpkoi-elements' ),
					'type'        => Elementor\Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => 'true',
					'default'     => array(
						'desktop',
						'tablet',
						'mobile',
					),
					'options'     => array(
						'desktop' => __( 'Desktop', 'wpkoi-elements' ),
						'tablet'  => __( 'Tablet', 'wpkoi-elements' ),
						'mobile'  => __( 'Mobile', 'wpkoi-elements' ),
					),
					'condition' => array(
						'wpkoi_tricks_widget_parallax' => 'true',
					),
					'render_type' => 'template',
				)
			);

			$obj->add_control(
				'wpkoi_satellite_heading',
				array(
					'label'     => esc_html__( 'Satellite', 'wpkoi-elements' ),
					'type'      => Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_satellite',
				array(
					'label'        => esc_html__( 'Use Satellite?', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
					'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
					'return_value' => 'true',
					'default'      => 'false',
					'render_type'  => 'template',
				)
			);

			$obj->start_controls_tabs( 'wpkoi_tricks_widget_satellite_tabs' );

			$obj->start_controls_tab(
				'wpkoi_tricks_widget_satellite_settings_tab',
				array(
					'label' => esc_html__( 'Settings', 'wpkoi-elements' ),
					'condition' => array(
						'wpkoi_tricks_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_satellite_type',
				array(
					'label'   => esc_html__( 'Type', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'text',
					'options' => array(
						'text'  => esc_html__( 'Text', 'wpkoi-elements' ),
						'icon'  => esc_html__( 'Icon', 'wpkoi-elements' ),
						'image' => esc_html__( 'Image', 'wpkoi-elements' ),
					),
					'condition' => array(
						'wpkoi_tricks_widget_satellite' => 'true',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_satellite_text',
				array(
					'label'   => esc_html__( 'Text', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Lorem Ipsum', 'wpkoi-elements' ),
					'condition' => array(
						'wpkoi_tricks_widget_satellite'      => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'text',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_satellite_icon_new',
				array(
					'label' => esc_html__( 'Icon', 'wpkoi-elements' ),
					'type' => Elementor\Controls_Manager::ICONS,
					'fa4compatibility' => 'wpkoi_tricks_widget_satellite_icon',
					'default' => array(
						'value' => 'fas fa-plus',
						'library' => 'fa-solid',
					),
					'condition' => array(
						'wpkoi_tricks_widget_satellite'      => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'icon',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_satellite_image',
				array(
					'label'   => esc_html__( 'Image', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::MEDIA,
					'default' => array(
						'url' => Elementor\Utils::get_placeholder_image_src(),
					),
					'condition' => array(
						'wpkoi_tricks_widget_satellite'     => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'image',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_satellite_position',
				array(
					'label'   => esc_html__( 'Position', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'top-center',
					'options' => array(
						'top-left'      => esc_html__( 'Top Left', 'wpkoi-elements' ),
						'top-center'    => esc_html__( 'Top Center', 'wpkoi-elements' ),
						'top-right'     => esc_html__( 'Top Right', 'wpkoi-elements' ),
						'middle-left'   => esc_html__( 'Middle Left', 'wpkoi-elements' ),
						'middle-center' => esc_html__( 'Middle Center', 'wpkoi-elements' ),
						'middle-right'  => esc_html__( 'Middle Right', 'wpkoi-elements' ),
						'bottom-left'   => esc_html__( 'Bottom Left', 'wpkoi-elements' ),
						'bottom-center' => esc_html__( 'Bottom Center', 'wpkoi-elements' ),
						'bottom-right'  => esc_html__( 'Bottom Right', 'wpkoi-elements' ),
					),
					'condition' => array(
						'wpkoi_tricks_widget_satellite' => 'true',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_satellite_x_offset',
				array(
					'label'      => esc_html__( 'x-Offset', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'range'      => array(
						'px' => array(
							'min' => -500,
							'max' => 500,
						),
					),
					'default' => array(
						'size' => 0,
						'unit' => 'px',
					),
					'selectors'  => array(
						'{{WRAPPER}} .wpkoi-tricks-satellite' => 'transform: translateX({{SIZE}}px);',
					),
					'condition' => array(
						'wpkoi_tricks_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_satellite_y_offset',
				array(
					'label'      => esc_html__( 'y-Offset', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'range'      => array(
						'px' => array(
							'min' => -500,
							'max' => 500,
						),
					),
					'default' => array(
						'size' => 0,
						'unit' => 'px',
					),
					'selectors'  => array(
						'{{WRAPPER}} .wpkoi-tricks-satellite__inner' => 'transform: translateY({{SIZE}}px);',
					),
					'condition' => array(
						'wpkoi_tricks_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_satellite_rotate',
				array(
					'label'      => esc_html__( 'Rotate', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array( 'deg' ),
					'range'      => array(
						'deg' => array(
							'min' => -180,
							'max' => 180,
						),
					),
					'default' => array(
						'size' => 0,
						'unit' => 'deg',
					),
					'selectors'  => array(
						'{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__text span' => 'transform: rotate({{SIZE}}deg)',
						'{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__icon .wpkoi-tricks-satellite__icon-instance' => 'transform: rotate({{SIZE}}deg)',
						'{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__image .wpkoi-tricks-satellite__image-instance' => 'transform: rotate({{SIZE}}deg)',
					),
					'condition' => array(
						'wpkoi_tricks_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_satellite_z',
				array(
					'label'   => esc_html__( 'z-Index', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 2,
					'min'     => 0,
					'max'     => 999,
					'step'    => 1,
					'condition' => array(
						'wpkoi_tricks_widget_satellite' => 'true',
					),
					'selectors'  => array(
						'{{WRAPPER}} .wpkoi-tricks-satellite' => 'z-index:{{VALUE}}',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->start_controls_tab(
				'wpkoi_tricks_widget_satellite_styles_tab',
				array(
					'label' => esc_html__( 'Styles', 'wpkoi-elements' ),
					'condition' => array(
						'wpkoi_tricks_widget_satellite' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_satellite_text_color',
				array(
					'label'  => esc_html__( 'Color', 'wpkoi-elements' ),
					'type'   => Elementor\Controls_Manager::COLOR,
					'condition' => array(
						'wpkoi_tricks_widget_satellite'      => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'text',
					),
					'selectors' => array(
						'{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__text' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_group_control(
				Elementor\Group_Control_Typography::get_type(),
				array(
					'name'     => 'wpkoi_tricks_widget_satellite_text_typography',
					'selector' => '{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__text',
					'condition' => array(
						'wpkoi_tricks_widget_satellite'      => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'text',
					),
				)
			);

			$obj->add_group_control(
				Elementor\Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => 'wpkoi_tricks_widget_satellite_text_shadow',
					'selector' => '{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__text',
					'condition' => array(
						'wpkoi_tricks_widget_satellite'      => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'text',
					),
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_satellite_image_width',
				array(
					'label'   => esc_html__( 'Width', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 200,
					'min'     => 10,
					'max'     => 1000,
					'step'    => 1,
					'condition' => array(
						'wpkoi_tricks_widget_satellite'      => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'image',
					),
					'selectors'  => array(
						'{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__image' => 'width:{{VALUE}}px',
					),
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_satellite_image_height',
				array(
					'label'   => esc_html__( 'Height', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 200,
					'min'     => 10,
					'max'     => 1000,
					'step'    => 1,
					'condition' => array(
						'wpkoi_tricks_widget_satellite'      => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'image',
					),
					'selectors'  => array(
						'{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__image' => 'height:{{VALUE}}px',
					),
				)
			);

			$obj->add_group_control(
				\WPKoi_Group_Control_Box_Style::get_type(),
				array(
					'label'     => esc_html__( 'Icon Box', 'wpkoi-elements' ),
					'name'      => 'wpkoi_tricks_widget_satellite_icon_box',
					'selector'  => '{{WRAPPER}} .wpkoi-tricks-satellite .wpkoi-tricks-satellite__icon-instance',
					'condition' => array(
						'wpkoi_tricks_widget_satellite'      => 'true',
						'wpkoi_tricks_widget_satellite_type' => 'icon',
					),
				)
			);

			if ( class_exists( 'Elementor\Group_Control_Css_Filter' ) ) {
				$obj->add_group_control(
					Elementor\Group_Control_Css_Filter::get_type(),
					array(
						'name'     => 'wpkoi_tricks_widget_satellite_css_filters',
						'selector' => '{{WRAPPER}} .wpkoi-tricks-satellite',
						'condition' => array(
							'wpkoi_tricks_widget_satellite'      => 'true',
						),
					)
				);
			}

			$obj->end_controls_tab();

			$obj->end_controls_tabs();

			$obj->add_control(
				'wpkoi_tooltip_heading',
				array(
					'label'     => esc_html__( 'Tooltip', 'wpkoi-elements' ),
					'type'      => Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip',
				array(
					'label'        => esc_html__( 'Use Tooltip?', 'wpkoi-elements' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
					'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
					'return_value' => 'true',
					'default'      => 'false',
					'render_type'  => 'template',
				)
			);

			$obj->start_controls_tabs( 'wpkoi_tricks_widget_tooltip_tabs' );

			$obj->start_controls_tab(
				'wpkoi_tricks_widget_tooltip_settings_tab',
				array(
					'label' => esc_html__( 'Settings', 'wpkoi-elements' ),
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_description',
				array(
					'label' => esc_html__( 'Description', 'wpkoi-elements' ),
					'type'  => Elementor\Controls_Manager::TEXTAREA,
					'render_type'  => 'template',
					'default'      => 'Lorem Ipsum',
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_placement',
				array(
					'label'   => esc_html__( 'Placement', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'top',
					'options' => array(
						'top'    => esc_html__( 'Top', 'wpkoi-elements' ),
						'bottom' => esc_html__( 'Bottom', 'wpkoi-elements' ),
						'left'   => esc_html__( 'Left', 'wpkoi-elements' ),
						'right'  => esc_html__( 'Right', 'wpkoi-elements' ),
					),
					'render_type'  => 'template',
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_animation',
				array(
					'label'   => esc_html__( 'Animation', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => 'shift-toward',
					'options' => array(
						'shift-away'   => esc_html__( 'Shift-Away', 'wpkoi-elements' ),
						'shift-toward' => esc_html__( 'Shift-Toward', 'wpkoi-elements' ),
						'fade'         => esc_html__( 'Fade', 'wpkoi-elements' ),
						'scale'        => esc_html__( 'Scale', 'wpkoi-elements' ),
						'perspective'  => esc_html__( 'Perspective', 'wpkoi-elements' ),
					),
					'render_type'  => 'template',
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_x_offset',
				array(
					'label'   => esc_html__( 'Offset', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 0,
					'min'     => -1000,
					'max'     => 1000,
					'step'    => 1,
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_y_offset',
				array(
					'label'   => esc_html__( 'Distance', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 0,
					'min'     => -1000,
					'max'     => 1000,
					'step'    => 1,
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_z_index',
				array(
					'label'   => esc_html__( 'z-Index', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::NUMBER,
					'default' => 999,
					'min'     => 0,
					'max'     => 999,
					'step'    => 1,
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->start_controls_tab(
				'wpkoi_tricks_widget_tooltip_styles_tab',
				array(
					'label' => esc_html__( 'Style', 'wpkoi-elements' ),
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_tooltip_width',
				array(
					'label'      => esc_html__( 'Width', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::SLIDER,
					'size_units' => array(
						'px', 'em',
					),
					'range'      => array(
						'px' => array(
							'min' => 50,
							'max' => 500,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} > .tippy-popper .tippy-tooltip' => 'width: {{SIZE}}{{UNIT}};',
					),
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
					'render_type'  => 'template',
				)
			);

			$obj->add_group_control(
				Elementor\Group_Control_Typography::get_type(),
				array(
					'name'     => 'wpkoi_tricks_widget_tooltip_typography',
					'selector' => '{{WRAPPER}} > .tippy-popper .tippy-tooltip .tippy-content',
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_color',
				array(
					'label'  => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type'   => Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} > .tippy-popper .tippy-tooltip' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_text_align',
				array(
					'label'   => esc_html__( 'Text Alignment', 'wpkoi-elements' ),
					'type'    => Elementor\Controls_Manager::CHOOSE,
					'default' => 'center',
					'options' => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'wpkoi-elements' ),
							'icon'  => 'fa fa-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'wpkoi-elements' ),
							'icon'  => 'fa fa-align-center',
						),
						'right' => array(
							'title' => esc_html__( 'Right', 'wpkoi-elements' ),
							'icon'  => 'fa fa-align-right',
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} > .tippy-popper .tippy-tooltip .tippy-content' => 'text-align: {{VALUE}};',
					),
				)
			);

			$obj->add_group_control(
				Elementor\Group_Control_Background::get_type(),
				array(
					'name'     => 'wpkoi_tricks_widget_tooltip_background',
					'selector' => '{{WRAPPER}} > .tippy-popper .tippy-tooltip',
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_control(
				'wpkoi_tricks_widget_tooltip_arrow_color',
				array(
					'label'  => esc_html__( 'Arrow Color', 'wpkoi-elements' ),
					'type'   => Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} > .tippy-popper[x-placement^=left] .tippy-tooltip .tippy-arrow'=> 'border-left-color: {{VALUE}}',
						'{{WRAPPER}} > .tippy-popper[x-placement^=right] .tippy-tooltip .tippy-arrow'=> 'border-right-color: {{VALUE}}',
						'{{WRAPPER}} > .tippy-popper[x-placement^=top] .tippy-tooltip .tippy-arrow'=> 'border-top-color: {{VALUE}}',
						'{{WRAPPER}} > .tippy-popper[x-placement^=bottom] .tippy-tooltip .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
					),
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_tooltip_padding',
				array(
					'label'      => __( 'Padding', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} > .tippy-popper .tippy-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'render_type'  => 'template',
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_group_control(
				Elementor\Group_Control_Border::get_type(),
				array(
					'name'        => 'wpkoi_tricks_widget_tooltip_border',
					'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} > .tippy-popper .tippy-tooltip',
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_responsive_control(
				'wpkoi_tricks_widget_tooltip_border_radius',
				array(
					'label'      => __( 'Border Radius', 'wpkoi-elements' ),
					'type'       => Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} > .tippy-popper .tippy-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->add_group_control(
				Elementor\Group_Control_Box_Shadow::get_type(),
				array(
					'name' => 'wpkoi_tricks_widget_tooltip_box_shadow',
					'selector' => '{{WRAPPER}} > .tippy-popper .tippy-tooltip',
					'condition' => array(
						'wpkoi_tricks_widget_tooltip' => 'true',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->end_controls_tabs();

			$obj->end_controls_section();
		}

		public function widget_before_render( $widget ) {
			$data     = $widget->get_data();
			$settings = $data['settings'];

			$settings = wp_parse_args( $settings, $this->default_widget_settings );

			$widget_settings = array();
			
			$parallax_settings = $widget->get_settings_for_display();

			if( $parallax_settings['adv_parallax_effects_show'] == 'yes' ) {

				$parallax_y_start    = ($parallax_settings['adv_parallax_effects_y_start']['size']) ? $parallax_settings['adv_parallax_effects_y_start']['size'] : 0;
				$parallax_y_end      = ($parallax_settings['adv_parallax_effects_y_end']['size']) ? $parallax_settings['adv_parallax_effects_y_end']['size'] : 0;
	
				$parallax_x_start    = $parallax_settings['adv_parallax_effects_x_start']['size'];
				$parallax_x_end      = $parallax_settings['adv_parallax_effects_x_end']['size'];
	
				$parallax_opacity_start    = ($parallax_settings['adv_parallax_effects_opacity_start']['size']) ? $parallax_settings['adv_parallax_effects_opacity_start']['size'] : 100;
				$parallax_opacity_end      = ($parallax_settings['adv_parallax_effects_opacity_end']['size']) ? $parallax_settings['adv_parallax_effects_opacity_end']['size'] : 100;
	
				$parallax_blur_start = ($parallax_settings['adv_parallax_effects_blur_start']['size']) ? $parallax_settings['adv_parallax_effects_blur_start']['size'] : 0;
				$parallax_blur_end   = ($parallax_settings['adv_parallax_effects_blur_end']['size']) ? $parallax_settings['adv_parallax_effects_blur_end']['size'] : 0;
	
				$parallax_rotate_start     = ($parallax_settings['adv_parallax_effects_rotate_value_start']['size']) ? $parallax_settings['adv_parallax_effects_rotate_value_start']['size'] : 0;
				$parallax_rotate_end     = ($parallax_settings['adv_parallax_effects_rotate_value_end']['size']) ? $parallax_settings['adv_parallax_effects_rotate_value_end']['size'] : 0;
	
				$parallax_scale      = $parallax_settings['adv_parallax_effects_scale_value']['size'];
	
				$parallax_hue        = $parallax_settings['adv_parallax_effects_hue_value']['size'];
	
				$parallax_grayscale  = $parallax_settings['adv_parallax_effects_grayscale_value']['size'];
	
				$parallax_saturate   = $parallax_settings['adv_parallax_effects_saturate_value']['size'];
	
				$parallax_sepia      = $parallax_settings['adv_parallax_effects_sepia_value']['size'];
	
				if ( $parallax_settings['adv_parallax_effects_y'] ) {
					$widget->add_render_attribute( "_wrapper", "data-uk-parallax", "y: '" . $parallax_y_start . "," . $parallax_y_end . "'," );
				}
	
				if ( $parallax_settings['adv_parallax_effects_x'] ) {
					$widget->add_render_attribute( "_wrapper", "data-uk-parallax", "x: '" . $parallax_x_start . "," . $parallax_x_end . "'," );
				}
	
				if ( $parallax_settings['adv_parallax_effects_opacity'] ) {
					$parallax_opacity_start_full = '0.' . $parallax_opacity_start;
					if ($parallax_opacity_start < 10){ $parallax_opacity_start_full = '0.0' . $parallax_opacity_start;}
					if ($parallax_opacity_start == 100){ $parallax_opacity_start_full = '1'; }
					$parallax_opacity_end_full = '0.' . $parallax_opacity_end;
					if ($parallax_opacity_end < 10){ $parallax_opacity_end_full = '0.0' . $parallax_opacity_end;}
					if ($parallax_opacity_end == 100){ $parallax_opacity_end_full = '1'; }
					
					$widget->add_render_attribute( "_wrapper", "data-uk-parallax", "opacity: '" . $parallax_opacity_start_full . "," . $parallax_opacity_end_full . "'," );
				}
	
				if ( $parallax_settings['adv_parallax_effects_blur'] ) {
					$widget->add_render_attribute( "_wrapper", "data-uk-parallax", "blur: '" . $parallax_blur_start . "," . $parallax_blur_end . "'," );
				}
	
				if ( $parallax_settings['adv_parallax_effects_rotate'] ) {
					$widget->add_render_attribute( "_wrapper", "data-uk-parallax", "rotate: '" . $parallax_rotate_start . "," . $parallax_rotate_end . "'," );
				}
	
				if ( $parallax_settings['adv_parallax_effects_scale'] ) {
					$widget->add_render_attribute( '_wrapper', 'data-uk-parallax', 'scale: ' . $parallax_scale . ',' );
				}
	
				if ( $parallax_settings['adv_parallax_effects_hue'] ) {
					$widget->add_render_attribute( '_wrapper', 'data-uk-parallax', 'hue: ' . $parallax_hue . ',' );
				}
	
				if ( $parallax_settings['adv_parallax_effects_grayscale'] ) {
					$widget->add_render_attribute( '_wrapper', 'data-uk-parallax', 'grayscale: ' . $parallax_grayscale . ',' );
				}
	
				if ( $parallax_settings['adv_parallax_effects_saturate'] ) {
					$widget->add_render_attribute( '_wrapper', 'data-uk-parallax', 'saturate: ' . $parallax_saturate . ',' );
				}
	
				if ( $parallax_settings['adv_parallax_effects_sepia'] ) {
					$widget->add_render_attribute( '_wrapper', 'data-uk-parallax', 'sepia: ' . $parallax_sepia . ',' );
				}
	
			}
		
			if ( filter_var( $settings['wpkoi_tricks_widget_parallax'], FILTER_VALIDATE_BOOLEAN ) ) {

				$widget_settings['parallax'] = filter_var( $settings['wpkoi_tricks_widget_parallax'], FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false';
				$widget_settings['invert']   = filter_var( $settings['wpkoi_tricks_widget_parallax_invert'], FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false';
				$widget_settings['speed']    = $settings['wpkoi_tricks_widget_parallax_speed'];
				$widget_settings['stickyOn'] = $settings['wpkoi_tricks_widget_parallax_on'];

				$widget->add_render_attribute( '_wrapper', array(
					'class' => 'wpkoi-parallax-widget',
				) );
			}

			if ( filter_var( $settings['wpkoi_tricks_widget_satellite'], FILTER_VALIDATE_BOOLEAN ) ) {
				$widget_settings['satellite'] = filter_var( $settings['wpkoi_tricks_widget_satellite'], FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false';
				$widget_settings['satelliteType'] = $settings['wpkoi_tricks_widget_satellite_type'];
				$widget_settings['satellitePosition'] = $settings['wpkoi_tricks_widget_satellite_position'];

				$widget->add_render_attribute( '_wrapper', array(
					'class' => 'wpkoi-satellite-widget',
				) );
			}

			if ( filter_var( $settings['wpkoi_tricks_widget_tooltip'], FILTER_VALIDATE_BOOLEAN ) ) {
				$widget_settings['tooltip'] = filter_var( $settings['wpkoi_tricks_widget_tooltip'], FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false';
				$widget_settings['tooltipDescription'] = $settings['wpkoi_tricks_widget_tooltip_description'];
				$widget_settings['tooltipPlacement'] = $settings['wpkoi_tricks_widget_tooltip_placement'];
				$widget_settings['xOffset'] = $settings['wpkoi_tricks_widget_tooltip_x_offset'];
				$widget_settings['yOffset'] = $settings['wpkoi_tricks_widget_tooltip_y_offset'];
				$widget_settings['tooltipAnimation'] = $settings['wpkoi_tricks_widget_tooltip_animation'];
				$widget_settings['zIndex'] = $settings['wpkoi_tricks_widget_tooltip_z_index'];

				$widget->add_render_attribute( '_wrapper', array(
					'class' => 'wpkoi-tooltip-widget',
				) );
			}

			$widget_settings = apply_filters(
				'wpkoi-tricks/frontend/widget/settings',
				$widget_settings,
				$widget,
				$this
			);

			if ( ! empty( $widget_settings ) ) {
				$widget->add_render_attribute( '_wrapper', array(
					'data-wpkoi-tricks-settings' => json_encode( $widget_settings ),
				) );
			}

			$this->widgets_data[ $data['id'] ] = $widget_settings;
		}

		public function widget_before_render_content( $widget ) {

			$data     = $widget->get_data();
			$settings = $data['settings'];

			$settings = wp_parse_args( $settings, $this->default_widget_settings );
			$settings = apply_filters( 'wpkoi-tricks/frontend/widget-content/settings', $settings, $widget, $this );

			if ( filter_var( $settings['wpkoi_tricks_widget_satellite'], FILTER_VALIDATE_BOOLEAN ) ) {
				switch ( $settings['wpkoi_tricks_widget_satellite_type'] ) {
					case 'text':

						if ( ! empty( $settings['wpkoi_tricks_widget_satellite_text'] ) ) {
							echo sprintf( '<div class="wpkoi-tricks-satellite wpkoi-tricks-satellite--%1$s"><div class="wpkoi-tricks-satellite__inner"><div class="wpkoi-tricks-satellite__text"><span>%2$s</span></div></div></div>', $settings['wpkoi_tricks_widget_satellite_position'], $settings['wpkoi_tricks_widget_satellite_text'] );
						}
					break;

					case 'icon':

						if ( ! empty( $settings['wpkoi_tricks_widget_satellite_icon_new'] ) || ! empty( $settings['wpkoi_tricks_widget_satellite_icon'] ) ) {
							echo sprintf( '<div class="wpkoi-tricks-satellite wpkoi-tricks-satellite--%1$s"><div class="wpkoi-tricks-satellite__inner"><div class="wpkoi-tricks-satellite__icon"><div class="wpkoi-tricks-satellite__icon-instance">', $settings['wpkoi_tricks_widget_satellite_position'] );
							
							$migrated = isset( $settings['__fa4_migrated']['wpkoi_tricks_widget_satellite_icon_new'] );
							$is_new = empty( $settings['wpkoi_tricks_widget_satellite_icon'] );
							if ( $is_new || $migrated ) :
								Elementor\Icons_Manager::render_icon( $settings['wpkoi_tricks_widget_satellite_icon_new'], [ 'aria-hidden' => 'true' ] );
							else : 
								echo '<i class="' . $settings['wpkoi_tricks_widget_satellite_icon'] . '" aria-hidden="true"></i>';
							endif;
							
							echo '</div></div></div></div>';
						}
					break;

					case 'image':

						if ( ! empty( $settings['wpkoi_tricks_widget_satellite_image']['url'] ) ) {
							echo sprintf( '<div class="wpkoi-tricks-satellite wpkoi-tricks-satellite--%1$s"><div class="wpkoi-tricks-satellite__inner"><div class="wpkoi-tricks-satellite__image"><img class="wpkoi-tricks-satellite__image-instance" src="%2$s" alt=""></div></div></div>', $settings['wpkoi_tricks_widget_satellite_position'], $settings['wpkoi_tricks_widget_satellite_image']['url'] );
						}
					break;
				}
			}

			if ( filter_var( $settings['wpkoi_tricks_widget_tooltip'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $settings['wpkoi_tricks_widget_tooltip_description'] ) ) {
				echo sprintf( '<div id="wpkoi-tricks-tooltip-content-%1$s" class="wpkoi-tooltip-widget__content">%2$s</div>', $data['id'], $settings['wpkoi_tricks_widget_tooltip_description'] );
			}
		}

		public function enqueue_scripts() {

			wp_enqueue_script(
				'wpkoi-resize-sensor',
				WPKOI_ELEMENTS_URL . 'assets/js/ResizeSensor.min.js',
				array( 'jquery' ),
				'1.7.0',
				true
			);

			wp_enqueue_script( 'wpkoi-tricks-tippy' );
			wp_enqueue_script('uikit',WPKOI_ELEMENTS_URL.'elements/effects/assets/uikit.js', array('jquery'),WPKOI_ELEMENTS_VERSION, true);
			wp_enqueue_script('uikit-parallax',WPKOI_ELEMENTS_URL.'elements/effects/assets/parallax.js', array('jquery'),WPKOI_ELEMENTS_VERSION, true);

			wpkoi_elements_integration()->elements_data['sections'] = $this->sections_data;
			wpkoi_elements_integration()->elements_data['columns'] = $this->columns_data;
			wpkoi_elements_integration()->elements_data['widgets'] = $this->widgets_data;
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
 * Returns instance of WPKoi_Elements_Effects_Extension
 */
function wpkoi_elements_effect_extension() {
	return WPKoi_Elements_Effects_Extension::get_instance();
}
wpkoi_elements_effect_extension()->init();