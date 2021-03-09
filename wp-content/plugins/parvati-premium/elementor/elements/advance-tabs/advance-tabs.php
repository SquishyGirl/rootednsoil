<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WPKoi_Elements_Adv_Tabs extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-adv-tabs';
	}

	public function get_title() {
		return esc_html__( 'Advanced Tabs', 'wpkoi-elements' );
	}

	public function get_script_depends() {
        return [
            'wpkoi-elements-scripts'
        ];
    }

	public function get_icon() {
		return 'eicon-tabs';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {
		/**
  		 * Advance Tabs Content Settings
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_adv_tabs_content_settings',
  			[
  				'label' => esc_html__( 'Tabs Settings', 'wpkoi-elements' )
  			]
  		);
		
		$repeater = new Repeater();

		$repeater->add_control(
			'wpkoi_elements_adv_tabs_tab_show_as_default',
			array(
				'label' => __( 'Set as Default', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'inactive',
				'return_value' => 'active-default',
			)
		);

		$repeater->add_control(
			'wpkoi_elements_adv_tabs_icon_type',
			array(
				'label'       => esc_html__( 'Icon Type', 'wpkoi-elements' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'none' => [
						'title' => esc_html__( 'None', 'wpkoi-elements' ),
						'icon'  => 'fa fa-ban',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'wpkoi-elements' ),
						'icon'  => 'fa fa-gear',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'wpkoi-elements' ),
						'icon'  => 'fa fa-picture-o',
					],
				],
				'default'       => 'icon',
			)
		);

		$repeater->add_control(
			'wpkoi_elements_adv_tabs_tab_title_icon_new',
			array(
				'label' => esc_html__( 'Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_adv_tabs_tab_title_icon',
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'condition' => [
					'wpkoi_elements_adv_tabs_icon_type' => 'icon'
				]
			)
		);

		$repeater->add_control(
			'wpkoi_elements_adv_tabs_tab_title_image',
			array(
				'label' => esc_html__( 'Image', 'wpkoi-elements' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'wpkoi_elements_adv_tabs_icon_type' => 'image'
				]
			)
		);

		$repeater->add_control(
			'wpkoi_elements_adv_tabs_tab_title',
			array(
				'label' => esc_html__( 'Tab Title', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Tab Title', 'wpkoi-elements' ),
				'dynamic' => [ 'active' => true ]
			)
		);

		$repeater->add_control(
			'wpkoi_elements_adv_tabs_text_type',
			array(
				'label'                 => __( 'Content Type', 'wpkoi-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'content'       => __( 'Content', 'wpkoi-elements' ),
					'template'      => __( 'Saved Templates', 'wpkoi-elements' ),
				],
				'default'               => 'content',
			)
		);

		$repeater->add_control(
			'wpkoi_elements_primary_templates',
			array(
				'label'                 => __( 'Choose Template', 'wpkoi-elements' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => wpkoi_elements_get_page_templates(),
				'condition'             => [
					'wpkoi_elements_adv_tabs_text_type'      => 'template',
				],
			)
		);

		$repeater->add_control(
			'wpkoi_elements_adv_tabs_tab_content',
			array(
				'label' => esc_html__( 'Tab Content', 'wpkoi-elements' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Add Your content here...', 'wpkoi-elements' ),
				'dynamic' => [ 'active' => true ],
				'condition'             => [
					'wpkoi_elements_adv_tabs_text_type'      => 'content',
				],
			)
		);
		
		$this->add_control(
			'wpkoi_elements_adv_tabs_tab',
			array(
				'type'    => Controls_Manager::REPEATER,
				'label'   => esc_html__( 'Tabs content', 'wpkoi-elements' ),
				'fields'  => $repeater->get_controls(),
				'seperator' => 'before',
				'default' => [
					[ 'wpkoi_elements_adv_tabs_tab_title' => esc_html__( 'Tab Title 1', 'wpkoi-elements' ) ],
					[ 'wpkoi_elements_adv_tabs_tab_title' => esc_html__( 'Tab Title 2', 'wpkoi-elements' ) ],
				],
				'title_field' => '{{wpkoi_elements_adv_tabs_tab_title}}',
			)
		);
		
		$this->add_control(
		  'wpkoi_elements_adv_tab_layout',
		  	[
		   	'label'       	=> esc_html__( 'Style', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'wpkoi-elements-tabs-horizontal',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'wpkoi-elements-tabs-horizontal' => esc_html__( 'Horizontal', 'wpkoi-elements' ),
		     		'wpkoi-elements-tabs-vertical' => esc_html__( 'Vertical', 'wpkoi-elements' ),
		     	],
		  	]
		);
		$this->add_control(
			'wpkoi_elements_adv_tabs_icon_show',
			[
				'label' => esc_html__( 'Enable Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
			]
		);
		$this->add_control(
		  'wpkoi_elements_adv_tab_icon_position',
		  	[
		   	'label'       	=> esc_html__( 'Icon Position', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'wpkoi-elements-tab-inline-icon',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'wpkoi-elements-tab-top-icon' => esc_html__( 'Stacked', 'wpkoi-elements' ),
		     		'wpkoi-elements-tab-inline-icon' => esc_html__( 'Inline', 'wpkoi-elements' ),
		     	],
		     	'condition' => [
		     		'wpkoi_elements_adv_tabs_icon_show' => 'yes'
		     	]
		  	]
		);
  		$this->end_controls_section();

  		
  		/**
		 * -------------------------------------------
		 * Tab Style Advance Tabs Generel Style
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_adv_tabs_style_settings',
			[
				'label' => esc_html__( 'General', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-advance-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-advance-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_adv_tabs_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs',
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-advance-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_adv_tabs_box_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs',
			]
		);
  		$this->end_controls_section();
  		/**
		 * -------------------------------------------
		 * Tab Style Advance Tabs Content Style
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_adv_tabs_tab_style_settings',
			[
				'label' => esc_html__( 'Tab Title', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name' => 'wpkoi_elements_adv_tabs_tab_title_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li',
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_title_width',
			[
				'label' => __( 'Title Min Width', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-advance-tabs.wpkoi-elements-tabs-vertical .wpkoi-elements-tabs-nav > ul' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'wpkoi_elements_adv_tab_layout' => 'wpkoi-elements-tabs-vertical'
				]
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_tab_icon_size',
			[
				'label' => __( 'Icon Size', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 16,
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li img' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_tab_icon_gap',
			[
				'label' => __( 'Icon Gap', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-tab-inline-icon li i, {{WRAPPER}} .wpkoi-elements-tab-inline-icon li img' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpkoi-elements-tab-top-icon li i, {{WRAPPER}} .wpkoi-elements-tab-top-icon li img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_tab_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_tab_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->start_controls_tabs( 'wpkoi_elements_adv_tabs_header_tabs' );
			// Normal State Tab
			$this->start_controls_tab( 'wpkoi_elements_adv_tabs_header_normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_color',
					[
						'label' => esc_html__( 'Tab Background Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#f1f1f1',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_text_color',
					[
						'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#333',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#333',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li i' => 'color: {{VALUE}};',
						]
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'wpkoi_elements_adv_tabs_tab_border',
						'label' => esc_html__( 'Border', 'wpkoi-elements' ),
						'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li',
					]
				);
				$this->add_responsive_control(
					'wpkoi_elements_adv_tabs_tab_border_radius',
					[
						'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
			 					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 			],
					]
				);
			$this->end_controls_tab();
			// Hover State Tab
			$this->start_controls_tab( 'wpkoi_elements_adv_tabs_header_hover', [ 'label' => esc_html__( 'Hover', 'wpkoi-elements' ) ] );
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_color_hover',
					[
						'label' => esc_html__( 'Tab Background Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#f1f1f1',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li:hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_text_color_hover',
					[
						'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#333',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_icon_color_hover',
					[
						'label' => esc_html__( 'Icon Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#333',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li:hover .fa' => 'color: {{VALUE}};',
						]
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'wpkoi_elements_adv_tabs_tab_border_hover',
						'label' => esc_html__( 'Border', 'wpkoi-elements' ),
						'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li:hover',
					]
				);
				$this->add_responsive_control(
					'wpkoi_elements_adv_tabs_tab_border_radius_hover',
					[
						'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
			 					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 			],
					]
				);
			$this->end_controls_tab();
			// Active State Tab
			$this->start_controls_tab( 'wpkoi_elements_adv_tabs_header_active', [ 'label' => esc_html__( 'Active', 'wpkoi-elements' ) ] );
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_color_active',
					[
						'label' => esc_html__( 'Tab Background Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#444',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active-default' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_text_color_active',
					[
						'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#fff',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active' => 'color: {{VALUE}};',
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active-deafult' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'wpkoi_elements_adv_tabs_tab_icon_color_active',
					[
						'label' => esc_html__( 'Icon Color', 'wpkoi-elements' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#fff',
						'selectors' => [
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active .fa' => 'color: {{VALUE}};',
							'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active-default .fa' => 'color: {{VALUE}};',
						]
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'wpkoi_elements_adv_tabs_tab_border_active',
						'label' => esc_html__( 'Border', 'wpkoi-elements' ),
						'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active, {{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active-default',
					]
				);
				$this->add_responsive_control(
					'wpkoi_elements_adv_tabs_tab_border_radius_active',
					[
						'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
			 					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li.active-default' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 			],
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();
  		$this->end_controls_section();

  		/**
		 * -------------------------------------------
		 * Tab Style Advance Tabs Content Style
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_adv_tabs_tab_content_style_settings',
			[
				'label' => esc_html__( 'Content', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'adv_tabs_content_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-content > div' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'adv_tabs_content_text_color',
			[
				'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-content > div' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name' => 'wpkoi_elements_adv_tabs_content_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-content > div',
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_content_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_adv_tabs_content_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-content > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_adv_tabs_content_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-content > div',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_adv_tabs_content_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-content > div',
				'separator' => 'before'
			]
		);
  		$this->end_controls_section();

  		/**
		 * -------------------------------------------
		 * Tab Style Advance Tabs Caret Style
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_adv_tabs_tab_caret_style_settings',
			[
				'label' => esc_html__( 'Caret', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'wpkoi_elements_adv_tabs_tab_caret_show',
			[
				'label' => esc_html__( 'Show Caret on Active Tab', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'wpkoi_elements_adv_tabs_tab_caret_size',
			[
				'label' => esc_html__( 'Caret Size', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10
				],
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li:after' => 'border-width: {{SIZE}}px; bottom: -{{SIZE}}px',
					'{{WRAPPER}} .wpkoi-elements-advance-tabs.wpkoi-elements-tabs-vertical .wpkoi-elements-tabs-nav > ul li:after' => 'right: -{{SIZE}}px; top: calc(50% - {{SIZE}}px) !important;',
				],
				'condition' => [
					'wpkoi_elements_adv_tabs_tab_caret_show' => 'yes'
				]
			]
		);
		$this->add_control(
			'wpkoi_elements_adv_tabs_tab_caret_color',
			[
				'label' => esc_html__( 'Caret Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#444',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-advance-tabs .wpkoi-elements-tabs-nav > ul li:after' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-advance-tabs.wpkoi-elements-tabs-vertical .wpkoi-elements-tabs-nav > ul li:after' => 'border-top-color: transparent; border-left-color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_adv_tabs_tab_caret_show' => 'yes'
				]
			]
		);
  		$this->end_controls_section();
	}

	protected function render() {

   		$settings = $this->get_settings_for_display();
   		$wpkoi_elements_find_default_tab = array();
   		$wpkoi_elements_adv_tab_id = 1;
		$wpkoi_elements_adv_tab_content_id = 1;
		   
		$this->add_render_attribute(
			'wpkoi_elements_tab_wrapper',
			[
				'id'				=> "wpkoi-elements-advance-tabs-{$this->get_id()}",
				'class'				=> [ 'wpkoi-elements-advance-tabs', $settings['wpkoi_elements_adv_tab_layout'] ],
				'data-tabid'		=> $this->get_id()
			]
		);
		if($settings['wpkoi_elements_adv_tabs_tab_caret_show'] != 'yes')
			$this->add_render_attribute('wpkoi_elements_tab_wrapper', 'class', 'active-caret-on');

		$this->add_render_attribute( 'wpkoi_elements_tab_icon_position', 'class', esc_attr($settings['wpkoi_elements_adv_tab_icon_position']) );
	?>
	<div <?php echo $this->get_render_attribute_string('wpkoi_elements_tab_wrapper'); ?>>
  		<div class="wpkoi-elements-tabs-nav">
		  <ul <?php echo $this->get_render_attribute_string('wpkoi_elements_tab_icon_position'); ?>>
	    	<?php foreach( $settings['wpkoi_elements_adv_tabs_tab'] as $tab ) : ?>
	      		<li class="<?php echo esc_attr( $tab['wpkoi_elements_adv_tabs_tab_show_as_default'] ); ?>"><?php if( $settings['wpkoi_elements_adv_tabs_icon_show'] === 'yes' ) : 
	      				if( $tab['wpkoi_elements_adv_tabs_icon_type'] === 'icon' ) : 
						$migrated = isset( $tab['__fa4_migrated']['wpkoi_elements_adv_tabs_tab_title_icon_new'] );
						$is_new = empty( $tab['wpkoi_elements_adv_tabs_tab_title_icon'] );
						if ( $is_new || $migrated ) :
							Icons_Manager::render_icon( $tab['wpkoi_elements_adv_tabs_tab_title_icon_new'], [ 'aria-hidden' => 'true' ] );
						else : ?><i class="<?php echo $tab['wpkoi_elements_adv_tabs_tab_title_icon']; ?>" aria-hidden="true"></i>
						<?php endif;
						elseif( $tab['wpkoi_elements_adv_tabs_icon_type'] === 'image' ) : ?>
	      					<img src="<?php echo esc_attr( $tab['wpkoi_elements_adv_tabs_tab_title_image']['url'] ); ?>">
	      				<?php endif; ?>
	      		<?php endif; ?> <span class="wpkoi-elements-tab-title"><?php echo $tab['wpkoi_elements_adv_tabs_tab_title']; ?></span></li>
	      	<?php endforeach; ?>
    		</ul>
  		</div>
  		<div class="wpkoi-elements-tabs-content">
  			<?php foreach( $settings['wpkoi_elements_adv_tabs_tab'] as $tab ) : $wpkoi_elements_find_default_tab[] = $tab['wpkoi_elements_adv_tabs_tab_show_as_default'];?>
    			<div class="clearfix <?php echo esc_attr( $tab['wpkoi_elements_adv_tabs_tab_show_as_default'] ); ?>">
      				<?php if( 'content' == $tab['wpkoi_elements_adv_tabs_text_type'] ) : ?>
						<?php echo do_shortcode( $tab['wpkoi_elements_adv_tabs_tab_content'] ); ?>
					<?php elseif( 'template' == $tab['wpkoi_elements_adv_tabs_text_type'] ) : ?>
						<?php
							if ( !empty( $tab['wpkoi_elements_primary_templates'] ) ) {
								$wpkoi_elements_template_id = $tab['wpkoi_elements_primary_templates'];
								$wpkoi_elements_frontend = new Frontend;
								echo $wpkoi_elements_frontend->get_builder_content( $wpkoi_elements_template_id, true );
							}
						?>
					<?php endif; ?>
    			</div>
			<?php endforeach; ?>
  		</div>
	</div>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Adv_Tabs() );