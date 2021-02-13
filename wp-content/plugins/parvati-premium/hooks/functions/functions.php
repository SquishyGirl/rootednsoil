<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add any necessary files
require plugin_dir_path( __FILE__ ) . 'hooks.php';

if ( ! function_exists( 'parvati_hooks_get_hooks' ) ) {
	function parvati_hooks_get_hooks() {
		$hooks = array(
			'parvati_wp_head_php',
			'parvati_wp_head',
			'parvati_before_header_php',
			'parvati_before_header',
			'parvati_before_header_content_php',
			'parvati_before_header_content',
			'parvati_after_header_content_php',
			'parvati_after_header_content',
			'parvati_after_header_php',
			'parvati_after_header',
			'parvati_before_main_content_php',
			'parvati_before_main_content',
			'parvati_before_content_php',
			'parvati_before_content',
			'parvati_after_entry_header_php',
			'parvati_after_entry_header',
			'parvati_after_content_php',
			'parvati_after_content',
			'parvati_before_right_sidebar_content_php',
			'parvati_before_right_sidebar_content',
			'parvati_after_right_sidebar_content_php',
			'parvati_after_right_sidebar_content',
			'parvati_before_left_sidebar_content_php',
			'parvati_before_left_sidebar_content',
			'parvati_after_left_sidebar_content_php',
			'parvati_after_left_sidebar_content',
			'parvati_before_footer_php',
			'parvati_before_footer',
			'parvati_after_footer_widgets_php',
			'parvati_after_footer_widgets',
			'parvati_before_footer_content_php',
			'parvati_before_footer_content',
			'parvati_after_footer_content_php',
			'parvati_after_footer_content',
			'parvati_wp_footer_php',
			'parvati_wp_footer'
		);

		return $hooks;
	}
}

if ( ! function_exists( 'parvati_hooks_php_check' ) ) {
	add_action( 'admin_notices', 'parvati_hooks_php_check' );
	/**
	 * Checks if DISALLOW_FILE_EDIT is defined.
	 * If it is, tell the user to disallow PHP execution in Parvati Hooks.
	 *
	 */
	function parvati_hooks_php_check() {
		if ( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT && ! defined( 'PARVATI_HOOKS_DISALLOW_PHP' ) && current_user_can( 'manage_options' ) ) {
			printf(
				'<div class="notice notice-error">
					<p>%1$s <a href="https://wpkoi.com/docs/disallow_file_edit-is-defined/" target="_blank">%2$s</a></p>
				</div>',
				esc_html__( 'DISALLOW_FILE_EDIT is defined. You should also disallow PHP execution in Parvati Hooks.', 'parvati-premium' ),
				esc_html__( 'Learn how', 'parvati-premium' )
			);
		}
	}
}

if ( ! function_exists( 'parvati_hooks_setup' ) ) {
	function parvati_hooks_setup() {
		// Just to verify that we're activated.
	}
}

if ( ! class_exists( 'Parvati_Hooks_Settings' ) ) {
	class Parvati_Hooks_Settings {
	    private $dir;
		private $file;
		private $assets_dir;
		private $assets_url;
		private $settings_base;
		private $settings;

		public function __construct( $file ) {
			$this->file = $file;
			$this->dir = dirname( $this->file );
			$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
			$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );
			$this->settings_base = '';

			// Initialise settings
			add_action( 'admin_init', array( $this, 'init' ) );

			// Register plugin settings
			add_action( 'admin_init' , array( $this, 'register_settings' ) );

			// Add settings page to menu
			add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

			// Add settings link to plugins page
			add_filter( 'plugin_action_links_' . plugin_basename( $this->file ) , array( $this, 'add_settings_link' ) );
		}

		/**
		 * Initialise settings
		 * @return void
		 */
		public function init() {
			$this->settings = $this->settings_fields();
		}

		/**
		 * Add settings page to admin menu
		 * @return void
		 */
		public function add_menu_item() {
			$page = add_theme_page( __( 'Parvati Hooks', 'parvati-premium' ) , __( 'Parvati Hooks', 'parvati-premium' ) , apply_filters( 'parvati_hooks_capability','manage_options' ) , 'gp_hooks_settings' ,  array( $this, 'settings_page' ) );
			add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
		}

		/**
		 * Load settings JS & CSS
		 * @return void
		 */
		public function settings_assets() {
			wp_enqueue_script( 'gp-cookie', $this->assets_url . 'js/jquery.cookie.js', array( 'jquery' ), PARVATI_HOOKS_VERSION );
			wp_enqueue_script( 'gp-hooks', $this->assets_url . 'js/admin.js', array( 'jquery', 'gp-cookie' ), PARVATI_HOOKS_VERSION );
			wp_enqueue_style( 'gp-hooks', $this->assets_url . 'css/hooks.css' );
		}

		/**
		 * Add settings link to plugin list table
		 * @param  array $links Existing links
		 * @return array 		Modified links
		 */
		public function add_settings_link( $links ) {
			$settings_link = '<a href="options-general.php?page=gp_hooks_settings">' . __( 'Parvati Hooks', 'parvati-premium' ) . '</a>';
	  		array_push( $links, $settings_link );
	  		return $links;
		}

		/**
		 * Build settings fields
		 * @return array Fields to be displayed on settings page
		 */
		private function settings_fields() {

			$settings['standard'] = array(
				'title'					=> '',
				'description'			=> '',
				'fields'				=> array(
					array(
						"name" => __( 'wp_head', 'parvati-premium' ),
						"id" => 'parvati_wp_head',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'Before Header', 'parvati-premium' ),
						"id" => 'parvati_before_header',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'Before Header Content', 'parvati-premium' ),
						"id" => 'parvati_before_header_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'After Header Content', 'parvati-premium' ),
						"id" => 'parvati_after_header_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'After Header', 'parvati-premium' ),
						"id" => 'parvati_after_header',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'Inside Content Container', 'parvati-premium' ),
						"id" => 'parvati_before_main_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'Before Content', 'parvati-premium' ),
						"id" => 'parvati_before_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'After Entry Title', 'parvati-premium' ),
						"id" => 'parvati_after_entry_header',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'After Content', 'parvati-premium' ),
						"id" => 'parvati_after_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'Before Right Sidebar Content', 'parvati-premium' ),
						"id" => 'parvati_before_right_sidebar_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'After Right Sidebar Content', 'parvati-premium' ),
						"id" => 'parvati_after_right_sidebar_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'Before Left Sidebar Content', 'parvati-premium' ),
						"id" => 'parvati_before_left_sidebar_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'After Left Sidebar Content', 'parvati-premium' ),
						"id" => 'parvati_after_left_sidebar_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'Before Footer', 'parvati-premium' ),
						"id" => 'parvati_before_footer',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'After Footer Widgets', 'parvati-premium' ),
						"id" => 'parvati_after_footer_widgets',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'Before Footer Content', 'parvati-premium' ),
						"id" => 'parvati_before_footer_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'After Footer Content', 'parvati-premium' ),
						"id" => 'parvati_after_footer_content',
						"type" => 'textarea'
					),

					array(
						"name" => __( 'wp_footer', 'parvati-premium' ),
						"id" => 'parvati_wp_footer',
						"type" => 'textarea'
					)
				)
			);

			$settings = apply_filters( 'gp_hooks_settings_fields', $settings );

			return $settings;
		}

		/**
		 * Register plugin settings
		 * @return void
		 */
		public function register_settings() {
			if ( is_array( $this->settings ) ) {
				foreach( $this->settings as $section => $data ) {

					// Add section to page
					add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'gp_hooks_settings' );

					foreach( $data['fields'] as $field ) {

						// Sanitizing isn't possible, as hooks allow any HTML, JS or PHP to be added.
						// Allowing PHP can be a security issue if you have admin users who you don't trust.
						// In that case, you can disable the ability to add PHP in hooks like this: define( 'PARVATI_HOOKS_DISALLOW_PHP', true );
						$validation = '';
						if( isset( $field['callback'] ) ) {
							$validation = $field['callback'];
						}

						// Register field
						$option_name = $this->settings_base . $field['id'];
						register_setting( 'gp_hooks_settings', 'parvati_hooks', $validation );

						// Add field to page
						add_settings_field( 'parvati_hooks[' . $field['id'] . ']', $field['name'], array( $this, 'display_field' ), 'gp_hooks_settings', $section, array( 'field' => $field ) );
					}
				}
			}
		}

		public function settings_section( $section ) {
			$html = '';
			echo $html;
		}

		/**
		 * Generate HTML for displaying fields
		 * @param  array $args Field data
		 * @return void
		 */
		public function display_field( $args ) {

			$field = $args['field'];

			$html = '';

			$option_name = $this->settings_base . $field['id'];
			$option = get_option( 'parvati_hooks' );

			$data = '';
			if( isset( $option[$option_name] ) ) {
				$data = $option[$option_name];
			} elseif( isset( $field['default'] ) ) {
				$data = $field['default'];
			}


			switch( $field['type'] ) {

				case 'textarea':
					$checked = '';
					$checked2 = '';
					if( isset( $option[$field['id'] . '_php'] ) && 'true' == $option[$field['id'] . '_php'] ){
						$checked = 'checked="checked"';
					}
					if( isset( $option[$field['id'] . '_disable'] ) && 'true' == $option[$field['id'] . '_disable'] ){
						$checked2 = 'checked="checked"';
					}
					$html .= '<textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" id="parvati_hooks[' . esc_attr( $field['id'] ) . ']" name="parvati_hooks[' . esc_attr( $field['id'] ) . ']" style="width:100%;height:200px;" cols="" rows="">' . esc_textarea( $data ) . '</textarea>';

					if ( ! defined( 'PARVATI_HOOKS_DISALLOW_PHP' ) ) {
						$html .= '<div class="execute"><input type="checkbox" name="parvati_hooks[' . esc_attr( $field['id'] ) . '_php]" id="parvati_hooks[' . esc_attr( $field['id'] ) . '_php]" value="true" ' . $checked . ' /> <label for="parvati_hooks[' . esc_attr( $field['id'] ) . '_php]">' . __( 'Execute PHP', 'parvati-premium' ) . '</label></div>';
					}
					$html .= '<div class="disable"><input type="checkbox" name="parvati_hooks[' . esc_attr( $field['id'] ) . '_disable]" id="parvati_hooks[' . esc_attr( $field['id'] ) . '_disable]" value="true" ' . $checked2 . ' /> <label for="parvati_hooks[' . esc_attr( $field['id'] ) . '_disable]" class="disable">' . __( 'Disable Hook', 'parvati-premium' ) . '</label></div>';
				break;

				case 'checkbox':


				break;

			}

			echo $html;
		}

		/**
		 * Validate individual settings field
		 * @param  string $data Inputted value
		 * @return string       Validated value
		 */
		public function validate_field( $data ) {
			if ( $data && strlen( $data ) > 0 && $data != '' ) {
				$data = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
			}
			return $data;
		}

		/**
		 * Load settings page content
		 * @return void
		 */
		public function settings_page() {

			// Build page HTML
			$html = '<div class="wrap" id="gp_hooks_settings">';
				$html .= '<div id="poststuff">';
				$html .= '<div class="metabox-holder columns-2" id="post-body">';
				$html .= '<form method="post" action="options.php" enctype="multipart/form-data">';
					$html .= '<div id="post-body-content">';
						// Get settings fields
						ob_start();
							settings_fields( 'gp_hooks_settings' );
							do_settings_sections( 'gp_hooks_settings' );
						$html .= ob_get_clean();
					$html .= '</div>';

					$html .= '<div id="postbox-container-1">';
						$html .= '<div class="postbox sticky-scroll-box">';
							$html .= '<h3 class="hndle">' . __( 'Parvati Hooks', 'parvati-premium' ) . '</h3>';
							$html .= '<div class="inside">';
								$html .= '<p>' . __( 'Use these fields to insert anything you like throughout Parvati. Shortcodes are allowed, and you can even use PHP if you check the Execute PHP checkboxes.', 'parvati-premium' ) . '</p>';
								$html .= '<select id="hook-dropdown" style="margin-top:20px;">';
									$html .= '<option value="all">' . __( 'Show all', 'parvati-premium' ) . '</option>';
									if( is_array( $this->settings ) ) {
										foreach( $this->settings as $section => $data ) {
											$count = 0;
											foreach( $data['fields'] as $field ) {
												$html .= '<option id="' . $count++ . '">' . $field['name'] . '</option>';
											}
										}
									}
								$html .= '</select>';
								$html .= '<p style="padding:0;margin:13px 0 0 0;" class="submit">';
									$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Hooks' , 'parvati-premium' ) ) . '" />';
								$html .= '</p>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</form>';
				$html .= '</div>';
				$html .= '<br class="clear" />';
			$html .= '</div>';
			$html .= '</div>';

			echo $html;
		}

	}
	$settings = new Parvati_Hooks_Settings( __FILE__ );
}

if ( ! function_exists( 'parvati_update_hooks' ) ) {
	add_action( 'admin_init', 'parvati_update_hooks' );
	/**
	 * Moving standalone db entries to parvati_hooks db entry
	 */
	function parvati_update_hooks() {
		$parvati_hooks = get_option( 'parvati_hooks' );

		// If we've done this before, bail
		if ( ! empty( $parvati_hooks ) ) {
			return;
		}

		// One last check
		if ( 'true' == $parvati_hooks['updated'] ) {
			return;
		}

		$hooks = parvati_hooks_get_hooks();
		$parvati_new_hooks = array();

		foreach ( $hooks as $hook ) {

			$current_hook = get_option( $hook );

			if ( isset( $current_hook ) && '' !== $current_hook ) {

				$parvati_new_hooks[ $hook ] = get_option( $hook );
				$parvati_new_hooks[ 'updated' ] = 'true';
				// Let's not delete the old options yet, just in case
				//delete_option( $hook );

			}

		}

		$parvati_new_hook_settings = wp_parse_args( $parvati_new_hooks, $parvati_hooks );
		update_option( 'parvati_hooks', $parvati_new_hook_settings );

	}
}

if ( ! function_exists( 'parvati_hooks_admin_errors' ) ) {
	add_action( 'admin_notices', 'parvati_hooks_admin_errors' );
	/**
	 * Add our admin notices
	 */
	function parvati_hooks_admin_errors() {
		$screen = get_current_screen();
		if ( 'appearance_page_gp_hooks_settings' !== $screen->base ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
			 add_settings_error( 'parvati-hook-notices', 'true', __( 'Hooks saved.', 'parvati-premium' ), 'updated' );
		}

		settings_errors( 'parvati-hook-notices' );
	}
}
