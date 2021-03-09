<?php

/**
 * Get Post Data
 */
function wpkoi_elements_get_post_data( $args ) {
    $defaults = array(
        'posts_per_page'   => 5,
        'offset'           => 0,
        'category'         => '',
        'category_name'    => '',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'include'          => '',
        'exclude'          => '',
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => 'post',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'author'           => '',
        'author_name'      => '',
        'post_status'      => 'publish',
        'suppress_filters' => true,
        'tag__in'          => '',
        'post__not_in'     => '',
    );

    $atts = wp_parse_args( $args, $defaults );

    $posts = get_posts( $atts );

    return $posts;
}

/**
 * Get All POst Types
 */
function wpkoi_elements_get_post_types(){

    $wpkoi_elements_cpts = get_post_types( array( 'public'   => true, 'show_in_nav_menus' => true ) );
    $wpkoi_elements_exclude_cpts = array( 'elementor_library', 'attachment', 'product' );

    foreach ( $wpkoi_elements_exclude_cpts as $exclude_cpt ) {
        unset($wpkoi_elements_cpts[$exclude_cpt]);
    }

    $post_types = array_merge($wpkoi_elements_cpts);
    return $post_types;
}

/**
 * Add REST API support to an already registered post type.
 */
add_action( 'init', 'wpkoi_elements_custom_post_type_rest_support', 25 );
function wpkoi_elements_custom_post_type_rest_support() {
    global $wp_post_types;

    $post_types = wpkoi_elements_get_post_types();
    foreach( $post_types as $post_type ) {
        $post_type_name = $post_type;
        if( isset( $wp_post_types[ $post_type_name ] ) ) {
            $wp_post_types[$post_type_name]->show_in_rest = true;
            $wp_post_types[$post_type_name]->rest_base = $post_type_name;
            $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
        }
    }

}

/**
 * Post Settings Parameter
 */
function wpkoi_elements_get_post_settings($settings){
    $post_args['post_type'] = $settings['wpkoi_elements_post_type'];

    if($settings['wpkoi_elements_post_type'] == 'post'){
        $post_args['category'] = $settings['category'];
    }

    $wpkoi_elements_tiled_post_author = '';
    $wpkoi_elements_tiled_post_authors = $settings['wpkoi_elements_post_authors'];
    if ( !empty( $wpkoi_elements_tiled_post_authors) ) {
        $wpkoi_elements_tiled_post_author = implode( ",", $wpkoi_elements_tiled_post_authors );
    }

    $post_args['posts_per_page'] = $settings['wpkoi_elements_posts_count'];
    $post_args['offset'] = $settings['wpkoi_elements_post_offset'];
    $post_args['orderby'] = $settings['wpkoi_elements_post_orderby'];
    $post_args['order'] = $settings['wpkoi_elements_post_order'];
    $post_args['tag__in'] = $settings['wpkoi_elements_post_tags'];
    $post_args['post__not_in'] = $settings['wpkoi_elements_post_exclude_posts'];
    $post_args['author'] = $wpkoi_elements_tiled_post_author;

    return $post_args;
}

/**
 * Getting Excerpts By Post Id
 */
function wpkoi_elements_get_excerpt_by_id($post_id,$excerpt_length){
    $the_post = get_post($post_id); //Gets post ID

    $the_excerpt = null;
    if ($the_post)
    {
        $the_excerpt = $the_post->post_excerpt ? $the_post->post_excerpt : $the_post->post_content;
    }

    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

     if(count($words) > $excerpt_length) :
         array_pop($words);
         array_push($words, '...');
         $the_excerpt = implode(' ', $words);
     endif;

     return $the_excerpt;
}

/**
 * Get Post Thumbnail Size
 */
function wpkoi_elements_get_thumbnail_sizes(){
    $sizes = get_intermediate_image_sizes();
    foreach($sizes as $s){
        $ret[$s] = $s;
    }

    return $ret;
}

/**
 * Post Orderby Options
 */
function wpkoi_elements_get_post_orderby_options(){
    $orderby = array(
        'ID' => 'Post ID',
        'author' => 'Post Author',
        'title' => 'Title',
        'date' => 'Date',
        'modified' => 'Last Modified Date',
        'parent' => 'Parent Id',
        'rand' => 'Random',
        'comment_count' => 'Comment Count',
        'menu_order' => 'Menu Order',
    );

    return $orderby;
}

/**
 * Get Post Categories
 */
function wpkoi_elements_post_type_categories(){
    $terms = get_terms( array(
        'taxonomy' => 'category',
        'hide_empty' => true,
    ));

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $options[ $term->term_id ] = $term->name;
    }
    }

    return $options;
}

/**
 * WooCommerce Product Query
 */
function wpkoi_elements_woocommerce_product_categories(){
    $terms = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    ));

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $options[ $term->slug ] = $term->name;
    }
    return $options;
    }
}

/**
 * WooCommerce Get Product By Id
 */
function wpkoi_elements_woocommerce_product_get_product_by_id(){
    $postlist = get_posts(array(
        'post_type' => 'product',
        'showposts' => 9999,
    ));
    $posts = array();

    if ( ! empty( $postlist ) && ! is_wp_error( $postlist ) ){
    foreach ( $postlist as $post ) {
        $options[ $post->ID ] = $post->post_title;
    }
    return $options;

    }
}

/**
 * WooCommerce Get Product Category By Id
 */
function wpkoi_elements_woocommerce_product_categories_by_id(){
    $terms = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    ));

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $options[ $term->term_id ] = $term->name;
    }
    return $options;
    }

}

// Get all elementor page templates
if ( !function_exists('wpkoi_elements_get_page_templates') ) {
    function wpkoi_elements_get_page_templates(){
        $page_templates = get_posts( array(
            'post_type'         => 'elementor_library',
            'posts_per_page'    => -1
        ));

        $options = array();

        if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){
            foreach ( $page_templates as $post ) {
                $options[ $post->ID ] = $post->post_title;
            }
        }
        return $options;
    }
}

// Get all Authors
if ( !function_exists('wpkoi_elements_get_authors') ) {
    function wpkoi_elements_get_authors() {

        $options = array();

        $users = get_users();

        foreach ( $users as $user ) {
            $options[ $user->ID ] = $user->display_name;
        }

        return $options;
    }
}

// Get all Tags
if ( !function_exists('wpkoi_elements_get_tags') ) {
    function wpkoi_elements_get_tags() {

        $options = array();

        $tags = get_tags();

        foreach ( $tags as $tag ) {
            $options[ $tag->term_id ] = $tag->name;
        }

        return $options;
    }
}

// Get all Posts
if ( !function_exists('wpkoi_elements_get_posts') ) {
    function wpkoi_elements_get_posts() {

        $post_list = get_posts( array(
            'post_type'         => 'post',
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => -1,
        ) );

        $posts = array();

        if ( ! empty( $post_list ) && ! is_wp_error( $post_list ) ) {
            foreach ( $post_list as $post ) {
               $posts[ $post->ID ] = $post->post_title;
            }
        }

        return $posts;
    }
}