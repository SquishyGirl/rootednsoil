<?php
defined( 'WPINC' ) or die;

if ( ! function_exists( 'parvati_blog_get_columns' ) ) {
	/**
	 * Initiate columns.
	 *
	 */
	function parvati_blog_get_columns() {
		$parvati_blog_settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		// If columns are enabled, set to true
		$columns = ( true == $parvati_blog_settings['column_layout'] ) ? true : false;

		// If we're not dealing with posts, set it to false.
		// Check for is_home() to prevent bug in Yoast that throws off the post type check.
		$columns = ( 'post' == get_post_type() || 'wpkoi-events' == get_post_type() || is_search() || is_home() ) ? $columns : false;

		// If masonry is enabled via filter, enable columns
		$columns = ( 'true' == apply_filters( 'parvati_blog_masonry', 'false' ) ) ? true : $columns;

		// If we're on a singular post or page, disable
		$columns = ( is_singular() ) ? false : $columns;

		// Turn off columns if we're on a WooCommerce search page
		if ( function_exists( 'is_woocommerce' ) ) {
			$columns = ( is_woocommerce() && is_search() ) ? false : $columns;
		}

		// Bail if there's no search results
		if ( is_search() ) {
			global $wp_query;
			if ( 0 == $wp_query->post_count ) {
				$columns = false;
			}
		}

		// Return the result
		return apply_filters( 'parvati_blog_columns', $columns );
	}
}

if ( ! function_exists( 'parvati_blog_get_masonry' ) ) {
	/**
	 * Check if masonry is enabled
	 */
	function parvati_blog_get_masonry() {
		$parvati_blog_settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		// If masonry is enabled via option or filter, enable it.
		if ( $parvati_blog_settings['masonry'] || 'true' == apply_filters( 'parvati_blog_masonry', 'false' ) ) {
			$masonry = 'true';
		} else {
			$masonry = 'false';
		}

		return $masonry;
	}
}

if ( ! function_exists( 'parvati_blog_add_columns_container' ) ) {
	add_action( 'parvati_before_main_content', 'parvati_blog_add_columns_container' );
	/**
	 * Add columns container
	 *
	 */
	function parvati_blog_add_columns_container() {
		if ( ! parvati_blog_get_columns() ) {
			return;
		}

		$settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		printf(
			'<div class="parvati-columns-container %1$s">%2$s',
			'false' !== parvati_blog_get_masonry() ? 'masonry-container are-images-unloaded' : '',
			'false' !== parvati_blog_get_masonry() ? '<div class="grid-sizer ' . esc_attr( 'grid-' . $settings['columns'] ) . ' tablet-grid-50 mobile-grid-100"></div>' : ''
		);
	}
}

if ( ! function_exists( 'parvati_blog_add_ending_columns_container' ) ) {
	add_action( 'parvati_after_main_content', 'parvati_blog_add_ending_columns_container' );
	/**
	 * Add closing columns container
	 *
	 */
	function parvati_blog_add_ending_columns_container() {
		if ( ! parvati_blog_get_columns() ) {
			return;
		}

		echo '</div><!-- .parvati-columns-contaier -->';
	}
}

if ( ! function_exists( 'parvati_blog_columns_css' ) ) {
	/**
	 * Add inline CSS
	 */
	function parvati_blog_columns_css() {
		$parvati_blog_settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		if ( function_exists( 'parvati_spacing_get_defaults' ) ) {
			$spacing_settings = wp_parse_args(
				get_option( 'parvati_spacing_settings', array() ),
				parvati_spacing_get_defaults()
			);
		}

		$separator = ( function_exists('parvati_spacing_get_defaults') ) ? absint( $spacing_settings['separator'] ) : 20;

		$return = '';
		if ( parvati_blog_get_columns() ) {
			$return .= '.parvati-columns {margin-bottom: ' . $separator . 'px;padding-left: ' . $separator . 'px;}';
			$return .= '.parvati-columns-container {margin-left: -' . $separator . 'px;}';
			$return .= '.page-header {margin-bottom: ' . $separator . 'px;margin-left: ' . $separator . 'px}';
			$return .= '.parvati-columns-container > .paging-navigation {margin-left: ' . $separator . 'px;}';
		}

		return $return;
	}
}

if ( ! function_exists( 'parvati_blog_get_column_count' ) ) {
	/**
	 * Get our column grid class
	 */
	function parvati_blog_get_column_count() {
		$parvati_blog_settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		$count = $parvati_blog_settings['columns'];

		return apply_filters( 'parvati_blog_get_column_count', $count );
	}
}
