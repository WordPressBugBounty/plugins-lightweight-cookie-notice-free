<?php
/**
 * Plugin Name: Lightweight Cookie Notice
 * Description: Generates a lightweight cookie notice. (Lite Version)
 * Version: 1.18
 * Author: DAEXT
 * Author URI: https://daext.com
 * Text Domain: lightweight-cookie-notice-free
 * License: GPLv3
 *
 * @package lightweight-cookie-notice-free
 */

// Prevent direct access to this file.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// Set constants.
define( 'DAEXTLWCN_EDITION', 'FREE' );

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
