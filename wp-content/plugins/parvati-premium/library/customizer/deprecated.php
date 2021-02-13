<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'parvati_backgrounds_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function parvati_backgrounds_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_text_field( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if ( ! function_exists( 'parvati_backgrounds_is_top_bar_active' ) ) :
/**
 * Check to see if the top bar is active
 *
 */
function parvati_backgrounds_is_top_bar_active()
{
	$top_bar = is_active_sidebar( 'top-bar' ) ? true : false;
	return apply_filters( 'parvati_is_top_bar_active', $top_bar );
}
endif;

if ( ! function_exists( 'parvati_blog_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function parvati_blog_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_key( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if ( ! function_exists( 'parvati_blog_is_posts_page' ) ) :
/**
 * Check to see if we're on a posts page
 */
function parvati_blog_is_posts_page()
{
	$blog = ( is_home() || is_archive() || is_attachment() || is_tax() ) ? true : false;
	
	return $blog;
}
endif;

if ( ! function_exists( 'parvati_blog_is_posts_page_single' ) ) :
/**
 * Check to see if we're on a posts page or a single post
 */
function parvati_blog_is_posts_page_single()
{
	$blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;
	
	return $blog;
}
endif;

if ( ! function_exists( 'parvati_blog_is_excerpt' ) ) :
/**
 * Check to see if we're displaying excerpts
 */
function parvati_blog_is_excerpt()
{
	if ( ! function_exists( 'parvati_get_defaults' ) )
		return;
	
	$parvati_settings = wp_parse_args( 
		get_option( 'parvati_settings', array() ), 
		parvati_get_defaults() 
	);
	
	return ( 'excerpt' == $parvati_settings['post_content'] ) ? true : false;
}
endif;

if ( ! function_exists( 'parvati_colors_sanitize_hex_color' ) ) :
/**
 * Sanitize hex colors
 * We don't use the core function as we want to allow empty values 
 */
function parvati_colors_sanitize_hex_color( $color ) {
    if ( '' === $color )
        return '';
 
    // 3 or 6 hex digits, or the empty string.
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
        return $color;
 
    return '';
}
endif;

if ( ! function_exists( 'parvati_colors_sanitize_rgba' ) ) :
/**
 * Sanitize RGBA colors 
 */
function parvati_colors_sanitize_rgba( $color ) {
    if ( '' === $color )
        return '';
 
	// If string does not start with 'rgba', then treat as hex
	// sanitize the hex color and finally convert hex to rgba
	if ( false === strpos( $color, 'rgba' ) ) {
		return parvati_colors_sanitize_hex_color( $color );
	}

	// By now we know the string is formatted as an rgba color so we need to further sanitize it.
	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
	return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
 
    return '';
}
endif;

if ( ! function_exists( 'parvati_menu_plus_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function parvati_menu_plus_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_key( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if ( ! function_exists( 'parvati_pageheader_is_posts_page' ) ) :
/**
 * This is an active_callback
 * Check if we're on a posts page
 */
function parvati_pageheader_is_posts_page()
{
	$blog = ( is_home() || is_archive() || is_attachment() || is_tax() ) ? true : false;
	
	return $blog;
}
endif;

if ( ! function_exists( 'parvati_pageheader_is_posts_page_single' ) ) :
/**
 * Check to see if we're on a posts page or a single post
 */
function parvati_pageheader_is_posts_page_single()
{
	$blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;
	
	return $blog;
}
endif;

if ( ! function_exists( 'parvati_secondary_nav_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function parvati_secondary_nav_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_key( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if ( ! function_exists( 'parvati_spacing_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function parvati_spacing_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_key( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if ( ! function_exists( 'parvati_premium_sanitize_typography' ) ) :
/**
 * Sanitize typography dropdown
 */
function parvati_premium_sanitize_typography( $input ) 
{
	if ( ! function_exists( 'parvati_get_all_google_fonts' ) || ! function_exists( 'parvati_typography_default_fonts' ) ) {
		return 'Open Sans';
	}
	
	// Grab all of our fonts
	$fonts = parvati_get_all_google_fonts();
	
	// Loop through all of them and grab their names
	$font_names = array();
	foreach ( $fonts as $k => $fam ) {
		$font_names[] = $fam['name'];
	}
	
	// Get all non-Google font names
	$not_google = parvati_typography_default_fonts();

	// Merge them both into one array
	$valid = array_merge( $font_names, $not_google );
	
	// Sanitize
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return 'Open Sans';
    }
}
endif;

if ( ! function_exists( 'parvati_typography_sanitize_choices' ) ) :
/**
 * Sanitize choices
 */
function parvati_typography_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_key( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if ( ! function_exists( 'parvati_pageheader_sanitize_choices' ) ) :
/**
 * Sanitize our select inputs
 */
function parvati_pageheader_sanitize_choices( $input, $setting ) {
	
	// Ensure input is a slug
	$input = sanitize_key( $input );
	
	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

if ( ! function_exists( 'parvati_pageheader_sanitize_hex_color' ) ) :
/**
 * Sanitize colors
 * We don't use the core function as we want to allow empty values
 */
function parvati_pageheader_sanitize_hex_color( $color ) {
    if ( '' === $color )
        return '';
 
    // 3 or 6 hex digits, or the empty string.
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
        return $color;
 
    return '';
}
endif;

if ( ! function_exists( 'parvati_pageheader_sanitize_html' ) ) :
/**
 * Sanitize our fields that accept HTML
 */
function parvati_pageheader_sanitize_html( $input ) 
{
	return wp_kses_post( $input );
}
endif;