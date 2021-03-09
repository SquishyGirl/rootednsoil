<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WPKoi_Elements_Flip_Box extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-flip-box';
	}

	public function get_title() {
		return esc_html__( 'Flip Box', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {

  		/**
  		 * Flipbox Image Settings
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_flipbox_content_settings',
  			[
  				'label' => esc_html__( 'Flipbox Settings', 'wpkoi-elements' )
  			]
  		);

  		$this->add_control(
		  'wpkoi_elements_flipbox_type',
		  	[
		   	'label'       	=> esc_html__( 'Flipbox Type', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'animate-left',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'animate-left'  		=> esc_html__( 'Flip Left', 'wpkoi-elements' ),
		     		'animate-right' 		=> esc_html__( 'Flip Right', 'wpkoi-elements' ),
		     		'animate-up' 			=> esc_html__( 'Flip Top', 'wpkoi-elements' ),
		     		'animate-down' 		=> esc_html__( 'Flip Bottom', 'wpkoi-elements' ),
		     		'animate-zoom-in' 	=> esc_html__( 'Zoom In', 'wpkoi-elements' ),
		     		'animate-zoom-out' 	=> esc_html__( 'Zoom Out', 'wpkoi-elements' ),
		     	],
		  	]
		);

		$this->add_responsive_control(
			'wpkoi_elements_flipbox_img_or_icon',
			[
				'label' => esc_html__( 'Image or Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'img' => [
						'title' => esc_html__( 'Image', 'wpkoi-elements' ),
						'icon' => 'fa fa-picture-o',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'wpkoi-elements' ),
						'icon' => 'fa fa-info-circle',
					],
				],
				'default' => 'icon',
			]
		);
		/**
		 * Condition: 'wpkoi_elements_flipbox_img_or_icon' => 'img'
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_image',
			[
				'label' => esc_html__( 'Flipbox Image', 'wpkoi-elements' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'wpkoi_elements_flipbox_img_or_icon' => 'img'
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_flipbox_image_resizer',
			[
				'label' => esc_html__( 'Image Resizer', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '100'
				],
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-icon-image img' => 'width: {{SIZE}}px;',
				],
				'condition' => [
					'wpkoi_elements_flipbox_img_or_icon' => 'img'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'condition' => [
					'wpkoi_elements_flipbox_image[url]!' => '',
				],
				'condition' => [
					'wpkoi_elements_flipbox_img_or_icon' => 'img'
				]
			]
		);
		/**
		 * Condition: 'wpkoi_elements_flipbox_img_or_icon' => 'icon'
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_icon_new',
			[
				'label' => esc_html__( 'Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_flipbox_icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'wpkoi_elements_flipbox_img_or_icon' => 'icon'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Flipbox Content
		 */
		$this->start_controls_section(
			'wpkoi_elements_flipbox_content',
			[
				'label' => esc_html__( 'Flipbox Content', 'wpkoi-elements' ),
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_flipbox_front_or_back_content',
			[
				'label' => esc_html__( 'Front or Back Content', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'front' => [
						'title' => esc_html__( 'Front Content', 'wpkoi-elements' ),
						'icon' => 'fa fa-reply',
					],
					'back' => [
						'title' => esc_html__( 'Back Content', 'wpkoi-elements' ),
						'icon' => 'fa fa-share',
					],
				],
				'default' => 'front',
			]
		);
		/**
		 * Condition: 'wpkoi_elements_flipbox_front_or_back_content' => 'front'
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_front_title',
			[
				'label' => esc_html__( 'Front Title', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Elementor Flipbox', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_flipbox_front_or_back_content' => 'front'
				]
			]
		);
		$this->add_control(
			'wpkoi_elements_flipbox_front_text',
			[
				'label' => esc_html__( 'Front Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => __( 'This is front-end content.', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_flipbox_front_or_back_content' => 'front'
				]
			]
		);
		/**
		 * Condition: 'wpkoi_elements_flipbox_front_or_back_content' => 'back'
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_back_title',
			[
				'label' => esc_html__( 'Back Title', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Elementor Flipbox', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_flipbox_front_or_back_content' => 'back'
				]
			]
		);
		$this->add_control(
			'wpkoi_elements_flipbox_back_text',
			[
				'label' => esc_html__( 'Back Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => __( 'This is back-end content.', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_flipbox_front_or_back_content' => 'back'
				]
			]
		);
		$this->add_responsive_control(
			'wpkoi_elements_flipbox_content_alignment',
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
				'prefix_class' => 'wpkoi-elements-flipbox-content-align-',
			]
		);
		$this->end_controls_section();
		/**
		 * -------------------------------------------
		 * Tab Style (Flipbox Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_flipbox_style_settings',
			[
				'label' => esc_html__( 'Filp Box Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_flipbox_front_bg_color',
			[
				'label' => esc_html__( 'Front Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#61ce70',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-front-container' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_flipbox_back_bg_color',
			[
				'label' => esc_html__( 'Back Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff0000',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-rear-container' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_flipbox_container_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-elements-progression-flip-box-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_flipbox_front_back_padding',
			[
				'label' => esc_html__( 'Fornt / Back Content Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-front-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-rear-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_flipbox_container_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-elements-progression-flip-box-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_filbpox_border',
					'label' => esc_html__( 'Border Style', 'wpkoi-elements' ),
					'selectors' => ['{{WRAPPER}} .wpkoi-elements-elements-flip-box-front-container', '{{WRAPPER}} .wpkoi-elements-elements-flip-box-rear-container'],
				]
		);

		$this->add_control(
			'wpkoi_elements_flipbox_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-progression-flip-box-container' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_flipbox_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-elements-progression-flip-box-container',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Flip Box Image)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_flipbox_imgae_style_settings',
			[
				'label' => esc_html__( 'Image Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
		     		'wpkoi_elements_flipbox_img_or_icon' => 'img'
		     	]
			]
		);

		$this->add_control(
		  'wpkoi_elements_flipbox_img_type',
		  	[
		   	'label'       	=> esc_html__( 'Image Type', 'wpkoi-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'default',
		     	'label_block' 	=> false,
		     	'options' 		=> [
		     		'circle'  	=> esc_html__( 'Circle', 'wpkoi-elements' ),
		     		'radius' 	=> esc_html__( 'Radius', 'wpkoi-elements' ),
		     		'default' 	=> esc_html__( 'Default', 'wpkoi-elements' ),
		     	],
		     	'prefix_class' => 'wpkoi-elements-flipbox-img-',
		     	'condition' => [
		     		'wpkoi_elements_flipbox_img_or_icon' => 'img'
		     	]
		  	]
		);

		/**
		 * Condition: 'wpkoi_elements_flipbox_img_type' => 'radius'
		 */
		$this->add_control(
			'wpkoi_elements_filpbox_img_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-icon-image img' => 'border-radius: {{SIZE}}px;',
				],
				'condition' => [
					'wpkoi_elements_flipbox_img_or_icon' => 'img',
					'wpkoi_elements_flipbox_img_type' => 'radius'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Flip Box Icon Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_flipbox_icon_style_settings',
			[
				'label' => esc_html__( 'Icon Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
		     		'wpkoi_elements_flipbox_img_or_icon' => 'icon'
		     	]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_flipbox_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-elements-flip-box-icon-image',
					'condition' => [
						'wpkoi_elements_flipbox_img_or_icon' => 'icon'
					]
				]
		);

		$this->add_control(
			'wpkoi_elements_flipbox_icon_border_padding',
			[
				'label' => esc_html__( 'Border Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-icon-image' => 'padding: {{SIZE}}px;',
				],
				'condition' => [
					'wpkoi_elements_flipbox_img_or_icon' => 'icon'
				]
			]
		);

		$this->add_control(
			'wpkoi_elements_flipbox_icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-icon-image' => 'border-radius: {{SIZE}}px;',
				],
				'condition' => [
					'wpkoi_elements_flipbox_img_or_icon' => 'icon'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Flip Box Title Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_flipbox_title_style_settings',
			[
				'label' => esc_html__( 'Color &amp; Typography', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_flipbox_front_back_content_toggler',
			[
				'label' => esc_html__( 'Front or Rear Content', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'front' => [
						'title' => esc_html__( 'Front Content', 'wpkoi-elements' ),
						'icon' => 'fa fa-arrow-left',
					],
					'back' => [
						'title' => esc_html__( 'Rear Content', 'wpkoi-elements' ),
						'icon' => 'fa fa-arrow-right',
					],
				],
				'default' => 'front',
			]
		);

		$this->add_control(
			'wpkoi_elements_flipbox_front_title_heading',
			[
				'label' => esc_html__( 'Title Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		/**
		 * Condition: 'wpkoi_elements_flipbox_front_back_content_toggler' => 'front'
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_front_title_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-front-container .wpkoi-elements-elements-flip-box-heading, {{WRAPPER}} .wpkoi-elements-elements-flip-box-front-container i' => 'color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_flipbox_front_back_content_toggler' => 'front'
				]
			]
		);

		/**
		 * Condition: 'wpkoi_elements_flipbox_front_back_content_toggler' => 'back'
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_back_title_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-rear-container .wpkoi-elements-elements-flip-box-heading, {{WRAPPER}} .wpkoi-elements-elements-flip-box-rear-container i' => 'color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_flipbox_front_back_content_toggler' => 'back'
				]
			]
		);

		/**
		 * Condition: 'wpkoi_elements_flipbox_front_back_content_toggler' => 'front'
		 */
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name' => 'wpkoi_elements_flipbox_front_title_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-elements-flip-box-front-container .wpkoi-elements-elements-flip-box-heading',
				'condition' => [
					'wpkoi_elements_flipbox_front_back_content_toggler' => 'front'
				],
			]
		);

		/**
		 * Condition: 'wpkoi_elements_flipbox_front_back_content_toggler' => 'back'
		 */
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name' => 'wpkoi_elements_flipbox_back_title_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-elements-flip-box-rear-container .wpkoi-elements-elements-flip-box-heading',
				'condition' => [
					'wpkoi_elements_flipbox_front_back_content_toggler' => 'back'
				],
			]
		);

		/**
		 * Content
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_content_heading',
			[
				'label' => esc_html__( 'Content Style', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		/**
		 * Condition: 'wpkoi_elements_flipbox_front_back_content_toggler' => 'front'
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_front_content_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-front-container .wpkoi-elements-elements-flip-box-content' => 'color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_flipbox_front_back_content_toggler' => 'front'
				]
			]
		);

		/**
		 * Condition: 'wpkoi_elements_flipbox_front_back_content_toggler' => 'back'
		 */
		$this->add_control(
			'wpkoi_elements_flipbox_back_content_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-elements-flip-box-rear-container .wpkoi-elements-elements-flip-box-content' => 'color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_flipbox_front_back_content_toggler' => 'back'
				]
			]
		);

		/**
		 * Condition: 'wpkoi_elements_flipbox_front_back_content_toggler' => 'front'
		 */
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name' => 'wpkoi_elements_flipbox_front_content_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-elements-flip-box-front-container .wpkoi-elements-elements-flip-box-content',
				'condition' => [
					'wpkoi_elements_flipbox_front_back_content_toggler' => 'front'
				]
			]
		);

		/**
		 * Condition: 'wpkoi_elements_flipbox_front_back_content_toggler' => 'back'
		 */
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
            	'name' => 'wpkoi_elements_flipbox_back_content_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-elements-flip-box-rear-container .wpkoi-elements-elements-flip-box-content',
				'condition' => [
					'wpkoi_elements_flipbox_front_back_content_toggler' => 'back'
				]
			]
		);

		$this->end_controls_section();

	}


	protected function render( ) {

   		$settings = $this->get_settings();
      	$flipbox_image = $this->get_settings( 'wpkoi_elements_flipbox_image' );
	  	$flipbox_image_url = Group_Control_Image_Size::get_attachment_image_src( $flipbox_image['id'], 'thumbnail', $settings );
	  	if( empty( $flipbox_image_url ) ) : $flipbox_image_url = $flipbox_image['url']; else: $flipbox_image_url = $flipbox_image_url; endif;

	?>

	<div class="wpkoi-elements-elements-progression-flip-box-container wpkoi-elements-animate-flip wpkoi-elements-<?php echo esc_attr( $settings['wpkoi_elements_flipbox_type'] ); ?>">
	    <div class="wpkoi-elements-elements-flip-box-flip-card">
	        <div class="wpkoi-elements-elements-flip-box-front-container">
	            <div class="wpkoi-elements-elements-slider-display-table">
	                <div class="wpkoi-elements-elements-flip-box-vertical-align">
	                    <div class="wpkoi-elements-elements-flip-box-padding">
	                        <div class="wpkoi-elements-elements-flip-box-icon-image">
	                        	<?php if( 'icon' === $settings['wpkoi_elements_flipbox_img_or_icon'] ) : ?>
	                           	<?php   
								$migrated = isset( $settings['__fa4_migrated']['wpkoi_elements_flipbox_icon_new'] );
								$is_new = empty( $settings['wpkoi_elements_flipbox_icon'] );
								if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['wpkoi_elements_flipbox_icon_new'], [ 'aria-hidden' => 'true' ] );
								else : ?>
									<i class="<?php echo $settings['wpkoi_elements_flipbox_icon']; ?>" aria-hidden="true"></i>
								<?php endif; ?>
	                           <?php elseif( 'img' === $settings['wpkoi_elements_flipbox_img_or_icon'] ): ?>
	                           	<img src="<?php echo esc_url( $flipbox_image_url ); ?>" alt="">
	                           <?php endif; ?>
	                        </div>
	                        <h3 class="wpkoi-elements-elements-flip-box-heading"><?php echo esc_html( $settings['wpkoi_elements_flipbox_front_title'] ); ?></h3>
	                        <div class="wpkoi-elements-elements-flip-box-content">
	                           <p><?php echo $settings['wpkoi_elements_flipbox_front_text'] ; ?></p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="wpkoi-elements-elements-flip-box-rear-container">
	            <div class="wpkoi-elements-elements-slider-display-table">
	                <div class="wpkoi-elements-elements-flip-box-vertical-align">
	                    <div class="wpkoi-elements-elements-flip-box-padding">
	                        <h2 class="wpkoi-elements-elements-flip-box-heading"><?php echo esc_html( $settings['wpkoi_elements_flipbox_back_title'] ); ?></h2>
	                        <div class="wpkoi-elements-elements-flip-box-content">
	                           <p><?php echo $settings['wpkoi_elements_flipbox_back_text'] ; ?></p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Flip_Box() );