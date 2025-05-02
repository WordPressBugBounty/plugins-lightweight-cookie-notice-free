<?php
/**
 * This class should be used to include ajax actions.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * Class Daextlwcnf_Ajax
 *
 * This class should be used to include ajax actions.
 */
class Daextlwcnf_Ajax {

	/**
	 * The instance of the Daextulmap_Ajax class.
	 *
	 * @var Daextulmap_Ajax
	 */
	protected static $instance = null;

	/**
	 * The instance of the Daextulmap_Shared class.
	 *
	 * @var Daextulmap_Shared
	 */
	private $shared = null;

	/**
	 * The constructor of the Daextulmap_Ajax class.
	 */
	private function __construct() {

		// Assign an instance of the plugin info.
		$this->shared = Daextlwcnf_Shared::get_instance();

		// Ajax requests for logged-in and not logged-in users.
		add_action( 'wp_ajax_daextlwcnf_geolocate_user', array( $this, 'daextlwcnf_geolocate_user' ) );
		add_action( 'wp_ajax_nopriv_daextlwcnf_geolocate_user', array( $this, 'daextlwcnf_geolocate_user' ) );
		add_action(
			'wp_ajax_nopriv_daextlwcnf_save_consent_log',
			array( $this, 'daextlwcnf_save_consent_log' )
		);
		add_action(
			'wp_ajax_daextlwcnf_save_consent_log',
			array( $this, 'daextlwcnf_save_consent_log' )
		);

		// AJAX requests for logged-in users.
		add_action( 'wp_ajax_daextlwcnf_get_category_data', array( $this, 'daextlwcnf_get_category_data' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return Daextulmap_Ajax|self|null
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Geolocate the user by using a database stored in the web server of the website.
	 *
	 * The following geolocation databases are currently supported:
	 *
	 * - MaxMind GeoLite2
	 */
	public function daextlwcnf_geolocate_user() {

		// Check the referer.
		if ( ! check_ajax_referer( 'daextlwcnf', 'security', false ) ) {
			echo 'Invalid AJAX Request';
			die();
		}

		$ip_address = $this->shared->get_ip_address();

		switch ( intval( get_option( $this->shared->get( 'slug' ) . '_geolocation_service' ), 10 ) ) {

			// MaxMind GeoLite2.
			case 1:
				$country_code = $this->shared->get_country_code_from_ip( $ip_address );
				$city         = $this->shared->get_city_from_ip( $ip_address );

				if ( $this->shared->is_valid_locale_maxmind_geolite2( $country_code, $city ) ) {
					$result = true;
				} else {
					$result = false;
				}

				break;

			// Default.
			default:
				/**
				 * Note: There are no other geolocation services that verifies the country in the back-end available at
				 * the moment. HostIP.info verifies the country in the front-end using JavaScript and an AJAX request
				 * to the HostIP.info API.
				 */

				$result = true;
				break;

		}

		$result = $result ? '1' : '0';

		// Generate the json output from the tab array.
		echo wp_json_encode(
			array(
				'country_code' => null !== $country_code ? $country_code : '',
				'result'       => $result,
			)
		);

		die();
	}

	/**
	 * Save the acceptance statistic for all the cookie categories.
	 */
	public function daextlwcnf_save_consent_log() {

		// Check the referer.
		if ( ! check_ajax_referer( 'daextlwcnf', 'security', false ) ) {
			echo 'Invalid AJAX Request';
			die();
		}

		// Save the consolidated consent.
		$consent_id         = $this->shared->generate_consent_id();
		$anonymized_user_ip = $this->shared->get_anonymized_ip_address();
		$date               = current_time( 'mysql', true );
		$user_agent         = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
		$url                = isset( $_POST['url'] ) ? esc_url_raw( wp_unslash( $_POST['url'] ) ) : '';
		$country_code       = isset( $_POST['country_code'] ) ? sanitize_text_field( wp_unslash( $_POST['country_code'] ) ) : '';

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- The sanitization is performed in sanitize_category_state().
		$category_cookies = isset( $_POST['category_cookies'] ) ? $this->shared->sanitize_category_state( wp_unslash( $_POST['category_cookies'] ) ) : '';

		// Compress the state value ----------------------------------------------------------------------------------.

		$res = $this->shared->get_cookie_notice_data();

		/**
		 * Relevant options used to determine the text and choices presented to the users as part of the cookie
		 * mechanism.
		 */
		$options = array(
			'cookie_notice_main_message_text'    => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_main_message_text' ),
			'cookie_notice_button_1_text'        => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_1_text' ),
			'cookie_notice_button_2_text'        => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_2_text' ),
			'cookie_notice_button_3_text'        => get_option( $this->shared->get( 'slug' ) . '_cookie_notice_button_3_text' ),
			'cookie_settings_description_header' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_description_header' ),
			'cookie_settings_description_footer' => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_description_footer' ),
			'cookie_settings_button_1_text'      => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_1_text' ),
			'cookie_settings_button_2_text'      => get_option( $this->shared->get( 'slug' ) . '_cookie_settings_button_2_text' ),
		);

		$state = array(
			'category_cookies' => $category_cookies,
			'section_a'        => $res['section_a'],
			'options'          => $options,
		);

		$state = wp_json_encode( $state );

		$encrypted_key = hash( 'sha512', $state );

		// Compress the string with maximum compression level (9).
		$compressed_string = gzcompress( $state, 9 );

		// Optionally, base64 encode the compressed string to ensure it can be safely stored in a text field.
		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- base64_encode9() is necessary to make the binary data generated with gzcompress() safe for storage in a database field.
		$state = base64_encode( $compressed_string );

		// Save these data in the "_consent_log" table.
		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$query_result = $wpdb->query(
			$wpdb->prepare(
				"INSERT INTO {$wpdb->prefix}daextlwcnf_consent_log SET 
			consent_id = %s,
			anonymized_user_ip = %s,
			date = %s,
			user_agent = %s,
			url = %s,
			encrypted_key = %s,
			country_code = %s,
			state = %s",
				$consent_id,
				$anonymized_user_ip,
				$date,
				$user_agent,
				$url,
				$encrypted_key,
				$country_code,
				$state
			)
		);

		// Generate the response and terminate the script.
		echo esc_html( $encrypted_key );
		die();
	}

	/**
	 * Method used in the GenericReactSelect component of the "Cookies" Gutenberg blocks.
	 *
	 * A JSON string that includes name and ID of all the categories is returned.
	 */
	public function daextlwcnf_get_category_data() {

		// Check the referer.
		if ( ! check_ajax_referer( 'daextlwcnf', 'security', false ) ) {
			echo 'Invalid AJAX Request';
			die();
		}

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$category_a = $wpdb->get_results(
			"SELECT category_id, name FROM {$wpdb->prefix}daextlwcnf_category ORDER BY category_id DESC",
			ARRAY_A
		);

		// Change the indexes to meet the requirements of the GenericReactSelect component.
		foreach ( $category_a as $key => $category ) {
			$category_a[ $key ]['value'] = $category['category_id'];
			$category_a[ $key ]['label'] = stripslashes( $category['name'] );
			unset( $category_a[ $key ]['category_id'] );
			unset( $category_a[ $key ]['name'] );
		}

		// Set the default value at the beginning of the array.
		array_unshift(
			$category_a,
			array(
				'value' => '0',
				'label' => __( 'All', 'lightweight-cookie-notice-free' ),
			)
		);

		// Generate the response and terminate the script.
		echo wp_json_encode( $category_a );
		die();
	}
}
