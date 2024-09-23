<?php
/**
 * Here the REST API endpoint of the plugin are registered.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * This class should be used to work with the REST API endpoints of the plugin.
 */
class Daextlwcnf_Rest {

	/**
	 * The singleton instance of the class.
	 *
	 * @var null
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

		// Assign an instance of the shared class.
		$this->shared = Daextlwcnf_Shared::get_instance();

		/**
		 * Add custom routes to the Rest API.
		 */
		add_action( 'rest_api_init', array( $this, 'rest_api_register_route' ) );
	}

	/**
	 * Create a singleton instance of the class.
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
	 * Add custom routes to the Rest API.
	 *
	 * @return void
	 */
	public function rest_api_register_route() {

		// Add the GET 'lightweight-cookie-notice-free/v1/options' endpoint to the Rest API.
		register_rest_route(
			'lightweight-cookie-notice-free/v1',
			'/read-options/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'rest_api_daext_lightweight_cookie_notice_pro_read_options_callback' ),
				'permission_callback' => array( $this, 'rest_api_daext_lightweight_cookie_notice_pro_read_options_callback_permission_check' ),
			)
		);

		// Add the POST 'lightweight-cookie-notice-free/v1/options' endpoint to the Rest API.
		register_rest_route(
			'lightweight-cookie-notice-free/v1',
			'/options',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'rest_api_daext_lightweight_cookie_notice_pro_update_options_callback' ),
				'permission_callback' => array( $this, 'rest_api_daext_lightweight_cookie_notice_pro_update_options_callback_permission_check' ),

			)
		);

		// Add the POST 'lightweight-cookie-notice-free/v1/consent-log/' endpoint to the Rest API.
		register_rest_route(
			'lightweight-cookie-notice-free/v1',
			'/consent-log/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'rest_api_daext_lightweight_cookie_notice_read_statistics_callback' ),
				'permission_callback' => array( $this, 'rest_api_daext_lightweight_cookie_notice_read_statistics_callback_permission_check' ),
			)
		);
	}

	/**
	 * Callback for the GET 'lightweight-cookie-notice-free/v1/options' endpoint of the Rest API.
	 *
	 * @return WP_REST_Response
	 */
	public function rest_api_daext_lightweight_cookie_notice_pro_read_options_callback() {

		// Generate the response.
		$response = array();
		foreach ( $this->shared->get( 'options' ) as $key => $value ) {
			$response[ $key ] = get_option( $key );
		}

		// Prepare the response.
		$response = new WP_REST_Response( $response );

		return $response;
	}

	/**
	 * Check the user capability.
	 *
	 * @return true|WP_Error
	 */
	public function rest_api_daext_lightweight_cookie_notice_pro_read_options_callback_permission_check() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error(
				'rest_read_error',
				'Sorry, you are not allowed to read the Lightweight Cookie Notice options.',
				array( 'status' => 403 )
			);
		}

		return true;
	}

	/**
	 * Callback for the POST 'lightweight-cookie-notice/v1/options' endpoint of the Rest API.
	 *
	 * This method is in the following contexts:
	 *
	 *  - To update the plugin options in the "Options" menu.
	 *
	 * @param object $request The request data.
	 *
	 * @return WP_REST_Response
	 */
	public function rest_api_daext_lightweight_cookie_notice_pro_update_options_callback( $request ) {

		// Get and sanitize data --------------------------------------------------------------------------------------.

		$options = array();

		// Get and sanitize data --------------------------------------------------------------------------------------.

		// Content - Tab -------------------------------------------------------------------------------------------------.

		// Cookie Notice - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_cookie_notice_main_message_text']     = $request->get_param( 'daextlwcnf_cookie_notice_main_message_text' ) !== null ? $this->shared->apply_custom_kses( $request->get_param( 'daextlwcnf_cookie_notice_main_message_text' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_1_text']         = $request->get_param( 'daextlwcnf_cookie_notice_button_1_text' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_1_text' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_1_action']       = $request->get_param( 'daextlwcnf_cookie_notice_button_1_action' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_notice_button_1_action' ), 10 ) : null;
		$options['daextlwcnf_cookie_notice_button_1_url']          = $request->get_param( 'daextlwcnf_cookie_notice_button_1_url' ) !== null ? esc_url_raw( $request->get_param( 'daextlwcnf_cookie_notice_button_1_url' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_2_text']         = $request->get_param( 'daextlwcnf_cookie_notice_button_2_text' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_2_text' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_2_action']       = $request->get_param( 'daextlwcnf_cookie_notice_button_2_action' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_notice_button_2_action' ), 20 ) : null;
		$options['daextlwcnf_cookie_notice_button_2_url']          = $request->get_param( 'daextlwcnf_cookie_notice_button_2_url' ) !== null ? esc_url_raw( $request->get_param( 'daextlwcnf_cookie_notice_button_2_url' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_3_text']         = $request->get_param( 'daextlwcnf_cookie_notice_button_3_text' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_3_text' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_3_action']       = $request->get_param( 'daextlwcnf_cookie_notice_button_3_action' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_notice_button_3_action' ), 30 ) : null;
		$options['daextlwcnf_cookie_notice_button_3_url']          = $request->get_param( 'daextlwcnf_cookie_notice_button_3_url' ) !== null ? esc_url_raw( $request->get_param( 'daextlwcnf_cookie_notice_button_3_url' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_dismiss_action'] = $request->get_param( 'daextlwcnf_cookie_notice_button_dismiss_action' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_notice_button_dismiss_action' ), 10 ) : null;
		$options['daextlwcnf_cookie_notice_button_dismiss_url']    = $request->get_param( 'daextlwcnf_cookie_notice_button_dismiss_url' ) !== null ? esc_url_raw( $request->get_param( 'daextlwcnf_cookie_notice_button_dismiss_url' ) ) : null;
		$options['daextlwcnf_cookie_notice_shake_effect']          = $request->get_param( '_cookie_notice_shake_effect' ) !== null ? intval( $request->get_param( '_cookie_notice_shake_effect' ), 10 ) : null;

		// Cookie Settings - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_cookie_settings_logo_url']           = $request->get_param( 'daextlwcnf_cookie_settings_logo_url' ) !== null ? esc_url_raw( $request->get_param( 'daextlwcnf_cookie_settings_logo_url' ) ) : null;
		$options['daextlwcnf_cookie_settings_title']              = $request->get_param( 'daextlwcnf_cookie_settings_title' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_title' ) ) : null;
		$options['daextlwcnf_cookie_settings_description_header'] = $request->get_param( 'daextlwcnf_cookie_settings_description_header' ) !== null ? $this->shared->apply_custom_kses( $request->get_param( 'daextlwcnf_cookie_settings_description_header' ) ) : null;
		$options['daextlwcnf_cookie_settings_description_footer'] = $request->get_param( 'daextlwcnf_cookie_settings_description_footer' ) !== null ? $this->shared->apply_custom_kses( $request->get_param( 'daextlwcnf_cookie_settings_description_footer' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_1_text']      = $request->get_param( 'daextlwcnf_cookie_settings_button_1_text' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_1_text' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_1_action']    = $request->get_param( 'daextlwcnf_cookie_settings_button_1_action' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_settings_button_1_action' ), 10 ) : null;
		$options['daextlwcnf_cookie_settings_button_1_url']       = $request->get_param( 'daextlwcnf_cookie_settings_button_1_url' ) !== null ? esc_url_raw( $request->get_param( 'daextlwcnf_cookie_settings_button_1_url' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_2_text']      = $request->get_param( 'daextlwcnf_cookie_settings_button_2_text' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_2_text' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_2_action']    = $request->get_param( 'daextlwcnf_cookie_settings_button_2_action' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_settings_button_2_action' ), 20 ) : null;
		$options['daextlwcnf_cookie_settings_button_2_url']       = $request->get_param( 'daextlwcnf_cookie_settings_button_2_url' ) !== null ? esc_url_raw( $request->get_param( 'daextlwcnf_cookie_settings_button_2_url' ) ) : null;

		// Revisit Consent - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_revisit_consent_button_enable']       = $request->get_param( 'daextlwcnf_revisit_consent_button_enable' ) !== null ? intval( $request->get_param( 'daextlwcnf_revisit_consent_button_enable' ), 10 ) : null;
		$options['daextlwcnf_revisit_consent_button_tooltip_text'] = $request->get_param( 'daextlwcnf_revisit_consent_button_tooltip_text' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_revisit_consent_button_tooltip_text' ) ) : null;

		// Style - Tab -------------------------------------------------------------------------------------------------.

		// General - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_headings_font_family']     = $request->get_param( 'daextlwcnf_headings_font_family' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_headings_font_family' ) ) : null;
		$options['daextlwcnf_headings_font_weight']     = $request->get_param( 'daextlwcnf_headings_font_weight' ) !== null ? intval( $request->get_param( 'daextlwcnf_headings_font_weight' ), 10 ) : null;
		$options['daextlwcnf_paragraphs_font_family']   = $request->get_param( 'daextlwcnf_paragraphs_font_family' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_paragraphs_font_family' ) ) : null;
		$options['daextlwcnf_paragraphs_font_weight']   = $request->get_param( 'daextlwcnf_paragraphs_font_weight' ) !== null ? intval( $request->get_param( 'daextlwcnf_paragraphs_font_weight' ), 10 ) : null;
		$options['daextlwcnf_strong_tags_font_weight']  = $request->get_param( 'daextlwcnf_strong_tags_font_weight' ) !== null ? intval( $request->get_param( 'daextlwcnf_strong_tags_font_weight' ), 10 ) : null;
		$options['daextlwcnf_buttons_font_family']      = $request->get_param( 'daextlwcnf_buttons_font_family' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_buttons_font_family' ) ) : null;
		$options['daextlwcnf_buttons_font_weight']      = $request->get_param( 'daextlwcnf_buttons_font_weight' ) !== null ? intval( $request->get_param( 'daextlwcnf_buttons_font_weight' ), 10 ) : null;
		$options['daextlwcnf_buttons_border_radius']    = $request->get_param( 'daextlwcnf_buttons_border_radius' ) !== null ? intval( $request->get_param( 'daextlwcnf_buttons_border_radius' ), 10 ) : null;
		$options['daextlwcnf_containers_border_radius'] = $request->get_param( 'daextlwcnf_containers_border_radius' ) !== null ? intval( $request->get_param( 'daextlwcnf_containers_border_radius' ), 10 ) : null;

		// Cookie Notice - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_cookie_notice_main_message_font_color']      = $request->get_param( 'daextlwcnf_cookie_notice_main_message_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_main_message_font_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_main_message_link_font_color'] = $request->get_param( 'daextlwcnf_cookie_notice_main_message_link_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_main_message_link_font_color' ) ) : null;

		$options['daextlwcnf_cookie_notice_button_1_background_color']       = $request->get_param( 'daextlwcnf_cookie_notice_button_1_background_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_1_background_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_1_background_color_hover'] = $request->get_param( 'daextlwcnf_cookie_notice_button_1_background_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_1_background_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_1_border_color']           = $request->get_param( 'daextlwcnf_cookie_notice_button_1_border_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_1_border_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_1_border_color_hover']     = $request->get_param( 'daextlwcnf_cookie_notice_button_1_border_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_1_border_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_1_font_color']             = $request->get_param( 'daextlwcnf_cookie_notice_button_1_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_1_font_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_1_font_color_hover']       = $request->get_param( 'daextlwcnf_cookie_notice_button_1_font_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_1_font_color_hover' ) ) : null;

		$options['daextlwcnf_cookie_notice_button_2_background_color']       = $request->get_param( 'daextlwcnf_cookie_notice_button_2_background_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_2_background_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_2_background_color_hover'] = $request->get_param( 'daextlwcnf_cookie_notice_button_2_background_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_2_background_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_2_border_color']           = $request->get_param( 'daextlwcnf_cookie_notice_button_2_border_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_2_border_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_2_border_color_hover']     = $request->get_param( 'daextlwcnf_cookie_notice_button_2_border_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_2_border_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_2_font_color']             = $request->get_param( 'daextlwcnf_cookie_notice_button_2_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_2_font_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_2_font_color_hover']       = $request->get_param( 'daextlwcnf_cookie_notice_button_2_font_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_2_font_color_hover' ) ) : null;

		$options['daextlwcnf_cookie_notice_button_3_background_color']       = $request->get_param( 'daextlwcnf_cookie_notice_button_3_background_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_3_background_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_3_background_color_hover'] = $request->get_param( 'daextlwcnf_cookie_notice_button_3_background_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_3_background_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_3_border_color']           = $request->get_param( 'daextlwcnf_cookie_notice_button_3_border_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_3_border_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_3_border_color_hover']     = $request->get_param( 'daextlwcnf_cookie_notice_button_3_border_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_3_border_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_3_font_color']             = $request->get_param( 'daextlwcnf_cookie_notice_button_3_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_3_font_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_button_3_font_color_hover']       = $request->get_param( 'daextlwcnf_cookie_notice_button_3_font_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_3_font_color_hover' ) ) : null;

		$options['daextlwcnf_cookie_notice_button_dismiss_color']        = $request->get_param( 'daextlwcnf_cookie_notice_button_dismiss_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_button_dismiss_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_container_position']          = $request->get_param( 'daextlwcnf_cookie_notice_container_position' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_notice_container_position' ), 10 ) : null;
		$options['daextlwcnf_cookie_notice_container_width']             = $request->get_param( 'daextlwcnf_cookie_notice_container_width' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_notice_container_width' ), 10 ) : null;
		$options['daextlwcnf_cookie_notice_container_background_color']  = $request->get_param( 'daextlwcnf_cookie_notice_container_background_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_container_background_color' ), 10 ) : null;
		$options['daextlwcnf_cookie_notice_container_opacity']           = $request->get_param( 'daextlwcnf_cookie_notice_container_opacity' ) !== null ? floatval( $request->get_param( 'daextlwcnf_cookie_notice_container_opacity' ) ) : null;
		$options['daextlwcnf_cookie_notice_container_border_width']      = $request->get_param( 'daextlwcnf_cookie_notice_container_border_width' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_notice_container_border_width' ), 10 ) : null;
		$options['daextlwcnf_cookie_notice_container_border_color']      = $request->get_param( 'daextlwcnf_cookie_notice_container_border_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_container_border_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_container_border_opacity']    = $request->get_param( 'daextlwcnf_cookie_notice_container_border_opacity' ) !== null ? floatval( $request->get_param( 'daextlwcnf_cookie_notice_container_border_opacity' ) ) : null;
		$options['daextlwcnf_cookie_notice_container_drop_shadow']       = $request->get_param( 'daextlwcnf_cookie_notice_container_drop_shadow' ) !== null ? floatval( $request->get_param( 'daextlwcnf_cookie_notice_container_drop_shadow' ) ) : null;
		$options['daextlwcnf_cookie_notice_container_drop_shadow_color'] = $request->get_param( 'daextlwcnf_cookie_notice_container_drop_shadow_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_container_drop_shadow_color' ) ) : null;
		$options['daextlwcnf_cookie_notice_mask']                        = $request->get_param( 'daextlwcnf_cookie_notice_mask' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_notice_mask' ), 10 ) : null;
		$options['daextlwcnf_cookie_notice_mask_color']                  = $request->get_param( 'daextlwcnf_cookie_notice_mask_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_notice_mask_color' ), 10 ) : null;
		$options['daextlwcnf_cookie_notice_mask_opacity']                = $request->get_param( 'daextlwcnf_cookie_notice_mask_opacity' ) !== null ? floatval( $request->get_param( 'daextlwcnf_cookie_notice_mask_opacity' ) ) : null;

		// Cookie Notice - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_cookie_settings_button_1_background_color']       = $request->get_param( 'daextlwcnf_cookie_settings_button_1_background_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_1_background_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_1_background_color_hover'] = $request->get_param( 'daextlwcnf_cookie_settings_button_1_background_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_1_background_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_1_border_color']           = $request->get_param( 'daextlwcnf_cookie_settings_button_1_border_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_1_border_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_1_border_color_hover']     = $request->get_param( 'daextlwcnf_cookie_settings_button_1_border_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_1_border_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_1_font_color']             = $request->get_param( 'daextlwcnf_cookie_settings_button_1_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_1_font_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_1_font_color_hover']       = $request->get_param( 'daextlwcnf_cookie_settings_button_1_font_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_1_font_color_hover' ) ) : null;

		$options['daextlwcnf_cookie_settings_button_2_background_color']       = $request->get_param( 'daextlwcnf_cookie_settings_button_2_background_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_2_background_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_2_background_color_hover'] = $request->get_param( 'daextlwcnf_cookie_settings_button_2_background_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_2_background_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_2_border_color']           = $request->get_param( 'daextlwcnf_cookie_settings_button_2_border_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_2_border_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_2_border_color_hover']     = $request->get_param( 'daextlwcnf_cookie_settings_button_2_border_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_2_border_color_hover' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_2_font_color']             = $request->get_param( 'daextlwcnf_cookie_settings_button_2_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_2_font_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_button_2_font_color_hover']       = $request->get_param( 'daextlwcnf_cookie_settings_button_2_font_color_hover' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_button_2_font_color_hover' ) ) : null;

		$options['daextlwcnf_cookie_settings_headings_font_color']         = $request->get_param( 'daextlwcnf_cookie_settings_headings_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_headings_font_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_paragraphs_font_color']       = $request->get_param( 'daextlwcnf_cookie_settings_paragraphs_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_paragraphs_font_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_links_font_color']            = $request->get_param( 'daextlwcnf_cookie_settings_links_font_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_links_font_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_container_background_color']  = $request->get_param( 'daextlwcnf_cookie_settings_container_background_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_container_background_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_container_opacity']           = $request->get_param( 'daextlwcnf_cookie_settings_container_opacity' ) !== null ? floatval( $request->get_param( 'daextlwcnf_cookie_settings_container_opacity' ) ) : null;
		$options['daextlwcnf_cookie_settings_container_border_width']      = $request->get_param( 'daextlwcnf_cookie_settings_container_border_width' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_settings_container_border_width' ), 10 ) : null;
		$options['daextlwcnf_cookie_settings_container_border_color']      = $request->get_param( 'daextlwcnf_cookie_settings_container_border_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_container_border_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_container_border_opacity']    = $request->get_param( 'daextlwcnf_cookie_settings_container_border_opacity' ) !== null ? floatval( $request->get_param( 'daextlwcnf_cookie_settings_container_border_opacity' ) ) : null;
		$options['daextlwcnf_cookie_settings_container_drop_shadow']       = $request->get_param( 'daextlwcnf_cookie_settings_container_drop_shadow' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_settings_container_drop_shadow' ), 10 ) : null;
		$options['daextlwcnf_cookie_settings_container_drop_shadow_color'] = $request->get_param( 'daextlwcnf_cookie_settings_container_drop_shadow_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_container_drop_shadow_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_container_highlight_color']   = $request->get_param( 'daextlwcnf_cookie_settings_container_highlight_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_container_highlight_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_separator_color']             = $request->get_param( 'daextlwcnf_cookie_settings_separator_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_separator_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_mask']                        = $request->get_param( 'daextlwcnf_cookie_settings_mask' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_mask' ) ) : null;
		$options['daextlwcnf_cookie_settings_mask_color']                  = $request->get_param( 'daextlwcnf_cookie_settings_mask_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_settings_mask_color' ) ) : null;
		$options['daextlwcnf_cookie_settings_mask_opacity']                = $request->get_param( 'daextlwcnf_cookie_settings_mask_opacity' ) !== null ? floatval( $request->get_param( 'daextlwcnf_cookie_settings_mask_opacity' ) ) : null;

		// Revisit Consent - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_revisit_consent_button_position']         = $request->get_param( 'daextlwcnf_revisit_consent_button_position' ) !== null ? sanitize_key( $request->get_param( 'daextlwcnf_revisit_consent_button_position' ) ) : null;
		$options['daextlwcnf_revisit_consent_button_background_color'] = $request->get_param( 'daextlwcnf_revisit_consent_button_background_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_revisit_consent_button_background_color' ) ) : null;
		$options['daextlwcnf_revisit_consent_button_icon_color']       = $request->get_param( 'daextlwcnf_revisit_consent_button_icon_color' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_revisit_consent_button_icon_color' ) ) : null;

		// Geolocation - Tab --------------------------------------------------------------------------------------.

		// General - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_enable_geolocation']   = $request->get_param( 'daextlwcnf_enable_geolocation' ) !== null ? intval( $request->get_param( 'daextlwcnf_enable_geolocation' ), 10 ) : null;
		$options['daextlwcnf_geolocation_behavior'] = $request->get_param( 'daextlwcnf_geolocation_behavior' ) !== null ? intval( $request->get_param( 'daextlwcnf_geolocation_behavior' ), 10 ) : null;
		$options['daextlwcnf_geolocation_service']  = $request->get_param( 'daextlwcnf_geolocation_service' ) !== null ? intval( $request->get_param( 'daextlwcnf_geolocation_service' ), 10 ) : null;
		$options['daextlwcnf_geolocation_locale']   = $request->get_param( 'daextlwcnf_geolocation_locale' ) !== null ? $request->get_param( 'daextlwcnf_geolocation_locale' ) : null;

		// Maxmind GeoLite2 - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_geolocation_subdivision']         = $request->get_param( 'daextlwcnf_geolocation_subdivision' ) !== null ? $request->get_param( 'daextlwcnf_geolocation_subdivision' ) : null;
		$options['daextlwcnf_maxmind_database_file_path']      = $request->get_param( 'daextlwcnf_maxmind_database_file_path' ) !== null ? $request->get_param( 'daextlwcnf_maxmind_database_file_path' ) : null;
		$options['daextlwcnf_maxmind_database_city_file_path'] = $request->get_param( 'daextlwcnf_maxmind_database_city_file_path' ) !== null ? $request->get_param( 'daextlwcnf_maxmind_database_city_file_path' ) : null;

		// Advanced - Tab --------------------------------------------------------------------------------------.

		// Behavior - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_assets_mode']                          = $request->get_param( 'daextlwcnf_assets_mode' ) !== null ? intval( $request->get_param( 'daextlwcnf_assets_mode' ), 10 ) : null;
		$options['daextlwcnf_test_mode']                            = $request->get_param( 'daextlwcnf_test_mode' ) !== null ? intval( $request->get_param( 'daextlwcnf_test_mode' ), 10 ) : null;
		$options['daextlwcnf_reload_page']                          = $request->get_param( 'daextlwcnf_reload_page' ) !== null ? intval( $request->get_param( 'daextlwcnf_reload_page' ), 10 ) : null;
		$options['daextlwcnf_store_user_consent']                   = $request->get_param( 'daextlwcnf_store_user_consent' ) !== null ? intval( $request->get_param( 'daextlwcnf_store_user_consent' ), 10 ) : null;
		$options['daextlwcnf_transient_expiration']                 = $request->get_param( 'daextlwcnf_transient_expiration' ) !== null ? intval( $request->get_param( 'daextlwcnf_transient_expiration' ), 10 ) : null;
		$options['daextlwcnf_page_fragment_caching_exception_w3tc'] = $request->get_param( 'daextlwcnf_page_fragment_caching_exception_w3tc' ) !== null ? intval( $request->get_param( 'daextlwcnf_page_fragment_caching_exception_w3tc' ), 10 ) : null;
		$options['daextlwcnf_max_displayed_consent_log_records'] = $request->get_param( 'daextlwcnf_max_displayed_consent_log_records' ) !== null ? intval( $request->get_param( 'daextlwcnf_max_displayed_consent_log_records' ), 10 ) : null;

		// Content - Section --------------------------------------------------------------------------------------.
		$options['daextlwcnf_google_font_url']       = $request->get_param( 'daextlwcnf_google_font_url' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_google_font_url' ) ) : null;
		$options['daextlwcnf_responsive_breakpoint'] = $request->get_param( 'daextlwcnf_responsive_breakpoint' ) !== null ? intval( $request->get_param( 'daextlwcnf_responsive_breakpoint' ), 10 ) : null;
		$options['daextlwcnf_cookie_table_columns']  = $request->get_param( 'daextlwcnf_cookie_table_columns' ) !== null ? $request->get_param( 'daextlwcnf_cookie_table_columns' ) : null;
		$options['daextlwcnf_force_css_specificity'] = $request->get_param( 'daextlwcnf_force_css_specificity' ) !== null ? intval( $request->get_param( 'daextlwcnf_force_css_specificity' ), 10 ) : null;
		$options['daextlwcnf_compress_output']       = $request->get_param( 'daextlwcnf_compress_output' ) !== null ? intval( $request->get_param( 'daextlwcnf_compress_output' ), 10 ) : null;

		// Cookie Attributes - Section --------------------------------------------------------------------------------.
		$options['daextlwcnf_cookie_expiration']     = $request->get_param( 'daextlwcnf_cookie_expiration' ) !== null ? intval( $request->get_param( 'daextlwcnf_cookie_expiration' ), 10 ) : null;
		$options['daextlwcnf_cookie_path_attribute'] = $request->get_param( 'daextlwcnf_cookie_path_attribute' ) !== null ? sanitize_text_field( $request->get_param( 'daextlwcnf_cookie_path_attribute' ) ) : null;

		// Update the options -----------------------------------------------------------------------------------------.
		foreach ( $options as $key => $option ) {
			if ( null !== $option ) {
				update_option( $key, $option );
			}
		}

		$response = new WP_REST_Response( 'Data successfully added.', '200' );

		return $response;
	}

	/**
	 * Check the user capability.
	 *
	 * @return true|WP_Error
	 */
	public function rest_api_daext_lightweight_cookie_notice_pro_update_options_callback_permission_check() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error(
				'rest_update_error',
				'Sorry, you are not allowed to update the Lightweight Cookie Notice options.',
				array( 'status' => 403 )
			);
		}

		return true;
	}

	/**
	 * Callback for the POST 'lightweight-cookie-notice-free/v1/statistics' endpoint of the Rest API.
	 *
	 * This method is in the following contexts:
	 *
	 * - In the "Dashboard" menu to retrieve the statistics of the links on the posts.
	 *
	 * @param object $request The request data.
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function rest_api_daext_lightweight_cookie_notice_read_statistics_callback( $request ) {

		$data_update_required = intval( $request->get_param( 'data_update_required' ), 10 );

		if ( 0 === $data_update_required ) {

			// Use the provided form data.
			$search_string  = sanitize_text_field( $request->get_param( 'search_string' ) );
			$sorting_column = sanitize_text_field( $request->get_param( 'sorting_column' ) );
			$sorting_order  = sanitize_text_field( $request->get_param( 'sorting_order' ) );

		} else {

			// Set the default values of the form data.
			$search_string  = '';
			$sorting_column = 'date';
			$sorting_order  = 'desc';

		}

		// Create the WHERE part of the query based on the $optimization_status value.
		global $wpdb;
		$filter = '';

		// Create the WHERE part of the string based on the $search_string value.
		if ( '' !== $search_string ) {
			if ( strlen( $filter ) === 0 ) {
				$filter .= $wpdb->prepare( 'WHERE (url LIKE %s)', '%' . $search_string . '%' );
			} else {
				$filter .= $wpdb->prepare( ' AND (url LIKE %s)', '%' . $search_string . '%' );

			}
		}

		// Create the ORDER BY part of the query based on the $sorting_column and $sorting_order values.
		if ( '' !== $sorting_column ) {
			$filter .= ' ORDER BY ' . sanitize_key( $sorting_column );
		} else {
			$filter .= ' ORDER BY date';
		}

		if ( 'desc' === $sorting_order ) {
			$filter .= ' DESC';
		} else {
			$filter .= ' ASC';
		}

		// Get the data from the "_archive" db table using $wpdb and put them in the $response array.

		$offset = 0;
		$limit = 100; // Set the limit to 100 records per iteration.
		$max = intval(get_option($this->shared->get( 'slug' ) . '_max_displayed_consent_log_records'), 10); // Set the maximum number of records to fetch.
		$all_requests = array(); // Initialize an array to hold all requests.

		// Attempt to increase the memory limit.
		wp_raise_memory_limit();

		do {

			// Fetch the records in batches of 100.

			// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- $filter is prepared.
			// phpcs:disable WordPress.DB.DirectDatabaseQuery
			$requests = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT consent_log_id, anonymized_user_ip, date, user_agent, url, encrypted_key, country_code, state, consent_id FROM {$wpdb->prefix}daextlwcnf_consent_log $filter LIMIT %d OFFSET %d",
					$limit,
					$offset
				)
			);
			// phpcs:enable

			if ( is_array( $requests ) && count( $requests ) > 0 ) {

				foreach ( $requests as $key => $request ) {

					/**
					 * Add the formatted date (based on the date format defined in the WordPress settings) to the $requests
					 * array.
					 */
					$request->formatted_date = mysql2date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $request->date );

					/**
					 * Decode, decompress, and truncate the state string for display purposes. -----------------------------
					 */

					// Decode the base64 encoded string.
					// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- Base64 decode is required.
					$compressed_string = base64_decode( $request->state );

					// Decompress the string.
					$original_string = gzuncompress( $compressed_string );

					// Truncate the $original_string var for display purposes.
					$request->formatted_state           = $original_string;
					$request->formatted_state_truncated = substr( $original_string, 0, 100 ) . '...';

					// Append the processed request to the all_requests array.
					$all_requests[] = $request;

				}

				// Increase the offset for the next batch.
				$offset += $limit;

				// Exit if the maximum number of records has been reached.
				if($offset >= $max) {
					break;
				}

			}

		} while ( count( $requests ) > 0 );

		if ( count( $all_requests ) > 0 ) {

			$response = array(
				'statistics' => array(
					'all_records'     => count( $all_requests ),
					'acceptance_rate' => $this->shared->get_acceptance_rate( $all_requests ),
				),
				'table'      => $all_requests,
			);


		} else {

			$response = array(
				'statistics' => array(
					'all_records'     => 0,
					'acceptance_rate' => 'N/A',
				),
				'table'      => array(),
			);

		}

		// Prepare the response.
		$response = new WP_REST_Response( $response );

		return $response;
	}

	/**
	 * Check the user capability.
	 *
	 * @return true|WP_Error
	 */
	public function rest_api_daext_lightweight_cookie_notice_read_statistics_callback_permission_check() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error(
				'rest_update_error',
				'Sorry, you are not allowed to read the Lightweight Cookie Notice statistics.',
				array( 'status' => 403 )
			);
		}

		return true;
	}
}
