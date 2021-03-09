<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_WPKoi_Distorted_Heading extends Widget_Base {

	public function get_name() {
		return 'wpkoi-distorted-heading';
	}

	public function get_title() {
		return esc_html__( 'Distorted Heading', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-heading';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}


	protected function register_controls() {


  		$this->start_controls_section(
			'section_content_heading',
			[
				'label' => __( 'Heading', 'wpkoi-elements' ),
			]
		);

		$this->add_control(
			'main_heading',
			[
				'label'       => __( 'Heading Text', 'wpkoi-elements' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Add Your text here', 'wpkoi-elements' ),
				'default'     => '',
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'wpkoi-elements' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'Paste URL or type', 'wpkoi-elements' ),
			]
		);

		$this->add_control(
			'header_size',
			[
				'label'   => __( 'HTML Tag', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
						'h1'  => esc_html__( 'H1', 'wpkoi-elements' ),
						'h2'  => esc_html__( 'H2', 'wpkoi-elements' ),
						'h3'  => esc_html__( 'H3', 'wpkoi-elements' ),
						'h4'  => esc_html__( 'H4', 'wpkoi-elements' ),
						'h5'  => esc_html__( 'H5', 'wpkoi-elements' ),
						'h6'  => esc_html__( 'H6', 'wpkoi-elements' ),
						'div'  => esc_html__( 'div', 'wpkoi-elements' ),
						'span'  => esc_html__( 'span', 'wpkoi-elements' ),
						'p'  => esc_html__( 'p', 'wpkoi-elements' ),
					),
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'wpkoi-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wpkoi-elements' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wpkoi-elements' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wpkoi-elements' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],

			]
		);

		$this->end_controls_section();
		

		$this->start_controls_section(
			'section_style_main_heading',
			[
				'label'     => __( 'Heading', 'wpkoi-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'main_heading!' => '',
				],
			]
		);

		$this->add_control(
			'main_heading_color',
			[
				'label'     => __( 'Color', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-distorted-heading .wpkoi-distorted-main > div' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'main_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wpkoi-distorted-heading .wpkoi-distorted-main > div',
			]
		);

		$this->add_control(
			'heading_distort_text',
			[
				'label'     => __( 'Scroll Distort', 'wpkoi-elements' ),
				'type'      => Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'main_heading_distort',
			[
				'label'        => __( 'Add Distort', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'wpkoi-distort-',
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'distort_type',
			[
				'label'   => __( 'Direction', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
						'1'  => esc_html__( '1', 'wpkoi-elements' ),
						'2'  => esc_html__( '2', 'wpkoi-elements' ),
						'3'  => esc_html__( '3', 'wpkoi-elements' ),
						'4'  => esc_html__( '4', 'wpkoi-elements' ),
						'5'  => esc_html__( '5', 'wpkoi-elements' ),
						'6'  => esc_html__( '6', 'wpkoi-elements' ),
						'7'  => esc_html__( '7', 'wpkoi-elements' ),
						'8'  => esc_html__( '8', 'wpkoi-elements' ),
						'9'  => esc_html__( '9', 'wpkoi-elements' ),
						'10'  => esc_html__( '10', 'wpkoi-elements' ),
					),
				'default' => '1',
                'condition'   => [
                    'main_heading_distort' => 'yes'
                ]
			]
		);

        $this->add_control(
            'distort_size',
            [
                'label'   => __( 'Text Size', 'wpkoi-elements' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
					'unit' => 'px',
                ],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					]
				],
                'condition'   => [
                    'main_heading_distort' => 'yes'
                ]
            ]
        );

		$this->end_controls_section();


	}


	protected function render( ) {

      	$settings         = $this->get_settings_for_display();
		$id               = $this->get_id();
		$heading_html     = [];
		$main_heading     = '';

		if ( empty( $settings['main_heading'] ) ) {
			return;
		}

		$this->add_render_attribute( 'heading', 'class', 'wpkoi-heading-title' );


		$this->add_render_attribute( 'main_heading', 'class', 'wpkoi-distorted-main-inner' );
		$this->add_inline_editing_attributes( 'main_heading' );

		if ($settings['main_heading']) :

			$mainh_style = '';

			$main_heading = '<div '.$this->get_render_attribute_string( 'main_heading' ).'  id="wpkoi-heading-title-'.$id.'" data-blotter><span>' . $settings['main_heading'] . '</span></div>';

			$main_heading = '<div class="wpkoi-distorted-main">' . $main_heading . $mainh_style . '</div>';

		endif;


		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'url', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}

			$main_heading = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $main_heading );
		}

		$heading_html[] = '<div id ="'.$id.'" class="wpkoi-distorted-heading">';
		
		
		$heading_html[] = sprintf( '<%1$s %2$s">%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'heading' ), $main_heading );
		
		$heading_html[] = '</div>';
		
		if ( 'yes' == $settings['main_heading_distort'] ) {
			$distortstyle = $settings["distort_type"];
			$heading_html[] = '<script type="text/javascript">jQuery(document).ready(function($) {class Blotter'.$id.' {constructor(el, options) {this.DOM = {el: el};this.DOM.textEl = this.DOM.el.querySelector("#wpkoi-heading-title-'.$id.' span");this.style = {family : "';
			$heading_html[] = "'" . $settings["main_heading_typography_font_family"] . "'";
			$heading_html[] = '",weight : ' . $settings["main_heading_typography_font_weight"] . ',size : ' . $settings["distort_size"]["size"] . ',leading: 1.8,fill : "'. $settings["main_heading_color"] .'"};Object.assign(this.style, options.style);this.material = new Material(options.type, options);this.text = new Blotter.Text(this.DOM.textEl.innerHTML, this.style);this.blotter = new Blotter(this.material, {texts: this.text});this.scope = this.blotter.forText(this.text);this.DOM.el.removeChild(this.DOM.textEl);this.scope.appendTo(this.DOM.el);const observer = new IntersectionObserver(entries => entries.forEach(entry => this.scope[entry.isIntersecting ? "play" : "pause"]()));observer.observe(this.scope.domElement);}}const config = [';
			
			if ( $distortstyle == '1' ) {
				$heading_html[] = '{type: "LiquidDistortMaterial",uniforms: [{uniform: "uSpeed", value: 0.6},{uniform: "uVolatility", value: 0},{uniform: "uSeed", value: 0.4}],animatable: [{prop: "uVolatility", from: 0, to: 0.4}],easeFactor: 0.05}';
			} elseif ( $distortstyle == '2' ) {
				$heading_html[] = '{type: "LiquidDistortMaterial",uniforms: [{uniform: "uSpeed", value: 0.9},{uniform: "uVolatility", value: 0},{uniform: "uSeed", value: 0.1}],animatable: [{prop: "uVolatility", from: 0, to: 2}],easeFactor: 0.1}';
			} elseif ( $distortstyle == '3' ) {
				$heading_html[] = '{type: "RollingDistortMaterial",uniforms: [{uniform: "uSineDistortSpread",value: 0.354},{uniform: "uSineDistortCycleCount",value: 5},{uniform: "uSineDistortAmplitude", value: 0},{uniform: "uNoiseDistortVolatility", value: 0},{uniform: "uNoiseDistortAmplitude", value: 0.168},{uniform: "uDistortPosition", value: [0.38,0.68]},{uniform: "uRotation", value: 48},{uniform: "uSpeed", value: 0.421}],animatable: [{prop: "uSineDistortAmplitude", from: 0, to: 0.5}],easeFactor: 0.15}';
			} elseif ( $distortstyle == '4' ) {
				$heading_html[] = '{type: "RollingDistortMaterial",uniforms: [{uniform: "uSineDistortSpread", value: 0.54},{uniform: "uSineDistortCycleCount", value: 2},{uniform: "uSineDistortAmplitude", value: 0},{uniform: "uNoiseDistortVolatility", value: 0},{uniform: "uNoiseDistortAmplitude", value: 0.15},{uniform: "uDistortPosition", value: [0.18,0.98]},{uniform: "uRotation", value: 90},{uniform: "uSpeed", value: 0.3}],animatable: [{prop: "uSineDistortAmplitude", from: 0, to: 0.2}],easeFactor: 0.05}';
			} elseif ( $distortstyle == '5' ) {
				$heading_html[] = '{type: "RollingDistortMaterial",uniforms: [{uniform: "uSineDistortSpread", value: 0.44},{uniform: "uSineDistortCycleCount", value: 5},{uniform: "uSineDistortAmplitude", value: 0},{uniform: "uNoiseDistortVolatility", value: 0},{uniform: "uNoiseDistortAmplitude", value: 0.85},{uniform: "uDistortPosition", value: [0,0]},{uniform: "uRotation", value: 0},{uniform: "uSpeed", value: .1}],animatable: [{prop: "uSineDistortAmplitude", from: 0, to: 0.2}],easeFactor: 0.35}';
			} elseif ( $distortstyle == '6' ) {
				$heading_html[] = '{type: "RollingDistortMaterial",uniforms: [{uniform: "uSineDistortSpread", value: 0.74},{uniform: "uSineDistortCycleCount", value: 7},{uniform: "uSineDistortAmplitude", value: 0},{uniform: "uNoiseDistortVolatility", value: 0},{uniform: "uNoiseDistortAmplitude", value: 0.15},{uniform: "uDistortPosition", value: [0.1,0.5]},{uniform: "uRotation", value: 20},{uniform: "uSpeed", value: 0.7}],animatable: [{prop: "uSineDistortAmplitude", from: 0, to: 0.2}],easeFactor: 0.1}';
			} elseif ( $distortstyle == '7' ) {
				$heading_html[] = '{type: "RollingDistortMaterial",uniforms: [{uniform: "uSineDistortSpread", value: 0.084},{uniform: "uSineDistortCycleCount", value: 2.2},{uniform: "uSineDistortAmplitude", value: 0},{uniform: "uNoiseDistortVolatility", value: 0},{uniform: "uNoiseDistortAmplitude", value: 0},{uniform: "uDistortPosition", value: [0.35,0.37]},{uniform: "uRotation", value: 180},{uniform: "uSpeed", value: 0.94}],animatable: [{prop: "uSineDistortAmplitude", from: 0, to: 0.13}],easeFactor: 0.15}';
			} elseif ( $distortstyle == '8' ) {
				$heading_html[] = '{type: "RollingDistortMaterial",uniforms: [{uniform: "uSineDistortSpread", value: 0},{uniform: "uSineDistortCycleCount", value: 0},{uniform: "uSineDistortAmplitude", value: 0},{uniform: "uNoiseDistortVolatility", value: 0.01},{uniform: "uNoiseDistortAmplitude", value: 0.126},{uniform: "uDistortPosition", value: [0.3,0.3]},{uniform: "uRotation", value: 180},{uniform: "uSpeed", value: 0.13}],animatable: [{prop: "uNoiseDistortVolatility", from: 0.01, to: 200},{prop: "uRotation", from: 180, to: 270}],easeFactor: 0.25}';
			} elseif ( $distortstyle == '9' ) {
				$heading_html[] = '{type: "RollingDistortMaterial",uniforms: [{uniform: "uSineDistortSpread", value: 0.1},{uniform: "uSineDistortCycleCount", value: 0},{uniform: "uSineDistortAmplitude", value: 0},{uniform: "uNoiseDistortVolatility", value: 0},{uniform: "uNoiseDistortAmplitude", value: 0},{uniform: "uDistortPosition", value: [0,0]},{uniform: "uRotation", value: 90},{uniform: "uSpeed", value: 2}],animatable: [{prop: "uSineDistortAmplitude", from: 0, to: 0.3},{prop: "uSineDistortCycleCount", from: 0, to: 1.5},],easeFactor: 0.35}';
			} elseif ( $distortstyle == '10' ) {
				$heading_html[] = '{type: "RollingDistortMaterial",uniforms: [{uniform: "uSineDistortSpread", value: 0.28},{uniform: "uSineDistortCycleCount", value: 7},{uniform: "uSineDistortAmplitude", value: 0},{uniform: "uNoiseDistortVolatility", value: 0},{uniform: "uNoiseDistortAmplitude", value: 0},{uniform: "uDistortPosition", value: [0,0]},{uniform: "uRotation", value: 90},{uniform: "uSpeed", value: 0.3}],animatable: [{prop: "uSineDistortAmplitude", from: 0, to: 0.2}],easeFactor: 0.65}';
			}
			
			$heading_html[] = '];[...document.querySelectorAll("#wpkoi-heading-title-'.$id.'")].forEach((el, pos) => new Blotter'.$id.'(el, config[pos]))});</script>';
		}

		echo implode("", $heading_html);
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Distorted_Heading() );