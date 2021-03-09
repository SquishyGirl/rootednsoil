<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $defaults[ 'top_bar_top' ] ) ) {
	// Widget padding top
	$wp_customize->add_setting( 'parvati_spacing_settings[top_bar_top]',
		array(
			'default' => $defaults['top_bar_top'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	// Widget padding right
	$wp_customize->add_setting( 'parvati_spacing_settings[top_bar_right]',
		array(
			'default' => $defaults['top_bar_right'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	// Widget padding bottom
	$wp_customize->add_setting( 'parvati_spacing_settings[top_bar_bottom]',
		array(
			'default' => $defaults['top_bar_bottom'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	// Widget padding left
	$wp_customize->add_setting( 'parvati_spacing_settings[top_bar_left]',
		array(
			'default' => $defaults['top_bar_left'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);

	// Make use of the widget padding settings
	$wp_customize->add_control(
		new Parvati_Spacing_Control(
			$wp_customize,
			'top_bar_spacing',
			array(
				'type' 		 => 'parvati-spacing',
				'label'      => esc_html__( 'Top Bar Padding', 'parvati-premium' ),
				'section'    => 'parvati_top_bar',
				'settings'   => array(
					'top'    => 'parvati_spacing_settings[top_bar_top]',
					'right'  => 'parvati_spacing_settings[top_bar_right]',
					'bottom' => 'parvati_spacing_settings[top_bar_bottom]',
					'left'   => 'parvati_spacing_settings[top_bar_left]'
				),
				'element'	 => 'top_bar',
				'priority'   => 99,
				'active_callback' => 'parvati_premium_is_top_bar_active',
			)
		)
	);
}
