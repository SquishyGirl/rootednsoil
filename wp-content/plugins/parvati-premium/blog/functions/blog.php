<?php
defined( 'WPINC' ) or die;

// Pull in our defaults and functions
require plugin_dir_path( __FILE__ ) . 'images.php';
require plugin_dir_path( __FILE__ ) . 'columns.php';
require plugin_dir_path( __FILE__ ) . 'customizer.php';
require plugin_dir_path( __FILE__ ) . 'migrate.php';

if ( ! function_exists( 'parvati_blog_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'parvati_blog_scripts', 50 );
	/**
	 * Enqueue scripts and styles
	 */
	function parvati_blog_scripts() {
		$settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		wp_add_inline_style( 'parvati-style', parvati_blog_css() );
		wp_add_inline_style( 'parvati-style', parvati_blog_columns_css() );

		$deps = array();

		if ( 'true' == parvati_blog_get_masonry() && parvati_blog_get_columns() ) {
			$deps[] = 'jquery-masonry';
			$deps[] = 'imagesloaded';
		}

		if ( $settings[ 'infinite_scroll' ] && ! is_singular() && ! is_404() ) {
			$deps[] = 'infinitescroll';
			wp_enqueue_script( 'infinitescroll', plugin_dir_url( __FILE__ ) . 'js/infinite-scroll.pkgd.min.js', array( 'jquery' ), '3.0.1', true );

			if ( $settings['infinite_scroll_button'] ) {
				wp_enqueue_style( 'parvati-premium-icons' );
			}
		}

		if ( ( 'true' == parvati_blog_get_masonry() && parvati_blog_get_columns() ) || ( $settings[ 'infinite_scroll' ] && ! is_singular() && ! is_404() ) ) {
			wp_enqueue_script( 'parvati-blog', plugin_dir_url( __FILE__ ) . 'js/scripts.min.js', $deps, PARVATI_BLOG_VERSION, true );
			wp_localize_script( 'parvati-blog', 'blog', array(
				'more'  => $settings['masonry_load_more'],
				'loading' => $settings['masonry_loading'],
			) );
		}

		wp_enqueue_style( 'parvati-blog', plugin_dir_url( __FILE__ ) . 'css/style-min.css', array(), PARVATI_BLOG_VERSION );
	}
}

if ( ! function_exists( 'parvati_blog_post_classes' ) ) {
	add_filter( 'post_class', 'parvati_blog_post_classes' );
	/**
	 * Adds custom classes to the content container
	 *
	 */
	function parvati_blog_post_classes( $classes ) {
		global $wp_query;
		$paged = get_query_var( 'paged' );
		$paged = $paged ? $paged : 1;

		// Get our options
		$settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		// Set our masonry class
		if ( 'true' == parvati_blog_get_masonry() && parvati_blog_get_columns() ) {
			$classes[] = 'masonry-post';
		}

		// Set our column classes
		if ( parvati_blog_get_columns() && ! is_singular() ) {
			$classes[] = 'parvati-columns';
			$classes[] = 'tablet-grid-50';
			$classes[] = 'mobile-grid-100';
			$classes[] = 'grid-parent';

			// Set our featured column class
			if ( $wp_query->current_post == 0 && $paged == 1 && $settings['featured_column'] ) {
				if ( 50 == parvati_blog_get_column_count() ) {
					$classes[] = 'grid-100';
				}

				if ( 33 == parvati_blog_get_column_count() ) {
					$classes[] = 'grid-66';
				}

				if ( 25 == parvati_blog_get_column_count() ) {
					$classes[] = 'grid-50';
				}

				if ( 20 == parvati_blog_get_column_count() ) {
					$classes[] = 'grid-60';
				}
				$classes[] = 'featured-column';
			} else {
				$classes[] = 'grid-' . parvati_blog_get_column_count();
			}
		}

		if ( ! $settings['post_image_padding'] && ! is_singular() ) {
			$classes[] = 'no-featured-image-padding';
		}

		$location = parvati_blog_get_singular_template();

		if ( ! $settings[$location . '_post_image_padding'] && is_singular() ) {
			$classes[] = 'no-featured-image-padding';
		}

		return $classes;
	}
}

if ( ! function_exists( 'parvati_blog_body_classes' ) ) {
	add_filter( 'body_class', 'parvati_blog_body_classes' );
	/**
	 * Adds custom classes to the body
	 *
	 */
	function parvati_blog_body_classes( $classes ) {
		// Get theme options
		$settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		if ( is_singular() ) {
			$location = parvati_blog_get_singular_template();

			if ( 'below-title' == $settings[$location . '_post_image_position'] ) {
				$classes[] = 'post-image-below-header';
			}

			if ( 'inside-content' == $settings[$location . '_post_image_position'] ) {
				$classes[] = 'post-image-above-header';
			}

			$classes[] = ( ! empty( $settings[$location . '_post_image_alignment'] ) ) ? 'post-image-aligned-' . $settings[$location . '_post_image_alignment'] : 'post-image-aligned-center';
		} else {
			$classes[] = ( '' == $settings['post_image_position'] ) ? 'post-image-below-header' : 'post-image-above-header';
			$classes[] = ( ! empty( $settings['post_image_alignment'] ) ) ? $settings['post_image_alignment'] : 'post-image-aligned-center';
		}

		if ( 'true' == parvati_blog_get_masonry() && parvati_blog_get_columns() ) {
			$classes[] = 'masonry-enabled';
		}

		if ( parvati_blog_get_columns() && ! is_singular() ) {
			$classes[] = 'parvati-columns-activated';
		}

		if ( $settings[ 'infinite_scroll' ] && ! is_singular() ) {
			$classes[] = 'infinite-scroll';
		}

		return $classes;
	}
}

if ( ! function_exists( 'parvati_excerpt_length' ) ) {
	add_filter( 'excerpt_length', 'parvati_excerpt_length', 15 );
	/**
	 * Set our excerpt length
	 *
	 */
	function parvati_excerpt_length( $length ) {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);
		return absint( apply_filters( 'parvati_excerpt_length', $parvati_settings['excerpt_length'] ) );
	}
}

if ( ! function_exists( 'parvati_blog_css' ) ) {
	/**
	 * Build our inline CSS
	 *
	 */
	function parvati_blog_css() {
		global $post;
		$return = '';

		$settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		// Get disable headline meta
		$disable_headline = ( isset( $post ) ) ? get_post_meta( $post->ID, '_parvati-disable-headline', true ) : '';

		if ( ! $settings['categories'] && ! $settings['comments'] && ! $settings['tags'] && ! is_singular() ) {
			$return .= '.blog footer.entry-meta, .archive footer.entry-meta {display:none;}';
		}

		if ( ! $settings['single_date'] && ! $settings['single_author'] && $disable_headline && is_singular() ) {
			$return .= '.single .entry-header{display:none;}.single .entry-content {margin-top:0;}';
		}

		if ( ! $settings['date'] && ! $settings['author'] && ! is_singular() ) {
			$return .= '.entry-header .entry-meta {display:none;}';
		}

		if ( ! $settings['single_date'] && ! $settings['single_author'] && is_singular() ) {
			$return .= '.entry-header .entry-meta {display:none;}';
		}

		if ( ! $settings['single_post_navigation'] && is_singular() ) {
			$return .= '.post-navigation {display:none;}';
		}

		if ( ! $settings['single_categories'] && ! $settings['single_post_navigation'] && ! $settings['single_tags'] && is_singular() ) {
			$return .= '.single footer.entry-meta {display:none;}';
		}

		$separator = 20;
		$content_padding_top = 40;
		$content_padding_right = 40;
		$content_padding_left = 40;
		$mobile_content_padding_top = 30;
		$mobile_content_padding_right = 30;
		$mobile_content_padding_left = 30;

		if ( function_exists( 'parvati_spacing_get_defaults' ) ) {
			$spacing_settings = wp_parse_args(
				get_option( 'parvati_spacing_settings', array() ),
				parvati_spacing_get_defaults()
			);

			$separator = absint( $spacing_settings['separator'] );
			$content_padding_top = absint( $spacing_settings['content_top'] );
			$content_padding_right = absint( $spacing_settings['content_right'] );
			$content_padding_left = absint( $spacing_settings['content_left'] );
			$mobile_content_padding_top = absint( $spacing_settings['mobile_content_top'] );
			$mobile_content_padding_right = absint( $spacing_settings['mobile_content_right'] );
			$mobile_content_padding_left = absint( $spacing_settings['mobile_content_left'] );
		}

		if ( 'true' == parvati_blog_get_masonry() && parvati_blog_get_columns() ) {
			$return .= '.page-header {margin-bottom: ' . $separator . 'px;margin-left: ' . $separator . 'px}';
		}

		if ( $settings[ 'infinite_scroll' ] && ! is_singular() ) {
			$return .= '#nav-below {display:none;}';
		}

		if ( ! $settings['post_image_padding'] && 'post-image-aligned-center' == $settings['post_image_alignment']  && ! is_singular() ) {
			$return .= '.no-featured-image-padding .post-image {margin-left:-' . $content_padding_left . 'px;margin-right:-' . $content_padding_right . 'px;}';
			$return .= '.post-image-above-header .no-featured-image-padding .inside-article .post-image {margin-top:-' . $content_padding_top . 'px;}';
		}

		$location = parvati_blog_get_singular_template();

		if ( ! $settings[$location . '_post_image_padding'] && 'center' == $settings[$location . '_post_image_alignment'] && is_singular() ) {
			$return .= '.no-featured-image-padding .featured-image {margin-left:-' . $content_padding_left . 'px;margin-right:-' . $content_padding_right . 'px;}';
			$return .= '.post-image-above-header .no-featured-image-padding .inside-article .featured-image {margin-top:-' . $content_padding_top . 'px;}';
		}

		if ( ! $settings['page_post_image_padding'] || ! $settings['single_post_image_padding'] || ! $settings['post_image_padding'] ) {
			$return .= '@media ' . apply_filters( 'parvati_mobile_media_query', '(max-width:768px)' ) . '{';
				if ( ! $settings['post_image_padding'] && 'post-image-aligned-center' == $settings['post_image_alignment'] && ! is_singular() ) {
					$return .= '.no-featured-image-padding .post-image {margin-left:-' . $mobile_content_padding_left . 'px;margin-right:-' . $mobile_content_padding_right . 'px;}';
					$return .= '.post-image-above-header .no-featured-image-padding .inside-article .post-image {margin-top:-' . $mobile_content_padding_top . 'px;}';
				}

				if ( ! $settings[$location . '_post_image_padding'] && 'center' == $settings[$location . '_post_image_alignment'] && is_singular() ) {
					$return .= '.no-featured-image-padding .featured-image {margin-left:-' . $mobile_content_padding_left . 'px;margin-right:-' . $mobile_content_padding_right . 'px;}';
					$return .= '.post-image-above-header .no-featured-image-padding .inside-article .featured-image {margin-top:-' . $mobile_content_padding_top . 'px;}';
				}
			$return .= '}';
		}

		return $return;
	}
}

if ( ! function_exists( 'parvati_blog_excerpt_more' ) ) {
	add_filter( 'excerpt_more', 'parvati_blog_excerpt_more', 15 );
	/**
	 * Prints the read more HTML
	 */
	function parvati_blog_excerpt_more( $more ) {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		// If empty, return
		if ( '' == $parvati_settings['read_more'] ) {
			return '';
		}

		return apply_filters( 'parvati_excerpt_more_output', sprintf( ' ... <a title="%1$s" class="read-more" href="%2$s">%3$s</a>',
			the_title_attribute( 'echo=0' ),
			esc_url( get_permalink( get_the_ID() ) ),
			wp_kses_post( $parvati_settings['read_more'] )
		) );
	}
}

if ( ! function_exists( 'parvati_blog_content_more' ) ) {
	add_filter( 'the_content_more_link', 'parvati_blog_content_more', 15 );
	/**
	 * Prints the read more HTML
	 */
	function parvati_blog_content_more( $more ) {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		// If empty, return
		if ( '' == $parvati_settings['read_more'] ) {
			return '';
		}

		return apply_filters( 'parvati_content_more_link_output', sprintf( '<p class="read-more-container"><a title="%1$s" class="read-more content-read-more" href="%2$s">%3$s%4$s</a></p>',
			the_title_attribute( 'echo=0' ),
			esc_url( get_permalink( get_the_ID() ) . apply_filters( 'parvati_more_jump','#more-' . get_the_ID() ) ),
			wp_kses_post( $parvati_settings['read_more'] ),
			'<span class="screen-reader-text">' . get_the_title() . '</span>'
		) );
	}
}

/**
 * Checks the setting and returns false if $thing is disabled
 *
 *
 * @param String  $data  The original data, passed through if not disabled
 * @param String  $thing The name of the thing to check
 * @return String|False The original data, or false (if disabled)
 */
function parvati_disable_post_thing( $data, $thing ) {
	$parvati_blog_settings = wp_parse_args(
		get_option( 'parvati_blog_settings', array() ),
		parvati_blog_get_defaults()
	);

	if ( ! $parvati_blog_settings[$thing] ) {
		return false;
	}

	return $data;
}

if ( ! function_exists( 'parvati_disable_post_date' ) ) {
	add_filter( 'parvati_post_date', 'parvati_disable_post_date' );
	/**
	 * Remove the post date if set
	 *
	 */
	function parvati_disable_post_date( $date ) {
		if ( is_singular() ) {
			return parvati_disable_post_thing( $date, 'single_date' );
		} else {
			return parvati_disable_post_thing( $date, 'date' );
		}
	}
}

if ( ! function_exists( 'parvati_disable_post_author' ) ) {
	add_filter( 'parvati_post_author', 'parvati_disable_post_author' );
	/**
	 * Set the author if set
	 *
	 */
	function parvati_disable_post_author( $author ) {
		if ( is_singular() ) {
			return parvati_disable_post_thing( $author, 'single_author' );
		} else {
			return parvati_disable_post_thing( $author, 'author' );
		}
	}
}

if ( ! function_exists( 'parvati_disable_post_categories' ) ) {
	add_filter( 'parvati_show_categories', 'parvati_disable_post_categories' );
	/**
	 * Remove the categories if set
	 *
	 */
	function parvati_disable_post_categories( $categories ) {
		if ( is_singular() ) {
			return parvati_disable_post_thing( $categories, 'single_categories' );
		} else {
			return parvati_disable_post_thing( $categories, 'categories' );
		}
	}
}

if ( ! function_exists( 'parvati_disable_post_tags' ) ) {
	add_filter( 'parvati_show_tags', 'parvati_disable_post_tags' );
	/**
	 * Remove the tags if set
	 *
	 */
	function parvati_disable_post_tags( $tags ) {
		if ( is_singular() ) {
			return parvati_disable_post_thing( $tags, 'single_tags' );
		} else {
			return parvati_disable_post_thing( $tags, 'tags' );
		}
	}
}

if ( ! function_exists( 'parvati_disable_post_comments_link' ) ) {
	add_filter( 'parvati_show_comments', 'parvati_disable_post_comments_link' );
	/**
	 * Remove the link to comments if set
	 *
	 */
	function parvati_disable_post_comments_link( $comments_link ) {
		return parvati_disable_post_thing( $comments_link, 'comments' );
	}
}

add_filter( 'next_post_link', 'parvati_disable_post_navigation' );
add_filter( 'previous_post_link', 'parvati_disable_post_navigation' );
/**
 * Remove the single post navigation
 *
 */
function parvati_disable_post_navigation( $navigation ) {
	return parvati_disable_post_thing( $navigation, 'single_post_navigation' );
}

add_filter( 'parvati_excerpt_more_output', 'parvati_blog_read_more_button' );
add_filter( 'parvati_content_more_link_output', 'parvati_blog_read_more_button' );
/**
 * Add the button class to our read more link if set.
 *
 *
 * @param string Our existing read more link.
 */
function parvati_blog_read_more_button( $output ) {
	$settings = wp_parse_args(
		get_option( 'parvati_blog_settings', array() ),
		parvati_blog_get_defaults()
	);

	if ( ! $settings[ 'read_more_button' ] ) {
		return $output;
	}

	return sprintf( '%5$s<p class="read-more-container"><a title="%1$s" class="read-more button" href="%2$s">%3$s%4$s</a></p>',
		the_title_attribute( 'echo=0' ),
		esc_url( get_permalink( get_the_ID() ) . apply_filters( 'parvati_more_jump','#more-' . get_the_ID() ) ),
		wp_kses_post( $settings['read_more'] ),
		'<span class="screen-reader-text">' . get_the_title() . '</span>',
		'parvati_excerpt_more_output' == current_filter() ? ' ... ' : ''
	);
}

if ( ! function_exists( 'parvati_blog_load_more' ) ) {
	add_action( 'parvati_after_main_content', 'parvati_blog_load_more', 20 );
	/**
	 * Build our load more button
	 */
	function parvati_blog_load_more() {
		// Get theme options
		$settings = wp_parse_args(
			get_option( 'parvati_blog_settings', array() ),
			parvati_blog_get_defaults()
		);

		if ( ( ! $settings[ 'infinite_scroll_button' ] || ! $settings[ 'infinite_scroll' ] ) || is_singular() || is_404() ) {
			return;
		}

		global $wp_query;

		if ( is_search() && empty( $wp_query->found_posts ) ) {
			return;
		}

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		if ( $wp_query->max_num_pages == 1 ) {
			return;
		}
		?>
		<div class="masonry-load-more load-more <?php if ( 'true' == parvati_blog_get_masonry() && parvati_blog_get_columns() ) { ?>are-images-unloaded<?php } ?>">
			<a class="button" href="#"><?php echo wp_kses_post( $settings['masonry_load_more'] ); ?></a>
		</div>
		<?php
	}
}

/**
 * Checks to see whether we're getting page or single post options.
 *
 *
 * @return string Name of our singular template
 */
function parvati_blog_get_singular_template() {
	$template = 'single';

	if ( is_page() ) {
		$template = 'page';
	}

	return $template;
}
