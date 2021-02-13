<?php
/**
 * Class: WPKoi_Hotspots_Widget
 * Name: WPKoi_Tricks
 * Slug: wpkoi-tricks
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPKoi_Hotspots_Widget extends Widget_Base {

	public function get_name() {
		return 'wpkoi-hotspots';
	}

	public function get_title() {
		return esc_html__( 'Hotspots', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-post';
	}

	public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	public function get_script_depends() {
		return array( 'imagesloaded', 'wpkoi-tricks-tippy' );
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'wpkoi-tricks/hotspots/css-scheme',
			array(
				'instance'   => '.wpkoi-hotspots',
				'inner'      => '.wpkoi-hotspots__inner',
				'item'       => '.wpkoi-hotspots__item',
				'item_inner' => '.wpkoi-hotspots__item-inner',
				'tooltip'    => '.tippy-tooltip',
			)
		);

		$this->start_controls_section(
			'section_image',
			array(
				'label' => esc_html__( 'Hotspots', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'wpkoi-elements' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_hotspot' );

		$repeater->start_controls_tab(
			'tabs_hotspot_content',
			array(
				'label' => esc_html__( 'Content', 'wpkoi-elements' ),
			)
		);
		
		$repeater->add_control(
			'hotspot_icon_new',
			array(
				'label' => esc_html__( 'Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'hotspot_icon',
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				]
			)
		);

		$repeater->add_control(
			'hotspot_text',
			array(
				'label'   => esc_html__( 'Text', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
			)
		);

		$repeater->add_control(
			'hotspot_description',
			array(
				'label' => esc_html__( 'Description', 'wpkoi-elements' ),
				'type'  => Controls_Manager::TEXTAREA,
			)
		);

		$repeater->add_control(
			'hotspot_url',
			array(
				'label'       => esc_html__( 'Link', 'wpkoi-elements' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => array(
					'url' => '',
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tabs_hotspot_position',
			array(
				'label' => esc_html__( 'Position', 'wpkoi-elements' ),
			)
		);

		$repeater->add_control(
			'horizontal_position',
			array(
				'label' => esc_html__( 'Horizontal Position(%)', 'wpkoi-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array(
					'%',
				),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
			)
		);

		$repeater->add_control(
			'vertical_position',
			array(
				'label' => esc_html__( 'Vertical Position(%)', 'wpkoi-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array(
					'%',
				),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'hotspots',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ hotspot_text }}}',
				'default'     => array(
					array(
						'hotspot_text'        => '',
						'horizontal_position' => array(
							'size' => 50,
							'unit' => '%',
						),
						'vertical_position'   => array(
							'size' => 50,
							'unit' => '%',
						),
					)
				),
			)
		);

		$this->add_control(
			'hotspots_animation',
			array(
				'label'   => esc_html__( 'Animation', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'pulse',
				'options' => array(
					'none'   => esc_html__( 'None', 'wpkoi-elements' ),
					'flash'  => esc_html__( 'Flash', 'wpkoi-elements' ),
					'pulse'  => esc_html__( 'Pulse', 'wpkoi-elements' ),
					'shake'  => esc_html__( 'Shake', 'wpkoi-elements' ),
					'tada'   => esc_html__( 'Tada', 'wpkoi-elements' ),
					'rubber' => esc_html__( 'Rubber', 'wpkoi-elements' ),
					'swing'  => esc_html__( 'Swing', 'wpkoi-elements' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tooltip',
			array(
				'label' => esc_html__( 'Tooltip', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'tooltip_placement',
			array(
				'label'   => esc_html__( 'Placement', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'wpkoi-elements' ),
					'bottom' => esc_html__( 'Bottom', 'wpkoi-elements' ),
					'left'   => esc_html__( 'Left', 'wpkoi-elements' ),
					'right'  => esc_html__( 'Right', 'wpkoi-elements' ),
				),
			)
		);

		$this->add_control(
			'tooltip_arrow',
			array(
				'label'        => esc_html__( 'Use Arrow', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
				'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'tooltip_arrow_type',
			array(
				'label'   => esc_html__( 'Arrow Type', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sharp',
				'options' => array(
					'sharp' => esc_html__( 'Sharp', 'wpkoi-elements' ),
					'round' => esc_html__( 'Round', 'wpkoi-elements' ),
				),
				'condition' => array(
					'tooltip_arrow' => 'yes',
				),
			)
		);

		$this->add_control(
			'tooltip_arrow_size',
			array(
				'label'   => esc_html__( 'Arrow Size', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'scale(1)',
				'options' => array(
					'scale(1)'     => esc_html__( 'Normal', 'wpkoi-elements' ),
					'scale(0.75)'  => esc_html__( 'Small', 'wpkoi-elements' ),
					'scaleX(0.75)' => esc_html__( 'Skinny', 'wpkoi-elements' ),
					'scale(1.5)'   => esc_html__( 'Large', 'wpkoi-elements' ),
					'scaleX(1.5)'  => esc_html__( 'Wide', 'wpkoi-elements' ),
				),
				'condition' => array(
					'tooltip_arrow' => 'yes',
				),
			)
		);

		$this->add_control(
			'tooltip_trigger',
			array(
				'label'   => esc_html__( 'Trigger', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'mouseenter',
				'options' => array(
					'mouseenter' => esc_html__( 'Mouseenter', 'wpkoi-elements' ),
					'click'      => esc_html__( 'Click', 'wpkoi-elements' ),
					'manual'     => esc_html__( 'None', 'wpkoi-elements' ),
				),
			)
		);

		$this->add_control(
			'tooltip_trigger_none_desc',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => esc_html__( 'Always show tooltips.', 'wpkoi-elements' ),
				'content_classes' => 'elementor-descriptor',
				'condition' => array(
					'tooltip_trigger' => 'manual',
				),
			)
		);

		$this->add_control(
			'tooltip_show_duration',
			array(
				'label'      => esc_html__( 'Show Duration', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'ms',
				),
				'range'      => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 1000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 500,
					'unit' => 'ms',
				),
				'condition' => array(
					'tooltip_trigger!' => 'manual',
				),
			)
		);

		$this->add_control(
			'tooltip_hide_duration',
			array(
				'label'      => esc_html__( 'Hide Duration', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'ms',
				),
				'range'      => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 1000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 300,
					'unit' => 'ms',
				),
				'condition' => array(
					'tooltip_trigger!' => 'manual',
				),
			)
		);

		$this->add_control(
			'tooltip_delay',
			array(
				'label'      => esc_html__( 'Delay', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'ms',
				),
				'range'      => array(
					'ms' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 0,
					'unit' => 'ms',
				),
				'condition' => array(
					'tooltip_trigger!' => 'manual',
				),
			)
		);

		$this->add_control(
			'tooltip_distance',
			array(
				'label'      => esc_html__( 'Distance', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default' => array(
					'size' => 15,
					'unit' => 'px',
				),
			)
		);

		$this->add_control(
			'tooltip_animation',
			array(
				'label'   => esc_html__( 'Animation', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shift-toward',
				'options' => array(
					'shift-away'   => esc_html__( 'Shift-Away', 'wpkoi-elements' ),
					'shift-toward' => esc_html__( 'Shift-Toward', 'wpkoi-elements' ),
					'fade'         => esc_html__( 'Fade', 'wpkoi-elements' ),
					'scale'        => esc_html__( 'Scale', 'wpkoi-elements' ),
					'perspective'  => esc_html__( 'Perspective', 'wpkoi-elements' ),
				),
				'condition' => array(
					'tooltip_trigger!' => 'manual',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Hotspots Style Section
		 */
		$this->start_controls_section(
			'section_hotspot_style',
			array(
				'label'      => esc_html__( 'Hotspot', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'hotspot_padding',
			array(
				'label'      => __( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'hotspot_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['item_inner'],
			)
		);

		$this->add_responsive_control(
			'hotspot_border_radius',
			array(
				'label'      => __( 'Border Radius', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'hotspot_box_shadow',
				'exclude' => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['item_inner'],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'hotspot_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['item_inner'] . ' span',
			)
		);

		$this->start_controls_tabs( 'tabs_hotspot' );

		$this->start_controls_tab(
			'tabs_hotspot_normal_style',
			array(
				'label' => esc_html__( 'Normal', 'wpkoi-elements' ),
			)
		);

		$this->add_responsive_control(
			'hotspot_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em',
				),
				'range'      => array(
					'px' => array(
						'min' => 8,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_inner'] . ' i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'hotspot_icon_color',
			array(
				'label'  => esc_html__( 'Icon Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_inner'] . ' i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'hotspot_text_color',
			array(
				'label'  => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_inner'] . ' span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'hotspot_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_inner'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_hotspot_hover_style',
			array(
				'label' => esc_html__( 'Hover', 'wpkoi-elements' ),
			)
		);

		$this->add_responsive_control(
			'hotspot_icon_size_hover',
			array(
				'label'      => esc_html__( 'Icon Size', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em',
				),
				'range'      => array(
					'px' => array(
						'min' => 8,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_inner'] . ' i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'hotspot_icon_color_hover',
			array(
				'label'  => esc_html__( 'Icon Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_inner'] . ' i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'hotspot_text_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_inner'] . ' span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'hotspot_background_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_inner'],
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Tooltips Style Section
		 */
		$this->start_controls_section(
			'section_tooltips_style',
			array(
				'label'      => esc_html__( 'Tooltip', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'tooltip_width',
			array(
				'label'      => esc_html__( 'Width', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em',
				),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tooltip_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'] . ' .tippy-content',
			)
		);

		$this->add_control(
			'tooltip_text_align',
			array(
				'label'   => esc_html__( 'Text Alignment', 'wpkoi-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'wpkoi-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'wpkoi-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'] . ' .tippy-content' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tooltip_color',
			array(
				'label'  => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'tooltip_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'],
			)
		);

		$this->add_control(
			'tooltip_arrow_color',
			array(
				'label'  => esc_html__( 'Arrow Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' .tippy-popper[x-placement^=left] ' . $css_scheme['tooltip'] .' .tippy-arrow'=> 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' .tippy-popper[x-placement^=right] ' . $css_scheme['tooltip'] .' .tippy-arrow'=> 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' .tippy-popper[x-placement^=top] ' . $css_scheme['tooltip'] .' .tippy-arrow'=> 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' .tippy-popper[x-placement^=bottom] ' . $css_scheme['tooltip'] .' .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'tooltip_padding',
			array(
				'label'      => __( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'tooltip_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'],
			)
		);

		$this->add_responsive_control(
			'tooltip_border_radius',
			array(
				'label'      => __( 'Border Radius', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'tooltip_box_shadow',
				'exclude' => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'] . ' ' . $css_scheme['tooltip'],
			)
		);

		$this->end_controls_section();

	}

	/**
	 * [render description]
	 * @return [type] [description]
	 */
	protected function render() {

		$id_int = substr( $this->get_id_int(), 0, 3 );

		$settings = $this->get_settings();

		$hotspots = $settings['hotspots'];

		$json_settings = array(
			'tooltipPlacement'     => $settings['tooltip_placement'],
			'tooltipArrow'        => filter_var( $settings['tooltip_arrow'], FILTER_VALIDATE_BOOLEAN ),
			'tooltipArrowType'    => $settings['tooltip_arrow_type'],
			'tooltipArrowSize'    => $settings['tooltip_arrow_size'],
			'tooltipTrigger'      => $settings['tooltip_trigger'],
			'tooltipShowDuration' => $settings['tooltip_show_duration'],
			'tooltipHideDuration' => $settings['tooltip_hide_duration'],
			'tooltipDelay'        => $settings['tooltip_delay'],
			'tooltipDistance'     => $settings['tooltip_distance'],
			'tooltipAnimation'    => $settings['tooltip_animation'],
		);

		$this->add_render_attribute( 'instance', array(
			'class' => array(
				'wpkoi-hotspots',
				'wpkoi-hotspots__hotspots-' . $settings['hotspots_animation'] . '-animation',
			),
			'data-settings' => json_encode( $json_settings ),
		) );

		if ( empty( $settings['image']['id'] ) ) {
			echo sprintf( '<h3>%s</h3>', esc_html__( 'Image not defined', 'wpkoi-elements' ) );

			return false;
		}

		$image = sprintf( '<img class="wpkoi-hotspots__image" src="%s" srcset="%s" alt="">',
			wp_get_attachment_image_url( $settings['image']['id'] ),
			wp_get_attachment_image_srcset( $settings['image']['id'], 'full' )
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'instance' ); ?>>
			<div class="wpkoi-hotspots__inner"><?php
				echo $image;?>
				<div class="wpkoi-hotspots__container"><?php
					foreach ( $hotspots as $index => $hotspot ) {
						$hotspot_count = $index + 1;

						$is_link = ! empty( $hotspot['hotspot_url']['url'] ) ? true : false;

						$hotspot_setting_key = $this->get_repeater_setting_key( 'wpkoi_hotspot_control', 'hotspots', $index );

						$this->add_render_attribute( $hotspot_setting_key, array(
							'id'                       => 'wpkoi-hotspot-' . $id_int . $hotspot_count,
							'class'                    => array(
								'wpkoi-hotspots__item',
							),
							'title'                    => $hotspot['hotspot_description'],
							'data-horizontal-position' => $hotspot['horizontal_position']['size'],
							'data-vertical-position'   => $hotspot['vertical_position']['size'],
						) );

						if ( $is_link ) {
							$this->add_render_attribute( $hotspot_setting_key, array(
								'href' => $hotspot['hotspot_url']['url'],
							) );

							if ( $hotspot['hotspot_url']['is_external'] ) {
								$this->add_render_attribute( $hotspot_setting_key, 'target', '_blank' );
							}

							if ( ! empty( $hotspot['hotspot_url']['nofollow'] ) ) {
								$this->add_render_attribute( $hotspot_setting_key, 'rel', 'nofollow' );
							}
						}

						$icon_html = '';

						$text_html = '';

						if ( ! empty( $hotspot['hotspot_text'] ) ) {
							$text_html = sprintf( '<span>%1$s</span>', $hotspot['hotspot_text'] );
						}

						$tag = ! $is_link ? 'div' : 'a';

						echo sprintf( '<%1$s %2$s><div class="wpkoi-hotspots__item-inner">', $tag, $this->get_render_attribute_string( $hotspot_setting_key ) );
						
						if ( ! empty( $hotspot['hotspot_icon_new'] ) ) {
								$migrated = isset( $hotspot['__fa4_migrated']['hotspot_icon_new'] );
								$is_new = empty( $hotspot['hotspot_icon'] );
								if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $hotspot['hotspot_icon_new'], [ 'aria-hidden' => 'true' ] );
								else : echo '<i class="' . $hotspot['hotspot_icon'] . '" aria-hidden="true"></i>'; endif;
						}
						
						echo sprintf( '%1$s</div></%2$s>', $text_html, $tag );
					}?>
				</div>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new WPKoi_Hotspots_Widget() );