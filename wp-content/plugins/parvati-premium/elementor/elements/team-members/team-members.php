<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_WPKoi_Elements_Team_Member extends Widget_Base {

	public function get_name() {
		return 'wpkoi-elements-team-member';
	}

	public function get_title() {
		return esc_html__( 'Team Member', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}
	
	
	protected function register_controls() {

		
  		$this->start_controls_section(
  			'wpkoi_elements_section_team_member_image',
  			[
  				'label' => esc_html__( 'Team Member Image', 'wpkoi-elements' )
  			]
  		);
		

		$this->add_control(
			'wpkoi_elements_team_member_image',
			[
				'label' => __( 'Team Member Avatar', 'wpkoi-elements' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'condition' => [
					'wpkoi_elements_team_member_image[url]!' => '',
				],
			]
		);


		$this->end_controls_section();

  		$this->start_controls_section(
  			'wpkoi_elements_section_team_member_content',
  			[
  				'label' => esc_html__( 'Team Member Content', 'wpkoi-elements' )
  			]
  		);


		$this->add_control(
			'wpkoi_elements_team_member_name',
			[
				'label' => esc_html__( 'Name', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'wpkoi-elements' ),
			]
		);
		
		$this->add_control(
			'wpkoi_elements_team_member_job_title',
			[
				'label' => esc_html__( 'Job Position', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Software Engineer', 'wpkoi-elements' ),
			]
		);
		
		$this->add_control(
			'wpkoi_elements_team_member_description',
			[
				'label' => esc_html__( 'Description', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Add team member description here. Remove the text if not necessary.', 'wpkoi-elements' ),
			]
		);
		

		$this->end_controls_section();


  		$this->start_controls_section(
  			'wpkoi_elements_section_team_member_social_profiles',
  			[
  				'label' => esc_html__( 'Social Profiles', 'wpkoi-elements' )
  			]
  		);

		$this->add_control(
			'wpkoi_elements_team_member_enable_social_profiles',
			[
				'label' => esc_html__( 'Display Social Profiles?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$repeater = new Repeater();

		$repeater->add_control(
			'social_new',
			array(
				'label' => esc_html__( 'Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brand',
				]
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label' => esc_html__( 'Link', 'wpkoi-elements' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
					'url' => '',
					'is_external' => 'true',
				],
				'placeholder' => esc_html__( 'Place URL here', 'wpkoi-elements' ),
			)
		);
		
		$this->add_control(
			'wpkoi_elements_team_member_social_profile_links',
			array(
				'type'    => Controls_Manager::REPEATER,
				'condition' => [
					'wpkoi_elements_team_member_enable_social_profiles!' => '',
				],
				'label'   => esc_html__( 'Socials', 'wpkoi-elements' ),
				'fields'  => $repeater->get_controls(),
				'seperator' => 'before',
				'default' => [
					[
						'social' => 'fa fa-facebook',
					],
					[
						'social' => 'fa fa-twitter',
					],
					[
						'social' => 'fa fa-linkedin',
					],
				],
				'title_field' => '<i class="{{ social }}"></i> {{{ social.replace( \'fa fa-\', \'\' ).replace( \'-\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}',
			)
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'wpkoi_elements_section_team_members_styles_general',
			[
				'label' => esc_html__( 'Team Member Styles', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);


		$this->add_control(
			'wpkoi_elements_team_members_preset',
			[
				'label' => esc_html__( 'Style Preset', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wpkoi-elements-team-members-simple',
				'options' => [
					'wpkoi-elements-team-members-simple' 		=> esc_html__( 'Simple Style', 'wpkoi-elements' ),
					'wpkoi-elements-team-members-overlay' 	=> esc_html__( 'Overlay Style', 'wpkoi-elements' ),
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_overlay_background',
			[
				'label' => esc_html__( 'Overlay Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.8)',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-members-overlay .wpkoi-elements-team-content' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'wpkoi_elements_team_members_preset' => 'wpkoi-elements-team-members-overlay',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_background',
			[
				'label' => esc_html__( 'Content Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item .wpkoi-elements-team-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_alignment',
			[
				'label' => esc_html__( 'Set Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'default' => [
						'title' => __( 'Default', 'wpkoi-elements' ),
						'icon' => 'fa fa-ban',
					],
					'left' => [
						'title' => esc_html__( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'centered' => [
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'wpkoi-elements-team-align-default',
				'prefix_class' => 'wpkoi-elements-team-align-',
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_team_members_padding',
			[
				'label' => esc_html__( 'Content Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item .wpkoi-elements-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_team_members_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-team-item',
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'wpkoi_elements_section_team_members_image_styles',
			[
				'label' => esc_html__( 'Team Member Image Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);		

		$this->add_responsive_control(
			'wpkoi_elements_team_members_image_width',
			[
				'label' => esc_html__( 'Image Width', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
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
					'{{WRAPPER}} .wpkoi-elements-team-item figure img' => 'width:{{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'wpkoi_elements_team_members_image_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item figure img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_team_members_image_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_team_members_image_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-team-item figure img',
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_image_rounded',
			[
				'label' => esc_html__( 'Rounded Avatar?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'team-avatar-rounded',
				'default' => '',
			]
		);


		$this->add_control(
			'wpkoi_elements_team_members_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item figure img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'wpkoi_elements_team_members_image_rounded!' => 'team-avatar-rounded',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'wpkoi_elements_section_team_members_typography',
			[
				'label' => esc_html__( 'Color &amp; Typography', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_name_heading',
			[
				'label' => __( 'Member Name', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_name_color',
			[
				'label' => esc_html__( 'Member Name Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item .wpkoi-elements-team-member-name' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_team_members_name_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-team-item .wpkoi-elements-team-member-name',
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_position_heading',
			[
				'label' => __( 'Member Job Position', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_position_color',
			[
				'label' => esc_html__( 'Job Position Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item .wpkoi-elements-team-member-position' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_team_members_position_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-team-item .wpkoi-elements-team-member-position',
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_description_heading',
			[
				'label' => __( 'Member Description', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_description_color',
			[
				'label' => esc_html__( 'Description Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-item .wpkoi-elements-team-content .wpkoi-elements-team-text' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_team_members_description_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-team-item .wpkoi-elements-team-content .wpkoi-elements-team-text',
			]
		);


		$this->end_controls_section();

		
		$this->start_controls_section(
			'wpkoi_elements_section_team_members_social_profiles_styles',
			[
				'label' => esc_html__( 'Social Profiles Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);		


		$this->add_control(
			'wpkoi_elements_team_members_social_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-member-social-link > a' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_team_members_social_profiles_padding',
			[
				'label' => esc_html__( 'Social Profiles Spacing', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-content > .wpkoi-elements-team-member-social-profiles' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'wpkoi_elements_team_members_social_icons_style_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );

		$this->add_control(
			'wpkoi_elements_team_members_social_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f1ba63',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-member-social-link > a' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_control(
			'wpkoi_elements_team_members_social_icon_background',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-member-social-link > a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_team_members_social_icon_border',
				'selector' => '{{WRAPPER}} .wpkoi-elements-team-member-social-link > a',
			]
		);
		
		$this->add_control(
			'wpkoi_elements_team_members_social_icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-member-social-link > a' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_team_members_social_icon_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-team-member-social-link > a',
			]
		);

		
		$this->end_controls_tab();

		$this->start_controls_tab( 'wpkoi_elements_team_members_social_icon_hover', [ 'label' => esc_html__( 'Hover', 'wpkoi-elements' ) ] );

		$this->add_control(
			'wpkoi_elements_team_members_social_icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ad8647',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-member-social-link > a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_social_icon_hover_background',
			[
				'label' => esc_html__( 'Hover Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-member-social-link > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_team_members_social_icon_hover_border_color',
			[
				'label' => esc_html__( 'Hover Border Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-team-member-social-link > a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();


		$this->end_controls_section();


	}


	protected function render( ) {
		
      $settings = $this->get_settings();
      $team_member_image = $this->get_settings( 'wpkoi_elements_team_member_image' );
	  $team_member_image_url = Group_Control_Image_Size::get_attachment_image_src( $team_member_image['id'], 'thumbnail', $settings );	
	  if( empty( $team_member_image_url ) ) : $team_member_image_url = $team_member_image['url']; else: $team_member_image_url = $team_member_image_url; endif;
	  $team_member_classes = $this->get_settings('wpkoi_elements_team_members_preset') . " " . $this->get_settings('wpkoi_elements_team_members_image_rounded');
	
	?>


	<div id="wpkoi-elements-team-member-<?php echo esc_attr($this->get_id()); ?>" class="wpkoi-elements-team-item <?php echo $team_member_classes; ?>">
		<div class="wpkoi-elements-team-item-inner">
			<div class="wpkoi-elements-team-image">
				<figure>
					<img src="<?php echo esc_url($team_member_image_url);?>" alt="<?php echo $settings['wpkoi_elements_team_member_name'];?>">
				</figure>
			</div>

			<div class="wpkoi-elements-team-content">
				<h3 class="wpkoi-elements-team-member-name"><?php echo $settings['wpkoi_elements_team_member_name']; ?></h3>
				<h4 class="wpkoi-elements-team-member-position"><?php echo $settings['wpkoi_elements_team_member_job_title']; ?></h4>

				<?php if ( ! empty( $settings['wpkoi_elements_team_member_enable_social_profiles'] ) ): ?>
				<ul class="wpkoi-elements-team-member-social-profiles">
					<?php foreach ( $settings['wpkoi_elements_team_member_social_profile_links'] as $item ) : ?>
						<?php if ( ! empty( $item['social_new'] ) ) : ?>
							<?php $target = $item['link']['is_external'] ? ' target="_blank"' : ''; ?>
							<li class="wpkoi-elements-team-member-social-link">
								<a href="<?php echo esc_attr( $item['link']['url'] ); ?>"<?php echo $target; ?>>
                                <?php $migrated = isset( $item['__fa4_migrated']['social_new'] );
								$is_new = empty( $item['social'] );
								if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $item['social_new'], [ 'aria-hidden' => 'true' ] );
								else : ?><i class="<?php echo $item['social']; ?>" aria-hidden="true"></i>
								<?php endif; ?>
                                </a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>

				<p class="wpkoi-elements-team-text"><?php echo $settings['wpkoi_elements_team_member_description']; ?></p>
			</div>
		</div>
	</div>

	
	<?php
	
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Team_Member() );