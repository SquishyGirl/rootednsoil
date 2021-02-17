<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Default values for premium features

if ( ! function_exists( 'parvati_get_background_defaults' ) ) {
	/**
	 * Set BACKGROUND defaults
	 *
	 */
	function parvati_get_background_defaults() {
		$parvati_background_defaults = array(
			'body_image' => '',
			'body_repeat' => '',
			'body_size' => '',
			'body_attachment' => '',
			'body_position' => '',
			'top_bar_image' => '',
			'top_bar_repeat' => '',
			'top_bar_size' => '',
			'top_bar_attachment' => '',
			'top_bar_position' => '',
			'header_repeat' => '',
			'header_size' => '',
			'header_attachment' => '',
			'header_position' => '',
			'nav_image' => '',
			'nav_repeat' => '',
			'nav_item_image' => '',
			'nav_item_repeat' => '',
			'nav_item_hover_image' => '',
			'nav_item_hover_repeat' => '',
			'nav_item_current_image' => '',
			'nav_item_current_repeat' => '',
			'sub_nav_image' => '',
			'sub_nav_repeat' => '',
			'sub_nav_item_image' => '',
			'sub_nav_item_repeat' => '',
			'sub_nav_item_hover_image' => '',
			'sub_nav_item_hover_repeat' => '',
			'sub_nav_item_current_image' => '',
			'sub_nav_item_current_repeat' => '',
			'content_image' => '',
			'content_repeat' => '',
			'content_size' => '',
			'content_attachment' => '',
			'content_position' => '',
			'sidebar_widget_image' => '',
			'sidebar_widget_repeat' => '',
			'sidebar_widget_size' => '',
			'sidebar_widget_attachment' => '',
			'sidebar_widget_position' => '',
			'footer_widget_image' => '',
			'footer_widget_repeat' => '',
			'footer_widget_size' => '',
			'footer_widget_attachment' => '',
			'footer_widget_position' => '',
			'footer_image' => '',
			'footer_repeat' => '',
			'footer_size' => '',
			'footer_attachment' => '',
			'footer_position' => '',
		);

		return apply_filters( 'parvati_background_option_defaults', $parvati_background_defaults );
	}
}

if ( ! function_exists( 'parvati_blog_get_defaults' ) ) {
	/**
	 * Set BLOG defaults
	 *
	 */
	function parvati_blog_get_defaults() {
		$parvati_blog_defaults = array(
			'excerpt_length' => '25',
			'read_more' => __( 'Read more', 'parvati-premium' ),
			'read_more_button' => true,
			'masonry' => false,
			'masonry_load_more' => __( '+ More', 'parvati-premium' ),
			'masonry_loading' => __( 'Loading...', 'parvati-premium' ),
			'infinite_scroll' => false,
			'infinite_scroll_button' => false,
			'post_image' => true,
			'post_image_position' => 'post-image-above-header',
			'post_image_alignment' => 'post-image-aligned-left',
			'post_image_width' => '',
			'post_image_height' => '',
			'post_image_padding' => true,
			'single_post_image' => true,
			'single_post_image_position' => 'inside-content',
			'single_post_image_alignment' => 'center',
			'single_post_image_width' => '',
			'single_post_image_height' => '',
			'single_post_image_padding' => true,
			'page_post_image' => true,
			'page_post_image_position' => 'above-content',
			'page_post_image_alignment' => 'center',
			'page_post_image_width' => '',
			'page_post_image_height' => '',
			'page_post_image_padding' => true,
			'date' => true,
			'author' => true,
			'categories' => true,
			'tags' => true,
			'comments' => true,
			'single_date' => true,
			'single_author' => true,
			'single_categories' => true,
			'single_tags' => true,
			'single_post_navigation' => true,
			'column_layout' => true,
			'columns' => '50',
			'featured_column' => false
		);

		return apply_filters( 'parvati_blog_option_defaults', $parvati_blog_defaults );
	}
}

if ( ! function_exists( 'parvati_fixed_side_content_get_defaults' ) ) {
	/**
	 * Set FIXED SIDE defaults.
	 *
	 */
	function parvati_fixed_side_content_get_defaults( $filter = true ) {
		$parvati_defaults = array(
			'fixed_side_display_mobile' => false,
		);

		return apply_filters( 'parvati_fixed_side_content_option_defaults', $parvati_defaults );
	}
}

if ( ! function_exists( 'parvati_menu_plus_get_defaults' ) ) {
	/**
	 * Set MENU PLUS defaults
	 */
	function parvati_menu_plus_get_defaults() {
		$parvati_menu_plus_get_defaults = array(
			'mobile_menu_label' => __( 'Menu', 'parvati-premium' ),
			'sticky_menu' => 'true',
			'sticky_menu_effect' => 'slide',
			'sticky_menu_logo' => '',
			'sticky_menu_logo_position' => 'sticky-menu',
			'mobile_header' => 'enable',
			'mobile_header_logo' => '',
			'mobile_header_sticky' => 'disable',
			'slideout_menu' => 'desktop',
			'slideout_menu_side' => 'left',
			'auto_hide_sticky' => false,
			'mobile_header_auto_hide_sticky' => false,
		);

		return apply_filters( 'parvati_menu_plus_option_defaults', $parvati_menu_plus_get_defaults );
	}
}

add_filter( 'parvati_color_option_defaults', 'parvati_menu_plus_color_defaults' );
/**
 * Set MENU PLUS color defaults
 *
 */
function parvati_menu_plus_color_defaults( $defaults ) {
	$defaults[ 'slideout_background_color' ] = 'rgba(21,21,21,0.8)';
	$defaults[ 'slideout_text_color' ] = '#ffffff';
	$defaults[ 'slideout_background_hover_color' ] = 'rgba(255,255,255,0)';
	$defaults[ 'slideout_text_hover_color' ] = '#dddddd';
	$defaults[ 'slideout_background_current_color' ] = '';
	$defaults[ 'slideout_text_current_color' ] = '';
	$defaults[ 'slideout_submenu_background_color' ] = 'rgba(255,255,255,0)';
	$defaults[ 'slideout_submenu_text_color' ] = '';
	$defaults[ 'slideout_submenu_background_hover_color' ] = '';
	$defaults[ 'slideout_submenu_text_hover_color' ] = '';
	$defaults[ 'slideout_submenu_background_current_color' ] = '';
	$defaults[ 'slideout_submenu_text_current_color' ] = '';

	return $defaults;
}

add_filter( 'parvati_font_option_defaults', 'parvati_menu_plus_typography_defaults' );
/**
 * Set MENU PLUS typography defaults.
 *
 */
function parvati_menu_plus_typography_defaults( $defaults ) {
	$defaults[ 'slideout_font_weight' ] = '400';
	$defaults[ 'slideout_font_transform' ] = 'uppercase';
	$defaults[ 'slideout_font_size' ] = '32';
	$defaults[ 'slideout_mobile_font_size' ] = '';

	return $defaults;
}

if ( ! function_exists( 'parvati_secondary_nav_get_defaults' ) ) {
	/**
	 * Set SECONDARY NAV defaults.
	 *
	 */
	function parvati_secondary_nav_get_defaults( $filter = true ) {
		$parvati_defaults = array(
			'secondary_nav_mobile_label' => 'Menu',
			'secondary_nav_layout_setting' => 'secondary-fluid-nav',
			'secondary_nav_inner_width' => 'contained',
			'secondary_nav_position_setting' => 'secondary-nav-above-header',
			'secondary_nav_alignment' => 'center',
			'navigation_background_color' => '',
			'navigation_text_color' => '',
			'navigation_background_hover_color' => '',
			'navigation_text_hover_color' => '#dddddd',
			'navigation_background_current_color' => '',
			'navigation_text_current_color' => '',
			'subnavigation_background_color' => '#ffffff',
			'subnavigation_text_color' => '#333333',
			'subnavigation_background_hover_color' => '',
			'subnavigation_text_hover_color' => '#151515',
			'subnavigation_background_current_color' => '',
			'subnavigation_text_current_color' => '',
			'secondary_menu_item' => '12',
			'secondary_menu_item_height' => '45',
			'secondary_sub_menu_item_height' => '12',
			'secondary_navigation_background_color' => '#151515',
			'secondary_navigation_text_color' => '#ffffff',
			'font_secondary_navigation' => 'inherit',
			'font_secondary_navigation_category' => '',
			'font_secondary_navigation_variants' => 'regular',
			'secondary_navigation_font_weight' => 'normal',
			'secondary_navigation_font_transform' => 'none',
			'secondary_navigation_font_size' => '15',
			'nav_image' => '',
			'nav_repeat' => '',
			'nav_item_image' => '',
			'nav_item_repeat' => '',
			'nav_item_hover_image' => '',
			'nav_item_hover_repeat' => '',
			'nav_item_current_image' => '',
			'nav_item_current_repeat' => '',
			'sub_nav_image' => '',
			'sub_nav_repeat' => '',
			'sub_nav_item_image' => '',
			'sub_nav_item_repeat' => '',
			'sub_nav_item_hover_image' => '',
			'sub_nav_item_hover_repeat' => '',
			'sub_nav_item_current_image' => '',
			'sub_nav_item_current_repeat' => '',
			'merge_top_bar' => false
		);

		if ( $filter ) {
			return apply_filters( 'parvati_secondary_nav_option_defaults', $parvati_defaults );
		}

		return $parvati_defaults;
	}
}

if ( ! function_exists( 'parvati_spacing_premium_defaults' ) ) {
	add_filter( 'parvati_spacing_option_defaults', 'parvati_spacing_premium_defaults' );
	/**
	 * Set premium SPACING defaults.
	 *
	 */
	function parvati_spacing_premium_defaults( $defaults ) {

		$defaults[ 'mobile_menu_item' ] = '';
		$defaults[ 'mobile_menu_item_height' ] = '';
		$defaults[ 'sticky_menu_item_height' ] = '';
		$defaults[ 'off_canvas_menu_item_height' ] = '62';
		return $defaults;

	}
}

/**
 * Set the WC option defaults.
 *
 */
function parvati_wc_defaults() {
	return apply_filters( 'parvati_woocommerce_defaults', array(
		'cart_menu_item' => true,
		'sidebar_layout' => 'right-sidebar',
		'single_sidebar_layout' => 'inherit',
		'products_per_page' => 9,
		'columns' => 3,
		'tablet_columns' => 2,
		'mobile_columns' => 1,
		'related_upsell_columns' => 4,
		'mobile_related_upsell_columns' => 1,
		'product_archive_image_alignment' => 'center',
		'product_archive_alignment' => 'center',
		'shop_page_title' => true,
		'product_results_count' => true,
		'product_sorting' => true,
		'product_archive_image' => true,
		'product_secondary_image' => true,
		'product_archive_title' => true,
		'product_archive_sale_flash' => true,
		'product_archive_sale_flash_overlay' => true,
		'product_archive_rating' => true,
		'product_archive_price' => true,
		'product_archive_add_to_cart' => true,
		'product_tabs' => true,
		'product_related' => true,
		'product_upsells' => true,
		'product_meta' => true,
		'product_description' => true,
		'breadcrumbs' => false,
		'distraction_free' => true,
		'product_archive_description' => false,
	) );
}

add_filter( 'parvati_color_option_defaults', 'parvati_wc_color_defaults' );
/**
 * Set the WC color option defaults.
 *
 */
function parvati_wc_color_defaults( $defaults ) {
	$defaults[ 'wc_alt_button_background' ] = '#151515';
	$defaults[ 'wc_alt_button_background_hover' ] = '#ffffff';
	$defaults[ 'wc_alt_button_text' ] = '#e0a655';
	$defaults[ 'wc_alt_button_text_hover' ] = '#e0a655';
	$defaults[ 'wc_rating_stars' ] = '#151515';
	$defaults[ 'wc_sale_sticker_background' ] = '#ffffff';
	$defaults[ 'wc_sale_sticker_text' ] = '#000000';
	$defaults[ 'wc_price_color' ] = '#151515';
	$defaults[ 'wc_product_tab' ] = '#555555';
	$defaults[ 'wc_product_tab_highlight' ] = '#151515';
	$defaults[ 'wc_success_message_background' ] = '#0b9444';
	$defaults[ 'wc_success_message_text' ] = '#ffffff';
	$defaults[ 'wc_info_message_background' ] = '#1e73be';
	$defaults[ 'wc_info_message_text' ] = '#ffffff';
	$defaults[ 'wc_error_message_background' ] = '#e8626d';
	$defaults[ 'wc_error_message_text' ] = '#ffffff';
	$defaults[ 'wc_product_title_color' ] = '';
	$defaults[ 'wc_product_title_color_hover' ] = '';

	return $defaults;
}

add_filter( 'parvati_font_option_defaults', 'parvati_wc_typography_defaults' );
/**
 * Set the WC typography option defaults.
 *
 */
function parvati_wc_typography_defaults( $defaults ) {
	$defaults[ 'wc_product_title_font_weight' ] = '600';
	$defaults[ 'wc_product_title_font_transform' ] = 'none';
	$defaults[ 'wc_product_title_font_size' ] = '22';
	$defaults[ 'mobile_wc_product_title_font_size' ] = '';
	$defaults[ 'wc_related_product_title_font_size' ] = '22';
	return $defaults;
}

if ( ! function_exists( 'parvati_get_default_color_palettes' ) ) {
	/**
	 * Set up our colors for the color picker palettes and filter them so you can change them
	 *
	 */
	function parvati_get_default_color_palettes() {
		$palettes = array(
			'#e0a655',
			'#1c0d08',
			'#151515',
			'#252525',
			'#eeeeee',
			'#ffffff'
		);

		return apply_filters( 'parvati_default_color_palettes', $palettes );
	}
}

if ( ! function_exists( 'parvati_typography_default_fonts' ) ) {
	/**
	 * Get our system fonts
	 */
	function parvati_typography_default_fonts() {
		$fonts = array(
			'inherit',
			'System Stack',
			'Arial, Helvetica, sans-serif',
			'Courier New',
			'Georgia, Times New Roman, Times, serif',
			'Trebuchet MS, Helvetica, sans-serif',
			'Verdana, Geneva, sans-serif',
			'Playfair Display',
			'Cinzel',
			'Merriweather'
		);

		return apply_filters( 'parvati_typography_default_fonts', $fonts );
	}
}

define('PARVATI_PREMIUM_DEFAULT_FONTS','//fonts.googleapis.com/css?family=Merriweather:300,300italic,regular,italic,700,700italic,900,900italic|Cinzel:regular,700,900|Playfair+Display:regular,italic,700,700italic,900,900italic');