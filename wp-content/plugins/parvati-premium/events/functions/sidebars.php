<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'wpkoi_events_widgets_init' ) ) {
	add_action( 'widgets_init', 'wpkoi_events_widgets_init', 99 );
	/**
	 * Register widgetized area and update sidebar with default widgets
	 */
	function wpkoi_events_widgets_init() {
		$widgets = array(
			'wpkoi-events-1' => __( 'Events Right Sidebar', 'parvati' ),
			'wpkoi-events-2' => __( 'Events Left Sidebar', 'parvati' ),
		);

		foreach ( $widgets as $id => $name ) {
			register_sidebar( array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
		}
	}
}

if ( ! function_exists( 'wpkoi_events_construct_sidebars' ) ) {
	/**
	 * Construct the sidebars.
	 *
	 */
	function wpkoi_events_construct_sidebars() {
		$layout = parvati_get_layout();

		// When to show the right sidebar.
		$rs = array( 'right-sidebar', 'both-sidebars', 'both-right', 'both-left' );

		// When to show the left sidebar.
		$ls = array( 'left-sidebar', 'both-sidebars', 'both-right', 'both-left' );

		// If left sidebar, show it.
		if ( in_array( $layout, $ls ) ) {
			// If the navigation is set in the sidebar, set variable to true.
			$navigation_active = ( 'nav-left-sidebar' == parvati_get_navigation_location() ) ? true : false;
			
			// If the secondary navigation is set in the sidebar, set variable to true.
			if ( function_exists( 'parvati_secondary_nav_get_defaults' ) ) {
				$secondary_nav = wp_parse_args(
					get_option( 'parvati_secondary_nav_settings', array() ),
					parvati_secondary_nav_get_defaults()
				);
			
				if ( 'secondary-nav-left-sidebar' == $secondary_nav['secondary_nav_position_setting'] ) {
					$navigation_active = true;
				}
			}
			?>
			<div id="left-sidebar" itemtype="https://schema.org/WPSideBar" itemscope="itemscope" <?php parvati_left_sidebar_class(); ?>>
				<div class="inside-left-sidebar">
					<?php
					/**
					 * parvati_before_left_sidebar_content hook.
					 *
					 */
					do_action( 'parvati_before_left_sidebar_content' );
			
					if ( ! dynamic_sidebar( 'wpkoi-events-2' ) ) :
			
						if ( false == $navigation_active ) : ?>
			
							<aside id="search" class="widget widget_search">
								<?php get_search_form(); ?>
							</aside>
			
							<aside id="archives" class="widget">
								<h2 class="widget-title"><?php esc_html_e( 'Archives', 'parvati' ); ?></h2>
								<ul>
									<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
								</ul>
							</aside>
			
						<?php endif;
			
					endif;
			
					/**
					 * parvati_after_left_sidebar_content hook.
					 *
					 */
					do_action( 'parvati_after_left_sidebar_content' );
					?>
				</div><!-- .inside-left-sidebar -->
			</div><!-- #secondary --> 
			<?php
		}

		// If right sidebar, show it.
		if ( in_array( $layout, $rs ) ) {
			// If the navigation is set in the sidebar, set variable to true.
			$navigation_active = ( 'nav-right-sidebar' == parvati_get_navigation_location() ) ? true : false;
			
			// If the secondary navigation is set in the sidebar, set variable to true.
			if ( function_exists( 'parvati_secondary_nav_get_defaults' ) ) {
				$secondary_nav = wp_parse_args(
					get_option( 'parvati_secondary_nav_settings', array() ),
					parvati_secondary_nav_get_defaults()
				);
			
				if ( 'secondary-nav-right-sidebar' == $secondary_nav['secondary_nav_position_setting'] ) {
					$navigation_active = true;
				}
			}
			?>
			<div id="right-sidebar" itemtype="https://schema.org/WPSideBar" itemscope="itemscope" <?php parvati_right_sidebar_class(); ?>>
				<div class="inside-right-sidebar">
					<?php
					/**
					 * parvati_before_right_sidebar_content hook.
					 *
					 */
					do_action( 'parvati_before_right_sidebar_content' );
			
					if ( ! dynamic_sidebar( 'wpkoi-events-1' ) ) :
			
						if ( false == $navigation_active ) : ?>
			
							<aside id="search" class="widget widget_search">
								<?php get_search_form(); ?>
							</aside>
			
							<aside id="archives" class="widget">
								<h2 class="widget-title"><?php esc_html_e( 'Archives', 'parvati' ); ?></h2>
								<ul>
									<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
								</ul>
							</aside>
			
						<?php endif;
			
					endif;
			
					/**
					 * parvati_after_right_sidebar_content hook.
					 *
					 */
					do_action( 'parvati_after_right_sidebar_content' );
					?>
				</div><!-- .inside-right-sidebar -->
			</div><!-- #secondary -->
            <?php
		}
	}
}
