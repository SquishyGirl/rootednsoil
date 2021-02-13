<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$header_section = 'parvati_layout_header';

// Header top
$wp_customize->add_setting( 'parvati_spacing_settings[header_top]',
	array(
		'default' 			=> $defaults['header_top'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
		'transport' 		=> 'postMessage'
	)
);

// Header right
$wp_customize->add_setting( 'parvati_spacing_settings[header_right]',
	array(
		'default' 			=> $defaults['header_right'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
		'transport' 		=> 'postMessage'
	)
);

// Header bottom
$wp_customize->add_setting( 'parvati_spacing_settings[header_bottom]',
	array(
		'default' 			=> $defaults['header_bottom'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
		'transport' 		=> 'postMessage'
	)
);

// Header left
$wp_customize->add_setting( 'parvati_spacing_settings[header_left]',
	array(
		'default' 			=> $defaults['header_left'],
		'type' 				=> 'option',
		'sanitize_callback' => 'absint',
		'transport' 		=> 'postMessage'
	)
);

// Do something with our header controls
$wp_customize->add_control(
	new Parvati_Spacing_Control(
		$wp_customize,
		'header_spacing',
		array(
			'type' => 'parvati-spacing',
			'label'       => esc_html__( 'Header Padding', 'parvati-premium' ),
			'section'     => $header_section,
			'settings'    => array(
				'top'     => 'parvati_spacing_settings[header_top]',
				'right'   => 'parvati_spacing_settings[header_right]',
				'bottom'  => 'parvati_spacing_settings[header_bottom]',
				'left'    => 'parvati_spacing_settings[header_left]'
			),
			'element'	  => 'header',
		)
	)
);
