<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_enqueue_scripts', 'parvati_premium_dashboard_scripts' );
/**
 * Enqueue scripts and styles for the Parvati Dashboard area.
 *
 */
function parvati_premium_dashboard_scripts() {
	$screen = get_current_screen();

	if ( 'appearance_page_parvati-options' !== $screen->base ) {
		return;
	}

	wp_enqueue_style( 'parvati-premium-dashboard', plugin_dir_url( __FILE__ ) . 'assets/dashboard.css', array(), PARVATI_PREMIUM_VERSION );
	wp_enqueue_script( 'parvati-premium-dashboard', plugin_dir_url( __FILE__ ) . 'assets/dashboard.js', array( 'jquery' ), PARVATI_PREMIUM_VERSION, true );
}

if ( ! function_exists( 'parvati_premium_notices' ) ) {
	add_action( 'admin_notices', 'parvati_premium_notices' );
	/*
	* Set up errors and messages
	*/
	function parvati_premium_notices() {
		if ( isset( $_GET['parvati-message'] ) && 'addon_deactivated' == $_GET['parvati-message'] ) {
			 add_settings_error( 'parvati-premium-notices', 'addon_deactivated', __( 'Module deactivated.', 'parvati-premium' ), 'updated' );
		}

		if ( isset( $_GET['parvati-message'] ) && 'addon_activated' == $_GET['parvati-message'] ) {
			 add_settings_error( 'parvati-premium-notices', 'addon_activated', __( 'Module activated.', 'parvati-premium' ), 'updated' );
		}

		settings_errors( 'parvati-premium-notices' );
	}
}

if ( ! function_exists( 'parvati_super_package_addons' ) ) {
	add_action( 'parvati_inside_options_form', 'parvati_super_package_addons', 5 );
	/**
	 * Build the area that allows us to activate and deactivate modules.
	 *
	 */
	function parvati_super_package_addons() {
		$addons = array(
			'Backgrounds' => 'parvati_package_backgrounds',
			'Blog' => 'parvati_package_blog',
			'Colors' => 'parvati_package_colors',
			'Copyright' => 'parvati_package_copyright',
			'Disable Elements' => 'parvati_package_disable_elements',
			'Demo Import' => 'parvati_package_demo_import',
			'Hooks' => 'parvati_package_hooks',
			'Menu Plus' => 'parvati_package_menu_plus',
			'Page Header' => 'parvati_package_page_header',
			'Fixed Side Content' => 'parvati_package_fixed_side_content',
			'Secondary Nav' => 'parvati_package_secondary_nav',
			'Spacing' => 'parvati_package_spacing',
			'Typography' => 'parvati_package_typography',
			'Events' => 'wpkoi_package_events',
			'Widgets' => 'wpkoi_package_widgets',
			'WooCommerce' => 'parvati_package_woocommerce',
			'Elementor Addon' => 'parvati_package_elementor_addon',
			'Updater' => 'parvati_package_updater',
		);

		$addon_count = 0;
		foreach ( $addons as $k => $v ) {
			if ( 'activated' == get_option( $v ) )
				$addon_count++;
		}

		$version = ( defined( 'PARVATI_PREMIUM_VERSION' ) ) ? PARVATI_PREMIUM_VERSION  : '';

		?>
		<div class="postbox parvati-metabox parvati-admin-block" id="modules">
			<h3 class="hndle"><?php _e('Parvati Premium','parvati-premium'); ?> <?php echo $version; ?></h3>
            <h4 class="parvati-instruct"><?php esc_html_e( 'Turn on all the features that You need!', 'parvati-premium' ); ?></h4>
			<div class="inside" style="margin:0;padding:0;">
				<div class="premium-addons">
					<form method="post">
						<div class="add-on gp-clear addon-container grid-parent" style="background:#EFEFEF;border-left:5px solid #DDD;padding-left:10px !important;">
							<div class="addon-name column-addon-name">
								<input type="checkbox" id="parvati-select-all" />
								<select name="parvati_mass_activate" class="mass-activate-select">
									<option value=""><?php _e( 'Bulk Actions', 'parvati-premium' ) ;?></option>
									<option value="activate-selected"><?php _e( 'Activate','parvati-premium' ) ;?></option>
									<option value="deactivate-selected"><?php _e( 'Deactivate','parvati-premium' ) ;?></option>
								</select>
								<?php wp_nonce_field( 'parvati_premium_bulk_action_nonce', 'parvati_premium_bulk_action_nonce' ); ?>
								<input type="submit" name="parvati_multi_activate" class="button mass-activate-button" value="<?php _e( 'Apply','parvati-premium' ); ?>" />
							</div>
						</div>
						<?php

						foreach ( $addons as $k => $v ) :

							$key = get_option( $v );

							if( $key == 'activated' ) { ?>
								<div class="add-on activated gp-clear addon-container grid-parent">
									<div class="addon-name column-addon-name" style="">
										<input type="checkbox" class="addon-checkbox" name="parvati_addon_checkbox[]" value="<?php echo $v; ?>" />
										<?php echo $k;?>
									</div>
									<div class="addon-action addon-addon-action" style="text-align:right;">
										<?php wp_nonce_field( $v . '_deactivate_nonce', $v . '_deactivate_nonce' ); ?>
										<input type="submit" name="<?php echo $v;?>_deactivate_package" value="<?php _e( 'Deactivate','parvati-premium' );?>"/>
									</div>
								</div>
							<?php } else { ?>
								<div class="add-on gp-clear addon-container grid-parent">

									<div class="addon-name column-addon-name">
										<input <?php if ( 'WooCommerce' == $k && ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) { echo 'disabled'; } ?> type="checkbox" class="addon-checkbox" name="parvati_addon_checkbox[]" value="<?php echo $v; ?>" />
										<?php echo $k;?>
									</div>

									<div class="addon-action addon-addon-action" style="text-align:right;">
										<?php if ( 'WooCommerce' == $k && ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) { ?>
											<?php _e( 'WooCommerce not activated.','parvati-premium' ); ?>
										<?php } else { ?>
											<?php wp_nonce_field( $v . '_activate_nonce', $v . '_activate_nonce' ); ?>
											<input type="submit" name="<?php echo $v;?>_activate_package" value="<?php _e( 'Activate','parvati-premium' );?>"/>
										<?php } ?>
									</div>

								</div>
							<?php }
							echo '<div class="gp-clear"></div>';
						endforeach;
						?>
					</form>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'parvati_multi_activate' ) ) {
	add_action( 'admin_init', 'parvati_multi_activate' );

	function parvati_multi_activate() {
		// Deactivate selected
		if ( isset( $_POST['parvati_multi_activate'] ) ) {

			// If we didn't click the button, bail.
			if ( ! check_admin_referer( 'parvati_premium_bulk_action_nonce', 'parvati_premium_bulk_action_nonce' ) ) {
				return;
			}

			// If we're not an administrator, bail.
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$name = ( isset( $_POST['parvati_addon_checkbox'] ) ) ? $_POST['parvati_addon_checkbox'] : '';
			$option = ( isset( $_POST['parvati_addon_checkbox'] ) ) ? $_POST['parvati_mass_activate'] : '';

			if ( isset( $_POST['parvati_addon_checkbox'] ) ) {

				if ( 'deactivate-selected' == $option ) {
					foreach ( $name as $id ) {
						if ( 'activated' == get_option( $id ) ) {
							update_option( $id, '' );
						}
					}
				}

				if ( 'activate-selected' == $option ) {
					foreach ( $name as $id ) {
						if ( 'activated' !== get_option( $id ) ) {
							update_option( $id, 'activated' );
						}
					}
				}

				wp_safe_redirect( admin_url( 'themes.php?page=parvati-options' ) );
				exit;
			} else {
				wp_safe_redirect( admin_url( 'themes.php?page=parvati-options' ) );
				exit;
			}
		}
	}
}

/***********************************************
* Activate the add-on
***********************************************/
if ( ! function_exists( 'parvati_activate_super_package_addons' ) ) {
	add_action( 'admin_init', 'parvati_activate_super_package_addons' );

	function parvati_activate_super_package_addons() {
		$addons = array(
			'Typography' => 'parvati_package_typography',
			'Colors' => 'parvati_package_colors',
			'Copyright' => 'parvati_package_copyright',
			'Backgrounds' => 'parvati_package_backgrounds',
			'Page Header' => 'parvati_package_page_header',
			'Disable Elements' => 'parvati_package_disable_elements',
			'Demo Import' => 'parvati_package_demo_import',
			'Blog' => 'parvati_package_blog',
			'Hooks' => 'parvati_package_hooks',
			'Spacing' => 'parvati_package_spacing',
			'Fixed Side Content' => 'parvati_package_fixed_side_content',
			'Secondary Nav' => 'parvati_package_secondary_nav',
			'Menu Plus' => 'parvati_package_menu_plus',
			'Events' => 'wpkoi_package_events',
			'Widgets' => 'wpkoi_package_widgets',
			'WooCommerce' => 'parvati_package_woocommerce',
			'Elementor Addon' => 'parvati_package_elementor_addon',
			'Updater' => 'parvati_package_updater',
		);

		foreach( $addons as $k => $v ) :

			if ( isset( $_POST[$v . '_activate_package'] ) ) {

				// If we didn't click the button, bail.
				if ( ! check_admin_referer( $v . '_activate_nonce', $v . '_activate_nonce' ) ) {
					return;
				}

				// If we're not an administrator, bail.
				if ( ! current_user_can( 'manage_options' ) ) {
					return;
				}

				update_option( $v, 'activated' );
				wp_safe_redirect( admin_url( 'themes.php?page=parvati-options&parvati-message=addon_activated' ) );
				exit;
			}

		endforeach;
	}
}

/***********************************************
* Deactivate the plugin
***********************************************/
if ( ! function_exists( 'parvati_deactivate_super_package_addons' ) ) {
	add_action( 'admin_init', 'parvati_deactivate_super_package_addons' );

	function parvati_deactivate_super_package_addons() {
		$addons = array(
			'Typography' => 'parvati_package_typography',
			'Colors' => 'parvati_package_colors',
			'Copyright' => 'parvati_package_copyright',
			'Backgrounds' => 'parvati_package_backgrounds',
			'Page Header' => 'parvati_package_page_header',
			'Disable Elements' => 'parvati_package_disable_elements',
			'Demo Import' => 'parvati_package_demo_import',
			'Blog' => 'parvati_package_blog',
			'Hooks' => 'parvati_package_hooks',
			'Spacing' => 'parvati_package_spacing',
			'Fixed Side Content' => 'parvati_package_fixed_side_content',
			'Secondary Nav' => 'parvati_package_secondary_nav',
			'Menu Plus' => 'parvati_package_menu_plus',
			'Events' => 'wpkoi_package_events',
			'Widgets' => 'wpkoi_package_widgets',
			'WooCommerce' => 'parvati_package_woocommerce',
			'Elementor Addon' => 'parvati_package_elementor_addon',
			'Updater' => 'parvati_package_updater',
		);

		foreach( $addons as $k => $v ) :

			if ( isset( $_POST[$v . '_deactivate_package'] ) ) {

				// If we didn't click the button, bail.
				if ( ! check_admin_referer( $v . '_deactivate_nonce', $v . '_deactivate_nonce' ) ) {
					return;
				}

				// If we're not an administrator, bail.
				if ( ! current_user_can( 'manage_options' ) ) {
					return;
				}

				update_option( $v, 'deactivated' );
				wp_safe_redirect( admin_url('themes.php?page=parvati-options&parvati-message=addon_deactivated' ) );
				exit;
			}

		endforeach;
	}
}

if ( ! function_exists( 'parvati_premium_body_class' ) ) {
	add_filter( 'admin_body_class', 'parvati_premium_body_class' );
	/**
	 * Add a class or many to the body in the dashboard
	 */
	function parvati_premium_body_class( $classes ) {
	    return "$classes parvati_premium";
	}
}


if ( ! function_exists( 'parvati_premium_activation_area' ) ) {
	add_action( 'parvati_admin_right_panel', 'parvati_premium_activation_area' );

	function parvati_premium_activation_area() {
		if ( version_compare( phpversion(), '5.5.0', '>' ) ) {
			
			$license        = get_option( 'parvati_premium_option_license_key', '' );
			$key            = get_option( 'parvati_premium_option_license_key_status', 'deactivated' );
			$sku		    = get_option( 'parvati_premium_option_license_key_sku', '' );
			$sku_type	    = get_option( 'parvati_premium_option_license_key_sku_type', '' );
			$valid_until    = get_option( 'parvati_premium_option_license_key_valid_until', '' );
			$activation_id  = get_option( 'parvati_premium_option_license_key_activation_id', '' );
	
			if ( 'valid' == $key ) {
				$message = sprintf( '<span class="license-key-message receiving-updates">%s</span>', __( 'Receiving updates', 'parvati-premium' ) );
			} else {
				$message = sprintf( '<span class="license-key-message not-receiving-updates">%s</span>', __( 'Not receiving updates', 'parvati-premium' ) );
			}
			?>
			<form method="post" action="options.php">
				<div class="postbox parvati-metabox" id="parvati-premium-license-keys">
					<h3 class="hndle">
						<?php _e( 'Updates', 'parvati-premium' );?>
						<span class="license-key-info">
							<?php echo $message; ?>
							<a title="<?php esc_attr_e( 'Help', 'parvati-premium' ); ?>" href="<?php echo PARVATI_THEME_URL; ?>" target="_blank" rel="noopener">[?]</a>
						</span>
					</h3>
	
					<div class="inside" style="margin-bottom:0;">
						<div class="license-key-container" style="position:relative;">
							<?php if ($key == 'valid') { ?>
							<h3><?php _e( 'Your license is activated!', 'parvati-premium' );?></h3>
							<p><?php _e( 'License code: ', 'parvati-premium' ); echo $license; ?></p>
							<p><?php _e( 'Valid until: ', 'parvati-premium' ); echo esc_html($valid_until); ?></p>
							<p><?php _e( 'License Type: ', 'parvati-premium' ); echo esc_html($sku_type); ?></p>
							<input type="submit" class="button button-primary" name="parvati_premium_deactivate_license_key" value="<?php _e( 'Deactivate', 'parvati-premium' );?>" />
							<?php } else { ?>
							<p>
								<select id="parvati_license_key_type_select" name="parvati_license_key_type_select" class="license-key-select">
									<option value=""><?php _e( 'Select Your license type', 'parvati-premium' ) ;?></option>
									<option value="parvati"><?php _e( 'Parvati 1 Year','parvati-premium' ) ;?></option>
									<option value="parvati-l"><?php _e( 'Parvati Lifetime','parvati-premium' ) ;?></option>
									<option value="sitelicense"><?php _e( 'Site License','parvati-premium' ) ;?></option>
									<option value="sitelicense-l"><?php _e( 'Site License Lifetime','parvati-premium' ) ;?></option>
								</select>
									
								<input spellcheck="false" class="license-key-input" id="parvati_license_key_parvati_premium" name="parvati_license_key_parvati_premium" value="<?php echo $license; ?>" placeholder="<?php _e( 'License Key', 'parvati-premium' ); ?>" />
							</p>
	
							<?php wp_nonce_field( 'parvati_license_key_parvati_premium_nonce', 'parvati_license_key_parvati_premium_nonce' ); ?>
							<input type="submit" class="button button-primary" name="parvati_premium_license_key" value="<?php _e( 'Save', 'parvati-premium' );?>" />
							<?php } ?>
						</div>
					</div>
				</div>
			</form>
		<?php
		} else { ?>
        	<div class="postbox parvati-metabox" id="parvati-premium-license-keys">
                <h3 class="hndle">
                    <?php _e( 'Updates', 'parvati-premium' );?>
                    <span class="license-key-info">
                        <a title="<?php esc_attr_e( 'Help', 'parvati-premium' ); ?>" href="<?php echo PARVATI_THEME_URL; ?>" target="_blank" rel="noopener">[?]</a>
                    </span>
                </h3>
                <h3 class="hndle parvati-instruct"><?php _e( 'The Updater requires PHP 5.5.0+ to run properly.', 'parvati-premium' );?></h3>
            </div>
		<?php
		}
	}
}

add_action( 'admin_init', 'parvati_premium_process_license_key', 5 );
/**
 * Process our saved license key.
 *
 * @since 1.6
 */
function parvati_premium_process_license_key() {
	// Has our button been clicked?
	if ( ( isset( $_POST[ 'parvati_premium_license_key' ] ) ) && ( version_compare( phpversion(), '5.5.0', '>' ) ) ) {

		// Get out if we didn't click the button
		if ( ! check_admin_referer( 'parvati_license_key_parvati_premium_nonce', 'parvati_license_key_parvati_premium_nonce' ) ) {
			return;
		}

		// If we're not an administrator, bail.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Grab the value being saved
		$new 		 = $_POST['parvati_license_key_parvati_premium'];
		$licensetype = $_POST['parvati_license_key_type_select'];

		// Get the previously saved value
		$old    = get_option( 'parvati_premium_option_license_key' );
		$status = get_option( 'parvati_premium_option_license_key_status' );

		// Still here? Update our option with the new license key
		update_option( 'parvati_premium_option_license_key', $new );

		// If we have a value, run activation.
		if ( $status != 'valid' ) {
			$activatelink = 'https://wpkoi.com/wp-admin/admin-ajax.php?action=license_key_activate&store_code=9R6Ag5bKcPqEP9t&sku=' . esc_attr($licensetype) . '&license_key=' . esc_attr($new) . '&domain='. home_url();
			$license_response = wp_remote_get( $activatelink, array(
				'timeout'   => 20,
				'headers' => array(
					'Accept' => 'application/json'
				) 
			) );
			
			if ( is_wp_error( $license_response ) || 200 !== wp_remote_retrieve_response_code( $license_response ) ) {
				$message = $license_response->get_error_message();
			} else {
	
				// Still here? Decode our response.
				$license_data = json_decode( $license_response['body'] );
	
				if ( true === $license_data->error ) {
					
					switch ( $license_data->error ) {

						case 'license_key' :
		
							$message = __( 'Invalid license key.', 'parvati-premium'  );
							break;
		
						case 'activation_id' :
		
							$message = __( 'Invalid activation.', 'parvati-premium' );
							break;
		
						default :
		
						$message = __( 'An error occurred, please try again.', 'parvati-premium' );
						break;
						
					}
					
				} elseif ( false === $license_data->error ) {
					$licensename = '';
					$licensevalidtime = '';
					if ( $licensetype == 'parvati' ) { $licensename = __( 'Parvati-Premium 1 Year', 'parvati-premium' ); $licensevalidtime = $license_data->data->expire_date;
					} elseif ( $licensetype == 'parvati-l' ) { $licensename = __( 'Parvati-Premium Lifetime', 'parvati-premium' );  $licensevalidtime = __( 'Forever', 'parvati-premium' );
					} elseif ( $licensetype == 'sitelicense' ) { $licensename = __( 'Site License 1 Year', 'parvati-premium' ); $licensevalidtime = $license_data->data->expire_date;
					} elseif ( $licensetype == 'sitelicense-l' ) { $licensename = __( 'Site License Lifetime', 'parvati-premium' ); $licensevalidtime = __( 'Forever', 'parvati-premium' );
					}
					update_option( 'parvati_premium_option_license_key_status', 'valid' );
					update_option( 'parvati_premium_option_license_key_sku', $licensetype );
					update_option( 'parvati_premium_option_license_key_sku_type', $licensename );
					update_option( 'parvati_premium_option_license_key_valid_until', $licensevalidtime );
					update_option( 'parvati_premium_option_license_key_activation_id', $license_data->data->activation_id );
					delete_transient( 'parvati_premium_upgrade_plugin_parvati_premium' );
					wp_safe_redirect( admin_url( 'themes.php?page=parvati-options&parvati-message=license_activated' ) );
				}
			}
		}
		
		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'themes.php?page=parvati-options' );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), esc_url( $base_url ) );
			wp_redirect( $redirect );
			exit();
		}
	}
	
	if ( ( isset( $_POST[ 'parvati_premium_deactivate_license_key' ] ) ) && ( version_compare( phpversion(), '5.5.0', '>' ) ) ) {
		$license        = get_option( 'parvati_premium_option_license_key', '' );
		$key            = get_option( 'parvati_premium_option_license_key_status', 'deactivated' );
		$valid_until    = get_option( 'parvati_premium_option_license_key_valid_until', '' );
		$activation_id  = get_option( 'parvati_premium_option_license_key_activation_id', '' );
		$sku		    = get_option( 'parvati_premium_option_license_key_valid_sku', '' );
		
		$deactivatelink = 'https://wpkoi.com/wp-admin/admin-ajax.php?action=license_key_deactivate&store_code=9R6Ag5bKcPqEP9t&sku=' . esc_attr($sku) . '&license_key=' . esc_attr($license) . '&domain='. home_url().'&activation_id=' . esc_attr($activation_id);
		$license_response = wp_remote_get( $deactivatelink, array(
			'timeout'   => 20,
			'headers' => array(
				'Accept' => 'application/json'
			) 
		) );
		update_option( 'parvati_premium_option_license_key', '' );
		update_option( 'parvati_premium_option_license_key_status', 'deactivated' );
		update_option( 'parvati_premium_option_license_key_valid_until', '' );
		update_option( 'parvati_premium_option_license_key_activation_id', '' );
		update_option( 'parvati_premium_option_license_key_valid_sku', '' );
		update_option( 'parvati_premium_option_license_key_valid_sku_type', '' );
		wp_safe_redirect( admin_url( 'themes.php?page=parvati-options&parvati-message=deactivation_passed' ) );
	}
}

if ( ! function_exists( 'parvati_premium_license_errors' ) ) {
	add_action( 'admin_notices', 'parvati_premium_license_errors' );
	/*
	* Set up errors and messages
	*/
	function parvati_premium_license_errors() {
		if ( isset( $_GET['parvati-message'] ) && 'deactivation_passed' == $_GET['parvati-message'] ) {
			add_settings_error( 'parvati-license-notices', 'deactivation_passed', __( 'License deactivated.', 'parvati-premium' ), 'updated' );
		}

		if ( isset( $_GET['parvati-message'] ) && 'license_activated' == $_GET['parvati-message'] ) {
			add_settings_error( 'parvati-license-notices', 'license_activated', __( 'License activated.', 'parvati-premium' ), 'updated' );
		}

		if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {

			switch ( $_GET['sl_activation'] ) {

				case 'false':
					$message = urldecode( $_GET['message'] );
					add_settings_error( 'parvati-license-notices', 'license_failed', $message, 'error' );
				break;

				case 'true':
				default:
				break;

			}
		}

		settings_errors( 'parvati-license-notices' );
	}
}