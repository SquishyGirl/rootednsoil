<?php
defined( 'WPINC' ) or die;

if ( ! defined( 'PARVATI_IMAGE_RESIZER' ) ) {
	require_once PARVATI_LIBRARY_DIRECTORY . 'image-processing-queue/image-processing-queue.php';
}

if ( ! function_exists( 'parvati_get_blog_image_attributes' ) ) {
	/**
	 * Build our image attributes
	 *
	 */
	function parvati_get_blog_image_attributes() {
		$settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		if ( is_singular() ) {
			if ( is_singular( 'page' ) ) {
				$single = 'page_';
			} else {
				$single = 'single_';
			}
		} else {
			$single = '';
		}

		$ignore_crop = array( '', '0', '9999' );

		$atts = array(
			'width' => ( in_array( $settings["{$single}post_image_width"], $ignore_crop ) ) ? 9999 : absint( $settings["{$single}post_image_width"] ),
			'height' => ( in_array( $settings["{$single}post_image_height"], $ignore_crop ) ) ? 9999 : absint( $settings["{$single}post_image_height"] ),
			'crop' => ( in_array( $settings["{$single}post_image_width"], $ignore_crop ) || in_array( $settings["{$single}post_image_height"], $ignore_crop ) ) ? false : true
		);

		// If there's no height or width, empty the array
		if ( 9999 == $atts[ 'width' ] && 9999 == $atts[ 'height' ] ) {
			$atts = array();
		}

		return apply_filters( 'parvati_blog_image_attributes', $atts );
	}
}

if ( ! function_exists( 'parvati_blog_setup' ) ) {
	add_action( 'wp', 'parvati_blog_setup', 50 );
	/**
	 * Setup our blog functions and actions
	 *
	 */
	function parvati_blog_setup() {
		$settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		// Move our featured images to above the title
		if ( 'post-image-above-header' == $settings['post_image_position'] ) {
			remove_action( 'parvati_after_entry_header', 'parvati_post_image' );
			add_action( 'parvati_before_content', 'parvati_post_image' );

			// If we're using the Page Header add-on, move those as well
			if ( function_exists('parvati_pageheader_post_image') ) {
				remove_action( 'parvati_after_entry_header', 'parvati_pageheader_post_image' );
				add_action( 'parvati_before_content', 'parvati_pageheader_post_image' );
			}
		}

		$page_header_content = false;
		if ( function_exists( 'parvati_pageheader_get_options' ) ) {
			$options = parvati_pageheader_get_options();
			if ( '' !== $options[ 'content' ] ) {
				$page_header_content = true;
			}

			// If our Page Header has no content, remove it
			// This will allow the Blog add-on to add an image for us
			if ( ! $page_header_content && is_singular() ) {
				remove_action( 'parvati_before_content', 'parvati_pageheader' );
				remove_action( 'parvati_after_entry_header', 'parvati_pageheader' );
				remove_action( 'parvati_after_header', 'parvati_pageheader' );
			}
		}

		// Remove the core theme featured image
		// I would like to filter instead one day
		remove_action( 'parvati_after_header', 'parvati_featured_page_header' );
		remove_action( 'parvati_before_content', 'parvati_featured_page_header_inside_single' );

		$location = parvati_blog_get_singular_template();

		if ( $settings[$location . '_post_image'] && is_singular() && ! $page_header_content ) {
			if ( 'below-title' == $settings[$location . '_post_image_position'] ) {
				add_action( 'parvati_after_entry_header', 'parvati_blog_single_featured_image' );
			}

			if ( 'inside-content' == $settings[$location . '_post_image_position'] ) {
				add_action( 'parvati_before_content', 'parvati_blog_single_featured_image' );
			}

			if ( 'above-content' == $settings[$location . '_post_image_position'] ) {
				add_action( 'parvati_after_header', 'parvati_blog_single_featured_image' );
			}
		}
	}
}

add_filter( 'parvati_featured_image_output', 'parvati_blog_featured_image' );
/**
 * Filter our core featured image so we can include support for resized images.
 *
 * @return string The image HTML
 */
function parvati_blog_featured_image( $output ) {
	$settings = wp_parse_args(
		get_option( 'parvati_blog_settings', array() ),
		parvati_blog_get_defaults()
	);

	$image_atts = parvati_get_blog_image_attributes();
	$image_id = get_post_thumbnail_id( get_the_ID(), 'full' );

	if ( ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) || ! $settings['post_image'] ) {
		return false;
	}

	if ( $image_atts && function_exists( 'ipq_get_theme_image' ) ) {
		$image_html = ipq_get_theme_image( $image_id,
			array(
				array( $image_atts[ 'width' ], $image_atts[ 'height' ], $image_atts[ 'crop' ] )
			),
			array(
				'itemprop' => 'image',
			)
		);
	} else {
		return $output;
	}

	return apply_filters( 'parvati_resized_featured_image_output', sprintf(
		'<div class="post-image">
			<a href="%1$s">
				%2$s
			</a>
		</div>',
		esc_url( get_permalink() ),
		$image_html
	), $image_html );
}

/**
 * Build our featured images for single posts and pages.
 *
 * This function is way more complicated than it could be so it can
 * ensure compatibility with the Page Header add-on.
 *
 *
 * @return string The image HTML
 */
function parvati_blog_single_featured_image() {
	$settings = wp_parse_args(
		get_option( 'parvati_blog_settings', array() ),
		parvati_blog_get_defaults()
	);

	$image_atts = parvati_get_blog_image_attributes();
	$image_id = get_post_thumbnail_id( get_the_ID(), 'full' );

	if ( function_exists( 'parvati_pageheader_get_image' ) && parvati_pageheader_get_image( 'ID' ) ) {
		if ( intval( $image_id ) !== parvati_pageheader_get_image( 'ID' ) ) {
			$image_id = parvati_pageheader_get_image( 'ID' );
		}
	}

	$location = parvati_blog_get_singular_template();

	if ( ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) || ! $settings[$location . '_post_image'] || ! $image_id ) {
		return false;
	}

	if ( $image_atts && function_exists( 'ipq_get_theme_image' ) ) {

		$image_html = ipq_get_theme_image( $image_id,
			array(
				array( $image_atts[ 'width' ], $image_atts[ 'height' ], $image_atts[ 'crop' ] )
			),
			array(
				'itemprop' => 'image',
			)
		);

	} else {

		$image_html = apply_filters( 'post_thumbnail_html',
			wp_get_attachment_image( $image_id, apply_filters( 'parvati_pageheader_default_size', 'full' ), '',
				array(
					'itemprop' => 'image',
				)
			),
			get_the_ID(),
			$image_id,
			apply_filters( 'parvati_pageheader_default_size', 'full' ),
			''
		);

	}

	$location = parvati_blog_get_singular_template();

	$classes = array(
		is_page() ? 'page-header-image' : null,
		is_singular() && ! is_page() ? 'page-header-image-single' : null,
		'above-content' == $settings[$location . '_post_image_position'] ? 'grid-container grid-parent' : null,
	);

	$image_html = apply_filters( 'parvati_single_featured_image_html', $image_html );

	echo apply_filters( 'parvati_single_featured_image_output', sprintf(
		'<div class="featured-image %2$s">
			%1$s
		</div>',
		$image_html,
		implode( ' ', $classes )
	), $image_html );
}

add_filter( 'parvati_blog_image_attributes', 'parvati_blog_page_header_image_atts' );
/**
 * Filter our image attributes in case we're using differents atts in our Page Header
 *
 *
 * @param array $atts Our existing image attributes.
 * @return array Image attributes
 */
function parvati_blog_page_header_image_atts( $atts ) {
	if ( ! function_exists( 'parvati_pageheader_get_options' ) ) {
		return $atts;
	}

	if ( ! is_singular() ) {
		return $atts;
	}

	$options = parvati_pageheader_get_options();

	if ( 'enable' == $options[ 'image_resize' ] ) {
		$ignore_crop = array( '', '0', '9999' );

		$atts = array(
			'width' => ( in_array( $options[ 'image_width' ], $ignore_crop ) ) ? 9999 : absint( $options[ 'image_width' ] ),
			'height' => ( in_array( $options[ 'image_height' ], $ignore_crop ) ) ? 9999 : absint( $options[ 'image_height' ] ),
			'crop' => ( in_array( $options[ 'image_width' ], $ignore_crop ) || in_array( $options[ 'image_height' ], $ignore_crop ) ) ? false : true
		);
	}

	return $atts;
}

add_filter( 'parvati_single_featured_image_html', 'parvati_blog_page_header_link' );
/**
 * Add our Page Header link to our featured image if set.
 *
 *
 * @param string $image_html Our existing image HTML.
 * @return string Our new image HTML.
 */
function parvati_blog_page_header_link( $image_html ) {
	if ( ! function_exists( 'parvati_pageheader_get_options' ) ) {
		return $image_html;
	}

	$options = parvati_pageheader_get_options();

	if ( ! empty( $options['image_link'] ) ) {
		return '<a href="' . esc_url( $options[ 'image_link' ] ) . '"' . apply_filters( 'parvati_pageheader_link_target', '' ) . '>' . $image_html . '</a>';
	} else {
		return $image_html;
	}
}
