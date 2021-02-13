<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_WPKoi_Elements_Testimonial extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-testimonial';
	}

	public function get_title() {
		return esc_html__( 'Testimonial', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}


	protected function register_controls() {


  		$this->start_controls_section(
  			'wpkoi_elements_section_testimonial_image',
  			[
  				'label' => esc_html__( 'Testimonial Image', 'wpkoi-elements' )
  			]
  		);

		$this->add_control(
			'wpkoi_elements_testimonial_enable_avatar',
			[
				'label' => esc_html__( 'Display Avatar?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_image',
			[
				'label' => __( 'Testimonial Avatar', 'wpkoi-elements' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'wpkoi_elements_testimonial_enable_avatar' => 'yes',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'thumbnail',
				'condition' => [
					'wpkoi_elements_testimonial_image[url]!' => '',
					'wpkoi_elements_testimonial_enable_avatar' => 'yes',
				],
			]
		);


		$this->end_controls_section();

  		$this->start_controls_section(
  			'wpkoi_elements_section_testimonial_content',
  			[
  				'label' => esc_html__( 'Testimonial Content', 'wpkoi-elements' )
  			]
  		);


		$this->add_control(
			'wpkoi_elements_testimonial_name',
			[
				'label' => esc_html__( 'User Name', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'wpkoi-elements' ),
				'dynamic' => [ 'active' => true ]
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_company_title',
			[
				'label' => esc_html__( 'Company Name', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Codetic', 'wpkoi-elements' ),
				'dynamic' => [ 'active' => true ]
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_description',
			[
				'label' => esc_html__( 'Testimonial Description', 'wpkoi-elements' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Add testimonial description here. Edit and place your own text.', 'wpkoi-elements' ),
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'wpkoi_elements_section_testimonial_styles_general',
			[
				'label' => esc_html__( 'Testimonial Styles', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_background',
			[
				'label' => esc_html__( 'Testimonial Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_alignment',
			[
				'label' => esc_html__( 'Set Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'wpkoi-elements-testimonial-align-default' => [
						'title' => __( 'Default', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					],
					'wpkoi-elements-testimonial-align-left' => [
						'title' => esc_html__( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'wpkoi-elements-testimonial-align-centered' => [
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'wpkoi-elements-testimonial-align-right' => [
						'title' => esc_html__( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'wpkoi-elements-testimonial-align-default',
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_user_display_block',
			[
				'label' => esc_html__( 'Display User & Company Block?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_testimonial_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_testimonial_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-testimonial-item',
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'wpkoi_elements_section_testimonial_image_styles',
			[
				'label' => esc_html__( 'Testimonial Image Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_testimonial_image_width',
			[
				'label' => esc_html__( 'Image Width', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 150,
					'unit' => 'px',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-image img' => 'width:{{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'wpkoi_elements_testimonial_image_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_testimonial_image_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_testimonial_image_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-testimonial-image img',
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_image_rounded',
			[
				'label' => esc_html__( 'Rounded Avatar?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'testimonial-avatar-rounded',
				'default' => '',
			]
		);


		$this->add_control(
			'wpkoi_elements_testimonial_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-image img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'wpkoi_elements_testimonial_image_rounded!' => 'testimonial-avatar-rounded',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'wpkoi_elements_section_testimonial_typography',
			[
				'label' => esc_html__( 'Color &amp; Typography', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_name_heading',
			[
				'label' => __( 'User Name', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_name_color',
			[
				'label' => esc_html__( 'User Name Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-content .wpkoi-elements-testimonial-user' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_testimonial_name_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-testimonial-content .wpkoi-elements-testimonial-user',
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_company_heading',
			[
				'label' => __( 'Company Name', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);


		$this->add_control(
			'wpkoi_elements_testimonial_company_color',
			[
				'label' => esc_html__( 'Company Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-content .wpkoi-elements-testimonial-user-company' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_testimonial_position_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-testimonial-content .wpkoi-elements-testimonial-user-company',
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_description_heading',
			[
				'label' => __( 'Testimonial Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_description_color',
			[
				'label' => esc_html__( 'Testimonial Text Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7a7a7a',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-content .wpkoi-elements-testimonial-text, {{WRAPPER}} .wpkoi-elements-testimonial-content .wpkoi-elements-testimonial-text p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_testimonial_description_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-testimonial-content .wpkoi-elements-testimonial-text',
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_quotation_heading',
			[
				'label' => __( 'Quotation Mark', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_testimonial_quotation_color',
			[
				'label' => esc_html__( 'Quotation Mark Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.15)',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-testimonial-quote' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_testimonial_quotation_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-testimonial-quote',
			]
		);


		$this->end_controls_section();


	}


	protected function render( ) {

      $settings = $this->get_settings_for_display();
      $testimonial_image = $this->get_settings( 'wpkoi_elements_testimonial_image' );
	  $testimonial_image_url = Group_Control_Image_Size::get_attachment_image_src( $testimonial_image['id'], 'thumbnail', $settings );
	  $testimonial_classes = $this->get_settings('wpkoi_elements_testimonial_image_rounded') . " " . $this->get_settings('wpkoi_elements_testimonial_alignment');


	?>


<div id="wpkoi-elements-testimonial-<?php echo esc_attr($this->get_id()); ?>" class="wpkoi-elements-testimonial-item clearfix <?php echo $testimonial_classes; ?>">

	<div class="wpkoi-elements-testimonial-image">
		<i class="fas fa-quote-left wpkoi-elements-testimonial-quote"></i>
		<?php if( 'yes' == $settings['wpkoi_elements_testimonial_enable_avatar'] ) : ?>
			<figure>
				<img src="<?php echo esc_url($testimonial_image_url);?>" alt="<?php echo $settings['wpkoi_elements_testimonial_name'];?>">
			</figure>
		<?php endif; ?>
	</div>

	<div class="wpkoi-elements-testimonial-content">
		<i class="fas fa-quote-left wpkoi-elements-testimonial-quote"></i>
		<div class="wpkoi-elements-testimonial-text"><?php echo $settings['wpkoi_elements_testimonial_description']; ?></div>
		<p class="wpkoi-elements-testimonial-user" <?php if ( ! empty( $settings['wpkoi_elements_testimonial_user_display_block'] ) ) : ?> style="display: block; float: none;"<?php endif;?>><?php echo $settings['wpkoi_elements_testimonial_name']; ?></p>
		<p class="wpkoi-elements-testimonial-user-company"><?php echo $settings['wpkoi_elements_testimonial_company_title']; ?></p>
	</div>
</div>


	<?php

	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Testimonial() );