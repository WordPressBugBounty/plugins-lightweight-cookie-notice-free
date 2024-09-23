<?php
/**
 * Uninstall plugin.
 *
 * @package lightweight-cookie-notice-free
 */

// Exit if this file is called outside WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die();
}

require_once plugin_dir_path( __FILE__ ) . 'shared/class-daextlwcnf-shared.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/class-daextlwcnf-admin.php';

// Delete options and tables.
Daextlwcnf_Admin::un_delete();
