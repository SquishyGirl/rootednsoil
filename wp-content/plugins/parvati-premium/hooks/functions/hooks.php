<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'parvati_execute_hooks' ) ) {
	function parvati_execute_hooks( $id ) {
		$hooks = get_option( 'parvati_hooks' );

		$content = isset( $hooks[$id] ) ? $hooks[$id] : null;

		$disable = isset( $hooks[$id . '_disable'] ) ? $hooks[$id . '_disable'] : null;

		if ( ! $content || 'true' == $disable ) {
			return;
		}

		$php = isset( $hooks[$id . '_php'] ) ? $hooks[$id . '_php'] : null;

		$value = do_shortcode( $content );

		if ( 'true' == $php && ! defined( 'PARVATI_HOOKS_DISALLOW_PHP' ) ) {
			eval( "?>$value<?php " );
		} else {
			echo $value;
		}
	}
}

if ( ! function_exists( 'parvati_hooks_wp_head' ) ) {
	add_action( 'wp_head', 'parvati_hooks_wp_head' );

	function parvati_hooks_wp_head() {
		parvati_execute_hooks( 'parvati_wp_head' );
	}
}

if ( ! function_exists( 'parvati_hooks_before_header' ) ) {
	add_action( 'parvati_before_header', 'parvati_hooks_before_header', 4 );

	function parvati_hooks_before_header() {
		parvati_execute_hooks( 'parvati_before_header' );
	}
}

if ( ! function_exists( 'parvati_hooks_before_header_content' ) ) {
	add_action( 'parvati_before_header_content', 'parvati_hooks_before_header_content' );

	function parvati_hooks_before_header_content() {
		parvati_execute_hooks( 'parvati_before_header_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_after_header_content' ) ) {
	add_action( 'parvati_after_header_content', 'parvati_hooks_after_header_content' );

	function parvati_hooks_after_header_content() {
		parvati_execute_hooks( 'parvati_after_header_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_after_header' ) ) {
	add_action( 'parvati_after_header', 'parvati_hooks_after_header' );

	function parvati_hooks_after_header() {
		parvati_execute_hooks( 'parvati_after_header' );
	}
}

if ( ! function_exists( 'parvati_hooks_inside_main_content' ) ) {
	add_action( 'parvati_before_main_content', 'parvati_hooks_inside_main_content', 9 );

	function parvati_hooks_inside_main_content() {
		parvati_execute_hooks( 'parvati_before_main_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_before_content' ) ) {
	add_action( 'parvati_before_content', 'parvati_hooks_before_content' );

	function parvati_hooks_before_content() {
		parvati_execute_hooks( 'parvati_before_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_after_entry_header' ) ) {
	add_action( 'parvati_after_entry_header', 'parvati_hooks_after_entry_header' );

	function parvati_hooks_after_entry_header() {
		parvati_execute_hooks( 'parvati_after_entry_header' );
	}
}

if ( ! function_exists( 'parvati_hooks_after_content' ) ) {
	add_action( 'parvati_after_content', 'parvati_hooks_after_content' );

	function parvati_hooks_after_content() {
		parvati_execute_hooks( 'parvati_after_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_before_right_sidebar_content' ) ) {
	add_action( 'parvati_before_right_sidebar_content', 'parvati_hooks_before_right_sidebar_content', 5 );

	function parvati_hooks_before_right_sidebar_content() {
		parvati_execute_hooks( 'parvati_before_right_sidebar_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_after_right_sidebar_content' ) ) {
	add_action( 'parvati_after_right_sidebar_content', 'parvati_hooks_after_right_sidebar_content' );

	function parvati_hooks_after_right_sidebar_content() {
		parvati_execute_hooks( 'parvati_after_right_sidebar_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_before_left_sidebar_content' ) ) {
	add_action( 'parvati_before_left_sidebar_content', 'parvati_hooks_before_left_sidebar_content', 5 );

	function parvati_hooks_before_left_sidebar_content() {
		parvati_execute_hooks( 'parvati_before_left_sidebar_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_after_left_sidebar_content' ) ) {
	add_action( 'parvati_after_left_sidebar_content', 'parvati_hooks_after_left_sidebar_content' );

	function parvati_hooks_after_left_sidebar_content() {
		parvati_execute_hooks( 'parvati_after_left_sidebar_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_before_footer' ) ) {
	add_action( 'parvati_before_footer', 'parvati_hooks_before_footer' );

	function parvati_hooks_before_footer() {
		parvati_execute_hooks( 'parvati_before_footer' );
	}
}

if ( ! function_exists( 'parvati_hooks_after_footer_widgets' ) ) {
	add_action( 'parvati_after_footer_widgets', 'parvati_hooks_after_footer_widgets' );

	function parvati_hooks_after_footer_widgets() {
		parvati_execute_hooks( 'parvati_after_footer_widgets' );
	}
}

if ( ! function_exists( 'parvati_hooks_before_footer_content' ) ) {
	add_action( 'parvati_before_footer_content', 'parvati_hooks_before_footer_content' );

	function parvati_hooks_before_footer_content() {
		parvati_execute_hooks( 'parvati_before_footer_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_after_footer_content' ) ) {
	add_action( 'parvati_after_footer_content', 'parvati_hooks_after_footer_content' );

	function parvati_hooks_after_footer_content() {
		parvati_execute_hooks( 'parvati_after_footer_content' );
	}
}

if ( ! function_exists( 'parvati_hooks_wp_footer' ) ) {
	add_action( 'wp_footer', 'parvati_hooks_wp_footer' );

	function parvati_hooks_wp_footer() {
		parvati_execute_hooks( 'parvati_wp_footer' );
	}
}
