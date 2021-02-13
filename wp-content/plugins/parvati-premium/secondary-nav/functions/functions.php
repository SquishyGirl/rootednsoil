<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

// Add necessary files
require plugin_dir_path( __FILE__ ) . 'css.php';

if ( ! function_exists( 'parvati_secondary_nav_setup' ) ) {
	add_action( 'after_setup_theme', 'parvati_secondary_nav_setup' );
	/**
	 * Register our secondary navigation 
	 */
	function parvati_secondary_nav_setup() {
		register_nav_menus( array(
			'secondary' => __( 'Secondary Menu', 'parvati-premium' ),
		) );
	}
}

if ( ! function_exists( 'parvati_secondary_nav_enqueue_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'parvati_secondary_nav_enqueue_scripts', 100 );
	/**
	 * Add our necessary scripts 
	 */
	function parvati_secondary_nav_enqueue_scripts() {
		// Bail if no Secondary menu is set
		if ( ! has_nav_menu( 'secondary' ) ) {
			return;
		}

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'parvati-secondary-nav', plugin_dir_url( __FILE__ ) . "css/style{$suffix}.css", array(), PARVATI_SECONDARY_NAV_VERSION );
		if ( ! defined( 'PARVATI_DISABLE_MOBILE' ) ) {
			wp_add_inline_script( 'parvati-navigation',
				"jQuery( document ).ready( function($) {
					$( '.secondary-navigation .menu-toggle' ).on( 'click', function( e ) {
						e.preventDefault();
						$( this ).closest( '.secondary-navigation' ).toggleClass( 'toggled' );
						$( this ).closest( '.secondary-navigation' ).attr( 'aria-expanded', $( this ).closest( '.secondary-navigation' ).attr( 'aria-expanded' ) === 'true' ? 'false' : 'true' );
						$( this ).toggleClass( 'toggled' );
						$( this ).children( 'i' ).toggleClass( 'fa-bars' ).toggleClass( 'fa-close' );
						$( this ).attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
					});
				});"
			);

			wp_enqueue_style( 'parvati-secondary-nav-mobile', plugin_dir_url( __FILE__ ) . "css/mobile{$suffix}.css", array(), PARVATI_SECONDARY_NAV_VERSION, 'all' );
		}
	}
}

if ( ! function_exists( 'parvati_secondary_nav_enqueue_customizer_scripts' ) ) {
	add_action( 'customize_preview_init', 'parvati_secondary_nav_enqueue_customizer_scripts' );
	/**
	 * Add our Customizer preview JS.
	 *
	 */
	function parvati_secondary_nav_enqueue_customizer_scripts() {
	    wp_enqueue_script( 'parvati-secondary-nav-customizer', plugin_dir_url( __FILE__ ) . 'js/customizer.js', array( 'jquery', 'customize-preview' ), PARVATI_SECONDARY_NAV_VERSION, true );
	}
}

if ( ! function_exists( 'parvati_secondary_nav_customize_register' ) ) {
	add_action( 'customize_register', 'parvati_secondary_nav_customize_register', 100 );
	/**
	 * Register our options.
	 *
	 */
	function parvati_secondary_nav_customize_register( $wp_customize ) {
		// Get our defaults
		$defaults = parvati_secondary_nav_get_defaults();

		// Controls
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Use the Layout panel in the free theme if it exists
		if ( $wp_customize->get_panel( 'parvati_layout_panel' ) ) {
			$layout_panel = 'parvati_layout_panel';
		} else {
			$layout_panel = 'secondary_navigation_panel';
		}

		// Add our secondary navigation panel
		// This shouldn't be used anymore if the theme is up to date
		if ( class_exists( 'WP_Customize_Panel' ) ) {
			$wp_customize->add_panel( 'secondary_navigation_panel', array(
				'priority'       => 100,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Secondary Navigation', 'parvati-premium' ),
				'description'    => '',
			) );
		}

		// Add secondary navigation section
		$wp_customize->add_section(
			'secondary_nav_section',
			array(
				'title' => __( 'Secondary Navigation', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'priority' => 31,
				'panel' => $layout_panel
			)
		);

		// Mobile menu label
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[secondary_nav_mobile_label]',
			array(
				'default' => $defaults['secondary_nav_mobile_label'],
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post'
			)
		);

		$wp_customize->add_control(
			'secondary_nav_mobile_label_control', array(
				'label' => __( 'Mobile Menu Label', 'parvati-premium' ),
				'section' => 'secondary_nav_section',
				'settings' => 'parvati_secondary_nav_settings[secondary_nav_mobile_label]',
				'priority' => 10
			)
		);

		// Navigation width
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[secondary_nav_layout_setting]',
			array(
				'default' => $defaults['secondary_nav_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'parvati_secondary_nav_settings[secondary_nav_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Width', 'parvati-premium' ),
				'section' => 'secondary_nav_section',
				'choices' => array(
					'secondary-fluid-nav' => __( 'Full', 'parvati-premium' ),
					'secondary-contained-nav' => __( 'Contained', 'parvati-premium' )
				),
				'settings' => 'parvati_secondary_nav_settings[secondary_nav_layout_setting]',
				'priority' => 15
			)
		);

		// Inner navigation width
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[secondary_nav_inner_width]',
			array(
				'default' => $defaults['secondary_nav_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'parvati_secondary_nav_settings[secondary_nav_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Navigation Width', 'parvati-premium' ),
				'section' => 'secondary_nav_section',
				'choices' => array(
					'full-width' => __( 'Full', 'parvati-premium' ),
					'contained' => __( 'Contained', 'parvati-premium' )
				),
				'settings' => 'parvati_secondary_nav_settings[secondary_nav_inner_width]',
				'priority' => 15
			)
		);

		// Navigation alignment
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[secondary_nav_alignment]',
			array(
				'default' => $defaults['secondary_nav_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'parvati_secondary_nav_settings[secondary_nav_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Alignment', 'parvati-premium' ),
				'section' => 'secondary_nav_section',
				'choices' => array(
					'left' => __( 'Left', 'parvati-premium' ),
					'center' => __( 'Center', 'parvati-premium' ),
					'right' => __( 'Right', 'parvati-premium' )
				),
				'settings' => 'parvati_secondary_nav_settings[secondary_nav_alignment]',
				'priority' => 20
			)
		);

		// Navigation location
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[secondary_nav_position_setting]',
			array(
				'default' => $defaults['secondary_nav_position_setting'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'parvati_secondary_nav_settings[secondary_nav_position_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Location', 'parvati-premium' ),
				'section' => 'secondary_nav_section',
				'choices' => array(
					'secondary-nav-below-header' => __( 'Below Header', 'parvati-premium' ),
					'secondary-nav-above-header' => __( 'Above Header', 'parvati-premium' ),
					'secondary-nav-float-right' => __( 'Float Right', 'parvati-premium' ),
					'secondary-nav-float-left' => __( 'Float Left', 'parvati-premium' ),
					'secondary-nav-left-sidebar' => __( 'Left Sidebar', 'parvati-premium' ),
					'secondary-nav-right-sidebar' => __( 'Right Sidebar', 'parvati-premium' ),
					'' => __( 'No Navigation', 'parvati-premium' )
				),
				'settings' => 'parvati_secondary_nav_settings[secondary_nav_position_setting]',
				'priority' => 30
			)
		);

		// Merge top bar
		$wp_customize->add_setting(
			'parvati_secondary_nav_settings[merge_top_bar]',
			array(
				'default' => $defaults['merge_top_bar'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'parvati_secondary_nav_settings[merge_top_bar]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Merge with Secondary Navigation', 'parvati-premium' ),
				'section' => 'parvati_top_bar',
				'settings' => 'parvati_secondary_nav_settings[merge_top_bar]',
				'priority' => 100,
				'active_callback' => 'parvati_secondary_nav_show_merge_top_bar'
			)
		);
	}
}

if ( ! function_exists( 'parvati_display_secondary_google_fonts' ) ) {
	add_filter( 'parvati_typography_google_fonts', 'parvati_display_secondary_google_fonts', 50 );
	/**
	 * Add Google Fonts to wp_head if needed.
	 *
	 */
	function parvati_display_secondary_google_fonts($google_fonts) {

		// Bail if no Secondary menu is set
		if ( ! has_nav_menu( 'secondary' ) ) {
			return $google_fonts;
		}

		$parvati_secondary_nav_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		// List our non-Google fonts
		if ( function_exists( 'parvati_typography_default_fonts' ) ) {
			$not_google = str_replace( ' ', '+', parvati_typography_default_fonts() );
		} else {
			$not_google = array(
				'inherit',
				'Arial,+Helvetica,+sans-serif',
				'Century+Gothic',
				'Comic+Sans+MS',
				'Courier+New',
				'Georgia,+Times+New+Roman,+Times,+serif',
				'Helvetica',
				'Impact',
				'Lucida+Console',
				'Lucida+Sans+Unicode',
				'Palatino+Linotype',
				'Tahoma,+Geneva,+sans-serif',
				'Trebuchet+MS,+Helvetica,+sans-serif',
				'Verdana,+Geneva,+sans-serif'
			);
		}

		// Create our Google Fonts array
		$secondary_google_fonts = array();

		if ( function_exists( 'parvati_get_google_font_variants' ) ) {

			// If our value is still using the old format, fix it
			if ( strpos( $parvati_secondary_nav_settings[ 'font_secondary_navigation' ], ':' ) !== false ) {
				$parvati_secondary_nav_settings[ 'font_secondary_navigation' ] = current( explode( ':', $parvati_secondary_nav_settings[ 'font_secondary_navigation' ] ) );
			}

			// Grab the variants using the plain name
			$variants = parvati_get_google_font_variants( $parvati_secondary_nav_settings[ 'font_secondary_navigation' ], 'font_secondary_navigation', parvati_secondary_nav_get_defaults() );

		} else {
			$variants = '';
		}

		// Replace the spaces in the names with a plus
		$value = str_replace( ' ', '+', $parvati_secondary_nav_settings[ 'font_secondary_navigation' ] );

		// If we have variants, add them to our value
		$value = ! empty( $variants ) ? $value . ':' . $variants : $value;

		// Add our value to the array
		$secondary_google_fonts[] = $value;

		// Ignore any non-Google fonts
		$secondary_google_fonts = array_diff($secondary_google_fonts, $not_google);

		// Separate each different font with a bar
		$secondary_google_fonts = implode('|', $secondary_google_fonts);

		if ( !empty( $secondary_google_fonts ) ) {
			$print_secondary_fonts = '|' . $secondary_google_fonts;
		} else {
			$print_secondary_fonts = '';
		}

		// Remove any duplicates
		$return = $google_fonts . $print_secondary_fonts;
		$return = implode('|',array_unique(explode('|', $return)));
		return $return;

	}
}

if ( ! function_exists( 'parvati_add_secondary_navigation_after_header' ) ) {
	add_action( 'parvati_after_header', 'parvati_add_secondary_navigation_after_header', 7 );
	/**
	 * Add the navigation after the header.
	 *
	 */
	function parvati_add_secondary_navigation_after_header() {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		if ( 'secondary-nav-below-header' == $parvati_settings['secondary_nav_position_setting'] ) {
			parvati_secondary_navigation_position();
		}

	}
}

if ( ! function_exists( 'parvati_add_secondary_navigation_before_header' ) ) {
	add_action( 'parvati_before_header', 'parvati_add_secondary_navigation_before_header', 7 );
	/**
	 * Add the navigation before the header.
	 *
	 */
	function parvati_add_secondary_navigation_before_header() {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		if ( 'secondary-nav-above-header' == $parvati_settings['secondary_nav_position_setting'] ) {
			parvati_secondary_navigation_position();
		}

	}
}

if ( ! function_exists( 'parvati_add_secondary_navigation_float_right' ) ) {
	add_action( 'parvati_before_header_content', 'parvati_add_secondary_navigation_float_right', 7 );
	/**
	 * Add the navigation inside the header so it can float right.
	 *
	 */
	function parvati_add_secondary_navigation_float_right() {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		if ( 'secondary-nav-float-right' == $parvati_settings['secondary_nav_position_setting'] || 'secondary-nav-float-left' == $parvati_settings['secondary_nav_position_setting'] ) {
			parvati_secondary_navigation_position();
		}

	}
}

if ( ! function_exists( 'parvati_add_secondary_navigation_before_right_sidebar' ) ) {
	add_action( 'parvati_before_right_sidebar_content', 'parvati_add_secondary_navigation_before_right_sidebar', 7 );
	/**
	 * Add the navigation into the right sidebar.
	 *
	 */
	function parvati_add_secondary_navigation_before_right_sidebar() {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		if ( 'secondary-nav-right-sidebar' == $parvati_settings['secondary_nav_position_setting'] ) {
			echo '<div class="gen-sidebar-secondary-nav">';
				parvati_secondary_navigation_position();
			echo '</div><!-- .gen-sidebar-secondary-nav -->';
		}

	}
}

if ( ! function_exists( 'parvati_add_secondary_navigation_before_left_sidebar' ) ) {
	add_action( 'parvati_before_left_sidebar_content', 'parvati_add_secondary_navigation_before_left_sidebar', 7 );
	/**
	 * Add the navigation into the left sidebar.
	 *
	 */
	function parvati_add_secondary_navigation_before_left_sidebar() {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		if ( 'secondary-nav-left-sidebar' == $parvati_settings['secondary_nav_position_setting'] ) {
			echo '<div class="gen-sidebar-secondary-nav">';
				parvati_secondary_navigation_position();
			echo '</div><!-- .gen-sidebar-secondary-nav -->';
		}

	}
}

if ( ! function_exists( 'parvati_secondary_navigation_position' ) ) {
	/**
	 * Build our secondary navigation.
	 * Would like to change this function name.
	 *
	 */
	function parvati_secondary_navigation_position() {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);
		if ( has_nav_menu( 'secondary' ) ) :
			?>
			<nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" id="secondary-navigation" <?php parvati_secondary_navigation_class(); ?>>
				<div <?php parvati_inside_secondary_navigation_class(); ?>>
					<?php do_action('parvati_inside_secondary_navigation'); ?>
					<button class="menu-toggle secondary-menu-toggle">
						<?php do_action( 'parvati_inside_secondary_mobile_menu' ); ?>
						<span class="mobile-menu"><?php echo $parvati_settings['secondary_nav_mobile_label']; ?></span>
					</button>
					<?php

						wp_nav_menu(
							array(
								'theme_location' => 'secondary',
								'container' => 'div',
								'container_class' => 'main-nav',
								'menu_class' => '',
								'fallback_cb' => 'parvati_secondary_menu_fallback',
								'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', parvati_get_secondary_menu_class() ) . '">%3$s</ul>'
							)
						);

					?>
				</div><!-- .inside-navigation -->
			</nav><!-- #secondary-navigation -->
			<?php
		endif;
	}
}

if ( ! function_exists( 'parvati_secondary_menu_fallback' ) ) {
	/**
	 * Menu fallback.
	 *
	 * @param  array $args
	 * @return string
	 */
	function parvati_secondary_menu_fallback( $args ) {
	?>
		<div class="main-nav">
			<ul <?php parvati_secondary_menu_class(); ?>>
				<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
			</ul>
		</div><!-- .main-nav -->
	<?php
	}
}

if ( ! function_exists( 'parvati_secondary_nav_body_classes' ) ) {
	add_filter( 'body_class', 'parvati_secondary_nav_body_classes' );
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 */
	function parvati_secondary_nav_body_classes( $classes ) {

		// Bail if no Secondary menu is set
		if ( ! has_nav_menu( 'secondary' ) ) {
			return $classes;
		}

		// Get theme options
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		$classes[] = ( $parvati_settings['secondary_nav_position_setting'] ) ? $parvati_settings['secondary_nav_position_setting'] : 'secondary-nav-below-header';

		// Navigation alignment class
		if ( $parvati_settings['secondary_nav_alignment'] == 'left' ) {
			$classes[] = 'secondary-nav-aligned-left';
		} elseif ( $parvati_settings['secondary_nav_alignment'] == 'center' ) {
			$classes[] = 'secondary-nav-aligned-center';
		} elseif ( $parvati_settings['secondary_nav_alignment'] == 'right' ) {
			$classes[] = 'secondary-nav-aligned-right';
		} else {
			$classes[] = 'secondary-nav-aligned-left';
		}

		return $classes;
	}
}

if ( ! function_exists( 'parvati_secondary_menu_classes' ) ) {
	add_filter( 'parvati_secondary_menu_class', 'parvati_secondary_menu_classes' );
	/**
	 * Adds custom classes to the menu.
	 *
	 */
	function parvati_secondary_menu_classes( $classes ) {

		$classes[] = 'secondary-menu';
		$classes[] = 'sf-menu';

		return $classes;

	}
}

if ( ! function_exists( 'parvati_secondary_navigation_classes' ) ) {
	add_filter( 'parvati_secondary_navigation_class', 'parvati_secondary_navigation_classes' );
	/**
	 * Adds custom classes to the navigation.
	 *
	 */
	function parvati_secondary_navigation_classes( $classes ) {

		$classes[] = 'secondary-navigation';

		// Get theme options
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		$nav_layout = $parvati_settings['secondary_nav_layout_setting'];

		if ( $nav_layout == 'secondary-contained-nav' ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;

	}
}

if ( ! function_exists( 'parvati_inside_secondary_navigation_classes' ) ) {
	add_filter( 'parvati_inside_secondary_navigation_class', 'parvati_inside_secondary_navigation_classes' );
	/**
	 * Adds custom classes to the inner navigation
	 */
	function parvati_inside_secondary_navigation_classes( $classes ) {
		$classes[] = 'inside-navigation';
		// Get theme options
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);
		$inner_nav_width = $parvati_settings['secondary_nav_inner_width'];

		if ( $inner_nav_width !== 'full-width' ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;

	}
}

if ( ! function_exists( 'parvati_secondary_nav_css' ) ) {
	/**
	 * Generate the CSS in the <head> section using the Theme Customizer.
	 *
	 */
	function parvati_secondary_nav_css() {

		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		if ( function_exists( 'parvati_spacing_get_defaults' ) ) {
			$spacing_settings = wp_parse_args(
				get_option( 'parvati_spacing_settings', array() ),
				parvati_spacing_get_defaults()
			);
			$separator = $spacing_settings[ 'separator' ];
		} else {
			$separator = 20;
		}

		if ( function_exists( 'parvati_get_font_family_css' ) ) {
			$secondary_nav_family = parvati_get_font_family_css( 'font_secondary_navigation', 'parvati_secondary_nav_settings', parvati_secondary_nav_get_defaults() );
		} else {
			$secondary_nav_family = current( explode( ':', $parvati_settings['font_secondary_navigation'] ) );
		}

		if ( '""' == $secondary_nav_family ) {
			$secondary_nav_family = 'inherit';
		}

		// Get our untouched defaults
		$og_defaults = parvati_secondary_nav_get_defaults( false );

		// Initiate our CSS class
		$css = new Parvati_Secondary_Nav_CSS;

		// Navigation background
		$css->set_selector( '.secondary-navigation' );
		$css->add_property( 'background-color', esc_attr( $parvati_settings[ 'secondary_navigation_background_color' ] ) );
		$css->add_property( 'background-image', !empty( $parvati_settings['nav_image'] ) ? 'url(' . esc_url( $parvati_settings['nav_image'] )	. ')' : '' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings['nav_repeat'] ) );

		// Top bar
		if ( 'secondary-nav-above-header' == $parvati_settings[ 'secondary_nav_position_setting' ] && has_nav_menu( 'secondary' ) && is_active_sidebar( 'top-bar' ) ) {
			$css->set_selector( '.secondary-navigation .top-bar' );
			$css->add_property( 'color', esc_attr( $parvati_settings[ 'navigation_text_color' ] ) );
			$css->add_property( 'line-height', absint( $parvati_settings[ 'secondary_menu_item_height' ] ), false, 'px' );
			$css->add_property( 'font-family', $secondary_nav_family );
			$css->add_property( 'font-weight', esc_attr( $parvati_settings[ 'secondary_navigation_font_weight' ] ) );
			$css->add_property( 'text-transform', esc_attr( $parvati_settings[ 'secondary_navigation_font_transform' ] ) );
			$css->add_property( 'font-size', absint( $parvati_settings[ 'secondary_navigation_font_size' ] ), false, 'px' );

			$css->set_selector( '.secondary-navigation .top-bar a' );
			$css->add_property( 'color', esc_attr( $parvati_settings[ 'navigation_text_color' ] ) );

			$css->set_selector( '.secondary-navigation .top-bar a:hover, .secondary-navigation .top-bar a:focus' );
			$css->add_property( 'color', esc_attr( $parvati_settings[ 'navigation_background_hover_color' ] ) );
		}

		// Navigation text
		$css->set_selector( '.secondary-navigation .main-nav ul li a,.secondary-navigation .menu-toggle' );
		$css->add_property( 'color', esc_attr( $parvati_settings[ 'secondary_navigation_text_color' ] ) );
		$css->add_property( 'font-family', ( 'inherit' !== $secondary_nav_family ) ? $secondary_nav_family : null );
		$css->add_property( 'font-weight', esc_attr( $parvati_settings[ 'secondary_navigation_font_weight' ] ), $og_defaults[ 'secondary_navigation_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $parvati_settings[ 'secondary_navigation_font_transform' ] ), $og_defaults[ 'secondary_navigation_font_transform' ] );
		$css->add_property( 'font-size', absint( $parvati_settings[ 'secondary_navigation_font_size' ] ), $og_defaults[ 'secondary_navigation_font_size' ], 'px' );
		$css->add_property( 'padding-left', absint( $parvati_settings[ 'secondary_menu_item' ] ), $og_defaults[ 'secondary_menu_item' ], 'px' );
		$css->add_property( 'padding-right', absint( $parvati_settings[ 'secondary_menu_item' ] ), $og_defaults[ 'secondary_menu_item' ], 'px' );
		$css->add_property( 'line-height', absint( $parvati_settings[ 'secondary_menu_item_height' ] ), $og_defaults[ 'secondary_menu_item_height' ], 'px' );
		$css->add_property( 'background-image', !empty( $parvati_settings['nav_item_image'] ) ? 'url(' . esc_url( $parvati_settings['nav_item_image'] ) . ')' : '' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings['nav_item_repeat'] ) );

		// Mobile menu text on hover
		$css->set_selector( 'button.secondary-menu-toggle:hover,button.secondary-menu-toggle:focus' );
		$css->add_property( 'color', esc_attr( $parvati_settings[ 'secondary_navigation_text_color' ] ) );

		// Widget area navigation
		$css->set_selector( '.widget-area .secondary-navigation' );
		$css->add_property( 'margin-bottom', absint( $separator ), false, 'px' );

		// Sub-navigation background
		$css->set_selector( '.secondary-navigation ul ul' );
		$css->add_property( 'background-color', esc_attr( $parvati_settings[ 'subnavigation_background_color' ] ) );
		$css->add_property( 'top', 'auto' ); // Added for compatibility purposes on 22/12/2016

		// Sub-navigation text
		$css->set_selector( '.secondary-navigation .main-nav ul ul li a' );
		$css->add_property( 'color', esc_attr( $parvati_settings[ 'subnavigation_text_color' ] ) );
		$css->add_property( 'font-size', absint( $parvati_settings[ 'secondary_navigation_font_size' ] - 1 ), absint( $og_defaults[ 'secondary_navigation_font_size' ] - 1 ), 'px' );
		$css->add_property( 'padding-left', absint( $parvati_settings[ 'secondary_menu_item' ] ), $og_defaults[ 'secondary_menu_item' ], 'px' );
		$css->add_property( 'padding-right', absint( $parvati_settings[ 'secondary_menu_item' ] ), $og_defaults[ 'secondary_menu_item' ], 'px' );
		$css->add_property( 'padding-top', absint( $parvati_settings[ 'secondary_sub_menu_item_height' ] ), $og_defaults[ 'secondary_sub_menu_item_height' ], 'px' );
		$css->add_property( 'padding-bottom', absint( $parvati_settings[ 'secondary_sub_menu_item_height' ] ), $og_defaults[ 'secondary_sub_menu_item_height' ], 'px' );
		$css->add_property( 'background-image', !empty( $parvati_settings['sub_nav_item_image'] ) ? 'url(' . esc_url( $parvati_settings['sub_nav_item_image'] ) . ')' : '' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings['sub_nav_item_repeat'] ) );

		// Menu item padding on RTL
		if ( is_rtl() ) {
			$css->set_selector( 'nav.secondary-navigation .main-nav ul li.menu-item-has-children > a' );
			$css->add_property( 'padding-right', absint( $parvati_settings[ 'secondary_menu_item' ] ), $og_defaults[ 'secondary_menu_item' ], 'px' );
		}

		// Dropdown arrow
		$css->set_selector( '.secondary-navigation .menu-item-has-children ul .dropdown-menu-toggle' );
		$css->add_property( 'padding-top', absint( $parvati_settings[ 'secondary_sub_menu_item_height' ] ), $og_defaults[ 'secondary_sub_menu_item_height' ], 'px' );
		$css->add_property( 'padding-bottom', absint( $parvati_settings[ 'secondary_sub_menu_item_height' ] ), $og_defaults[ 'secondary_sub_menu_item_height' ], 'px' );
		$css->add_property( 'margin-top', '-' . absint( $parvati_settings[ 'secondary_sub_menu_item_height' ] ), '-' . absint( $og_defaults[ 'secondary_sub_menu_item_height' ] ), 'px' );

		// Dropdown arrow
		$css->set_selector( '.secondary-navigation .menu-item-has-children .dropdown-menu-toggle' );
		$css->add_property( 'padding-right', absint( $parvati_settings[ 'secondary_menu_item' ] ), $og_defaults[ 'secondary_menu_item' ], 'px' );

		// Sub-navigation dropdown arrow
		$css->set_selector( '.secondary-navigation .menu-item-has-children ul .dropdown-menu-toggle' );
		$css->add_property( 'padding-top', absint( $parvati_settings[ 'secondary_sub_menu_item_height' ] ), $og_defaults[ 'secondary_sub_menu_item_height' ], 'px' );
		$css->add_property( 'padding-bottom', absint( $parvati_settings[ 'secondary_sub_menu_item_height' ] ), $og_defaults[ 'secondary_sub_menu_item_height' ], 'px' );
		$css->add_property( 'margin-top', '-' . absint( $parvati_settings[ 'secondary_sub_menu_item_height' ] ), '-' . absint( $og_defaults[ 'secondary_sub_menu_item_height' ] ), 'px' );

		// Navigation background/text on hover
		$css->set_selector( '.secondary-navigation .main-nav ul li:hover > a,.secondary-navigation .main-nav ul li:focus > a,.secondary-navigation .main-nav ul li.sfHover > a' );
		$css->add_property( 'color', esc_attr( $parvati_settings[ 'navigation_text_hover_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $parvati_settings[ 'navigation_background_hover_color' ] ) );
		$css->add_property( 'background-image', !empty( $parvati_settings[ 'nav_item_hover_image' ] ) ? 'url(' . esc_url( $parvati_settings[ 'nav_item_hover_image' ] )	. ')' : '' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings['nav_item_hover_repeat'] ) );

		// Sub-Navigation background/text on hover
		$css->set_selector( '.secondary-navigation .main-nav ul ul li:hover > a,.secondary-navigation .main-nav ul ul li:focus > a,.secondary-navigation .main-nav ul ul li.sfHover > a' );
		$css->add_property( 'color', esc_attr( $parvati_settings[ 'subnavigation_text_hover_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $parvati_settings[ 'subnavigation_background_hover_color' ] ) );
		$css->add_property( 'background-image', !empty( $parvati_settings[ 'sub_nav_item_hover_image' ] ) ? 'url(' . esc_url( $parvati_settings[ 'sub_nav_item_hover_image' ] )	. ')' : '' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings['sub_nav_item_hover_repeat'] ) );

		// Navigation background / text current + hover
		$css->set_selector( '.secondary-navigation .main-nav ul li[class*="current-menu-"] > a, .secondary-navigation .main-nav ul li[class*="current-menu-"] > a:hover,.secondary-navigation .main-nav ul li[class*="current-menu-"].sfHover > a' );
		$css->add_property( 'color', esc_attr( $parvati_settings[ 'navigation_text_current_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $parvati_settings[ 'navigation_background_current_color' ] ) );
		$css->add_property( 'background-image', !empty( $parvati_settings[ 'nav_item_current_image' ] ) ? 'url(' . esc_url( $parvati_settings[ 'nav_item_current_image' ] )	. ')' : '' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings['nav_item_current_repeat'] ) );

		// Sub-Navigation background / text current + hover
		$css->set_selector( '.secondary-navigation .main-nav ul ul li[class*="current-menu-"] > a,.secondary-navigation .main-nav ul ul li[class*="current-menu-"] > a:hover,.secondary-navigation .main-nav ul ul li[class*="current-menu-"].sfHover > a' );
		$css->add_property( 'color', esc_attr( $parvati_settings[ 'subnavigation_text_current_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $parvati_settings[ 'subnavigation_background_current_color' ] ) );
		$css->add_property( 'background-image', !empty( $parvati_settings[ 'sub_nav_item_current_image' ] ) ? 'url(' . esc_url( $parvati_settings[ 'sub_nav_item_current_image' ] )	. ')' : '' );
		$css->add_property( 'background-repeat', esc_attr( $parvati_settings['sub_nav_item_current_repeat'] ) );

		// RTL menu item padding
		if ( is_rtl() ) {
			$css->set_selector( '.secondary-navigation .main-nav ul li.menu-item-has-children > a' );
			$css->add_property( 'padding-right', absint( $parvati_settings[ 'secondary_menu_item' ] ), false, 'px' );
		}

		// Return our dynamic CSS
		return $css->css_output();
	}
}

if ( ! function_exists( 'parvati_secondary_color_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'parvati_secondary_color_scripts', 110 );
	/**
	 * Enqueue scripts and styles
	 */
	function parvati_secondary_color_scripts() {
		// Bail if no Secondary menu is set
		if ( ! has_nav_menu( 'secondary' ) ) {
			return;
		}

		wp_add_inline_style( 'parvati-secondary-nav', parvati_secondary_nav_css() );
	}
}

if ( ! function_exists( 'parvati_secondary_navigation_class' ) ) {
	/**
	 * Display the classes for the secondary navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function parvati_secondary_navigation_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . join( ' ', parvati_get_secondary_navigation_class( $class ) ) . '"';
	}
}

if ( ! function_exists( 'parvati_get_secondary_navigation_class' ) ) {
	/**
	 * Retrieve the classes for the secondary navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function parvati_get_secondary_navigation_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('parvati_secondary_navigation_class', $classes, $class);
	}
}

if ( ! function_exists( 'parvati_secondary_menu_class' ) ) {
	/**
	 * Display the classes for the secondary navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function parvati_secondary_menu_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . join( ' ', parvati_get_secondary_menu_class( $class ) ) . '"';
	}
}

if ( ! function_exists( 'parvati_get_secondary_menu_class' ) ) {
	/**
	 * Retrieve the classes for the secondary navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function parvati_get_secondary_menu_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('parvati_secondary_menu_class', $classes, $class);
	}
}

if ( ! function_exists( 'parvati_inside_secondary_navigation_class' ) ) {
	/**
	 * Display the classes for the inner navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function parvati_inside_secondary_navigation_class( $class = '' ) {
		$classes = array();

		if ( ! empty($class) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split('#\s+#', $class);
			}

			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		$return = apply_filters('parvati_inside_secondary_navigation_class', $classes, $class);

		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . join( ' ', $return ) . '"';
	}
}

if ( ! function_exists( 'parvati_hidden_secondary_navigation' ) && function_exists( 'is_customize_preview' ) ) {
	add_action( 'wp_footer', 'parvati_hidden_secondary_navigation' );
	/**
	 * Adds a hidden navigation if no navigation is set
	 * This allows us to use postMessage to position the navigation when it doesn't exist
	 */
	function parvati_hidden_secondary_navigation() {
		if ( is_customize_preview() && function_exists( 'parvati_secondary_navigation_position' ) ) {
			?>
			<div style="display:none;">
				<?php parvati_secondary_navigation_position(); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'parvati_secondary_nav_remove_top_bar' ) ) {
	add_action( 'wp', 'parvati_secondary_nav_remove_top_bar' );
	/**
	 * Remove the top bar and add it to the Secondary Navigation if it's set
	 */
	function parvati_secondary_nav_remove_top_bar() {
		$parvati_settings = wp_parse_args(
			get_option( 'parvati_secondary_nav_settings', array() ),
			parvati_secondary_nav_get_defaults()
		);

		if ( $parvati_settings[ 'merge_top_bar' ] && 'secondary-nav-above-header' == $parvati_settings[ 'secondary_nav_position_setting' ] && has_nav_menu( 'secondary' ) && is_active_sidebar( 'top-bar' ) ) {
			remove_action( 'parvati_before_header','parvati_top_bar', 5 );
			add_action( 'parvati_inside_secondary_navigation','parvati_secondary_nav_top_bar_widget', 5 );
			add_filter( 'parvati_is_top_bar_active', '__return_false' );
		}
	}
}

if ( ! function_exists( 'parvati_secondary_nav_top_bar_widget' ) ) {
	/**
	 * Build the top bar widget area
	 * This is placed into the secondary navigation if set
	 */
	function parvati_secondary_nav_top_bar_widget() {
		if ( ! is_active_sidebar( 'top-bar' ) ) {
			return;
		}
		?>
		<div class="top-bar">
			<div class="inside-top-bar">
				<?php dynamic_sidebar( 'top-bar' ); ?>
			</div>
		</div>
		<?php
	}
}
