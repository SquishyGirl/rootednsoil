<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WPKoi_Elements_Integration' ) ) {

	/**
	 * Define WPKoi_Elements_Integration class
	 */
	class WPKoi_Elements_Integration {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Localize data
		 */
		public $elements_data = array(
			'sections' => array(),
			'columns'  => array(),
			'widgets'  => array(),
		);

		/**
		 * Check if processing elementor widget
		 */
		private $is_elementor_ajax = false;

		/**
		 * Localize data array
		 */
		public $localize_data = array();

		/**
		 * Initalize integration hooks
		 */
		public function init() {
			
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_addons' ), 10 );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_vendor_addons' ), 20 );

			add_action( 'elementor/controls/controls_registered', array( $this, 'add_controls' ), 10 );

			add_action( 'wp_ajax_elementor_render_widget', array( $this, 'set_elementor_ajax' ), 10, -1 );
			
			add_action( 'elementor/frontend/before_register_scripts', array( $this, 'register_scripts' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ) );
			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );

			// Frontend messages
			$this->localize_data['messages'] = array(
				'invalidMail' => esc_html__( 'Please specify a valid e-mail', 'wpkoi-elements' ),
			);
		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 */
		public function enqueue_styles() {

			wp_enqueue_style('wpkoi-elements',WPKOI_ELEMENTS_URL . 'assets/css/wpkoi-elements.css',false,WPKOI_ELEMENTS_VERSION);
			
			wp_enqueue_style('wpkoi_elements_elementor-slick-css',WPKOI_ELEMENTS_URL.'assets/slick/slick.css');
		
			wp_enqueue_script('wpkoi_elements_elementor-filterizr-js',WPKOI_ELEMENTS_URL.'assets/js/jquery.filterizr.min.js', array('jquery'),'1.0', true);
		
			wp_enqueue_script('wpkoi-elements-scripts',WPKOI_ELEMENTS_URL.'assets/js/premium-scripts.js', array('jquery'),'1.0', true);
			
			wp_enqueue_script('wpkoi_elements_elementor-masonry-js',WPKOI_ELEMENTS_URL.'assets/js/masonry.min.js', array('jquery'),'1.0', true);
			wp_enqueue_script('wpkoi_elements_elementor-load-more-js',WPKOI_ELEMENTS_URL.'assets/js/load-more.js', array('jquery'),'1.0', true);
			wp_enqueue_script('wpkoi_elements_magnific-popup-js',WPKOI_ELEMENTS_URL.'assets/js/jquery.magnific-popup.min.js', array('jquery'),'1.0', true);
			wp_enqueue_script('wpkoi_elements_elementor-slick-js',WPKOI_ELEMENTS_URL.'assets/slick/slick.min.js', array('jquery'),'1.0', true);
			
			// options for effects
			$wtfe_parallax_section 		= get_option( 'wtfe_parallax_section', '' );
			$wtfe_element_effects 		= get_option( 'wtfe_element_effects', '' );
			$wtfe_particles 			= get_option( 'wtfe_particles', '' );
			$wtfe_sticky_column			= get_option( 'wtfe_sticky_column', '' );
			
			$wtfe_advanced_accordion 	= get_option( 'wtfe_advanced_accordion', '' );
			$wtfe_advanced_tabs 		= get_option( 'wtfe_advanced_tabs', '' );
			$wtfe_advanced_headings 	= get_option( 'wtfe_advanced_headings', '' );
			$wtfe_animated_text			= get_option( 'wtfe_animated_text', '' );
			$wtfe_button 				= get_option( 'wtfe_button', '' );
			$wtfe_call_to_action 		= get_option( 'wtfe_call_to_action', '' );
			$wtfe_circle_progress 		= get_option( 'wtfe_circle_progress', '' );
			$wtfe_content_ticker 		= get_option( 'wtfe_content_ticker', '' );
			$wtfe_countdown 			= get_option( 'wtfe_countdown', '' );
			$wtfe_darkmode			 	= get_option( 'wtfe_darkmode', '' );
			$wtfe_data_table 			= get_option( 'wtfe_data_table', '' );
			$wtfe_distorted_headings 	= get_option( 'wtfe_distorted_headings', '' );
			$wtfe_filterable_gallery 	= get_option( 'wtfe_filterable_gallery', '' );
			$wtfe_flip_box 				= get_option( 'wtfe_flip_box', '' );
			$wtfe_hotspots 				= get_option( 'wtfe_hotspots', '' );
			$wtfe_image_accordion 		= get_option( 'wtfe_image_accordion', '' );
			$wtfe_image_comparison 		= get_option( 'wtfe_image_comparison', '' );
			$wtfe_post_grid 			= get_option( 'wtfe_post_grid', '' );
			$wtfe_post_timeline 		= get_option( 'wtfe_post_timeline', '' );
			$wtfe_pricing_table 		= get_option( 'wtfe_pricing_table', '' );
			$wtfe_product_grid 			= get_option( 'wtfe_product_grid', '' );
			$wtfe_qr_code 				= get_option( 'wtfe_qr_code', '' );
			$wtfe_scroll_navigation 	= get_option( 'wtfe_scroll_navigation', '' );
			$wtfe_team_member 			= get_option( 'wtfe_team_member', '' );
			$wtfe_testimonial 			= get_option( 'wtfe_testimonial', '' );
			$wtfe_unfold 				= get_option( 'wtfe_unfold', '' );
			$wtfe_view_more 			= get_option( 'wtfe_view_more', '' );
			
			
			if ( $wtfe_advanced_accordion != true ) {
				wp_enqueue_style('wpkoi-advance-accordion',WPKOI_ELEMENTS_URL . 'elements/advance-accordion/assets/advance-accordion.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_advanced_tabs != true ) {
				wp_enqueue_style('wpkoi-advance-tabs',WPKOI_ELEMENTS_URL . 'elements/advance-tabs/assets/advance-tabs.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_advanced_headings != true ) {
				wp_enqueue_style('wpkoi-advanced-heading',WPKOI_ELEMENTS_URL . 'elements/advanced-heading/assets/advanced-heading.css',false,WPKOI_ELEMENTS_VERSION);
				wp_enqueue_script('wpkoi-circletype-js',WPKOI_ELEMENTS_URL.'elements/advanced-heading/assets/circletype.min.js', '','1.0', true);
			}
			
			if ( $wtfe_animated_text != true ) {
				wp_enqueue_style('wpkoi-animated-text',WPKOI_ELEMENTS_URL . 'elements/animated-text/assets/animated-text.css',false,WPKOI_ELEMENTS_VERSION);
				wp_enqueue_script('wpkoi-anime-js');
			}
			
			if ( $wtfe_button != true ) {
				wp_enqueue_style('wpkoi-button',WPKOI_ELEMENTS_URL . 'elements/button/assets/button.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_call_to_action != true ) {
				wp_enqueue_style('wpkoi-call-to-action',WPKOI_ELEMENTS_URL . 'elements/call-to-action/assets/call-to-action.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_circle_progress != true ) {
				wp_enqueue_style('wpkoi-circle-progress',WPKOI_ELEMENTS_URL . 'elements/circle-progress/assets/circle-progress.css',false,WPKOI_ELEMENTS_VERSION);
				wp_enqueue_script('jquery-numerator');
			}
			
			if ( $wtfe_content_ticker != true ) {
				wp_enqueue_style('wpkoi-content-ticker',WPKOI_ELEMENTS_URL . 'elements/content-ticker/assets/content-ticker.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_countdown != true ) {
				wp_enqueue_style('wpkoi-countdown',WPKOI_ELEMENTS_URL . 'elements/countdown/assets/countdown.css',false,WPKOI_ELEMENTS_VERSION);
				wp_enqueue_script('wpkoi_elements_elementor-countdown-js',WPKOI_ELEMENTS_URL.'elements/countdown/assets/countdown.min.js', array('jquery'),'1.0', true);
			}
			
			if ( $wtfe_darkmode != true ) {
				wp_enqueue_script('darkmode',WPKOI_ELEMENTS_URL.'elements/darkmode/assets/darkmode-js.min.js', array('jquery'),WPKOI_ELEMENTS_VERSION, true);
				wp_enqueue_style('wpkoi-darkmode',WPKOI_ELEMENTS_URL . 'elements/darkmode/assets/darkmode.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_data_table != true ) {
				wp_enqueue_style('wpkoi-data-table',WPKOI_ELEMENTS_URL . 'elements/data-table/assets/data-table.css',false,WPKOI_ELEMENTS_VERSION);
				wp_enqueue_script('jquery-tablesorter',WPKOI_ELEMENTS_URL . 'elements/data-table/assets/jquery.tablesorter.min.js',array( 'jquery' ),'2.30.7',true);
			}
			
			if ( $wtfe_distorted_headings != true ) {
				wp_enqueue_script('wpkoi-blotter-js',WPKOI_ELEMENTS_URL.'elements/distorted-heading/assets/blotter.min.js', '',WPKOI_ELEMENTS_VERSION, true);
				wp_enqueue_script('wpkoi-distortmaterials-js',WPKOI_ELEMENTS_URL.'elements/distorted-heading/assets/materials.js', '',WPKOI_ELEMENTS_VERSION, true);
			}
			
			if ( $wtfe_element_effects != true ) {
				wp_enqueue_style('wpkoi-effects-style',WPKOI_ELEMENTS_URL . 'elements/effects/assets/effects.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_filterable_gallery != true ) {
				wp_enqueue_style('wpkoi-filterable-gallery',WPKOI_ELEMENTS_URL . 'elements/filterable-gallery/assets/filterable-gallery.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_flip_box != true ) {
				wp_enqueue_style('wpkoi-flipbox',WPKOI_ELEMENTS_URL . 'elements/flipbox/assets/flipbox.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_hotspots != true ) {
				wp_enqueue_style('wpkoi-hotspots',WPKOI_ELEMENTS_URL . 'elements/hotspots/assets/hotspots.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_image_accordion != true ) {
				wp_enqueue_style('wpkoi-image-accordion',WPKOI_ELEMENTS_URL . 'elements/image-accordion/assets/image-accordion.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_image_comparison != true ) {
				wp_enqueue_style('wpkoi-image-comparison',WPKOI_ELEMENTS_URL . 'elements/image-comparison/assets/image-comparison.css',false,WPKOI_ELEMENTS_VERSION);
				wp_enqueue_style('wpkoi-juxtapose-css',WPKOI_ELEMENTS_URL . 'elements/image-comparison/assets/juxtapose.css',false,'1.3.0');
				wp_register_script('wpkoi-juxtapose',WPKOI_ELEMENTS_URL . 'elements/image-comparison/assets/juxtapose.min.js',array(),'1.3.0',true);
			}
			
			if ( $wtfe_pricing_table != true ) {
				wp_enqueue_style('wpkoi-pricing-table',WPKOI_ELEMENTS_URL . 'elements/pricing-table/assets/pricing-table.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_qr_code != true ) {
				wp_enqueue_script('wpkoi-qrcode',WPKOI_ELEMENTS_URL.'elements/qr-code/assets/jquery.qrcode.min.js', array('jquery'),WPKOI_ELEMENTS_VERSION, true);
			}
			
			if ( $wtfe_scroll_navigation != true ) {
				wp_enqueue_style('wpkoi-scroll-navigation',WPKOI_ELEMENTS_URL . 'elements/scroll-navigation/assets/scroll-navigation.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_team_member != true ) {
				wp_enqueue_style('wpkoi-team-members',WPKOI_ELEMENTS_URL . 'elements/team-members/assets/team-members.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_testimonial != true ) {
				wp_enqueue_style('wpkoi-testimonials',WPKOI_ELEMENTS_URL . 'elements/testimonials/assets/testimonials.css',false,WPKOI_ELEMENTS_VERSION);
			}
			
			if ( $wtfe_unfold != true ) {
				wp_enqueue_style('wpkoi-unfold',WPKOI_ELEMENTS_URL . 'elements/unfold/assets/unfold.css',false,WPKOI_ELEMENTS_VERSION);
				wp_enqueue_script('wpkoi-anime-js');
			}
			
			if ( $wtfe_view_more != true ) {
				wp_enqueue_style('wpkoi-view-more',WPKOI_ELEMENTS_URL . 'elements/view-more/assets/view-more.css',false,WPKOI_ELEMENTS_VERSION);
			}

			if ( is_rtl() ) {
				wp_enqueue_style(
					'wpkoi-elements-rtl',
					WPKOI_ELEMENTS_URL . 'assets/css/wpkoi-elements-rtl.css',
					false,
					WPKOI_ELEMENTS_VERSION
				);
			}

			$default_theme_enabled = apply_filters( 'wpkoi-elements/assets/css/default-theme-enabled', true );

			if ( ! $default_theme_enabled ) {
				return;
			}

			wp_enqueue_style(
				'wpkoi-elements-skin',
				WPKOI_ELEMENTS_URL . 'assets/css/wpkoi-elements-skin.css',
				false,
				WPKOI_ELEMENTS_VERSION
			);

			if ( wpkoi_elements_integration()->in_elementor() ) {
				// Enqueue mediaelement css only in the editor.
				wp_enqueue_style( 'mediaelement' );
			}
		}

		/**
		 * Enqueue editor styles
		 */
		public function editor_styles() {
		}

		/**
		 * Register plugin scripts
		 */
		public function register_scripts() {

			// Register vendor anime.js script (https://github.com/juliangarnier/anime)
			wp_register_script(
				'wpkoi-anime-js',
				WPKOI_ELEMENTS_URL . 'assets/js/anime.min.js',
				array(),
				'2.2.0',
				true
			);

			wp_register_script(
				'wpkoi-tricks-tippy',
				WPKOI_ELEMENTS_URL . 'assets/js/tippy.all.min.js',
				array(),
				'2.5.2',
				true
			);
		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 */
		public function enqueue_scripts() {
			wp_enqueue_script(
				'wpkoi-elements',
				WPKOI_ELEMENTS_URL . 'assets/js/wpkoi-elements.js',
				array( 'jquery', 'elementor-frontend' ),
				WPKOI_ELEMENTS_VERSION,
				true
			);

			wp_localize_script(
				'wpkoi-elements',
				'wpkoiElements',
				apply_filters( 'wpkoi-elements/frontend/localize-data', $this->localize_data )
			);
			
			wp_enqueue_script( 'wpkoi-effects-js',
				WPKOI_ELEMENTS_URL . 'elements/effects/assets/effects.js', 
				array( 'jquery', 'elementor-frontend' ), 
				WPKOI_ELEMENTS_VERSION, 
				true 
			);
			

			wp_localize_script( 'wpkoi-particles', 'WPKoiTricksSettings', array(
				'elements_data' => $this->elements_data,
			) );
		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 */
		public function editor_scripts() {
			wp_enqueue_script(
				'wpkoi-elements-editor',
				WPKOI_ELEMENTS_URL . 'assets/js/wpkoi-elements-editor.js',
				array( 'jquery' ),
				WPKOI_ELEMENTS_VERSION,
				true
			);
		}

		/**
		 * Set $this->is_elementor_ajax to true on Elementor AJAX processing
		 */
		public function set_elementor_ajax() {
			$this->is_elementor_ajax = true;
		}

		/**
		 * Check if we currently in Elementor mode
		 */
		public function in_elementor() {

			$result = false;

			if ( wp_doing_ajax() ) {
				$result = $this->is_elementor_ajax;
			} elseif ( Elementor\Plugin::instance()->editor->is_edit_mode()
				|| Elementor\Plugin::instance()->preview->is_preview_mode() ) {
				$result = true;
			}

			/**
			 * Allow to filter result before return
			 */
			return apply_filters( 'wpkoi-elements/in-elementor', $result );
		}

		/**
		 * Register plugin addons
		 */
		public function register_addons( $widgets_manager ) {
			
			$wtfe_advanced_accordion 	= get_option( 'wtfe_advanced_accordion', '' );
			$wtfe_advanced_tabs 		= get_option( 'wtfe_advanced_tabs', '' );
			$wtfe_advanced_headings 	= get_option( 'wtfe_advanced_headings', '' );
			$wtfe_animated_text			= get_option( 'wtfe_animated_text', '' );
			$wtfe_button 				= get_option( 'wtfe_button', '' );
			$wtfe_call_to_action 		= get_option( 'wtfe_call_to_action', '' );
			$wtfe_circle_progress 		= get_option( 'wtfe_circle_progress', '' );
			$wtfe_content_ticker 		= get_option( 'wtfe_content_ticker', '' );
			$wtfe_countdown 			= get_option( 'wtfe_countdown', '' );
			$wtfe_darkmode			 	= get_option( 'wtfe_darkmode', '' );
			$wtfe_data_table 			= get_option( 'wtfe_data_table', '' );
			$wtfe_distorted_headings 	= get_option( 'wtfe_distorted_headings', '' );
			$wtfe_filterable_gallery 	= get_option( 'wtfe_filterable_gallery', '' );
			$wtfe_flip_box 				= get_option( 'wtfe_flip_box', '' );
			$wtfe_hotspots 				= get_option( 'wtfe_hotspots', '' );
			$wtfe_image_accordion 		= get_option( 'wtfe_image_accordion', '' );
			$wtfe_image_comparison 		= get_option( 'wtfe_image_comparison', '' );
			$wtfe_post_grid 			= get_option( 'wtfe_post_grid', '' );
			$wtfe_post_timeline 		= get_option( 'wtfe_post_timeline', '' );
			$wtfe_pricing_table 		= get_option( 'wtfe_pricing_table', '' );
			$wtfe_product_grid 			= get_option( 'wtfe_product_grid', '' );
			$wtfe_qr_code 				= get_option( 'wtfe_qr_code', '' );
			$wtfe_scroll_navigation 	= get_option( 'wtfe_scroll_navigation', '' );
			$wtfe_team_member 			= get_option( 'wtfe_team_member', '' );
			$wtfe_testimonial 			= get_option( 'wtfe_testimonial', '' );
			$wtfe_unfold 				= get_option( 'wtfe_unfold', '' );
			$wtfe_view_more 			= get_option( 'wtfe_view_more', '' );
			
			if ( $wtfe_advanced_accordion != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/advance-accordion/advance-accordion.php', $widgets_manager );
			}

			if ( $wtfe_advanced_tabs != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/advance-tabs/advance-tabs.php', $widgets_manager );
			}
			
			if ( $wtfe_advanced_headings != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/advanced-heading/advanced-heading.php', $widgets_manager );
			}

			if ( $wtfe_animated_text != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/animated-text/wpkoi-elements-animated-text.php', $widgets_manager );
			}

			if ( $wtfe_button != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/button/wpkoi-elements-button.php', $widgets_manager );
			}

			if ( $wtfe_call_to_action != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/call-to-action/call-to-action.php', $widgets_manager );
			}

			if ( $wtfe_circle_progress != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/circle-progress/wpkoi-elements-circle-progress.php', $widgets_manager );
			}

			if ( $wtfe_content_ticker != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/content-ticker/content-ticker.php', $widgets_manager );
			}

			if ( $wtfe_countdown != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/countdown/countdown.php', $widgets_manager );
			}

			if ( $wtfe_darkmode != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/darkmode/darkmode.php', $widgets_manager );
			}
			
			if ( $wtfe_data_table != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/data-table/data-table.php', $widgets_manager );
			}
			
			if ( $wtfe_distorted_headings != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/distorted-heading/distorted-heading.php', $widgets_manager );
			}

			if ( $wtfe_filterable_gallery != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/filterable-gallery/filterable-gallery.php', $widgets_manager );
			}

			if ( $wtfe_flip_box != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/flipbox/flipbox.php', $widgets_manager );
			}

			if ( $wtfe_hotspots != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/hotspots/wpkoi-hotspots-widget.php', $widgets_manager );
			}

			if ( $wtfe_image_accordion != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/image-accordion/image-accordion.php', $widgets_manager );
			}

			if ( $wtfe_image_comparison != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/image-comparison/wpkoi-elements-image-comparison.php', $widgets_manager );
			}

			if ( $wtfe_post_grid != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/post-grid/post-grid.php', $widgets_manager );
			}

			if ( $wtfe_post_timeline != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/post-timeline/post-timeline.php', $widgets_manager );
			}

			if ( $wtfe_pricing_table != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/pricing-table/pricing-table.php', $widgets_manager );
			}

			if ( $wtfe_product_grid != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/product-grid/product-grid.php', $widgets_manager );
			}
			
			if ( $wtfe_qr_code != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/qr-code/qr-code.php', $widgets_manager );
			}

			if ( $wtfe_scroll_navigation != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/scroll-navigation/wpkoi-elements-scroll-navigation.php', $widgets_manager );
			}

			if ( $wtfe_team_member != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/team-members/team-members.php', $widgets_manager );
			}

			if ( $wtfe_testimonial != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/testimonials/testimonials.php', $widgets_manager );
			}

			if ( $wtfe_unfold != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/unfold/wpkoi-unfold-widget.php', $widgets_manager );
			}

			if ( $wtfe_view_more != true ) {
				$this->register_addon(  WPKOI_ELEMENTS_PATH . 'elements/view-more/wpkoi-view-more-widget.php', $widgets_manager );
			}

		}

		/**
		 * Register vendor addons
		 */
		public function register_vendor_addons( $widgets_manager ) {
		}

		/**
		 * Add new controls.
		 */
		public function add_controls( $controls_manager ) {

			$grouped = array(
				'wpkoi-box-style' => 'WPKoi_Group_Control_Box_Style',
			);

			foreach ( $grouped as $control_id => $class_name ) {
				if ( $this->include_control( $class_name, true ) ) {
					$controls_manager->add_group_control( $control_id, new $class_name() );
				}
			}

		}

		/**
		 * Include control file by class name.
		 */
		public function include_control( $class_name, $grouped = false ) {

			$filename = sprintf(
				'includes/controls/%2$sclass-%1$s.php',
				str_replace( '_', '-', strtolower( $class_name ) ),
				( true === $grouped ? 'groups/' : '' )
			);

			if ( ! file_exists( WPKOI_ELEMENTS_PATH . '' . $filename ) ) {
				return false;
			}

			require WPKOI_ELEMENTS_PATH . '' . $filename ;

			return true;
		}

		/**
		 * Register addon by file name
		 */
		public function register_addon( $file, $widgets_manager ) {

			$base  = basename( str_replace( '.php', '', $file ) );
			$class = ucwords( str_replace( '-', ' ', $base ) );
			$class = str_replace( ' ', '_', $class );
			$class = sprintf( 'Elementor\%s', $class );

			require $file;

			if ( class_exists( $class ) ) {
				$widgets_manager->register_widget_type( new $class );
			}
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
 * Returns instance of WPKoi_Elements_Integration
 */
function wpkoi_elements_integration() {
	return WPKoi_Elements_Integration::get_instance();
}
wpkoi_elements_integration()->init();