<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add our old navigation section
$wp_customize->add_section(
	'parvati_spacing_navigation',
	array(
		'title' => __( 'Primary Navigation', 'parvati-premium' ),
		'capability' => 'edit_theme_options',
		'priority' => 15,
		'panel' => 'parvati_spacing_panel'
	)
);

// If our new Layout section doesn't exist, use the old navigation section
$navigation_section = ( $wp_customize->get_panel( 'parvati_layout_panel' ) ) ? 'parvati_layout_navigation' : 'parvati_spacing_navigation';

// Menu item width
$wp_customize->add_setting(
	'parvati_spacing_settings[menu_item]', array(
		'default' => $defaults['menu_item'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_setting(
	'parvati_spacing_settings[mobile_menu_item]', array(
		'default' => $defaults['mobile_menu_item'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'parvati_premium_sanitize_empty_absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_spacing_settings[menu_item]',
		array(
			'label' => __( 'Menu Item Width', 'parvati-premium' ),
			'section' => $navigation_section,
			'settings' => array(
				'desktop' => 'parvati_spacing_settings[menu_item]',
				'mobile' => 'parvati_spacing_settings[mobile_menu_item]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile' => array(
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 220,
		)
	)
);

// Menu item height
$wp_customize->add_setting(
	'parvati_spacing_settings[menu_item_height]', array(
		'default' => $defaults['menu_item_height'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_setting(
	'parvati_spacing_settings[mobile_menu_item_height]', array(
		'default' => $defaults['mobile_menu_item_height'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'parvati_premium_sanitize_empty_absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_spacing_settings[menu_item_height]',
		array(
			'label' => __( 'Menu Item Height', 'parvati-premium' ),
			'section' => $navigation_section,
			'settings' => array(
				'desktop' => 'parvati_spacing_settings[menu_item_height]',
				'mobile' => 'parvati_spacing_settings[mobile_menu_item_height]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 20,
					'max' => 150,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile' => array(
					'min' => 20,
					'max' => 150,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 240,
		)
	)
);

// Sub-menu item height
$wp_customize->add_setting(
	'parvati_spacing_settings[sub_menu_item_height]', array(
		'default' => $defaults['sub_menu_item_height'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_spacing_settings[sub_menu_item_height]',
		array(
			'label' => __( 'Sub-Menu Item Height', 'parvati-premium' ),
			'section' => $navigation_section,
			'settings' => array(
				'desktop' => 'parvati_spacing_settings[sub_menu_item_height]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 0,
					'max' => 50,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 260,
		)
	)
);

// Sticky menu height
$wp_customize->add_setting(
	'parvati_spacing_settings[sticky_menu_item_height]', array(
		'default' => $defaults['sticky_menu_item_height'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'parvati_premium_sanitize_empty_absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_spacing_settings[sticky_menu_item_height]',
		array(
			'label' => __( 'Menu Item Height', 'parvati-premium' ),
			'section' => 'menu_plus_sticky_menu',
			'settings' => array(
				'desktop' => 'parvati_spacing_settings[sticky_menu_item_height]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 20,
					'max' => 150,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 150,
			'active_callback' => 'parvati_sticky_navigation_activated',
		)
	)
);

// Off canvas menu height
$wp_customize->add_setting(
	'parvati_spacing_settings[off_canvas_menu_item_height]', array(
		'default' => $defaults['off_canvas_menu_item_height'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'parvati_premium_sanitize_empty_absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_spacing_settings[off_canvas_menu_item_height]',
		array(
			'label' => __( 'Menu Item Height', 'parvati-premium' ),
			'section' => 'menu_plus_slideout_menu',
			'settings' => array(
				'desktop' => 'parvati_spacing_settings[off_canvas_menu_item_height]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 20,
					'max' => 150,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 200,
			'active_callback' => 'parvati_slideout_navigation_activated',
		)
	)
);
