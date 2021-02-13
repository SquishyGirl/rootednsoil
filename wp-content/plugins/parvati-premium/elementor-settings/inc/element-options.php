<?php
/**
 * Element options for admin.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_action( 'admin_init', 'wpkoi_elements_for_elementor_wtfe_submit', 5 );
/**
 * Process our element options.
 */
function wpkoi_elements_for_elementor_wtfe_submit() {
	// Has our button been clicked?
	if ( isset( $_POST[ 'wefe_submit' ] ) ) {

		// If we're not an administrator, bail.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		
		$wtfe_parallax_section_p 	= $_POST['wtfe_parallax_section'];
		$wtfe_element_effects_p		= $_POST['wtfe_element_effects'];
		$wtfe_particles_p 			= $_POST['wtfe_particles'];
		$wtfe_background_change_p 	= $_POST['wtfe_background_change'];
		$wtfe_sticky_column_p		= $_POST['wtfe_sticky_column'];

		$wtfe_advanced_accordion_p 	= $_POST['wtfe_advanced_accordion'];
		$wtfe_advanced_tabs_p 		= $_POST['wtfe_advanced_tabs'];
		$wtfe_advanced_headings_p 	= $_POST['wtfe_advanced_headings'];
		$wtfe_animated_text_p		= $_POST['wtfe_animated_text'];
		$wtfe_button_p				= $_POST['wtfe_button'];
		$wtfe_call_to_action_p 		= $_POST['wtfe_call_to_action'];
		$wtfe_circle_progress_p		= $_POST['wtfe_circle_progress'];
		$wtfe_content_ticker_p 		= $_POST['wtfe_content_ticker'];
		$wtfe_countdown_p 			= $_POST['wtfe_countdown'];
		$wtfe_darkmode_p 			= $_POST['wtfe_darkmode'];
		$wtfe_data_table_p 			= $_POST['wtfe_data_table'];
		$wtfe_distorted_headings_p 	= $_POST['wtfe_distorted_headings'];
		$wtfe_filterable_gallery_p 	= $_POST['wtfe_filterable_gallery'];
		$wtfe_flip_box_p 			= $_POST['wtfe_flip_box'];
		$wtfe_hotspots_p 			= $_POST['wtfe_hotspots'];
		$wtfe_image_accordion_p 	= $_POST['wtfe_image_accordion'];
		$wtfe_image_comparison_p 	= $_POST['wtfe_image_comparison'];
		$wtfe_post_grid_p 			= $_POST['wtfe_post_grid'];
		$wtfe_post_timeline_p 		= $_POST['wtfe_post_timeline'];
		$wtfe_pricing_table_p 		= $_POST['wtfe_pricing_table'];
		$wtfe_product_grid_p 		= $_POST['wtfe_product_grid'];
		$wtfe_qr_code_p 			= $_POST['wtfe_qr_code'];
		$wtfe_scroll_navigation_p 	= $_POST['wtfe_scroll_navigation'];
		$wtfe_team_member_p 		= $_POST['wtfe_team_member'];
		$wtfe_testimonial_p 		= $_POST['wtfe_testimonial'];
		$wtfe_unfold_p 				= $_POST['wtfe_unfold'];
		$wtfe_view_more_p 			= $_POST['wtfe_view_more'];
		
		$wtfe_parallax_section 		= get_option( 'wtfe_parallax_section', '' );
		$wtfe_element_effects 		= get_option( 'wtfe_element_effects', '' );
		$wtfe_particles 			= get_option( 'wtfe_particles', '' );
		$wtfe_background_change 	= get_option( 'wtfe_background_change', '' );
		$wtfe_sticky_column			= get_option( 'wtfe_sticky_column', '' );
		
		$wtfe_advanced_accordion 	= get_option( 'wtfe_advanced_accordion', '' );
		$wtfe_advanced_tabs 		= get_option( 'wtfe_advanced_tabs', '' );
		$wtfe_advanced_headings 	= get_option( 'wtfe_advanced_headings', '' );
		$wtfe_animated_text			= get_option( 'wtfe_animated_text', '' );
		$wtfe_button 				= get_option( 'wtfe_button', '' );
		$wtfe_call_to_action 		= get_option( 'wtfe_call_to_action', '' );
		$wtfe_circle_progress 		= get_option( 'wtfe_circle_progress', '' );
		$wtfe_content_ticker 		= get_option( 'wtfe_content_ticker', '' );
		$wtfe_countdown 			= get_option( 'wtfe_countdown', '' );
		$wtfe_darkmode			 	= get_option( 'wtfe_darkmode', '' );
		$wtfe_data_table 			= get_option( 'wtfe_data_table', '' );
		$wtfe_distorted_headings 	= get_option( 'wtfe_distorted_headings', '' );
		$wtfe_filterable_gallery 	= get_option( 'wtfe_filterable_gallery', '' );
		$wtfe_flip_box 				= get_option( 'wtfe_flip_box', '' );
		$wtfe_hotspots 				= get_option( 'wtfe_hotspots', '' );
		$wtfe_image_accordion 		= get_option( 'wtfe_image_accordion', '' );
		$wtfe_image_comparison 		= get_option( 'wtfe_image_comparison', '' );
		$wtfe_post_grid 			= get_option( 'wtfe_post_grid', '' );
		$wtfe_post_timeline 		= get_option( 'wtfe_post_timeline', '' );
		$wtfe_pricing_table 		= get_option( 'wtfe_pricing_table', '' );
		$wtfe_product_grid 			= get_option( 'wtfe_product_grid', '' );
		$wtfe_qr_code 				= get_option( 'wtfe_qr_code', '' );
		$wtfe_scroll_navigation 	= get_option( 'wtfe_scroll_navigation', '' );
		$wtfe_team_member 			= get_option( 'wtfe_team_member', '' );
		$wtfe_testimonial 			= get_option( 'wtfe_testimonial', '' );
		$wtfe_unfold 				= get_option( 'wtfe_unfold', '' );
		$wtfe_view_more 			= get_option( 'wtfe_view_more', '' );

		// Still here? Update our option with the new values
		update_option( 'wtfe_parallax_section', $wtfe_parallax_section_p );
		update_option( 'wtfe_element_effects', $wtfe_element_effects_p );
		update_option( 'wtfe_particles', $wtfe_particles_p );
		update_option( 'wtfe_background_change', $wtfe_background_change_p );
		update_option( 'wtfe_sticky_column', $wtfe_sticky_column_p );
		
		update_option( 'wtfe_advanced_accordion', $wtfe_advanced_accordion_p );
		update_option( 'wtfe_advanced_tabs', $wtfe_advanced_tabs_p );
		update_option( 'wtfe_advanced_headings', $wtfe_advanced_headings_p );
		update_option( 'wtfe_animated_text', $wtfe_animated_text_p );
		update_option( 'wtfe_button', $wtfe_button_p );
		update_option( 'wtfe_call_to_action', $wtfe_call_to_action_p );
		update_option( 'wtfe_circle_progress', $wtfe_circle_progress_p );
		update_option( 'wtfe_content_ticker', $wtfe_content_ticker_p );
		update_option( 'wtfe_countdown', $wtfe_countdown_p );
		update_option( 'wtfe_darkmode', $wtfe_darkmode_p );
		update_option( 'wtfe_data_table', $wtfe_data_table_p );
		update_option( 'wtfe_distorted_headings', $wtfe_distorted_headings_p );
		update_option( 'wtfe_filterable_gallery', $wtfe_filterable_gallery_p );
		update_option( 'wtfe_flip_box', $wtfe_flip_box_p );
		update_option( 'wtfe_hotspots', $wtfe_hotspots_p );
		update_option( 'wtfe_image_accordion', $wtfe_image_accordion_p );
		update_option( 'wtfe_image_comparison', $wtfe_image_comparison_p );
		update_option( 'wtfe_post_grid', $wtfe_post_grid_p );
		update_option( 'wtfe_post_timeline', $wtfe_post_timeline_p );
		update_option( 'wtfe_pricing_table', $wtfe_pricing_table_p );
		update_option( 'wtfe_product_grid', $wtfe_product_grid_p );
		update_option( 'wtfe_qr_code', $wtfe_qr_code_p );
		update_option( 'wtfe_scroll_navigation', $wtfe_scroll_navigation_p );
		update_option( 'wtfe_team_member', $wtfe_team_member_p );
		update_option( 'wtfe_testimonial', $wtfe_testimonial_p );
		update_option( 'wtfe_unfold', $wtfe_unfold_p );
		update_option( 'wtfe_view_more', $wtfe_view_more_p );

		$activetheme = wp_get_theme();
		wp_safe_redirect( admin_url( 'admin.php?page=' . $activetheme->template . '-premium/elementor-settings/wpkoi-elements.php' ) );
	}
}