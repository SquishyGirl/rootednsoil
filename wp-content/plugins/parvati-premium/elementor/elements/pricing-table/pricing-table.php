<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WPKoi_Elements_Pricing_Table extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-pricing-table';
	}

	public function get_title() {
		return esc_html__( 'Pricing Table', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {

  		/**
  		 * Pricing Table Settings
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_pricing_table_settings',
  			[
  				'label' => esc_html__( 'Settings', 'wpkoi-elements' )
  			]
  		);

  		$this->add_control(
		  'wpkoi_elements_pricing_table_style',
		  	[
		   	'label'       	=> esc_html__( 'Pricing Style', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'style-1',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'style-1'  	=> esc_html__( 'Default', 'wpkoi-elements' ),
		     		'style-2' 	=> esc_html__( 'Pricing with icon', 'wpkoi-elements' ),
		     	],
		  	]
		);

		/**
		 * Condition: 'wpkoi_elements_pricing_table_featured' => 'yes'
		 */
		$this->add_control(
			'wpkoi_elements_pricing_table_icon_enabled',
			[
				'label' => esc_html__( 'List Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'show',
				'default' => 'show',
				'condition' => [
					'wpkoi_elements_pricing_table_style' => 'style-2'
				]
			]
		);

  		$this->add_control(
			'wpkoi_elements_pricing_table_title',
			[
				'label' => esc_html__( 'Title', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( 'Startup', 'wpkoi-elements' )
			]
		);

		/**
		 * Condition: 'wpkoi_elements_pricing_table_style' => 'style-2'
		 */
		$this->add_control(
			'wpkoi_elements_pricing_table_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( 'A tagline here.', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_pricing_table_style' => 'style-2'
				]
			]
		);

		/**
		 * Condition: 'wpkoi_elements_pricing_table_style' => 'style-2'
		 */
		$this->add_control(
			'wpkoi_elements_pricing_table_style_2_icon_new',
			[
				'label' => esc_html__( 'Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_pricing_table_style_2_icon',
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_style' => 'style-2'
				]
			]
		);

  		$this->end_controls_section();

  		/**
  		 * Pricing Table Price
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_pricing_table_price',
  			[
  				'label' => esc_html__( 'Price', 'wpkoi-elements' )
  			]
  		);

		$this->add_control(
			'wpkoi_elements_pricing_table_price',
			[
				'label' => esc_html__( 'Price', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( '99', 'wpkoi-elements' )
			]
		);
		$this->add_control(
			'wpkoi_elements_pricing_table_onsale',
			[
				'label' => __( 'On Sale?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __( 'Yes', 'wpkoi-elements' ),
				'label_off' => __( 'No', 'wpkoi-elements' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'wpkoi_elements_pricing_table_onsale_price',
			[
				'label' => esc_html__( 'Sale Price', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( '89', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_pricing_table_onsale' => 'yes'
				]
			]
		);
  		$this->add_control(
			'wpkoi_elements_pricing_table_price_cur',
			[
				'label' => esc_html__( 'Price Currency', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( '$', 'wpkoi-elements' ),
			]
		);

		$this->add_control(
		  'wpkoi_elements_pricing_table_price_cur_placement',
		  	[
		   	'label'       	=> esc_html__( 'Currency Placement', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'left',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'left'  	=> esc_html__( 'Left', 'wpkoi-elements' ),
		     		'right'  	=> esc_html__( 'Right', 'wpkoi-elements' ),
		     	],
		  	]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_price_period',
			[
				'label' => esc_html__( 'Price Period (per)', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( 'month', 'wpkoi-elements' )
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_period_separator',
			[
				'label' => esc_html__( 'Period Separator', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( '/', 'wpkoi-elements' )
			]
		);

  		$this->end_controls_section();

  		/**
  		 * Pricing Table Feature
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_pricing_table_feature',
  			[
  				'label' => esc_html__( 'Feature', 'wpkoi-elements' )
  			]
  		);
		
		$repeater = new Repeater();

		$repeater->add_control(
			'wpkoi_elements_pricing_table_item',
			array(
				'label' => esc_html__( 'List Item', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Pricing table list item', 'wpkoi-elements' )
			)
		);

		$repeater->add_control(
			'wpkoi_elements_pricing_table_list_icon_new',
			array(
				'label' => esc_html__( 'List Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_pricing_table_list_icon'
			)
		);

		$repeater->add_control(
			'wpkoi_elements_pricing_table_icon_mood',
			array(
				'label' => esc_html__( 'Item Active?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);

		$repeater->add_control(
			'wpkoi_elements_pricing_table_list_icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#00C853',
			)
		);
		
		$this->add_control(
			'wpkoi_elements_pricing_table_items',
			array(
				'type'    => Controls_Manager::REPEATER,
				'label'   => esc_html__( 'Table items', 'wpkoi-elements' ),
				'fields'  => $repeater->get_controls(),
				'seperator' => 'before',
				'default' => [
					[ 'wpkoi_elements_pricing_table_item' => 'Unlimited calls' ],
					[ 'wpkoi_elements_pricing_table_item' => 'Free hosting' ],
					[ 'wpkoi_elements_pricing_table_item' => '500 MB of storage space' ],
					[ 'wpkoi_elements_pricing_table_item' => '500 MB Bandwidth' ],
					[ 'wpkoi_elements_pricing_table_item' => '24/7 support' ]
				],
				'title_field' => '{{wpkoi_elements_pricing_table_item}}',
			)
		);

  		$this->end_controls_section();

  		/**
  		 * Pricing Table Footer
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_pricing_table_footerr',
  			[
  				'label' => esc_html__( 'Footer', 'wpkoi-elements' )
  			]
  		);

  		$this->add_control(
			'wpkoi_elements_pricing_table_button_icon_new',
			[
				'label' => esc_html__( 'Button Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_pricing_table_button_icon',
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_button_icon_alignment',
			[
				'label' => esc_html__( 'Icon Position', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', 'wpkoi-elements' ),
					'right' => esc_html__( 'After', 'wpkoi-elements' ),
				],
				'condition' => [
					'wpkoi_elements_pricing_table_button_icon!' => '',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_button_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 60,
					],
				],
				'condition' => [
					'wpkoi_elements_pricing_table_button_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing-button.fa-icon-left i' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .wpkoi-elements-pricing-button.fa-icon-right i' => 'margin-left: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_btn',
			[
				'label' => esc_html__( 'Button Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Choose Plan', 'wpkoi-elements' ),
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_btn_link',
			[
				'label' => esc_html__( 'Button Link', 'wpkoi-elements' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
        			'url' => '#',
        			'is_external' => '',
     			],
     			'show_external' => true,
			]
		);

  		$this->end_controls_section();

  		/**
  		 * Pricing Table Rebon
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_pricing_table_featured',
  			[
  				'label' => esc_html__( 'Ribbon', 'wpkoi-elements' )
  			]
  		);

  		$this->add_control(
			'wpkoi_elements_pricing_table_featured',
			[
				'label' => esc_html__( 'Featured?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_featured_styles',
			[
				'label' => esc_html__( 'Ribbon Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ribbon-1',
				'options' => [
					'ribbon-1' => esc_html__( 'Style 1', 'wpkoi-elements' ),
					'ribbon-2' => esc_html__( 'Style 2', 'wpkoi-elements' ),
					'ribbon-3' => esc_html__( 'Style 3', 'wpkoi-elements' ),
				],
				'condition' => [
					'wpkoi_elements_pricing_table_featured' => 'yes',
				],
			]
		);

		/**
		 * Condition: 'wpkoi_elements_pricing_table_featured_styles' => [ 'ribbon-2', 'ribbon-3' ], 'wpkoi_elements_pricing_table_featured' => 'yes'
		 */
		$this->add_control(
			'wpkoi_elements_pricing_table_featured_tag_text',
			[
				'label' => esc_html__( 'Featured Tag Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( 'Featured', 'wpkoi-elements' ),
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.featured:before' => 'content: "{{VALUE}}";',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.featured:before' => 'content: "{{VALUE}}";',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_featured_styles' => [ 'ribbon-2', 'ribbon-3' ],
					'wpkoi_elements_pricing_table_featured' => 'yes'
				]
			]
		);

  		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Pricing Table Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_pricing_table_style_settings',
			[
				'label' => esc_html__( 'Pricing Table Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_pricing_table_container_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_pricing_table_container_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_pricing_table_border',
				'label' => esc_html__( 'Border Type', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-item',
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 4,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-item' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_pricing_table_shadow',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-item',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_pricing_table_content_alignment',
			[
				'label' => esc_html__( 'Content Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'prefix_class' => 'wpkoi-elements-pricing-content-align-',
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_pricing_table_content_button_alignment',
			[
				'label' => esc_html__( 'Button Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'prefix_class' => 'wpkoi-elements-pricing-button-align-',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Style (Header)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_pricing_table_header_style_settings',
			[
				'label' => esc_html__( 'Header', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_title_heading',
			[
				'label' => esc_html__( 'Title Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_title_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing-item .header .title' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_style_2_title_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C8E6C9',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .header' => 'background: {{VALUE}};'
				],
				'condition' => [
					'wpkoi_elements_pricing_table_style' => ['style-2']
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_style_1_title_line_color',
			[
				'label' => esc_html__( 'Line Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#dbdbdb',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item .header:after' => 'background: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_style' => ['style-1']
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_pricing_table_title_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing-item .header .title',
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_subtitle_heading',
			[
				'label' => esc_html__( 'Subtitle Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'wpkoi_elements_pricing_table_style!' => 'style-1'
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_subtitle_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing-item .header .subtitle' => 'color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_style!' => 'style-1'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' => 'wpkoi_elements_pricing_table_subtitle_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing-item .header .subtitle',
				'condition' => [
					'wpkoi_elements_pricing_table_style!' => 'style-1'
				]
			]

		);

		$this->end_controls_section();


		/**
		 * -------------------------------------------
		 * Style (Pricing)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_pricing_table_title_style_settings',
			[
				'label' => esc_html__( 'Pricing', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_price_tag_onsale_heading',
			[
				'label' => esc_html__( 'Original Price', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' =>  'before'
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_pricing_onsale_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#999',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing-item .muted-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            'name' => 'wpkoi_elements_pricing_table_price_tag_onsale_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing-item .muted-price',
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_price_tag_heading',
			[
				'label' => esc_html__( 'Sale Price', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' =>  'before'
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_pricing_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing-item .price-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            'name' => 'wpkoi_elements_pricing_table_price_tag_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing-item .price-tag',
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_price_currency_heading',
			[
				'label' => esc_html__( 'Currency', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' =>  'before'
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_pricing_curr_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#00C853',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing-item .price-tag .price-currency' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            'name' => 'wpkoi_elements_pricing_table_price_cur_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing-item .price-currency',
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_pricing_table_price_cur_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-pricing-item .price-currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		
		$this->add_control(
			'wpkoi_elements_pricing_table_pricing_period_heading',
			[
				'label' => esc_html__( 'Pricing Period', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_pricing_period_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing-item .price-period' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            'name' => 'wpkoi_elements_pricing_table_price_preiod_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing-item .price-period',
			]
		);


		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Style (Feature List)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_pricing_table_style_featured_list_settings',
			[
				'label' => esc_html__( 'Feature List', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_list_item_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing-item .body ul li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            'name' => 'wpkoi_elements_pricing_table_list_item_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing-item .body ul li',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Style (Ribbon)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_pricing_table_style_3_featured_tag_settings',
			[
				'label' => esc_html__( 'Ribbon', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_style_1_featured_bar_color',
			[
				'label' => esc_html__( 'Line Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#00C853',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-1:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-1:before' => 'background: {{VALUE}};'
				],
				'condition' => [
					'wpkoi_elements_pricing_table_featured' => 'yes',
					'wpkoi_elements_pricing_table_featured_styles' => 'ribbon-1'
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_style_1_featured_bar_height',
			[
				'label' => esc_html__( 'Line Height', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 3
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-1:before' => 'height: {{SIZE}}px;',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-1:before' => 'height: {{SIZE}}px;',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_featured' => 'yes',
					'wpkoi_elements_pricing_table_featured_styles' => 'ribbon-1'
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_featured_tag_font_size',
			[
				'label' => esc_html__( 'Font Size', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10
				],
				'range' => [
					'px' => [
						'max' => 18,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-2:before' => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-2:before' => 'font-size: {{SIZE}}px;',

					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-3:before' => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-3:before' => 'font-size: {{SIZE}}px;',

				],
				'condition' => [
					'wpkoi_elements_pricing_table_featured' => 'yes',
					'wpkoi_elements_pricing_table_featured_styles' => ['ribbon-2', 'ribbon-3']
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_featured_tag_text_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-2:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-2:before' => 'color: {{VALUE}};',

					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-3:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-3:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_featured' => 'yes',
					'wpkoi_elements_pricing_table_featured_styles' => ['ribbon-2', 'ribbon-3']
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_featured_tag_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-2:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-2:after' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-1 .wpkoi-elements-pricing-item.ribbon-3:before' => 'background: {{VALUE}};',

					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-2:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-2:after' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item.ribbon-3:before' => 'background: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_featured' => 'yes',
					'wpkoi_elements_pricing_table_featured_styles' => ['ribbon-2', 'ribbon-3']
				],
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Pricing Table Icon Style)
		 * Condition: 'wpkoi_elements_pricing_table_style' => 'style-2'
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_pricing_table_icon_settings',
			[
				'label' => esc_html__( 'Icon Settings', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'wpkoi_elements_pricing_table_style' => 'style-2'
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_icon_bg_show',
			[
				'label' => __( 'Show Background', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Show', 'wpkoi-elements' ),
				'label_off' => __( 'Hide', 'wpkoi-elements' ),
				'return_value' => 'yes',
			]
		);

		/**
		 * Condition: 'wpkoi_elements_pricing_table_icon_bg_show' => 'yes'
		 */
		$this->add_control(
			'wpkoi_elements_pricing_table_icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .wpkoi-elements-pricing-icon .icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_icon_bg_show' => 'yes'
				]
			]
		);

		/**
		 * Condition: 'wpkoi_elements_pricing_table_icon_bg_show' => 'yes'
		 */
		$this->add_control(
			'wpkoi_elements_pricing_table_icon_bg_hover_color',
			[
				'label' => esc_html__( 'Background Hover Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item:hover .wpkoi-elements-pricing-icon .icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_icon_bg_show' => 'yes'
				],
				'separator'=> 'after',
			]
		);


		$this->add_control(
			'wpkoi_elements_pricing_table_icon_settings',
			[
				'label' => esc_html__( 'Icon Size', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30
				],
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .wpkoi-elements-pricing-icon .icon i' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_icon_area_width',
			[
				'label' => esc_html__( 'Icon Area Width', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 80
				],
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .wpkoi-elements-pricing-icon .icon' => 'width: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_icon_area_height',
			[
				'label' => esc_html__( 'Icon Area Height', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 80
				],
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .wpkoi-elements-pricing-icon .icon' => 'height: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_icon_line_height',
			[
				'label' => esc_html__( 'Icon Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 80
				],
				'range' => [
					'px' => [
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .wpkoi-elements-pricing-icon .icon i' => 'line-height: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .wpkoi-elements-pricing-icon .icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item:hover .wpkoi-elements-pricing-icon .icon i' => 'color: {{VALUE}};',
				],
				'separator' => 'after'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_pricing_table_icon_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .wpkoi-elements-pricing-icon .icon',
				]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_icon_border_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item:hover .wpkoi-elements-pricing-icon .icon' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_pricing_table_icon_border_border!' => ''
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_pricing_table_icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-pricing.style-2 .wpkoi-elements-pricing-item .wpkoi-elements-pricing-icon .icon' => 'border-radius: {{SIZE}}%;',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Button Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_pricing_table_btn_style_settings',
			[
				'label' => esc_html__( 'Button', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_pricing_table_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_pricing_table_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
	         'name' => 'wpkoi_elements_pricing_table_btn_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button',
			]
		);

		$this->start_controls_tabs( 'wpkoi_elements_cta_button_tabs' );

			// Normal State Tab
			$this->start_controls_tab( 'wpkoi_elements_pricing_table_btn_normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_pricing_table_btn_normal_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_pricing_table_btn_normal_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#00C853',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
			Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_pricing_table_btn_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button',
				]
			);

			$this->add_control(
				'wpkoi_elements_pricing_table_btn_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button' => 'border-radius: {{SIZE}}px;',
					],
				]
			);

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'wpkoi_elements_pricing_table_btn_hover', [ 'label' => esc_html__( 'Hover', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_pricing_table_btn_hover_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#f9f9f9',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_pricing_table_btn_hover_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#03b048',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button:hover' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_pricing_table_btn_hover_border_color',
				[
					'label' => esc_html__( 'Border Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button:hover' => 'border-color: {{VALUE}};',
					],
				]

			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_cta_button_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-pricing .wpkoi-elements-pricing-button',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

	}


	protected function render( ) {

   	$settings = $this->get_settings();
      $pricing_table_image = $this->get_settings( 'wpkoi_elements_pricing_table_image' );
	  	$pricing_table_image_url = Group_Control_Image_Size::get_attachment_image_src( $pricing_table_image['id'], 'thumbnail', $settings );
		$target = $settings['wpkoi_elements_pricing_table_btn_link']['is_external'] ? 'target="_blank"' : '';
		$nofollow = $settings['wpkoi_elements_pricing_table_btn_link']['nofollow'] ? 'rel="nofollow"' : '';
		if( 'yes' === $settings['wpkoi_elements_pricing_table_featured'] ) : $featured_class = 'featured '.$settings['wpkoi_elements_pricing_table_featured_styles']; else : $featured_class = ''; endif;

		if( 'yes' === $settings['wpkoi_elements_pricing_table_onsale'] ) {
			if( $settings['wpkoi_elements_pricing_table_price_cur_placement'] == 'left' ) {
				$pricing = '<del class="muted-price"><span class="muted-price-currency">'.$settings['wpkoi_elements_pricing_table_price_cur'].'</span>'.$settings['wpkoi_elements_pricing_table_price'].'</del> <span class="price-currency">'.$settings['wpkoi_elements_pricing_table_price_cur'].'</span>'.$settings['wpkoi_elements_pricing_table_onsale_price'];
			}else if( $settings['wpkoi_elements_pricing_table_price_cur_placement'] == 'right' ) {
				$pricing = '<del class="muted-price">'.$settings['wpkoi_elements_pricing_table_price'].'<span class="muted-price-currency">'.$settings['wpkoi_elements_pricing_table_price_cur'].'</span></del> '.$settings['wpkoi_elements_pricing_table_onsale_price'].'<span class="price-currency">'.$settings['wpkoi_elements_pricing_table_price_cur'].'</span>';
			}
		}else {
			if( $settings['wpkoi_elements_pricing_table_price_cur_placement'] == 'left' ) {
				$pricing = '<span class="price-currency">'.$settings['wpkoi_elements_pricing_table_price_cur'].'</span>'.$settings['wpkoi_elements_pricing_table_price'];
			}else if( $settings['wpkoi_elements_pricing_table_price_cur_placement'] == 'right' ) {
				$pricing = $settings['wpkoi_elements_pricing_table_price'].'<span class="price-currency">'.$settings['wpkoi_elements_pricing_table_price_cur'].'</span>';
			}
		}
	?>
	<?php if( 'style-1' === $settings['wpkoi_elements_pricing_table_style'] ) : ?>
	<div class="wpkoi-elements-pricing style-1">
	    <div class="wpkoi-elements-pricing-item <?php echo esc_attr( $featured_class ); ?>">
	        <div class="header">
	            <h2 class="title"><?php echo $settings['wpkoi_elements_pricing_table_title']; ?></h2>
	        </div>
	        <div class="wpkoi-elements-pricing-tag">
	            <span class="price-tag"><?php echo $pricing; ?></span>
	            <span class="price-period"><?php echo $settings['wpkoi_elements_pricing_table_period_separator']; ?> <?php echo $settings['wpkoi_elements_pricing_table_price_period']; ?></span>
	        </div>
	        <div class="body">
	            <ul>
	            	<?php
	            		foreach( $settings['wpkoi_elements_pricing_table_items'] as $item ) :
	            		if( 'yes' === $item['wpkoi_elements_pricing_table_icon_mood'] ) : $icon_mood = ''; else : $icon_mood = 'disable-item'; endif;
	            	?>
	                	<li class="<?php echo esc_attr( $icon_mood ); ?>">
	                		<?php if( 'show' === $settings['wpkoi_elements_pricing_table_icon_enabled'] ) : ?>
	                		<span class="li-icon" style="color:<?php echo esc_attr( $item['wpkoi_elements_pricing_table_list_icon_color'] ); ?>"><?php   
			$migrated = isset( $item['__fa4_migrated']['wpkoi_elements_pricing_table_list_icon_new'] );
			$is_new = empty( $item['wpkoi_elements_pricing_table_list_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $item['wpkoi_elements_pricing_table_list_icon_new'], [ 'aria-hidden' => 'true' ] );
			else : ?><i class="<?php echo $item['wpkoi_elements_pricing_table_list_icon']; ?>" aria-hidden="true"></i><?php endif; ?></span>
	                		<?php endif; ?>
	                		<?php echo $item['wpkoi_elements_pricing_table_item']; ?>
	                	</li>
	               <?php endforeach; ?>
	            </ul>
	        </div>
	        <div class="footer">
		    	<a href="<?php echo esc_url( $settings['wpkoi_elements_pricing_table_btn_link']['url'] ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> class="wpkoi-elements-pricing-button<?php if( 'left' == $settings['wpkoi_elements_pricing_table_button_icon_alignment'] ) { ?> fa-icon-left<?php } ?><?php if( 'right' == $settings['wpkoi_elements_pricing_table_button_icon_alignment'] ) { ?> fa-icon-right<?php } ?>">
		    		<?php if( 'left' == $settings['wpkoi_elements_pricing_table_button_icon_alignment'] ) : ?>
						<?php   
			$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_pricing_table_button_icon_new'] );
			$is_new = empty( $settings['wpkoi_elements_pricing_table_button_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['wpkoi_elements_pricing_table_button_icon_new'], [ 'aria-hidden' => 'true' ] );
			else : ?><i class="<?php echo $settings['wpkoi_elements_pricing_table_button_icon']; ?>" aria-hidden="true"></i><?php endif; ?>
						<?php echo $settings['wpkoi_elements_pricing_table_btn']; ?>
					<?php elseif( 'right' == $settings['wpkoi_elements_pricing_table_button_icon_alignment'] ) : ?>
						<?php echo $settings['wpkoi_elements_pricing_table_btn']; ?>
		        		<?php   
			$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_pricing_table_button_icon_new'] );
			$is_new = empty( $settings['wpkoi_elements_pricing_table_button_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['wpkoi_elements_pricing_table_button_icon_new'], [ 'aria-hidden' => 'true' ] );
			else : ?><i class="<?php echo $settings['wpkoi_elements_pricing_table_button_icon']; ?>" aria-hidden="true"></i><?php endif; ?>
		        	<?php endif; ?>
		    	</a>
		    </div>
	    </div>
	</div>
	<?php elseif( 'style-2' === $settings['wpkoi_elements_pricing_table_style'] ) : ?>
	<div class="wpkoi-elements-pricing style-2">
	    <div class="wpkoi-elements-pricing-item <?php echo esc_attr( $featured_class ); ?>">
	        <div class="wpkoi-elements-pricing-icon">
	            <span class="icon" style="background:<?php if('yes' != $settings['wpkoi_elements_pricing_table_icon_bg_show']) : echo 'none'; endif;  ?>;"><?php   
			$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_pricing_table_style_2_icon_new'] );
			$is_new = empty( $settings['wpkoi_elements_pricing_table_style_2_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['wpkoi_elements_pricing_table_style_2_icon_new'], [ 'aria-hidden' => 'true' ] );
			else : ?><i class="<?php echo $settings['wpkoi_elements_pricing_table_style_2_icon']; ?>" aria-hidden="true"></i><?php endif; ?></span>
	        </div>
	        <div class="header">
	            <h2 class="title"><?php echo $settings['wpkoi_elements_pricing_table_title']; ?></h2>
	            <span class="subtitle"><?php echo $settings['wpkoi_elements_pricing_table_sub_title']; ?></span>
	        </div>
	        <div class="wpkoi-elements-pricing-tag">
	            <span class="price-tag"><?php echo $pricing; ?></span>
	            <span class="price-period"><?php echo $settings['wpkoi_elements_pricing_table_period_separator']; ?> <?php echo $settings['wpkoi_elements_pricing_table_price_period']; ?></span>
	        </div>
	        <div class="body">
	            <ul>
	            	<?php
	            		foreach( $settings['wpkoi_elements_pricing_table_items'] as $item ) :
	            		if( 'yes' === $item['wpkoi_elements_pricing_table_icon_mood'] ) : $icon_mood = ''; else : $icon_mood = 'disable-item'; endif;
	            	?>
	                	<li class="<?php echo esc_attr( $icon_mood ); ?>">
	                		<?php if( 'show' === $settings['wpkoi_elements_pricing_table_icon_enabled'] ) : ?>
	                		<span class="li-icon" style="color:<?php echo esc_attr( $item['wpkoi_elements_pricing_table_list_icon_color'] ); ?>"><?php   
			$migrated = isset( $item['__fa4_migrated']['wpkoi_elements_pricing_table_list_icon_new'] );
			$is_new = empty( $item['wpkoi_elements_pricing_table_list_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $item['wpkoi_elements_pricing_table_list_icon_new'], [ 'aria-hidden' => 'true' ] );
			else : ?><i class="<?php echo $item['wpkoi_elements_pricing_table_list_icon']; ?>" aria-hidden="true"></i><?php endif; ?></span>
	                		<?php endif; ?>
	                		<?php echo $item['wpkoi_elements_pricing_table_item']; ?>
	                	</li>
	               <?php endforeach; ?>
	            </ul>
	        </div>
	        <div class="footer">
		    	<a href="<?php echo esc_url( $settings['wpkoi_elements_pricing_table_btn_link']['url'] ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> class="wpkoi-elements-pricing-button<?php if( 'left' == $settings['wpkoi_elements_pricing_table_button_icon_alignment'] ) { ?> fa-icon-left<?php } ?><?php if( 'right' == $settings['wpkoi_elements_pricing_table_button_icon_alignment'] ) { ?> fa-icon-right<?php } ?>">
		    		<?php if( 'left' == $settings['wpkoi_elements_pricing_table_button_icon_alignment'] ) : ?>
						<?php   
			$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_pricing_table_button_icon_new'] );
			$is_new = empty( $settings['wpkoi_elements_pricing_table_button_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['wpkoi_elements_pricing_table_button_icon_new'], [ 'aria-hidden' => 'true' ] );
			else : ?><i class="<?php echo $settings['wpkoi_elements_pricing_table_button_icon']; ?>" aria-hidden="true"></i><?php endif; ?>
						<?php echo $settings['wpkoi_elements_pricing_table_btn']; ?>
					<?php elseif( 'right' == $settings['wpkoi_elements_pricing_table_button_icon_alignment'] ) : ?>
						<?php echo $settings['wpkoi_elements_pricing_table_btn']; ?>
		        		<?php   
			$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_pricing_table_button_icon_new'] );
			$is_new = empty( $settings['wpkoi_elements_pricing_table_button_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['wpkoi_elements_pricing_table_button_icon_new'], [ 'aria-hidden' => 'true' ] );
			else : ?><i class="<?php echo $settings['wpkoi_elements_pricing_table_button_icon']; ?>" aria-hidden="true"></i><?php endif; ?>
		        	<?php endif; ?>
		    	</a>
		    </div>
	    </div>
	</div>
	<?php endif; ?>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Pricing_Table() );