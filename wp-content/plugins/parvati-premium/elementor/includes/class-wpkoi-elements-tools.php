<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPKoi_Elements_Tools' ) ) {

	/**
	 * Define WPKoi_Elements_Tools class
	 */
	class WPKoi_Elements_Tools {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Get categories list.
		 */
		public function get_categories() {

			$categories = get_categories();

			if ( empty( $categories ) || ! is_array( $categories ) ) {
				return array();
			}

			return wp_list_pluck( $categories, 'name', 'term_id' );

		}

		/**
		 * Returns icons data list.
		 */
		public function get_theme_icons_data() {

			$default = array(
				'icons'  => false,
				'format' => 'fa %s',
				'file'   => false,
			);

			/**
			 * Filter default icon data before useing
			 */
			$icon_data = apply_filters( 'wpkoi-elements/controls/icon/data', $default );
			$icon_data = array_merge( $default, $icon_data );

			return $icon_data;
		}

		/**
		 * Returns array with numbers in $index => $name format for numeric selects
		 */
		public function get_select_range( $to = 10 ) {
			$range = range( 1, $to );
			return array_combine( $range, $range );
		}

		/**
		 * Returns carousel arrow
		 */
		public function get_carousel_arrow( $classes ) {

			$format = apply_filters( 'wpkoi_elements/carousel/arrows_format', '<i class="%s wpkoi-arrow"></i>', $classes );

			return sprintf( $format, implode( ' ', $classes ) );
		}

		/**
		 * Get post types options list
		 */
		public function get_post_types() {

			$post_types = get_post_types( array( 'public' => true ), 'objects' );

			$deprecated = apply_filters(
				'wpkoi-elements/post-types-list/deprecated',
				array( 'attachment', 'elementor_library' )
			);

			$result = array();

			if ( empty( $post_types ) ) {
				return $result;
			}

			foreach ( $post_types as $slug => $post_type ) {

				if ( in_array( $slug, $deprecated ) ) {
					continue;
				}

				$result[ $slug ] = $post_type->label;

			}

			return $result;

		}

		/**
		 * Return availbale arrows list
		 */
		public function get_available_prev_arrows_list() {

			return apply_filters(
				'wpkoi_elements/carousel/available_arrows/prev',
				array(
					'fa fa-angle-left'          => __( 'Angle', 'wpkoi-elements' ),
					'fa fa-chevron-left'        => __( 'Chevron', 'wpkoi-elements' ),
					'fa fa-angle-double-left'   => __( 'Angle Double', 'wpkoi-elements' ),
					'fa fa-arrow-left'          => __( 'Arrow', 'wpkoi-elements' ),
					'fa fa-caret-left'          => __( 'Caret', 'wpkoi-elements' ),
					'fa fa-long-arrow-left'     => __( 'Long Arrow', 'wpkoi-elements' ),
					'fa fa-arrow-circle-left'   => __( 'Arrow Circle', 'wpkoi-elements' ),
					'fa fa-chevron-circle-left' => __( 'Chevron Circle', 'wpkoi-elements' ),
					'fa fa-caret-square-o-left' => __( 'Caret Square', 'wpkoi-elements' ),
				)
			);

		}

		/**
		 * Return availbale arrows list
		 */
		public function get_available_next_arrows_list() {

			return apply_filters(
				'wpkoi_elements/carousel/available_arrows/next',
				array(
					'fa fa-angle-right'          => __( 'Angle', 'wpkoi-elements' ),
					'fa fa-chevron-right'        => __( 'Chevron', 'wpkoi-elements' ),
					'fa fa-angle-double-right'   => __( 'Angle Double', 'wpkoi-elements' ),
					'fa fa-arrow-right'          => __( 'Arrow', 'wpkoi-elements' ),
					'fa fa-caret-right'          => __( 'Caret', 'wpkoi-elements' ),
					'fa fa-long-arrow-right'     => __( 'Long Arrow', 'wpkoi-elements' ),
					'fa fa-arrow-circle-right'   => __( 'Arrow Circle', 'wpkoi-elements' ),
					'fa fa-chevron-circle-right' => __( 'Chevron Circle', 'wpkoi-elements' ),
					'fa fa-caret-square-o-right' => __( 'Caret Square', 'wpkoi-elements' ),
				)
			);

		}

		/**
		 * Returns the instance.
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of WPKoi_Elements_Tools
 */
function wpkoi_elements_tools() {
	return WPKoi_Elements_Tools::get_instance();
}
