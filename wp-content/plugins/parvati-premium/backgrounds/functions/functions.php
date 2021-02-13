<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Add necessary files
require_once plugin_dir_path( __FILE__ ) . 'secondary-nav-backgrounds.php';
require_once plugin_dir_path( __FILE__ ) . 'css.php';

if ( ! function_exists( 'parvati_backgrounds_customize' ) ) {
	add_action( 'customize_register', 'parvati_backgrounds_customize', 999 );
	/**
	 * Build our Customizer options
	 *
	 */
	function parvati_backgrounds_customize( $wp_customize ) {
		// Get our defaults
		$defaults = parvati_get_background_defaults();

		// Get our controls
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Register our custom control
		if ( method_exists( $wp_customize,'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Parvati_Background_Images_Customize_Control' );
		}

		// Add our panel
		if ( class_exists( 'WP_Customize_Panel' ) ) {
			if ( ! $wp_customize->get_panel( 'parvati_backgrounds_panel' ) ) {
				$wp_customize->add_panel( 'parvati_backgrounds_panel', array(
					'capability'     => 'edit_theme_options',
					'theme_supports' => '',
					'title'          => __( 'Background Images', 'parvati-premium' ),
					'priority'		 => 55
				) );
			}
		}

		$wp_customize->add_section(
			'backgrounds_section',
			array(
				'title' => __( 'Background Images', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 50,
			)
		);

		$wp_customize->add_section(
			'parvati_backgrounds_body',
			array(
				'title' => __( 'Body', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 5,
				'panel' => 'parvati_backgrounds_panel',
			)
		);

		/**
		 * Body background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[body_image]', array(
				'default' => $defaults['body_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_backgrounds-body-image',
				array(
					'section'    => 'parvati_backgrounds_body',
					'settings'   => 'parvati_background_settings[body_image]',
					'label' => __( 'Body', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[body_repeat]',
			array(
				'default' => $defaults['body_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[body_size]',
			array(
				'default' => $defaults['body_size'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[body_attachment]',
			array(
				'default' => $defaults['body_attachment'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[body_position]', array(
				'default' => $defaults['body_position'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			new Parvati_Background_Images_Customize_Control(
				$wp_customize,
				'body_backgrounds_control',
				array(
					'section' => 'parvati_backgrounds_body',
					'settings' => array(
						'repeat' => 'parvati_background_settings[body_repeat]',
						'size' => 'parvati_background_settings[body_size]',
						'attachment' => 'parvati_background_settings[body_attachment]',
						'position' => 'parvati_background_settings[body_position]',
					),
				)
			)
		);

		/**
		 * Top bar background
		 */
		$wp_customize->add_section(
			'parvati_backgrounds_top_bar',
			array(
				'title' => __( 'Top Bar', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 5,
				'panel' => 'parvati_backgrounds_panel',
				'active_callback' => 'parvati_premium_is_top_bar_active',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[top_bar_image]', array(
				'default' => $defaults['top_bar_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_background_settings[top_bar_image]',
				array(
					'section'    => 'parvati_backgrounds_top_bar',
					'settings'   => 'parvati_background_settings[top_bar_image]',
					'label' => __( 'Top Bar', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[top_bar_repeat]',
			array(
				'default' => $defaults['top_bar_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[top_bar_size]',
			array(
				'default' => $defaults['top_bar_size'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[top_bar_attachment]',
			array(
				'default' => $defaults['top_bar_attachment'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[top_bar_position]', array(
				'default' => $defaults['top_bar_position'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			new Parvati_Background_Images_Customize_Control(
				$wp_customize,
				'top_bar_backgrounds_control',
				array(
					'section' => 'parvati_backgrounds_top_bar',
					'settings' => array(
						'repeat' => 'parvati_background_settings[top_bar_repeat]',
						'size' => 'parvati_background_settings[top_bar_size]',
						'attachment' => 'parvati_background_settings[top_bar_attachment]',
						'position' => 'parvati_background_settings[top_bar_position]',
					),
				)
			)
		);

		/**
		 * Header background
		 */
		$wp_customize->add_section(
			'parvati_backgrounds_header',
			array(
				'title' => __( 'Header', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 10,
				'panel' => 'parvati_backgrounds_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[header_repeat]',
			array(
				'default' => $defaults['header_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[header_size]',
			array(
				'default' => $defaults['header_size'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[header_attachment]',
			array(
				'default' => $defaults['header_attachment'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[header_position]', array(
				'default' => $defaults['header_position'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			new Parvati_Background_Images_Customize_Control(
				$wp_customize,
				'header_backgrounds_control',
				array(
					'section' => 'parvati_backgrounds_header',
					'settings' => array(
						'repeat' => 'parvati_background_settings[header_repeat]',
						'size' => 'parvati_background_settings[header_size]',
						'attachment' => 'parvati_background_settings[header_attachment]',
						'position' => 'parvati_background_settings[header_position]',
					),
				)
			)
		);

		$wp_customize->add_section(
			'parvati_backgrounds_navigation',
			array(
				'title' => __( 'Primary Navigation', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 15,
				'panel' => 'parvati_backgrounds_panel',
			)
		);

		/**
		 * Navigation background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[nav_image]', array(
				'default' => $defaults['nav_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_background_settings[nav_image]',
				array(
					'section'    => 'parvati_backgrounds_navigation',
					'settings'   => 'parvati_background_settings[nav_image]',
					'priority' => 750,
					'label' => __( 'Navigation', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[nav_repeat]',
			array(
				'default' => $defaults['nav_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'parvati_background_settings[nav_repeat]',
			array(
				'type' => 'select',
				'section' => 'parvati_backgrounds_navigation',
				'choices' => array(
					'' => __( 'Repeat', 'parvati-premium' ),
					'repeat-x' => __( 'Repeat x', 'parvati-premium' ),
					'repeat-y' => __( 'Repeat y', 'parvati-premium' ),
					'no-repeat' => __( 'No Repeat', 'parvati-premium' ),
				),
				'settings' => 'parvati_background_settings[nav_repeat]',
				'priority' => 800,
			)
		);

		/**
		 * Navigation item background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[nav_item_image]', array(
				'default' => $defaults['nav_item_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_backgrounds-nav-item-image',
				array(
					'section' => 'parvati_backgrounds_navigation',
					'settings' => 'parvati_background_settings[nav_item_image]',
					'priority' => 950,
					'label' => __( 'Navigation Item', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[nav_item_repeat]',
			array(
				'default' => $defaults['nav_item_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'parvati_background_settings[nav_item_repeat]',
			array(
				'type' => 'select',
				'section' => 'parvati_backgrounds_navigation',
				'choices' => array(
					'' => __( 'Repeat', 'parvati-premium' ),
					'repeat-x' => __( 'Repeat x', 'parvati-premium' ),
					'repeat-y' => __( 'Repeat y', 'parvati-premium' ),
					'no-repeat' => __( 'No Repeat', 'parvati-premium' ),
				),
				'settings' => 'parvati_background_settings[nav_item_repeat]',
				'priority' => 1000,
			)
		);

		/**
		 * Navigation item hover background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[nav_item_hover_image]', array(
				'default' => $defaults['nav_item_hover_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_backgrounds-nav-item-hover-image',
				array(
					'section'    => 'parvati_backgrounds_navigation',
					'settings'   => 'parvati_background_settings[nav_item_hover_image]',
					'priority' => 1150,
					'label' => __( 'Navigation Item Hover', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[nav_item_hover_repeat]',
			array(
				'default' => $defaults['nav_item_hover_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'parvati_background_settings[nav_item_hover_repeat]',
			array(
				'type' => 'select',
				'section' => 'parvati_backgrounds_navigation',
				'choices' => array(
					'' => __( 'Repeat', 'parvati-premium' ),
					'repeat-x' => __( 'Repeat x', 'parvati-premium' ),
					'repeat-y' => __( 'Repeat y', 'parvati-premium' ),
					'no-repeat' => __( 'No Repeat', 'parvati-premium' ),
				),
				'settings' => 'parvati_background_settings[nav_item_hover_repeat]',
				'priority' => 1200,
			)
		);

		/**
		 * Navigation item current background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[nav_item_current_image]', array(
				'default' => $defaults['nav_item_current_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_backgrounds-nav-item-current-image',
				array(
					'section'    => 'parvati_backgrounds_navigation',
					'settings'   => 'parvati_background_settings[nav_item_current_image]',
					'priority' => 1350,
					'label' => __( 'Navigation Item Current', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[nav_item_current_repeat]',
			array(
				'default' => $defaults['nav_item_current_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'parvati_background_settings[nav_item_current_repeat]',
			array(
				'type' => 'select',
				'section' => 'parvati_backgrounds_navigation',
				'choices' => array(
					'' => __( 'Repeat', 'parvati-premium' ),
					'repeat-x' => __( 'Repeat x', 'parvati-premium' ),
					'repeat-y' => __( 'Repeat y', 'parvati-premium' ),
					'no-repeat' => __( 'No Repeat', 'parvati-premium' ),
				),
				'settings' => 'parvati_background_settings[nav_item_current_repeat]',
				'priority' => 1400,
			)
		);

		$wp_customize->add_section(
			'parvati_backgrounds_subnavigation',
			array(
				'title' => __( 'Primary Sub-Navigation', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 20,
				'panel' => 'parvati_backgrounds_panel',
			)
		);

		/**
		 * Sub-Navigation item background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[sub_nav_item_image]', array(
				'default' => $defaults['sub_nav_item_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_background_settings[sub_nav_item_image]',
				array(
					'section'    => 'parvati_backgrounds_subnavigation',
					'settings'   => 'parvati_background_settings[sub_nav_item_image]',
					'priority' => 1700,
					'label' => __( 'Sub-Navigation Item', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[sub_nav_item_repeat]',
			array(
				'default' => $defaults['sub_nav_item_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'parvati_background_settings[sub_nav_item_repeat]',
			array(
				'type' => 'select',
				'section' => 'parvati_backgrounds_subnavigation',
				'choices' => array(
					'' => __( 'Repeat', 'parvati-premium' ),
					'repeat-x' => __( 'Repeat x', 'parvati-premium' ),
					'repeat-y' => __( 'Repeat y', 'parvati-premium' ),
					'no-repeat' => __( 'No Repeat', 'parvati-premium' ),
				),
				'settings' => 'parvati_background_settings[sub_nav_item_repeat]',
				'priority' => 1800,
			)
		);

		/**
		 * Sub-Navigation item hover background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[sub_nav_item_hover_image]', array(
				'default' => $defaults['sub_nav_item_hover_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_background_settings[sub_nav_item_hover_image]',
				array(
					'section' => 'parvati_backgrounds_subnavigation',
					'settings' => 'parvati_background_settings[sub_nav_item_hover_image]',
					'priority' => 2000,
					'label' => __( 'Sub-Navigation Item Hover', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[sub_nav_item_hover_repeat]',
			array(
				'default' => $defaults['sub_nav_item_hover_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'parvati_background_settings[sub_nav_item_hover_repeat]',
			array(
				'type' => 'select',
				'section' => 'parvati_backgrounds_subnavigation',
				'choices' => array(
					'' => __( 'Repeat', 'parvati-premium' ),
					'repeat-x' => __( 'Repeat x', 'parvati-premium' ),
					'repeat-y' => __( 'Repeat y', 'parvati-premium' ),
					'no-repeat' => __( 'No Repeat', 'parvati-premium' ),
				),
				'settings' => 'parvati_background_settings[sub_nav_item_hover_repeat]',
				'priority' => 2100,
			)
		);

		/**
		 * Sub-Navigation item current background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[sub_nav_item_current_image]', array(
				'default' => $defaults['sub_nav_item_current_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_background_settings[sub_nav_item_current_image]',
				array(
					'section'    => 'parvati_backgrounds_subnavigation',
					'settings'   => 'parvati_background_settings[sub_nav_item_current_image]',
					'priority' => 2300,
					'label' => __( 'Sub-Navigation Item Current', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[sub_nav_item_current_repeat]',
			array(
				'default' => $defaults['sub_nav_item_current_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			'parvati_background_settings[sub_nav_item_current_repeat]',
			array(
				'type' => 'select',
				'section' => 'parvati_backgrounds_subnavigation',
				'choices' => array(
					'' => __( 'Repeat', 'parvati-premium' ),
					'repeat-x' => __( 'Repeat x', 'parvati-premium' ),
					'repeat-y' => __( 'Repeat y', 'parvati-premium' ),
					'no-repeat' => __( 'No Repeat', 'parvati-premium' ),
				),
				'settings' => 'parvati_background_settings[sub_nav_item_current_repeat]',
				'priority' => 2400
			)
		);

		$wp_customize->add_section(
			'parvati_backgrounds_content',
			array(
				'title' => __( 'Content', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 25,
				'panel' => 'parvati_backgrounds_panel',
			)
		);

		/**
		 * Content background
		 */
		$wp_customize->add_setting(
			'parvati_background_settings[content_image]', array(
				'default' => $defaults['content_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_background_settings[content_image]',
				array(
					'section' => 'parvati_backgrounds_content',
					'settings' => 'parvati_background_settings[content_image]',
					'label' => __( 'Content', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[content_repeat]',
			array(
				'default' => $defaults['content_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[content_size]',
			array(
				'default' => $defaults['content_size'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[content_attachment]',
			array(
				'default' => $defaults['content_attachment'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[content_position]', array(
				'default' => $defaults['content_position'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			new Parvati_Background_Images_Customize_Control(
				$wp_customize,
				'content_backgrounds_control',
				array(
					'section' => 'parvati_backgrounds_content',
					'settings' => array(
						'repeat' => 'parvati_background_settings[content_repeat]',
						'size' => 'parvati_background_settings[content_size]',
						'attachment' => 'parvati_background_settings[content_attachment]',
						'position' => 'parvati_background_settings[content_position]',
					),
				)
			)
		);

		// Sidebars
		$wp_customize->add_section(
			'parvati_backgrounds_sidebars',
			array(
				'title' => __( 'Sidebar', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 25,
				'panel' => 'parvati_backgrounds_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[sidebar_widget_image]', array(
				'default' => $defaults['sidebar_widget_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_background_settings[sidebar_widget_image]',
				array(
					'section'    => 'parvati_backgrounds_sidebars',
					'settings'   => 'parvati_background_settings[sidebar_widget_image]',
					'label' => __( 'Sidebar Widgets', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[sidebar_widget_repeat]',
			array(
				'default' => $defaults['sidebar_widget_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[sidebar_widget_size]',
			array(
				'default' => $defaults['sidebar_widget_size'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[sidebar_widget_attachment]',
			array(
				'default' => $defaults['sidebar_widget_attachment'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[sidebar_widget_position]', array(
				'default' => $defaults['sidebar_widget_position'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			new Parvati_Background_Images_Customize_Control(
				$wp_customize,
				'sidebar_backgrounds_control',
				array(
					'section' => 'parvati_backgrounds_sidebars',
					'settings' => array(
						'repeat' => 'parvati_background_settings[sidebar_widget_repeat]',
						'size' => 'parvati_background_settings[sidebar_widget_size]',
						'attachment' => 'parvati_background_settings[sidebar_widget_attachment]',
						'position' => 'parvati_background_settings[sidebar_widget_position]',
					),
				)
			)
		);

		// Footer widgets
		$wp_customize->add_section(
			'parvati_backgrounds_footer',
			array(
				'title' => __( 'Footer', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 30,
				'panel' => 'parvati_backgrounds_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_widget_image]',
			array(
				'default' => $defaults['footer_widget_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_background_settings[footer_widget_image]',
				array(
					'section'    => 'parvati_backgrounds_footer',
					'settings'   => 'parvati_background_settings[footer_widget_image]',
					'label' => __( 'Footer Widget Area', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_widget_repeat]',
			array(
				'default' => $defaults['footer_widget_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_widget_size]',
			array(
				'default' => $defaults['footer_widget_size'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_widget_attachment]',
			array(
				'default' => $defaults['footer_widget_attachment'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_widget_position]', array(
				'default' => $defaults['footer_widget_position'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			new Parvati_Background_Images_Customize_Control(
				$wp_customize,
				'footer_widgets_backgrounds_control',
				array(
					'section' => 'parvati_backgrounds_footer',
					'settings' => array(
						'repeat' => 'parvati_background_settings[footer_widget_repeat]',
						'size' => 'parvati_background_settings[footer_widget_size]',
						'attachment' => 'parvati_background_settings[footer_widget_attachment]',
						'position' => 'parvati_background_settings[footer_widget_position]',
					),
				)
			)
		);

		// Footer
		$wp_customize->add_setting(
			'parvati_background_settings[footer_image]',
			array(
				'default' => $defaults['footer_image'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_backgrounds-footer-image',
				array(
					'section' => 'parvati_backgrounds_footer',
					'settings' => 'parvati_background_settings[footer_image]',
					'label' => __( 'Footer Area', 'parvati-premium' ),
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_repeat]',
			array(
				'default' => $defaults['footer_repeat'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_size]',
			array(
				'default' => $defaults['footer_size'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_attachment]',
			array(
				'default' => $defaults['footer_attachment'],
				'type' => 'option',
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_setting(
			'parvati_background_settings[footer_position]', array(
				'default' => $defaults['footer_position'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			new Parvati_Background_Images_Customize_Control(
				$wp_customize,
				'footer_backgrounds_control',
				array(
					'section' => 'parvati_backgrounds_footer',
					'settings' => array(
						'repeat' => 'parvati_background_settings[footer_repeat]',
						'size' => 'parvati_background_settings[footer_size]',
						'attachment' => 'parvati_background_settings[footer_attachment]',
						'position' => 'parvati_background_settings[footer_position]',
					),
				)
			)
		);
	}
}

if ( ! function_exists( 'parvati_backgrounds_css' ) ) {
	/**
	 * Generate the CSS in the <head> section using the Theme Customizer
	 *
	 */
	function parvati_backgrounds_css() {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_background_settings', array() ),
			parvati_get_background_defaults()
		);

		// Fix size values
		// Spaces and % are stripped by sanitize_key
		$parvati_settings[ 'body_size' ] = ( '100' == $parvati_settings[ 'body_size' ] ) ? '100% auto' : esc_attr( $parvati_settings[ 'body_size' ] );
		$parvati_settings[ 'top_bar_size' ] = ( '100' == $parvati_settings[ 'top_bar_size' ] ) ? '100% auto' : esc_attr( $parvati_settings[ 'top_bar_size' ] );
		$parvati_settings[ 'header_size' ] = ( '100' == $parvati_settings[ 'header_size' ] ) ? '100% auto' : esc_attr( $parvati_settings[ 'header_size' ] );
		$parvati_settings[ 'content_size' ] = ( '100' == $parvati_settings[ 'content_size' ] ) ? '100% auto' : esc_attr( $parvati_settings[ 'content_size' ] );
		$parvati_settings[ 'sidebar_widget_size' ] = ( '100' == $parvati_settings[ 'sidebar_widget_size' ] ) ? '100% auto' : esc_attr( $parvati_settings[ 'sidebar_widget_size' ] );
		$parvati_settings[ 'footer_widget_size' ] = ( '100' == $parvati_settings[ 'footer_widget_size' ] ) ? '100% auto' : esc_attr( $parvati_settings[ 'footer_widget_size' ] );
		$parvati_settings[ 'footer_size' ] = ( '100' == $parvati_settings[ 'footer_size' ] ) ? '100% auto' : esc_attr( $parvati_settings[ 'footer_size' ] );

		// Initiate our CSS class
		$css = new Parvati_Backgrounds_CSS;

		// Body
		$css->set_selector( 'body' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'body_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'body_repeat' ] ) );
		$css->add_property( 'background-size', esc_attr( $parvati_settings[ 'body_size' ] ) );
		$css->add_property( 'background-attachment', esc_attr( $parvati_settings[ 'body_attachment' ] ) );
		$css->add_property( 'background-position', esc_attr( $parvati_settings[ 'body_position' ] ) );

		// Top bar
		if ( is_active_sidebar( 'top-bar' ) ) {
			$css->set_selector( '.top-bar' );
			$css->add_property( 'background-image', esc_url( $parvati_settings[ 'top_bar_image' ] ), 'url' );
			$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'top_bar_repeat' ] ) );
			$css->add_property( 'background-size', esc_attr( $parvati_settings[ 'top_bar_size' ] ) );
			$css->add_property( 'background-attachment', esc_attr( $parvati_settings[ 'top_bar_attachment' ] ) );
			$css->add_property( 'background-position', esc_attr( $parvati_settings[ 'top_bar_position' ] ) );
		}

		// Header
		$css->set_selector( '.site-header' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'header_repeat' ] ) );
		$css->add_property( 'background-size', esc_attr( $parvati_settings[ 'header_size' ] ) );
		$css->add_property( 'background-attachment', esc_attr( $parvati_settings[ 'header_attachment' ] ) );
		$css->add_property( 'background-position', esc_attr( $parvati_settings[ 'header_position' ] ) );

		// Navigation background
		$css->set_selector( '.main-navigation,.menu-toggle' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'nav_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'nav_repeat' ] ) );

		// Navigation item background
		$css->set_selector( '.main-navigation .main-nav > ul > li > a' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'nav_item_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'nav_item_repeat' ] ) );

		// Navigation background/text on hover
		$css->set_selector( '.main-navigation .main-nav > ul > li > a:hover,.main-navigation .main-nav > ul > li.sfHover > a' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'nav_item_hover_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'nav_item_hover_repeat' ] ) );

		// Navigation background/text current
		$css->set_selector( '.main-navigation .main-nav > ul > li[class*="current-menu-"] > a,.main-navigation .main-nav > ul > li[class*="current-menu-"] > a:hover,.main-navigation .main-nav > ul > li[class*="current-menu-"].sfHover > a' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'nav_item_current_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'nav_item_current_repeat' ] ) );

		// Sub-Navigation text
		$css->set_selector( '.main-navigation ul ul li a' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'sub_nav_item_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'sub_nav_item_repeat' ] ) );

		// Sub-Navigation background/text on hover
		$css->set_selector( '.main-navigation ul ul li > a:hover,.main-navigation ul ul li.sfHover > a' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'sub_nav_item_hover_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'sub_nav_item_hover_repeat' ] ) );

		// Sub-Navigation background / text current
		$css->set_selector( '.main-navigation ul ul li[class*="current-menu-"] > a,.main-navigation ul ul li[class*="current-menu-"] > a:hover,.main-navigation ul ul li[class*="current-menu-"].sfHover > a' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'sub_nav_item_current_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'sub_nav_item_current_repeat' ] ) );

		// Content
		$css->set_selector( '.separate-containers .inside-article,.separate-containers .comments-area,.separate-containers .page-header,.one-container .container,.separate-containers .paging-navigation,.separate-containers .inside-page-header' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'content_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'content_repeat' ] ) );
		$css->add_property( 'background-size', esc_attr( $parvati_settings[ 'content_size' ] ) );
		$css->add_property( 'background-attachment', esc_attr( $parvati_settings[ 'content_attachment' ] ) );
		$css->add_property( 'background-position', esc_attr( $parvati_settings[ 'content_position' ] ) );

		// Sidebar widget
		$css->set_selector( '.sidebar .widget' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'sidebar_widget_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'sidebar_widget_repeat' ] ) );
		$css->add_property( 'background-size', esc_attr( $parvati_settings[ 'sidebar_widget_size' ] ) );
		$css->add_property( 'background-attachment', esc_attr( $parvati_settings[ 'sidebar_widget_attachment' ] ) );
		$css->add_property( 'background-position', esc_attr( $parvati_settings[ 'sidebar_widget_position' ] ) );

		// Footer widget
		$css->set_selector( '.footer-widgets' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'footer_widget_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'footer_widget_repeat' ] ) );
		$css->add_property( 'background-size', esc_attr( $parvati_settings[ 'footer_widget_size' ] ) );
		$css->add_property( 'background-attachment', esc_attr( $parvati_settings[ 'footer_widget_attachment' ] ) );
		$css->add_property( 'background-position', esc_attr( $parvati_settings[ 'footer_widget_position' ] ) );

		// Footer
		$css->set_selector( '.site-info' );
		$css->add_property( 'background-image', esc_url( $parvati_settings[ 'footer_image' ] ), 'url' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings[ 'footer_repeat' ] ) );
		$css->add_property( 'background-size', esc_attr( $parvati_settings[ 'footer_size' ] ) );
		$css->add_property( 'background-attachment', esc_attr( $parvati_settings[ 'footer_attachment' ] ) );
		$css->add_property( 'background-position', esc_attr( $parvati_settings[ 'footer_position' ] ) );

		// Return our dynamic CSS
		return apply_filters( 'parvati_backgrounds_css_output', $css->css_output() );
	}
}

if ( ! function_exists( 'parvati_background_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'parvati_background_scripts', 70 );
	/**
	 * Enqueue scripts and styles.
	 *
	 */
	function parvati_background_scripts() {
		wp_add_inline_style( 'parvati-style', parvati_backgrounds_css() );
	}
}
