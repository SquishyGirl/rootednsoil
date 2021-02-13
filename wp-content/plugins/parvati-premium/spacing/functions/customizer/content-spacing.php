<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add our old Spacing section
$wp_customize->add_section(
	'parvati_spacing_content',
	array(
		'title' => __( 'Content', 'parvati-premium' ),
		'capability' => 'edit_theme_options',
		'priority' => 10,
		'panel' => 'parvati_spacing_panel'
	)
);

// If we don't have a layout panel, use our old spacing section
if ( $wp_customize->get_panel( 'parvati_layout_panel' ) ) {
	$content_section = 'parvati_layout_container';
} else {
	$content_section = 'parvati_spacing_content';
}

// Take control of the container width control
// This control is handled by the free theme, but we take control of it here for consistency between control styles
$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_settings[container_width]',
		array(
			'label' => __( 'Container Width', 'parvati-premium' ),
			'section' => 'parvati_layout_container',
			'settings' => array(
				'desktop' => 'parvati_settings[container_width]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 700,
					'max' => 2000,
					'step' => 5,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 0,
		)
	)
);

// Separating space
$wp_customize->add_setting(
	'parvati_spacing_settings[separator]', array(
		'default' => $defaults['separator'],
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

$wp_customize->add_control(
	new Parvati_Pro_Range_Slider_Control(
		$wp_customize,
		'parvati_spacing_settings[separator]',
		array(
			'label' => __( 'Separating Space', 'parvati-premium' ),
			'section' => $content_section,
			'settings' => array(
				'desktop' => 'parvati_spacing_settings[separator]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Content padding top
$wp_customize->add_setting( 'parvati_spacing_settings[content_top]',
	array(
		'default' => $defaults['content_top'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Content padding right
$wp_customize->add_setting( 'parvati_spacing_settings[content_right]',
	array(
		'default' => $defaults['content_right'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Content padding bottom
$wp_customize->add_setting( 'parvati_spacing_settings[content_bottom]',
	array(
		'default' => $defaults['content_bottom'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Content padding left
$wp_customize->add_setting( 'parvati_spacing_settings[content_left]',
	array(
		'default' => $defaults['content_left'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Make use of the content padding settings
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'content_spacing',
		array(
			'type' 		 => 'parvati-spacing',
			'label'      => esc_html__( 'Content Padding', 'parvati-premium' ),
			'section'    => $content_section,
			'settings'   => array(
				'top'    => 'parvati_spacing_settings[content_top]',
				'right'  => 'parvati_spacing_settings[content_right]',
				'bottom' => 'parvati_spacing_settings[content_bottom]',
				'left'   => 'parvati_spacing_settings[content_left]'
			),
			'element'	 => 'content',
			'priority'   => 99
		)
	)
);

// If mobile_content_top is set, the rest of them are too
// We have to check as these defaults are set in the theme
if ( isset( $defaults[ 'mobile_content_top' ] ) ) {
	// Mobile content padding top
	$wp_customize->add_setting( 'parvati_spacing_settings[mobile_content_top]',
		array(
			'default' => $defaults['mobile_content_top'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	// Content padding right
	$wp_customize->add_setting( 'parvati_spacing_settings[mobile_content_right]',
		array(
			'default' => $defaults['mobile_content_right'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	// Content padding bottom
	$wp_customize->add_setting( 'parvati_spacing_settings[mobile_content_bottom]',
		array(
			'default' => $defaults['mobile_content_bottom'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	// Content padding left
	$wp_customize->add_setting( 'parvati_spacing_settings[mobile_content_left]',
		array(
			'default' => $defaults['mobile_content_left'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	// Make use of the content padding settings
	$wp_customize->add_control(
		new Parvati_Spacing_Control(
			$wp_customize,
			'mobile_content_spacing',
			array(
				'type' 		 => 'parvati-spacing',
				'label'      => esc_html__( 'Mobile Content Padding', 'parvati-premium' ),
				'section'    => $content_section,
				'settings'   => array(
					'top'    => 'parvati_spacing_settings[mobile_content_top]',
					'right'  => 'parvati_spacing_settings[mobile_content_right]',
					'bottom' => 'parvati_spacing_settings[mobile_content_bottom]',
					'left'   => 'parvati_spacing_settings[mobile_content_left]'
				),
				'element'	 => 'mobile_content',
				'priority'   => 100
			)
		)
	);
}

// Side padding top
$wp_customize->add_setting( 'parvati_spacing_settings[side_top]',
	array(
		'default' => $defaults['side_top'],
		'type' => 'option',
		'sanitize_callback' => 'absint'
	)
);

// Side padding right
$wp_customize->add_setting( 'parvati_spacing_settings[side_right]',
	array(
		'default' => $defaults['side_right'],
		'type' => 'option',
		'sanitize_callback' => 'absint'
	)
);

// Side padding bottom
$wp_customize->add_setting( 'parvati_spacing_settings[side_bottom]',
	array(
		'default' => $defaults['side_bottom'],
		'type' => 'option',
		'sanitize_callback' => 'absint'
	)
);

// Side padding left
$wp_customize->add_setting( 'parvati_spacing_settings[side_left]',
	array(
		'default' => $defaults['side_left'],
		'type' => 'option',
		'sanitize_callback' => 'absint'
	)
);

// Make use of the side padding settings
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'side_spacing',
		array(
			'type' 		 => 'parvati-spacing',
			'label'      => esc_html__( 'Side Padding', 'parvati-premium' ),
			'section'    => $content_section,
			'settings'   => array(
				'top'    => 'parvati_spacing_settings[side_top]',
				'right'  => 'parvati_spacing_settings[side_right]',
				'bottom' => 'parvati_spacing_settings[side_bottom]',
				'left'   => 'parvati_spacing_settings[side_left]'
			),
			'element'	 => 'side_padding',
			'priority'   => 101
		)
	)
);

// Mobile side padding top
$wp_customize->add_setting( 'parvati_spacing_settings[mobile_side_top]',
	array(
		'default' => $defaults['mobile_side_top'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Side padding right
$wp_customize->add_setting( 'parvati_spacing_settings[mobile_side_right]',
	array(
		'default' => $defaults['mobile_side_right'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Side padding bottom
$wp_customize->add_setting( 'parvati_spacing_settings[mobile_side_bottom]',
	array(
		'default' => $defaults['mobile_side_bottom'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Side padding left
$wp_customize->add_setting( 'parvati_spacing_settings[mobile_side_left]',
	array(
		'default' => $defaults['mobile_side_left'],
		'type' => 'option',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage'
	)
);

// Make use of the side padding settings
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'mobile_side_spacing',
		array(
			'type' 		 => 'parvati-spacing',
			'label'      => esc_html__( 'Mobile Side Padding', 'parvati-premium' ),
			'section'    => $content_section,
			'settings'   => array(
				'top'    => 'parvati_spacing_settings[mobile_side_top]',
				'right'  => 'parvati_spacing_settings[mobile_side_right]',
				'bottom' => 'parvati_spacing_settings[mobile_side_bottom]',
				'left'   => 'parvati_spacing_settings[mobile_side_left]'
			),
			'element'	 => 'mobile_side_padding',
			'priority'   => 102
		)
	)
);