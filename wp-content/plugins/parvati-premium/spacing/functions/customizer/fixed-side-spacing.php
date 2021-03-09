<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Margin top
$wp_customize->add_setting( 'parvati_spacing_settings[fixed_side_margin_top]',
	array(
		'default' 			=> $defaults['fixed_side_margin_top'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
	)
);

// Margin right
$wp_customize->add_setting( 'parvati_spacing_settings[fixed_side_margin_right]',
	array(
		'default' 			=> $defaults['fixed_side_margin_right'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
	)
);

// Margin bottom
$wp_customize->add_setting( 'parvati_spacing_settings[fixed_side_margin_bottom]',
	array(
		'default' 			=> $defaults['fixed_side_margin_bottom'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
	)
);

// Margin left
$wp_customize->add_setting( 'parvati_spacing_settings[fixed_side_margin_left]',
	array(
		'default' 			=> $defaults['fixed_side_margin_left'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
	)
);

// Do something with our fixed side controls
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'fixed_side_margin_spacing',
		array(
			'type' => 'parvati-spacing',
			'label'       => esc_html__( 'Fixed Side Margin', 'parvati-premium' ),
			'section'     => 'parvati_layout_sidecontent',
			'settings'    => array(
				'top'     => 'parvati_spacing_settings[fixed_side_margin_top]',
				'right'   => 'parvati_spacing_settings[fixed_side_margin_right]',
				'bottom'  => 'parvati_spacing_settings[fixed_side_margin_bottom]',
				'left'    => 'parvati_spacing_settings[fixed_side_margin_left]'
			),
		)
	)
);

// Padding top
$wp_customize->add_setting( 'parvati_spacing_settings[fixed_side_top]',
	array(
		'default' 			=> $defaults['fixed_side_top'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
	)
);

// Padding right
$wp_customize->add_setting( 'parvati_spacing_settings[fixed_side_right]',
	array(
		'default' 			=> $defaults['fixed_side_right'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
	)
);

// Padding bottom
$wp_customize->add_setting( 'parvati_spacing_settings[fixed_side_bottom]',
	array(
		'default' 			=> $defaults['fixed_side_bottom'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
	)
);

// Padding left
$wp_customize->add_setting( 'parvati_spacing_settings[fixed_side_left]',
	array(
		'default' 			=> $defaults['fixed_side_left'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
	)
);

// Do something with our fixed side controls
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'fixed_side_spacing',
		array(
			'type' => 'parvati-spacing',
			'label'       => esc_html__( 'Fixed Side Padding', 'parvati-premium' ),
			'section'     => 'parvati_layout_sidecontent',
			'settings'    => array(
				'top'     => 'parvati_spacing_settings[fixed_side_top]',
				'right'   => 'parvati_spacing_settings[fixed_side_right]',
				'bottom'  => 'parvati_spacing_settings[fixed_side_bottom]',
				'left'    => 'parvati_spacing_settings[fixed_side_left]'
			),
		)
	)
);
