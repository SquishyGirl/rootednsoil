<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_WPKoi_Elements_PostTimeline extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-post-timeline';
	}

	public function get_title() {
		return __( 'Post Timeline', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_script_depends() {
        return [
            'wpkoi-elements-scripts'
        ];
    }

	public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'wpkoi_elements_section_post_timeline_filters',
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
			'wpkoi_elements_section_post_timeline_layout',
			[
				'label' => __( 'Layout Settings', 'wpkoi-elements' )
			]
		);

        $this->add_control(
            'wpkoi_elements_post_timeline_show_load_more',
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
				'default' => '0'
            ]
        );

        $this->add_control(
			'wpkoi_elements_post_timeline_load_more_text',
			[
				'label' => esc_html__( 'Label Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => esc_html__( 'Load More', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_post_timeline_show_load_more' => '1',
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
                ]

            ]
        );


		$this->end_controls_section();


        $this->start_controls_section(
            'wpkoi_elements_section_post_timeline_style',
            [
                'label' => __( 'Timeline Style', 'wpkoi-elements' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'wpkoi_elements_timeline_overlay_color',
			[
				'label' => __( 'Overlay Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'description' => __('Leave blank or Clear to use default gradient overlay', 'wpkoi-elements' ),
				'default' => 'linear-gradient(45deg, #333333 0%, #888888 100%) repeat scroll 0 0 rgba(0, 0, 0, 0)',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-post-inner' => 'background: {{VALUE}}',
				]

			]
		);

        $this->add_control(
			'wpkoi_elements_timeline_bullet_color',
			[
				'label' => __( 'Timeline Bullet Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-bullet' => 'background-color: {{VALUE}};',
				]

			]
		);

        $this->add_control(
			'wpkoi_elements_timeline_bullet_border_color',
			[
				'label' => __( 'Timeline Bullet Border Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-bullet' => 'border-color: {{VALUE}};',
				]

			]
		);

        $this->add_control(
			'wpkoi_elements_timeline_vertical_line_color',
			[
				'label' => __( 'Timeline Vertical Line Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-post:after' => 'background-color: {{VALUE}};',
				]

			]
		);

        $this->add_control(
			'wpkoi_elements_timeline_border_color',
			[
				'label' => __( 'Border & Arrow Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-post-inner' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-timeline-post-inner::after' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-timeline-post:nth-child(2n) .wpkoi-elements-timeline-post-inner::after' => 'border-right-color: {{VALUE}};',
				]

			]
		);

        $this->add_control(
			'wpkoi_elements_timeline_date_background_color',
			[
				'label' => __( 'Date Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-post time' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-timeline-post time::before' => 'border-bottom-color: {{VALUE}};',
				]

			]
		);

        $this->add_control(
			'wpkoi_elements_timeline_date_color',
			[
				'label' => __( 'Date Text Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-post time' => 'color: {{VALUE}};',
				]

			]
		);


		$this->end_controls_section();

        $this->start_controls_section(
            'wpkoi_elements_section_typography',
            [
                'label' => __( 'Typography', 'wpkoi-elements' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'wpkoi_elements_timeline_title_style',
			[
				'label' => __( 'Title Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'wpkoi_elements_timeline_title_color',
			[
				'label' => __( 'Title Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-post-title h2' => 'color: {{VALUE}};',
				]

			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_timeline_title_alignment',
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
					'{{WRAPPER}} .wpkoi-elements-timeline-post-title h2' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wpkoi_elements_timeline_title_typography',
				'label' => __( 'Typography', 'wpkoi-elements' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wpkoi-elements-timeline-post-title h2',
			]
		);

		$this->add_control(
			'wpkoi_elements_timeline_excerpt_style',
			[
				'label' => __( 'Excerpt Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'wpkoi_elements_timeline_excerpt_color',
			[
				'label' => __( 'Excerpt Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-timeline-post-excerpt p' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_responsive_control(
			'wpkoi_elements_timeline_excerpt_alignment',
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
					'{{WRAPPER}} .wpkoi-elements-timeline-post-excerpt p' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wpkoi_elements_timeline_excerpt_typography',
				'label' => __( 'excerpt Typography', 'wpkoi-elements' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wpkoi-elements-timeline-post-excerpt p',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
            'wpkoi_elements_section_load_more_btn',
            [
                'label' => __( 'Load More Button Style', 'wpkoi-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                	'wpkoi_elements_post_timeline_show_load_more' => '1'
                ]
            ]
        );

		$this->add_responsive_control(
			'wpkoi_elements_post_timeline_load_more_btn_padding',
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
			'wpkoi_elements_post_timeline_load_more_btn_margin',
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
	         'name' => 'wpkoi_elements_post_timeline_load_more_btn_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-load-more-button',
			]
		);

		$this->start_controls_tabs( 'wpkoi_elements_post_timeline_load_more_btn_tabs' );

			// Normal State Tab
			$this->start_controls_tab( 'wpkoi_elements_post_timeline_load_more_btn_normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_post_timeline_load_more_btn_normal_text_color',
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
					'name' => 'wpkoi_elements_post_timeline_load_more_btn_normal_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-load-more-button',
				]
			);

			$this->add_control(
				'wpkoi_elements_post_timeline_load_more_btn_border_radius',
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
					'name' => 'wpkoi_elements_post_timeline_load_more_btn_shadow',
					'selector' => '{{WRAPPER}} .wpkoi-elements-load-more-button',
					'separator' => 'before'
				]
			);
			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'wpkoi_elements_post_timeline_load_more_btn_hover', [ 'label' => esc_html__( 'Hover', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_post_timeline_load_more_btn_hover_text_color',
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
				'wpkoi_elements_post_timeline_load_more_btn_hover_bg_color',
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
				'wpkoi_elements_post_timeline_load_more_btn_hover_border_color',
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
					'name' => 'wpkoi_elements_post_timeline_load_more_btn_hover_shadow',
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
		
		$this->add_render_attribute(
			'wpkoi_elements_post_timeline_wrapper',
			[
				'id'		=> "wpkoi-elements-post-timeline-{$this->get_id()}",
				'class'		=> 'wpkoi-elements-post-timeline',
				'data-url'	=> home_url( '/' ),
				'data-total_posts'	=> $total_post,
				'data-timeline_id'	=> $this->get_id(),
				'data-post_type'	=> $settings['wpkoi_elements_post_type'],
				'data-posts_per_page'	=> $settings['wpkoi_elements_posts_count'],
				'data-post_order'		=> $settings['wpkoi_elements_post_order'],
				'data-show_images'	=> $settings['wpkoi_elements_show_image'],
				'data-show_title'	=> $settings['wpkoi_elements_show_title'],
				'data-show_excerpt'	=> $settings['wpkoi_elements_show_excerpt'],
				'data-excerpt_length'	=> $settings['wpkoi_elements_excerpt_length'],
				'data-btn_text'			=> $settings['wpkoi_elements_post_timeline_load_more_text'],
				'data-categories'		=> $categories_id_string
			]
		);

		$this->add_render_attribute(
			'wpkoi_elements_post_timeline',
			[
				'class'	=> [ 'wpkoi-elements-post-timeline', "wpkoi-elements-post-appender-{$this->get_id()}" ]
			]
		);

        ?>
		<div <?php echo $this->get_render_attribute_string('wpkoi_elements_post_timeline_wrapper'); ?>>
		    <div <?php echo $this->get_render_attribute_string('wpkoi_elements_post_timeline'); ?>>
		    <?php
		        if(count($posts)){
		            global $post;
		            ?>
		                <?php
		                    foreach($posts as $post){
		                        setup_postdata($post);
		                    ?>
		                    <article class="wpkoi-elements-timeline-post wpkoi-elements-timeline-column">
		                        <div class="wpkoi-elements-timeline-bullet"></div>
		                        <div class="wpkoi-elements-timeline-post-inner">
		                            <a class="wpkoi-elements-timeline-post-link" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
			                            <time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
			                            <div class="wpkoi-elements-timeline-post-image" <?php if($settings['wpkoi_elements_show_image'] == 1){ ?> style="background-image: url('<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>');" <?php } ?>></div>
			                            <?php if($settings['wpkoi_elements_show_excerpt']){ ?>
			                            <div class="wpkoi-elements-timeline-post-excerpt">
			                                <p><?php echo  wpkoi_elements_get_excerpt_by_id(get_the_ID(),$settings['wpkoi_elements_excerpt_length']);?></p>
			                            </div>
			                            <?php } ?>

			                            <?php if($settings['wpkoi_elements_show_title']){ ?>
			                            <div class="wpkoi-elements-timeline-post-title">
                                            <?php 
											if ( get_post_type( get_the_ID() ) == 'wpkoi-events' ) {
												$wpkoi_events_metabox_location = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_location', true );
												$wpkoi_events_metabox_date     = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_date', true );
												$wpkoi_events_metabox_format   = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_format', true );
												$wpkoi_display_date = date_create($wpkoi_events_metabox_date);
												
												if ( $wpkoi_events_metabox_date != '' ) { ?>
												<h4 class="wpkoi-elements-event-date"><?php echo esc_html( date_format( $wpkoi_display_date, $wpkoi_events_metabox_format ) ); ?></h4>
												<?php }
												if ( $wpkoi_events_metabox_location != '' ) { ?>
												<h4 class="wpkoi-elements-event-location"><?php echo wp_kses_post( $wpkoi_events_metabox_location ); ?></h4>
												<?php }
											}
											?>
			                                <h2><?php the_title(); ?></h2>
			                            </div>
			                            <?php } ?>
		                            </a>
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
		</div>
		<?php if( 1 == $settings['wpkoi_elements_post_timeline_show_load_more'] ) : ?>
		<!-- Load More Button -->
		<div class="wpkoi-elements-load-more-button-wrap">
			<button class="wpkoi-elements-load-more-button" id="wpkoi-elements-load-more-btn-<?php echo $this->get_id(); ?>">
				<div class="wpkoi-elements-btn-loader button__loader"></div>
		  		<span><?php echo esc_html( $settings['wpkoi_elements_post_timeline_load_more_text'] ); ?></span>
			</button>
		</div>
		<?php endif;
	}

	protected function content_template() {}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_PostTimeline() );