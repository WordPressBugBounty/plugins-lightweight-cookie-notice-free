<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * This class should be used to work with the administrative side of WordPress.
 */
class Daextlwcnf_Admin {

	/**
	 * The instance of this class.
	 *
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * The instance of the shared class.
	 *
	 * @var Daextlwcnf_Shared|null
	 */
	private $shared = null;

	/**
	 * The screen id of the "Sections" menu.
	 *
	 * @var null
	 */
	private $screen_id_sections = null;

	/**
	 * The screen id of the "Categories" menu.
	 *
	 * @var null
	 */
	private $screen_id_categories = null;

	/**
	 * The screen id of the "Cookies" menu.
	 *
	 * @var null
	 */
	private $screen_id_cookies = null;

	/**
	 * The screen id of the "Consent Log" menu.
	 *
	 * @var null
	 */
	private $screen_id_consent_log = null;

	/**
	 * The screen id of the "Tools" menu.
	 *
	 * @var null
	 */
	private $screen_id_tools = null;

	/**
	 * The screen id of the "Maintenance" menu.
	 *
	 * @var null
	 */
	private $screen_id_maintenance = null;


	/**
	 * The screen id of the "Options" menu.
	 *
	 * @var null
	 */
	private $screen_id_options = null;

	/**
	 * Instance of the class used to generate the back-end menus.
	 *
	 * @var null
	 */
	private $menu_elements = null;

	/**
	 * Constructor.
	 */
	private function __construct() {

		// Assign an instance of the plugin info.
		$this->shared = Daextlwcnf_Shared::get_instance();

		// Load admin stylesheets and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the admin menu.
		add_action( 'admin_menu', array( $this, 'me_add_admin_menu' ) );

		// This hook is triggered during the creation of a new blog.
		add_action( 'wpmu_new_blog', array( $this, 'new_blog_create_options_and_tables' ), 10, 6 );

		// This hook is triggered during the deletion of a blog.
		add_action( 'delete_blog', array( $this, 'delete_blog_delete_options_and_tables' ), 10, 1 );

		// Require and instantiate the classes used to handle the menus.
		add_action( 'init', array( $this, 'handle_menus' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @return self|null
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * If we are in one of the plugin back-end menus require and instantiate the class used to handle the specific menu.
	 *
	 * @return void
	 */
	public function handle_menus() {

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce non-necessary for menu selection.
		$page_query_param = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : null;

		// Require and instantiate the class used to register the menu options.
		if ( null !== $page_query_param ) {

			$config = array(
				'admin_toolbar' => array(
					'items'      => array(
						array(
							'link_text' => __( 'Consent Log', 'lightweight-cookie-notice-free' ),
							'link_url'  => admin_url( 'admin.php?page=daextlwcnf-consent-log' ),
							'icon'      => 'file-06',
							'menu_slug' => 'daextlwcnf-consent-log',
						),
						array(
							'link_text' => __( 'Sections', 'lightweight-cookie-notice-free' ),
							'link_url'  => admin_url( 'admin.php?page=daextlwcnf-sections' ),
							'icon'      => 'divider',
							'menu_slug' => 'daextlwcnf-section',
						),
						array(
							'link_text' => __( 'Categories', 'lightweight-cookie-notice-free' ),
							'link_url'  => admin_url( 'admin.php?page=daextlwcnf-categories' ),
							'icon'      => 'list',
							'menu_slug' => 'daextlwcnf-category',
						),
					),
					'more_items' => array(
						array(
							'link_text' => __( 'Cookies', 'lightweight-cookie-notice-free' ),
							'link_url'  => admin_url( 'admin.php?page=daextlwcnf-cookies' ),
							'pro_badge' => false,
						),
						array(
							'link_text' => __( 'Tools', 'lightweight-cookie-notice-free' ),
							'link_url'  => admin_url( 'admin.php?page=daextlwcnf-tools' ),
							'pro_badge' => false,
						),
						array(
							'link_text' => __( 'Maintenance', 'lightweight-cookie-notice-free' ),
							'link_url'  => admin_url( 'admin.php?page=daextlwcnf-maintenance' ),
							'pro_badge' => false,
						),
						array(
							'link_text' => __( 'Proof of Consent', 'lightweight-cookie-notice-free' ),
							'link_url'  => 'https://daext.com/lightweight-cookie-notice/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Download Consent Data (CSV)', 'lightweight-cookie-notice-free' ),
							'link_url'  => 'https://daext.com/lightweight-cookie-notice/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Google Consent Mode', 'lightweight-cookie-notice-free' ),
							'link_url'  => 'https://daext.com/lightweight-cookie-notice/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Instant Scripts', 'lightweight-cookie-notice-free' ),
							'link_url'  => 'https://daext.com/lightweight-cookie-notice/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Import & Export', 'lightweight-cookie-notice-free' ),
							'link_url'  => 'https://daext.com/lightweight-cookie-notice/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Configure Capabilities', 'lightweight-cookie-notice-free' ),
							'link_url'  => 'https://daext.com/lightweight-cookie-notice/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Options', 'lightweight-cookie-notice-free' ),
							'link_url'  => admin_url( 'admin.php?page=daextlwcnf-options' ),
							'pro_badge' => false,
						),
					),
				),
			);

			// The parent class.
			require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/class-daextlwcnf-menu-elements.php';

			// Use the correct child class based on the page query parameter.
			if ( 'daextlwcnf-sections' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daextlwcnf-sections-menu-elements.php';
				$this->menu_elements = new Daextlwcnf_Sections_Menu_Elements( $this->shared, $page_query_param, $config );
			}
			if ( 'daextlwcnf-categories' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daextlwcnf-categories-menu-elements.php';
				$this->menu_elements = new Daextlwcnf_Categories_Menu_Elements( $this->shared, $page_query_param, $config );
			}
			if ( 'daextlwcnf-cookies' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daextlwcnf-cookies-menu-elements.php';
				$this->menu_elements = new Daextlwcnf_Cookies_Menu_Elements( $this->shared, $page_query_param, $config );
			}
			if ( 'daextlwcnf-consent-log' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daextlwcnf-consent-log-menu-elements.php';
				$this->menu_elements = new Daextlwcnf_Consent_Log_Menu_Elements( $this->shared, $page_query_param, $config );
			}
			if ( 'daextlwcnf-tools' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daextlwcnf-tools-menu-elements.php';
				$this->menu_elements = new Daextlwcnf_Tools_Menu_Elements( $this->shared, $page_query_param, $config );
			}
			if ( 'daextlwcnf-maintenance' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daextlwcnf-maintenance-menu-elements.php';
				$this->menu_elements = new Daextlwcnf_Maintenance_Menu_Elements( $this->shared, $page_query_param, $config );
			}
			if ( 'daextlwcnf-options' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daextlwcnf-options-menu-elements.php';
				$this->menu_elements = new Daextlwcnf_Options_Menu_Elements( $this->shared, $page_query_param, $config );
			}
		}

	}

	/**
	 * Enqueue admin specific styles.
	 *
	 * @return void
	 */
	public function enqueue_admin_styles() {

		$screen = get_current_screen();

		// Menu Consent Log.
		if ( $screen->id === $this->screen_id_consent_log ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array(), $this->shared->get( 'ver' ) );

		}

		// Menu Sections.
		if ( $screen->id === $this->screen_id_sections ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array(), $this->shared->get( 'ver' ) );

		}

		// Menu Categories.
		if ( $screen->id === $this->screen_id_categories ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array(), $this->shared->get( 'ver' ) );

			// Select2.
			wp_enqueue_style(
				$this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/css/select2.min.css',
				array(),
				$this->shared->get( 'ver' )
			);

		}

		// Menu Cookies.
		if ( $screen->id === $this->screen_id_cookies ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array(), $this->shared->get( 'ver' ) );

			// Select2.
			wp_enqueue_style(
				$this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/css/select2.min.css',
				array(),
				$this->shared->get( 'ver' )
			);

		}

		// Menu Maintenance.
		if ( $screen->id === $this->screen_id_maintenance ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array(), $this->shared->get( 'ver' ) );

			// Select2.
			wp_enqueue_style(
				$this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/css/select2.min.css',
				array(),
				$this->shared->get( 'ver' )
			);

			// jQuery UI Dialog.
			wp_enqueue_style(
				$this->shared->get( 'slug' ) . '-jquery-ui-dialog',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-dialog.css',
				array(),
				$this->shared->get( 'ver' )
			);

		}

		// Menu Tools.
		if ( $screen->id === $this->screen_id_tools ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array(), $this->shared->get( 'ver' ) );

		}

		// Menu Options.
		if ( $screen->id === $this->screen_id_options ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array( 'wp-components' ), $this->shared->get( 'ver' ) );

		}
	}

	/**
	 * Enqueue admin-specific JavaScript.
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {

		$wp_localize_script_data = array(
			'confirmText'        => esc_html__( 'Confirm', 'lightweight-cookie-notice-free' ),
			'cancelText'         => esc_html__( 'Cancel', 'lightweight-cookie-notice-free' ),
			'chooseAnOptionText' => wp_strip_all_tags( __( 'Choose an Option ...', 'lightweight-cookie-notice-free' ) ),
		);

		$screen = get_current_screen();

		// General.
		wp_enqueue_script( $this->shared->get( 'slug' ) . '-general', $this->shared->get( 'url' ) . 'admin/assets/js/general.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

		// Menu Sections.
		if ( $screen->id === $this->screen_id_sections ) {

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

		}

		// Menu Categories.
		if ( $screen->id === $this->screen_id_categories ) {

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

			// Select2.
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/js/select2.min.js',
				array( 'jquery' ),
				$this->shared->get( 'ver' ),
				true
			);

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-categories', $this->shared->get( 'url' ) . 'admin/assets/js/menu-categories.js', array( 'jquery', $this->shared->get( 'slug' ) . '-select2' ), $this->shared->get( 'ver' ), true );
			wp_localize_script( $this->shared->get( 'slug' ) . '-menu-categories', 'objectL10n', $wp_localize_script_data );

		}

		// Menu Cookies.
		if ( $screen->id === $this->screen_id_cookies ) {

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

			// Select2.
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/js/select2.min.js',
				array( 'jquery' ),
				$this->shared->get( 'ver' ),
				true
			);

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-cookies', $this->shared->get( 'url' ) . 'admin/assets/js/menu-cookies.js', array( 'jquery', $this->shared->get( 'slug' ) . '-select2' ), $this->shared->get( 'ver' ), true );

		}

		// Menu Consent Log.
		if ( $screen->id === $this->screen_id_consent_log ) {

			// Store the JavaScript parameters in the window.DAEXTAMP_PARAMETERS object.
			$initialization_script  = 'window.DAEXTLWCNF_PARAMETERS = {';
			$initialization_script .= 'ajax_url: "' . admin_url( 'admin-ajax.php' ) . '",';
			$initialization_script .= 'admin_url: "' . get_admin_url() . '",';
			$initialization_script .= 'site_url: "' . get_site_url() . '",';
			$initialization_script .= 'plugin_url: "' . $this->shared->get( 'url' ) . '",';
			$initialization_script .= '};';

			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-consent-log-menu',
				$this->shared->get( 'url' ) . 'admin/react/consent-log-menu/build/index.js',
				array( 'wp-element', 'wp-api-fetch', 'wp-i18n' ),
				$this->shared->get( 'ver' ),
				true
			);

			wp_add_inline_script( $this->shared->get( 'slug' ) . '-consent-log-menu', $initialization_script, 'before' );

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

		}

		// Menu Tools.
		if ( $screen->id === $this->screen_id_tools ) {

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

		}

		// Menu Maintenance.
		if ( $screen->id === $this->screen_id_maintenance ) {

			// Select2.
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/js/select2.min.js',
				array( 'jquery' ),
				$this->shared->get( 'ver' ),
				true
			);

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

			// Maintenance Menu.
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-menu-maintenance',
				$this->shared->get( 'url' ) . 'admin/assets/js/menu-maintenance.js',
				array( 'jquery', 'jquery-ui-dialog', $this->shared->get( 'slug' ) . '-select2' ),
				$this->shared->get( 'ver' ),
				true
			);
			wp_localize_script(
				$this->shared->get( 'slug' ) . '-menu-maintenance',
				'objectL10n',
				$wp_localize_script_data
			);

		}

		// Menu Options.
		if ( $screen->id === $this->screen_id_options ) {

			// Store the JavaScript parameters in the window.DAEXTDAEXTLWCNF_PARAMETERS object.
			$initialization_script  = 'window.DAEXTLWCNF_PARAMETERS = {';
			$initialization_script .= 'options_configuration_pages: ' . wp_json_encode( $this->shared->menu_options_configuration() );
			$initialization_script .= '};';

			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-menu-options',
				$this->shared->get( 'url' ) . 'admin/react/options-menu/build/index.js',
				array( 'wp-element', 'wp-api-fetch', 'wp-i18n', 'wp-components' ),
				$this->shared->get( 'ver' ),
				true
			);

			wp_add_inline_script( $this->shared->get( 'slug' ) . '-menu-options', $initialization_script, 'before' );

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

		}
	}

	/**
	 * Plugin activation.
	 *
	 * @param bool $networkwide True if the plugin is being activated network-wide.
	 *
	 * @return void
	 */
	public static function ac_activate( $networkwide ) {

		/**
		 * Delete options and tables for all the sites in the network.
		 */
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			/**
			 * If this is a "Network Activation" create the options and tables
			 * for each blog.
			 */
			if ( $networkwide ) {

				// Get the current blog id.
				global $wpdb;
				$current_blog = $wpdb->blogid;

				// Create an array with all the blog ids.

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

				// Iterate through all the blogs.
				foreach ( $blogids as $blog_id ) {

					// Switch to the iterated blog.
					switch_to_blog( $blog_id );

					// Create options and tables for the iterated blog.
					self::ac_initialize_options();
					self::ac_create_database_tables();

				}

				// Switch to the current blog.
				switch_to_blog( $current_blog );

			} else {

				/**
				 * If this is not a "Network Activation" create options and
				 * tables only for the current blog.
				 */
				self::ac_initialize_options();
				self::ac_create_database_tables();

			}
		} else {

			/**
			 * If this is not a multisite installation create options and
			 * tables only for the current blog.
			 */
			self::ac_initialize_options();
			self::ac_create_database_tables();

		}
	}

	/**
	 * Create the options and tables for the newly created blog.
	 *
	 * @param int $blog_id The id of the blog.
	 *
	 * @return void
	 */
	public function new_blog_create_options_and_tables( $blog_id ) {

		global $wpdb;

		/**
		 * If the plugin is "Network Active" create the options and tables for
		 * this new blog.
		 */
		if ( is_plugin_active_for_network( 'lightweight-cookie-notice/init.php' ) ) {

			// Get the id of the current blog.
			$current_blog = $wpdb->blogid;

			// Switch to the blog that is being activated.
			switch_to_blog( $blog_id );

			// Create options and database tables for the new blog.
			$this->ac_initialize_options();
			$this->ac_create_database_tables();

			// Switch to the current blog.
			switch_to_blog( $current_blog );

		}
	}

	/**
	 * Delete options and tables for the deleted blog.
	 *
	 * @param int $blog_id The ID of the blog.
	 *
	 * @return void
	 */
	public function delete_blog_delete_options_and_tables( $blog_id ) {

		global $wpdb;

		// Get the id of the current blog.
		$current_blog = $wpdb->blogid;

		// Switch to the blog that is being activated.
		switch_to_blog( $blog_id );

		// Create options and database tables for the new blog.
		$this->un_delete_options();
		$this->un_delete_database_tables();

		// Switch to the current blog.
		switch_to_blog( $current_blog );
	}

	/**
	 * Initialize plugin options.
	 *
	 * @return void
	 */
	public static function ac_initialize_options() {

		if ( intval( get_option( 'daextlwcnf_options_version' ), 10 ) < 1 ) {

			// assign an instance of Daextlwcnf_Shared.
			$shared = Daextlwcnf_Shared::get_instance();

			foreach ( $shared->get( 'options' ) as $key => $value ) {
				add_option( $key, $value );
			}

			// Update options version.
			update_option( 'daextlwcnf_options_version', '1' );

		}
	}

	/**
	 * Create the plugin database tables.
	 *
	 * @return void
	 */
	public static function ac_create_database_tables() {

		// assign an instance of Daextlwcnf_Shared.
		$shared = Daextlwcnf_Shared::get_instance();

		global $wpdb;

		// Get the database character collate that will be appended at the end of each query.
		$charset_collate = $wpdb->get_charset_collate();

		// check database version and create the database.
		if ( intval( get_option( $shared->get( 'slug' ) . '_database_version' ), 10 ) < 5 ) {

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			// Create *prefix*_section.
			$table_name = $wpdb->prefix . $shared->get( 'slug' ) . '_section';
			$sql        = "CREATE TABLE $table_name (
                section_id BIGINT UNSIGNED AUTO_INCREMENT,
                name TEXT,
                description TEXT,
                priority TINYINT(1) UNSIGNED,
                PRIMARY KEY  (section_id)
            ) $charset_collate";
			dbDelta( $sql );

			// Create *prefix*_category.
			$table_name = $wpdb->prefix . $shared->get( 'slug' ) . '_category';
			$sql        = "CREATE TABLE $table_name (
                category_id BIGINT UNSIGNED AUTO_INCREMENT,
                name TEXT,
                description TEXT,
                toggle TINYINT(1) UNSIGNED,
                default_status TINYINT(1) UNSIGNED,
                priority TINYINT(1) UNSIGNED,
                script_head TEXT,
                script_body TEXT,
                section_id BIGINT UNSIGNED,
                PRIMARY KEY  (category_id)
            ) $charset_collate";
			dbDelta( $sql );

			// Create *prefix*_cookie.
			$table_name = $wpdb->prefix . $shared->get( 'slug' ) . '_cookie';
			$sql        = "CREATE TABLE $table_name (
                cookie_id BIGINT UNSIGNED AUTO_INCREMENT,
                provider TEXT,
                domain TEXT,
                name TEXT,
                purpose TEXT,
                expiration TEXT,
                type TEXT,
                sensitivity TEXT,
                security TEXT,
                category_id BIGINT UNSIGNED,
                priority TINYINT(1) UNSIGNED,
                cookie_domain_attribute TEXT,
                cookie_path_attribute TEXT,
                PRIMARY KEY  (cookie_id)
            ) $charset_collate";
			dbDelta( $sql );

			// Create *prefix*_consent_log.
			$table_name = $wpdb->prefix . $shared->get( 'slug' ) . '_consent_log';
			$sql        = "CREATE TABLE $table_name (
                consent_log_id BIGINT UNSIGNED AUTO_INCREMENT,
                 consent_id TEXT,              
                 anonymized_user_ip TEXT,
                 date DATETIME,
                 user_agent TEXT,
                 url TEXT,
                 encrypted_key TEXT,
                country_code TEXT,
                state TEXT,
                PRIMARY KEY  (consent_log_id)
            ) $charset_collate";
			dbDelta( $sql );

			// Update database version.
			update_option( $shared->get( 'slug' ) . '_database_version', '5' );

		}
	}

	/**
	 * Plugin delete.
	 *
	 * @return void
	 */
	public static function un_delete() {

		/**
		 * Delete options and tables for all the sites in the network.
		 */
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			// Get the current blog id.
			global $wpdb;
			$current_blog = $wpdb->blogid;

			// Create an array with all the blog ids.

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

			// Iterate through all the blogs.
			foreach ( $blogids as $blog_id ) {

				// Switch to the iterated blog.
				switch_to_blog( $blog_id );

				// Create options and tables for the iterated blog.
				self::un_delete_options();
				self::un_delete_database_tables();

				/**
				 * Remove the cookies in WP Super Cache.
				 *
				 * Ref: https://odd.blog/2018/07/20/wp-super-cache-and-cookie-banners/
				 */
				do_action( 'wpsc_delete_cookie', 'daextlwcnf-accepted' );

			}

			// Switch to the current blog.
			switch_to_blog( $current_blog );

		} else {

			/**
			 * If this is not a multisite installation delete options and tables only for the current blog.
			 */
			self::un_delete_options();
			self::un_delete_database_tables();

			/**
			 * Remove the cookie in WP Super Cache.
			 *
			 * Ref: https://odd.blog/2018/07/20/wp-super-cache-and-cookie-banners/
			 */
			do_action( 'wpsc_delete_cookie', 'daextlwcnf-accepted' );

		}
	}

	/**
	 * Delete plugin options.
	 *
	 * @return void
	 */
	public static function un_delete_options() {

		// Assign an instance of Daextlwcnf_Shared.
		$shared = Daextlwcnf_Shared::get_instance();

		foreach ( $shared->get( 'options' ) as $key => $value ) {
			delete_option( $key );
		}
	}

	/**
	 * Delete plugin database tables.
	 *
	 * @return void
	 */
	public static function un_delete_database_tables() {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DROP TABLE {$wpdb->prefix}daextlwcnf_section" );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DROP TABLE {$wpdb->prefix}daextlwcnf_category" );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DROP TABLE {$wpdb->prefix}daextlwcnf_cookie" );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DROP TABLE {$wpdb->prefix}daextlwcnf_consent_log" );
	}

	/**
	 * Register the admin menu.
	 *
	 * @return void
	 */
	public function me_add_admin_menu() {

		$icon_svg = '<?xml version="1.0" encoding="UTF-8"?>
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 40 40">
		  <defs>
		    <style>
		      .cls-1 {
		      fill: #98a3b3;
		      }
		    </style>
		  </defs>
		  <!-- Generator: Adobe Illustrator 28.6.0, SVG Export Plug-In . SVG Version: 1.2.0 Build 709)  -->
		  <g>
		    <g id="Layer_1">
		      <g id="dots">
		        <circle class="cls-1" cx="21" cy="19" r="2"/>
		        <circle class="cls-1" cx="15" cy="11" r="1"/>
		        <circle class="cls-1" cx="10" cy="20" r="2"/>
		        <circle class="cls-1" cx="20" cy="30" r="2"/>
		        <circle class="cls-1" cx="12" cy="28" r="1"/>
		        <circle class="cls-1" cx="29" cy="25" r="1"/>
		      </g>
		      <path class="cls-1" d="M19.1,4c0,.3,0,.6,0,1,0,2.2,1.2,4.1,3,5.2.1,4.3,3.5,7.7,7.8,7.8,1,1.8,3,3,5.2,3s.7,0,1,0c-.5,8.4-7.5,15.1-16,15.1S4,28.8,4,20s6.7-15.5,15.1-16M20,2C10.1,2,2,10.1,2,20s8.1,18,18,18,18-8.1,18-18,0-1.5-.1-2.2c-.7.7-1.7,1.2-2.9,1.2-1.9,0-3.5-1.3-3.9-3.1-.4,0-.7.1-1.1.1-3.3,0-6-2.7-6-6s0-.8.1-1.1c-1.8-.4-3.1-2-3.1-3.9s.5-2.1,1.2-2.9c-.7,0-1.5-.1-2.2-.1h0Z"/>
		    </g>
		  </g>
		</svg>';

		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 encoding is used to embed the SVG in the HTML.
		$icon_svg = 'data:image/svg+xml;base64,' . base64_encode( $icon_svg );

		add_menu_page(
			esc_html__( 'LCN', 'lightweight-cookie-notice-free' ),
			esc_html__( 'Cookie Notice', 'lightweight-cookie-notice-free' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-consent-log',
			array( $this, 'me_display_menu_consent_log' ),
			$icon_svg
		);

		$this->screen_id_consent_log = add_submenu_page(
			$this->shared->get( 'slug' ) . '-consent-log',
			esc_html__( 'LCN - Consent Log', 'lightweight-cookie-notice-free' ),
			esc_html__( 'Consent Log', 'lightweight-cookie-notice-free' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-consent-log',
			array( $this, 'me_display_menu_consent_log' )
		);

		$this->screen_id_sections = add_submenu_page(
			$this->shared->get( 'slug' ) . '-consent-log',
			esc_html__( 'LCN - Sections', 'lightweight-cookie-notice-free' ),
			esc_html__( 'Sections', 'lightweight-cookie-notice-free' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-sections',
			array( $this, 'me_display_menu_sections' )
		);

		$this->screen_id_categories = add_submenu_page(
			$this->shared->get( 'slug' ) . '-consent-log',
			esc_html__( 'LCN - Categories', 'lightweight-cookie-notice-free' ),
			esc_html__( 'Categories', 'lightweight-cookie-notice-free' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-categories',
			array( $this, 'me_display_menu_categories' )
		);

		$this->screen_id_cookies = add_submenu_page(
			$this->shared->get( 'slug' ) . '-consent-log',
			esc_html__( 'LCN - Cookies', 'lightweight-cookie-notice-free' ),
			esc_html__( 'Cookies', 'lightweight-cookie-notice-free' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-cookies',
			array( $this, 'me_display_menu_cookies' )
		);

		$this->screen_id_tools = add_submenu_page(
			$this->shared->get( 'slug' ) . '-consent-log',
			esc_html__( 'LCN - Tools', 'lightweight-cookie-notice-free'),
			esc_html__( 'Tools', 'lightweight-cookie-notice-free'),
			'manage_options',
			$this->shared->get( 'slug' ) . '-tools',
			array( $this, 'me_display_menu_tools' )
		);

		$this->screen_id_maintenance = add_submenu_page(
			$this->shared->get( 'slug' ) . '-consent-log',
			esc_html__( 'LCN - Maintenance', 'lightweight-cookie-notice-free' ),
			esc_html__( 'Maintenance', 'lightweight-cookie-notice-free' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-maintenance',
			array( $this, 'me_display_menu_maintenance' )
		);

		$this->screen_id_options = add_submenu_page(
			$this->shared->get( 'slug' ) . '-consent-log',
			esc_html__( 'LCN - Options', 'lightweight-cookie-notice-free' ),
			esc_html__( 'Options', 'lightweight-cookie-notice-free' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-options',
			array( $this, 'me_display_menu_options' )
		);

		add_submenu_page(
			$this->shared->get( 'slug' ) . '-consent-log',
			esc_html__( 'Help & Support', 'lightweight-cookie-notice-free' ),
			esc_html__( 'Help & Support', 'lightweight-cookie-notice-free' ) . '<i class="dashicons dashicons-external" style="font-size:12px;vertical-align:-2px;height:10px;"></i>',
			'manage_options',
			'https://daext.com/doc/lightweight-cookie-notice/',
		);
	}

	/**
	 * Includes the categories view.
	 *
	 * @return void
	 */
	public function me_display_menu_sections() {
		include_once 'view/sections.php';
	}


	/**
	 * Includes the categories view.
	 *
	 * @return void
	 */
	public function me_display_menu_categories() {
		include_once 'view/categories.php';
	}

	/**
	 * Includes the cookies view.
	 *
	 * @return void
	 */
	public function me_display_menu_cookies() {
		include_once 'view/cookies.php';
	}

	/**
	 * Includes the consent log view.
	 *
	 * @return void
	 */
	public function me_display_menu_consent_log() {
		include_once 'view/consent_log.php';
	}

	/**
	 * Includes the tools view.
	 *
	 * @return void
	 */
	public function me_display_menu_tools() {
		include_once 'view/tools.php';
	}

	/**
	 * Includes the maintenance view.
	 *
	 * @return void
	 */
	public function me_display_menu_maintenance() {
		include_once 'view/maintenance.php';
	}

	/**
	 * Includes the options view.
	 *
	 * @return void
	 */
	public function me_display_menu_help() {
		include_once 'view/help.php';
	}

	/**
	 * Includes the options view.
	 *
	 * @return void
	 */
	public function me_display_menu_options() {
		include_once 'view/options.php';
	}
}
