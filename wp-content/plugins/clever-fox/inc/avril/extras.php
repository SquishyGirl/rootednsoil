<?php
/*
 *
 * Social Icon
 */
function avril_get_social_icon_default() {
	return apply_filters(
		'avril_get_social_icon_default', json_encode(
				 array(
				array(
					'icon_value'	  =>  esc_html__( 'fa-facebook', 'avril' ),
					'link'	  =>  esc_html__( '#', 'avril' ),
					'id'              => 'customizer_repeater_header_social_001',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-google-plus', 'avril' ),
					'link'	  =>  esc_html__( '#', 'avril' ),
					'id'              => 'customizer_repeater_header_social_002',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-twitter', 'avril' ),
					'link'	  =>  esc_html__( '#', 'avril' ),
					'id'              => 'customizer_repeater_header_social_003',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-linkedin', 'avril' ),
					'link'	  =>  esc_html__( '#', 'avril' ),
					'id'              => 'customizer_repeater_header_social_004',
				),
				array(
					'icon_value'	  =>  esc_html__( 'fa-behance', 'avril' ),
					'link'	  =>  esc_html__( '#', 'avril' ),
					'id'              => 'customizer_repeater_header_social_005',
				),
			)
		)
	);
}


/*
 *
 * Slider Default
 */
 function avril_get_slider_default() {
	return apply_filters(
		'avril_get_slider_default', json_encode(
				 array(
				array(
					'image_url'       => CLEVERFOX_PLUGIN_URL .'inc/avril/images/slider/img01.jpg',
					'title'           => esc_html__( 'Global Project Managment', 'avril' ),
					'subtitle'         => esc_html__( 'Services & Solutions', 'avril' ),
					'text'            => esc_html__( 'There are many variations of passages of Lorem Ipsum available but the majority have suffered injected humour dummy now.', 'avril' ),
					'text2'	  =>  esc_html__( 'Get Started', 'avril' ),
					'link'	  =>  esc_html__( '#', 'avril' ),
					'button_second'	  =>  esc_html__( 'Read More', 'avril' ),
					'link2'	  =>  esc_html__( '#', 'avril' ),
					"slide_align" => "left", 
					'id'              => 'customizer_repeater_slider_001',
				),
				array(
					'image_url'       => CLEVERFOX_PLUGIN_URL .'inc/avril/images/slider/img02.jpg',
					'title'           => esc_html__( 'Develop Stronger Minds', 'avril' ),
					'subtitle'         => esc_html__( 'Better Coaching Gets', 'avril' ),
					'text'            => esc_html__( 'There are many variations of passages of Lorem Ipsum available but the majority have suffered injected humour dummy now.', 'avril' ),
					'text2'	  =>  esc_html__( 'Get Started', 'avril' ),
					'link'	  =>  esc_html__( '#', 'avril' ),
					'button_second'	  =>  esc_html__( 'Read More', 'avril' ),
					'link2'	  =>  esc_html__( '#', 'avril' ),
					"slide_align" => "center", 
					'id'              => 'customizer_repeater_slider_002',
				),
				array(
					'image_url'       => CLEVERFOX_PLUGIN_URL .'inc/avril/images/slider/img03.jpg',
					'title'           => esc_html__( 'Industry Analysis', 'avril' ),
					'subtitle'         => esc_html__( 'Marketing & Strategy', 'avril' ),
					'text'            => esc_html__( 'There are many variations of passages of Lorem Ipsum available but the majority have suffered injected humour dummy now.', 'avril' ),
					'text2'	  =>  esc_html__( 'Get Started', 'avril' ),
					'link'	  =>  esc_html__( '#', 'avril' ),
					'button_second'	  =>  esc_html__( 'Read More', 'avril' ),
					'link2'	  =>  esc_html__( '#', 'avril' ),
					"slide_align" => "right", 
					'id'              => 'customizer_repeater_slider_003',
			
				),
			)
		)
	);
}


/*
 *
 * Service Default
 */
 function avril_get_service_default() {
	return apply_filters(
		'avril_get_service_default', json_encode(
				 array(
				array(
					'title'           => esc_html__( 'Well Documented', 'avril' ),
					'text'            => esc_html__( 'Lorem Ipsum is simply dummy of printing and typesetting and industry. Lorem Ipsum been.', 'avril' ),
					'icon_value'       => 'fa-folder-open-o',
					'id'              => 'customizer_repeater_service_001',
					
				),
				array(
					'title'           => esc_html__( 'Simple To Use', 'avril' ),
					'text'            => esc_html__( 'Lorem Ipsum is simply dummy of printing and typesetting and industry. Lorem Ipsum been.', 'avril' ),
					'icon_value'       => 'fa-list',
					'id'              => 'customizer_repeater_service_002',				
				),
				array(
					'title'           => esc_html__( 'High Performance', 'avril' ),
					'text'            => esc_html__( 'Lorem Ipsum is simply dummy of printing and typesetting and industry. Lorem Ipsum been.', 'avril' ),
					'icon_value'       => 'fa-rocket',
					'id'              => 'customizer_repeater_service_003',
				),
			)
		)
	);
}


/*
 *
 * Features Default
 */
 function avril_get_features_default() {
	return apply_filters(
		'avril_get_features_default', json_encode(
				 array(
				array(
					'title'           => esc_html__( 'Business Growth', 'avril' ),
					'text'            => esc_html__( 'Many variations of at Lorem Ipsum but the majority have suffered. Lorem Ipsum the majority suffered.', 'avril' ),
					'icon_value'       => 'fa-bar-chart',
					'id'              => 'customizer_repeater_features_001',
					
				),
				array(
					'title'           => esc_html__( 'Business Sustainability', 'avril' ),
					'text'            => esc_html__( 'Many variations of at Lorem Ipsum but the majority have suffered. Lorem Ipsum the majority suffered.', 'avril' ),
					'icon_value'       => 'fa-connectdevelop',
					'id'              => 'customizer_repeater_features_002',			
				),
				array(
					'title'           => esc_html__( 'Business Performance', 'avril' ),
					'text'            => esc_html__( 'Many variations of at Lorem Ipsum but the majority have suffered. Lorem Ipsum the majority suffered.', 'avril' ),
					'icon_value'       => 'fa-tachometer',
					'id'              => 'customizer_repeater_features_003',
				),
				array(
					'title'           => esc_html__( 'Business Organization', 'avril' ),
					'text'            => esc_html__( 'Many variations of at Lorem Ipsum but the majority have suffered. Lorem Ipsum the majority suffered.', 'avril' ),
					'icon_value'       => 'fa-user-secret',
					'id'              => 'customizer_repeater_features_004',
				),
				array(
					'title'           => esc_html__( 'Dedicated Teams', 'avril' ),
					'text'            => esc_html__( 'Many variations of at Lorem Ipsum but the majority have suffered. Lorem Ipsum the majority suffered.', 'avril' ),
					'icon_value'       => 'fa-folder-open-o',
					'id'              => 'customizer_repeater_features_005',
				),
				array(
					'title'           => esc_html__( '24X7 support', 'avril' ),
					'text'            => esc_html__( 'Many variations of at Lorem Ipsum but the majority have suffered. Lorem Ipsum the majority suffered.', 'avril' ),
					'icon_value'       => 'fa-users',
					'id'              => 'customizer_repeater_features_006',
				),
			)
		)
	);
}
