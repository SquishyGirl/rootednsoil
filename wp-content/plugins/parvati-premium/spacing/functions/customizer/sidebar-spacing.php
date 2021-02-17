<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add our old Sidebars section
// This section is no longer used but is kept around for back compat
$wp_customize->add_section(
	'parvati_spacing_sidebar',
	array(
		'title' => __( 'Sidebars', 'parvati-premium' ),
		'capability' => 'edit_theme_options',
		'priority' => 15,
		'panel' => 'parvati_spacing_panel'
	)
);

// Add our controls to the Layout panel if it exists
// If not, use the old section
$widget_section = ( $wp_customize->get_panel( 'parvati_layout_panel' ) ) ? 'parvati_layout_sidebars' : 'parvati_spacing_sidebar';

// Widget padding top
$wp_customize->add_setting( 'parvati_spacing_settings[widget_top]',
	array(
		'default' => $defaults['widget_top'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Widget padding right
$wp_customize->add_setting( 'parvati_spacing_settings[widget_right]',
	array(
		'default' => $defaults['widget_right'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Widget padding bottom
$wp_customize->add_setting( 'parvati_spacing_settings[widget_bottom]',
	array(
		'default' => $defaults['widget_bottom'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Widget padding left
$wp_customize->add_setting( 'parvati_spacing_settings[widget_left]',
	array(
		'default' => $defaults['widget_left'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Make use of the widget padding settings
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'widget_spacing',
		array(
			'type' 		 => 'parvati-spacing',
			'label'      => esc_html__( 'Widget Padding', 'parvati-premium' ),
			'section'    => $widget_section,
			'settings'   => array(
				'top'    => 'parvati_spacing_settings[widget_top]',
				'right'  => 'parvati_spacing_settings[widget_right]',
				'bottom' => 'parvati_spacing_settings[widget_bottom]',
				'left'   => 'parvati_spacing_settings[widget_left]'
			),
			'element'	 => 'widget',
			'priority'   => 99
		)
	)
);


// Left sidebar width
$wp_customize->add_setting(
	'parvati_spacing_settings[left_sidebar_width]', array(
		'default' => $defaults['left_sidebar_width'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_spacing_settings[left_sidebar_width]',
		array(
			'label' => esc_html__( 'Left Sidebar Width', 'parvati-premium' ),
			'section' => $widget_section,
			'settings' => array(
				'desktop' => 'parvati_spacing_settings[left_sidebar_width]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 15,
					'max' => 50,
					'step' => 5,
					'edit' => false,
					'unit' => '%',
				),
			),
			'priority' => 125,
		)
	)
);

// Right sidebar width
$wp_customize->add_setting(
	'parvati_spacing_settings[right_sidebar_width]', array(
		'default' => $defaults['right_sidebar_width'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_spacing_settings[right_sidebar_width]',
		array(
			'label' => esc_html__( 'Right Sidebar Width', 'parvati-premium' ),
			'section' => $widget_section,
			'settings' => array(
				'desktop' => 'parvati_spacing_settings[right_sidebar_width]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 15,
					'max' => 50,
					'step' => 5,
					'edit' => false,
					'unit' => '%',
				),
			),
			'priority' => 125,
		)
	)
);
