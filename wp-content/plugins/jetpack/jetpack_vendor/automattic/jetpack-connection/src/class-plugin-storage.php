<?php
/**
 * Storage for plugin connection information.
 *
 * @package automattic/jetpack-connection
 */

namespace Automattic\Jetpack\Connection;

use Jetpack_Options;
use WP_Error;

/**
 * The class serves a single purpose - to store the data which plugins use the connection, along with some auxiliary information.
 */
class Plugin_Storage {

	const ACTIVE_PLUGINS_OPTION_NAME = 'jetpack_connection_active_plugins';

	/**
	 * Options where disabled plugins were stored
	 *
	 * @deprecated since 1.39.0.
	 * @var string
	 */
	const PLUGINS_DISABLED_OPTION_NAME = 'jetpack_connection_disabled_plugins';

	/**
	 * Transient name used as flag to indicate that the active connected plugins list needs refreshing.
	 */
	const ACTIVE_PLUGINS_REFRESH_FLAG = 'jetpack_connection_active_plugins_refresh';

	/**
	 * Whether this class was configured for the first time or not.
	 *
	 * @var boolean
	 */
	private static $configured = false;

	/**
	 * Connected plugins.
	 *
	 * @var array
	 */
	private static $plugins = array();

	/**
	 * The blog ID the storage is setup for.
	 * The data will be refreshed if the blog ID changes.
	 * Used for the multisite networks.
	 *
	 * @var int
	 */
	private static $current_blog_id = null;

	/**
	 * Add or update the plugin information in the storage.
	 *
	 * @param string $slug Plugin slug.
	 * @param array  $args Plugin arguments, optional.
	 *
	 * @return bool
	 */
	public static function upsert( $slug, array $args = array() ) {
		self::$plugins[ $slug ] = $args;

		return true;
	}

	/**
	 * Retrieve the plugin information by slug.
	 * WARNING: the method cannot be called until Plugin_Storage::configure is called, which happens on plugins_loaded
	 * Even if you don't use Jetpack Config, it may be introduced later by other plugins,
	 * so please make sure not to run the method too early in the code.
	 *
	 * @param string $slug The plugin slug.
	 *
	 * @return array|null|WP_Error
	 */
	public static function get_one( $slug ) {
		$plugins = self::get_all();

		if ( $plugins instanceof WP_Error ) {
			return $plugins;
		}

		return empty( $plugins[ $slug ] ) ? null : $plugins[ $slug ];
	}

	/**
	 * Retrieve info for all plugins that use the connection.
	 * WARNING: the method cannot be called until Plugin_Storage::configure is called, which happens on plugins_loaded
	 * Even if you don't use Jetpack Config, it may be introduced later by other plugins,
	 * so please make sure not to run the method too early in the code.
	 *
	 * @since 1.39.0 deprecated the $connected_only argument.
	 *
	 * @param null $deprecated null plugins that were explicitly disconnected. Deprecated, there's no such a thing as disconnecting only specific plugins anymore.
	 *
	 * @return array|WP_Error
	 */
	public static function get_all( $deprecated = null ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$maybe_error = self::ensure_configured();

		if ( $maybe_error instanceof WP_Error ) {
			return $maybe_error;
		}

		return self::$plugins;
	}

	/**
	 * Remove the plugin connection info from Jetpack.
	 * WARNING: the method cannot be called until Plugin_Storage::configure is called, which happens on plugins_loaded
	 * Even if you don't use Jetpack Config, it may be introduced later by other plugins,
	 * so please make sure not to run the method too early in the code.
	 *
	 * @param string $slug The plugin slug.
	 *
	 * @return bool|WP_Error
	 */
	public static function delete( $slug ) {
		$maybe_error = self::ensure_configured();

		if ( $maybe_error instanceof WP_Error ) {
			return $maybe_error;
		}

		if ( array_key_exists( $slug, self::$plugins ) ) {
			unset( self::$plugins[ $slug ] );
		}

		return true;
	}

	/**
	 * The method makes sure that `Jetpack\Config` has finished, and it's now safe to retrieve the list of plugins.
	 *
	 * @return bool|WP_Error
	 */
	private static function ensure_configured() {
		if ( ! self::$configured ) {
			return new WP_Error( 'too_early', __( 'You cannot call this method until Jetpack Config is configured', 'jetpack-connection' ) );
		}

		if ( is_multisite() && get_current_blog_id() !== self::$current_blog_id ) {
			self::$plugins         = (array) get_option( self::ACTIVE_PLUGINS_OPTION_NAME, array() );
			self::$current_blog_id = get_current_blog_id();
		}

		return true;
	}

	/**
	 * Called once to configure this class after plugins_loaded.
	 *
	 * @return void
	 */
	public static function configure() {
		if ( self::$configured ) {
			return;
		}

		self::$configured = true;

		add_action( 'update_option_active_plugins', array( __CLASS__, 'set_flag_to_refresh_active_connected_plugins' ) );

		self::maybe_update_active_connected_plugins();
	}

	/**
	 * Set a flag to indicate that the active connected plugins list needs to be updated.
	 * This will happen when the `active_plugins` option is updated.
	 *
	 * @see configure
	 */
	public static function set_flag_to_refresh_active_connected_plugins() {
		set_transient( self::ACTIVE_PLUGINS_REFRESH_FLAG, time() );
	}

	/**
	 * Determine if we need to update the active connected plugins list.
	 */
	public static function maybe_update_active_connected_plugins() {
		$maybe_error = self::ensure_configured();

		if ( $maybe_error instanceof WP_Error ) {
			return;
		}
		// Only attempt to update the option if the corresponding flag is set.
		if ( ! get_transient( self::ACTIVE_PLUGINS_REFRESH_FLAG ) ) {
			return;
		}
		// Only attempt to update the option on POST requests.
		// This will prevent the option from being updated multiple times due to concurrent requests.
		if ( ! ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] ) ) {
			return;
		}

		delete_transient( self::ACTIVE_PLUGINS_REFRESH_FLAG );

		if ( is_multisite() ) {
			self::$current_blog_id = get_current_blog_id();
		}

		// If a plugin was activated or deactivated.
		// self::$plugins is populated in Config::ensure_options_connection().
		$configured_plugin_keys = array_keys( self::$plugins );
		$stored_plugin_keys     = array_keys( (array) get_option( self::ACTIVE_PLUGINS_OPTION_NAME, array() ) );
		sort( $configured_plugin_keys );
		sort( $stored_plugin_keys );

		if ( $configured_plugin_keys !== $stored_plugin_keys ) {
			self::update_active_plugins_option();
		}
	}

	/**
	 * Updates the active plugins option with current list of active plugins.
	 *
	 * @return void
	 */
	public static function update_active_plugins_option() {
		// Note: Since this option is synced to wpcom, if you change its structure, you have to update the sanitizer at wpcom side.
		update_option( self::ACTIVE_PLUGINS_OPTION_NAME, self::$plugins );
		if ( ! class_exists( 'Automattic\Jetpack\Sync\Settings' ) || ! \Automattic\Jetpack\Sync\Settings::is_sync_enabled() ) {
			self::update_active_plugins_wpcom_no_sync_fallback();
			// Remove the checksum for active plugins, so it gets recalculated when sync gets activated.
			$jetpack_callables_sync_checksum = Jetpack_Options::get_raw_option( 'jetpack_callables_sync_checksum' );
			if ( isset( $jetpack_callables_sync_checksum['jetpack_connection_active_plugins'] ) ) {
				unset( $jetpack_callables_sync_checksum['jetpack_connection_active_plugins'] );
				Jetpack_Options::update_raw_option( 'jetpack_callables_sync_checksum', $jetpack_callables_sync_checksum );
			}
		}
	}

	/**
	 * Add the plugin to the set of disconnected ones.
	 *
	 * @deprecated since 1.39.0.
	 *
	 * @param string $slug Plugin slug.
	 *
	 * @return bool
	 */
	public static function disable_plugin( $slug ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		return true;
	}

	/**
	 * Remove the plugin from the set of disconnected ones.
	 *
	 * @deprecated since 1.39.0.
	 *
	 * @param string $slug Plugin slug.
	 *
	 * @return bool
	 */
	public static function enable_plugin( $slug ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		return true;
	}

	/**
	 * Get all plugins that were disconnected by user.
	 *
	 * @deprecated since 1.39.0.
	 *
	 * @return array
	 */
	public static function get_all_disabled_plugins() { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		return array();
	}

	/**
	 * Update active plugins option with current list of active plugins on WPCOM.
	 * This is a fallback to ensure this option is always up to date on WPCOM in case
	 * Sync is not present or disabled.
	 *
	 * @since 1.34.0
	 */
	private static function update_active_plugins_wpcom_no_sync_fallback() {
		$connection = new Manager();
		if ( ! $connection->is_connected() ) {
			return;
		}

		$site_id = \Jetpack_Options::get_option( 'id' );

		$body = wp_json_encode(
			array(
				'active_connected_plugins' => self::$plugins,
			)
		);

		Client::wpcom_json_api_request_as_blog(
			sprintf( '/sites/%d/jetpack-active-connected-plugins', $site_id ),
			'2',
			array(
				'headers' => array( 'content-type' => 'application/json' ),
				'method'  => 'POST',
			),
			$body,
			'wpcom'
		);
	}
}
