<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_WPKoi_Elements_Post_Grid extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-post-grid';
	}

	public function get_title() {
		return __( 'Post Grid', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'wpkoi_elements_section_post_grid_filters',
			[
				'label' => __( 'Post Settings', 'wpkoi-elements' )
			]
		);


		$this->add_control(
            'wpkoi_elements_post_type',
            [
                'label' => __( 'Post Type', 'wpkoi-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => wpkoi_elements_get_post_types(),
                'default' => 'post',

            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __( 'Categories', 'wpkoi-elements' ),
                'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => wpkoi_elements_post_type_categories(),
                'condition' => [
                       'wpkoi_elements_post_type' => 'post'
                ]
            ]
		);
		
		$this->add_control(
            'wpkoi_elements_post_authors',
            [
                'label'             => __( 'Authors', 'wpkoi-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => wpkoi_elements_get_authors(),
            ]
        );

        $this->add_control(
            'wpkoi_elements_post_tags',
            [
                'label'             => __( 'Tags', 'wpkoi-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => wpkoi_elements_get_tags(),
            ]
        );

        $this->add_control(
            'wpkoi_elements_post_exclude_posts',
            [
                'label'             => __( 'Exclude Posts', 'wpkoi-elements' ),
                'type'              => Controls_Manager::SELECT2,
				'label_block'       => true,
				'multiple'          => true,
				'options'           => wpkoi_elements_get_posts(),
            ]
        );

        $this->add_control(
            'wpkoi_elements_posts_count',
            [
                'label' => __( 'Number of Posts', 'wpkoi-elements' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '4'
            ]
        );


        $this->add_control(
            'wpkoi_elements_post_offset',
            [
                'label' => __( 'Post Offset', 'wpkoi-elements' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '0'
            ]
        );

        $this->add_control(
            'wpkoi_elements_post_orderby',
            [
                'label' => __( 'Order By', 'wpkoi-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => wpkoi_elements_get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'wpkoi_elements_post_order',
            [
                'label' => __( 'Order', 'wpkoi-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'wpkoi_elements_section_post_grid_layout',
			[
				'label' => __( 'Layout Settings', 'wpkoi-elements' )
			]
		);

		$this->add_control(
			'wpkoi_elements_post_grid_columns',
			[
				'label' => esc_html__( 'Number of Columns', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wpkoi-elements-col-4',
				'options' => [
					'wpkoi-elements-col-1' => esc_html__( 'Single Column', 'wpkoi-elements' ),
					'wpkoi-elements-col-2' => esc_html__( 'Two Columns', 'wpkoi-elements' ),
					'wpkoi-elements-col-3' => esc_html__( 'Three Columns', 'wpkoi-elements' ),
					'wpkoi-elements-col-4' => esc_html__( 'Four Columns', 'wpkoi-elements' ),
					'wpkoi-elements-col-5' => esc_html__( 'Five Columns', 'wpkoi-elements' ),
					'wpkoi-elements-col-6' => esc_html__( 'Six Columns', 'wpkoi-elements' ),
				],
			]
		);

		$this->add_control(
            'wpkoi_elements_post_grid_show_load_more',
            [
                'label' => __( 'Show Load More', 'wpkoi-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wpkoi-elements' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '0',
                'condition' => [
                       'wpkoi_elements_post_type' => 'post'
                ]
            ]
        );

        $this->add_control(
			'wpkoi_elements_post_grid_show_load_more_text',
			[
				'label' => esc_html__( 'Label Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( 'Load More', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_post_grid_show_load_more' => '1',
				]
			]
		);

        $this->add_control(
            'wpkoi_elements_show_image',
            [
                'label' => __( 'Show Image', 'wpkoi-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wpkoi-elements' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'exclude' => [ 'custom' ],
				'default' => 'medium',
				'condition' => [
                    'wpkoi_elements_show_image' => '1',
                ]
			]
		);


		$this->add_control(
            'wpkoi_elements_show_title',
            [
                'label' => __( 'Show Title', 'wpkoi-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wpkoi-elements' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );


		$this->add_control(
            'wpkoi_elements_show_event_date',
            [
                'label' => __( 'Show Event Date', 'wpkoi-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wpkoi-elements' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1',
                'condition' => [
                       'wpkoi_elements_post_type' => 'wpkoi-events'
                ]
            ]
        );


		$this->add_control(
            'wpkoi_elements_show_event_location',
            [
                'label' => __( 'Show Event Location', 'wpkoi-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wpkoi-elements' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1',
                'condition' => [
                       'wpkoi_elements_post_type' => 'wpkoi-events'
                ]
            ]
        );

		$this->add_control(
            'wpkoi_elements_show_excerpt',
            [
                'label' => __( 'Show excerpt', 'wpkoi-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wpkoi-elements' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );


        $this->add_control(
            'wpkoi_elements_excerpt_length',
            [
                'label' => __( 'Excerpt Words', 'wpkoi-elements' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
                'condition' => [
                    'wpkoi_elements_show_excerpt' => '1',
                ],
                'description' => ''

            ]
        );


		$this->add_control(
            'wpkoi_elements_show_meta',
            [
                'label' => __( 'Show Meta', 'wpkoi-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( 'Yes', 'wpkoi-elements' ),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __( 'No', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => '1'
            ]
        );

		$this->add_control(
			'wpkoi_elements_post_grid_meta_position',
			[
				'label' => esc_html__( 'Meta Position', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'meta-entry-footer',
				'options' => [
					'meta-entry-header' => esc_html__( 'Entry Header', 'wpkoi-elements' ),
					'meta-entry-footer' => esc_html__( 'Entry Footer', 'wpkoi-elements' ),
				],
                'condition' => [
                    'wpkoi_elements_show_meta' => '1',
                ]
			]
		);


		$this->end_controls_section();

        $this->start_controls_section(
            'wpkoi_elements_section_post_grid_style',
            [
                'label' => __( 'Post Grid Style', 'wpkoi-elements' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'wpkoi_elements_post_grid_bg_color',
			[
				'label' => __( 'Post Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-grid-post-holder' => 'background-color: {{VALUE}}',
				]

			]
		);

        $this->add_control(
			'wpkoi_elements_thumbnail_overlay_color',
			[
				'label' => __( 'Thumbnail Overlay Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0, .75)',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-entry-overlay' => 'background-color: {{VALUE}}',
				]

			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_post_grid_spacing',
			[
				'label' => esc_html__( 'Spacing Between Items', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-grid-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_post_grid_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-grid-post-holder',
			]
		);

		$this->add_control(
			'wpkoi_elements_post_grid_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-grid-post-holder' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_post_grid_box_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-grid-post-holder',
			]
		);


		$this->end_controls_section();

        $this->start_controls_section(
            'wpkoi_elements_section_typography',
            [
                'label' => __( 'Color & Typography', 'wpkoi-elements' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'wpkoi_elements_post_grid_title_style',
			[
				'label' => __( 'Title Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'wpkoi_elements_post_grid_title_color',
			[
				'label' => __( 'Title Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-entry-title, {{WRAPPER}} .wpkoi-elements-entry-title a' => 'color: {{VALUE}};',
				]

			]
		);

        $this->add_control(
			'wpkoi_elements_post_grid_title_hover_color',
			[
				'label' => __( 'Title Hover Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-entry-title:hover, {{WRAPPER}} .wpkoi-elements-entry-title a:hover' => 'color: {{VALUE}};',
				]

			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_post_grid_title_alignment',
			[
				'label' => __( 'Title Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-entry-title' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wpkoi_elements_post_grid_title_typography',
				'label' => __( 'Typography', 'wpkoi-elements' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wpkoi-elements-entry-title',
			]
		);

		$this->add_control(
			'wpkoi_elements_post_grid_events_style',
			[
				'label' => __( 'Event Info Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                       'wpkoi_elements_post_type' => 'wpkoi-events'
                ]
			]
		);

        $this->add_control(
			'wpkoi_elements_post_grid_events_color',
			[
				'label' => __( 'Event Info Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-event-date, {{WRAPPER}} .wpkoi-elements-event-location' => 'color: {{VALUE}};',
				],
                'condition' => [
                       'wpkoi_elements_post_type' => 'wpkoi-events'
                ]

			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_post_grid_events_alignment',
			[
				'label' => __( 'Event Info Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-event-date, {{WRAPPER}} .wpkoi-elements-event-location' => 'text-align: {{VALUE}};',
				],
                'condition' => [
                       'wpkoi_elements_post_type' => 'wpkoi-events'
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wpkoi_elements_post_grid_events_typography',
				'label' => __( 'Event Info Typography', 'wpkoi-elements' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wpkoi-elements-event-date, {{WRAPPER}} .wpkoi-elements-event-location',
                'condition' => [
                       'wpkoi_elements_post_type' => 'wpkoi-events'
                ]
			]
		);

		$this->add_control(
			'wpkoi_elements_post_grid_excerpt_style',
			[
				'label' => __( 'Excerpt Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'wpkoi_elements_post_grid_excerpt_color',
			[
				'label' => __( 'Excerpt Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-grid-post-excerpt p' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_responsive_control(
			'wpkoi_elements_post_grid_excerpt_alignment',
			[
				'label' => __( 'Excerpt Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-grid-post-excerpt p' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wpkoi_elements_post_grid_excerpt_typography',
				'label' => __( 'excerpt Typography', 'wpkoi-elements' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wpkoi-elements-grid-post-excerpt p',
			]
		);


		$this->add_control(
			'wpkoi_elements_post_grid_meta_style',
			[
				'label' => __( 'Meta Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'wpkoi_elements_post_grid_meta_color',
			[
				'label' => __( 'Meta Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-entry-meta, .wpkoi-elements-entry-meta a' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_responsive_control(
			'wpkoi_elements_post_grid_meta_alignment',
			[
				'label' => __( 'Meta Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					],
					'stretch' => [
						'title' => __( 'Justified', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-entry-footer' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wpkoi_elements_post_grid_meta_typography',
				'label' => __( 'Excerpt Typography', 'wpkoi-elements' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wpkoi-elements-entry-meta > div',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
            'wpkoi_elements_section_load_more_btn',
            [
                'label' => __( 'Load More Button Style', 'wpkoi-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                	'wpkoi_elements_post_grid_show_load_more' => '1'
                ]
            ]
        );

		$this->add_responsive_control(
			'wpkoi_elements_post_grid_load_more_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-load-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_post_grid_load_more_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-load-more-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
	         'name' => 'wpkoi_elements_post_grid_load_more_btn_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-load-more-button',
			]
		);

		$this->start_controls_tabs( 'wpkoi_elements_post_grid_load_more_btn_tabs' );

			// Normal State Tab
			$this->start_controls_tab( 'wpkoi_elements_post_grid_load_more_btn_normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_post_grid_load_more_btn_normal_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-load-more-button' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_cta_btn_normal_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-load-more-button' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_post_grid_load_more_btn_normal_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-load-more-button',
				]
			);

			$this->add_control(
				'wpkoi_elements_post_grid_load_more_btn_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-load-more-button' => 'border-radius: {{SIZE}}px;',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'wpkoi_elements_post_grid_load_more_btn_shadow',
					'selector' => '{{WRAPPER}} .wpkoi-elements-load-more-button',
					'separator' => 'before'
				]
			);
			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'wpkoi_elements_post_grid_load_more_btn_hover', [ 'label' => esc_html__( 'Hover', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_post_grid_load_more_btn_hover_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-load-more-button:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_post_grid_load_more_btn_hover_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-load-more-button:hover' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_post_grid_load_more_btn_hover_border_color',
				[
					'label' => esc_html__( 'Border Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-load-more-button:hover' => 'border-color: {{VALUE}};',
					],
				]

			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'wpkoi_elements_post_grid_load_more_btn_hover_shadow',
					'selector' => '{{WRAPPER}} .wpkoi-elements-load-more-button:hover',
					'separator' => 'before'
				]
			);
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}


	protected function render( ) {
        $settings = $this->get_settings();

        $post_args = wpkoi_elements_get_post_settings($settings);

        $posts = wpkoi_elements_get_post_data($post_args);

        /* Get Post Categories */
        $post_categories = $this->get_settings( 'category' );
        if( !empty( $post_categories ) ) {
        	foreach ( $post_categories as $key=>$value ) {
	        	$categories[] = $value;
	        }
	        $categories_id_string = implode( ',' , $categories );

	        /* Get All Post Count */
	        $total_post = 0;
	        foreach( $categories as $cat ) {
	        	$category = get_category( $cat );
	        	$total_post = $total_post + $category->category_count;
	        }
        }else {
        	$categories_id_string = '';
        	$total_post = wp_count_posts( $settings['wpkoi_elements_post_type'] )->publish;
        }

        ?>

		<div id="wpkoi-elements-post-grid-<?php echo esc_attr($this->get_id()); ?>" class="wpkoi-elements-post-grid-container <?php echo esc_attr($settings['wpkoi_elements_post_grid_columns'] ); ?>">
		    <div class="wpkoi-elements-post-grid wpkoi-elements-post-appender-<?php echo esc_attr( $this->get_id() ); ?>">
		    <?php
		        if(count($posts)){
		            global $post;
		            ?>
		                <?php
		                    foreach($posts as $post){
		                        setup_postdata($post);
		                    ?>


		                    <article class="wpkoi-elements-grid-post wpkoi-elements-post-grid-column">
		                    	<div class="wpkoi-elements-grid-post-holder">
			                    	<div class="wpkoi-elements-grid-post-holder-inner">

			                    		<?php if ($thumbnail_exists = has_post_thumbnail()): ?>
			                    		<div class="wpkoi-elements-entry-media">
			                    			<div class="wpkoi-elements-entry-overlay">
			                    				<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
			                    				<a href="<?php echo get_permalink(); ?>"></a>
			                    			</div>
				                    		<div class="wpkoi-elements-entry-thumbnail">
				                    			<?php if($settings['wpkoi_elements_show_image'] == 1){ ?>
				                    			<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>">
				                    			<?php } ?>
				                    		</div>
			                    		</div>
			                    		<?php endif; ?>

			                    		<div class="wpkoi-elements-entry-wrapper">
			                    			<header class="wpkoi-elements-entry-header">
			                    				<?php if($settings['wpkoi_elements_show_title']){ ?>
			                    				<h2 class="wpkoi-elements-entry-title"><a class="wpkoi-elements-grid-post-link" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			                    				<?php } ?>
                                                
                                                <?php 
												if ( get_post_type( get_the_ID() ) == 'wpkoi-events' ) {
													$wpkoi_events_metabox_location = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_location', true );
													$wpkoi_events_metabox_date     = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_date', true );
													$wpkoi_events_metabox_format   = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_format', true );
													$wpkoi_display_date = date_create($wpkoi_events_metabox_date);
													
													if ( ( $settings['wpkoi_elements_show_event_date'] ) && ( $wpkoi_events_metabox_date != '' ) ){ ?>
                                                    <h4 class="wpkoi-elements-event-date"><?php echo esc_html( date_format( $wpkoi_display_date, $wpkoi_events_metabox_format ) ); ?></h4>
													<?php }
													if ( ( $settings['wpkoi_elements_show_event_location'] ) && ( $wpkoi_events_metabox_location != '' ) ){ ?>
                                                    <h4 class="wpkoi-elements-event-location"><?php echo wp_kses_post( $wpkoi_events_metabox_location ); ?></h4>
                                                    <?php }
												}
												?>

			                    				<?php if($settings['wpkoi_elements_show_meta'] && $settings['wpkoi_elements_post_grid_meta_position'] == 'meta-entry-header'){ ?>
				                    			<div class="wpkoi-elements-entry-meta">
				                    				<span class="wpkoi-elements-posted-by"><?php the_author_posts_link(); ?></span>
				                    				<span class="wpkoi-elements-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></span>
				                    			</div>
				                    			<?php } ?>
			                    			</header>

			                    			<div class="wpkoi-elements-entry-content">
					                            <?php if($settings['wpkoi_elements_show_excerpt']){ ?>
					                            <div class="wpkoi-elements-grid-post-excerpt">
					                                <p><?php echo  wpkoi_elements_get_excerpt_by_id(get_the_ID(),$settings['wpkoi_elements_excerpt_length']);?></p>
					                            </div>
					                            <?php } ?>
			                    			</div>
			                    		</div>

			                    		<?php if($settings['wpkoi_elements_show_meta'] && $settings['wpkoi_elements_post_grid_meta_position'] == 'meta-entry-footer'){ ?>
			                    		<div class="wpkoi-elements-entry-footer">
			                    			<div class="wpkoi-elements-author-avatar">
			                    				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 96 ); ?> </a>
			                    			</div>
			                    			<div class="wpkoi-elements-entry-meta">
			                    				<div class="wpkoi-elements-posted-by"><?php the_author_posts_link(); ?></div>
			                    				<div class="wpkoi-elements-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></div>
			                    			</div>
			                    		</div>
			                    		<?php } ?>
			                    	</div>
		                    	</div>
		                    </article>
		                    <?php
		                    }
		                    wp_reset_postdata();
		                ?>
		            <?php
		        }
		    ?>
		    </div>
		    <div class="clearfix"></div>
		</div>
		<?php if( 1 == $settings['wpkoi_elements_post_grid_show_load_more'] ) : ?>
		<!-- Load More Button -->
		<div class="wpkoi-elements-load-more-button-wrap">
			<button class="wpkoi-elements-load-more-button" id="wpkoi-elements-load-more-btn-<?php echo $this->get_id(); ?>">
				<div class="wpkoi-elements-btn-loader button__loader"></div>
		  		<span><?php echo esc_html( $settings['wpkoi_elements_post_grid_show_load_more_text'] ); ?></span>
			</button>
		</div>
		<?php endif; ?>
<!-- Loading Lode More Js -->
<script>
jQuery(document).ready(function($) {

	'use strict';
	var options = {
		siteUrl: '<?php echo home_url( '/' ); ?>',
		totalPosts: <?php echo $total_post; ?>,
		loadMoreBtn: $( '#wpkoi-elements-load-more-btn-<?php echo $this->get_id(); ?>' ),
		postContainer: $( '.wpkoi-elements-post-appender-<?php echo esc_attr( $this->get_id() ); ?>' ),
		postStyle: 'grid',
	}

	var settings = {
		postType: '<?php echo $settings['wpkoi_elements_post_type']; ?>',
		perPage: parseInt( <?php echo $settings['wpkoi_elements_posts_count'] ?>, 10 ),
		postOrder: '<?php echo $settings['wpkoi_elements_post_order'] ?>',
		showImage: <?php echo $settings['wpkoi_elements_show_image']; ?>,
		showTitle: <?php echo $settings['wpkoi_elements_show_title']; ?>,
		showExcerpt: <?php echo $settings['wpkoi_elements_show_excerpt']; ?>,
		showMeta: <?php echo $settings['wpkoi_elements_show_meta']; ?>,
		metaPosition: '<?php echo $settings['wpkoi_elements_post_grid_meta_position']; ?>',
		excerptLength: parseInt( <?php echo $settings['wpkoi_elements_excerpt_length']; ?>, 10 ),
		btnText: '<?php echo $settings['wpkoi_elements_post_grid_show_load_more_text']; ?>',
		categories: '<?php echo $categories_id_string; ?>',
	}

	loadMore( options, settings );

	// Load Masonry Js
  	$(window).load(function(){
    	$('.wpkoi-elements-post-grid').masonry({
      		itemSelector: '.wpkoi-elements-grid-post',
      		percentPosition: true,
      		columnWidth: '.wpkoi-elements-post-grid-column'
    	});
	});

});

</script>

        <?php
	}

	protected function content_template() {}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Post_Grid() );