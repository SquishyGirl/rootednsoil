<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'parvati_menu_plus_setup' ) ) {
	add_action( 'after_setup_theme', 'parvati_menu_plus_setup' );
	/**
	 * Register the slide-out menu
	 */
	function parvati_menu_plus_setup() {
		register_nav_menus( array(
			'slideout' => __( 'Slideout Navigation', 'parvati-premium' ),
		) );
	}
}

if ( ! function_exists( 'parvati_menu_plus_customize_register' ) ) {
	add_action( 'customize_register', 'parvati_menu_plus_customize_register', 100 );
	/**
	 * Initiate Customizer controls
	 */
	function parvati_menu_plus_customize_register( $wp_customize ) {
		// Get our defaults
		$defaults = parvati_menu_plus_get_defaults();

		// Get our Customizer helpers
		require_once PARVATI_LIBRARY_DIRECTORY . 'customizer-helpers.php';

		// Add our old Menu Plus panel
		// This panel shouldn't display anymore but is left for back compat
		if ( class_exists( 'WP_Customize_Panel' ) ) {
			if ( ! $wp_customize->get_panel( 'parvati_menu_plus' ) ) {
				$wp_customize->add_panel( 'parvati_menu_plus', array(
					'priority'       => 50,
					'capability'     => 'edit_theme_options',
					'theme_supports' => '',
					'title'          => esc_html__( 'Menu Plus', 'parvati-premium' ),
					'description'    => '',
				) );
			}
		}

		// Add our options to the Layout panel if it exists
		// The layout panel is in the free theme, so we have the fallback in case people haven't updated
		if ( $wp_customize->get_panel( 'parvati_layout_panel' ) ) {
			$panel = 'parvati_layout_panel';
			$navigation_section = 'parvati_layout_navigation';
			$header_section = 'parvati_layout_header';
			$sticky_menu_section = 'parvati_layout_navigation';
		} else {
			$panel = 'parvati_menu_plus';
			$navigation_section = 'menu_plus_section';
			$header_section = 'menu_plus_mobile_header';
			$sticky_menu_section = 'menu_plus_sticky_menu';
		}

		// Add Menu Plus section
		// This section shouldn't display anymore for the above reasons
		$wp_customize->add_section(
			'menu_plus_section',
			array(
				'title' => esc_html__( 'General Settings', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'panel' => 'parvati_menu_plus'
			)
		);

		// Mobile menu label
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[mobile_menu_label]',
			array(
				'default' => $defaults['mobile_menu_label'],
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post'
			)
		);

		$wp_customize->add_control(
			'mobile_menu_label_control', array(
				'label' => esc_html__( 'Mobile Menu Label', 'parvati-premium' ),
				'section' => $navigation_section,
				'settings' => 'parvati_menu_plus_settings[mobile_menu_label]'
			)
		);

		// Sticky menu section
		$wp_customize->add_section(
			'menu_plus_sticky_menu',
			array(
				'title' => esc_html__( 'Sticky Navigation', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'panel' => $panel,
				'priority' => 33
			)
		);

		// Sticky menu
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[sticky_menu]',
			array(
				'default' => $defaults['sticky_menu'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[sticky_menu]',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Sticky Navigation', 'parvati-premium' ),
				'section' => 'menu_plus_sticky_menu',
				'choices' => array(
					'mobile' => esc_html__( 'Mobile only', 'parvati-premium' ),
					'desktop' => esc_html__( 'Desktop only', 'parvati-premium' ),
					'true' => esc_html__( 'On', 'parvati-premium' ),
					'false' => esc_html__( 'Off', 'parvati-premium' )
				),
				'settings' => 'parvati_menu_plus_settings[sticky_menu]',
				'priority' => 105
			)
		);

		// Transition
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[sticky_menu_effect]',
			array(
				'default' => $defaults['sticky_menu_effect'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[sticky_menu_effect]',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Transition', 'parvati-premium' ),
				'section' => 'menu_plus_sticky_menu',
				'choices' => array(
					'fade' => esc_html__( 'Fade', 'parvati-premium' ),
					'slide' => esc_html__( 'Slide', 'parvati-premium' ),
					'none' => esc_html__( 'None', 'parvati-premium' )
				),
				'settings' => 'parvati_menu_plus_settings[sticky_menu_effect]',
				'active_callback' => 'parvati_sticky_navigation_activated',
				'priority' => 110
			)
		);

		// Auto hide on scroll down
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[auto_hide_sticky]',
			array(
				'default' => $defaults['auto_hide_sticky'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[auto_hide_sticky]',
			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Hide when scrolling down', 'parvati-premium' ),
				'section' => 'menu_plus_sticky_menu',
				'settings' => 'parvati_menu_plus_settings[auto_hide_sticky]',
				'priority' => 120,
				'active_callback' => 'parvati_sticky_navigation_activated',
			)
		);

		// Navigation logo
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[sticky_menu_logo]',
			array(
				'default' => $defaults['sticky_menu_logo'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_menu_plus_settings[sticky_menu_logo]',
				array(
					'label' => esc_html__( 'Navigation Logo', 'parvati-premium' ),
					'section' => $sticky_menu_section,
					'settings' => 'parvati_menu_plus_settings[sticky_menu_logo]',
					'priority' => 115
				)
			)
		);

		// Logo placement
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[sticky_menu_logo_position]',
			array(
				'default' => $defaults['sticky_menu_logo_position'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[sticky_menu_logo_position]',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Navigation Logo Placement', 'parvati-premium' ),
				'section' => $sticky_menu_section,
				'choices' => array(
					'sticky-menu' => esc_html__( 'Sticky', 'parvati-premium' ),
					'menu' => esc_html__( 'Sticky + Static', 'parvati-premium' ),
					'regular-menu' => esc_html__( 'Static', 'parvati-premium' )
				),
				'settings' => 'parvati_menu_plus_settings[sticky_menu_logo_position]',
				'priority' => 120,
				'active_callback' => 'parvati_navigation_logo_activated',
			)
		);

		// Mobile Header section
		// No longer displays
		$wp_customize->add_section(
			'menu_plus_mobile_header',
			array(
				'title' => esc_html__( 'Mobile Header', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'panel' => $panel,
				'priority' => 11
			)
		);

		// Mobile header
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[mobile_header]',
			array(
				'default' => $defaults['mobile_header'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[mobile_header]',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Mobile Header', 'parvati-premium' ),
				'section' => $header_section,
				'choices' => array(
					'disable' => esc_html__( 'Off', 'parvati-premium' ),
					'enable' => esc_html__( 'On', 'parvati-premium' )
				),
				'settings' => 'parvati_menu_plus_settings[mobile_header]',
			)
		);

		// Mobile header logo
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[mobile_header_logo]',
			array(
				'default' => $defaults['mobile_header_logo'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'parvati_menu_plus_settings[mobile_header_logo]',
				array(
					'label' => esc_html__( 'Logo', 'parvati-premium' ),
					'section' => $header_section,
					'settings' => 'parvati_menu_plus_settings[mobile_header_logo]',
					'active_callback' => 'parvati_mobile_header_activated'
				)
			)
		);

		// Sticky mobile header
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[mobile_header_sticky]',
			array(
				'default' => $defaults['mobile_header_sticky'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[mobile_header_sticky]',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Sticky', 'parvati-premium' ),
				'section' => $header_section,
				'choices' => array(
					'enable' => esc_html__( 'On', 'parvati-premium' ),
					'disable' => esc_html__( 'Off', 'parvati-premium' )
				),
				'settings' => 'parvati_menu_plus_settings[mobile_header_sticky]',
				'active_callback' => 'parvati_mobile_header_activated'
			)
		);

		// Auto hide on scroll down
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[mobile_header_auto_hide_sticky]',
			array(
				'default' => $defaults['mobile_header_auto_hide_sticky'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[mobile_header_auto_hide_sticky]',
			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Hide when scrolling down', 'parvati-premium' ),
				'section' => $header_section,
				'settings' => 'parvati_menu_plus_settings[mobile_header_auto_hide_sticky]',
				'active_callback' => 'parvati_mobile_header_sticky_activated'
			)
		);

		// Slide-out menu section
		$wp_customize->add_section(
			'menu_plus_slideout_menu',
			array(
				'title' => esc_html__( 'Slideout Navigation', 'parvati-premium' ),
				'capability' => 'edit_theme_options',
				'panel' => $panel,
				'priority' => 34
			)
		);

		// Slide-out menu
		$wp_customize->add_setting(
			'parvati_menu_plus_settings[slideout_menu]',
			array(
				'default' => $defaults['slideout_menu'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[slideout_menu]',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Slideout Navigation', 'parvati-premium' ),
				'section' => 'menu_plus_slideout_menu',
				'choices' => array(
					'mobile' => esc_html__( 'Mobile only', 'parvati-premium' ),
					'desktop' => esc_html__( 'Desktop only', 'parvati-premium' ),
					'both' => esc_html__( 'On', 'parvati-premium' ),
					'false' => esc_html__( 'Off', 'parvati-premium' )
				),
				'settings' => 'parvati_menu_plus_settings[slideout_menu]',
			)
		);

		$wp_customize->add_setting(
			'parvati_menu_plus_settings[slideout_menu_side]',
			array(
				'default' => $defaults['slideout_menu_side'],
				'type' => 'option',
				'sanitize_callback' => 'parvati_premium_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'parvati_menu_plus_settings[slideout_menu_side]',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Side', 'parvati-premium' ),
				'section' => 'menu_plus_slideout_menu',
				'choices' => array(
					'left' => esc_html__( 'Left', 'parvati-premium' ),
					'right' => esc_html__( 'Right', 'parvati-premium' ),
				),
				'settings' => 'parvati_menu_plus_settings[slideout_menu_side]',
				'active_callback' => 'parvati_slideout_navigation_activated',
			)
		);
	}
}

if ( ! function_exists( 'parvati_menu_plus_enqueue_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'parvati_menu_plus_enqueue_css', 100 );
	/**
	 * Enqueue scripts
	 */
	function parvati_menu_plus_enqueue_css() {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Add sticky menu script
		if ( 'false' !== $settings['sticky_menu'] ) {
			wp_enqueue_style( 'parvati-sticky', plugin_dir_url( __FILE__ ) . "css/sticky{$suffix}.css", array(), PARVATI_MENU_PLUS_VERSION );
		}

		// Add slideout menu script
		if ( 'false' !== $settings['slideout_menu'] ) {
			wp_enqueue_style( 'parvati-offside', plugin_dir_url( __FILE__ ) . "css/offside{$suffix}.css", array(), PARVATI_MENU_PLUS_VERSION );
		}

		// Add regular menu logo styling
		if ( '' !== $settings['sticky_menu_logo'] ) {
			wp_enqueue_style( 'parvati-menu-logo', plugin_dir_url( __FILE__ ) . "css/menu-logo{$suffix}.css", array(), PARVATI_MENU_PLUS_VERSION );
		}

		// Add mobile header CSS
		if ( 'enable' == $settings['mobile_header'] ) {
			wp_enqueue_style( 'parvati-mobile-header', plugin_dir_url( __FILE__ ) . "css/mobile-header{$suffix}.css", array(), PARVATI_MENU_PLUS_VERSION );
		}

		// Add inline CSS
		wp_add_inline_style( 'parvati-style', parvati_menu_plus_inline_css() );

	}
}

if ( ! function_exists( 'parvati_menu_plus_enqueue_js' ) ) {
	add_action( 'wp_enqueue_scripts', 'parvati_menu_plus_enqueue_js', 0 );
	/**
	 * Enqueue scripts
	 */
	function parvati_menu_plus_enqueue_js() {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Add sticky menu script
		if ( ( 'false' !== $settings['sticky_menu'] ) || ( 'enable' == $settings['mobile_header'] && 'enable' == $settings['mobile_header_sticky'] ) ) {
			wp_enqueue_script( 'parvati-sticky', plugin_dir_url( __FILE__ ) . "js/sticky{$suffix}.js", array( 'jquery' ), PARVATI_MENU_PLUS_VERSION, true );
		}

		// Add slideout menu script
		if ( 'false' !== $settings['slideout_menu'] ) {
			wp_enqueue_script( 'parvati-offside', plugin_dir_url( __FILE__ ) . "js/offside{$suffix}.js", array(), PARVATI_MENU_PLUS_VERSION, true );

			wp_localize_script(
				'parvati-offside',
				'offSide',
				array(
					'side' => $settings['slideout_menu_side']
				)
			);
		}
	}
}

if ( ! function_exists( 'parvati_menu_plus_mobile_header_js' ) ) {
	add_action( 'wp_enqueue_scripts', 'parvati_menu_plus_mobile_header_js', 15 );
	/**
	 * Enqueue scripts
	 */
	function parvati_menu_plus_mobile_header_js() {
		if ( function_exists( 'wp_add_inline_script' ) ) {

			$settings = wp_parse_args(
				get_option( 'parvati_menu_plus_settings', array() ),
				parvati_menu_plus_get_defaults()
			);

			if ( 'enable' == $settings[ 'mobile_header' ] && ( 'desktop' == $settings[ 'slideout_menu' ] || 'false' == $settings[ 'slideout_menu' ] ) ) {
				wp_add_inline_script( 'parvati-navigation',
					"jQuery( document ).ready( function($) {
						$( '#mobile-header .menu-toggle' ).on( 'click', function( e ) {
							e.preventDefault();
							$( this ).closest( '#mobile-header' ).toggleClass( 'toggled' );
							$( this ).closest( '#mobile-header' ).attr( 'aria-expanded', $( this ).closest( '#mobile-header' ).attr( 'aria-expanded' ) === 'true' ? 'false' : 'true' );
							$( this ).toggleClass( 'toggled' );
							$( this ).children( 'i' ).toggleClass( 'fa-bars' ).toggleClass( 'fa-close' );
							$( this ).attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
						});
					});"
				);
			}
		}
	}
}

if ( ! function_exists( 'parvati_menu_plus_inline_css' ) ) {
	/**
	 * Enqueue inline CSS
	 */
	function parvati_menu_plus_inline_css() {
		// Bail if Parvati isn't active
		if ( ! function_exists( 'parvati_get_defaults' ) ) {
			return;
		}

		$parvati_settings = wp_parse_args(
			get_option( 'parvati_settings', array() ),
			parvati_get_defaults()
		);

		$parvati_menu_plus_settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		if ( function_exists( 'parvati_spacing_get_defaults' ) ) {
			$spacing_settings = wp_parse_args(
				get_option( 'parvati_spacing_settings', array() ),
				parvati_spacing_get_defaults()
			);
			$menu_height = $spacing_settings['menu_item_height'];
		} else {
			$menu_height = 60;
		}

		$return = '';

		if ( '' !== $parvati_menu_plus_settings['sticky_menu_logo'] ) {
			$return .= '.main-navigation .navigation-logo img {height:' . absint( $menu_height ) . 'px;}';
			$return .= '@media (max-width: ' . ( absint( $parvati_settings['container_width'] + 10 ) ) . 'px) {.main-navigation .navigation-logo.site-logo {margin-left:0;}body.sticky-menu-logo.nav-float-left .main-navigation .site-logo.navigation-logo {margin-right:0;}}';
		}

		if ( '' !== $parvati_menu_plus_settings['mobile_header_logo'] ) {
			$return .= '.mobile-header-navigation .mobile-header-logo img {height:' . absint( $menu_height ) . 'px;}';
		}

		if ( 'false' !== $parvati_menu_plus_settings['sticky_menu'] ) {
			$return .= '.main-navigation .main-nav ul li a,.menu-toggle,.main-navigation .mobile-bar-items a{transition: line-height 300ms ease}';
		}

		return $return;
	}
}

if ( ! function_exists( 'parvati_menu_plus_mobile_header' ) ) {
	add_action( 'parvati_after_header', 'parvati_menu_plus_mobile_header', 5 );
	add_action( 'parvati_inside_mobile_header', 'parvati_navigation_search', 1 );
	add_action( 'parvati_inside_mobile_header', 'parvati_mobile_menu_search_icon' );
	function parvati_menu_plus_mobile_header() {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		if ( 'disable' == $settings[ 'mobile_header' ] ) {
			return;
		}

		if ( 'false' !== $settings['mobile_header_auto_hide_sticky'] && $settings[ 'mobile_header_auto_hide_sticky' ] ) {
			$hide_sticky = ' data-auto-hide-sticky="true"';
		} else {
			$hide_sticky = '';
		}
		?>
		<nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" id="mobile-header"<?php echo $hide_sticky;?> class="main-navigation mobile-header-navigation">
			<div class="inside-navigation grid-container grid-parent">
				<?php do_action( 'parvati_inside_mobile_header' ); ?>
				<button class="menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
					<?php do_action( 'parvati_inside_mobile_header_menu' ); ?>
					<span class="mobile-menu"><?php echo apply_filters('parvati_mobile_menu_label', __( 'Menu', 'parvati-premium' ) ); ?></span>
				</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => apply_filters( 'parvati_mobile_header_theme_location', 'primary' ),
						'container' => 'div',
						'container_class' => 'main-nav',
						'container_id' => 'mobile-menu',
						'menu_class' => '',
						'fallback_cb' => 'parvati_menu_fallback',
						'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', parvati_get_menu_class() ) . '">%3$s</ul>'
					)
				);
				?>
			</div><!-- .inside-navigation -->
		</nav><!-- #site-navigation -->
		<?php
	}
}

if ( ! function_exists( 'parvati_slideout_navigation' ) ) {
	/**
	 * Build the navigation.
	 *
	 */
	add_action( 'wp_footer', 'parvati_slideout_navigation', 0 );
	function parvati_slideout_navigation() {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		if ( 'false' == $settings['slideout_menu'] ) {
			return;
		}
		?>
		<nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" id="parvati-slideout-menu" class="main-navigation slideout-navigation" style="display: none;">
			<div class="inside-navigation grid-container grid-parent">
				<?php
				do_action( 'parvati_inside_slideout_navigation' );

				wp_nav_menu(
					array(
						'theme_location' => 'slideout',
						'container' => 'div',
						'container_class' => 'main-nav',
						'menu_class' => '',
						'fallback_cb' => false,
						'items_wrap' => '<ul id="%1$s" class="%2$s slideout-menu">%3$s</ul>'
					)
				);

				do_action( 'parvati_after_slideout_navigation' );
				?>
			</div><!-- .inside-navigation -->
		</nav><!-- #site-navigation -->

		<div class="slideout-overlay">
			<button class="slideout-exit">
				<span class="screen-reader-text"><?php esc_attr_e( 'Close', 'parvati-premium' ); ?></span>
			</button>
		</div>
		<?php
	}
}

add_action( 'parvati_after_slideout_navigation', 'parvati_slideout_menu_widget' );
function parvati_slideout_menu_widget() {
	if ( is_active_sidebar( 'slide-out-widget' ) ) {
		dynamic_sidebar( 'slide-out-widget' );
	}
}

if ( ! function_exists( 'parvati_slideout_menu_fallback' ) ) {
	/**
	 * Menu fallback.
	 *
	 * @param  array $args
	 * @return string
	 */
	function parvati_slideout_menu_fallback( $args ) {

	}
}

add_action( 'widgets_init', 'parvati_slideout_navigation_widget', 99 );
/**
 * Register widgetized area and update sidebar with default widgets
 */
function parvati_slideout_navigation_widget() {
	register_sidebar( array(
		'name'          => esc_html__( 'Slideout Navigation', 'parvati-premium' ),
		'id'            => 'slide-out-widget',
		'before_widget' => '<aside id="%1$s" class="slideout-widget">',
		'after_widget'  => '</aside>',
		'before_title'  => apply_filters( 'parvati_start_widget_title', '<h2 class="widget-title">' ),
		'after_title'   => apply_filters( 'parvati_end_widget_title', '</h2>' ),
	) );
}

if ( ! function_exists( 'parvati_slideout_body_classes' ) ) {
	add_filter( 'body_class', 'parvati_slideout_body_classes' );
	/**
	 * Adds custom classes to body
	 *
	 */
	function parvati_slideout_body_classes( $classes ) {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		// Slide-out menu classes
		if ( 'false' !== $settings['slideout_menu'] ) {
			$classes[] = 'slideout-enabled';
		}

		if ( 'mobile' == $settings['slideout_menu'] ) {
			$classes[] = 'slideout-mobile';
		}

		if ( 'desktop' == $settings['slideout_menu'] ) {
			$classes[] = 'slideout-desktop';
		}

		if ( 'both' == $settings['slideout_menu'] ) {
			$classes[] = 'slideout-both';
		}

		// Sticky menu transition class
		if ( 'slide' == $settings['sticky_menu_effect'] ) {
			$classes[] = 'sticky-menu-slide';
		}

		if ( 'fade' == $settings['sticky_menu_effect'] ) {
			$classes[] = 'sticky-menu-fade';
		}

		if ( 'none' == $settings['sticky_menu_effect'] ) {
			$classes[] = 'sticky-menu-no-transition';
		}

		// If sticky menu is enabled
		if ( 'false' !== $settings['sticky_menu'] ) {
			$classes[] = 'sticky-enabled';
		}

		// Sticky menu classes
		if ( '' !== $settings['sticky_menu_logo'] ) {

			if ( 'sticky-menu' == $settings['sticky_menu_logo_position'] ) {
				$classes[] = 'sticky-menu-logo';
			} elseif ( 'menu' == $settings['sticky_menu_logo_position'] ) {
				$classes[] = 'menu-logo';
			} elseif ( 'regular-menu' == $settings['sticky_menu_logo_position'] ) {
				$classes[] = 'regular-menu-logo';
			}

			$classes[] = 'menu-logo-enabled';

		}

		// Menu logo classes
		if ( 'mobile' == $settings['sticky_menu'] ) {
			$classes[] = 'mobile-sticky-menu';
		}

		if ( 'desktop' == $settings['sticky_menu'] ) {
			$classes[] = 'desktop-sticky-menu';
		}

		if ( 'true' == $settings['sticky_menu'] ) {
			$classes[] = 'both-sticky-menu';
		}

		// Mobile header classes
		if ( 'enable' == $settings['mobile_header'] ) {
			$classes[] = 'mobile-header';
		}

		if ( '' !== $settings['mobile_header_logo'] && 'enable' == $settings['mobile_header'] ) {
			$classes[] = 'mobile-header-logo';
		}

		if ( 'enable' == $settings['mobile_header_sticky'] && 'enable' == $settings['mobile_header'] ) {
			$classes[] = 'mobile-header-sticky';
		}

		return $classes;

	}
}

if ( ! function_exists( 'parvati_menu_plus_slidebar_icon' ) ) {
	add_filter( 'wp_nav_menu_items', 'parvati_menu_plus_slidebar_icon', 10, 2 );
	/**
	 * Add slidebar icon to primary menu if set
	 *
	 */
	function parvati_menu_plus_slidebar_icon( $nav, $args ) {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		// If the search icon isn't enabled, return the regular nav
		if ( 'desktop' !== $settings['slideout_menu'] && 'both' !== $settings['slideout_menu'] ) {
			return $nav;
		}

		// If our primary menu is set, add the search icon
	    if( $args->theme_location == 'primary' ) {
	        return $nav . '<li class="slideout-toggle"><a href="#parvati-slideout-menu" data-transition="overlay"></a></li>';
		}

		// Our primary menu isn't set, return the regular nav
		// In this case, the search icon is added to the parvati_menu_fallback() function in navigation.php
	    return $nav;
	}
}

if ( ! function_exists( 'parvati_sticky_navigation_classes' ) ) {
	add_filter( 'parvati_navigation_class', 'parvati_sticky_navigation_classes' );
	/**
	 * Adds custom classes to the navigation.
	 *
	 */
	function parvati_sticky_navigation_classes( $classes ) {

		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		if ( 'false' !== $settings['sticky_menu'] && $settings[ 'auto_hide_sticky' ] ) {
			$classes[] = 'auto-hide-sticky';
		}

		return $classes;

	}
}

if ( ! function_exists( 'parvati_menu_plus_label' ) ) {
	add_filter( 'parvati_mobile_menu_label', 'parvati_menu_plus_label' );
	/**
	 * Add mobile menu label
	 *
	 */
	function parvati_menu_plus_label() {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		return wp_kses_post( $settings['mobile_menu_label'] );
	}
}

if ( ! function_exists( 'parvati_menu_plus_sticky_logo' ) ) {
	add_action( 'parvati_inside_navigation', 'parvati_menu_plus_sticky_logo' );
	/**
	 * Add logo to sticky menu
	 *
	 */
	function parvati_menu_plus_sticky_logo() {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		if ( '' == $settings['sticky_menu_logo'] ) {
			return;
		}

		echo apply_filters( 'parvati_navigation_logo_output', sprintf(
			'<div class="site-logo sticky-logo navigation-logo">
				<a href="%1$s" title="%2$s" rel="home">
					<img class="header-image" src="%3$s" alt="%4$s" />
				</a>
			</div>',
			esc_url( apply_filters( 'parvati_logo_href' , home_url( '/' ) ) ),
			esc_attr( apply_filters( 'parvati_logo_title', get_bloginfo( 'name', 'display' ) ) ),
			esc_url( apply_filters( 'parvati_navigation_logo', $settings['sticky_menu_logo'] ) ),
			esc_attr( apply_filters( 'parvati_logo_title', get_bloginfo( 'name', 'display' ) ) )
		) );
	}
}

if ( ! function_exists( 'parvati_menu_plus_mobile_header_logo' ) ) {
	add_action( 'parvati_inside_mobile_header', 'parvati_menu_plus_mobile_header_logo', 5 );
	/**
	 * Add logo to mobile header
	 *
	 */
	function parvati_menu_plus_mobile_header_logo() {
		$settings = wp_parse_args(
			get_option( 'parvati_menu_plus_settings', array() ),
			parvati_menu_plus_get_defaults()
		);

		if ( '' == $settings['mobile_header_logo'] ) {
			return;
		}

		echo apply_filters( 'parvati_mobile_header_logo_output', sprintf(
			'<div class="site-logo mobile-header-logo">
				<a href="%1$s" title="%2$s" rel="home">
					<img class="header-image" src="%3$s" alt="%4$s" />
				</a>
			</div>',
			esc_url( apply_filters( 'parvati_logo_href' , home_url( '/' ) ) ),
			esc_attr( apply_filters( 'parvati_logo_title', get_bloginfo( 'name', 'display' ) ) ),
			esc_url( apply_filters( 'parvati_mobile_header_logo', $settings['mobile_header_logo'] ) ),
			esc_attr( apply_filters( 'parvati_logo_title', get_bloginfo( 'name', 'display' ) ) )
		) );
	}
}

/**
 * Build our dynamic CSS.
 *
 */
function parvati_menu_plus_make_css() {
	if ( ! function_exists( 'parvati_get_color_defaults' ) || ! function_exists( 'parvati_get_defaults' ) || ! function_exists( 'parvati_get_default_fonts' ) ) {
		return;
	}

	$defaults = array_merge( parvati_get_color_defaults(), parvati_get_defaults(), parvati_get_default_fonts() );

	// Get our color settings
	$settings = wp_parse_args(
		get_option( 'parvati_settings', array() ),
		$defaults
	);

	// Initiate our CSS class
	require_once PARVATI_LIBRARY_DIRECTORY . 'class-make-css.php';
	$css = new Parvati_Pro_CSS;

	// Navigation background
	$css->set_selector( '.slideout-navigation.main-navigation, .transparent-header #parvati-slideout-menu.main-navigation' );
	$css->add_property( 'background-color', esc_attr( $settings[ 'slideout_background_color' ] ) );

	// Navigation text
	$css->set_selector( '.slideout-navigation.main-navigation .main-nav ul li a' );
	$css->add_property( 'color', esc_attr( $settings[ 'slideout_text_color' ] ) );
	$css->add_property( 'font-weight', esc_attr( $settings[ 'slideout_font_weight' ] ) );
	$css->add_property( 'text-transform', esc_attr( $settings[ 'slideout_font_transform' ] ) );

	if ( '' !== $settings[ 'slideout_font_size' ] ) {
		$css->add_property( 'font-size', absint( $settings[ 'slideout_font_size' ] ), false, 'px' );
	}
	
	$css->set_selector( '.slideout-widget' );
	$css->add_property( 'color', esc_attr( $settings[ 'slideout_text_color' ] ) );

	// Slideout link color
	$css->set_selector( '.slideout-navigation a' );
	$css->add_property( 'color', esc_attr( $settings[ 'slideout_text_color' ] ) );

	// Sub-navigation background
	$css->set_selector( '.slideout-navigation.main-navigation ul ul' );
	$css->add_property( 'background-color', esc_attr( $settings[ 'slideout_submenu_background_color' ] ) );

	// Sub-navigation text
	$css->set_selector( '.slideout-navigation.main-navigation .main-nav ul ul li a' );
	$css->add_property( 'color', esc_attr( $settings[ 'slideout_submenu_text_color' ] ) );

	if ( '' !== $settings[ 'slideout_font_size' ] ) {
		$css->add_property( 'font-size', absint( $settings[ 'slideout_font_size' ] - 1 ), false, 'px' );
	}

	if ( '' !== $settings[ 'slideout_mobile_font_size' ] ) {
		$css->start_media_query( apply_filters( 'parvati_mobile_media_query', '(max-width:768px)' ) );
			$css->set_selector( '.slideout-navigation.main-navigation .main-nav ul li a' );
			$css->add_property( 'font-size', absint( $settings[ 'slideout_mobile_font_size' ] ), false, 'px' );

			$css->set_selector( '.slideout-navigation.main-navigation .main-nav ul ul li a' );
			$css->add_property( 'font-size', absint( $settings[ 'slideout_mobile_font_size' ] - 1 ), false, 'px' );
		$css->stop_media_query();
	}

	// Navigation background/text on hover
	$css->set_selector( '.slideout-navigation.main-navigation .main-nav ul li:hover > a,.slideout-navigation.main-navigation .main-nav ul li:focus > a,.slideout-navigation.main-navigation .main-nav ul li.sfHover > a' );
	$css->add_property( 'color', esc_attr( $settings[ 'slideout_text_hover_color' ] ) );
	$css->add_property( 'background-color', esc_attr( $settings[ 'slideout_background_hover_color' ] ) );

	// Sub-Navigation background/text on hover
	$css->set_selector( '.slideout-navigation.main-navigation .main-nav ul ul li:hover > a,.slideout-navigation.main-navigation .main-nav ul ul li:focus > a,.slideout-navigation.main-navigation .main-nav ul ul li.sfHover > a' );
	$css->add_property( 'color', esc_attr( $settings[ 'slideout_submenu_text_hover_color' ] ) );
	$css->add_property( 'background-color', esc_attr( $settings[ 'slideout_submenu_background_hover_color' ] ) );

	// Navigation background / text current + hover
	$css->set_selector( '.slideout-navigation.main-navigation .main-nav ul li[class*="current-menu-"] > a, .slideout-navigation.main-navigation .main-nav ul li[class*="current-menu-"] > a:hover,.slideout-navigation.main-navigation .main-nav ul li[class*="current-menu-"].sfHover > a' );
	$css->add_property( 'color', esc_attr( $settings[ 'slideout_text_current_color' ] ) );
	$css->add_property( 'background-color', esc_attr( $settings[ 'slideout_background_current_color' ] ) );

	// Sub-Navigation background / text current + hover
	$css->set_selector( '.slideout-navigation.main-navigation .main-nav ul ul li[class*="current-menu-"] > a,.slideout-navigation.main-navigation .main-nav ul ul li[class*="current-menu-"] > a:hover,.slideout-navigation.main-navigation .main-nav ul ul li[class*="current-menu-"].sfHover > a' );
	$css->add_property( 'color', esc_attr( $settings[ 'slideout_submenu_text_current_color' ] ) );
	$css->add_property( 'background-color', esc_attr( $settings[ 'slideout_submenu_background_current_color' ] ) );

	return $css->css_output();
}

add_action( 'wp_enqueue_scripts', 'parvati_menu_plus_enqueue_dynamic_css', 100 );
/**
 * Enqueue our dynamic CSS.
 *
 */
function parvati_menu_plus_enqueue_dynamic_css() {
	wp_add_inline_style( 'parvati-style', parvati_menu_plus_make_css() );
}
