<?php
/**
 * Class: WPKoi_View_More_Widget
 * Name: WPKoi_View_More
 * Slug: wpkoi-view-more
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPKoi_View_More_Widget extends Widget_Base {

	public function get_name() {
		return 'wpkoi-view-more';
	}

	public function get_title() {
		return esc_html__( 'View More', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'wpkoi-tricks/view-more/css-scheme',
			array(
				'instance' => '.wpkoi-view-more',
				'button'   => '.wpkoi-view-more__button',
				'icon'     => '.wpkoi-view-more__icon',
				'label'    => '.wpkoi-view-more__label',
			)
		);

		$this->start_controls_section(
			'section_items_data',
			array(
				'label' => esc_html__( 'Settings', 'wpkoi-elements' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'section_id',
			array(
				'label'   => esc_html__( 'Section Id', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'section_1',
			)
		);

		$this->add_control(
			'sections',
			array(
				'label'   => esc_html__( 'Sections', 'wpkoi-elements' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'section_id' => 'section_1'
					)
				),
				'title_field' => '{{{ section_id }}}',
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'button_label',
			array(
				'label'   => esc_html__( 'Label', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'View More', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'show_all',
			array(
				'label'        => esc_html__( 'Show All Sections', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
				'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'show_effect',
			array(
				'label'       => esc_html__( 'Show Effect', 'wpkoi-elements' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'move-up',
				'options' => array(
					'none'             => esc_html__( 'None', 'wpkoi-elements' ),
					'fade'             => esc_html__( 'Fade', 'wpkoi-elements' ),
					'zoom-in'          => esc_html__( 'Zoom In', 'wpkoi-elements' ),
					'zoom-out'         => esc_html__( 'Zoom Out', 'wpkoi-elements' ),
					'move-up'          => esc_html__( 'Move Up', 'wpkoi-elements' ),
					'fall-perspective' => esc_html__( 'Fall Perspective', 'wpkoi-elements' ),
				),
				'render_type' => 'template',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_general_style',
			array(
				'label'      => esc_html__( 'General', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => __( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
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

		$this->start_controls_tabs( 'button_styles' );

		$this->start_controls_tab(
			'button_normal',
			array(
				'label' => esc_html__( 'Normal', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'button_label_color',
			array(
				'label'  => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ' ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_label_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '. $css_scheme['button'] . ' ' . $css_scheme['label'],
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['button'],
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
			'button_hover',
			array(
				'label' => esc_html__( 'Hover', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'buttonlabel_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_label_typography_hover',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['label'],
			)
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_background_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border_hover',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow_hover',
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

		$this->__context = 'render';

		$button_settings = $this->get_settings();

		$sections = $button_settings[ 'sections' ];

		foreach ( $sections as $key => $section ) {
			$sections_list[ $section['_id'] ] = $section['section_id'];
		}

		$settings = array(
			'effect'   => $button_settings['show_effect'],
			'sections' => $sections_list,
			'showall'  => filter_var( $button_settings['show_all'], FILTER_VALIDATE_BOOLEAN ),
		);

		$this->add_render_attribute( 'instance', array(
			'class' => array(
				'wpkoi-view-more',
			),
			'data-settings' => json_encode( $settings ),
		) );


		$button_label_html = '';

		if ( ! empty( $button_settings['button_label'] ) ) {
			$button_label_html = sprintf( '<div class="wpkoi-view-more__label">%1$s</div>', $button_settings['button_label'] );
		}

		echo sprintf(
			'<div %1$s><div class="wpkoi-view-more__button">%2$s</div></div>',
			$this->get_render_attribute_string( 'instance' ),
			$button_label_html
		);
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new WPKoi_View_More_Widget() );