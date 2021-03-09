<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please
}

// Add necessary files
require_once trailingslashit( dirname(__FILE__) ) . 'secondary-nav-colors.php';
require_once trailingslashit( dirname(__FILE__) ) . 'woocommerce-colors.php';
require_once trailingslashit( dirname(__FILE__) ) . 'slideout-nav-colors.php';
require_once trailingslashit( dirname(__FILE__) ) . 'fixed-side-content-colors.php';

if ( ! function_exists( 'parvati_colors_customize_register' ) ) {
	add_action( 'customize_register', 'parvati_colors_customize_register' );
	/**
	 * Add our Customizer options.
	 *
	 */
	function parvati_colors_customize_register( $wp_customize ) {

		// Bail if we don't have our color defaults
		if ( ! function_exists( 'parvati_get_color_defaults' ) ) {
			return;
		}

		// Add our controls
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Get our defaults
		$defaults = parvati_get_color_defaults();

		// Add control types so controls can be built using JS
		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Parvati_Alpha_Color_Customize_Control' );
			$wp_customize->register_control_type( 'Parvati_Title_Customize_Control' );
		}

		// Get our palettes
		$palettes = parvati_get_default_color_palettes();

		// Add our Colors panel
		if ( class_exists( 'WP_Customize_Panel' ) ) {
			$wp_customize->add_panel( 'parvati_colors_panel', array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Extra Colors', 'parvati-premium' ),
				'description'    => '',
			) );
		}

		// Add Top Bar Colors section
		if ( isset( $defaults[ 'top_bar_background_color' ] ) && function_exists( 'parvati_is_top_bar_active' ) ) {
			$wp_customize->add_section(
				'parvati_top_bar_colors',
				array(
					'title' => __( 'Top Bar', 'parvati-premium' ),
					'capability' => 'edit_theme_options',
					'priority' => 40,
					'panel' => 'parvati_colors_panel',
				)
			);

			$wp_customize->add_setting(
				'parvati_settings[top_bar_background_color]',
				array(
					'default'     => $defaults['top_bar_background_color'],
					'type'        => 'option',
					'capability'  => 'edit_theme_options',
					'transport'   => 'postMessage',
					'sanitize_callback' => 'parvati_premium_sanitize_rgba',
				)
			);

			$wp_customize->add_control(
				new Parvati_Alpha_Color_Customize_Control(
					$wp_customize,
					'parvati_settings[top_bar_background_color]',
					array(
						'label'     => __( 'Background', 'parvati-premium' ),
						'section'   => 'parvati_top_bar_colors',
						'settings'  => 'parvati_settings[top_bar_background_color]',
						'palette'   => $palettes,
						'show_opacity'  => true,
						'priority' => 1,
						'active_callback' => 'parvati_is_top_bar_active',
					)
				)
			);

			// Add color settings
			$top_bar_colors = array();
			$top_bar_colors[] = array(
				'slug' => 'top_bar_text_color',
				'default' => $defaults['top_bar_text_color'],
				'label' => __( 'Text', 'parvati-premium' ),
				'priority' => 2,
			);
			$top_bar_colors[] = array(
				'slug' => 'top_bar_link_color',
				'default' => $defaults['top_bar_link_color'],
				'label' => __( 'Link', 'parvati-premium' ),
				'priority' => 3,
			);
			$top_bar_colors[] = array(
				'slug' => 'top_bar_link_color_hover',
				'default' => $defaults['top_bar_link_color_hover'],
				'label' => __( 'Link Hover', 'parvati-premium' ),
				'priority' => 4,
			);

			foreach( $top_bar_colors as $color ) {
				$wp_customize->add_setting(
					'parvati_settings[' . $color['slug'] . ']', array(
						'default' => $color['default'],
						'type' => 'option',
						'capability' => 'edit_theme_options',
						'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
						'transport' => 'postMessage'
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						$color['slug'],
						array(
							'label' => $color['label'],
							'section' => 'parvati_top_bar_colors',
							'settings' => 'parvati_settings[' . $color['slug'] . ']',
							'priority' => $color['priority'],
							'palette'   => $palettes,
							'active_callback' => 'parvati_is_top_bar_active'
						)
					)
				);
			}
		}

		// Add Header Colors section
		$wp_customize->add_section(
			'header_color_section',
			array(
				'title' => __( 'Header', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 50,
				'panel' => 'parvati_colors_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[header_background_color]',
			array(
				'default'     => $defaults['header_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[header_background_color]',
				array(
					'label'     => __( 'Background', 'parvati-premium' ),
					'section'   => 'header_color_section',
					'settings'  => 'parvati_settings[header_background_color]',
					'palette'   => $palettes,
					'show_opacity'  => true,
					'priority' => 1,
				)
			)
		);

		// Add color settings
		$header_colors = array();
		$header_colors[] = array(
			'slug' => 'header_text_color',
			'default' => $defaults['header_text_color'],
			'label' => __( 'Text', 'parvati-premium' ),
			'priority' => 2,
		);
		$header_colors[] = array(
			'slug' => 'header_link_color',
			'default' => $defaults['header_link_color'],
			'label' => __( 'Link', 'parvati-premium' ),
			'priority' => 3,
		);
		$header_colors[] = array(
			'slug' => 'header_link_hover_color',
			'default' => $defaults['header_link_hover_color'],
			'label' => __( 'Link Hover', 'parvati-premium' ),
			'priority' => 4,
		);
		$header_colors[] = array(
			'slug' => 'site_title_color',
			'default' => $defaults['site_title_color'],
			'label' => __( 'Site Title', 'parvati-premium' ),
			'priority' => 5,
		);
		$header_colors[] = array(
			'slug' => 'site_tagline_color',
			'default' => $defaults['site_tagline_color'],
			'label' => __( 'Tagline', 'parvati-premium' ),
			'priority' => 6,
		);

		foreach( $header_colors as $color ) {
			$wp_customize->add_setting(
				'parvati_settings[' . $color['slug'] . ']', array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
					'transport' => 'postMessage'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'header_color_section',
						'settings' => 'parvati_settings[' . $color['slug'] . ']',
						'priority' => $color['priority'],
						'palette'   => $palettes,
					)
				)
			);
		}

		// Add Navigation section
		$wp_customize->add_section(
			'navigation_color_section',
			array(
				'title' => __( 'Primary Navigation', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 60,
				'panel' => 'parvati_colors_panel',
			)
		);

		$wp_customize->add_control(
			new Parvati_Title_Customize_Control(
				$wp_customize,
				'parvati_primary_navigation_parent_items',
				array(
					'section'     => 'navigation_color_section',
					'type'        => 'parvati-customizer-title',
					'title'			=> __( 'Parent Items', 'parvati-premium' ),
					'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
					'priority'	=> 0,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[navigation_background_color]',
			array(
				'default'     => $defaults['navigation_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[navigation_background_color]',
				array(
					'label'     => __( 'Background', 'parvati-premium' ),
					'section'   => 'navigation_color_section',
					'settings'  => 'parvati_settings[navigation_background_color]',
					'palette'   => $palettes,
					'priority' => 1,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[navigation_background_hover_color]',
			array(
				'default'     => $defaults['navigation_background_hover_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[navigation_background_hover_color]',
				array(
					'label'     => __( 'Background Hover', 'parvati-premium' ),
					'section'   => 'navigation_color_section',
					'settings'  => 'parvati_settings[navigation_background_hover_color]',
					'palette'   => $palettes,
					'priority' => 3,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[navigation_background_current_color]',
			array(
				'default'     => $defaults['navigation_background_current_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[navigation_background_current_color]',
				array(
					'label'     => __( 'Background Current', 'parvati-premium' ),
					'section'   => 'navigation_color_section',
					'settings'  => 'parvati_settings[navigation_background_current_color]',
					'palette'   => $palettes,
					'priority' => 5,
				)
			)
		);

		// Add color settings
		$navigation_colors = array();
		$navigation_colors[] = array(
			'slug'=>'navigation_text_color',
			'default' => $defaults['navigation_text_color'],
			'label' => __( 'Text', 'parvati-premium' ),
			'priority' => 2,
		);
		$navigation_colors[] = array(
			'slug'=>'navigation_text_hover_color',
			'default' => $defaults['navigation_text_hover_color'],
			'label' => __( 'Text Hover', 'parvati-premium' ),
			'priority' => 4,
		);
		$navigation_colors[] = array(
			'slug'=>'navigation_text_current_color',
			'default' => $defaults['navigation_text_current_color'],
			'label' => __( 'Text Current', 'parvati-premium' ),
			'priority' => 6,
		);

		foreach( $navigation_colors as $color ) {
			$wp_customize->add_setting(
				'parvati_settings[' . $color['slug'] . ']', array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
					'transport' => 'postMessage'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'navigation_color_section',
						'settings' => 'parvati_settings[' . $color['slug'] . ']',
						'priority' => $color['priority']
					)
				)
			);
		}

		$wp_customize->add_control(
			new Parvati_Title_Customize_Control(
				$wp_customize,
				'parvati_primary_navigation_sub_menu_items',
				array(
					'section'     => 'navigation_color_section',
					'type'        => 'parvati-customizer-title',
					'title'			=> __( 'Sub-Menu Items', 'parvati-premium' ),
					'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
					'priority' => 7,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[subnavigation_background_color]',
			array(
				'default'     => $defaults['subnavigation_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[subnavigation_background_color]',
				array(
					'label'     => __( 'Background', 'parvati-premium' ),
					'section'   => 'navigation_color_section',
					'settings'  => 'parvati_settings[subnavigation_background_color]',
					'palette'   => $palettes,
					'priority' => 8,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[subnavigation_background_hover_color]',
			array(
				'default'     => $defaults['subnavigation_background_hover_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[subnavigation_background_hover_color]',
				array(
					'label'     => __( 'Background Hover', 'parvati-premium' ),
					'section'   => 'navigation_color_section',
					'settings'  => 'parvati_settings[subnavigation_background_hover_color]',
					'palette'   => $palettes,
					'priority' => 10,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[subnavigation_background_current_color]',
			array(
				'default'     => $defaults['subnavigation_background_current_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[subnavigation_background_current_color]',
				array(
					'label'     => __( 'Background Current', 'parvati-premium' ),
					'section'   => 'navigation_color_section',
					'settings'  => 'parvati_settings[subnavigation_background_current_color]',
					'palette'   => $palettes,
					'priority' => 12,
				)
			)
		);

		// Add color settings
		$subnavigation_colors = array();
		$subnavigation_colors[] = array(
			'slug'=>'subnavigation_text_color',
			'default' => $defaults['subnavigation_text_color'],
			'label' => __( 'Text', 'parvati-premium' ),
			'priority' => 9,
		);
		$subnavigation_colors[] = array(
			'slug'=>'subnavigation_text_hover_color',
			'default' => $defaults['subnavigation_text_hover_color'],
			'label' => __( 'Text Hover', 'parvati-premium' ),
			'priority' => 11,
		);
		$subnavigation_colors[] = array(
			'slug'=>'subnavigation_text_current_color',
			'default' => $defaults['subnavigation_text_current_color'],
			'label' => __( 'Text Current', 'parvati-premium' ),
			'priority' => 13,
		);
		foreach( $subnavigation_colors as $color ) {
			$wp_customize->add_setting(
				'parvati_settings[' . $color['slug'] . ']', array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'navigation_color_section',
						'settings' => 'parvati_settings[' . $color['slug'] . ']',
						'priority' => $color['priority'],
					)
				)
			);
		}

		$wp_customize->add_section(
			'buttons_color_section',
			array(
				'title' => __( 'Buttons', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 75,
				'panel' => 'parvati_colors_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[form_button_background_color]',
			array(
				'default'     => $defaults['form_button_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[form_button_background_color]',
				array(
					'label'     => __( 'Background', 'parvati-premium' ),
					'section'   => 'buttons_color_section',
					'settings'  => 'parvati_settings[form_button_background_color]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[form_button_text_color]', array(
				'default' => $defaults['form_button_text_color'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'form_button_text_color',
				array(
					'label' => __( 'Text', 'parvati-premium' ),
					'section' => 'buttons_color_section',
					'settings' => 'parvati_settings[form_button_text_color]',
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[form_button_background_color_hover]',
			array(
				'default'     => $defaults['form_button_background_color_hover'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[form_button_background_color_hover]',
				array(
					'label'     => __( 'Background Hover', 'parvati-premium' ),
					'section'   => 'buttons_color_section',
					'settings'  => 'parvati_settings[form_button_background_color_hover]',
					'palette'   => $palettes,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[form_button_text_color_hover]', array(
				'default' => $defaults['form_button_text_color_hover'],
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_hex_color'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'form_button_text_color_hover',
				array(
					'label' => __( 'Text Hover', 'parvati-premium' ),
					'section' => 'buttons_color_section',
					'settings' => 'parvati_settings[form_button_text_color_hover]',
				)
			)
		);

		// Add Content Colors section
		$wp_customize->add_section(
			'content_color_section',
			array(
				'title' => __( 'Content', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 80,
				'panel' => 'parvati_colors_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[content_background_color]',
			array(
				'default'     => $defaults['content_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[content_background_color]',
				array(
					'label'     => __( 'Background', 'parvati-premium' ),
					'section'   => 'content_color_section',
					'settings'  => 'parvati_settings[content_background_color]',
					'palette'   => $palettes,
					'priority' => 1,
				)
			)
		);

		// Add color settings
		$content_colors = array();
		$content_colors[] = array(
			'slug' => 'content_text_color',
			'default' => $defaults['content_text_color'],
			'label' => __( 'Text', 'parvati-premium' ),
			'priority' => 2,
		);
		$content_colors[] = array(
			'slug' => 'content_link_color',
			'default' => $defaults['content_link_color'],
			'label' => __( 'Link', 'parvati-premium' ),
			'priority' => 3,
		);
		$content_colors[] = array(
			'slug' => 'content_link_hover_color',
			'default' => $defaults['content_link_hover_color'],
			'label' => __( 'Link Hover', 'parvati-premium' ),
			'priority' => 4,
		);
		$content_colors[] = array(
			'slug' => 'content_title_color',
			'default' => $defaults['content_title_color'],
			'label' => __( 'Content Title', 'parvati-premium' ),
			'priority' => 5,
		);
		$content_colors[] = array(
			'slug' => 'blog_header_bg_color',
			'default' => $defaults['blog_header_bg_color'],
			'label' => __( 'Blog Header BG', 'parvati-premium' ),
			'priority' => 6,
		);
		$content_colors[] = array(
			'slug' => 'blog_header_title_color',
			'default' => $defaults['blog_header_title_color'],
			'label' => __( 'Blog Header Text 1', 'parvati-premium' ),
			'priority' => 6,
		);
		$content_colors[] = array(
			'slug' => 'blog_header_text_color',
			'default' => $defaults['blog_header_text_color'],
			'label' => __( 'Blog Header Text 2', 'parvati-premium' ),
			'priority' => 7,
		);
		$content_colors[] = array(
			'slug' => 'blog_header_button',
			'default' => $defaults['blog_header_button'],
			'label' => __( 'Blog Header Button', 'parvati-premium' ),
			'priority' => 8,
		);
		$content_colors[] = array(
			'slug' => 'blog_header_button_bg',
			'default' => $defaults['blog_header_button_bg'],
			'label' => __( 'Blog Header Button BG', 'parvati-premium' ),
			'priority' => 9,
		);
		$content_colors[] = array(
			'slug' => 'blog_header_button_hover',
			'default' => $defaults['blog_header_button_hover'],
			'label' => __( 'Blog Header Button Hover', 'parvati-premium' ),
			'priority' => 10,
		);
		$content_colors[] = array(
			'slug' => 'blog_header_button_hover_bg',
			'default' => $defaults['blog_header_button_hover_bg'],
			'label' => __( 'Blog Header Button Hover BG', 'parvati-premium' ),
			'priority' => 11,
		);
		$content_colors[] = array(
			'slug' => 'blog_post_title_color',
			'default' => $defaults['blog_post_title_color'],
			'label' => __( 'Blog Post Title', 'parvati-premium' ),
			'priority' => 12,
		);
		$content_colors[] = array(
			'slug' => 'blog_post_title_hover_color',
			'default' => $defaults['blog_post_title_hover_color'],
			'label' => __( 'Blog Post Title Hover', 'parvati-premium' ),
			'priority' => 13,
		);
		$content_colors[] = array(
			'slug' => 'entry_meta_text_color',
			'default' => $defaults['entry_meta_text_color'],
			'label' => __( 'Entry Meta Text', 'parvati-premium' ),
			'priority' => 14,
		);
		$content_colors[] = array(
			'slug' => 'entry_meta_link_color',
			'default' => $defaults['entry_meta_link_color'],
			'label' => __( 'Entry Meta Links', 'parvati-premium' ),
			'priority' => 15,
		);
		$content_colors[] = array(
			'slug' => 'entry_meta_link_color_hover',
			'default' => $defaults['entry_meta_link_color_hover'],
			'label' => __( 'Entry Meta Links Hover', 'parvati-premium' ),
			'priority' => 16,
		);
		$content_colors[] = array(
			'slug' => 'h1_color',
			'default' => $defaults['h1_color'],
			'label' => __( 'Heading 1 (H1) Color', 'parvati-premium' ),
			'priority' => 17,
		);
		$content_colors[] = array(
			'slug' => 'h2_color',
			'default' => $defaults['h2_color'],
			'label' => __( 'Heading 2 (H2) Color', 'parvati-premium' ),
			'priority' => 18,
		);
		$content_colors[] = array(
			'slug' => 'h3_color',
			'default' => $defaults['h3_color'],
			'label' => __( 'Heading 3 (H3) Color', 'parvati-premium' ),
			'priority' => 19,
		);

		if ( isset( $defaults['h4_color'] ) ) {
			$content_colors[] = array(
				'slug' => 'h4_color',
				'default' => $defaults['h4_color'],
				'label' => __( 'Heading 4 (H4) Color', 'parvati-premium' ),
				'priority' => 20,
			);
		}

		if ( isset( $defaults['h5_color'] ) ) {
			$content_colors[] = array(
				'slug' => 'h5_color',
				'default' => $defaults['h5_color'],
				'label' => __( 'Heading 5 (H5) Color', 'parvati-premium' ),
				'priority' => 21,
			);
		}

		foreach( $content_colors as $color ) {
			$wp_customize->add_setting(
				'parvati_settings[' . $color['slug'] . ']', array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'content_color_section',
						'settings' => 'parvati_settings[' . $color['slug'] . ']',
						'priority' => $color['priority'],
					)
				)
			);
		}

		// Add Sidebar Widget colors
		$wp_customize->add_section(
			'sidebar_widget_color_section',
			array(
				'title' => __( 'Sidebar Widgets', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 90,
				'panel' => 'parvati_colors_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[sidebar_widget_background_color]',
			array(
				'default'     => $defaults['sidebar_widget_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[sidebar_widget_background_color]',
				array(
					'label'     => __( 'Background', 'parvati-premium' ),
					'section'   => 'sidebar_widget_color_section',
					'settings'  => 'parvati_settings[sidebar_widget_background_color]',
					'palette'   => $palettes,
					'priority' => 1,
				)
			)
		);

		// Add color settings
		$sidebar_widget_colors = array();
		$sidebar_widget_colors[] = array(
			'slug' => 'sidebar_widget_text_color',
			'default' => $defaults['sidebar_widget_text_color'],
			'label' => __( 'Text', 'parvati-premium' ),
			'priority' => 2,
		);
		$sidebar_widget_colors[] = array(
			'slug' => 'sidebar_widget_link_color',
			'default' => $defaults['sidebar_widget_link_color'],
			'label' => __( 'Link', 'parvati-premium' ),
			'priority' => 3,
		);
		$sidebar_widget_colors[] = array(
			'slug' => 'sidebar_widget_link_hover_color',
			'default' => $defaults['sidebar_widget_link_hover_color'],
			'label' => __( 'Link Hover', 'parvati-premium' ),
			'priority' => 4,
		);
		$sidebar_widget_colors[] = array(
			'slug' => 'sidebar_widget_title_color',
			'default' => $defaults['sidebar_widget_title_color'],
			'label' => __( 'Widget Title', 'parvati-premium' ),
			'priority' => 5,
		);

		foreach( $sidebar_widget_colors as $color ) {
			$wp_customize->add_setting(
				'parvati_settings[' . $color['slug'] . ']', array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'sidebar_widget_color_section',
						'settings' => 'parvati_settings[' . $color['slug'] . ']',
						'priority' => $color['priority'],
					)
				)
			);
		}

		// Add Footer widget colors
		$wp_customize->add_section(
			'footer_widget_color_section',
			array(
				'title' => __( 'Footer Widgets', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 100,
				'panel' => 'parvati_colors_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[footer_widget_background_color]',
			array(
				'default'     => $defaults['footer_widget_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[footer_widget_background_color]',
				array(
					'label'     => __( 'Background', 'parvati-premium' ),
					'section'   => 'footer_widget_color_section',
					'settings'  => 'parvati_settings[footer_widget_background_color]',
					'palette'   => $palettes,
					'priority' => 1,
				)
			)
		);

		// Add color settings
		$footer_widget_colors = array();
		$footer_widget_colors[] = array(
			'slug' => 'footer_widget_text_color',
			'default' => $defaults['footer_widget_text_color'],
			'label' => __( 'Text', 'parvati-premium' ),
			'priority' => 2,
		);
		$footer_widget_colors[] = array(
			'slug' => 'footer_widget_link_color',
			'default' => $defaults['footer_widget_link_color'],
			'label' => __( 'Link', 'parvati-premium' ),
			'priority' => 3,
		);
		$footer_widget_colors[] = array(
			'slug' => 'footer_widget_link_hover_color',
			'default' => $defaults['footer_widget_link_hover_color'],
			'label' => __( 'Link Hover', 'parvati-premium' ),
			'priority' => 4,
		);
		$footer_widget_colors[] = array(
			'slug' => 'footer_widget_title_color',
			'default' => $defaults['footer_widget_title_color'],
			'label' => __( 'Widget Title', 'parvati-premium' ),
			'priority' => 5,
		);

		foreach( $footer_widget_colors as $color ) {
			$wp_customize->add_setting(
				'parvati_settings[' . $color['slug'] . ']', array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'footer_widget_color_section',
						'settings' => 'parvati_settings[' . $color['slug'] . ']',
						'priority' => $color['priority'],
					)
				)
			);
		}

		// Add Form colors
		$wp_customize->add_section(
			'form_color_section',
			array(
				'title' => __( 'Forms', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 130,
				'panel' => 'parvati_colors_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[form_background_color]',
			array(
				'default'     => $defaults['form_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[form_background_color]',
				array(
					'label'     => __( 'Form Background', 'parvati-premium' ),
					'section'   => 'form_color_section',
					'settings'  => 'parvati_settings[form_background_color]',
					'palette'   => $palettes,
					'priority' => 1,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[form_background_color_focus]',
			array(
				'default'     => $defaults['form_background_color_focus'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[form_background_color_focus]',
				array(
					'label'     => __( 'Form Background Focus', 'parvati-premium' ),
					'section'   => 'form_color_section',
					'settings'  => 'parvati_settings[form_background_color_focus]',
					'palette'   => $palettes,
					'priority' => 3,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[form_border_color]',
			array(
				'default'     => $defaults['form_border_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[form_border_color]',
				array(
					'label'     => __( 'Form Border', 'parvati-premium' ),
					'section'   => 'form_color_section',
					'settings'  => 'parvati_settings[form_border_color]',
					'palette'   => $palettes,
					'priority' => 5,
				)
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[form_border_color_focus]',
			array(
				'default'     => $defaults['form_border_color_focus'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[form_border_color_focus]',
				array(
					'label'     => __( 'Form Border Focus', 'parvati-premium' ),
					'section'   => 'form_color_section',
					'settings'  => 'parvati_settings[form_border_color_focus]',
					'palette'   => $palettes,
					'priority' => 6,
				)
			)
		);

		// Add color settings
		$form_colors = array();
		$form_colors[] = array(
			'slug' => 'form_text_color',
			'default' => $defaults['form_text_color'],
			'label' => __( 'Form Text', 'parvati-premium' ),
			'priority' => 2,
		);
		$form_colors[] = array(
			'slug' => 'form_text_color_focus',
			'default' => $defaults['form_text_color_focus'],
			'label' => __( 'Form Text Focus', 'parvati-premium' ),
			'priority' => 4,
		);

		foreach( $form_colors as $color ) {
			$wp_customize->add_setting(
				'parvati_settings[' . $color['slug'] . ']', array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'form_color_section',
						'settings' => 'parvati_settings[' . $color['slug'] . ']',
						'priority' => $color['priority'],
					)
				)
			);
		}

		// Add Footer colors
		$wp_customize->add_section(
			'footer_color_section',
			array(
				'title' => __( 'Footer', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 150,
				'panel' => 'parvati_colors_panel',
			)
		);

		$wp_customize->add_setting(
			'parvati_settings[footer_background_color]',
			array(
				'default'     => $defaults['footer_background_color'],
				'type'        => 'option',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'parvati_premium_sanitize_rgba',
			)
		);

		$wp_customize->add_control(
			new Parvati_Alpha_Color_Customize_Control(
				$wp_customize,
				'parvati_settings[footer_background_color]',
				array(
					'label'     => __( 'Background', 'parvati-premium' ),
					'section'   => 'footer_color_section',
					'settings'  => 'parvati_settings[footer_background_color]',
					'palette'   => $palettes,
					'priority' => 1,
				)
			)
		);

		// Add color settings
		$footer_colors = array();
		$footer_colors[] = array(
			'slug' => 'footer_text_color',
			'default' => $defaults['footer_text_color'],
			'label' => __( 'Text', 'parvati-premium' ),
			'priority' => 2,
		);
		$footer_colors[] = array(
			'slug' => 'footer_link_color',
			'default' => $defaults['footer_link_color'],
			'label' => __( 'Link', 'parvati-premium' ),
			'priority' => 3,
		);
		$footer_colors[] = array(
			'slug' => 'footer_link_hover_color',
			'default' => $defaults['footer_link_hover_color'],
			'label' => __( 'Link Hover', 'parvati-premium' ),
			'priority' => 4,
		);

		foreach( $footer_colors as $color ) {
			$wp_customize->add_setting(
				'parvati_settings[' . $color['slug'] . ']', array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_hex_color',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'footer_color_section',
						'settings' => 'parvati_settings[' . $color['slug'] . ']',
						'priority' => $color['priority'],
					)
				)
			);
		}

		if ( isset( $defaults['back_to_top_background_color'] ) ) {
			$wp_customize->add_control(
				new Parvati_Title_Customize_Control(
					$wp_customize,
					'parvati_back_to_top_title',
					array(
						'section' => 'footer_color_section',
						'type' => 'parvati-customizer-title',
						'title' => __( 'Back to Top Button', 'parvati-premium' ),
						'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
					)
				)
			);

			$wp_customize->add_setting(
				'parvati_settings[back_to_top_background_color]', array(
					'default' => $defaults['back_to_top_background_color'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_rgba',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new Parvati_Alpha_Color_Customize_Control(
					$wp_customize,
					'parvati_settings[back_to_top_background_color]',
					array(
						'label' => __( 'Background', 'parvati-premium' ),
						'section' => 'footer_color_section',
						'settings' => 'parvati_settings[back_to_top_background_color]',
						'palette' => $palettes,
					)
				)
			);

			$wp_customize->add_setting(
				'parvati_settings[back_to_top_text_color]', array(
					'default' => $defaults['back_to_top_text_color'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_rgba',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'parvati_settings[back_to_top_text_color]',
					array(
						'label' => __( 'Text', 'parvati-premium' ),
						'section' => 'footer_color_section',
						'settings' => 'parvati_settings[back_to_top_text_color]',
					)
				)
			);

			$wp_customize->add_setting(
				'parvati_settings[back_to_top_background_color_hover]', array(
					'default' => $defaults['back_to_top_background_color_hover'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_rgba',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new Parvati_Alpha_Color_Customize_Control(
					$wp_customize,
					'parvati_settings[back_to_top_background_color_hover]',
					array(
						'label'     => __( 'Background Hover', 'parvati-premium' ),
						'section'   => 'footer_color_section',
						'settings'  => 'parvati_settings[back_to_top_background_color_hover]',
						'palette'   => $palettes,
					)
				)
			);

			$wp_customize->add_setting(
				'parvati_settings[back_to_top_text_color_hover]', array(
					'default' => $defaults['back_to_top_text_color_hover'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'parvati_premium_sanitize_rgba',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'parvati_settings[back_to_top_text_color_hover]',
					array(
						'label' => __( 'Text Hover', 'parvati-premium' ),
						'section' => 'footer_color_section',
						'settings' => 'parvati_settings[back_to_top_text_color_hover]',
					)
				)
			);
		}
	}
}

if ( ! function_exists( 'parvati_get_color_setting' ) ) {
	/**
	 * Wrapper function to get our settings
	 *
	 */
	function parvati_get_color_setting( $setting ) {

		// Bail if we don't have our color defaults
		if ( ! function_exists( 'parvati_get_color_defaults' ) ) {
			return;
		}

		if ( function_exists( 'parvati_get_defaults' ) ) {
			$defaults = array_merge( parvati_get_defaults(), parvati_get_color_defaults()  );
		} else {
			$defaults = parvati_get_color_defaults();
		}

		$parvati_settings = wp_parse_args(
			get_option( 'parvati_settings', array() ),
			$defaults
		);

		return $parvati_settings[ $setting ];
	}
}

if ( ! function_exists( 'parvati_colors_rgba_to_hex' ) ) {
	/**
	 * Convert RGBA to hex if necessary 
	 */
	function parvati_colors_rgba_to_hex( $rgba ) {
		// If it's not rgba, return it
		if ( false === strpos( $rgba, 'rgba' ) ) {
			return $rgba;
		}

		return substr( $rgba, 0, strrpos( $rgba, ',' ) ) . ')';
	}
}

if ( ! function_exists( 'parvati_enqueue_color_palettes' ) ) {
	add_action( 'customize_controls_enqueue_scripts', 'parvati_enqueue_color_palettes', 1001 );
	/**
	 * Add our custom color palettes to the color pickers in the Customizer.
	 * Hooks into 1001 priority to show up after Secondary Nav.
	 *
	 */
	function parvati_enqueue_color_palettes() {
		// Old versions of WP don't get nice things
		if ( ! function_exists( 'wp_add_inline_script' ) ) {
			return;
		}

		// Grab our palette array and turn it into JS
		$palettes = json_encode( parvati_get_default_color_palettes() );

		// Add our custom palettes
		// json_encode takes care of escaping
		wp_add_inline_script( 'wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . $palettes . ';' );
	}
}

if ( ! function_exists( 'parvati_colors_customizer_live_preview' ) ) {
	add_action( 'customize_preview_init', 'parvati_colors_customizer_live_preview' );
	/**
	 * Add our live preview javascript.
	 *
	 */
	function parvati_colors_customizer_live_preview() {
		wp_enqueue_script(
			  'parvati-colors-customizer',
			  trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/customizer.js',
			  array( 'jquery','customize-preview' ),
			  PARVATI_COLORS_VERSION,
			  true
		);

		wp_register_script(
			  'parvati-wc-colors-customizer',
			  trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/wc-customizer.js',
			  array( 'jquery','customize-preview', 'parvati-colors-customizer' ),
			  PARVATI_COLORS_VERSION,
			  true
		);

		wp_register_script(
			  'parvati-menu-plus-colors-customizer',
			  trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/menu-plus-customizer.js',
			  array( 'jquery','customize-preview', 'parvati-colors-customizer' ),
			  PARVATI_COLORS_VERSION,
			  true
		);
	}
}
