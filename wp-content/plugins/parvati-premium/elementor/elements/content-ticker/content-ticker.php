<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WPKoi_Elements_Content_Ticker extends Widget_Base {

  public function get_name() {
    return 'wpkoi-elements-content-ticker';
  }

  public function get_title() {
    return esc_html__( 'Content Ticker', 'wpkoi-elements' );
  }

  public function get_icon() {
    return 'eicon-call-to-action';
  }

   public function get_categories() {
    return [ 'wpkoi-addons-for-elementor' ];
  }

  protected function register_controls() {
    /**
       * Content Ticker Content Settings
       */
      $this->start_controls_section(
        'wpkoi_elements_section_content_ticker_settings',
        [
          'label' => esc_html__( 'Ticker Settings', 'wpkoi-elements' )
        ]
      );

    $this->add_control(
      'wpkoi_elements_ticker_tag_text',
      [
        'label' => esc_html__( 'Tag Text', 'wpkoi-elements' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => esc_html__( 'Trending Today', 'wpkoi-elements' ),
      ]
    );
    $this->add_control(
      'wpkoi_elements_ticker_autoplay',
      [
        'label' => esc_html__( 'Autoplay', 'wpkoi-elements' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'true',
        'label_on' => __( 'Yes', 'wpkoi-elements' ),
        'label_off' => __( 'No', 'wpkoi-elements' ),
        'return_value' => 'true',
      ]
    );
    $this->add_control(
      'wpkoi_elements_ticker_autoplay_speed',
      [
        'label' => esc_html__( 'Autoplay Speed(ms)', 'wpkoi-elements' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => esc_html__( '3000', 'wpkoi-elements' ),
      ]
    );
    $this->add_control(
      'wpkoi_elements_ticker_slide_speed',
      [
        'label' => esc_html__( 'Slide Speed(ms)', 'wpkoi-elements' ),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => esc_html__( '300', 'wpkoi-elements' ),
      ]
    );
    $this->add_control(
      'wpkoi_elements_ticker_arrow',
      [
        'label' => esc_html__( 'Show Nav Arrow', 'wpkoi-elements' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'true',
        'label_on' => __( 'Yes', 'wpkoi-elements' ),
        'label_off' => __( 'No', 'wpkoi-elements' ),
        'return_value' => 'true',
      ]
    );
    $this->add_control(
      'wpkoi_elements_ticker_pause_on_hover',
      [
        'label' => esc_html__( 'Pause On Hover', 'wpkoi-elements' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'true',
        'label_on' => __( 'Yes', 'wpkoi-elements' ),
        'label_off' => __( 'No', 'wpkoi-elements' ),
        'return_value' => 'true',
      ]
    );
    $this->add_control(
      'wpkoi_elements_ticker_fade',
      [
        'label' => esc_html__( 'Fade Effect', 'wpkoi-elements' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'true',
        'label_on' => __( 'Yes', 'wpkoi-elements' ),
        'label_off' => __( 'No', 'wpkoi-elements' ),
        'return_value' => 'true',
      ]
    );
    $this->add_control(
      'wpkoi_elements_ticker_easing',
        [
        'label'         => esc_html__( 'Easing', 'wpkoi-elements' ),
          'type'      => Controls_Manager::SELECT,
          'default'     => 'ease',
          'label_block'   => false,
          'options'     => [
            'ease'          => esc_html__( 'Ease', 'wpkoi-elements' ),
            'ease-in'       => esc_html__( 'Ease In', 'wpkoi-elements' ),
            'ease-in-out'   => esc_html__( 'Ease In Out', 'wpkoi-elements' ),
          ],
        ]
    );
	$this->add_control(
		'wpkoi_elements_ticker_prev_icon_new',
		[
			'label' => esc_html__( 'Prev Icon', 'wpkoi-elements' ),
			'type' => Controls_Manager::ICONS,
			'fa4compatibility' => 'wpkoi_elements_ticker_prev_icon',
			'default' => [
				'value' => 'fas fa-angle-left',
				'library' => 'fa-solid',
			]
		]
	);
	$this->add_control(
		'wpkoi_elements_ticker_next_icon_new',
		[
			'label' => esc_html__( 'Next Icon', 'wpkoi-elements' ),
			'type' => Controls_Manager::ICONS,
			'fa4compatibility' => 'wpkoi_elements_ticker_next_icon',
			'default' => [
				'value' => 'fas fa-angle-right',
				'library' => 'fa-solid',
			]
		]
	);
    $this->end_controls_section();

    /**
       * Content Ticker Dynamic Content Settings
       */
    $this->start_controls_section(
      'wpkoi_elements_section_ticker_dynamic_content-settings',
      [
        'label' => __( 'Content Settings', 'wpkoi-elements' ),
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


      /**
       * -------------------------------------------
       * Tab Style (Content Ticker)
       * -------------------------------------------
       */
      $this->start_controls_section(
        'wpkoi_elements_section_ticker_style_settings',
        [
          'label' => esc_html__( 'Content Ticker Style', 'wpkoi-elements' ),
          'tab' => Controls_Manager::TAB_STYLE
        ]
      );

      $this->add_control(
        'wpkoi_elements_ticker_bg_color',
        [
          'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#f9f9f9',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap' => 'background-color: {{VALUE}};',
          ],
        ]
      );

      $this->add_responsive_control(
        'wpkoi_elements_ticker_container_padding',
        [
          'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .wpkoi-elements-ticker-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->add_responsive_control(
        'wpkoi_elements_ticker_container_margin',
        [
          'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .wpkoi-elements-ticker-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Border::get_type(),
        [
          'name' => 'wpkoi_elements_ticker_border',
          'label' => esc_html__( 'Border', 'wpkoi-elements' ),
          'selector' => '{{WRAPPER}} .wpkoi-elements-ticker-wrap',
        ]
      );

      $this->add_control(
        'wpkoi_elements_ticker_border_radius',
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
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap' => 'border-radius: {{SIZE}}px;',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Box_Shadow::get_type(),
        [
          'name' => 'wpkoi_elements_ticker_shadow',
          'selector' => '{{WRAPPER}} .wpkoi-elements-ticker-wrap',
        ]
      );

      $this->end_controls_section();

      /**
       * -------------------------------------------
       * Tab Style (Ticker Content Style)
       * -------------------------------------------
       */
      $this->start_controls_section(
        'wpkoi_elements_section_ticker_typography_settings',
        [
          'label' => esc_html__( 'Color &amp; Typography', 'wpkoi-elements' ),
          'tab' => Controls_Manager::TAB_STYLE
        ]
      );
      $this->add_control(
        'wpkoi_elements_ticker_content_text',
        [
          'label' => esc_html__( 'Ticker Content', 'wpkoi-elements' ),
          'type' => Controls_Manager::HEADING,
          'separator' => 'before'
        ]
      );

      $this->add_control(
        'wpkoi_elements_ticker_content_color',
        [
          'label' => esc_html__( 'Title Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .wpkoi-elements-ticker .ticker-content' => 'color: {{VALUE}};',
          ],
        ]
      );
      $this->add_control(
        'wpkoi_elements_ticker_hover_content_color',
        [
          'label' => esc_html__( 'Title Hover Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .wpkoi-elements-ticker .ticker-content:hover' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
          'name' => 'wpkoi_elements_ticker_content_typography',
          'selector' =>'{{WRAPPER}} .wpkoi-elements-ticker-wrap .wpkoi-elements-ticker .ticker-content',

        ]
      );

      $this->add_control(
        'wpkoi_elements_ticker_nav_icon_style',
        [
          'label' => esc_html__( 'Navigation', 'wpkoi-elements' ),
          'type' => Controls_Manager::HEADING,
          'separator' => 'before'
        ]
      );

      $this->add_control(
        'wpkoi_elements_ticker_nav_icon_color',
        [
          'label' => esc_html__( 'Icon Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#222',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-prev' => 'color: {{VALUE}};',
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-next' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_control(
        'wpkoi_elements_ticker_nav_icon_hover_color',
        [
          'label' => esc_html__( 'Icon Hover Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#fff',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-prev:hover' => 'color: {{VALUE}};',
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-next:hover' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_control(
        'wpkoi_elements_ticker_nav_icon_bg_color',
        [
          'label' => esc_html__( 'Icon Background Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#fff',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-prev' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-next' => 'background-color: {{VALUE}};',
          ],
        ]
      );
      $this->add_control(
        'wpkoi_elements_ticker_nav_icon_bg_color_hover',
        [
          'label' => esc_html__( 'Icon Background Hover Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#222',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-prev:hover' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-next:hover' => 'background-color: {{VALUE}};',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Border::get_type(),
        [
          'name' => 'wpkoi_elements_ticker_nav_icon_border',
          'label' => esc_html__( 'Border', 'wpkoi-elements' ),
          'selector' => '{{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-prev, {{WRAPPER}} .wpkoi-elements-ticker-wrap .slick-slider .wpkoi-elements-slick-next',
        ]
      );

      $this->end_controls_section();

      $this->start_controls_section(
        'wpkoi_elements_section_ticker_tag_style_settings',
        [
          'label' => esc_html__( 'Tag Style', 'wpkoi-elements' ),
          'tab' => Controls_Manager::TAB_STYLE
        ]
      );
      $this->add_control(
        'wpkoi_elements_ticker_tag_bg_color',
        [
          'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#222222',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .ticker-badge span' => 'background-color: {{VALUE}};',
          ],
        ]
      );
      $this->add_control(
        'wpkoi_elements_ticker_tag_color',
        [
          'label' => esc_html__( 'Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#fff',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-ticker-wrap .ticker-badge span' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
          'name' => 'wpkoi_elements_ticker_tag_typography',
          'selector' => '{{WRAPPER}} .wpkoi-elements-ticker-wrap .ticker-badge span',
        ]
      );
      $this->add_responsive_control(
        'wpkoi_elements_ticker_tag_padding',
        [
          'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .wpkoi-elements-ticker-wrap .ticker-badge span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );
      $this->add_responsive_control(
        'wpkoi_elements_ticker_tag_radius',
        [
          'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .wpkoi-elements-ticker-wrap .ticker-badge span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );
      $this->end_controls_section();
  }


  protected function render( ) {

      $settings = $this->get_settings();
      $post_args = wpkoi_elements_get_post_settings($settings);
      $posts = wpkoi_elements_get_post_data($post_args);

      ?>
        <?php if(count($posts)) : global $post; ?>
        <div class="wpkoi-elements-ticker-wrap" id="wpkoi-elements-ticker-wrap-<?php echo $this->get_id(); ?>">
          <?php if( !empty($settings['wpkoi_elements_ticker_tag_text']) ) : ?>
          <div class="ticker-badge">
            <span><?php echo $settings['wpkoi_elements_ticker_tag_text']; ?></span>
          </div>
          <?php endif; ?>
          <div class="wpkoi-elements-ticker">
            <?php foreach( $posts as $post ) : setup_postdata( $post );
              echo '<div><a href="'.get_the_permalink().'" class="ticker-content">'.get_the_title().'</a></div>';
            endforeach; ?>
          </div>
        </div>
          <?php endif; ?>

    <script>
      jQuery(document).ready(function($) {

        $('#wpkoi-elements-ticker-wrap-<?php echo $this->get_id(); ?> .wpkoi-elements-ticker').slick({
          autoplay: <?php if( !empty($settings['wpkoi_elements_ticker_autoplay']) ) : echo $settings['wpkoi_elements_ticker_autoplay']; else: echo 'false'; endif; ?>,
          autoplaySpeed: <?php echo $settings['wpkoi_elements_ticker_autoplay_speed']; ?>,
          arrows: <?php if( !empty($settings['wpkoi_elements_ticker_arrow']) ) : echo $settings['wpkoi_elements_ticker_arrow']; else: echo 'false'; endif; ?>,
          cssEase: 'ease',
          fade: <?php if( !empty($settings['wpkoi_elements_ticker_fade']) ) : echo $settings['wpkoi_elements_ticker_fade']; else: echo 'false'; endif; ?>,
          easing: '<?php echo $settings['wpkoi_elements_ticker_easing']; ?>',
          pauseOnHover: <?php if( !empty($settings['wpkoi_elements_ticker_pause_on_hover']) ) : echo $settings['wpkoi_elements_ticker_pause_on_hover']; else: echo 'false'; endif; ?>,
          prevArrow: '<button type="button" class="wpkoi-elements-slick-prev"><?php   
			$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_ticker_prev_icon_new'] );
			$is_new = empty( $settings['wpkoi_elements_ticker_prev_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['wpkoi_elements_ticker_prev_icon_new'], [ 'aria-hidden' => 'false' ] );
			else : ?><i class="<?php echo $settings['wpkoi_elements_ticker_prev_icon']; ?>"></i><?php endif; ?></button>',
          nextArrow: '<button type="button" class="wpkoi-elements-slick-next"><?php   
			$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_ticker_next_icon_new'] );
			$is_new = empty( $settings['wpkoi_elements_ticker_next_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['wpkoi_elements_ticker_next_icon_new'], [ 'aria-hidden' => 'false' ] );
			else : ?><i class="<?php echo $settings['wpkoi_elements_ticker_next_icon']; ?>"></i><?php endif; ?></button>',
          speed: <?php echo $settings['wpkoi_elements_ticker_slide_speed']; ?>,
          useCSS: true
        });

      });
    </script>
      <?php

    }

  protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Content_Ticker() );