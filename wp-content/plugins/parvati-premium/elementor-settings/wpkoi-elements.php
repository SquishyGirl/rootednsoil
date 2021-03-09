<?php
/**
 * Builds our admin page.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// options for effects
$wtfe_parallax_section 		= get_option( 'wtfe_parallax_section', '' );
$wtfe_element_effects 		= get_option( 'wtfe_element_effects', '' );
$wtfe_particles 			= get_option( 'wtfe_particles', '' );
$wtfe_background_change 	= get_option( 'wtfe_background_change', '' );
$wtfe_sticky_column			= get_option( 'wtfe_sticky_column', '' );
// options for elements
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
$wtfe_distorted_headings 	= get_option( 'wtfe_distorted_headings', '' );
$wtfe_data_table 			= get_option( 'wtfe_data_table', '' );
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

?>

<div id="wete-page-body">
	<div class="wete-title-area">
    	<a href="<?php echo esc_url( 'https://wpkoi.com/' ); ?>" target="_blank"><img src="<?php echo esc_url( WPKOI_ELEMENTS_FOR_ELEMENTOR_URL . 'assets/img/wpkoi-logo.png' ); ?>" class="wet-logo" /></a>
    	<div class="wete-title-content">
        	<h1><?php esc_html_e( 'WPKoi Elements for Elementor', 'wpkoi-elements' );?></h1>
            <p><?php esc_html_e( 'Give the spirit to Your site!', 'wpkoi-elements' );?></p>
        </div>
    </div>
    <h2><?php esc_html_e( 'WPKoi Elements for Elementor gives extra Elementor widgets and functions for the premium version of WPKoi themes.', 'wpkoi-elements' );?></h2>
    <p><?php esc_html_e( 'Here You can turn off the elements that You don`t use. It will improve the performance of Your site', 'wpkoi-elements' );?></p>
    <div class="wpkoi-disable-elements wefe-settings">
        <form method="post" action="options.php">
        <h3 class="switch-margin-top"><?php esc_html_e( 'Switch Your unused effects off!', 'wpkoi-elements' ); ?></h3>
        <p class="wet-de-p"><?php esc_html_e( 'Here You can switch off the WPKoi Effects for Elementor builder if You don˙t want to use. These effects used for elements, sections or columns.', 'wpkoi-elements' ); ?></p>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_parallax_section" name="wtfe_parallax_section" type="checkbox"<?php if ( $wtfe_parallax_section == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Parallax Section', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_element_effects" name="wtfe_element_effects" type="checkbox"<?php if ( $wtfe_element_effects == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Element Effects', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_particles" name="wtfe_particles" type="checkbox"<?php if ( $wtfe_particles == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Particles', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_background_change" name="wtfe_background_change" type="checkbox"<?php if ( $wtfe_background_change == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Background Change', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_sticky_column" name="wtfe_sticky_column" type="checkbox"<?php if ( $wtfe_sticky_column == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Sticky Column', 'wpkoi-elements' ); ?></p>
        </div>
        
        <h3 class="switch-margin-top"><?php esc_html_e( 'Switch Your unused elements off!', 'wpkoi-elements' ); ?></h3>
        <p class="wet-de-p"><?php esc_html_e( 'Here You can switch off the WPKoi widgets if You don˙t want to use.', 'wpkoi-elements' ); ?></p>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_advanced_accordion" name="wtfe_advanced_accordion" type="checkbox"<?php if ( $wtfe_advanced_accordion == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Advanced Accordion', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_advanced_tabs" name="wtfe_advanced_tabs" type="checkbox"<?php if ( $wtfe_advanced_tabs == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Advanced Tabs', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_advanced_headings" name="wtfe_advanced_headings" type="checkbox"<?php if ( $wtfe_advanced_headings == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Advanced Headings', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_animated_text" name="wtfe_animated_text" type="checkbox"<?php if ( $wtfe_animated_text == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Animated Text', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_button" name="wtfe_button" type="checkbox"<?php if ( $wtfe_button == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Button', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_call_to_action" name="wtfe_call_to_action" type="checkbox"<?php if ( $wtfe_call_to_action == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Call To Action', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_circle_progress" name="wtfe_circle_progress" type="checkbox"<?php if ( $wtfe_circle_progress == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Circle Progress', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_content_ticker" name="wtfe_content_ticker" type="checkbox"<?php if ( $wtfe_content_ticker == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Content Ticker', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_countdown" name="wtfe_countdown" type="checkbox"<?php if ( $wtfe_countdown == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Countdown', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_darkmode" name="wtfe_darkmode" type="checkbox"<?php if ( $wtfe_darkmode == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Darkmode', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_data_table" name="wtfe_data_table" type="checkbox"<?php if ( $wtfe_data_table == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Data Table', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_distorted_headings" name="wtfe_distorted_headings" type="checkbox"<?php if ( $wtfe_distorted_headings == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Distorted Headings', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_filterable_gallery" name="wtfe_filterable_gallery" type="checkbox"<?php if ( $wtfe_filterable_gallery == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Filterable Gallery', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_flip_box" name="wtfe_flip_box" type="checkbox"<?php if ( $wtfe_flip_box == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Flip Box', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_hotspots" name="wtfe_hotspots" type="checkbox"<?php if ( $wtfe_hotspots == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Hotspots', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_image_accordion" name="wtfe_image_accordion" type="checkbox"<?php if ( $wtfe_image_accordion == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Image Accordion', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_image_comparison" name="wtfe_image_comparison" type="checkbox"<?php if ( $wtfe_image_comparison == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Image Comparison', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_post_grid" name="wtfe_post_grid" type="checkbox"<?php if ( $wtfe_post_grid == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Post Grid', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_post_timeline" name="wtfe_post_timeline" type="checkbox"<?php if ( $wtfe_post_timeline == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Post Timeline', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_pricing_table" name="wtfe_pricing_table" type="checkbox"<?php if ( $wtfe_pricing_table == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Pricing Table', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_product_grid" name="wtfe_product_grid" type="checkbox"<?php if ( $wtfe_product_grid == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Product Grid', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_qr_code" name="wtfe_qr_code" type="checkbox"<?php if ( $wtfe_qr_code == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'QR Code', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_scroll_navigation" name="wtfe_scroll_navigation" type="checkbox"<?php if ( $wtfe_scroll_navigation == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Scroll Navigation', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_team_member" name="wtfe_team_member" type="checkbox"<?php if ( $wtfe_team_member == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Team Member', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_testimonial" name="wtfe_testimonial" type="checkbox"<?php if ( $wtfe_testimonial == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Testimonial', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_unfold" name="wtfe_unfold" type="checkbox"<?php if ( $wtfe_unfold == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'Unfold', 'wpkoi-elements' ); ?></p>
        </div>
        <div class="wet-de-e">
            <label class="switch">
              <input id="wtfe_view_more" name="wtfe_view_more" type="checkbox"<?php if ( $wtfe_view_more == true ){ ?> checked<?php } ?> >
              <span class="slider"></span>
            </label>
            <p><?php esc_html_e( 'View More', 'wpkoi-elements' ); ?></p>
        </div>
        
        <input type="submit" class="button button-primary" name="wefe_submit" value="<?php _e( 'Save', 'wpkoi-elements' );?>" />
    	</form>
    </div>
	
</div>

<?php 