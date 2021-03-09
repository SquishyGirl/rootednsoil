<?php
/**
 * The template for displaying Archive pages.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php parvati_content_class(); ?>>
		<main id="main" <?php parvati_main_class(); ?>>
			<?php
			/**
			 * parvati_before_main_content hook.
			 *
			 */
			do_action( 'parvati_before_main_content' );

			if ( have_posts() ) :

				while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php parvati_article_schema( 'CreativeWork' ); ?>>
                <div class="inside-article">
                    <div class="article-holder">
                    <?php
					// Get the Event options 
					$wpkoi_events_metabox_location = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_location', true );
					$wpkoi_events_metabox_address  = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_address', true );
					$wpkoi_events_metabox_date     = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_date', true );
					$wpkoi_events_metabox_hour     = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_hour', true );
					$wpkoi_events_metabox_minute   = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_minute', true );
					$wpkoi_events_metabox_format   = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_format', true );
					$wpkoi_display_date = date_create($wpkoi_events_metabox_date);
                    /**
                     * parvati_before_content hook.
                     *
                     *
                     * @hooked parvati_featured_page_header_inside_single - 10
                     */
                    do_action( 'parvati_before_content' );
                    ?>
            
                    <header class="entry-header">
                        <?php
                        /**
                         * parvati_before_entry_title hook.
                         *
                         */
                        do_action( 'parvati_before_entry_title' );
            
                        the_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
            
                        /**
                         * parvati_after_entry_title hook.
                         *
                         *
                         * @hooked parvati_post_meta - 10
                         */
                        do_action( 'parvati_after_entry_title' );
                        ?>
                        <?php if ( $wpkoi_events_metabox_date != '' ) { ?>
                        <h4><?php echo esc_html( date_format( $wpkoi_display_date, $wpkoi_events_metabox_format ) ); if ( $wpkoi_events_metabox_hour != '' ) { ?> - <?php echo esc_html( $wpkoi_events_metabox_hour ); ?>:<?php echo esc_html( $wpkoi_events_metabox_minute ); } ?></h4>
                        <?php }
                        if ( $wpkoi_events_metabox_location != '' ) { ?>
                        <h4><?php echo wp_kses_post( $wpkoi_events_metabox_location ); ?><?php if ( $wpkoi_events_metabox_address != '' ) { ?> - <?php echo wp_kses_post( $wpkoi_events_metabox_address ); } ?></h4>
							<?php } ?>
                    </header><!-- .entry-header -->
            
                    <?php
                    /**
                     * parvati_after_entry_header hook.
                     *
                     *
                     * @hooked parvati_post_image - 10
                     */
                    do_action( 'parvati_after_entry_header' );
            
                    if ( parvati_show_excerpt() ) : ?>
            
                        <div class="entry-summary" itemprop="text">
                            <?php the_excerpt(); ?>
                        </div><!-- .entry-summary -->
            
                    <?php else : ?>
            
                        <div class="entry-content" itemprop="text">
                            <?php
                            the_content();
            
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . __( 'Pages:', 'parvati' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div><!-- .entry-content -->
            
                    <?php endif;
            
                    /**
                     * parvati_after_entry_content hook.
                     *
                     *
                     * @hooked parvati_footer_meta - 10
                     */
                    do_action( 'parvati_after_entry_content' );
            
                    /**
                     * parvati_after_content hook.
                     *
                     */
                    do_action( 'parvati_after_content' );
                    ?>
                    </div>
                </div><!-- .inside-article -->
            </article><!-- #post-## -->
            <?php

				endwhile;

				parvati_content_nav( 'nav-below' );

			else :

				get_template_part( 'no-results', 'archive' );

			endif;

			/**
			 * parvati_after_main_content hook.
			 *
			 */
			do_action( 'parvati_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * parvati_after_primary_content_area hook.
	 *
	 */
	 do_action( 'parvati_after_primary_content_area' );

	 wpkoi_events_construct_sidebars();

get_footer();
