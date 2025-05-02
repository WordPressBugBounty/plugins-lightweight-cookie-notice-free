<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * This class should be used to work with the public side of WordPress.
 */
class Daextlwcnf_Public {

	/**
	 * The singleton instance of the class.
	 *
	 * @var Daextlwcnf_Shared
	 */
	protected static $instance = null;

	/**
	 * An instance of the shared class.
	 *
	 * @var Daextlwcnf_Shared|null
	 */
	private $shared = null;

	/**
	 * Constructor.
	 */
	private function __construct() {

		// Assign an instance of the plugin shared class.
		$this->shared = Daextlwcnf_Shared::get_instance();

		// Write in front-end footer.
		add_action( 'wp_footer', array( $this, 'wr_public_footer' ) );

		// Add the 'cookies' shortcode.
		add_shortcode( 'cookies', array( $this, 'print_cookie_table_html' ) );

		// Add the 'delete-cookies' shortcode.
		add_shortcode( 'delete-cookies', array( $this, 'print_delete_cookies_button_html' ) );

		// Add the 'revisit-consent' shortcode.
		add_shortcode( 'revisit-consent', array( $this, 'print_revisit_consent_button_html' ) );

		/**
		 * If W3 Total Cache is active and the plugin option "Page Fragment Caching Exception (W3TC)" is enabled the
		 * "Page Fragment Cache" feature of W3 Total Cache is used and the following operations are performed:
		 *
		 * - Set the W3TC_DYNAMIC_SECURITY constant that is required to run the mfunc and mclude HTML comment
		 * - Call the methods that use the mfunc and mclude HTML comment as a replacement of the PHP-tags
		 *
		 * Otherwise:
		 *
		 * - Run the normal methods used to add content in the head and at the end of the body.
		 *
		 * Ref: https://github.com/W3EDGE/w3-total-cache/wiki/FAQ:-Developers#what-is-page-fragment-cache
		 * Ref: https://www.justinsilver.com/technology/wordpress/w3-total-cache-fragment-caching-wordpress/
		 * Ref: https://www.boldgrid.com/support/w3-total-cache/how-to-implement-page-fragment-caching-exception-in-w3-total-cache/
		 */
		if ( function_exists( 'w3tc_flush_all' ) &&
			1 === intval( get_option( $this->shared->get( 'slug' ) . '_page_fragment_caching_exception_w3tc' ), 10 ) ) {
			define( 'W3TC_DYNAMIC_SECURITY', 'daextlwcnf' );
			add_action( 'wp_head', array( $this, 'print_head_scripts_w3tc' ) );
			add_action( 'wp_print_footer_scripts', array( $this, 'print_body_scripts_w3tc' ) );
		} else {
			add_action( 'wp_head', array( $this, 'print_head_scripts' ) );
			add_action( 'wp_print_footer_scripts', array( $this, 'print_body_scripts' ) );
		}

		// Load public CSS.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Load public js.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Add the cookies in WP Super Cache.
		add_action( 'init', array( $this, 'wpsc_add_cookie' ) );
	}

	/**
	 * Creates an instance of this class.
	 *
	 * @return Daextlwcnf_Shared|self|null
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Enqueue CSS styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {

		$google_font_url = get_option( $this->shared->get( 'slug' ) . '_google_font_url' );

		// Adds the Google Fonts if they are defined in the "Google Font URL" option.
		if ( strlen( trim( $google_font_url ) ) > 0 ) {

			wp_enqueue_style(
				$this->shared->get( 'slug' ) . '-google-font',
				esc_url( $google_font_url ),
				false,
				$this->shared->get( 'ver' )
			);

		}
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {

		if ( intval( get_option( $this->shared->get( 'slug' ) . '_assets_mode' ), 10 ) === 0 ) {

			// Development.
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-daextlwcnf-polyfills',
				$this->shared->get( 'url' ) . 'public/assets/js/daextlwcnf-polyfills.js',
				array(),
				$this->shared->get( 'ver' ),
				true
			);
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-daextlwcnf-utility',
				$this->shared->get( 'url' ) . 'public/assets/js/daextlwcnf-utility.js',
				array(),
				$this->shared->get( 'ver' ),
				true
			);
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-daextlwcnf-revisit-cookie-consent',
				$this->shared->get( 'url' ) . 'public/assets/js/daextlwcnf-revisit-cookie-consent.js',
				array(),
				$this->shared->get( 'ver' ),
				true
			);
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-daextLwcn-cookie-settings',
				$this->shared->get( 'url' ) . 'public/assets/js/daextlwcnf-cookie-settings.js',
				array(),
				$this->shared->get( 'ver' ),
				true
			);
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-daextlwcnf-cookie-notice',
				$this->shared->get( 'url' ) . 'public/assets/js/daextlwcnf-cookie-notice.js',
				array(),
				$this->shared->get( 'ver' ),
				true
			);

			$partial_script_handle = 'daextlwcnf-cookie-notice';

		} else {

			// Production.
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-general',
				$this->shared->get( 'url' ) . 'public/assets/js/production/general.js',
				array(),
				$this->shared->get( 'ver' ),
				true
			);

			$partial_script_handle = 'general';

		}

		// Generate the array that will be passed to wp_localize_script().
		$php_data = array(
			'nonce'               => wp_create_nonce( 'daextlwcnf' ),
			'ajaxUrl'             => admin_url( 'admin-ajax.php' ),
			'nameText'            => esc_html__( 'Name', 'lightweight-cookie-notice-free' ),
			'expirationText'      => esc_html__( 'Expiration', 'lightweight-cookie-notice-free' ),
			'purposeText'         => esc_html__( 'Purpose', 'lightweight-cookie-notice-free' ),
			'providerText'        => esc_html__( 'Provider', 'lightweight-cookie-notice-free' ),
			'domainText'          => esc_html__( 'Domain', 'lightweight-cookie-notice-free' ),
			'typeText'            => esc_html__( 'Type', 'lightweight-cookie-notice-free' ),
			'sensitivityText'     => esc_html__( 'Sensitivity', 'lightweight-cookie-notice-free' ),
			'securityText'        => esc_html__( 'Security', 'lightweight-cookie-notice-free' ),
			'moreInformationText' => esc_html__( 'More Information', 'lightweight-cookie-notice-free' ),
		);

		// Make PHP data available to the JavaScript part in the DAEXTLWCN_PHPDATA object.
		wp_localize_script(
			$this->shared->get( 'slug' ) . '-' . $partial_script_handle,
			'DAEXTLWCN_PHPDATA',
			$php_data
		);
	}

	/**
	 * Writes in the public footer the JavaScript code used to initialize and configure the cookie notice.
	 */
	public function wr_public_footer() {

		// Do not proceed if the test mode is enabled and the user is not the administrator.
		if ( intval( get_option( $this->shared->get( 'slug' ) . '_test_mode' ), 10 ) === 1 &&
			! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Get the transient with included the data if available.
		$data = get_transient( 'daextlwcnf_data' );

		// Generate the data only if the transient with the data is not available.
		if ( false === $data ) {

			$res = $this->shared->get_cookie_notice_data();

			$section_a = $res['section_a'];
			$cookies   = $res['cookies'];

			$data = array(

				// General --------------------------------------------------------------------------------------------.
				'headings_font_family'                     => get_option( $this->shared->get( 'slug' ) . '_headings_font_family' ),
				'headings_font_weight'                     => get_option( $this->shared->get( 'slug' ) . '_headings_font_weight' ),
				'paragraphs_font_family'                   => get_option( $this->shared->get( 'slug' ) . '_paragraphs_font_family' ),
				'paragraphs_font_weight'                   => get_option( $this->shared->get( 'slug' ) . '_paragraphs_font_weight' ),
				'strong_tags_font_weight'                  => get_option( $this->shared->get( 'slug' ) . '_strong_tags_font_weight' ),
				'buttons_font_family'                      => get_option( $this->shared->get( 'slug' ) . '_buttons_font_family' ),
				'buttons_font_weight'                      => get_option( $this->shared->get( 'slug' ) . '_buttons_font_weight' ),
				'buttons_border_radius'                    => get_option( $this->shared->get( 'slug' ) . '_buttons_border_radius' ),
				'containers_border_radius'                 => get_option( $this->shared->get( 'slug' ) . '_containers_border_radius' ),

				// Cookie Notice --------------------------------------------------------------------------------------.
				'cookie_notice_main_message_text'          => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_main_message_text' ),
				'cookie_notice_main_message_font_color'    => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_main_message_font_color' ),
				'cookie_notice_main_message_link_font_color' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_main_message_link_font_color' ),
				'cookie_notice_button_1_text'              => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_text' ),
				'cookie_notice_button_1_action'            => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_action' ),
				'cookie_notice_button_1_url'               => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_url' ),
				'cookie_notice_button_1_background_color'  => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_background_color' ),
				'cookie_notice_button_1_background_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_background_color_hover' ),
				'cookie_notice_button_1_border_color'      => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_border_color' ),
				'cookie_notice_button_1_border_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_border_color_hover' ),
				'cookie_notice_button_1_font_color'        => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_font_color' ),
				'cookie_notice_button_1_font_color_hover'  => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_font_color_hover' ),
				'cookie_notice_button_2_text'              => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_text' ),
				'cookie_notice_button_2_action'            => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_action' ),
				'cookie_notice_button_2_url'               => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_url' ),
				'cookie_notice_button_2_background_color'  => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_background_color' ),
				'cookie_notice_button_2_background_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_background_color_hover' ),
				'cookie_notice_button_2_border_color'      => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_border_color' ),
				'cookie_notice_button_2_border_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_border_color_hover' ),
				'cookie_notice_button_2_font_color'        => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_font_color' ),
				'cookie_notice_button_2_font_color_hover'  => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_font_color_hover' ),
				'cookie_notice_button_3_text'              => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_text' ),
				'cookie_notice_button_3_action'            => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_action' ),
				'cookie_notice_button_3_url'               => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_url' ),
				'cookie_notice_button_3_background_color'  => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_background_color' ),
				'cookie_notice_button_3_background_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_background_color_hover' ),
				'cookie_notice_button_3_border_color'      => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_border_color' ),
				'cookie_notice_button_3_border_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_border_color_hover' ),
				'cookie_notice_button_3_font_color'        => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_font_color' ),
				'cookie_notice_button_3_font_color_hover'  => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_font_color_hover' ),
				'cookie_notice_button_dismiss_action'      => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_dismiss_action' ),
				'cookie_notice_button_dismiss_url'         => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_dismiss_url' ),
				'cookie_notice_button_dismiss_color'       => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_dismiss_color' ),
				'cookie_notice_container_position'         => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_position' ),
				'cookie_notice_container_width'            => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_width' ),
				'cookie_notice_container_opacity'          => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_opacity' ),
				'cookie_notice_container_border_width'     => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_border_width' ),
				'cookie_notice_container_background_color' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_background_color' ),
				'cookie_notice_container_border_color'     => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_border_color' ),
				'cookie_notice_container_border_opacity'   => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_border_opacity' ),
				'cookie_notice_container_drop_shadow'      => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_drop_shadow' ),
				'cookie_notice_container_drop_shadow_color' => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_container_drop_shadow_color' ),
				'cookie_notice_mask'                       => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_mask' ),
				'cookie_notice_mask_color'                 => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_mask_color' ),
				'cookie_notice_mask_opacity'               => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_mask_opacity' ),
				'cookie_notice_shake_effect'               => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_shake_effect' ),

				// Cookie Settings ------------------------------------------------------------------------------------.
				'cookie_settings_logo_url'                 => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_logo_url' ),
				'cookie_settings_title'                    => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_title' ),
				'cookie_settings_description_header'       => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_description_header' ),
				'cookie_settings_toggle_on_color'          => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_toggle_on_color' ),
				'cookie_settings_toggle_off_color'         => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_toggle_off_color' ),
				'cookie_settings_toggle_misc_color'        => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_toggle_misc_color' ),
				'cookie_settings_toggle_disabled_color'    => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_toggle_disabled_color' ),
				'cookie_settings_separator_color'          => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_separator_color' ),
				'cookie_settings_chevron_color'            => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_chevron_color' ),
				'cookie_settings_expand_close_color'       => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_expand_close_color' ),
				'cookie_settings_description_footer'       => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_description_footer' ),
				'cookie_settings_button_1_text'            => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_text' ),
				'cookie_settings_button_1_action'          => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_action' ),
				'cookie_settings_button_1_url'             => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_url' ),
				'cookie_settings_button_1_background_color' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_background_color' ),
				'cookie_settings_button_1_background_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_background_color_hover' ),
				'cookie_settings_button_1_border_color'    => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_border_color' ),
				'cookie_settings_button_1_border_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_border_color_hover' ),
				'cookie_settings_button_1_font_color'      => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_font_color' ),
				'cookie_settings_button_1_font_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_font_color_hover' ),
				'cookie_settings_button_2_text'            => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_text' ),
				'cookie_settings_button_2_action'          => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_action' ),
				'cookie_settings_button_2_url'             => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_url' ),
				'cookie_settings_button_2_background_color' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_background_color' ),
				'cookie_settings_button_2_background_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_background_color_hover' ),
				'cookie_settings_button_2_border_color'    => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_border_color' ),
				'cookie_settings_button_2_border_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_border_color_hover' ),
				'cookie_settings_button_2_font_color'      => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_font_color' ),
				'cookie_settings_button_2_font_color_hover' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_font_color_hover' ),
				'cookie_settings_headings_font_color'      => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_headings_font_color' ),
				'cookie_settings_paragraphs_font_color'    => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_paragraphs_font_color' ),
				'cookie_settings_links_font_color'         => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_links_font_color' ),
				'cookie_settings_container_background_color' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_container_background_color' ),
				'cookie_settings_container_opacity'        => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_container_opacity' ),
				'cookie_settings_container_border_width'   => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_container_border_width' ),
				'cookie_settings_container_border_color'   => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_container_border_color' ),
				'cookie_settings_container_border_opacity' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_container_border_opacity' ),
				'cookie_settings_container_drop_shadow'    => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_container_drop_shadow' ),
				'cookie_settings_container_drop_shadow_color' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_container_drop_shadow_color' ),
				'cookie_settings_container_highlight_color' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_container_highlight_color' ),
				'cookie_settings_mask'                     => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_mask' ),
				'cookie_settings_mask_color'               => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_mask_color' ),
				'cookie_settings_mask_opacity'             => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_mask_opacity' ),

				// Geolocation ----------------------------------------------------------------------------------------.
				'enable_geolocation'                       => get_option( $this->shared->get( 'slug' ) . '_enable_geolocation' ),
				'geolocation_behavior'                     => get_option( $this->shared->get( 'slug' ) . '_geolocation_behavior' ),
				'geolocation_service'                      => get_option( $this->shared->get( 'slug' ) . '_geolocation_service' ),
				'geolocation_locale'                       => get_option( $this->shared->get( 'slug' ) . '_geolocation_locale' ),

				// Advanced -------------------------------------------------------------------------------------------.
				'responsive_breakpoint'                    => get_option( $this->shared->get( 'slug' ) . '_responsive_breakpoint' ),
				'cookie_expiration'                        => $this->shared->get_cookie_expiration_seconds( get_option( $this->shared->get( 'slug' ) . '_cookie_expiration' ) ),
				'cookie_path_attribute'                    => get_option( $this->shared->get( 'slug' ) . '_cookie_path_attribute' ),
				'reload_page'                              => get_option( $this->shared->get( 'slug' ) . '_reload_page' ),
				'store_user_consent'                       => get_option( $this->shared->get( 'slug' ) . '_store_user_consent' ),
				'cookie_table_columns'                     => wp_json_encode( maybe_unserialize( get_option( 'daextlwcnf_cookie_table_columns' ) ) ),
				'force_css_specificity'                    => get_option( 'daextlwcnf_force_css_specificity' ),

				// The data of the sections ---------------------------------------------------------------------------.
				'section_a'                                => $section_a,

				// The cookies ----------------------------------------------------------------------------------------.
				'cookies'                                  => $cookies,

			);

			// Set the transient.
			$transient_expiration = intval(
				get_option( $this->shared->get( 'slug' ) . '_transient_expiration' ),
				10
			);
			if ( $transient_expiration > 0 ) {
				set_transient( 'daextlwcnf_data', $data, $transient_expiration );
			}
		}

		// Turn on output buffer.
		ob_start();

		?>

		<script>

			let daextLwcnReadyStateCheckInterval = setInterval(function() {
			
			if (document.readyState === "complete") {

				clearInterval(daextLwcnReadyStateCheckInterval);

				window.daextLwcnCookieNotice.initialize({

				// General --------------------------------------------------------------------------------------------.
				headingsFontFamily: <?php echo wp_json_encode( $data['headings_font_family'] ); ?>,
				headingsFontWeight: <?php echo wp_json_encode( $data['headings_font_weight'] ); ?>,
				paragraphsFontFamily: <?php echo wp_json_encode( $data['paragraphs_font_family'] ); ?>,
				paragraphsFontWeight: <?php echo wp_json_encode( $data['paragraphs_font_weight'] ); ?>,
				strongTagsFontWeight: <?php echo wp_json_encode( $data['strong_tags_font_weight'] ); ?>,
				buttonsFontFamily: <?php echo wp_json_encode( $data['buttons_font_family'] ); ?>,
				buttonsFontWeight: <?php echo wp_json_encode( $data['buttons_font_weight'] ); ?>,
				buttonsBorderRadius: <?php echo wp_json_encode( $data['buttons_border_radius'] ); ?>,
				containersBorderRadius: <?php echo wp_json_encode( $data['containers_border_radius'] ); ?>,

				// Cookie Notice --------------------------------------------------------------------------------------.
				cookieNoticeMainMessageText: <?php echo wp_json_encode( $data['cookie_notice_main_message_text'] ); ?>,
				cookieNoticeMainMessageFontColor: <?php echo wp_json_encode( $data['cookie_notice_main_message_font_color'] ); ?>,
				cookieNoticeMainMessageLinkFontColor: <?php echo wp_json_encode( $data['cookie_notice_main_message_link_font_color'] ); ?>,
				cookieNoticeButton1Text: <?php echo wp_json_encode( $data['cookie_notice_button_1_text'] ); ?>,
				cookieNoticeButton1Action: <?php echo wp_json_encode( $data['cookie_notice_button_1_action'] ); ?>,
				cookieNoticeButton1Url: <?php echo wp_json_encode( $data['cookie_notice_button_1_url'] ); ?>,
				cookieNoticeButton1BackgroundColor: <?php echo wp_json_encode( $data['cookie_notice_button_1_background_color'] ); ?>,
				cookieNoticeButton1BackgroundColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_1_background_color_hover'] ); ?>,
				cookieNoticeButton1BorderColor: <?php echo wp_json_encode( $data['cookie_notice_button_1_border_color'] ); ?>,
				cookieNoticeButton1BorderColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_1_border_color_hover'] ); ?>,
				cookieNoticeButton1FontColor: <?php echo wp_json_encode( $data['cookie_notice_button_1_font_color'] ); ?>,
				cookieNoticeButton1FontColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_1_font_color_hover'] ); ?>,
				cookieNoticeButton2Text: <?php echo wp_json_encode( $data['cookie_notice_button_2_text'] ); ?>,
				cookieNoticeButton2Action: <?php echo wp_json_encode( $data['cookie_notice_button_2_action'] ); ?>,
				cookieNoticeButton2Url: <?php echo wp_json_encode( $data['cookie_notice_button_2_url'] ); ?>,
				cookieNoticeButton2BackgroundColor: <?php echo wp_json_encode( $data['cookie_notice_button_2_background_color'] ); ?>,
				cookieNoticeButton2BackgroundColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_2_background_color_hover'] ); ?>,
				cookieNoticeButton2BorderColor: <?php echo wp_json_encode( $data['cookie_notice_button_2_border_color'] ); ?>,
				cookieNoticeButton2BorderColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_2_border_color_hover'] ); ?>,
				cookieNoticeButton2FontColor: <?php echo wp_json_encode( $data['cookie_notice_button_2_font_color'] ); ?>,
				cookieNoticeButton2FontColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_2_font_color_hover'] ); ?>,
				cookieNoticeButton3Text: <?php echo wp_json_encode( $data['cookie_notice_button_3_text'] ); ?>,
				cookieNoticeButton3Action: <?php echo wp_json_encode( $data['cookie_notice_button_3_action'] ); ?>,
				cookieNoticeButton3Url: <?php echo wp_json_encode( $data['cookie_notice_button_3_url'] ); ?>,
				cookieNoticeButton3BackgroundColor: <?php echo wp_json_encode( $data['cookie_notice_button_3_background_color'] ); ?>,
				cookieNoticeButton3BackgroundColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_3_background_color_hover'] ); ?>,
				cookieNoticeButton3BorderColor: <?php echo wp_json_encode( $data['cookie_notice_button_3_border_color'] ); ?>,
				cookieNoticeButton3BorderColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_3_border_color_hover'] ); ?>,
				cookieNoticeButton3FontColor: <?php echo wp_json_encode( $data['cookie_notice_button_3_font_color'] ); ?>,
				cookieNoticeButton3FontColorHover: <?php echo wp_json_encode( $data['cookie_notice_button_3_font_color_hover'] ); ?>,
				cookieNoticeButtonDismissAction: <?php echo wp_json_encode( $data['cookie_notice_button_dismiss_action'] ); ?>,
				cookieNoticeButtonDismissUrl: <?php echo wp_json_encode( $data['cookie_notice_button_dismiss_url'] ); ?>,
				cookieNoticeButtonDismissColor: <?php echo wp_json_encode( $data['cookie_notice_button_dismiss_color'] ); ?>,
				cookieNoticeContainerPosition: <?php echo wp_json_encode( $data['cookie_notice_container_position'] ); ?>,
				cookieNoticeContainerWidth: <?php echo wp_json_encode( $data['cookie_notice_container_width'] ); ?>,
				cookieNoticeContainerOpacity: <?php echo wp_json_encode( $data['cookie_notice_container_opacity'] ); ?>,
				cookieNoticeContainerBorderWidth: <?php echo wp_json_encode( $data['cookie_notice_container_border_width'] ); ?>,
				cookieNoticeContainerBackgroundColor: <?php echo wp_json_encode( $data['cookie_notice_container_background_color'] ); ?>,
				cookieNoticeContainerBorderColor: <?php echo wp_json_encode( $data['cookie_notice_container_border_color'] ); ?>,
				cookieNoticeContainerBorderOpacity: <?php echo wp_json_encode( $data['cookie_notice_container_border_opacity'] ); ?>,
				cookieNoticeContainerDropShadow: <?php echo wp_json_encode( $data['cookie_notice_container_drop_shadow'] ); ?>,
				cookieNoticeContainerDropShadowColor: <?php echo wp_json_encode( $data['cookie_notice_container_drop_shadow_color'] ); ?>,
				cookieNoticeMask: <?php echo wp_json_encode( $data['cookie_notice_mask'] ); ?>,
				cookieNoticeMaskColor: <?php echo wp_json_encode( $data['cookie_notice_mask_color'] ); ?>,
				cookieNoticeMaskOpacity: <?php echo wp_json_encode( $data['cookie_notice_mask_opacity'] ); ?>,
				cookieNoticeShakeEffect: <?php echo wp_json_encode( $data['cookie_notice_shake_effect'] ); ?>,

				// Cookie Settings ------------------------------------------------------------------------------------.
				cookieSettingsLogoUrl: <?php echo wp_json_encode( $data['cookie_settings_logo_url'] ); ?>,
				cookieSettingsTitle: <?php echo wp_json_encode( $data['cookie_settings_title'] ); ?>,
				cookieSettingsDescriptionHeader: <?php echo wp_json_encode( $data['cookie_settings_description_header'] ); ?>,
				cookieSettingsToggleOnColor: <?php echo wp_json_encode( $data['cookie_settings_toggle_on_color'] ); ?>,
				cookieSettingsToggleOffColor: <?php echo wp_json_encode( $data['cookie_settings_toggle_off_color'] ); ?>,
				cookieSettingsToggleMiscColor: <?php echo wp_json_encode( $data['cookie_settings_toggle_misc_color'] ); ?>,
				cookieSettingsToggleDisabledColor: <?php echo wp_json_encode( $data['cookie_settings_toggle_disabled_color'] ); ?>,
				cookieSettingsSeparatorColor: <?php echo wp_json_encode( $data['cookie_settings_separator_color'] ); ?>,
				cookieSettingsChevronColor: <?php echo wp_json_encode( $data['cookie_settings_chevron_color'] ); ?>,
				cookieSettingsExpandCloseColor: <?php echo wp_json_encode( $data['cookie_settings_expand_close_color'] ); ?>,
				cookieSettingsDescriptionFooter: <?php echo wp_json_encode( $data['cookie_settings_description_footer'] ); ?>,
				cookieSettingsButton1Text: <?php echo wp_json_encode( $data['cookie_settings_button_1_text'] ); ?>,
				cookieSettingsButton1Action: <?php echo wp_json_encode( $data['cookie_settings_button_1_action'] ); ?>,
				cookieSettingsButton1Url: <?php echo wp_json_encode( $data['cookie_settings_button_1_url'] ); ?>,
				cookieSettingsButton1BackgroundColor: <?php echo wp_json_encode( $data['cookie_settings_button_1_background_color'] ); ?>,
				cookieSettingsButton1BackgroundColorHover: <?php echo wp_json_encode( $data['cookie_settings_button_1_background_color_hover'] ); ?>,
				cookieSettingsButton1BorderColor: <?php echo wp_json_encode( $data['cookie_settings_button_1_border_color'] ); ?>,
				cookieSettingsButton1BorderColorHover: <?php echo wp_json_encode( $data['cookie_settings_button_1_border_color_hover'] ); ?>,
				cookieSettingsButton1FontColor: <?php echo wp_json_encode( $data['cookie_settings_button_1_font_color'] ); ?>,
				cookieSettingsButton1FontColorHover: <?php echo wp_json_encode( $data['cookie_settings_button_1_font_color_hover'] ); ?>,
				cookieSettingsButton2Text: <?php echo wp_json_encode( $data['cookie_settings_button_2_text'] ); ?>,
				cookieSettingsButton2Action: <?php echo wp_json_encode( $data['cookie_settings_button_2_action'] ); ?>,
				cookieSettingsButton2Url: <?php echo wp_json_encode( $data['cookie_settings_button_2_url'] ); ?>,
				cookieSettingsButton2BackgroundColor: <?php echo wp_json_encode( $data['cookie_settings_button_2_background_color'] ); ?>,
				cookieSettingsButton2BackgroundColorHover: <?php echo wp_json_encode( $data['cookie_settings_button_2_background_color_hover'] ); ?>,
				cookieSettingsButton2BorderColor: <?php echo wp_json_encode( $data['cookie_settings_button_2_border_color'] ); ?>,
				cookieSettingsButton2BorderColorHover: <?php echo wp_json_encode( $data['cookie_settings_button_2_border_color_hover'] ); ?>,
				cookieSettingsButton2FontColor: <?php echo wp_json_encode( $data['cookie_settings_button_2_font_color'] ); ?>,
				cookieSettingsButton2FontColorHover: <?php echo wp_json_encode( $data['cookie_settings_button_2_font_color_hover'] ); ?>,
				cookieSettingsHeadingsFontColor: <?php echo wp_json_encode( $data['cookie_settings_headings_font_color'] ); ?>,
				cookieSettingsParagraphsFontColor: <?php echo wp_json_encode( $data['cookie_settings_paragraphs_font_color'] ); ?>,
				cookieSettingsLinksFontColor: <?php echo wp_json_encode( $data['cookie_settings_links_font_color'] ); ?>,
				cookieSettingsContainerBackgroundColor: <?php echo wp_json_encode( $data['cookie_settings_container_background_color'] ); ?>,
				cookieSettingsContainerOpacity: <?php echo wp_json_encode( $data['cookie_settings_container_opacity'] ); ?>,
				cookieSettingsContainerBorderWidth: <?php echo wp_json_encode( $data['cookie_settings_container_border_width'] ); ?>,
				cookieSettingsContainerBorderColor: <?php echo wp_json_encode( $data['cookie_settings_container_border_color'] ); ?>,
				cookieSettingsContainerBorderOpacity: <?php echo wp_json_encode( $data['cookie_settings_container_border_opacity'] ); ?>,
				cookieSettingsContainerDropShadow: <?php echo wp_json_encode( $data['cookie_settings_container_drop_shadow'] ); ?>,
				cookieSettingsContainerDropShadowColor: <?php echo wp_json_encode( $data['cookie_settings_container_drop_shadow_color'] ); ?>,
				cookieSettingsContainerHighlightColor: <?php echo wp_json_encode( $data['cookie_settings_container_highlight_color'] ); ?>,
				cookieSettingsMask: <?php echo wp_json_encode( $data['cookie_settings_mask'] ); ?>,
				cookieSettingsMaskColor: <?php echo wp_json_encode( $data['cookie_settings_mask_color'] ); ?>,
				cookieSettingsMaskOpacity: <?php echo wp_json_encode( $data['cookie_settings_mask_opacity'] ); ?>,

				// Revisit Consent ------------------------------------------------------------------------------------.
				revisitConsentButtonEnable: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_revisit_consent_button_enable' ) ); ?>,
				revisitConsentButtonTooltipText: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_revisit_consent_button_tooltip_text' ) ); ?>,
				revisitConsentButtonPosition: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_revisit_consent_button_position' ) ); ?>,
				revisitConsentButtonBackgroundColor: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_revisit_consent_button_background_color' ) ); ?>,
				revisitConsentButtonIconColor: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_revisit_consent_button_icon_color' ) ); ?>,

				// Geolocation ----------------------------------------------------------------------------------------.
				enableGeolocation: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_enable_geolocation' ) ); ?>,
				geolocationBehavior: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_geolocation_behavior' ) ); ?>,
				geolocationService: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_geolocation_service' ) ); ?>,
				geolocationLocale: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_geolocation_locale' ) ); ?>,

				// Advanced -------------------------------------------------------------------------------------------.
				responsiveBreakpoint: <?php echo wp_json_encode( get_option( $this->shared->get( 'slug' ) . '_responsive_breakpoint' ) ); ?>,
				cookieExpiration: <?php echo wp_json_encode( $data['cookie_expiration'] ); ?>,
				cookiePathAttribute: <?php echo wp_json_encode( $data['cookie_path_attribute'] ); ?>,
				reloadPage: <?php echo wp_json_encode( $data['reload_page'] ); ?>,
				storeUserConsent: <?php echo wp_json_encode( $data['store_user_consent'] ); ?>,
				cookieTableColumns: <?php echo wp_json_encode( $data['cookie_table_columns'] ); ?>,
				forceCssSpecificity: <?php echo wp_json_encode( $data['force_css_specificity'] ); ?>,

				// The data of the sections ---------------------------------------------------------------------------.
				sections: <?php echo wp_json_encode( $data['section_a'] ); ?>,

				// The cookies ----------------------------------------------------------------------------------------.
				cookies: <?php echo wp_json_encode( $data['cookies'] ); ?>,

				});
			   
			}
			}, 10);

		</script>

		<?php

		$out = ob_get_clean();

		// Compress javascript if the specific option is enabled.
		if ( intval( get_option( $this->shared->get( 'slug' ) . '_compress_output' ), 10 ) === 1 ) {
			$out = \JShrink\Minifier::minify( $out );
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- This is necessary because the output is compressed by JShrink after being created.
		echo $out;
	}

	/**
	 * Print the scripts in the HTML head element with PHP.
	 */
	public function print_head_scripts() {

		daextlwcnf_print_scripts( false );
	}

	/**
	 * Print the scripts in the HTML head element with PHP.
	 *
	 * This method runs only when W3 Total Cache is active and uses the "Page Fragment Cache" feature:
	 *
	 * Ref: https://github.com/W3EDGE/w3-total-cache/wiki/FAQ:-Developers#what-is-page-fragment-cache
	 */
	public function print_head_scripts_w3tc() {

		?>

		<!-- mfunc daextlwcnf -->
		daextlwcnf_print_scripts(false);
		<!-- /mfunc daextlwcnf -->

		<?php
	}

	/**
	 * Print the scripts at the end of the HTML body element with PHP.
	 */
	public function print_body_scripts() {

		daextlwcnf_print_scripts( true );
	}

	/**
	 * Print the scripts at the end of the HTML body element with PHP.
	 *
	 * This method runs only when W3 Total Cache is active and uses the "Page Fragment Cache" feature:
	 *
	 * Ref: https://github.com/W3EDGE/w3-total-cache/wiki/FAQ:-Developers#what-is-page-fragment-cache
	 */
	public function print_body_scripts_w3tc() {

		?>

		<!-- mfunc daextlwcnf -->
		daextlwcnf_print_scripts(true);
		<!-- /mfunc daextlwcnf -->

		<?php
	}

	/**
	 * Add the cookies in WP Super Cache.
	 *
	 * Ref: https://odd.blog/2018/07/20/wp-super-cache-and-cookie-banners/
	 */
	public function wpsc_add_cookie() {
		do_action( 'wpsc_add_cookie', 'daextlwcnf-accepted' );
	}
}
