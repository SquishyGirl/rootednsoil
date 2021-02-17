<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists('wpkoi_events') ) {

	// Register Custom Post Type
	function wpkoi_events() {
	
		$labels = array(
			'name'                  => _x( 'Events', 'Post Type General Name', 'parvati-premium' ),
			'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'parvati-premium' ),
			'menu_name'             => __( 'WPKoi Events', 'parvati-premium' ),
			'name_admin_bar'        => __( 'WPKoi Events', 'parvati-premium' ),
			'archives'              => __( 'Event Archives', 'parvati-premium' ),
			'attributes'            => __( 'Event Attributes', 'parvati-premium' ),
			'parent_item_colon'     => __( 'Parent Item:', 'parvati-premium' ),
			'all_items'             => __( 'All Items', 'parvati-premium' ),
			'add_new_item'          => __( 'Add New Item', 'parvati-premium' ),
			'add_new'               => __( 'Add New', 'parvati-premium' ),
			'new_item'              => __( 'New Item', 'parvati-premium' ),
			'edit_item'             => __( 'Edit Item', 'parvati-premium' ),
			'update_item'           => __( 'Update Item', 'parvati-premium' ),
			'view_item'             => __( 'View Item', 'parvati-premium' ),
			'view_items'            => __( 'View Items', 'parvati-premium' ),
			'search_items'          => __( 'Search Item', 'parvati-premium' ),
			'not_found'             => __( 'Not found', 'parvati-premium' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'parvati-premium' ),
			'featured_image'        => __( 'Featured Image', 'parvati-premium' ),
			'set_featured_image'    => __( 'Set featured image', 'parvati-premium' ),
			'remove_featured_image' => __( 'Remove featured image', 'parvati-premium' ),
			'use_featured_image'    => __( 'Use as featured image', 'parvati-premium' ),
			'insert_into_item'      => __( 'Insert into item', 'parvati-premium' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'parvati-premium' ),
			'items_list'            => __( 'Items list', 'parvati-premium' ),
			'items_list_navigation' => __( 'Items list navigation', 'parvati-premium' ),
			'filter_items_list'     => __( 'Filter items list', 'parvati-premium' ),
		);
		$rewrite = array(
			'slug'                  => 'events',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Event', 'parvati-premium' ),
			'description'           => __( 'Add Your events with WPKoi Events module', 'parvati-premium' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
			'taxonomies'            => array( 'wpkoi-events-category', ' wpkoi-events-tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-megaphone',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
		);
		register_post_type( 'wpkoi-events', $args );
		register_taxonomy(
			'wpkoi-events-category',
			'wpkoi-events',
			array(
				'hierarchical'  => true,
				'label'         => __( 'Events Categories', 'parvati-premium' ),
				'singular_name' => __( 'Events Category', 'parvati-premium' ),
				'query_var'		=> true,
				'rewrite' => array( 'slug' => 'events-category' ),
			)
		);
		register_taxonomy(
			'wpkoi-events-tag',
			'wpkoi-events',
			array(
				'hierarchical' => false,
				'label'         => __( 'Events Tags', 'parvati-premium' ),
				'singular_name' => __( 'Events Tag', 'parvati-premium' ),
				'show_ui' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array( 'slug' => 'events-tag' )
			)
		);
	
	}
	add_action( 'init', 'wpkoi_events', 0 );

}

if ( ! function_exists('wpkoi_events_single_template') ) {
	/* Filter the single_template with our custom function*/
	add_filter('single_template', 'wpkoi_events_single_template');
	function wpkoi_events_single_template($single) {
		global $post;
	
		/* Checks for single template by post type */
		if ( $post->post_type == 'wpkoi-events' ) {
			return plugin_dir_path( __FILE__ ) . 'single-wpkoi-events.php';
		}
		return $single;
	}
}

if ( ! function_exists('wpkoi_events_archive_template') ) {
	/* Filter the archive_template with our custom function*/
	add_filter( 'archive_template', 'wpkoi_events_archive_template' ) ;
	function wpkoi_events_archive_template( $archive_template ) {
		 global $post;
	
		 if ( is_post_type_archive ( 'wpkoi-events' ) ) {
			  return plugin_dir_path( __FILE__ ) . 'archive-wpkoi-events.php';
		 }
		 return $archive_template;
	}
}