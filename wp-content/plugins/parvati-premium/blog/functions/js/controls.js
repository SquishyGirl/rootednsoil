jQuery( document ).ready( function($) {
	// Featured image controls
	var featured_image_archive_controls = [
		'parvati_blog_settings-post_image',
		'parvati_blog_settings-post_image_padding',
		'parvati_blog_settings-post_image_position',
		'parvati_blog_settings-post_image_alignment',
		'parvati_blog_settings-post_image_width',
		'parvati_blog_settings-post_image_height',
		'post_image_apply_sizes',
	];

	$.each( featured_image_archive_controls, function( index, value ) {
		$( '#customize-control-' + value ).attr( 'data-control-section', 'featured-image-archives' );
	} );

	var featured_image_single_controls = [
		'parvati_blog_settings-single_post_image',
		'parvati_blog_settings-single_post_image_padding',
		'parvati_blog_settings-single_post_image_position',
		'parvati_blog_settings-single_post_image_alignment',
		'parvati_blog_settings-single_post_image_width',
		'parvati_blog_settings-single_post_image_height',
		'single_post_image_apply_sizes',
	];

	$.each( featured_image_single_controls, function( index, value ) {
		$( '#customize-control-' + value ).attr( 'data-control-section', 'featured-image-single' ).css( {
			visibility: 'hidden',
			height: '0',
			width: '0',
			margin: '0',
			overflow: 'hidden'
		} );
	} );

	var featured_image_page_controls = [
		'parvati_blog_settings-page_post_image',
		'parvati_blog_settings-page_post_image_padding',
		'parvati_blog_settings-page_post_image_position',
		'parvati_blog_settings-page_post_image_alignment',
		'parvati_blog_settings-page_post_image_width',
		'parvati_blog_settings-page_post_image_height',
		'page_post_image_apply_sizes',
	];

	$.each( featured_image_page_controls, function( index, value ) {
		$( '#customize-control-' + value ).attr( 'data-control-section', 'featured-image-page' ).css( {
			visibility: 'hidden',
			height: '0',
			width: '0',
			margin: '0',
			overflow: 'hidden'
		} );
	} );

	// Post meta controls
	var post_meta_archive_controls = [
		'parvati_settings-post_content',
		'parvati_blog_settings-excerpt_length',
		'parvati_blog_settings-read_more',
		'parvati_blog_settings-read_more_button',
		'parvati_blog_settings-date',
		'parvati_blog_settings-author',
		'parvati_blog_settings-categories',
		'parvati_blog_settings-tags',
		'parvati_blog_settings-comments',
		'parvati_blog_settings-infinite_scroll',
		'parvati_blog_settings-infinite_scroll_button',
		'blog_masonry_load_more_control',
		'blog_masonry_loading_control',
	];

	$.each( post_meta_archive_controls, function( index, value ) {
		$( '#customize-control-' + value ).attr( 'data-control-section', 'post-meta-archives' );
	} );

	var post_meta_single_controls = [
		'parvati_blog_settings-single_date',
		'parvati_blog_settings-single_author',
		'parvati_blog_settings-single_categories',
		'parvati_blog_settings-single_tags',
		'parvati_blog_settings-single_post_navigation',
	];

	$.each( post_meta_single_controls, function( index, value ) {
		$( '#customize-control-' + value ).attr( 'data-control-section', 'post-meta-single' ).css( {
			visibility: 'hidden',
			height: '0',
			width: '0',
			margin: '0',
			overflow: 'hidden'
		} );
	} );
});
