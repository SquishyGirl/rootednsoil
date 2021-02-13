<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WPKoi_Elements_Cta_Box extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-cta-box';
	}

	public function get_title() {
		return esc_html__( 'Call to Action', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {

  		/**
  		 * Call to Action Content Settings
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_cta_content_settings',
  			[
  				'label' => esc_html__( 'Content Settings', 'wpkoi-elements' )
  			]
  		);

  		$this->add_control(
		  'wpkoi_elements_cta_type',
		  	[
		   	'label'       	=> esc_html__( 'Content Style', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'cta-basic',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'cta-basic'  		=> esc_html__( 'Basic', 'wpkoi-elements' ),
		     		'cta-flex' 			=> esc_html__( 'Flex Grid', 'wpkoi-elements' ),
		     		'cta-icon-flex' 	=> esc_html__( 'Flex Grid with Icon', 'wpkoi-elements' ),
		     	],
		  	]
		);

  		/**
  		 * Condition: 'wpkoi_elements_cta_type' => 'cta-basic'
  		 */
		$this->add_control(
		  'wpkoi_elements_cta_content_type',
		  	[
		   	'label'       	=> esc_html__( 'Content Type', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'cta-default',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'cta-default'  	=> esc_html__( 'Left', 'wpkoi-elements' ),
		     		'cta-center' 		=> esc_html__( 'Center', 'wpkoi-elements' ),
		     		'cta-right' 		=> esc_html__( 'Right', 'wpkoi-elements' ),
		     	],
		     	'condition'    => [
		     		'wpkoi_elements_cta_type' => 'cta-basic'
		     	]
		  	]
		);

		$this->add_control(
		  'wpkoi_elements_cta_color_type',
		  	[
		   	'label'       	=> esc_html__( 'Color Style', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'cta-bg-color',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'cta-bg-color'  		=> esc_html__( 'Background Color', 'wpkoi-elements' ),
		     		'cta-bg-img' 			=> esc_html__( 'Background Image', 'wpkoi-elements' ),
		     		'cta-bg-img-fixed' 	=> esc_html__( 'Background Fixed Image', 'wpkoi-elements' ),
		     	],
		  	]
		);
		
		/**
		 * Condition: 'wpkoi_elements_cta_type' => 'cta-icon-flex'
		 */
		$this->add_control(
			'wpkoi_elements_cta_flex_grid_icon_new',
			[
				'label' => esc_html__( 'Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_cta_flex_grid_icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'wpkoi_elements_cta_type' => 'cta-icon-flex'
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_title',
			[
				'label' => esc_html__( 'Title', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'WPKoi Call to action element', 'wpkoi-elements' ),
				'dynamic' => [ 'active' => true ]
			]
		);
		$this->add_control(
            'wpkoi_elements_cta_title_content_type',
            [
                'label'                 => __( 'Content Type', 'wpkoi-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                    'content'       => __( 'Content', 'wpkoi-elements' ),
                    'template'      => __( 'Saved Templates', 'wpkoi-elements' ),
                ],
                'default'               => 'content',
            ]
        );

        $this->add_control(
            'wpkoi_elements_primary_templates',
            [
                'label'                 => __( 'Choose Template', 'wpkoi-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => wpkoi_elements_get_page_templates(),
				'condition'             => [
					'wpkoi_elements_cta_title_content_type'      => 'template',
				],
            ]
        );
		$this->add_control(
			'wpkoi_elements_cta_content',
			[
				'label' => esc_html__( 'Content', 'wpkoi-elements' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => esc_html__( 'Add Your text here.', 'wpkoi-elements' ),
				'separator' => 'after',
				'condition' => [
					'wpkoi_elements_cta_title_content_type' => 'content'
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Button Text', 'wpkoi-elements' )
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_btn_link',
			[
				'label' => esc_html__( 'Button Link', 'wpkoi-elements' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
        			'url' => 'http://',
        			'is_external' => '',
     			],
     			'show_external' => true,
     			'separator' => 'after'
			]
		);

		/**
		 * Condition: 'wpkoi_elements_cta_color_type' => 'cta-bg-img' && 'wpkoi_elements_cta_color_type' => 'cta-bg-img-fixed',
		 */
		$this->add_control(
			'wpkoi_elements_cta_bg_image',
			[
				'label' => esc_html__( 'Background Image', 'wpkoi-elements' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'selectors' => [
            	'{{WRAPPER}} .wpkoi-elements-call-to-action.bg-img' => 'background-image: url({{URL}});',
            	'{{WRAPPER}} .wpkoi-elements-call-to-action.bg-img-fixed' => 'background-image: url({{URL}});',
        		],
				'condition' => [
					'wpkoi_elements_cta_color_type' => [ 'cta-bg-img', 'cta-bg-img-fixed' ],
				]
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Cta Title Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_cta_style_settings',
			[
				'label' => esc_html__( 'Call to Action Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_container_width',
			[
				'label' => esc_html__( 'Set max width for the container?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'wpkoi-elements' ),
				'label_off' => __( 'no', 'wpkoi-elements' ),
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_cta_container_width_value',
			[
				'label' => __( 'Container Max Width (% or px)', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1170,
					'unit' => 'px',
				],
				'size_units' => [ 'px', '%' ],
				'range' => [
		            'px' => [
		                'min' => 0,
		                'max' => 1500,
		                'step' => 5,
		            ],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-call-to-action' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'wpkoi_elements_cta_container_width' => 'yes',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-call-to-action' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_cta_container_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-call-to-action' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_cta_container_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-call-to-action' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_cta_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-call-to-action',
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-call-to-action' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_cta_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-call-to-action',
			]
		);


		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Cta Title Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_cta_title_style_settings',
			[
				'label' => esc_html__( 'Color &amp; Typography ', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_title_heading',
			[
				'label' => esc_html__( 'Title Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_title_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-call-to-action .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_cta_title_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-call-to-action .title',
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_content_heading',
			[
				'label' => esc_html__( 'Content Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'wpkoi_elements_cta_content_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-call-to-action p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_cta_content_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-call-to-action p',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Button Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_cta_btn_style_settings',
			[
				'label' => esc_html__( 'Button Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
		  'wpkoi_elements_cta_btn_effect_type',
		  	[
		   	'label'       	=> esc_html__( 'Effect', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'default',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'default'  			=> esc_html__( 'Default', 'wpkoi-elements' ),
		     		'top-to-bottom'  	=> esc_html__( 'Top to Bottom', 'wpkoi-elements' ),
		     		'left-to-right'  	=> esc_html__( 'Left to Right', 'wpkoi-elements' ),
		     	],
		  	]
		);

		$this->add_responsive_control(
			'wpkoi_elements_cta_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_cta_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
	         'name' => 'wpkoi_elements_cta_btn_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button',
			]
		);

		$this->start_controls_tabs( 'wpkoi_elements_cta_button_tabs' );

			// Normal State Tab
			$this->start_controls_tab( 'wpkoi_elements_cta_btn_normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_cta_btn_normal_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#4d4d4d',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_cta_btn_normal_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#f9f9f9',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_cat_btn_normal_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button',
				]
			);

			$this->add_control(
				'wpkoi_elements_cta_btn_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button' => 'border-radius: {{SIZE}}px;',
					],
				]
			);

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'wpkoi_elements_cta_btn_hover', [ 'label' => esc_html__( 'Hover', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_cta_btn_hover_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#f9f9f9',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_cta_btn_hover_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#3F51B5',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button:after' => 'background: {{VALUE}};',
						'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button:hover' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpkoi_elements_cta_btn_hover_border_color',
				[
					'label' => esc_html__( 'Border Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button:hover' => 'border-color: {{VALUE}};',
					],
				]

			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_cta_button_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-call-to-action .cta-button',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Button Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_cta_icon_style_settings',
			[
				'label' => esc_html__( 'Icon Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'wpkoi_elements_cta_type' => 'cta-icon-flex'
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_section_cta_icon_size',
			[
				'label' => esc_html__( 'Font Size', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 80
				],
				'range' => [
					'px' => [
						'max' => 160,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-call-to-action.cta-icon-flex .icon' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_section_cta_icon_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#444',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-call-to-action.cta-icon-flex .icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}


	protected function render( ) {

   		$settings = $this->get_settings_for_display();
	  	$target = $settings['wpkoi_elements_cta_btn_link']['is_external'] ? 'target="_blank"' : '';
	  	$nofollow = $settings['wpkoi_elements_cta_btn_link']['nofollow'] ? 'rel="nofollow"' : '';
	  	if( 'cta-bg-color' == $settings['wpkoi_elements_cta_color_type'] ) {
	  		$cta_class = 'bg-lite';
	  	}else if( 'cta-bg-img' == $settings['wpkoi_elements_cta_color_type'] ) {
	  		$cta_class = 'bg-img';
	  	}else if( 'cta-bg-img-fixed' == $settings['wpkoi_elements_cta_color_type'] ) {
	  		$cta_class = 'bg-img bg-fixed';
	  	}else {
	  		$cta_class = '';
	  	}
	  	// Is Basic Cta Content Center or Not
	  	if( 'cta-center' === $settings['wpkoi_elements_cta_content_type'] ) {
	  		$cta_alignment = 'cta-center';
	  	}elseif( 'cta-right' === $settings['wpkoi_elements_cta_content_type'] ) {
	  		$cta_alignment = 'cta-right';
	  	}else {
	  		$cta_alignment = 'cta-left';
	  	}
	  	// Button Effect
	  	if( 'left-to-right' == $settings['wpkoi_elements_cta_btn_effect_type'] ) {
	  		$cta_btn_effect = 'effect-2';
	  	}elseif( 'top-to-bottom' == $settings['wpkoi_elements_cta_btn_effect_type'] ) {
	  		$cta_btn_effect = 'effect-1';
	  	}else {
	  		$cta_btn_effect = '';
	  	}

	?>
	<?php if( 'cta-basic' == $settings['wpkoi_elements_cta_type'] ) : ?>
	<div class="wpkoi-elements-call-to-action <?php echo esc_attr( $cta_class ); ?> <?php echo esc_attr( $cta_alignment ); ?>">
	    <h2 class="title"><?php echo $settings['wpkoi_elements_cta_title']; ?></h2>
	    <?php if( 'content' == $settings['wpkoi_elements_cta_title_content_type'] ) : ?>
	    <p><?php echo $settings['wpkoi_elements_cta_content']; ?></p>
		<?php elseif( 'template' == $settings['wpkoi_elements_cta_title_content_type'] ) : ?>
			<?php
				if ( !empty( $settings['wpkoi_elements_primary_templates'] ) ) {
                    $wpkoi_elements_template_id = $settings['wpkoi_elements_primary_templates'];
                    $wpkoi_elements_frontend = new Frontend;
					echo $wpkoi_elements_frontend->get_builder_content( $wpkoi_elements_template_id, true );
                }
			?>
		<?php endif; ?>
	    <a href="<?php echo esc_url( $settings['wpkoi_elements_cta_btn_link']['url'] ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> class="cta-button <?php echo esc_attr( $cta_btn_effect ); ?>"><?php echo esc_html( $settings['wpkoi_elements_cta_btn_text'] ); ?></a>
	</div>
	<?php endif; ?>
	<?php if( 'cta-flex' == $settings['wpkoi_elements_cta_type'] ) : ?>
	<div class="wpkoi-elements-call-to-action cta-flex <?php echo esc_attr( $cta_class ); ?>">
	    <div class="content">
	        <h2 class="title"><?php echo $settings['wpkoi_elements_cta_title']; ?></h2>
	        <?php if( 'content' == $settings['wpkoi_elements_cta_title_content_type'] ) : ?>
		    <p><?php echo $settings['wpkoi_elements_cta_content']; ?></p>
			<?php elseif( 'template' == $settings['wpkoi_elements_cta_title_content_type'] ) : ?>
				<?php
					if ( !empty( $settings['wpkoi_elements_primary_templates'] ) ) {
	                    $wpkoi_elements_template_id = $settings['wpkoi_elements_primary_templates'];
	                    $wpkoi_elements_frontend = new Frontend;
						echo $wpkoi_elements_frontend->get_builder_content( $wpkoi_elements_template_id, true );
	                }
				?>
			<?php endif; ?>
	    </div>
	    <div class="action">
	        <a href="<?php echo esc_url( $settings['wpkoi_elements_cta_btn_link']['url'] ); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> class="cta-button <?php echo esc_attr( $cta_btn_effect ); ?>"><?php echo esc_html( $settings['wpkoi_elements_cta_btn_text'] ); ?></a>
	    </div>
	</div>
	<?php endif; ?>
	<?php if( 'cta-icon-flex' == $settings['wpkoi_elements_cta_type'] ) : ?>
	<div class="wpkoi-elements-call-to-action cta-icon-flex <?php echo esc_attr( $cta_class ); ?>">
	    <div class="icon">
	        <?php   
			$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_cta_flex_grid_icon_new'] );
			$is_new = empty( $settings['wpkoi_elements_cta_flex_grid_icon'] );
			if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['wpkoi_elements_cta_flex_grid_icon_new'], [ 'aria-hidden' => 'true' ] );
			else : ?>
				<i class="<?php echo $settings['wpkoi_elements_cta_flex_grid_icon']; ?>" aria-hidden="true"></i>
			<?php endif; ?>
	    </div>
	    <div class="content">
	        <h2 class="title"><?php echo $settings['wpkoi_elements_cta_title']; ?></h2>
	        <?php if( 'content' == $settings['wpkoi_elements_cta_title_content_type'] ) : ?>
		    <p><?php echo $settings['wpkoi_elements_cta_content']; ?></p>
			<?php elseif( 'template' == $settings['wpkoi_elements_cta_title_content_type'] ) : ?>
				<?php
					if ( !empty( $settings['wpkoi_elements_primary_templates'] ) ) {
	                    $wpkoi_elements_template_id = $settings['wpkoi_elements_primary_templates'];
	                    $wpkoi_elements_frontend = new Frontend;
						echo $wpkoi_elements_frontend->get_builder_content( $wpkoi_elements_template_id, true );
	                }
				?>
			<?php endif; ?>
	    </div>
	    <div class="action">
	       <a href="<?php echo esc_url( $settings['wpkoi_elements_cta_btn_link']['url'] ); ?>" <?php echo $target; ?> class="cta-button <?php echo esc_attr( $cta_btn_effect ); ?>"><?php echo esc_html( $settings['wpkoi_elements_cta_btn_text'] ); ?></a>
	    </div>
	</div>
	<?php endif; ?>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Cta_Box() );