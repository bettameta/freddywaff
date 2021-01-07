<?php
/*
Plugin Name: GPP Theme Updates
Description: Backs up and then updates your Graph Paper Press themes automatically
Plugin URI: http://graphpaperpress.com/plugins/gpp-theme-updates/
Version: 1.0.2
License: GPL
Author: Graph Paper Press
Author URI: http://graphpaperpress.com
*/

/**
 * Set plugin constants
 */
$apikey = get_option( "gpp_autoupdate_apikey" );
if( isset( $_POST['keysubmit'] ) ) {
	$apikey = $_POST['apikey'];
	update_option( "gpp_autoupdate_apikey", $apikey );
}

// Retrieve active theme data. Used in constants below.
$theme_data = get_theme_data(get_stylesheet_directory().'/style.css');

define ( 'GPP_THEME_UPDATES_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname( plugin_basename( __FILE__ ) ) . '/' );
define ( 'GPP_THEME_UPDATES_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/' );
define ( 'GPP_THEME_UPDATES_KEY', $apikey );
define ( 'GPP_THEME_UPDATES_ENDPOINT', 'http://downloads.graphpaperpress.com/api/' );
define ( 'GPP_THEME_UPDATES_ACTIVE_THEME_VERSION', $theme_data['Version'] );
define ( 'GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME', strtolower(str_replace(" ","-",$theme_data['Name'])) );
define ( 'GPP_THEME_UPDATES_ACTIVE_THEME_PARENT', $theme_data['Template'] );


/**
 * Include main plugin files
 */
 
require_once( 'gpp-theme-updates-page.php' );
require_once( 'plugin-updates/plugin-update-checker.php' );


/**
 * Include css to style the custom meta boxes, this should be a global
 * stylesheet used by all similar meta boxes
 */
add_action( 'init', 'load_gpp_theme_update_css' );
function  load_gpp_theme_update_css() {
	global $pagenow;
	if ( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == "gpp-theme-updates" || is_admin() && $pagenow == "update-core.php" ) {
		wp_enqueue_style( 'gpp_theme_updates', GPP_THEME_UPDATES_PLUGIN_URL . 'gpp-theme-updates.css' );
	}
}

/**
 * Lets update this plugin from our own downloads server.
 */
$ExampleUpdateChecker = new PluginUpdateChecker(
	'http://downloads.graphpaperpress.com/gpp-theme-updates-plugin/info.json', 
	__FILE__
);