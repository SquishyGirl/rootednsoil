<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PARVATI_DE_LAYOUT_META_BOX', true );

if ( ! function_exists( 'parvati_disable_elements' ) ) {
	/**
	 * Remove the default disable_elements 
	 */
	function parvati_disable_elements() {
		// Don't run the function unless we're on a page it applies to
		if ( ! is_singular() ) {
			return;
		}

		global $post;

		// Prevent PHP notices
		if ( isset( $post ) ) {
			$disable_header = get_post_meta( $post->ID, '_parvati-disable-header', true );
			$disable_nav = get_post_meta( $post->ID, '_parvati-disable-nav', true );
			$disable_secondary_nav = get_post_meta( $post->ID, '_parvati-disable-secondary-nav', true );
			$disable_post_image = get_post_meta( $post->ID, '_parvati-disable-post-image', true );
			$disable_headline = get_post_meta( $post->ID, '_parvati-disable-headline', true );
			$disable_footer = get_post_meta( $post->ID, '_parvati-disable-footer', true );
		}

		$return = '';

		if ( ! empty( $disable_header ) && false !== $disable_header ) {
			$return = '.site-header {display:none}';
		}

		if ( ! empty( $disable_nav ) && false !== $disable_nav ) {
			$return .= '#site-navigation,.navigation-clone, #mobile-header {display:none !important}';
		}

		if ( ! empty( $disable_secondary_nav ) && false !== $disable_secondary_nav ) {
			$return .= '#secondary-navigation {display:none}';
		}

		if ( ! empty( $disable_post_image ) && false !== $disable_post_image ) {
			$return .= '.parvati-page-header, .page-header-image, .page-header-image-single {display:none}';
		}

		if ( ( ! empty( $disable_headline ) && false !== $disable_headline ) && ! is_single() ) {
			$return .= '.entry-header {display:none} .page-content, .entry-content, .entry-summary {margin-top:0}';
		}

		if ( ! empty( $disable_footer ) && false !== $disable_footer ) {
			$return .= '.site-footer {display:none}';
		}

		return $return;
	}
}

if ( ! function_exists('parvati_de_scripts') ) {
	add_action( 'wp_enqueue_scripts', 'parvati_de_scripts', 50 );
	/**
	 * Enqueue scripts and styles
	 */
	function parvati_de_scripts() {
		wp_add_inline_style( 'parvati-style', parvati_disable_elements() );
	}
}

if ( ! function_exists('parvati_add_de_meta_box') ) {
	add_action( 'add_meta_boxes', 'parvati_add_de_meta_box', 50 );
	/**
	 * Generate the layout metabox.
	 *
	 */
	function parvati_add_de_meta_box() {
		// Set user role - make filterable
		$allowed = apply_filters( 'parvati_metabox_capability', 'edit_theme_options' );

		// If not an administrator, don't show the metabox
		if ( ! current_user_can( $allowed ) ) {
			return;
		}

		if ( defined( 'PARVATI_LAYOUT_META_BOX' ) ) {
			return;
		}

		$args = array( 'public' => true );
		$post_types = get_post_types( $args );
		foreach ($post_types as $type) {
			if ( 'attachment' !== $type ) {
				add_meta_box(
					'parvati_de_meta_box',
					__( 'Disable Elements', 'parvati-premium' ),
					'parvati_show_de_meta_box',
					$type,
					'side',
					'default'
				);
			}
		}
	}
}

if ( ! function_exists('parvati_show_de_meta_box') ) {
	/**
	 * Outputs the content of the metabox
	 */
	function parvati_show_de_meta_box( $post ) {
	    wp_nonce_field( basename( __FILE__ ), 'parvati_de_nonce' );
	    $stored_meta = get_post_meta( $post->ID );
		$stored_meta['_parvati-disable-header'][0] = ( isset( $stored_meta['_parvati-disable-header'][0] ) ) ? $stored_meta['_parvati-disable-header'][0] : '';
		$stored_meta['_parvati-disable-nav'][0] = ( isset( $stored_meta['_parvati-disable-nav'][0] ) ) ? $stored_meta['_parvati-disable-nav'][0] : '';
		$stored_meta['_parvati-disable-secondary-nav'][0] = ( isset( $stored_meta['_parvati-disable-secondary-nav'][0] ) ) ? $stored_meta['_parvati-disable-secondary-nav'][0] : '';
		$stored_meta['_parvati-disable-post-image'][0] = ( isset( $stored_meta['_parvati-disable-post-image'][0] ) ) ? $stored_meta['_parvati-disable-post-image'][0] : '';
		$stored_meta['_parvati-disable-headline'][0] = ( isset( $stored_meta['_parvati-disable-headline'][0] ) ) ? $stored_meta['_parvati-disable-headline'][0] : '';
		$stored_meta['_parvati-disable-footer'][0] = ( isset( $stored_meta['_parvati-disable-footer'][0] ) ) ? $stored_meta['_parvati-disable-footer'][0] : '';
		$stored_meta['_parvati-disable-top-bar'][0] = ( isset( $stored_meta['_parvati-disable-top-bar'][0] ) ) ? $stored_meta['_parvati-disable-top-bar'][0] : '';
	    ?>

	    <p>
			<div class="parvati_disable_elements">
				<?php if ( function_exists( 'parvati_top_bar' ) ) : ?>
					<label for="meta-parvati-disable-top-bar" style="display:block;margin-bottom:3px;" title="<?php _e( 'Top Bar', 'parvati-premium' );?>">
						<input type="checkbox" name="_parvati-disable-top-bar" id="meta-parvati-disable-top-bar" value="true" <?php checked( $stored_meta['_parvati-disable-top-bar'][0], 'true' ); ?>>
						<?php _e( 'Top Bar', 'parvati-premium' );?>
					</label>
				<?php endif; ?>

				<label for="meta-parvati-disable-header" style="display:block;margin-bottom:3px;" title="<?php _e( 'Header', 'parvati-premium' );?>">
					<input type="checkbox" name="_parvati-disable-header" id="meta-parvati-disable-header" value="true" <?php checked( $stored_meta['_parvati-disable-header'][0], 'true' ); ?>>
					<?php _e( 'Header', 'parvati-premium' );?>
				</label>

				<label for="meta-parvati-disable-nav" style="display:block;margin-bottom:3px;" title="<?php _e( 'Primary Navigation', 'parvati-premium' );?>">
					<input type="checkbox" name="_parvati-disable-nav" id="meta-parvati-disable-nav" value="true" <?php checked( $stored_meta['_parvati-disable-nav'][0], 'true' ); ?>>
					<?php _e( 'Primary Navigation', 'parvati-premium' );?>
				</label>

				<?php if ( function_exists( 'parvati_secondary_nav_setup' ) ) : ?>
					<label for="meta-parvati-disable-secondary-nav" style="display:block;margin-bottom:3px;" title="<?php _e( 'Secondary Navigation', 'parvati-premium' );?>">
						<input type="checkbox" name="_parvati-disable-secondary-nav" id="meta-parvati-disable-secondary-nav" value="true" <?php checked( $stored_meta['_parvati-disable-secondary-nav'][0], 'true' ); ?>>
						<?php _e( 'Secondary Navigation', 'parvati-premium' );?>
					</label>
				<?php endif; ?>

				<label for="meta-parvati-disable-post-image" style="display:block;margin-bottom:3px;" title="<?php _e( 'Featured Image / Page Header', 'parvati-premium' );?>">
					<input type="checkbox" name="_parvati-disable-post-image" id="meta-parvati-disable-post-image" value="true" <?php checked( $stored_meta['_parvati-disable-post-image'][0], 'true' ); ?>>
					<?php _e( 'Featured Image / Page Header', 'parvati-premium' );?>
				</label>

				<label for="meta-parvati-disable-headline" style="display:block;margin-bottom:3px;" title="<?php _e( 'Content Title', 'parvati-premium' );?>">
					<input type="checkbox" name="_parvati-disable-headline" id="meta-parvati-disable-headline" value="true" <?php checked( $stored_meta['_parvati-disable-headline'][0], 'true' ); ?>>
					<?php _e( 'Content Title', 'parvati-premium' );?>
				</label>

				<label for="meta-parvati-disable-footer" style="display:block;margin-bottom:3px;" title="<?php _e( 'Footer', 'parvati-premium' );?>">
					<input type="checkbox" name="_parvati-disable-footer" id="meta-parvati-disable-footer" value="true" <?php checked( $stored_meta['_parvati-disable-footer'][0], 'true' ); ?>>
					<?php _e( 'Footer', 'parvati-premium' );?>
				</label>
			</div>
		</p>

	    <?php
	}
}

if ( ! function_exists('parvati_save_de_meta') ) {
	add_action( 'save_post', 'parvati_save_de_meta' );
	/**
	 * Save our options
	 */
	function parvati_save_de_meta( $post_id ) {

		if ( defined( 'PARVATI_LAYOUT_META_BOX' ) ) {
			return;
		}

		// Checks save status
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_valid_nonce = ( isset( $_POST[ 'parvati_de_nonce' ] ) && wp_verify_nonce( $_POST[ 'parvati_de_nonce' ], basename( __FILE__ ) ) ) ? true : false;

	    // Exits script depending on save status
	    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
	        return;
	    }

		// Check that the logged in user has permission to edit this post
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$options = array(
			'_parvati-disable-top-bar',
			'_parvati-disable-header',
			'_parvati-disable-nav',
			'_parvati-disable-secondary-nav',
			'_parvati-disable-headline',
			'_parvati-disable-footer',
			'_parvati-disable-post-image'
		);

		foreach ( $options as $key ) {
			$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );

			if ( $value ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				delete_post_meta( $post_id, $key );
			}
		}
	}
}

if ( ! function_exists( 'parvati_disable_elements_setup' ) ) {
	add_action( 'wp', 'parvati_disable_elements_setup', 50 );
	function parvati_disable_elements_setup() {
		// Don't run the function unless we're on a page it applies to
		if ( ! is_singular() ) {
			return;
		}

		// Get the current post
		global $post;

		// Grab our values
		if ( isset( $post ) ) {
			$disable_top_bar = get_post_meta( $post->ID, '_parvati-disable-top-bar', true );
			$disable_header = get_post_meta( $post->ID, '_parvati-disable-header', true );
			$disable_nav = get_post_meta( $post->ID, '_parvati-disable-nav', true );
			$disable_headline = get_post_meta( $post->ID, '_parvati-disable-headline', true );
			$disable_footer = get_post_meta( $post->ID, '_parvati-disable-footer', true );
		}

		// Remove the top bar
		if ( ! empty( $disable_top_bar ) && false !== $disable_top_bar && function_exists( 'parvati_top_bar' ) ) {
			remove_action( 'parvati_before_header','parvati_top_bar', 5 );
		}

		// Remove the header
		if ( ! empty( $disable_header ) && false !== $disable_header && function_exists( 'parvati_construct_header' ) ) {
			remove_action( 'parvati_header','parvati_construct_header' );
		}

		// Remove the navigation
		if ( ! empty( $disable_nav ) && false !== $disable_nav && function_exists( 'parvati_get_navigation_location' ) ) {
			add_filter( 'parvati_navigation_location','__return_false' );
		}

		// Remove the title
		if ( ! empty( $disable_headline ) && false !== $disable_headline && function_exists( 'parvati_show_title' ) ) {
			add_filter( 'parvati_show_title','__return_false' );
		}

		// Remove the footer
		if ( ! empty( $disable_footer ) && false !== $disable_footer ) {
			if ( function_exists( 'parvati_construct_footer_widgets' ) ) {
				remove_action( 'parvati_footer','parvati_construct_footer_widgets', 5 );
			}

			if ( function_exists( 'parvati_construct_footer' ) ) {
				remove_action( 'parvati_footer','parvati_construct_footer' );
			}
		}
	}
}

add_action( 'parvati_layout_disable_elements_section', 'parvati_premium_disable_elements_options' );
/**
 * Add the meta box options to the Layout meta box in the new Parvati
 *
 */
function parvati_premium_disable_elements_options( $stored_meta ) {
	$stored_meta['_parvati-disable-header'][0] = ( isset( $stored_meta['_parvati-disable-header'][0] ) ) ? $stored_meta['_parvati-disable-header'][0] : '';
	$stored_meta['_parvati-disable-nav'][0] = ( isset( $stored_meta['_parvati-disable-nav'][0] ) ) ? $stored_meta['_parvati-disable-nav'][0] : '';
	$stored_meta['_parvati-disable-secondary-nav'][0] = ( isset( $stored_meta['_parvati-disable-secondary-nav'][0] ) ) ? $stored_meta['_parvati-disable-secondary-nav'][0] : '';
	$stored_meta['_parvati-disable-post-image'][0] = ( isset( $stored_meta['_parvati-disable-post-image'][0] ) ) ? $stored_meta['_parvati-disable-post-image'][0] : '';
	$stored_meta['_parvati-disable-headline'][0] = ( isset( $stored_meta['_parvati-disable-headline'][0] ) ) ? $stored_meta['_parvati-disable-headline'][0] : '';
	$stored_meta['_parvati-disable-footer'][0] = ( isset( $stored_meta['_parvati-disable-footer'][0] ) ) ? $stored_meta['_parvati-disable-footer'][0] : '';
	$stored_meta['_parvati-disable-top-bar'][0] = ( isset( $stored_meta['_parvati-disable-top-bar'][0] ) ) ? $stored_meta['_parvati-disable-top-bar'][0] : '';
	?>
	<div class="parvati_disable_elements">
		<?php if ( function_exists( 'parvati_top_bar' ) ) : ?>
			<label for="meta-parvati-disable-top-bar" style="display:block;margin-bottom:3px;" title="<?php _e( 'Top Bar', 'parvati-premium' );?>">
				<input type="checkbox" name="_parvati-disable-top-bar" id="meta-parvati-disable-top-bar" value="true" <?php checked( $stored_meta['_parvati-disable-top-bar'][0], 'true' ); ?>>
				<?php _e( 'Top Bar', 'parvati-premium' );?>
			</label>
		<?php endif; ?>

		<label for="meta-parvati-disable-header" style="display:block;margin-bottom:3px;" title="<?php _e( 'Header', 'parvati-premium' );?>">
			<input type="checkbox" name="_parvati-disable-header" id="meta-parvati-disable-header" value="true" <?php checked( $stored_meta['_parvati-disable-header'][0], 'true' ); ?>>
			<?php _e( 'Header', 'parvati-premium' );?>
		</label>

		<label for="meta-parvati-disable-nav" style="display:block;margin-bottom:3px;" title="<?php _e( 'Primary Navigation', 'parvati-premium' );?>">
			<input type="checkbox" name="_parvati-disable-nav" id="meta-parvati-disable-nav" value="true" <?php checked( $stored_meta['_parvati-disable-nav'][0], 'true' ); ?>>
			<?php _e( 'Primary Navigation', 'parvati-premium' );?>
		</label>

		<?php if ( function_exists( 'parvati_secondary_nav_setup' ) ) : ?>
			<label for="meta-parvati-disable-secondary-nav" style="display:block;margin-bottom:3px;" title="<?php _e( 'Secondary Navigation', 'parvati-premium' );?>">
				<input type="checkbox" name="_parvati-disable-secondary-nav" id="meta-parvati-disable-secondary-nav" value="true" <?php checked( $stored_meta['_parvati-disable-secondary-nav'][0], 'true' ); ?>>
				<?php _e( 'Secondary Navigation', 'parvati-premium' );?>
			</label>
		<?php endif; ?>

		<label for="meta-parvati-disable-post-image" style="display:block;margin-bottom:3px;" title="<?php _e( 'Featured Image / Page Header', 'parvati-premium' );?>">
			<input type="checkbox" name="_parvati-disable-post-image" id="meta-parvati-disable-post-image" value="true" <?php checked( $stored_meta['_parvati-disable-post-image'][0], 'true' ); ?>>
			<?php _e( 'Featured Image / Page Header', 'parvati-premium' );?>
		</label>

		<label for="meta-parvati-disable-headline" style="display:block;margin-bottom:3px;" title="<?php _e( 'Content Title', 'parvati-premium' );?>">
			<input type="checkbox" name="_parvati-disable-headline" id="meta-parvati-disable-headline" value="true" <?php checked( $stored_meta['_parvati-disable-headline'][0], 'true' ); ?>>
			<?php _e( 'Content Title', 'parvati-premium' );?>
		</label>

		<label for="meta-parvati-disable-footer" style="display:block;margin-bottom:3px;" title="<?php _e( 'Footer', 'parvati-premium' );?>">
			<input type="checkbox" name="_parvati-disable-footer" id="meta-parvati-disable-footer" value="true" <?php checked( $stored_meta['_parvati-disable-footer'][0], 'true' ); ?>>
			<?php _e( 'Footer', 'parvati-premium' );?>
		</label>
	</div>
	<?php
}

add_action( 'parvati_layout_meta_box_save', 'parvati_premium_save_disable_elements_meta' );
/**
 * Save the Disable Elements meta box values
 *
 */
function parvati_premium_save_disable_elements_meta( $post_id ) {
	$options = array(
		'_parvati-disable-top-bar',
		'_parvati-disable-header',
		'_parvati-disable-nav',
		'_parvati-disable-secondary-nav',
		'_parvati-disable-headline',
		'_parvati-disable-footer',
		'_parvati-disable-post-image'
	);

	foreach ( $options as $key ) {
		$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );

		if ( $value ) {
			update_post_meta( $post_id, $key, $value );
		} else {
			delete_post_meta( $post_id, $key );
		}
	}
}
