<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPKoi_Unfold_Widget extends Widget_Base {

	public function get_name() {
		return 'wpkoi-unfold';
	}

	public function get_title() {
		return esc_html__( 'Unfold', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-slider-vertical';
	}

	public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'wpkoi-tricks/unfond/css-scheme',
			array(
				'instance'  => '.wpkoi-unfold',
				'inner'     => '.wpkoi-unfold__inner',
				'mask'      => '.wpkoi-unfold__mask',
				'separator' => '.wpkoi-unfold__separator',
				'content'   => '.wpkoi-unfold__content',
				'button'    => '.wpkoi-unfold__button',
			)
		);

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'editor',
			array(
				'label'   => esc_html__( 'Content', 'wpkoi-elements' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => array(
					'active' => true,
				),
				'default'  => esc_html__( 'Id neque aliquam vestibulum morbi blandit cursus risus at ultrices. Massa ultricies mi quis hendrerit dolor magna eget. Condimentum id venenatis a condimentum vitae sapien pellentesque. Aenean sed adipiscing diam donec adipiscing tristique risus nec. Sit amet venenatis urna cursus eget nunc. Tincidunt id aliquet risus feugiat in ante metus. Mauris augue neque gravida in fermentum et sollicitudin ac. In egestas erat imperdiet sed. Volutpat est velit egestas dui id ornare. Faucibus in ornare quam viverra orci sagittis eu volutpat odio. Imperdiet proin fermentum leo vel orci porta non pulvinar neque. Vulputate sapien nec sagittis aliquam malesuada. Odio facilisis mauris sit amet massa. Sem integer vitae justo eget magna fermentum. Purus non enim praesent elementum. Odio ut enim blandit volutpat maecenas.', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'fold',
			array(
				'label'        => esc_html__( 'Fold', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
				'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'mask_height',
			array(
				'label'      => esc_html__( 'Closed Height', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 1000,
					),
				),
				'default' => array(
					'size' => 50,
					'unit' => 'px',
				),
				'render_type' => 'template',
			)
		);

		$this->start_controls_tabs( 'tabs_settings' );

		$this->start_controls_tab(
			'tab_unfold_settings',
			array(
				'label' => esc_html__( 'Unfold', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'unfold_duration',
			array(
				'label'      => esc_html__( 'Duration', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'ms' ),
				'range'      => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 3000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 500,
					'unit' => 'ms',
				),
			)
		);

		$this->add_control(
			'unfold_easing',
			array(
				'label'       => esc_html__( 'Easing', 'wpkoi-elements' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'easeOutBack',
				'options' => array(
					'linear'        => esc_html__( 'Linear', 'wpkoi-elements' ),
					'easeOutSine'   => esc_html__( 'Sine', 'wpkoi-elements' ),
					'easeOutExpo'   => esc_html__( 'Expo', 'wpkoi-elements' ),
					'easeOutCirc'   => esc_html__( 'Circ', 'wpkoi-elements' ),
					'easeOutBack'   => esc_html__( 'Back', 'wpkoi-elements' ),
					'easeInOutSine' => esc_html__( 'InOutSine', 'wpkoi-elements' ),
					'easeInOutExpo' => esc_html__( 'InOutExpo', 'wpkoi-elements' ),
					'easeInOutCirc' => esc_html__( 'InOutCirc', 'wpkoi-elements' ),
					'easeInOutBack' => esc_html__( 'InOutBack', 'wpkoi-elements' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_fold_settings',
			array(
				'label' => esc_html__( 'Fold', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'fold_duration',
			array(
				'label'      => esc_html__( 'Duration', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'ms' ),
				'range'      => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 3000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 300,
					'unit' => 'ms',
				),
			)
		);

		$this->add_control(
			'fold_easing',
			array(
				'label'       => esc_html__( 'Easing', 'wpkoi-elements' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'easeOutSine',
				'options' => array(
					'linear'        => esc_html__( 'Linear', 'wpkoi-elements' ),
					'easeOutSine'   => esc_html__( 'Sine', 'wpkoi-elements' ),
					'easeOutExpo'   => esc_html__( 'Expo', 'wpkoi-elements' ),
					'easeOutCirc'   => esc_html__( 'Circ', 'wpkoi-elements' ),
					'easeOutBack'   => esc_html__( 'Back', 'wpkoi-elements' ),
					'easeInOutSine' => esc_html__( 'InOutSine', 'wpkoi-elements' ),
					'easeInOutExpo' => esc_html__( 'InOutExpo', 'wpkoi-elements' ),
					'easeInOutCirc' => esc_html__( 'InOutCirc', 'wpkoi-elements' ),
					'easeInOutBack' => esc_html__( 'InOutBack', 'wpkoi-elements' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->start_controls_tabs( 'tabs_button' );

		$this->start_controls_tab(
			'tab_fold_button',
			array(
				'label' => esc_html__( 'Fold', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'button_fold_text',
			array(
				'label'   => esc_html__( 'Fold Button Text', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hide', 'wpkoi-elements' ),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_unfold_button',
			array(
				'label' => esc_html__( 'Unfold', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'button_unfold_text',
			array(
				'label'   => esc_html__( 'Unfold Button Text', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Show', 'wpkoi-elements' ),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Container Style Section
		 */
		$this->start_controls_section(
			'section_container_style',
			array(
				'label'      => esc_html__( 'Container', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_container_style' );

		$this->start_controls_tab(
			'tab_fold_container',
			array(
				'label' => esc_html__( 'Fold', 'wpkoi-elements' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_fold_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_fold_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_fold_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_unfold_container',
			array(
				'label' => esc_html__( 'UnFold', 'wpkoi-elements' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_unfold_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'] . '.wpkoi-unfold-state',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_unfold_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'] . '.wpkoi-unfold-state',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_unfold_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'] . '.wpkoi-unfold-state',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'      => __( 'Margin', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Separator Style Section
		 */
		$this->start_controls_section(
			'section_separator_style',
			array(
				'label'      => esc_html__( 'Separator', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'separator_height',
			array(
				'label'      => esc_html__( 'Height', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['separator'] => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'separator_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['separator'],
			)
		);

		$this->end_controls_section();

		/**
		 * Content Style Section
		 */
		$this->start_controls_section(
			'section_content_style',
			array(
				'label'      => esc_html__( 'Content', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_content_style' );

		$this->start_controls_tab(
			'tab_fold_content',
			array(
				'label' => esc_html__( 'Fold', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'fold_content_color',
			array(
				'label'  => esc_html__( 'Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fold_content_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['content'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_unfold_content',
			array(
				'label' => esc_html__( 'Unfold', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'unfold_content_color',
			array(
				'label'  => esc_html__( 'Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wpkoi-unfold-state ' . $css_scheme['content'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'unfold_content_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wpkoi-unfold-state ' . $css_scheme['content'],
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		/**
		 * Button Style Section
		 */
		$this->start_controls_section(
			'section_button_style',
			array(
				'label'      => esc_html__( 'Button', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'wpkoi-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'wpkoi-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'wpkoi-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => __( 'Margin', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_margin',
			array(
				'label'      => __( 'Margin', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * [render description]
	 * @return [type] [description]
	 */
	protected function render() {

		$settings = $this->get_settings();

		$json_settings = array(
			'height'          => $settings['mask_height'],
			'separatorHeight' => $settings['separator_height'],
			'unfoldDuration'  => $settings['unfold_duration'],
			'foldDuration'    => $settings['fold_duration'],
			'unfoldEasing'    => $settings['unfold_easing'],
			'foldEasing'      => $settings['fold_easing'],
		);

		$this->add_render_attribute( 'instance', array(
			'class' => array(
				'wpkoi-unfold',
				filter_var( $settings['fold'], FILTER_VALIDATE_BOOLEAN ) ? 'wpkoi-unfold-state' : '',
			),
			'data-settings' => json_encode( $json_settings ),
		) );

		$this->add_render_attribute( 'button', array(
			'class' => array(
				'wpkoi-unfold__button',
				'elementor-button',
				'elementor-size-md',
			),
			'data-unfold-text' => $settings['button_unfold_text'],
			'data-fold-text'   => $settings['button_fold_text'],
		) );

		$editor_content = $this->get_settings_for_display( 'editor' );

		$editor_content = $this->parse_text_editor( $editor_content );

		$this->add_render_attribute( 'editor', 'class', array( 'elementor-text-editor', 'elementor-clearfix' ) );

		$this->add_inline_editing_attributes( 'editor', 'advanced' );		

		$button_text_html = '';

		if ( ! empty( $settings['button_unfold_text'] ) && ! empty( $settings['button_fold_text'] ) ) {
			$button_text = ! filter_var( $settings['fold'], FILTER_VALIDATE_BOOLEAN ) ? $settings['button_unfold_text'] : $settings['button_fold_text'];

			$button_text_html = sprintf( '<span class="wpkoi-unfold__button-text">%1$s</span>', $button_text );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'instance' ); ?>>
			<div class="wpkoi-unfold__inner">
				<div class="wpkoi-unfold__mask">
					<div class="wpkoi-unfold__content">
						<div <?php echo $this->get_render_attribute_string( 'editor' ); ?>><?php echo $editor_content; ?></div>
					</div>
					<div class="wpkoi-unfold__separator"></div>
				</div>
				<div class="wpkoi-unfold__trigger"><?php
					echo sprintf( '<div %1$s>%2$s</div>',
						$this->get_render_attribute_string( 'button' ),
						$button_text_html
					);?>
				</div>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new WPKoi_Unfold_Widget() );