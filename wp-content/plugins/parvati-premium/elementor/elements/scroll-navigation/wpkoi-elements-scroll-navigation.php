<?php
/**
 * Class: WPKoi_Elements_Scroll_Navigation
 * Name: Scroll Navigation
 * Slug: wpkoi-scroll-navigation
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPKoi_Elements_Scroll_Navigation extends Widget_Base {

	public function get_name() {
		return 'wpkoi-scroll-navigation';
	}

	public function get_title() {
		return esc_html__( 'Scroll Navigation', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-navigation-vertical';
	}

	public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'wpkoi-elements/scroll-navigation/css-scheme',
			array(
				'instance' => '.wpkoi-scroll-navigation',
				'item'     => '.wpkoi-scroll-navigation__item',
				'hint'     => '.wpkoi-scroll-navigation__item-hint',
				'icon'     => '.wpkoi-scroll-navigation__icon',
				'label'    => '.wpkoi-scroll-navigation__label',
				'dots'     => '.wpkoi-scroll-navigation__dot',
			)
		);

		$this->start_controls_section(
			'section_items_data',
			array(
				'label' => esc_html__( 'Sections', 'wpkoi-elements' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_icon_new',
			[
				'label' => esc_html__( 'Hint Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'item_icon'
			]
		);

		$repeater->add_control(
			'item_dot_icon_new',
			[
				'label' => esc_html__( 'Dot Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'item_dot_icon'
			]
		);

		$repeater->add_control(
			'item_label',
			array(
				'label'   => esc_html__( 'Label', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
			)
		);

		$repeater->add_control(
			'item_section_id',
			array(
				'label'   => esc_html__( 'Section Id', 'wpkoi-elements' ),
				'type'    => Controls_Manager::TEXT,
			)
		);

		$repeater->add_control(
			'item_section_invert',
			array(
				'label'        => esc_html__( 'Invert Under This Section', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
				'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'item_list',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_label'      => esc_html__( 'Section 1', 'wpkoi-elements' ),
						'item_section_id' => 'section_1',
					),
					array(
						'item_label'      => esc_html__( 'Section 2', 'wpkoi-elements' ),
						'item_section_id' => 'section_2',
					),
					array(
						'item_label'      => esc_html__( 'Section 3', 'wpkoi-elements' ),
						'item_section_id' => 'section_3',
					),
				),
				'title_field' => '{{{ item_label }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'wpkoi-elements' ),
			)
		);

		$this->add_control(
			'position',
			array(
				'label'   => esc_html__( 'Position', 'wpkoi-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'left'  => esc_html__( 'Left', 'wpkoi-elements' ),
					'right' => esc_html__( 'Right', 'wpkoi-elements' ),
				),
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Scroll Speed', 'wpkoi-elements' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			)
		);

		$this->add_control(
			'offset',
			array(
				'label'   => esc_html__( 'Scroll Offset', 'wpkoi-elements' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
			)
		);

		$this->add_control(
			'full_section_switch',
			array(
				'label'        => esc_html__( 'Full Section Switch', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wpkoi-elements' ),
				'label_off'    => esc_html__( 'No', 'wpkoi-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_general_style',
			array(
				'label'      => esc_html__( 'General', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'instance_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'instance_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->add_responsive_control(
			'instance_border_radius',
			array(
				'label'      => __( 'Border Radius', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'instance_padding',
			array(
				'label'      => __( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'instance_margin',
			array(
				'label'      => __( 'Margin', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'instance_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->end_controls_section();

		/**
		 * Hint Style Section
		 */
		$this->start_controls_section(
			'section_hint_style',
			array(
				'label'      => esc_html__( 'Hint', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'hint_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['hint'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'hint_border',
				'label'       => esc_html__( 'Border', 'wpkoi-elements' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['hint'],
			)
		);

		$this->add_responsive_control(
			'hint_border_radius',
			array(
				'label'      => __( 'Border Radius', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['hint'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'hint_padding',
			array(
				'label'      => __( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['hint'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'hint_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['hint'],
			)
		);

		$this->add_control(
			'hint_icon_style',
			array(
				'label'     => esc_html__( 'Hint Icon', 'wpkoi-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'hint_icon_color',
			array(
				'label'  => esc_html__( 'Icon Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'hint_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'wpkoi-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'hint_icon_margin',
			array(
				'label'      => __( 'Margin', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'hint_label_style',
			array(
				'label'     => esc_html__( 'Hint Label', 'wpkoi-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'hint_label_color',
			array(
				'label'  => esc_html__( 'Text Color', 'wpkoi-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'hint_label_margin',
			array(
				'label'      => __( 'Margin', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['label'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'hint_label_padding',
			array(
				'label'      => __( 'Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['label'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'hint_label_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
			)
		);

		$this->add_control(
			'hint_visible',
			array(
				'label'     => esc_html__( 'Hint Visible', 'wpkoi-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'desktop_hint_hide',
			array(
				'label'        => esc_html__( 'Hide On Desktop', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Hide', 'wpkoi-elements' ),
				'label_off'    => esc_html__( 'Show', 'wpkoi-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'tablet_hint_hide',
			array(
				'label'        => esc_html__( 'Hide On Tablet', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Hide', 'wpkoi-elements' ),
				'label_off'    => esc_html__( 'Show', 'wpkoi-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'mobile_hint_hide',
			array(
				'label'        => esc_html__( 'Hide On Mobile', 'wpkoi-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Hide', 'wpkoi-elements' ),
				'label_off'    => esc_html__( 'Show', 'wpkoi-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->end_controls_section();

		/**
		 * Dots Style Section
		 */
		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'      => esc_html__( 'Dots', 'wpkoi-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'tab_dots_normal',
			array(
				'label' => esc_html__( 'Normal', 'wpkoi-elements' ),
			)
		);

		$this->add_group_control(
			\WPKoi_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style',
				'label'          => esc_html__( 'Dots Style', 'wpkoi-elements' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['dots'],
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_invert',
			array(
				'label' => esc_html__( 'Invert', 'wpkoi-elements' ),
			)
		);

		$this->add_group_control(
			\WPKoi_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_invert',
				'label'          => esc_html__( 'Dots Style', 'wpkoi-elements' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['item'] . '.invert ' . $css_scheme['dots'],
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			array(
				'label' => esc_html__( 'Hover', 'wpkoi-elements' ),
			)
		);

		$this->add_group_control(
			\WPKoi_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_hover',
				'label'          => esc_html__( 'Dots Style', 'wpkoi-elements' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['dots'],
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			array(
				'label' => esc_html__( 'Active', 'wpkoi-elements' ),
			)
		);

		$this->add_group_control(
			\WPKoi_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_active',
				'label'          => esc_html__( 'Dots Style', 'wpkoi-elements' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['item'] . '.active ' . $css_scheme['dots'],
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'dots_padding',
			array(
				'label'      => __( 'Dots Padding', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['dots'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'item_margin',
			array(
				'label'      => __( 'Dots Margin', 'wpkoi-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$data_settings = $this->generate_setting_json();
		$position = $settings['position'];
		
		$classes_list[] = 'wpkoi-scroll-navigation';
		$classes_list[] = 'wpkoi-scroll-navigation--position-' . $position;
		$classes = implode( ' ', $classes_list );
		?>
		
		<div class="<?php echo $classes; ?>" <?php echo $data_settings; ?>>
        	<div class="wpkoi-scroll-navigation__inner">
				<?php foreach( $settings['item_list'] as $scrollsection ) :
				$hint_classes_array = array( 'wpkoi-scroll-navigation__item-hint' );
                if ( filter_var( $settings['desktop_hint_hide'], FILTER_VALIDATE_BOOLEAN ) ) {
                    $hint_classes_array[] = 'elementor-hidden-desktop';
                }
                
                if ( filter_var( $settings['tablet_hint_hide'], FILTER_VALIDATE_BOOLEAN ) ) {
                    $hint_classes_array[] = 'elementor-hidden-tablet';
                }
                
                if ( filter_var( $settings['mobile_hint_hide'], FILTER_VALIDATE_BOOLEAN ) ) {
                    $hint_classes_array[] = 'elementor-hidden-phone';
                }
                
                $hint_classes = implode( ' ', $hint_classes_array );
                
                $section_id_attr = $scrollsection['item_section_id'];
                $section_invert = $scrollsection['item_section_invert'];
                				
				$migrated_item_icon = isset( $scrollsection['__fa4_migrated']['item_icon_new'] );
				$is_new_item_icon = empty( $scrollsection['item_icon'] );
				$migrated_item_dot_icon = isset( $scrollsection['__fa4_migrated']['item_dot_icon_new'] );
				$is_new_item_dot_icon = empty( $scrollsection['item_dot_icon'] );
				
                ?>
                <div class="wpkoi-scroll-navigation__item" data-anchor="<?php echo $section_id_attr; ?>" data-invert="<?php echo $section_invert; ?>">
                    <div class="wpkoi-scroll-navigation__dot">
                    <?php if ( $is_new_item_dot_icon || $migrated_item_dot_icon ) :
						Icons_Manager::render_icon( $scrollsection['item_dot_icon_new'], [ 'aria-hidden' => 'true' ] );
						else : ?><i class="<?php echo $scrollsection['item_dot_icon']; ?>" aria-hidden="true"></i> <?php endif; ?>
                    </div>
                    <div class="<?php echo $hint_classes; ?>"><?php 
						echo '<span class="wpkoi-scroll-navigation__icon">';
						if ( $is_new_item_icon || $migrated_item_icon ) :
						Icons_Manager::render_icon( $scrollsection['item_icon_new'], [ 'aria-hidden' => 'true' ] );
						else : ?><i class="<?php echo $scrollsection['item_icon']; ?>" aria-hidden="true"></i> <?php endif;
						echo '</span>';
                        echo '<span class="wpkoi-scroll-navigation__label">' . $scrollsection['item_label'] . '</span>'; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
		</div>
		<?php
	}

	/**
	 * Generate setting json
	 *
	 * @return string
	 */
	public function generate_setting_json() {
		$settings = $this->get_settings();

		$instance_settings = array(
			'position'      => $settings['position'],
			'speed'         => absint( $settings['speed'] ),
			'offset'        => absint( $settings['offset'] ),
			'sectionSwitch' => filter_var( $settings['full_section_switch'], FILTER_VALIDATE_BOOLEAN ),
		);

		$instance_settings = json_encode( $instance_settings );

		return sprintf( 'data-settings=\'%1$s\'', $instance_settings );
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new WPKoi_Elements_Scroll_Navigation() );