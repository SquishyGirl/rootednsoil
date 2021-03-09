<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add our section
// This isn't used anymore if the Layout panel exists
$wp_customize->add_section(
	'parvati_spacing_footer',
	array(
		'title' => __( 'Footer', 'parvati-premium' ),
		'capability' => 'edit_theme_options',
		'priority' => 20,
		'panel' => 'parvati_spacing_panel'
	)
);

// Use our layout panel if it exists
if ( $wp_customize->get_panel( 'parvati_layout_panel' ) ) {
	$footer_section = 'parvati_layout_footer';
} else {
	$footer_section = 'parvati_spacing_footer';
}

// Footer widget area padding top
$wp_customize->add_setting( 'parvati_spacing_settings[footer_widget_container_top]',
	array(
		'default' => $defaults['footer_widget_container_top'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Footer widget area padding right
$wp_customize->add_setting( 'parvati_spacing_settings[footer_widget_container_right]',
	array(
		'default' => $defaults['footer_widget_container_right'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Footer widget area padding bottom
$wp_customize->add_setting( 'parvati_spacing_settings[footer_widget_container_bottom]',
	array(
		'default' => $defaults['footer_widget_container_bottom'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Footer widget area padding left
$wp_customize->add_setting( 'parvati_spacing_settings[footer_widget_container_left]',
	array(
		'default' => $defaults['footer_widget_container_left'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Make use of the Footer widget area padding settings
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'footer_widget_area_spacing',
		array(
			'type' 		 => 'parvati-spacing',
			'label'      => esc_html__( 'Footer Widget Area Padding', 'parvati-premium' ),
			'section'    => $footer_section,
			'settings'   => array(
				'top'    => 'parvati_spacing_settings[footer_widget_container_top]',
				'right'  => 'parvati_spacing_settings[footer_widget_container_right]',
				'bottom' => 'parvati_spacing_settings[footer_widget_container_bottom]',
				'left'   => 'parvati_spacing_settings[footer_widget_container_left]'
			),
			'element'	 => 'footer_widget_area',
			'priority'   => 99
		)
	)
);

// Footer padding top
$wp_customize->add_setting( 'parvati_spacing_settings[footer_top]',
	array(
		'default' => $defaults['footer_top'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Footer padding right
$wp_customize->add_setting( 'parvati_spacing_settings[footer_right]',
	array(
		'default' => $defaults['footer_right'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Footer padding bottom
$wp_customize->add_setting( 'parvati_spacing_settings[footer_bottom]',
	array(
		'default' => $defaults['footer_bottom'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Footer padding left
$wp_customize->add_setting( 'parvati_spacing_settings[footer_left]',
	array(
		'default' => $defaults['footer_left'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Make use of the footer padding settings
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'footer_spacing',
		array(
			'type' 		 => 'parvati-spacing',
			'label'      => esc_html__( 'Footer Padding', 'parvati-premium' ),
			'section'    => $footer_section,
			'settings'   => array(
				'top'    => 'parvati_spacing_settings[footer_top]',
				'right'  => 'parvati_spacing_settings[footer_right]',
				'bottom' => 'parvati_spacing_settings[footer_bottom]',
				'left'   => 'parvati_spacing_settings[footer_left]'
			),
			'element'	 => 'footer',
			'priority'   => 105
		)
	)
);
