<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WPKoi_Elements_Filterable_Gallery extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-filterable-gallery';
	}

	public function get_title() {
		return esc_html__( 'Filterable Gallery', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

  	public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	public function get_script_depends() {
        return [
            'wpkoi-elements-scripts'
        ];
    }

	protected function register_controls() {
		/**
  		 * Filter Gallery Settings
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_fg_settings',
  			[
  				'label' => esc_html__( 'Filterable Gallery Settings', 'wpkoi-elements' )
  			]
		);
		
		$this->add_control(
			'wpkoi_elements_fg_all_label_text',
			[
				'label'		=> esc_html__( 'Gallery All Label', 'wpkoi-elements' ),
				'type'		=> Controls_Manager::TEXT,
				'default'	=> 'All',
			]
		);

  		$this->add_control(
			'wpkoi_elements_fg_columns',
			[
				'label' => esc_html__( 'Number of Columns', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wpkoi-elements-col-3',
				'options' => [
					'wpkoi-elements-col-1' => esc_html__( 'Single Column', 'wpkoi-elements' ),
					'wpkoi-elements-col-2' => esc_html__( 'Two Columns', 'wpkoi-elements' ),
					'wpkoi-elements-col-3' => esc_html__( 'Three Columns', 'wpkoi-elements' ),
					'wpkoi-elements-col-4' => esc_html__( 'Four Columns', 'wpkoi-elements' ),
					'wpkoi-elements-col-5' => esc_html__( 'Five Columns', 'wpkoi-elements' ),
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_grid_style',
			[
				'label' => esc_html__( 'Grid Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wpkoi-elements-hoverer',
				'options' => [
					'wpkoi-elements-hoverer' 	=> esc_html__( 'Hoverer', 'wpkoi-elements' ),
					'wpkoi-elements-tiles' 	=> esc_html__( 'Tiles', 'wpkoi-elements' ),
					'wpkoi-elements-cards' 	=> esc_html__( 'Cards', 'wpkoi-elements' ),
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_grid_hover_style',
			[
				'label' => esc_html__( 'Hover Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wpkoi-elements-zoom-in',
				'options' => [
					'wpkoi-elements-zoom-in' 		=> esc_html__( 'Zoom In', 'wpkoi-elements' ),
					'wpkoi-elements-slide-left' 	=> esc_html__( 'Slide In Left', 'wpkoi-elements' ),
					'wpkoi-elements-slide-right' 	=> esc_html__( 'Slide In Right', 'wpkoi-elements' ),
					'wpkoi-elements-slide-top' 	=> esc_html__( 'Slide In Top', 'wpkoi-elements' ),
					'wpkoi-elements-slide-bottom' => esc_html__( 'Slide In Bottom', 'wpkoi-elements' ),
				],
			]
		);

  		$this->add_control(
			'wpkoi_elements_section_fg_zoom_icon_new',
			[
				'label' => esc_html__( 'Zoom Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_section_fg_zoom_icon',
				'default' => [
					'value' => 'fas fa-search-plus',
					'library' => 'fa-solid',
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_section_fg_link_icon_new',
			[
				'label' => esc_html__( 'Link Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_section_fg_link_icon',
				'default' => [
					'value' => 'fas fa-link',
					'library' => 'fa-solid',
				]
			]
		);

  		$this->end_controls_section();

		/**
  		 * Filter Gallery Control Settings
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_fg_control_settings',
  			[
  				'label' => esc_html__( 'Gallery Control Settings', 'wpkoi-elements' )
  			]
  		);
		
		$list_item_repeater = new Repeater();

		$list_item_repeater->add_control(
			'wpkoi_elements_fg_control',
			array(
				'label' => esc_html__( 'List Item', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Item', 'wpkoi-elements' )
			)
		);
		
		$this->add_control(
			'wpkoi_elements_fg_controls',
			array(
				'type'    => Controls_Manager::REPEATER,
				'label'   => esc_html__( 'Categories', 'wpkoi-elements' ),
				'fields'  => $list_item_repeater->get_controls(),
				'seperator' => 'before',
				'default' => [
					[ 'wpkoi_elements_fg_control' => 'Item' ],
				],
				'title_field' => '{{wpkoi_elements_fg_control}}',
			)
		);

  		$this->end_controls_section();

  		/**
  		 * Filter Gallery Grid Settings
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_fg_grid_settings',
  			[
  				'label' => esc_html__( 'Gallery Item Settings', 'wpkoi-elements' )
  			]
  		);
		
		$gallery_item_repeater = new Repeater();

		$gallery_item_repeater->add_control(
			'wpkoi_elements_fg_gallery_item_name',
			array(
				'label' => esc_html__( 'Item Name', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Gallery item name', 'wpkoi-elements' )
			)
		);

		$gallery_item_repeater->add_control(
			'wpkoi_elements_fg_gallery_item_content',
			array(
				'label' => esc_html__( 'Item Content', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, provident.', 'wpkoi-elements' ),
			)
		);

		$gallery_item_repeater->add_control(
			'wpkoi_elements_fg_gallery_control_name',
			array(
				'label' => esc_html__( 'Control Name', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'User the gallery control name form Control Settings. use the exact name that matches with its associate name.', 'wpkoi-elements' )
			)
		);

		$gallery_item_repeater->add_control(
			'wpkoi_elements_fg_gallery_img',
			array(
				'label' => esc_html__( 'Image', 'wpkoi-elements' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => WPKOI_ELEMENTS_URL . 'elements/filterable-gallery/assets/flexia-preview.jpg',
				],
			)
		);

		$gallery_item_repeater->add_control(
			'wpkoi_elements_fg_gallery_link',
			array(
				'label' => __( 'Gallery Link?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'true',
				'label_on' => esc_html__( 'Yes', 'wpkoi-elements' ),
				'label_off' => esc_html__( 'No', 'wpkoi-elements' ),
				'return_value' => 'true',
			)
		);

		$gallery_item_repeater->add_control(
			'wpkoi_elements_fg_gallery_img_link',
			array(
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
					'url' => '#',
					'is_external' => '',
				],
				'show_external' => true,
				'condition' => [
					'wpkoi_elements_fg_gallery_link' => 'true'
				]
			)
		);
		
		$this->add_control(
			'wpkoi_elements_fg_gallery_items',
			array(
				'type'    => Controls_Manager::REPEATER,
				'label'   => esc_html__( 'Gallery items', 'wpkoi-elements' ),
				'fields'  => $gallery_item_repeater->get_controls(),
				'seperator' => 'before',
				'default' => [
					[ 'wpkoi_elements_fg_gallery_item_name' => 'Gallery Item Name' ],
					[ 'wpkoi_elements_fg_gallery_item_name' => 'Gallery Item Name' ],
					[ 'wpkoi_elements_fg_gallery_item_name' => 'Gallery Item Name' ],
					[ 'wpkoi_elements_fg_gallery_item_name' => 'Gallery Item Name' ],
					[ 'wpkoi_elements_fg_gallery_item_name' => 'Gallery Item Name' ],
					[ 'wpkoi_elements_fg_gallery_item_name' => 'Gallery Item Name' ],
				],
				'title_field' => '{{wpkoi_elements_fg_gallery_item_name}}',
			)
		);

  		$this->end_controls_section();

  		/**
  		 * Filter Gallery Grid Settings
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_fg_popup_settings',
  			[
  				'label' => esc_html__( 'Popup Settings', 'wpkoi-elements' )
  			]
  		);

  		$this->add_control(
		  'wpkoi_elements_fg_show_popup',
		  	[
				'label' => __( 'Show Popup', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'true',
				'label_on' => esc_html__( 'Yes', 'wpkoi-elements' ),
				'label_off' => esc_html__( 'No', 'wpkoi-elements' ),
				'return_value' => 'true',
		  	]
		);

  		$this->end_controls_section();

  		/**
		 * -------------------------------------------
		 * Tab Style (Filterable Gallery Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_fg_style_settings',
			[
				'label' => esc_html__( 'General Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_fg_container_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-filter-gallery-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_fg_container_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-filter-gallery-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_fg_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-wrapper',
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-wrapper' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_fg_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-wrapper',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Filterable Gallery Control Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_fg_control_style_settings',
			[
				'label' => esc_html__( 'Control Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_fg_control_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_fg_control_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
	         'name' => 'wpkoi_elements_fg_control_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control',
			]
		);
		// Tabs
		$this->start_controls_tabs( 'wpkoi_elements_fg_control_tabs' );

			// Normal State Tab
			$this->start_controls_tab( 'wpkoi_elements_fg_control_normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_fg_control_normal_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#444',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_fg_control_normal_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_fg_control_normal_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li > a.control',
				]
			);

			$this->add_control(
				'wpkoi_elements_fg_control_normal_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 20
					],
					'range' => [
						'px' => [
							'max' => 30,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control' => 'border-radius: {{SIZE}}px;',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'wpkoi_elements_fg_control_shadow',
					'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control',
					'separator' => 'before'
				]
			);

			$this->end_controls_tab();

			// Active State Tab
			$this->start_controls_tab( 'wpkoi_elements_cta_btn_hover', [ 'label' => esc_html__( 'Active', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_fg_control_active_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control.filtr-active' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_fg_control_active_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#3F51B5',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control.filtr-active' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_fg_control_active_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li > a.control.filtr-active',
				]
			);

			$this->add_control(
				'wpkoi_elements_fg_control_active_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 20
					],
					'range' => [
						'px' => [
							'max' => 30,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.control.filtr-active' => 'border-radius: {{SIZE}}px;',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'wpkoi_elements_fg_control_active_shadow',
					'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-control ul li a.filtr-active',
					'separator' => 'before'
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();



		$this->end_controls_section();



		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Filterable Gallery Item Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_fg_item_style_settings',
			[
				'label' => esc_html__( 'Item Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_fg_item_container_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_fg_item_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item',
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_fg_item_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item',
			]
		);

		$this->end_controls_section();
		/**
		 * -------------------------------------------
		 * Tab Style (Filterable Gallery Item Caption Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_fg_item_cap_style_settings',
			[
				'label' => esc_html__( 'Item Caption Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_cap_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.7)',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item .caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_fg_item_cap_container_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item .caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_fg_item_cap_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item .caption',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_fg_item_cap_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item .caption',
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_caption_hover_icon',
			[
				'label' => esc_html__( 'Hover Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff622a',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item .caption a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_icon_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container .item .caption a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Filterable Gallery Item Content Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_fg_item_content_style_settings',
			[
				'label' => esc_html__( 'Item Content Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
	 			'condition' => [
	 				'wpkoi_elements_fg_grid_style' => 'wpkoi-elements-cards'
	 			]
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_content_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f9f9f9',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_fg_item_content_container_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_fg_item_content_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_fg_item_content_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content',
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_content_title_typography_settings',
			[
				'label' => esc_html__( 'Title Typography', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_content_title_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#303133',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content .title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_content_title_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#23527c',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content .title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' => 'wpkoi_elements_fg_item_content_title_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content .title a',
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_content_text_typography_settings',
			[
				'label' => esc_html__( 'Content Typography', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'wpkoi_elements_fg_item_content_text_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#444',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' => 'wpkoi_elements_fg_item_content_text_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-filter-gallery-container.wpkoi-elements-cards .item-content p',
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_fg_item_content_alignment',
			[
				'label' => esc_html__( 'Content Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'separator' => 'before',
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
				'default' => 'left',
				'prefix_class' => 'wpkoi-elements-fg-content-align-',
			]
		);

		$this->end_controls_section();
	}

	public function sorter_class( $string ) {
		$sorter_class = strtolower( $string );
		$sorter_class = preg_replace( '/[^a-z0-9_\s-]/', "", $sorter_class );
		$sorter_class = preg_replace("/[\s-]+/", " ", $sorter_class);
		$sorter_class = preg_replace("/[\s_]/", "-", $sorter_class);

		return $sorter_class;
	}

	protected function render( ) {

   		$settings = $this->get_settings();

	?>
		<div id="wpkoi-elements-filter-gallery-wrapper-<?php echo esc_attr( $this->get_id() ); ?>" class="wpkoi-elements-filter-gallery-wrapper" data-grid-style="<?php echo $settings['wpkoi_elements_fg_grid_style']; ?>" data-duration="<?php if( !empty( $settings['wpkoi_elements_fg_filter_duration'] ) ) : echo $settings['wpkoi_elements_fg_filter_duration']; else: echo '500'; endif; ?>" data-popup="<?php echo $settings['wpkoi_elements_fg_show_popup']; ?>">
			<div class="wpkoi-elements-filter-gallery-control filters">
	            <ul>
	                <li><a href="javascript:;" class="control filtr-button filtr filtr-active" data-filter="all"><?php echo ( isset($settings['wpkoi_elements_fg_all_label_text']) && ! empty($settings['wpkoi_elements_fg_all_label_text']) ? esc_attr($settings['wpkoi_elements_fg_all_label_text']) : 'All'); ?></a></li>
	                <?php foreach( $settings['wpkoi_elements_fg_controls'] as $control ) : ?>
	                <?php $sorter_filter = $this->sorter_class( $control['wpkoi_elements_fg_control'] ); ?>
						<li><a href="javascript:;" class="control filtr-button filtr" data-filter="<?php echo esc_attr( $sorter_filter ); ?>-<?php echo esc_attr( $this->get_id() ); ?>"><?php echo $control['wpkoi_elements_fg_control']; ?></a></li>
	                <?php endforeach; ?>
	            </ul>
	        </div>
			<?php if( $settings['wpkoi_elements_fg_grid_style'] == 'wpkoi-elements-hoverer' || $settings['wpkoi_elements_fg_grid_style'] == 'wpkoi-elements-tiles' ) : ?>
		        <div class="wpkoi-elements-filter-gallery-container <?php echo esc_attr( $settings['wpkoi_elements_fg_grid_style'] ); ?> <?php echo esc_attr( $settings['wpkoi_elements_fg_columns'] ); ?>">
		        	<?php foreach( $settings['wpkoi_elements_fg_gallery_items'] as $gallery ) : ?>
		        	<?php $sorter_class = $this->sorter_class( $gallery['wpkoi_elements_fg_gallery_control_name'] ); ?>
		            <div class="item filtr-item <?php echo esc_attr( $sorter_class ) ?>-<?php echo esc_attr( $this->get_id() ); ?>" data-category="<?php echo esc_attr( $sorter_class ) ?>-<?php echo esc_attr( $this->get_id() ); ?>">
                    	<div class="item-i" style="background-image: url(<?php echo esc_attr( $gallery['wpkoi_elements_fg_gallery_img']['url'] ); ?>);">
                            <div class="caption <?php echo esc_attr( $settings['wpkoi_elements_fg_grid_hover_style'] ); ?> ">
                                <?php if( 'true' == $settings['wpkoi_elements_fg_show_popup'] ) : ?>
                                <a href="<?php echo esc_attr( $gallery['wpkoi_elements_fg_gallery_img']['url'] ); ?>" class="wpkoi-elements-magnific-link"><?php   
								$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_section_fg_zoom_icon_new'] );
								$is_new = empty( $settings['wpkoi_elements_section_fg_zoom_icon'] );
								if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['wpkoi_elements_section_fg_zoom_icon_new'], [ 'aria-hidden' => 'true' ] );
								else : ?><i class="<?php echo $settings['wpkoi_elements_section_fg_zoom_icon']; ?>" aria-hidden="true"></i><?php endif; ?></a>
                                <?php endif; ?>
                                <?php if( 'true' == $gallery['wpkoi_elements_fg_gallery_link'] ) :
                                    $wpkoi_elements_gallery_link = $gallery['wpkoi_elements_fg_gallery_img_link']['url'];
                                    $target = $gallery['wpkoi_elements_fg_gallery_img_link']['is_external'] ? 'target="_blank"' : '';
                                    $nofollow = $gallery['wpkoi_elements_fg_gallery_img_link']['nofollow'] ? 'rel="nofollow"' : '';
                                ?>
                                <a href="<?php echo esc_url( $wpkoi_elements_gallery_link ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> ><?php   
								$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_section_fg_link_icon_new'] );
								$is_new = empty( $settings['wpkoi_elements_section_fg_link_icon'] );
								if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['wpkoi_elements_section_fg_link_icon_new'], [ 'aria-hidden' => 'true' ] );
								else : ?><i class="<?php echo $settings['wpkoi_elements_section_fg_link_icon']; ?>" aria-hidden="true"></i><?php endif; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
		            </div>
		        	<?php endforeach; ?>
		        </div>
	    	<?php elseif( $settings['wpkoi_elements_fg_grid_style'] == 'wpkoi-elements-cards' ) : ?>
				<div class="wpkoi-elements-filter-gallery-container <?php echo esc_attr( $settings['wpkoi_elements_fg_grid_style'] ); ?> <?php echo esc_attr( $settings['wpkoi_elements_fg_columns'] ); ?>">
		        	<?php foreach( $settings['wpkoi_elements_fg_gallery_items'] as $gallery ) : ?>
			        	<?php $sorter_class = $this->sorter_class( $gallery['wpkoi_elements_fg_gallery_control_name'] ); ?>
			            <div class="item filtr-item <?php echo esc_attr( $sorter_class ) ?>-<?php echo esc_attr( $this->get_id() ); ?>" data-category="<?php echo esc_attr( $sorter_class ) ?>-<?php echo esc_attr( $this->get_id() ); ?>">
							<div class="item-img" style="background-image:url('<?php echo esc_attr( $gallery['wpkoi_elements_fg_gallery_img']['url'] ); ?>')">
				            	<div class="caption <?php echo esc_attr( $settings['wpkoi_elements_fg_grid_hover_style'] ); ?> ">
				                	<?php if( 'true' == $settings['wpkoi_elements_fg_show_popup'] ) : ?>
                                    <a href="<?php echo esc_url( $gallery['wpkoi_elements_fg_gallery_img']['url'] ); ?>" class="wpkoi-elements-magnific-link"><?php   
								$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_section_fg_zoom_icon_new'] );
								$is_new = empty( $settings['wpkoi_elements_section_fg_zoom_icon'] );
								if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['wpkoi_elements_section_fg_zoom_icon_new'], [ 'aria-hidden' => 'true' ] );
								else : ?><i class="<?php echo $settings['wpkoi_elements_section_fg_zoom_icon']; ?>" aria-hidden="true"></i><?php endif; ?></a>
				                	<?php endif; ?>
				                    <?php if( 'true' == $gallery['wpkoi_elements_fg_gallery_link'] ) :
										$wpkoi_elements_gallery_link = $gallery['wpkoi_elements_fg_gallery_img_link']['url'];
                                    	$target = $gallery['wpkoi_elements_fg_gallery_img_link']['is_external'] ? 'target="_blank"' : '';
                                    	$nofollow = $gallery['wpkoi_elements_fg_gallery_img_link']['nofollow'] ? 'rel="nofollow"' : '';
						        	?>
						        	<a href="<?php echo esc_url( $wpkoi_elements_gallery_link ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> ><?php   
								$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_section_fg_link_icon_new'] );
								$is_new = empty( $settings['wpkoi_elements_section_fg_link_icon'] );
								if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['wpkoi_elements_section_fg_link_icon_new'], [ 'aria-hidden' => 'true' ] );
								else : ?><i class="<?php echo $settings['wpkoi_elements_section_fg_link_icon']; ?>" aria-hidden="true"></i><?php endif; ?></a>
				                    <?php endif; ?>
				                </div>
							</div>
							<div class="item-content">
								<h2 class="title">
                                <?php if( 'true' == $gallery['wpkoi_elements_fg_gallery_link'] ) :
									$wpkoi_elements_gallery_link = $gallery['wpkoi_elements_fg_gallery_img_link']['url'];
									$target = $gallery['wpkoi_elements_fg_gallery_img_link']['is_external'] ? 'target="_blank"' : '';
									$nofollow = $gallery['wpkoi_elements_fg_gallery_img_link']['nofollow'] ? 'rel="nofollow"' : '';
								?>
						        	<a href="<?php echo esc_url( $wpkoi_elements_gallery_link ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> >
                                <?php else : ?>
                                	<a href="#">
                                <?php endif; ?>
								<?php echo esc_html( $gallery['wpkoi_elements_fg_gallery_item_name'] ); ?>
                                </a>
                                </h2>
								<p><?php echo $gallery['wpkoi_elements_fg_gallery_item_content']; ?></p>
							</div>
			        	</div>
		        	<?php endforeach; ?>
				</div>
	    	<?php endif; ?>
		</div>
        <script type="text/javascript">
		jQuery(document).ready(function($){
			//Setup buttons
			$('.filters .filtr').click(function() {
				$('.filters .filtr').removeClass('filtr-active');
				$(this).addClass('filtr-active');
			});
			// Default options
			var options = {
				animationDuration: 0.5, // in seconds
				filter: 'all', // Initial filter
				callbacks: { 
					onFilteringStart: function() { },
					onFilteringEnd: function() { },
					onShufflingStart: function() { },
					onShufflingEnd: function() { },
					onSortingStart: function() { },
					onSortingEnd: function() { }
				},
				controlsSelector: '', // Selector for custom controls
				delay: 0, // Transition delay in ms
				delayMode: 'progressive', // 'progressive' or 'alternate'
				easing: 'ease-out',
				filterOutCss: { // Filtering out animation
					opacity: 0,
					transform: 'scale(0.5)'
				},
				filterInCss: { // Filtering in animation
					opacity: 0,
					transform: 'scale(1)'
				},
				layout: 'sameSize', // See layouts
				multifilterLogicalOperator: 'or',
				selector: '.wpkoi-elements-filter-gallery-container',
				setupControls: true // Should be false if controlsSelector is set 
			} 
			// You can override any of these options and then call...
			var filterizd = $('.wpkoi-elements-filter-gallery-container').filterizr(options);
			// If you have already instantiated your Filterizr then call...
			filterizd.filterizr('setOptions', options);
			
			});
		</script>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Filterable_Gallery() );