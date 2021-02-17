<?php
defined( 'WPINC' ) or die;

if ( ! function_exists( 'add_parvati_pageheader_meta_box' ) ) {
	add_action( 'add_meta_boxes', 'add_parvati_pageheader_meta_box', 50 );
	/**
	 * Generate the page header metabox.
	 *
	 */
	function add_parvati_pageheader_meta_box() {
		// Set user role - make filterable
		$allowed = apply_filters( 'parvati_pageheader_metabox_capability', 'edit_posts' );

		// If not an administrator, don't show the metabox
		if ( ! current_user_can( $allowed ) ) {
			return;
		}

		$stored_meta = (array) get_post_meta( get_the_ID() );

		// Set defaults to avoid PHP notices
		$stored_meta['_meta-parvati-page-header-image'][0] = ( isset( $stored_meta['_meta-parvati-page-header-image'][0] ) ) ? $stored_meta['_meta-parvati-page-header-image'][0] : '';
		$stored_meta['_meta-parvati-page-header-image-id'][0] = ( isset( $stored_meta['_meta-parvati-page-header-image-id'][0] ) ) ? $stored_meta['_meta-parvati-page-header-image-id'][0] : '';
		$stored_meta['_meta-parvati-page-header-content'][0] = ( isset( $stored_meta['_meta-parvati-page-header-content'][0] ) ) ? $stored_meta['_meta-parvati-page-header-content'][0] : '';

		$args = array( 'public' => true );
		$post_types = get_post_types( $args );

		// Bail if we're not using the old Page Header meta box
		if ( 'parvati_pageheader' !== get_post_type() && '' == $stored_meta['_meta-parvati-page-header-content'][0] && '' == $stored_meta['_meta-parvati-page-header-image'][0] && '' == $stored_meta['_meta-parvati-page-header-image-id'][0] ) {
			if ( ! defined( 'PARVATI_LAYOUT_META_BOX' ) ) {
				foreach ( $post_types as $type ) {
					if ( 'attachment' !== $type ) {
						add_meta_box(
							'parvati_select_page_header_meta_box',
							__( 'Page Header', 'parvati-premium' ),
							'parvati_do_select_page_header_meta_box',
							$type,
							'normal',
							'high'
						);
					}
				}
			}

			if ( ! apply_filters( 'parvati_pageheader_legacy_metabox', false ) ) {
				return;
			}
		}

		array_push( $post_types, 'parvati_pageheader' );
		foreach ($post_types as $type) {
			if ( 'attachment' !== $type ) {
				add_meta_box(
					'parvati_pageheader_meta_box',
					__( 'Page Header', 'parvati-premium' ),
					'show_parvati_pageheader_meta_box',
					$type,
					'normal',
					'high'
				);
			}
		}
	}
}

if ( ! function_exists( 'parvati_pageheader_metabox_enqueue' ) ) {
	add_action( 'admin_enqueue_scripts', 'parvati_pageheader_metabox_enqueue' );
	/**
	 * Add our metabox scripts
	 */
	function parvati_pageheader_metabox_enqueue( $hook ) {
		// I prefer to enqueue the styles only on pages that are using the metaboxes
		if ( in_array( $hook, array( "post.php", "post-new.php" ) ) ) {
			$args = array( 'public' => true );
			$post_types = get_post_types( $args );

			$screen = get_current_screen();
			$post_type = $screen->id;

			if ( in_array( $post_type, (array) $post_types ) || 'parvati_pageheader' == get_post_type() ){
				wp_enqueue_media();
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker-alpha', plugin_dir_url( __FILE__ ) . 'js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), PARVATI_PAGE_HEADER_VERSION );
				wp_enqueue_style( 'parvati-page-header-metabox', plugin_dir_url( __FILE__ ) . 'css/metabox.css', array(), PARVATI_PAGE_HEADER_VERSION );
				wp_enqueue_script( 'parvati-lc-switch', plugin_dir_url( __FILE__ ) . 'js/lc_switch.js', array( 'jquery' ), PARVATI_PAGE_HEADER_VERSION, false );
				wp_enqueue_script( 'parvati-page-header-metabox', plugin_dir_url( __FILE__ ) . 'js/metabox.js', array( 'jquery','parvati-lc-switch', 'wp-color-picker' ), PARVATI_PAGE_HEADER_VERSION, false );

				if ( function_exists( 'wp_add_inline_script' ) && function_exists( 'parvati_get_default_color_palettes' ) ) {
					// Grab our palette array and turn it into JS
					$palettes = json_encode( parvati_get_default_color_palettes() );

					// Add our custom palettes
					// json_encode takes care of escaping
					wp_add_inline_script( 'wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . $palettes . ';' );
				}
			}
		}
	}
}

/**
 * Build our Select Page Header meta box.
 *
 */
function parvati_do_select_page_header_meta_box( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'parvati_pageheader_nonce' );
    $stored_meta = get_post_meta( $post->ID );
	$stored_meta['_parvati-select-page-header'][0] = ( isset( $stored_meta['_parvati-select-page-header'][0] ) ) ? $stored_meta['_parvati-select-page-header'][0] : '';

	$page_headers = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'title',
		'post_type' => 'parvati_pageheader',
	));

	if ( count( $page_headers ) > 0 ) :
	?>
	<p>
		<select name="_parvati-select-page-header" id="_parvati-select-page-header">
			<option value="" <?php selected( $stored_meta['_parvati-select-page-header'][0], '' ); ?>></option>
			<?php
			foreach( $page_headers as $header ) {
				printf( '<option value="%1$s" %2$s>%3$s</option>',
					$header->ID,
					selected( $stored_meta['_parvati-select-page-header'][0], $header->ID ),
					$header->post_title
				);
			}
			?>
		</select>
	</p>
    <?php else : ?>
		<p>
			<?php
			printf( __( 'No Page Headers found. Want to <a href="%1$s" target="_blank">create one</a>?', 'parvati-premium' ),
				esc_url( admin_url( 'post-new.php?post_type=parvati_pageheader' ) )
			);
			?>
		</p>
	<?php endif;
}

if ( ! function_exists( 'show_parvati_pageheader_meta_box' ) ) {
	/**
	 * Outputs the content of the metabox
	 * This could use some cleaning up
	 */
	function show_parvati_pageheader_meta_box( $post ) {
	    wp_nonce_field( basename( __FILE__ ), 'parvati_pageheader_nonce' );
		$show_excerpt_option = ( has_post_thumbnail() ) ? 'style="display:none;"' : 'style="display:block;"';

		$content_required = sprintf(
			'<div class="page-header-content-required" %2$s><p>%1$s</p></div>',
			__( 'Content is required for the below settings to work.', 'parvati-premium' ),
			'' !== parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content', true ) ? 'style="display:none"' : ''
		);

		if ( '' !== parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content', true ) ) {
			?>
			<script>
				jQuery(document).ready(function($) {
					$('#parvati-image-tab').hide();
					$('#parvati-content-tab').show();
					$('.parvati-tabs-menu .content-settings').addClass('parvati-current');
					$('.parvati-tabs-menu .image-settings').removeClass('parvati-current');
				});
			</script>
			<?php
		}
		?>
		<div id="parvati-tabs-container">
			<ul class="parvati-tabs-menu">
				<li class="parvati-current image-settings">
					<a href="#parvati-image-tab"><?php _e( 'Image', 'parvati-premium' ); ?></a>
				</li>

				<li class="content-settings">
					<a href="#parvati-content-tab"><?php _e( 'Content', 'parvati-premium' ); ?></a>
				</li>

				<li class="video-settings">
					<a href="#parvati-video-background-tab"><?php _e( 'Background Video', 'parvati-premium' ); ?></a>
				</li>

				<?php if ( parvati_pageheader_logo_exists() || parvati_pageheader_navigation_logo_exists() ) : ?>
					<li class="logo-settings">
						<a href="#parvati-logo-tab"><?php _e( 'Logo', 'parvati-premium' ); ?></a>
					</li>
				<?php endif; ?>

				<li class="advanced-settings">
					<a href="#parvati-advanced-tab"><?php _e( 'Advanced', 'parvati-premium' ); ?></a>
				</li>

				<?php if ( 'post' == get_post_type() && !is_single() ) : ?>
					<div class="show-in-excerpt" <?php echo $show_excerpt_option; ?>>
						<p>
							<label for="_meta-parvati-page-header-add-to-excerpt"><strong><?php _e( 'Add to excerpt', 'parvati-premium' );?></strong></label><br />
							<input class="add-to-excerpt" type="checkbox" name="_meta-parvati-page-header-add-to-excerpt" id="_meta-parvati-page-header-add-to-excerpt" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-add-to-excerpt', true ), 'yes' ); ?> />
						</p>
					</div>
				<?php endif; ?>
			</ul>
			<div class="parvati-tab">
				<div id="parvati-image-tab" class="parvati-tab-content" style="display:block;">
					<?php
					$show_featured_image_message = ( has_post_thumbnail() && '' == parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-id', true ) ) ? 'style="display:block;"' : 'style="display:none;"';
					$remove_button = ( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image', true ) != "") ? 'style="display:inline-block;"' : 'style="display:none;"';
					$show_image_settings = ( has_post_thumbnail() || '' !== parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-id', true ) ) ? 'style="display:block;"' : 'style="display: none;"';
					$no_image_selected = ( ! has_post_thumbnail() && '' == parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-id', true ) ) ? 'style="display:block;"' : 'style="display:none;"';
					?>
					<div class="featured-image-message" <?php echo $show_featured_image_message; ?>>
						<p class="description">
							<?php _e( 'Currently using your <a href="#" class="parvati-featured-image">featured image</a>.', 'parvati-premium' ); ?>
						</p>
					</div>

					<div id="preview-image" class="parvati-page-header-image">
						<?php if( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image', true ) != "") { ?>
							<img class="saved-image" src="<?php echo esc_url( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image', true ) );?>" width="100" style="margin-bottom:12px;" />
						<?php } ?>
					</div>

					<input data-prev="true" id="upload_image" type="hidden" name="_meta-parvati-page-header-image" value="<?php echo esc_url(parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image', true )); ?>" />
					<button class="parvati-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Page Header Image', 'parvati-premium' );?>" data-insert="<?php _e( 'Insert Image', 'parvati-premium' ); ?>" data-prev="true">
						<?php _e( 'Choose Image', 'parvati-premium' ) ;?>
					</button>
					<button class="parvati-page-header-remove-image button" type="button" <?php echo $remove_button; ?> data-input="#upload_image" data-input-id="#_meta-parvati-page-header-image-id" data-prev=".parvati-page-header-image">
						<?php _e( 'Remove Image', 'parvati-premium' ) ;?>
					</button>
					<input class="image-id" id="_meta-parvati-page-header-image-id" type="hidden" name="_meta-parvati-page-header-image-id" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-id', true ) ); ?>" />

					<div class="parvati-page-header-set-featured-image" <?php echo $no_image_selected; ?>>
						<p class="description"><?php _e( 'Or you can <a href="#">set the featured image</a>.', 'parvati-premium' ); ?></p>
					</div>

					<div class="page-header-image-settings" <?php echo $show_image_settings; ?>>
						<p>
							<label for="_meta-parvati-page-header-image-link" class="example-row-title"><strong><?php _e( 'Image Link', 'parvati-premium' );?></strong></label><br />
							<input class="widefat" style="max-width:350px;" placeholder="http://" id="_meta-parvati-page-header-image-link" type="text" name="_meta-parvati-page-header-image-link" value="<?php echo esc_url(parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-link', true )); ?>" />
						</p>

						<p>
							<label for="_meta-parvati-page-header-enable-image-crop" class="example-row-title"><strong><?php _e( 'Resize Image', 'parvati-premium' );?></strong></label><br />
							<select name="_meta-parvati-page-header-enable-image-crop" id="_meta-parvati-page-header-enable-image-crop">
								<option value="" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-enable-image-crop', true ), '' ); ?>><?php _e( 'Disable', 'parvati-premium' );?></option>
								<option value="enable" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-enable-image-crop', true ), 'enable' ); ?>><?php _e( 'Enable', 'parvati-premium' );?></option>
							</select>
						</p>

						<div id="crop-enabled" style="display:none">
							<p>
								<label for="_meta-parvati-page-header-image-width" class="example-row-title"><strong><?php _e( 'Image Width', 'parvati-premium' );?></strong></label><br />
								<input style="width:45px" type="text" name="_meta-parvati-page-header-image-width" id="_meta-parvati-page-header-image-width" value="<?php echo intval( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-width', true ) ); ?>" /><label for="_meta-parvati-page-header-image-width"><span class="pixels">px</span></label>
							</p>

							<p style="margin-bottom:0;">
								<label for="_meta-parvati-page-header-image-height" class="example-row-title"><strong><?php _e( 'Image Height', 'parvati-premium' );?></strong></label><br />
								<input placeholder="" style="width:45px" type="text" name="_meta-parvati-page-header-image-height" id="_meta-parvati-page-header-image-height" value="<?php echo intval( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-height', true ) ); ?>" />
								<label for="_meta-parvati-page-header-image-height"><span class="pixels">px</span></label>
								<span class="description" style="display:block;"><?php _e( 'Use "0" or leave blank for proportional resizing.', 'parvati-premium' );?></span>
							</p>
						</div>
					</div>
				</div>

				<div id="parvati-content-tab" class="parvati-tab-content">

					<textarea style="width:100%;min-height:200px;" name="_meta-parvati-page-header-content" id="_meta-parvati-page-header-content"><?php echo esc_textarea( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content', true ) ); ?></textarea>
					<p class="description" style="margin:0;"><?php _e( 'HTML and shortcodes allowed.', 'parvati-premium' );?></p>

					<div style="margin-top:12px;">
						<?php echo $content_required; ?>
						<div class="page-header-column">
							<p>
								<input type="checkbox" name="_meta-parvati-page-header-content-autop" id="_meta-parvati-page-header-content-autop" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content-autop', true ), 'yes' ); ?> />
								<label for="_meta-parvati-page-header-content-autop"><?php _e( 'Automatically add paragraphs', 'parvati-premium' );?></label>
							</p>

							<p>
								<input type="checkbox" name="_meta-parvati-page-header-content-padding" id="_meta-parvati-page-header-content-padding" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content-padding', true ), 'yes' ); ?> />
								<label for="_meta-parvati-page-header-content-padding"><?php _e( 'Add Padding', 'parvati-premium' );?></label>
							</p>

							<p>
								<input class="image-background" type="checkbox" name="_meta-parvati-page-header-image-background" id="_meta-parvati-page-header-image-background" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background', true ), 'yes' ); ?> />
								<label for="_meta-parvati-page-header-image-background"><?php _e( 'Add Background Image', 'parvati-premium' );?></label>
							</p>

							<p class="parallax">
								<input type="checkbox" name="_meta-parvati-page-header-image-background-overlay" id="_meta-parvati-page-header-image-background-overlay" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-overlay', true ), 'yes' ); ?> />
								<label for="_meta-parvati-page-header-image-background-overlay"><?php _e( 'Use background color as overlay', 'parvati-premium' );?></label>
							</p>

							<p class="parallax">
								<input type="checkbox" name="_meta-parvati-page-header-image-background-fixed" id="_meta-parvati-page-header-image-background-fixed" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-fixed', true ), 'yes' ); ?> />
								<label for="_meta-parvati-page-header-image-background-fixed"><?php _e( 'Parallax Effect', 'parvati-premium' );?></label>
							</p>

							<p class="fullscreen">
								<input type="checkbox" name="_meta-parvati-page-header-full-screen" id="_meta-parvati-page-header-full-screen" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-full-screen', true ), 'yes' ); ?> />
								<label for="_meta-parvati-page-header-full-screen"><?php _e( 'Fullscreen', 'parvati-premium' );?></label>
							</p>

							<p class="vertical-center">
								<input type="checkbox" name="_meta-parvati-page-header-vertical-center" id="_meta-parvati-page-header-vertical-center" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-vertical-center', true ), 'yes' ); ?> />
								<label for="_meta-parvati-page-header-vertical-center"><?php _e( 'Vertical center content', 'parvati-premium' );?></label>
							</p>
						</div>

						<div class="page-header-column">
							<p>
								<label for="_meta-parvati-page-header-image-background-type" class="example-row-title"><strong><?php _e( 'Container', 'parvati-premium' );?></strong></label><br />
								<select name="_meta-parvati-page-header-image-background-type" id="_meta-parvati-page-header-image-background-type">
									<option value="" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-type', true ), '' ); ?>><?php _e( 'Contained', 'parvati-premium' );?></option>
									<option value="fluid" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-type', true ), 'fluid' ); ?>><?php _e( 'Full Width', 'parvati-premium' );?></option>
								</select>
							</p>

							<p>
								<label for="_meta-parvati-page-header-image-background-type" class="example-row-title"><strong><?php _e( 'Inner Container', 'parvati-premium' );?></strong></label><br />
								<select name="_meta-parvati-page-header-inner-container" id="_meta-parvati-page-header-inner-container">
									<option value="" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-inner-container', true ), '' ); ?>><?php _e( 'Contained', 'parvati-premium' );?></option>
									<option value="full" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-inner-container', true ), 'full' ); ?>><?php _e( 'Full Width', 'parvati-premium' );?></option>
								</select>
							</p>

							<p>
								<label for="_meta-parvati-page-header-image-background-alignment" class="example-row-title"><strong><?php _e( 'Text Alignment', 'parvati-premium' );?></strong></label><br />
								<select name="_meta-parvati-page-header-image-background-alignment" id="_meta-parvati-page-header-image-background-alignment">
									<option value="" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-alignment', true ), '' ); ?>><?php _e( 'Left', 'parvati-premium' );?></option>
									<option value="center" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-alignment', true ), 'center' ); ?>><?php _e( 'Center', 'parvati-premium' );?></option>
									<option value="right" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-alignment', true ), 'right' ); ?>><?php _e( 'Right', 'parvati-premium' );?></option>
								</select>
							</p>

							<p>
								<label for="_meta-parvati-page-header-image-background-spacing" class="example-row-title"><strong><?php _e( 'Top Padding', 'parvati-premium' );?></strong></label><br />
								<input placeholder="" style="width:45px" type="text" name="_meta-parvati-page-header-image-background-spacing" id="_meta-parvati-page-header-image-background-spacing" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-spacing', true ) ); ?>" />
								<select name="_meta-parvati-page-header-image-background-spacing-unit" id="_meta-parvati-page-header-image-background-spacing-unit">
									<option value="" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-spacing-unit', true ), '' ); ?>>px</option>
									<option value="%" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-spacing-unit', true ), '%' ); ?>>%</option>
								</select>
							</p>

							<p>
								<label for="_meta-parvati-page-header-image-background-spacing-bottom" class="example-row-title"><strong><?php _e( 'Bottom Padding', 'parvati-premium' );?></strong></label><br />
								<input placeholder="" style="width:45px" type="text" name="_meta-parvati-page-header-image-background-spacing-bottom" id="_meta-parvati-page-header-image-background-spacing-bottom" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-spacing-bottom', true ) ); ?>" />
								<select name="_meta-parvati-page-header-image-background-spacing-bottom-unit" id="_meta-parvati-page-header-image-background-spacing-bottom-unit">
									<option value="" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-spacing-bottom-unit', true ), '' ); ?>>px</option>
									<option value="%" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-spacing-bottom-unit', true ), '%' ); ?>>%</option>
								</select>
							</p>

							<p>
								<label for="_meta-parvati-page-header-left-right-padding" class="example-row-title"><strong><?php _e( 'Left & Right Padding', 'parvati-premium' );?></strong></label><br />
								<input placeholder="" style="width:45px" type="text" name="_meta-parvati-page-header-left-right-padding" id="_meta-parvati-page-header-left-right-padding" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-left-right-padding', true ) ); ?>" />
								<select name="_meta-parvati-page-header-left-right-padding-unit" id="_meta-parvati-page-header-left-right-padding-unit">
									<option value="" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-left-right-padding-unit', true ), '' ); ?>>px</option>
									<option value="%" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-left-right-padding-unit', true ), '%' ); ?>>%</option>
								</select>
							</p>

							<p>
								<label for="_meta-parvati-page-header-content-max-width" class="example-row-title"><strong><?php _e( 'Content Max Width', 'parvati-premium' );?></strong></label><br />
								<input placeholder="" style="width:45px" type="text" name="_meta-parvati-page-header-content-max-width" id="_meta-parvati-page-header-content-max-width" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content-max-width', true ) ); ?>" />
								<select name="_meta-parvati-page-header-content-max-width-unit" id="_meta-parvati-page-header-content-max-width-unit">
									<option value="" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content-max-width-unit', true ), '' ); ?>>px</option>
									<option value="%" <?php selected( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content-max-width-unit', true ), '%' ); ?>>%</option>
								</select>
							</p>
						</div>

						<div class="page-header-column last">
							<p>
								<label for="_meta-parvati-page-header-image-background-color" class="example-row-title"><strong><?php _e( 'Background Color', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" data-alpha="true" style="width:45px" type="text" name="_meta-parvati-page-header-image-background-color" id="_meta-parvati-page-header-image-background-color" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-color', true ) ); ?>" />
							</p>
                            
							<p>
								<label for="_meta-parvati-page-header-content-background-color" class="example-row-title"><strong><?php _e( 'Content Background', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" data-alpha="true" style="width:45px" type="text" name="_meta-parvati-page-header-content-background-color" id="_meta-parvati-page-header-content-background-color" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-content-background-color', true ) ); ?>" />
							</p>

							<p>
								<label for="_meta-parvati-page-header-image-background-text-color" class="example-row-title"><strong><?php _e( 'Text Color', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" style="width:45px" type="text" name="_meta-parvati-page-header-image-background-text-color" id="_meta-parvati-page-header-image-background-text-color" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-text-color', true ) ); ?>" />
							</p>

							<p>
								<label for="_meta-parvati-page-header-image-background-link-color" class="example-row-title"><strong><?php _e( 'Link Color', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" style="width:45px" type="text" name="_meta-parvati-page-header-image-background-link-color" id="_meta-parvati-page-header-image-background-link-color" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-link-color', true ) ); ?>" />
							</p>

							<p>
								<label for="_meta-parvati-page-header-image-background-link-color-hover" class="example-row-title"><strong><?php _e( 'Link Color Hover', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" style="width:45px" type="text" name="_meta-parvati-page-header-image-background-link-color-hover" id="_meta-parvati-page-header-image-background-link-color-hover" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-image-background-link-color-hover', true ) ); ?>" />
							</p>
						</div>
						<div class="clear"></div>
					</div>
				</div>

				<div id="parvati-video-background-tab" class="parvati-tab-content parvati-video-tab" style="display:none">
					<?php echo $content_required; ?>
					<p style="margin-top:0;">
						<label for="_meta-parvati-page-header-video" class="example-row-title"><strong><?php _e( 'MP4 file', 'parvati-premium' );?></strong></label><br />
						<input placeholder="http://" class="widefat" style="max-width:350px" id="_meta-parvati-page-header-video" type="text" name="_meta-parvati-page-header-video" value="<?php echo esc_url(parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-video', true )); ?>" />
						<button class="parvati-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video', 'parvati-premium' );?>" data-insert="<?php _e( 'Insert Video', 'parvati-premium' ); ?>" data-prev="false">
							<?php _e( 'Choose Video', 'parvati-premium' ) ;?>
						</button>
					</p>

					<p>
						<label for="_meta-parvati-page-header-video-ogv" class="example-row-title"><strong><?php _e( 'OGV file', 'parvati-premium' );?></strong></label><br />
						<input placeholder="http://" class="widefat" style="max-width:350px" id="_meta-parvati-page-header-video-ogv" type="text" name="_meta-parvati-page-header-video-ogv" value="<?php echo esc_url(parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-video-ogv', true )); ?>" />
						<button class="parvati-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video', 'parvati-premium' );?>" data-insert="<?php _e( 'Insert Video', 'parvati-premium' ); ?>" data-prev="false">
							<?php _e( 'Choose Video', 'parvati-premium' ) ;?>
						</button>
					</p>

					<p>
						<label for="_meta-parvati-page-header-video-webm" class="example-row-title"><strong><?php _e( 'WEBM file', 'parvati-premium' );?></strong></label><br />
						<input placeholder="http://" class="widefat" style="max-width:350px" id="_meta-parvati-page-header-video-webm" type="text" name="_meta-parvati-page-header-video-webm" value="<?php echo esc_url(parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-video-webm', true )); ?>" />
						<button class="parvati-upload-file button" type="button" data-type="video" data-title="<?php _e( 'Page Header Video', 'parvati-premium' );?>" data-insert="<?php _e( 'Insert Video', 'parvati-premium' ); ?>" data-prev="false">
							<?php _e( 'Choose Video', 'parvati-premium' ) ;?>
						</button>
					</p>

					<p>
						<label for="_meta-parvati-page-header-video-overlay" class="example-row-title"><strong><?php _e( 'Overlay Color', 'parvati-premium' );?></strong></label><br />
						<input class="color-picker" data-alpha="true" style="width:45px" type="text" name="_meta-parvati-page-header-video-overlay" id="_meta-parvati-page-header-video-overlay" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-video-overlay', true ) ); ?>" />
					</p>
				</div>

				<?php if ( parvati_pageheader_logo_exists() || parvati_pageheader_navigation_logo_exists() ) : ?>
					<div id="parvati-logo-tab" class="parvati-tab-content">
						<?php if ( function_exists( 'parvati_get_defaults' ) ) {
							$parvati_settings = wp_parse_args(
								get_option( 'parvati_settings', array() ),
								parvati_get_defaults()
							);

							if ( function_exists( 'parvati_construct_logo' ) && ( get_theme_mod( 'custom_logo' ) ) ) {
								?>
								<p class="description" style="margin-top:0;">
									<?php _e( 'Overwrite your site-wide logo/header on this page.', 'parvati-premium' ); ?>
								</p>

								<div id="preview-image" class="parvati-logo-image">
									<?php if( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-logo', true ) != "") { ?>
										<img class="saved-image" src="<?php echo esc_url( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-logo', true ) );?>" width="100" style="margin-bottom:12px;" />
									<?php } ?>
								</div>

								<input style="width:350px" id="_meta-parvati-page-header-logo" type="hidden" name="_meta-parvati-page-header-logo" value="<?php echo esc_url(parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-logo', true )); ?>" />
								<button class="parvati-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Header / Logo', 'parvati-premium' );?>" data-insert="<?php _e( 'Insert Logo', 'parvati-premium' ); ?>" data-prev="true">
									<?php _e('Choose Logo', 'parvati-premium' ) ;?>
								</button>
								<input class="image-id" id="_meta-parvati-page-header-logo-id" type="hidden" name="_meta-parvati-page-header-logo-id" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-logo-id', true ) ); ?>" />

								<?php if( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-logo', true ) != "") {
									$remove_button = 'style="display:inline-block;"';
								} else {
									$remove_button = 'style="display:none;"';
								}
								?>
								<button class="parvati-page-header-remove-image button" type="button" <?php echo $remove_button; ?> data-input="#_meta-parvati-page-header-logo" data-input-id="_meta-parvati-page-header-logo-id" data-prev=".parvati-logo-image">
									<?php _e( 'Remove Logo', 'parvati-premium' ) ;?>
								</button>

								<p style="margin-bottom:20px;"></p>
								<?php
							}
						}

						if ( function_exists( 'parvati_menu_plus_get_defaults' ) ) {
							$parvati_menu_plus_settings = wp_parse_args(
								get_option( 'parvati_menu_plus_settings', array() ),
								parvati_menu_plus_get_defaults()
							);

							if ( '' !== $parvati_menu_plus_settings[ 'sticky_menu_logo' ] ) {
								?>
								<p class="description" style="margin-top:0;">
									<?php _e( 'Overwrite your navigation logo on this page.', 'parvati-premium' ); ?>
								</p>

								<div id="preview-image" class="parvati-navigation-logo-image">
									<?php if( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-logo', true ) != "") { ?>
										<img class="saved-image" src="<?php echo esc_url( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-logo', true ) );?>" width="100" style="margin-bottom:12px;" />
									<?php } ?>
								</div>

								<input style="width:350px" id="_meta-parvati-page-header-navigation-logo" type="hidden" name="_meta-parvati-page-header-navigation-logo" value="<?php echo esc_url( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-logo', true ) ); ?>" />
								<button class="parvati-upload-file button" type="button" data-type="image" data-title="<?php _e( 'Navigation Logo', 'parvati-premium' );?>" data-insert="<?php _e( 'Insert Logo', 'parvati-premium'); ?>" data-prev="true">
									<?php _e( 'Choose Logo', 'parvati-premium' ) ;?>
								</button>
								<input class="image-id" id="_meta-parvati-page-header-navigation-logo-id" type="hidden" name="_meta-parvati-page-header-navigation-logo-id" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-logo-id', true ) ); ?>" />

								<?php if ( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-logo', true ) != "" ) {
									$remove_button = 'style="display:inline-block;"';
								} else {
									$remove_button = 'style="display:none;"';
								}
								?>

								<button class="parvati-page-header-remove-image button" type="button" <?php echo $remove_button; ?> data-input="#_meta-parvati-page-header-navigation-logo" data-input-id="_meta-parvati-page-header-navigation-logo-id" data-prev=".parvati-navigation-logo-image">
									<?php _e( 'Remove Logo', 'parvati-premium' ) ;?>
								</button>
							<?php }
						}
						?>
					</div>
				<?php endif; ?>

				<div id="parvati-advanced-tab" class="parvati-tab-content" style="display:none">
					<?php echo $content_required; ?>
					<p style="margin-top:0;">
						<input type="checkbox" name="_meta-parvati-page-header-combine" id="_meta-parvati-page-header-combine" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-combine', true ), 'yes' ); ?> />
						<label for="_meta-parvati-page-header-combine"><?php _e( 'Merge with site header', 'parvati-premium' );?></label>
					</p>

					<div class="combination-options">
						<p class="absolute-position">
							<input type="checkbox" name="_meta-parvati-page-header-absolute-position" id="_meta-parvati-page-header-absolute-position" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-absolute-position', true ), 'yes' ); ?> />
							<label for="_meta-parvati-page-header-absolute-position"><?php _e( 'Place content behind header (sliders etc..)', 'parvati-premium' );?></label>
						</p>

						<p>
							<label for="_meta-parvati-page-header-site-title" class="example-row-title"><?php _e( 'Site Title', 'parvati-premium' );?></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-parvati-page-header-site-title" id="_meta-parvati-page-header-site-title" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-site-title', true ) ); ?>" />
						</p>

						<p>
							<label for="_meta-parvati-page-header-site-tagline" class="example-row-title"><?php _e( 'Site Tagline', 'parvati-premium' );?></label><br />
							<input class="color-picker" style="width:45px" type="text" name="_meta-parvati-page-header-site-tagline" id="_meta-parvati-page-header-site-tagline" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-site-tagline', true ) ); ?>" />
						</p>

						<p>
							<input type="checkbox" name="_meta-parvati-page-header-transparent-navigation" id="_meta-parvati-page-header-transparent-navigation" value="yes" <?php checked( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-transparent-navigation', true ), 'yes' ); ?> />
							<label for="_meta-parvati-page-header-transparent-navigation"><?php _e( 'Custom Navigation Colors', 'parvati-premium' );?></label>
						</p>

						<div class="navigation-colors">
							<p>
								<label for="_meta-parvati-page-header-navigation-background" class="example-row-title"><strong><?php _e( 'Navigation Background', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" data-alpha="true" style="width:45px" type="text" name="_meta-parvati-page-header-navigation-background" id="_meta-parvati-page-header-navigation-background" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-background', true ) ); ?>" />
							</p>

							<p>
								<label for="_meta-parvati-page-header-navigation-text" class="example-row-title"><strong><?php _e( 'Navigation Text', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" style="width:45px" type="text" name="_meta-parvati-page-header-navigation-text" id="_meta-parvati-page-header-navigation-text" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-text', true ) ); ?>" />
							</p>

							<p>
								<label for="_meta-parvati-page-header-navigation-background-hover" class="example-row-title"><strong><?php _e( 'Navigation Background Hover', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" data-alpha="true" style="width:45px" type="text" name="_meta-parvati-page-header-navigation-background-hover" id="_meta-parvati-page-header-navigation-background-hover" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-background-hover', true ) ); ?>" />
							</p>

							<p>
								<label for="_meta-parvati-page-header-navigation-text-hover" class="example-row-title"><strong><?php _e( 'Navigation Text Hover', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" style="width:45px" type="text" name="_meta-parvati-page-header-navigation-text-hover" id="_meta-parvati-page-header-navigation-text-hover" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-text-hover', true ) ); ?>" />
							</p>

							<p>
								<label for="_meta-parvati-page-header-navigation-background-current" class="example-row-title"><strong><?php _e( 'Navigation Background Current', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" data-alpha="true" style="width:45px" type="text" name="_meta-parvati-page-header-navigation-background-current" id="_meta-parvati-page-header-navigation-background-current" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-background-current', true ) ); ?>" />
							</p>

							<p>
								<label for="_meta-parvati-page-header-navigation-text-current" class="example-row-title"><strong><?php _e( 'Navigation Text Current', 'parvati-premium' );?></strong></label><br />
								<input class="color-picker" style="width:45px" type="text" name="_meta-parvati-page-header-navigation-text-current" id="_meta-parvati-page-header-navigation-text-current" value="<?php echo esc_attr( parvati_pageheader_get_post_meta( get_the_ID(), '_meta-parvati-page-header-navigation-text-current', true ) ); ?>" />
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	    <?php
	}
}

if ( ! function_exists( 'save_parvati_pageheader_meta' ) ) {
	add_action( 'save_post', 'save_parvati_pageheader_meta' );
	/**
	 * Save our settings
	 */
	function save_parvati_pageheader_meta($post_id) {
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'parvati_pageheader_nonce' ] ) && wp_verify_nonce( $_POST[ 'parvati_pageheader_nonce' ], basename( __FILE__ ) ) ) ? true : false;

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
	    }

		// Check that the logged in user has permission to edit this post
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$options = array(
			'_meta-parvati-page-header-content' => 'FILTER_CONTENT',
			'_meta-parvati-page-header-image' => 'FILTER_SANITIZE_URL',
			'_meta-parvati-page-header-image-id' => 'FILTER_SANITIZE_NUMBER_INT',
			'_meta-parvati-page-header-image-link' => 'FILTER_SANITIZE_URL',
			'_meta-parvati-page-header-enable-image-crop' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-crop' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-width' => 'FILTER_SANITIZE_NUMBER_INT',
			'_meta-parvati-page-header-image-height' => 'FILTER_SANITIZE_NUMBER_INT',
			'_meta-parvati-page-header-image-background-type' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-inner-container' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-alignment' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-spacing' => 'FILTER_SANITIZE_NUMBER_INT',
			'_meta-parvati-page-header-image-background-spacing-unit' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-spacing-bottom' => 'FILTER_SANITIZE_NUMBER_INT',
			'_meta-parvati-page-header-image-background-spacing-bottom-unit' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-left-right-padding' => 'FILTER_SANITIZE_NUMBER_INT',
			'_meta-parvati-page-header-left-right-padding-unit' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-content-max-width' => 'FILTER_SANITIZE_NUMBER_INT',
			'_meta-parvati-page-header-content-max-width-unit' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-color' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-content-background-color' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-text-color' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-link-color' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-link-color-hover' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-navigation-background' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-navigation-text' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-navigation-background-hover' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-navigation-text-hover' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-navigation-background-current' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-navigation-text-current' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-site-title' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-site-tagline' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-video' => 'FILTER_SANITIZE_URL',
			'_meta-parvati-page-header-video-ogv' => 'FILTER_SANITIZE_URL',
			'_meta-parvati-page-header-video-webm' => 'FILTER_SANITIZE_URL',
			'_meta-parvati-page-header-video-overlay' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-content-autop' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-content-padding' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-full-screen' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-vertical-center' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-fixed' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-image-background-overlay' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-combine' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-absolute-position' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-transparent-navigation' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-add-to-excerpt' => 'FILTER_SANITIZE_STRING',
			'_meta-parvati-page-header-logo' => 'FILTER_SANITIZE_URL',
			'_meta-parvati-page-header-logo-id' => 'FILTER_SANITIZE_NUMBER_INT',
			'_meta-parvati-page-header-navigation-logo' => 'FILTER_SANITIZE_URL',
			'_meta-parvati-page-header-navigation-logo-id' => 'FILTER_SANITIZE_NUMBER_INT',
		);

		if ( ! defined( 'PARVATI_LAYOUT_META_BOX' ) ) {
			$options[ '_parvati-select-page-header' ] = 'FILTER_SANITIZE_NUMBER_INT';
		}

		foreach ( $options as $key => $sanitize ) {
			if ( 'FILTER_SANITIZE_STRING' == $sanitize ) {
				$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
			} elseif ( 'FILTER_SANITIZE_URL' == $sanitize ) {
				$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_URL );
			} elseif ( 'FILTER_SANITIZE_NUMBER_INT' == $sanitize ) {
				$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );
			} elseif ( 'FILTER_CONTENT' == $sanitize && isset( $_POST[ $key ] ) ) {
				if ( current_user_can( 'unfiltered_html' ) ) {
					$value = $_POST[ $key ];
				} else {
					$value = wp_kses_post( $_POST[ $key ] );
				}
			} else {
				$value = filter_input( INPUT_POST, $key, FILTER_DEFAULT );
			}

			if ( $value ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				delete_post_meta( $post_id, $key );
			}
		}
	}
}

add_action( 'add_meta_boxes', 'parvati_pageheader_tags_add_meta_box' );
/**
 * Add our Template Tags meta box.
 *
 * @param WP_Post $post Current post object.
 *
 */
function parvati_pageheader_tags_add_meta_box( $post ) {
	add_meta_box( 'parvati_pageheader_tags', __( 'Template Tags', 'parvati-premium' ), 'parvati_pageheader_tags_do_meta_box', 'parvati_pageheader', 'side', 'low' );
}

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 *
 */
function parvati_pageheader_tags_do_meta_box( $post ) {
    ?>
	<input type="text" readonly="readonly" value="{{post_title}}" />
	<p class="decription" style="margin-top:0;opacity:0.8;font-size:85%;"><?php _e( 'The content title of the current post/taxonomy.', 'parvati-premium' ); ?></p>

	<input type="text" readonly="readonly" value="{{post_date}}" />
	<p class="decription" style="margin-top:0;opacity:0.8;font-size:85%;"><?php _e( 'The published date of the current post.', 'parvati-premium' ); ?></p>

	<input type="text" readonly="readonly" value="{{post_author}}" />
	<p class="decription" style="margin-top:0;opacity:0.8;font-size:85%;"><?php _e( 'The author of the current post.', 'parvati-premium' ); ?></p>

	<input type="text" readonly="readonly" value="{{post_terms.taxonomy}}" />
	<p class="decription" style="margin-top:0;opacity:0.8;font-size:85%;"><?php _e( 'The terms attached to the chosen taxonomy (category, post_tag, product_cat).', 'parvati-premium' ); ?></p>

	<input type="text" readonly="readonly" value='{{custom_field.name}}' />
	<p class="decription" style="margin-top:0;opacity:0.8;font-size:85%;"><?php _e( 'Custom post meta. Replace "name" with the name of your custom field.', 'parvati-premium' ); ?></p>
	<?php
}

add_action( 'parvati_layout_meta_box_content', 'parvati_premium_page_header_meta_box_options' );
/**
 * Add the meta box options to the Layout meta box in the new Parvati
 *
 */
function parvati_premium_page_header_meta_box_options( $stored_meta ) {
	$stored_meta = (array) get_post_meta( get_the_ID() );
	$stored_meta['_parvati-select-page-header'][0] = ( isset( $stored_meta['_parvati-select-page-header'][0] ) ) ? $stored_meta['_parvati-select-page-header'][0] : '';
	?>
	<div id="parvati-layout-page-header" style="display: none;">
		<?php
		$page_headers = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'post_type' => 'parvati_pageheader',
			'suppress_filters' => false,
		));

		if ( count( $page_headers ) > 0 ) :
		?>
		<p style="margin-top:0;">
			<select name="_parvati-select-page-header" id="_parvati-select-page-header">
				<option value="" <?php selected( $stored_meta['_parvati-select-page-header'][0], '' ); ?>></option>
				<?php
				foreach( $page_headers as $header ) {
					printf( '<option value="%1$s" %2$s>%3$s</option>',
						$header->ID,
						selected( $stored_meta['_parvati-select-page-header'][0], $header->ID ),
						$header->post_title
					);
				}
				?>
			</select>
		</p>
		<?php else : ?>
			<p>
				<?php
				printf( __( 'No Page Headers found. Want to <a href="%1$s" target="_blank">create one</a>?', 'parvati-premium' ),
					esc_url( admin_url( 'post-new.php?post_type=parvati_pageheader' ) )
				);
				?>
			</p>
		<?php endif; ?>
	</div>
    <?php
}

add_action( 'parvati_layout_meta_box_menu_item', 'parvati_premium_page_header_menu_item' );

function parvati_premium_page_header_menu_item() {
	?>
	<li class="page-heade-meta-menu-item"><a href="#parvati-layout-page-header"><?php _e( 'Page Header', 'parvati-premium' ); ?></a></li>
	<?php
}

add_action( 'parvati_layout_meta_box_save', 'parvati_premium_save_page_header_meta' );
/**
 * Save the Page Header meta box values
 *
 */
function parvati_premium_save_page_header_meta( $post_id ) {
	$page_header_key   = '_parvati-select-page-header';
	$page_header_value = filter_input( INPUT_POST, $page_header_key, FILTER_SANITIZE_NUMBER_INT );

	if ( $page_header_value ) {
		update_post_meta( $post_id, $page_header_key, $page_header_value );
	} else {
		delete_post_meta( $post_id, $page_header_key );
	}
}
