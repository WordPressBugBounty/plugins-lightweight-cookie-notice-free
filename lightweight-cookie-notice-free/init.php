<?php
/**
 * Plugin Name: Lightweight Cookie Notice
 * Description: Generates a lightweight cookie notice. (Lite Version)
 * Version: 1.22
 * Author: DAEXT
 * Author URI: https://daext.com
 * Text Domain: lightweight-cookie-notice-free
 * License: GPLv3
 *
 * @package lightweight-cookie-notice-free
 */

use Daext\Daextlwcnf\NoticesManager\DAEXT_Notices_Manager;

// Prevent direct access to this file.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// Set constants.
define( 'DAEXTLWCNF_EDITION', 'FREE' );

// Include functions.
require_once plugin_dir_path( __FILE__ ) . 'functions.php';

// Class shared across public and admin.
require_once plugin_dir_path( __FILE__ ) . 'shared/class-daextlwcnf-shared.php';
require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';

// Rest API.
require_once plugin_dir_path( __FILE__ ) . 'inc/class-daextlwcnf-rest.php';
add_action( 'plugins_loaded', array( 'Daextlwcnf_Rest', 'get_instance' ) );

// Public.
require_once plugin_dir_path( __FILE__ ) . 'public/class-daextlwcnf-public.php';
add_action( 'plugins_loaded', array( 'Daextlwcnf_Public', 'get_instance' ) );

/**
 * Consent log retention.
 *
 * The expired consent log records are deleted once a day with WP-Cron, based on the "Consent Log Retention" option.
 * The second event is used for single deletions: right after the option is changed, and to continue a deletion that
 * doesn't complete in a single run.
 */
add_action( 'daextlwcnf_delete_expired_consent_log_records', array( Daextlwcnf_Shared::get_instance(), 'run_scheduled_consent_log_retention' ) );
add_action( 'daextlwcnf_delete_expired_consent_log_records_single', array( Daextlwcnf_Shared::get_instance(), 'run_scheduled_consent_log_retention' ) );
add_action( 'init', array( Daextlwcnf_Shared::get_instance(), 'schedule_consent_log_retention' ) );
add_action( 'update_option_daextlwcnf_consent_log_retention', array( Daextlwcnf_Shared::get_instance(), 'schedule_consent_log_retention_after_update' ), 10, 2 );

/**
 * Get the total number of records stored in the plugin "_consent_log" table.
 *
 * This helper is used to quickly retrieve how many consent log records are currently stored
 * without having to run a full query on the table contents.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @return int Total number of rows in the "*_consent_log" table. Returns 0 if the table does not exist.
 */
function daextlwcnf_get_consent_log_count() {

	// Use a transient to avoid running the COUNT(*) query on every request.
	$transient_key = 'daextlwcnf_consent_log_count';
	$cached_count  = get_transient( $transient_key );

	if ( false !== $cached_count ) {
		return (int) $cached_count;
	}

	/**
	 * If the database version is not set or is less than 5, it means the table has not been created yet or is not
	 * updated to the latest version. In this case, we can safely return 0 without running a query.
	 */
	if ( intval( get_option( 'daextlwcnf_database_version' ), 10 ) < 5 ) {
		return 0;
	}

	global $wpdb;

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}daextlwcnf_consent_log" );

	/**
	 * Cache the result for a short period to reduce database load while keeping it reasonably fresh.
	 * Here we use 10 minutes (600 seconds) as a sensible default.
	 */
	set_transient( $transient_key, $count, 10 * MINUTE_IN_SECONDS );
	return $count;

}

/**
 * Initialize the plugin notices manager used to display documentation and review notices for this plugin.
 *
 * The notices are only relevant in the admin area, so we restrict the initialization to is_admin(),
 * which also avoids running the consent log COUNT(*) query on front-end requests.
 */
if ( is_admin() ) {
	require_once __DIR__ . '/inc/daext-notices-manager/class-daext-notices-manager.php';
	DAEXT_Notices_Manager::get_instance( [
		'plugin_slug'        => 'lightweight-cookie-notice-free',
		'plugin_file'        => __FILE__,
		'docs_url'           => 'https://daext.com/doc/lightweight-cookie-notice/',
		'review_url'         => 'https://wordpress.org/support/plugin/lightweight-cookie-notice-free/reviews/#new-post',
		'plugin_prefix'      => 'daextlwcnf',
		'settings_screen_id' => 'cookie-notice_page_daextlwcnf-options',
		'feature_used'       => daextlwcnf_get_consent_log_count() >= 5,
	] );
}

// Admin.
if ( is_admin() ) {

	// Admin.
	require_once plugin_dir_path( __FILE__ ) . 'admin/class-daextlwcnf-admin.php';

	// If this is not an AJAX request, create a new singleton instance of the admin class.
	if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
		add_action( 'plugins_loaded', array( 'Daextlwcnf_Admin', 'get_instance' ) );
	}

	// Activate the plugin using only the class static methods.
	register_activation_hook( __FILE__, array( 'Daextlwcnf_Admin', 'ac_activate' ) );

	// Deactivate the plugin using only the class static methods.
	register_deactivation_hook( __FILE__, array( 'Daextlwcnf_Admin', 'dc_deactivate' ) );

	// Update the plugin db tables and options if they are not up-to-date.
	Daextlwcnf_Admin::ac_create_database_tables();
	Daextlwcnf_Admin::ac_initialize_options();

}

// Ajax.
if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

	// Admin.
	require_once plugin_dir_path( __FILE__ ) . 'class-daextlwcnf-ajax.php';
	add_action( 'plugins_loaded', array( 'Daextlwcnf_Ajax', 'get_instance' ) );

}

/**
 * Customize the action links in the "Plugins" menu.
 *
 * @param array $actions An array of plugin action links.
 *
 * @return mixed
 */
function daextlwcnf_customize_action_links( $actions ) {
	$actions[] = '<a href="https://daext.com/lightweight-cookie-notice/" target="_blank">' . esc_html__( 'Buy the Pro Version', 'lightweight-cookie-notice-free' ) . '</a>';
	return $actions;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'daextlwcnf_customize_action_links' );
