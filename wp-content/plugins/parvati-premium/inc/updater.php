<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin info
add_filter('plugins_api', 'parvati_premium_plugin_info', 20, 3);
function parvati_premium_plugin_info( $res, $action, $args ){
 	
	if ( version_compare( phpversion(), '5.4.0', '>' ) ) {
 
		// do nothing if this is not about getting plugin information
		if( $action !== 'plugin_information' )
			return false;
	 
		// do nothing if it is not our plugin	
		if( 'parvati-premium' !== $args->slug )
			return $res;
	 
		// trying to get from cache first, to disable cache comment 18,28,29,30,32
		if( false == $remote = get_transient( 'parvati_premium_upgrade_plugin_parvati_premium' ) ) {
	 
			// Check lincense
			$licenselink = 'https://wpkoi.com/updatecheck/update-info-parvati-rg55p.json';
			
			// info.json is the file with the actual plugin information on your server
			$remote = wp_remote_get( $licenselink , array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				)
			));
			
			if ( is_wp_error( $remote ) ) {
				return;
			}
	 
			if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
				set_transient( 'parvati_premium_upgrade_plugin_parvati_premium', $remote, 43200 ); 
			}
	 
		}
	 
		if( !is_wp_error( $remote ) ) {
	 
			$remote = json_decode( $remote['body'] );
			$res = new stdClass();
			$res->name = 'Parvati Premium';
			$res->slug = 'parvati-premium';
			$res->version = $remote->version;
			$res->tested = $remote->tested;
			$res->requires = $remote->requires;
			$res->author = '<a href="https://wpkoi.com/">WPKoi</a>'; // I decided to write it directly in the plugin
			$res->download_link = $remote->download_url;
			$res->trunk = $remote->download_url;
			//$res->last_updated = $remote->last_updated;
			$res->sections = array(
				'description'  => $remote->sections->description, // description tab
				'changelog'    => $remote->sections->changelog,
			);
				return $res;
	 
		}
	 
		return false;
	} else {
		return false;
	}
}

add_filter('site_transient_update_plugins', 'parvati_premium_push_update' );
 
function parvati_premium_push_update( $transient ){
 	
	if ( version_compare( phpversion(), '5.4.0', '>' ) ) {
 
		if ( empty($transient->checked ) ) {
				return $transient;
			}
	 
		if( false == $remote = get_transient( 'parvati_premium_upgrade_plugin_parvati_premium' ) ) {
	 
			// Check lincense
			$licenselink = 'https://wpkoi.com/updatecheck/update-info-parvati-rg55p.json';
			
			// info.json is the file with the actual plugin information on your server
			$remote = wp_remote_get( $licenselink , array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				)
			));
			
			if ( is_wp_error( $remote ) ) {
				return;
			}
	 
			if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
				set_transient( 'parvati_premium_upgrade_plugin_parvati_premium', $remote, 43200 ); 
			}
	 
		}
	 
		if( !is_wp_error( $remote ) ) {
			if( isset( $remote['body'] ) ) {
				$remote = json_decode( $remote['body'] );
		 
				// your installed plugin version should be on the line below! You can obtain it dynamically of course 
				if( $remote && version_compare( PARVATI_PREMIUM_VERSION, $remote->version, '<' ) && version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
					$res = new stdClass();
					$res->slug = 'parvati-premium';
					$res->plugin = 'parvati-premium/parvati-premium.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
					$res->new_version = $remote->version;
					$res->tested = $remote->tested;
					$res->package = $remote->download_url;
					$res->url = $remote->homepage;
						$transient->response[$res->plugin] = $res;
						//$transient->checked[$res->plugin] = $remote->version;
					}
			}
		}
			return $transient;
	}
}

add_action( 'upgrader_process_complete', 'parvati_premium_after_update', 10, 2 );

function parvati_premium_after_update( $upgrader_object, $options ) {
	if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
		// just clean the cache when new plugin version is installed
		delete_transient( 'parvati_premium_upgrade_plugin_parvati_premium' );
	}
}

add_action( 'in_plugin_update_message-parvati-premium/parvati-premium.php', 'parvati_premium_update_message', 10, 2 );
function parvati_premium_update_message( $plugin_info_array, $plugin_info_object ) {
	if( empty( $plugin_info_array['package'] ) ) {
		echo ' Please <a href="themes.php?page=parvati-options">add Your license</a> on the theme page for the updates.';
	}
}