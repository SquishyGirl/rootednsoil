<?php
/**
 * Class: WPKoi_Elements_Circle_Progress
 * Name: Circle Progress
 * Slug: wpkoi-circle-progress
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPKoi_Elements_Circle_Progress extends Widget_Base {

	public function get_name() {
		return 'wpkoi-circle-progress';
	}

	public function get_title() {
		return esc_html__( 'Circle Progress', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-loading';
	}

	public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_values',
			array(
				'label' => esc_html__( 'Circle Progress', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'values_type',
			array(
				'label'   => esc_html__( 'Type', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'percent',
				'options' => array(
					'percent'  => esc_html__( 'Percent', 'wpkoi-elements' ),
					'absolute' => esc_html__( 'Absolute', 'wpkoi-elements' ),
				),
			)
		);

		$this->add_control(
			'percent_value',
			array(
				'label'      => esc_html__( 'Percent', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'condition' => array(
					'values_type' => 'percent',
				),
			)
		);

		$this->add_control(
			'absolute_value_curr',
			array(
				'label'     => esc_html__( 'Value', 'wpkoi-elements' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 50,
				'condition' => array(
					'values_type' => 'absolute',
				),
			)
		);

		$this->add_control(
			'absolute_value_max',
			array(
				'label'     => esc_html__( 'Max Value', 'wpkoi-elements' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 100,
				'condition' => array(
					'values_type' => 'absolute',
				),
			)
		);

		$this->add_control(
			'prefix',
			array(
				'label'       => esc_html__( 'Number Prefix', 'wpkoi-elements' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => '+',
			)
		);

		$this->add_control(
			'suffix',
			array(
				'label'       => esc_html__( 'Number Suffix', 'wpkoi-elements' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '%',
				'placeholder' => '%',
			)
		);

		$this->add_control(
			'thousand_separator',
			array(
				'label'     => esc_html__( 'Thousand Separator', 'wpkoi-elements' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'wpkoi-elements' ),
				'label_off' => esc_html__( 'No', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Counter Title', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'   => esc_html__( 'Counter Subtitle', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'percent_position',
			array(
				'label'   => esc_html__( 'Value Position', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'in-circle',
				'options' => array(
					'in-circle'  => esc_html__( 'Inside of Circle', 'wpkoi-elements' ),
					'out-circle' => esc_html__( 'Outside of Circle', 'wpkoi-elements' ),
				),
			)
		);

		$this->add_control(
			'labels_position',
			array(
				'label'   => esc_html__( 'Title Position', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'out-circle',
				'options' => array(
					'in-circle'  => esc_html__( 'Inside of Circle', 'wpkoi-elements' ),
					'out-circle' => esc_html__( 'Outside of Circle', 'wpkoi-elements' ),
				),
			)
		);

		$this->add_responsive_control(
			'circle_size',
			array(
				'label'      => esc_html__( 'Circle Size', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 175,
				),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 600,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .circle-progress-bar' => 'max-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .circle-progress' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .position-in-circle'  => 'height: {{SIZE}}{{UNIT}}',

				),
				'render_type' => 'template',
			)
		);

		$this->add_responsive_control(
			'value_stroke',
			array(
				'label'      => esc_html__( 'Value Stoke Width', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 12,
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
				),
			)
		);

		$this->add_responsive_control(
			'bg_stroke',
			array(
				'label'      => esc_html__( 'Background Stoke Width', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 6,
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 300,
					),
				),
			)
		);

		$this->add_control(
			'duration',
			array(
				'label'   => esc_html__( 'Animation Duration', 'wpkoi-elements' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 800,
				'min'     => 100,
				'step'    => 100,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_progress_style',
			array(
				'label'      => esc_html__( 'Progress Circle Style', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'bg_stroke_type',
			array(
				'label'       => esc_html__( 'Background Stroke Type', 'wpkoi-elements' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color' => array(
						'title' => esc_html__( 'Classic', 'wpkoi-elements' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => esc_html__( 'Gradient', 'wpkoi-elements' ),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'val_bg_color',
			array(
				'label'     => esc_html__( 'Background Stroke Color', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e6e9ec',
				'condition' => array(
					'bg_stroke_type' => array( 'color' ),
				),
			)
		);

		$this->add_control(
			'val_bg_gradient_color_a',
			array(
				'label'     => esc_html__( 'Background Stroke Color A', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#54595f',
				'condition' => array(
					'bg_stroke_type' => array( 'gradient' ),
				),
			)
		);

		$this->add_control(
			'val_bg_gradient_color_b',
			array(
				'label'     => esc_html__( 'Background Stroke Color B', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#858d97',
				'condition' => array(
					'bg_stroke_type' => array( 'gradient' ),
				),
			)
		);

		$this->add_control(
			'val_bg_gradient_angle',
			array(
				'label'     => esc_html__( 'Background Stroke Gradient Angle', 'wpkoi-elements' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 45,
				'min'       => 0,
				'max'       => 360,
				'step'      => 0,
				'condition' => array(
					'bg_stroke_type' => array( 'gradient' ),
				),
			)
		);

		$this->add_control(
			'val_stroke_type',
			array(
				'label'       => esc_html__( 'Value Stroke Type', 'wpkoi-elements' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color' => array(
						'title' => esc_html__( 'Classic', 'wpkoi-elements' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => esc_html__( 'Gradient', 'wpkoi-elements' ),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'val_stroke_color',
			array(
				'label'     => esc_html__( 'Value Stroke Color', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6ec1e4',
				'condition' => array(
					'val_stroke_type' => array( 'color' ),
				),
			)
		);

		$this->add_control(
			'val_stroke_gradient_color_a',
			array(
				'label'     => esc_html__( 'Value Stroke Color A', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6ec1e4',
				'condition' => array(
					'val_stroke_type' => array( 'gradient' ),
				),
			)
		);

		$this->add_control(
			'val_stroke_gradient_color_b',
			array(
				'label'     => esc_html__( 'Value Stroke Color B', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#b6e0f1',
				'condition' => array(
					'val_stroke_type' => array( 'gradient' ),
				),
			)
		);

		$this->add_control(
			'val_stroke_gradient_angle',
			array(
				'label'     => esc_html__( 'Value Stroke Angle', 'wpkoi-elements' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 45,
				'min'       => 0,
				'max'       => 360,
				'step'      => 1,
				'condition' => array(
					'val_stroke_type' => array( 'gradient' ),
				),
			)
		);

		$this->add_control(
			'circle_fill_color',
			array(
				'label'     => esc_html__( 'Circle Fill Color', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .circle-progress__meter' => 'fill: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'line_endings',
			array(
				'label'   => esc_html__( 'Progress Line Endings', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'butt',
				'options' => array(
					'butt'  => esc_html__( 'Flat', 'wpkoi-elements' ),
					'round' => esc_html__( 'Rounded', 'wpkoi-elements' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .circle-progress__value' => 'stroke-linecap: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'circle_box_shadow',
				'label'    => esc_html__( 'Circle Box Shadow', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .circle-progress',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			array(
				'label'      => esc_html__( 'Content Style', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'number_style',
			array(
				'label'     => esc_html__( 'Number Styles', 'wpkoi-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'number_color',
			array(
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} .circle-counter .circle-val' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'number_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .circle-counter .circle-val',
			)
		);

		$this->add_responsive_control(
			'number_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .circle-counter .circle-val' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'number_prefix_font_size',
			array(
				'label'      => esc_html__( 'Prefix Font Size', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .circle-counter .circle-val .circle-counter__prefix' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'number_prefix_gap',
			array(
				'label'      => esc_html__( 'Prefix Gap (px)', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'body:not(.rtl) {{WRAPPER}} .circle-counter .circle-val .circle-counter__prefix' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .circle-counter .circle-val .circle-counter__prefix' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'number_prefix_alignment',
			array(
				'label'       => esc_html__( 'Prefix Alignment', 'wpkoi-elements' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default'     => 'center',
				'options'     => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'wpkoi-elements' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'wpkoi-elements' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .circle-counter .circle-val .circle-counter__prefix' => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'number_suffix_font_size',
			array(
				'label'      => esc_html__( 'Suffix Font Size', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .circle-counter .circle-val .circle-counter__suffix' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'number_suffix_gap',
			array(
				'label'      => esc_html__( 'Suffix Gap (px)', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'body:not(.rtl) {{WRAPPER}} .circle-counter .circle-val .circle-counter__suffix' => 'margin-left: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .circle-counter .circle-val .circle-counter__suffix' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'number_suffix_alignment',
			array(
				'label'       => esc_html__( 'Suffix Alignment', 'wpkoi-elements' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default'     => 'center',
				'options'     => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'wpkoi-elements' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'wpkoi-elements' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .circle-counter .circle-val .circle-counter__suffix' => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_style',
			array(
				'label'     => esc_html__( 'Title Styles', 'wpkoi-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .circle-counter .circle-counter__title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .circle-counter .circle-counter__title',
			)
		);

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .circle-counter .circle-counter__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'subtitle_style',
			array(
				'label'     => esc_html__( 'Subtitle Styles', 'wpkoi-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'  => esc_html__( 'Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} .circle-counter .circle-counter__subtitle' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .circle-counter .circle-counter__subtitle',
			)
		);

		$this->add_responsive_control(
			'subtitle_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .circle-counter .circle-counter__subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$perc_position   = $this->get_settings_for_display( 'percent_position' );
		$labels_position = $this->get_settings_for_display( 'labels_position' );
		
		$this->add_render_attribute( 'circle-wrap', array(
			'class'         => 'circle-progress-wrap',
			'data-duration' => $this->get_settings_for_display( 'duration' ),
		) );
		
		$this->add_render_attribute( 'circle-bar', array(
			'class' => 'circle-progress-bar',
		) );
		
		?>
		<div <?php echo $this->get_render_attribute_string( 'circle-wrap' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'circle-bar' ); ?>>
			<?php
				$settings   = $this->get_settings_for_display();
				$size       = is_array( $settings['circle_size'] ) ? $settings['circle_size']['size'] : $settings['circle_size'];
				$radius     = $size / 2;
				$center     = $radius;
				$viewbox    = sprintf( '0 0 %1$s %1$s', $size );
				$val_stroke = is_array( $settings['value_stroke'] ) ? $settings['value_stroke']['size'] : $settings['value_stroke'];
				$bg_stroke  = is_array( $settings['bg_stroke'] ) ? $settings['bg_stroke']['size'] : $settings['bg_stroke'];
				
				// Fix radius relative to stroke
				$max    = ( $val_stroke >= $bg_stroke ) ? $val_stroke : $bg_stroke;
				$radius = $radius - ( $max / 2 );
				
				$value = 0;
				
				if ( 'percent' === $settings['values_type'] ) {
					$value = $settings['percent_value']['size'];
				} elseif ( 0 !== absint( $settings['absolute_value_max'] ) ) {
				
					$curr  = $settings['absolute_value_curr'];
					$max   = $settings['absolute_value_max'];
					$value = round( ( ( absint( $curr ) * 100 ) / absint( $max ) ), 0 );
				}
				
				$circumference = 2 * M_PI * $radius;
				
				$meter_stroke = ( 'color' === $settings['bg_stroke_type'] ) ? $settings['val_bg_color'] : 'url(#circle-progress-meter-gradient-' . $this->get_id() . ')';
				$value_stroke = ( 'color' === $settings['val_stroke_type'] ) ? $settings['val_stroke_color'] : 'url(#circle-progress-value-gradient-' . $this->get_id() . ')';
				
				// Tablet size data.
				$tablet_size    = is_array( $settings['circle_size_tablet'] ) ? $settings['circle_size_tablet']['size'] : $settings['circle_size_tablet'];
				$tablet_size    = ! empty( $tablet_size ) ? $tablet_size : $size;
				$tablet_viewbox = sprintf( '0 0 %1$s %1$s', $tablet_size );
				$tablet_center  = $tablet_size / 2;
				
				$tablet_val_stroke = is_array( $settings['value_stroke_tablet'] ) ? $settings['value_stroke_tablet']['size'] : $settings['value_stroke_tablet'];
				$tablet_val_stroke = ! empty( $tablet_val_stroke ) ? $tablet_val_stroke : $val_stroke;
				$tablet_bg_stroke  = is_array( $settings['bg_stroke_tablet'] ) ? $settings['bg_stroke_tablet']['size'] : $settings['bg_stroke_tablet'];
				$tablet_bg_stroke  = ! empty( $tablet_bg_stroke ) ? $tablet_bg_stroke : $bg_stroke;
				
				$tablet_max    = ( $tablet_val_stroke >= $tablet_bg_stroke ) ? $tablet_val_stroke : $tablet_bg_stroke;
				$tablet_radius = ( $tablet_size / 2 ) - ( $tablet_max / 2 );
				
				$tablet_circumference = 2 * M_PI * $tablet_radius;
				
				// Mobile size data.
				$mobile_size    = is_array( $settings['circle_size_mobile'] ) ? $settings['circle_size_mobile']['size'] : $settings['circle_size_mobile'];
				$mobile_size    = ! empty( $mobile_size ) ? $mobile_size : $tablet_size;
				$mobile_viewbox = sprintf( '0 0 %1$s %1$s', $mobile_size );
				$mobile_center  = $mobile_size / 2;
				
				$mobile_val_stroke = is_array( $settings['value_stroke_mobile'] ) ? $settings['value_stroke_mobile']['size'] : $settings['value_stroke_mobile'];
				$mobile_val_stroke = ! empty( $mobile_val_stroke ) ? $mobile_val_stroke : $tablet_val_stroke;
				$mobile_bg_stroke  = is_array( $settings['bg_stroke_mobile'] ) ? $settings['bg_stroke_mobile']['size'] : $settings['bg_stroke_mobile'];
				$mobile_bg_stroke  = ! empty( $mobile_bg_stroke ) ? $mobile_bg_stroke : $tablet_bg_stroke;
				
				$mobile_max    = ( $mobile_val_stroke >= $mobile_bg_stroke ) ? $mobile_val_stroke : $mobile_bg_stroke;
				$mobile_radius = ( $mobile_size / 2 ) - ( $mobile_max / 2 );
				
				$mobile_circumference = 2 * M_PI * $mobile_radius;
				
				$gradientanglespacer = '';
				if ( $settings['val_bg_gradient_angle'] == ''){$gradientanglespacer = '0';}
				
				$responsive_sizes = array(
					'desktop' => array(
						'size'          => $size,
						'viewBox'       => $viewbox,
						'center'        => $center,
						'radius'        => $radius,
						'valStroke'     => $val_stroke,
						'bgStroke'      => $bg_stroke,
						'circumference' => $circumference,
					),
					'tablet' => array(
						'size'          => $tablet_size,
						'viewBox'       => $tablet_viewbox,
						'center'        => $tablet_center,
						'radius'        => $tablet_radius,
						'valStroke'     => $tablet_val_stroke,
						'bgStroke'      => $tablet_bg_stroke,
						'circumference' => $tablet_circumference,
					),
					'mobile' => array(
						'size'          => $mobile_size,
						'viewBox'       => $mobile_viewbox,
						'center'        => $mobile_center,
						'radius'        => $mobile_radius,
						'valStroke'     => $mobile_val_stroke,
						'bgStroke'      => $mobile_bg_stroke,
						'circumference' => $mobile_circumference,
					),
				);
				
				?>
				<svg class="circle-progress" width="<?php echo $size; ?>" height="<?php echo $size; ?>" viewBox="<?php echo $viewbox; ?>" data-radius="<?php echo $radius; ?>" data-circumference="<?php echo $circumference; ?>" data-responsive-sizes="<?php echo esc_attr( json_encode( $responsive_sizes ) ); ?>">
					<linearGradient id="circle-progress-meter-gradient-<?php echo $this->get_id(); ?>" gradientUnits="objectBoundingBox" gradientTransform="rotate(<?php echo $settings['val_bg_gradient_angle'].$gradientanglespacer; ?> 0.5 0.5)" x1="-0.25" y1="0.5" x2="1.25" y2="0.5">
						<stop offset="0%" stop-color="<?php echo $settings['val_bg_gradient_color_a']; ?>"/>
						<stop offset="100%" stop-color="<?php echo $settings['val_bg_gradient_color_b']; ?>"/>
					</linearGradient>
					<linearGradient id="circle-progress-value-gradient-<?php echo $this->get_id(); ?>" gradientUnits="objectBoundingBox" gradientTransform="rotate(<?php echo $settings['val_stroke_gradient_angle'].$gradientanglespacer; ?> 0.5 0.5)" x1="-0.25" y1="0.5" x2="1.25" y2="0.5">
						<stop offset="0%" stop-color="<?php echo $settings['val_stroke_gradient_color_a']; ?>"/>
						<stop offset="100%" stop-color="<?php echo $settings['val_stroke_gradient_color_b']; ?>"/>
					</linearGradient>
					<circle
						class="circle-progress__meter"
						cx="<?php echo $center; ?>"
						cy="<?php echo $center; ?>"
						r="<?php echo $radius; ?>"
						stroke="<?php echo $meter_stroke; ?>"
						stroke-width="<?php echo $bg_stroke; ?>"
						fill="none"
					/>
					<circle
						class="circle-progress__value"
						cx="<?php echo $center; ?>"
						cy="<?php echo $center; ?>"
						r="<?php echo $radius; ?>"
						stroke="<?php echo $value_stroke; ?>"
						stroke-width="<?php echo $val_stroke; ?>"
						data-value="<?php echo $value; ?>"
						style="stroke-dasharray: <?php echo $circumference; ?>; stroke-dashoffset: <?php echo $circumference; ?>;"
						fill="none"
					/>
				</svg>
				<?php
				if ( 'in-circle' === $perc_position || 'in-circle' === $labels_position ) {
					echo '<div class="position-in-circle">';
					$this->__processed_item = 'in-circle';
					$perc_position   = $this->get_settings_for_display( 'percent_position' );
					$labels_position = $this->get_settings_for_display( 'labels_position' );
					
					?>
					<div class="circle-counter">
						<?php if ( $perc_position === $this->__processed_item ) { ?>
						<div class="circle-val"><?php
							if ( ! empty( $settings['prefix'] ) ) {
								echo '<span class="circle-counter__prefix">' . $settings['prefix'] . '</span>';
							}
							$value = 0;
							if ( 'percent' === $settings['values_type'] ) {
								$value = $settings['percent_value']['size'];
							} else {
								$value  = $settings['absolute_value_curr'];
							}
							
							$this->add_render_attribute( 'circle-counter', array(
								'class'         => 'circle-counter__number',
								'data-to-value' => $value,
							) );
							
							if ( ! empty( $settings['thousand_separator'] ) ) {
								$this->add_render_attribute( 'circle-counter', 'data-delimiter', ',' );
							}
							?>
							<span <?php echo $this->get_render_attribute_string( 'circle-counter' ); ?>>0</span>
							<?php
							if ( ! empty( $settings['suffix'] ) ) {
								echo '<span class="circle-counter__suffix">' . $settings['suffix'] . '</span>';
							}
						?></div>
						<?php } ?>
						<?php if ( $labels_position === $this->__processed_item ) { ?>
						<div class="circle-counter__content">
							<?php if ( ! empty( $settings['title'] ) ) {
								echo '<div class="circle-counter__title">' . $settings['title'] . '</div>';
							} ?>
							<?php if ( ! empty( $settings['subtitle'] ) ) {
								echo '<div class="circle-counter__subtitle">' . $settings['subtitle'] . '</div>';
							} ?>
						</div>
						<?php } ?>
					</div>
					<?php
					echo '</div>';
				}
			?>
			</div>
			<?php
				if ( 'out-circle' === $perc_position || 'out-circle' === $labels_position ) {
					echo '<div class="position-below-circle">';
					$this->__processed_item = 'out-circle';
					$perc_position   = $this->get_settings_for_display( 'percent_position' );
					$labels_position = $this->get_settings_for_display( 'labels_position' );
					?>
					<div class="circle-counter">
						<?php if ( $perc_position === $this->__processed_item ) { ?>
						<div class="circle-val"><?php
							if ( ! empty( $settings['prefix'] ) ) {
								echo '<span class="circle-counter__prefix">' . $settings['prefix'] . '</span>';
							}
							$value = 0;
							if ( 'percent' === $settings['values_type'] ) {
								$value = $settings['percent_value']['size'];
							} else {
								$value  = $settings['absolute_value_curr'];
							}
							
							$this->add_render_attribute( 'circle-counter', array(
								'class'         => 'circle-counter__number',
								'data-to-value' => $value,
							) );
							
							if ( ! empty( $settings['thousand_separator'] ) ) {
								$this->add_render_attribute( 'circle-counter', 'data-delimiter', ',' );
							}
							if ( ! empty( $settings['suffix'] ) ) {
								echo '<span class="circle-counter__suffix">' . $settings['suffix'] . '</span>';
							}
						?></div>
						<?php } ?>
						<?php if ( $labels_position === $this->__processed_item ) { ?>
						<div class="circle-counter__content">
							<?php if ( ! empty( $settings['title'] ) ) {
								echo '<div class="circle-counter__title">' . $settings['title'] . '</div>';
							} ?>
							<?php if ( ! empty( $settings['subtitle'] ) ) {
								echo '<div class="circle-counter__subtitle">' . $settings['subtitle'] . '</div>';
							} ?>
						</div>
						<?php } ?>
					</div>
					<?php
					echo '</div>';
				}
		
				$this->__processed_item = false;
			?>
		</div>
		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new WPKoi_Elements_Circle_Progress() );