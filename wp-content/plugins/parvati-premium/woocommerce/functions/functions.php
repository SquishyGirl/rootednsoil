<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add any necessary files
require plugin_dir_path( __FILE__ ) . 'customizer/customizer.php';

add_filter( 'parvati_navigation_class', 'parvati_wc_navigation_class' );
/**
 * Add navigation class when the menu icon is enabled.
 *
 */
function parvati_wc_navigation_class( $classes ) {
	$classes[] = ( parvati_wc_get_setting( 'cart_menu_item' ) ) ? 'wc-menu-cart-activated' : '';
	return $classes;
}

add_filter( 'post_class', 'parvati_wc_post_class' );
add_filter( 'product_cat_class', 'parvati_wc_post_class' );
/**
 * Add post classes to the products.
 *
 *
 * @param array $classes Existing product classes.
 * @return array
 */
function parvati_wc_post_class( $classes ) {
	if ( 'product' == get_post_type() ) {
		$classes[] = ( parvati_wc_get_setting( 'product_archive_sale_flash_overlay' ) && parvati_wc_get_setting( 'product_archive_image' ) ) ? 'sales-flash-overlay' : '';
		$classes[] = ( ! is_single() ) ? 'woocommerce-text-align-' . parvati_wc_get_setting( 'product_archive_alignment' ) : '';
		$classes[] = ( ! is_single() ) ? 'woocommerce-image-align-' . parvati_wc_get_setting( 'product_archive_image_alignment' ) : '';

		if ( is_single() ) {
				$classes[] = 'wc-related-upsell-columns-' . parvati_wc_get_setting( 'related_upsell_columns' );
				$classes[] = 'wc-related-upsell-mobile-columns-' . parvati_wc_get_setting( 'mobile_related_upsell_columns' );
		}
	}

	return $classes;
}

add_action( 'woocommerce_before_shop_loop', 'parvati_wc_before_shop_loop' );
/**
 * Add opening element inside shop page.
 *
 */
function parvati_wc_before_shop_loop() {
	$classes = apply_filters( 'parvati_woocommerce_container_classes', array(
		'wc-columns-' . parvati_wc_get_setting( 'columns' ),
		//'wc-tablet-columns-' . parvati_wc_get_setting( 'tablet_columns' ),
		'wc-mobile-columns-' . parvati_wc_get_setting( 'mobile_columns' ),
	) );

	$classes = array_map('esc_attr', $classes);
	echo '<div class="' . join( ' ', $classes ) . '">';
}

add_action( 'woocommerce_after_shop_loop', 'parvati_wc_after_shop_loop' );
/**
 * Add closing element inside shop page.
 *
 */
function parvati_wc_after_shop_loop() {
	echo '</div>';
}

add_action( 'wp_enqueue_scripts', 'parvati_wc_scripts', 100 );
/**
 * Add scripts and styles.
 *
 */
function parvati_wc_scripts() {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_style( 'parvati-woocommerce', plugin_dir_url( __FILE__ ) . "css/woocommerce{$suffix}.css", array(), PARVATI_WOOCOMMERCE_VERSION );
	wp_enqueue_style( 'parvati-woocommerce-mobile', plugin_dir_url( __FILE__ ) . "css/woocommerce-mobile{$suffix}.css", array(), PARVATI_WOOCOMMERCE_VERSION, apply_filters( 'parvati_mobile_media_query', '(max-width:768px)' ) );
	//wp_enqueue_style( 'parvati-woocommerce-tablet', plugin_dir_url( __FILE__ ) . "css/woocommerce-tablet{$suffix}.css", array(), PARVATI_WOOCOMMERCE_VERSION, apply_filters( 'parvati_tablet_media_query', '(min-width: 769px) and (max-width: 1024px)' ) );

	wp_enqueue_script( 'parvati-woocommerce', plugin_dir_url( __FILE__ ) . "js/woocommerce{$suffix}.js", array( 'jquery' ), PARVATI_WOOCOMMERCE_VERSION, true );

	if ( parvati_wc_get_setting( 'distraction_free' ) && is_checkout() ) {
		wp_dequeue_script( 'parvati-advanced-sticky' );
		wp_dequeue_script( 'parvati-sticky' );
	}

	wp_enqueue_style( 'parvati-premium-icons' );
}

/**
 * Wrapper class to get the options.
 *
 *
 * @return string $setting The option name.
 * @return string The value.
 */
function parvati_wc_get_setting( $setting ) {
	$settings = wp_parse_args(
		get_option( 'parvati_woocommerce_settings', array() ),
		parvati_wc_defaults()
	);

	return $settings[ $setting ];
}

add_filter( 'parvati_sidebar_layout', 'parvati_wc_sidebar_layout' );
/**
 * Set the WC sidebars.
 *
 *
 * @param string Existing layout
 * @return string New layout
 */
function parvati_wc_sidebar_layout( $layout ) {
	if ( is_woocommerce() && is_single() && 'inherit' !== parvati_wc_get_setting( 'single_sidebar_layout' ) ) {
		if ( get_post_meta( get_the_ID(), '_parvati-sidebar-layout-meta', true ) ) {
			return get_post_meta( get_the_ID(), '_parvati-sidebar-layout-meta', true );
		}

		return parvati_wc_get_setting( 'single_sidebar_layout' );
	}

	if ( is_woocommerce() ) {
		return parvati_wc_get_setting( 'sidebar_layout' );
	}

	return $layout;
}

add_filter( 'loop_shop_columns', 'parvati_wc_product_columns', 999 );
/**
 * Set the WC column number.
 *
 */
function parvati_wc_product_columns() {
	return parvati_wc_get_setting( 'columns' );
}

add_filter( 'loop_shop_per_page', 'parvati_wc_products_per_page', 20 );
/**
 * Set the WC products per page.
 *
 */
function parvati_wc_products_per_page() {
	return parvati_wc_get_setting( 'products_per_page' );
}

add_action( 'wp', 'parvati_wc_setup' );
/**
 * Set up WC.
 *
 */
function parvati_wc_setup() {

	// Add support for WC features
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	remove_action( 'wp_enqueue_scripts','parvati_woocommerce_css', 100 );

	remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering', 30 );
	add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering', 10 );

	add_action( 'woocommerce_before_shop_loop_item_title' , 'parvati_wc_image_wrapper_open', 8 );
	add_action( 'woocommerce_before_subcategory_title' , 'parvati_wc_image_wrapper_open', 8 );
	add_action( 'woocommerce_shop_loop_item_title' , 'parvati_wc_image_wrapper_close', 8 );
	add_action( 'woocommerce_before_subcategory_title' , 'parvati_wc_image_wrapper_close', 20 );

	$archive_results_count       = parvati_wc_get_setting( 'product_results_count' );
	$archive_sorting             = parvati_wc_get_setting( 'product_sorting' );
	$archive_image               = parvati_wc_get_setting( 'product_archive_image' );
	$archive_sale_flash          = parvati_wc_get_setting( 'product_archive_sale_flash' );
	$archive_sale_flash_overlay  = parvati_wc_get_setting( 'product_archive_sale_flash_overlay' );
	$archive_rating              = parvati_wc_get_setting( 'product_archive_rating' );
	$archive_price               = parvati_wc_get_setting( 'product_archive_price' );
	$archive_add_to_cart         = parvati_wc_get_setting( 'product_archive_add_to_cart' );
	$archive_title		         = parvati_wc_get_setting( 'product_archive_title' );
	$product_tabs		         = parvati_wc_get_setting( 'product_tabs' );
	$product_related	         = parvati_wc_get_setting( 'product_related' );
	$product_upsells	         = parvati_wc_get_setting( 'product_upsells' );
	$product_meta		         = parvati_wc_get_setting( 'product_meta' );
	$product_description         = parvati_wc_get_setting( 'product_description' );
	$breadcrumbs		         = parvati_wc_get_setting( 'breadcrumbs' );
	$page_title			         = parvati_wc_get_setting( 'shop_page_title' );
	$distraction_free			 = parvati_wc_get_setting( 'distraction_free' );
	$archive_description		 = parvati_wc_get_setting( 'product_archive_description' );

	if ( false === $archive_sale_flash_overlay ) {
		remove_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_after_shop_loop_item_title',      'woocommerce_show_product_loop_sale_flash', 6 );
	}

	if ( false === $page_title ) {
		add_filter( 'woocommerce_show_page_title' , '__return_false' );
	}

	if ( false === $archive_results_count ) {
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	}

	if ( false === $archive_sorting ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
	}

	if ( false === $archive_image ) {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	}

	if ( false === $archive_sale_flash ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6 );
	}

	if ( false === $archive_rating ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}

	if ( false === $archive_price ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	}

	if ( false === $archive_add_to_cart ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}

	if ( false === $archive_title ) {
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	}

	if ( false === $product_tabs ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	}

	if ( false === $product_related ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	}

	if ( false === $product_upsells ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	}

	if ( false === $product_meta ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	}

	if ( false === $product_description ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	}

	if ( false === $breadcrumbs ) {
		remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
	}

	if ( true === $distraction_free ) {
		add_filter( 'parvati_sidebar_layout','parvati_wc_checkout_sidebar_layout' );
		add_filter( 'parvati_footer_widgets','parvati_wc_checkout_footer_widgets' );
	}

	if ( true === $archive_description && ! is_single() && ! is_cart() ) {
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 5 );
		add_action( 'woocommerce_after_subcategory_title', 'parvati_wc_category_description', 12 );
	}
}

/**
 * Set the WC checkout sidebar layout.
 *
 *
 * @param string $sidebar Existing sidebar layout.
 * @return string New sidebar layout.
 */
function parvati_wc_checkout_sidebar_layout( $layout ) {
	if ( is_checkout() ) {
		return 'no-sidebar';
	}

	return $layout;
}

/**
 * Set the WC checkout footer widgets.
 *
 *
 * @param int $widgets Existing number of widgets.
 * @return int New number of widgets.
 */
function parvati_wc_checkout_footer_widgets( $widgets ) {
	if ( is_checkout() ) {
		return '0';
	}

	return $widgets;
}

add_filter( 'wp_nav_menu_items', 'parvati_wc_menu_cart', 10, 2 );
/**
 * Add the WC cart menu item.
 *
 *
 * @param string $nav The HTML list content for the menu items.
 * @param stdClass $args An object containing wp_nav_menu() arguments.
 * @return string The search icon menu item.
 */
function parvati_wc_menu_cart( $nav, $args ) {
	// If our primary menu is set, add the search icon
	if ( $args->theme_location == apply_filters( 'parvati_woocommerce_menu_item_location', 'primary' ) && parvati_wc_get_setting( 'cart_menu_item' ) ) {
		return sprintf(
			'%1$s
			<li class="wc-menu-item %4$s" title="%2$s">
				%3$s
			</li>',
			$nav,
			esc_attr__( 'View your shopping cart', 'parvati-premium' ),
			parvati_wc_cart_link(),
			is_cart() ? 'current-menu-item' : ''
		);
	}

	// Our primary menu isn't set, return the regular nav
    return $nav;
}

/**
 * Build the menu cart link.
 *
 */
function parvati_wc_cart_link() {
	// Kept for backward compatibility.
	$icon = apply_filters( 'parvati_woocommerce_menu_cart_icon', '' );
	ob_start();
	?>
	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-contents" title="<?php esc_attr_e( 'View your shopping cart', 'parvati-premium' ); ?>"><?php echo $icon; ?><span class="amount"><?php if ( WC()->cart->subtotal > 0 ) { echo wp_kses_data( WC()->cart->get_cart_subtotal() ); } ?></span></a>
	<?php
	return ob_get_clean();
}

add_filter( 'woocommerce_add_to_cart_fragments', 'parvati_wc_cart_link_fragment' );
/**
 * Make it so the amount can be updated using AJAX.
 *
 *
 * @param array $fragments
 * @return array
 */
function parvati_wc_cart_link_fragment( $fragments ) {
	global $woocommerce;

	$fragments['.cart-contents span.amount'] = ( WC()->cart->subtotal > 0 ) ? '<span class="amount">' . wp_kses_data( WC()->cart->get_cart_subtotal() ) . '</span>' : '<span class="amount"></span>';

	return $fragments;
}

add_action( 'parvati_inside_navigation', 'parvati_wc_mobile_cart_link' );
add_action( 'parvati_inside_mobile_header', 'parvati_wc_mobile_cart_link' );
/**
 * Add the cart icon in the mobile menu.
 *
 */
function parvati_wc_mobile_cart_link() {
	if ( ! parvati_wc_get_setting( 'cart_menu_item' ) ) {
		return;
	}
	?>
	<div class="mobile-bar-items wc-mobile-cart-items">
		<?php do_action( 'parvati_mobile_cart_items' ); ?>
		<?php echo parvati_wc_cart_link(); ?>
	</div><!-- .mobile-bar-items -->
	<?php

}

add_filter( 'woocommerce_output_related_products_args', 'parvati_wc_related_products_count' );
/**
 * Adjust the related products output.
 *
 *
 * @param array $args
 * @return array
 */
function parvati_wc_related_products_count( $args ) {
    $args['posts_per_page'] = parvati_wc_get_setting( 'related_upsell_columns' );
    $args['columns'] = parvati_wc_get_setting( 'related_upsell_columns' );
    return $args;
}

/**
 * Build our dynamic CSS.
 *
 */
function parvati_wc_css() {
	if ( ! function_exists( 'parvati_get_color_defaults' ) || ! function_exists( 'parvati_get_defaults' ) || ! function_exists( 'parvati_get_default_fonts' ) ) {
		return;
	}

	$defaults = array_merge( parvati_get_color_defaults(), parvati_get_defaults(), parvati_get_default_fonts() );

	// Get our color settings
	$settings = wp_parse_args(
		get_option( 'parvati_settings', array() ),
		$defaults
	);

	// Initiate our CSS class
	require_once PARVATI_LIBRARY_DIRECTORY . 'class-make-css.php';
	$css = new Parvati_Pro_CSS;

	// Product title color
	$css->set_selector( '.woocommerce ul.products li.product .woocommerce-LoopProduct-link' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_product_title_color' ] ) );

	// Product title color hover
	$css->set_selector( '.woocommerce ul.products li.product .woocommerce-LoopProduct-link:hover' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_product_title_color_hover' ] ) );

	// Product title font size
	$css->set_selector( '.woocommerce ul.products li.product .woocommerce-LoopProduct-link h2, .woocommerce ul.products li.product .woocommerce-loop-category__title' );
	$css->add_property( 'font-weight', esc_attr( $settings[ 'wc_product_title_font_weight' ] ) );
	$css->add_property( 'text-transform', esc_attr( $settings[ 'wc_product_title_font_transform' ] ) );
	$css->add_property( 'font-size', esc_attr( $settings[ 'wc_product_title_font_size' ] ), false, 'px' );

	$css->set_selector( '.woocommerce .up-sells ul.products li.product .woocommerce-LoopProduct-link h2, .woocommerce .cross-sells ul.products li.product .woocommerce-LoopProduct-link h2, .woocommerce .related ul.products li.product .woocommerce-LoopProduct-link h2' );
	if ( '' !== $settings[ 'wc_related_product_title_font_size' ] ) {
		$css->add_property( 'font-size', esc_attr( $settings[ 'wc_related_product_title_font_size' ] ), false, 'px' );
	}

	$css->start_media_query( apply_filters( 'parvati_mobile_media_query', '(max-width:768px)' ) );
		$css->set_selector( '.woocommerce ul.products li.product .woocommerce-LoopProduct-link h2, .woocommerce ul.products li.product .woocommerce-loop-category__title' );
		if ( '' !== $settings[ 'mobile_wc_product_title_font_size' ] ) {
			$css->add_property( 'font-size', esc_attr( $settings[ 'mobile_wc_product_title_font_size' ] ), false, 'px' );
		}
	$css->stop_media_query();

	// Primary button
	$css->set_selector( '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button' );
	$css->add_property( 'color', esc_attr( $settings[ 'form_button_text_color' ] ) );
	$css->add_property( 'background-color', esc_attr( $settings[ 'form_button_background_color' ] ) );

	if ( isset( $settings[ 'buttons_font_size' ] ) ) {
		$css->add_property( 'font-weight', esc_attr( $settings[ 'buttons_font_weight' ] ) );
		$css->add_property( 'text-transform', esc_attr( $settings[ 'buttons_font_transform' ] ) );

		if ( '' !== $settings[ 'buttons_font_size' ] ) {
			$css->add_property( 'font-size', absint( $settings[ 'buttons_font_size' ] ), false, 'px' );
		}
	}

	// Primary button hover
	$css->set_selector( '.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover' );
	$css->add_property( 'color', esc_attr( $settings[ 'form_button_text_color_hover' ] ) );
	$css->add_property( 'background-color', esc_attr( $settings[ 'form_button_background_color_hover' ] ) );

	// Alt button
	$css->set_selector( '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_alt_button_text' ] ) );
	$css->add_property( 'background-color', esc_attr( $settings[ 'wc_alt_button_background' ] ) );

	// Alt button hover
	$css->set_selector( '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_alt_button_text_hover' ] ) );
	$css->add_property( 'background-color', esc_attr( $settings[ 'wc_alt_button_background_hover' ] ) );

	// Star rating
	$css->set_selector( '.woocommerce .star-rating span:before, .woocommerce .star-rating:before' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_rating_stars' ] ) );

	// Sale sticker
	$css->set_selector( '.woocommerce span.onsale' );
	$css->add_property( 'background-color', esc_attr( $settings[ 'wc_sale_sticker_background' ] ) );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_sale_sticker_text' ] ) );

	// Price
	$css->set_selector( '.woocommerce ul.products li.product .price, .woocommerce div.product p.price' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_price_color' ] ) );

	// Product tab
	$css->set_selector( '.woocommerce div.product .woocommerce-tabs ul.tabs li a' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_product_tab' ] ) );

	// Highlight product tab
	$css->set_selector( '.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_product_tab_highlight' ] ) );

	// Success message
	$css->set_selector( '.woocommerce-message' );
	$css->add_property( 'background-color', esc_attr( $settings[ 'wc_success_message_background' ] ) );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_success_message_text' ] ) );

	$css->set_selector( 'div.woocommerce-message a.button, div.woocommerce-message a.button:focus, div.woocommerce-message a.button:hover, div.woocommerce-message a, div.woocommerce-message a:focus, div.woocommerce-message a:hover' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_success_message_text' ] ) );

	// Info message
	$css->set_selector( '.woocommerce-info' );
	$css->add_property( 'background-color', esc_attr( $settings[ 'wc_info_message_background' ] ) );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_info_message_text' ] ) );

	$css->set_selector( 'div.woocommerce-info a.button, div.woocommerce-info a.button:focus, div.woocommerce-info a.button:hover, div.woocommerce-info a, div.woocommerce-info a:focus, div.woocommerce-info a:hover' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_info_message_text' ] ) );

	// Info message
	$css->set_selector( '.woocommerce-error' );
	$css->add_property( 'background-color', esc_attr( $settings[ 'wc_error_message_background' ] ) );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_error_message_text' ] ) );

	$css->set_selector( 'div.woocommerce-error a.button, div.woocommerce-error a.button:focus, div.woocommerce-error a.button:hover, div.woocommerce-error a, div.woocommerce-error a:focus, div.woocommerce-error a:hover' );
	$css->add_property( 'color', esc_attr( $settings[ 'wc_error_message_text' ] ) );

	// Archive short description
	$css->set_selector( '.woocommerce-product-details__short-description' );
	if ( '' !== $settings[ 'content_text_color' ] ) {
		$css->add_property( 'color', esc_attr( $settings[ 'content_text_color' ] ) );
	} else {
		$css->add_property( 'color', esc_attr( $settings[ 'text_color' ] ) );
	}

	return $css->css_output();
}

add_action( 'wp_enqueue_scripts', 'parvati_wc_enqueue_css', 100 );
/**
 * Enqueue our dynamic CSS.
 *
 */
function parvati_wc_enqueue_css() {
	wp_add_inline_style( 'parvati-woocommerce', parvati_wc_css() );
}

/**
 * Open WC image wrapper.
 *
 */
function parvati_wc_image_wrapper_open() {
	if ( parvati_wc_get_setting( 'product_archive_image' ) ) {
		echo '<div class="wc-product-image"><div class="inside-wc-product-image">';
	}
}

/**
 * Close WC image wrapper.
 *
 */
function parvati_wc_image_wrapper_close() {
	if ( parvati_wc_get_setting( 'product_archive_image' ) ) {
		echo '</div></div>';
	}
}

add_filter( 'post_class', 'parvati_wc_product_has_gallery' );
add_filter( 'product_cat_class', 'parvati_wc_product_has_gallery' );
/**
 * Add product image post classes to products.
 *
 *
 * @param array $classes Existing classes.
 * @return array New classes.
 */
function parvati_wc_product_has_gallery( $classes ) {

	$post_type = get_post_type( get_the_ID() );

	if ( 'product' == $post_type && method_exists( 'WC_Product', 'get_gallery_image_ids' ) ) {

		$product = new WC_Product( get_the_ID() );
		$attachment_ids = $product->get_gallery_image_ids();

		if ( $attachment_ids && parvati_wc_get_setting( 'product_secondary_image' ) && parvati_wc_get_setting( 'product_archive_image' ) && has_post_thumbnail() ) {
			$classes[] = 'wc-has-gallery';
		}
	}

	return $classes;
}

add_action( 'woocommerce_before_shop_loop_item_title', 'parvati_wc_secondary_product_image' );
/**
 * Add secondary product image.
 *
 */
function parvati_wc_secondary_product_image() {

	if ( ! method_exists( 'WC_Product', 'get_gallery_image_ids' ) ) {
		return;
	}

	$product = new WC_Product( get_the_ID() );
	$attachment_ids = $product->get_gallery_image_ids();

	if ( $attachment_ids && parvati_wc_get_setting( 'product_secondary_image' ) && parvati_wc_get_setting( 'product_archive_image' ) && has_post_thumbnail() ) {
		$secondary_image_id = $attachment_ids['0'];
		echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) );
	}
}

add_filter('woocommerce_product_get_rating_html', 'parvati_wc_rating_html', 10, 2);
/**
 * Always show ratings area to make sure products are similar heights.
 *
 *
 * @param string $rating_html
 * @param int $rating
 * @return string
 */
function parvati_wc_rating_html( $rating_html, $rating ) {
	if ( $rating > 0 ) {
		$title = sprintf( __( 'Rated %s out of 5', 'parvati-premium' ), $rating );
	} else {
		$title = __( 'Not yet rated','parvati-premium' );
		$rating = 0;
	}

	$rating_html  = '<div class="star-rating" title="' . esc_attr( $title ) . '">';
	$rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . __( 'out of 5', 'parvati-premium' ) . '</span>';
	$rating_html .= '</div>';
	return $rating_html;
}

/**
 * Add WC category description.
 *
 *
 * @param array $category
 * @return string
 */
function parvati_wc_category_description( $category ) {
	$prod_term = get_term( $category->term_id, 'product_cat' );
	$description = $prod_term->description;
	echo '<div class="woocommerce-product-details__short-description">' . $description . '</div>';
}
