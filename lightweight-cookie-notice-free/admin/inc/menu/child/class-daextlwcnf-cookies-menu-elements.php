<?php
/**
 * Class used to implement the back-end functionalities of the "cookies" menu.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * Class used to implement the back-end functionalities of the "cookies" menu.
 */
class Daextlwcnf_Cookies_Menu_Elements extends Daextlwcnf_Menu_Elements {

	/**
	 * Daextlwcnf_Dashboard_Menu_Elements constructor.
	 *
	 * @param object $shared The shared class.
	 * @param string $page_query_param The page query parameter.
	 * @param string $config The config parameter.
	 */
	public function __construct( $shared, $page_query_param, $config ) {

		parent::__construct( $shared, $page_query_param, $config );

		$this->menu_slug          = 'cookie';
		$this->slug_plural        = 'cookies';
		$this->label_singular     = __( 'Cookie', 'lightweight-cookie-notice-free' );
		$this->label_plural       = __( 'Cookies', 'lightweight-cookie-notice-free' );
		$this->primary_key        = 'cookie_id';
		$this->db_table           = 'cookie';
		$this->list_table_columns = array(
			array(
				'db_field' => 'name',
				'label'    => __( 'Name', 'lightweight-cookie-notice-free' ),
			),
		);
		$this->searchable_fields  = array(
			'name',
		);

		$this->default_values = array(
			'name'                    => '',
			'expiration'              => '',
			'purpose'                 => '',
			'priority'                => 0,
			'category_id'             => 0,
			'provider'                => '',
			'domain'                  => '',
			'type'                    => '',
			'sensitivity'             => '',
			'security'                => '',
			'cookie_domain_attribute' => '',
			'cookie_path_attribute'   => '/',
		);
	}

	/**
	 * Process the add/edit form submission of the menu. Specifically the following tasks are performed:
	 *
	 * 1. Sanitization
	 * 2. Validation
	 * 3. Database update
	 *
	 * @return void
	 */
	public function process_form() {

		if ( isset( $_POST['update_id'] ) ||
			isset( $_POST['form_submitted'] ) ) {

			// Nonce verification.
			check_admin_referer( 'daextlwcnf_create_update_' . $this->menu_slug, 'daextlwcnf_create_update_' . $this->menu_slug . '_nonce' );

		}

		// Preliminary operations ---------------------------------------------------------------------------------------------.
		global $wpdb;

		// Sanitization -------------------------------------------------------------------------------------------------------.

		$data = array();

		// Actions.
		$data['update_id']      = isset( $_POST['update_id'] ) ? intval( $_POST['update_id'], 10 ) : null;
		$data['form_submitted'] = isset( $_POST['form_submitted'] ) ? intval( $_POST['form_submitted'], 10 ) : null;

		// Sanitization.
		if ( ! is_null( $data['update_id'] ) || ! is_null( $data['form_submitted'] ) ) {

			$data['name']     = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : null;
			$data['provider'] = isset( $_POST['provider'] ) ? sanitize_text_field( wp_unslash( $_POST['provider'] ) ) : null;
			$data['domain']   = isset( $_POST['domain'] ) ? sanitize_text_field( wp_unslash( $_POST['domain'] ) ) : null;

			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- A limited set of HTML tags are allowed to give the user the ability to format the text.
			$data['purpose'] = isset( $_POST['purpose'] ) ? $this->shared->apply_custom_kses( wp_unslash( $_POST['purpose'] ) ) : null;

			$data['expiration'] = isset( $_POST['expiration'] ) ? sanitize_text_field( wp_unslash( $_POST['expiration'] ) ) : null;
			$data['type']       = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : null;

			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- A limited set of HTML tags are allowed to give the user the ability to format the text.
			$data['sensitivity'] = isset( $_POST['sensitivity'] ) ? sanitize_text_field( wp_unslash( $_POST['sensitivity'] ) ) : null;

			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- A limited set of HTML tags are allowed to give the user the ability to format the text.
			$data['security'] = isset( $_POST['security'] ) ? sanitize_text_field( wp_unslash( $_POST['security'] ) ) : null;

			$data['category_id']             = isset( $_POST['category_id'] ) ? intval( $_POST['category_id'], 10 ) : null;
			$data['priority']                = isset( $_POST['priority'] ) ? intval( $_POST['priority'], 10 ) : null;
			$data['cookie_domain_attribute'] = isset( $_POST['cookie_domain_attribute'] ) ? sanitize_text_field( wp_unslash( $_POST['cookie_domain_attribute'] ) ) : null;
			$data['cookie_path_attribute']   = isset( $_POST['cookie_path_attribute'] ) ? sanitize_text_field( wp_unslash( $_POST['cookie_path_attribute'] ) ) : null;

		}

		// Validation ---------------------------------------------------------------------------------------------------------.
		if ( ! is_null( $data['update_id'] ) || ! is_null( $data['form_submitted'] ) ) {

			// Validation on "name".
			if ( mb_strlen( trim( $data['name'] ) ) === 0 || mb_strlen( trim( $data['name'] ) ) > 255 ) {
				$this->shared->save_dismissible_notice(
					__( 'Please enter a valid value in the "Name" field.', 'lightweight-cookie-notice-free' ),
					'error'
				);
				$invalid_data = true;
			}

			// Validation on "expiration".
			if ( mb_strlen( trim( $data['expiration'] ) ) === 0 || mb_strlen( trim( $data['expiration'] ) ) > 255 ) {
				$this->shared->save_dismissible_notice(
					__( 'Please enter a valid value in the "Expiration" field.', 'lightweight-cookie-notice-free' ),
					'error'
				);
				$invalid_data = true;
			}

			// Validation on "purpose".
			if ( mb_strlen( trim( $data['purpose'] ) ) === 0 || mb_strlen( trim( $data['purpose'] ) ) > 100000 ) {
				$this->shared->save_dismissible_notice(
					__( 'Please enter a valid value in the "Purpose" field.', 'lightweight-cookie-notice-free' ),
					'error'
				);
				$invalid_data = true;
			}
		}

		// Database record update -------------------------------------------------------------------------------------.
		if ( ! is_null( $data['update_id'] ) && ! isset( $invalid_data ) ) {

			// Update the database.

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$query_result = $wpdb->query(
				$wpdb->prepare(
					"UPDATE {$wpdb->prefix}daextlwcnf_cookie SET 
		                provider = %s,
		                domain = %s,
		                name = %s,
		                purpose = %s,
		                expiration = %s,
		                type = %s,
		                sensitivity = %s,
		                security = %s,
		                category_id = %d,
		                priority = %d,
		                cookie_domain_attribute = %s,
		                cookie_path_attribute = %s
		                WHERE cookie_id = %d",
					$data['provider'],
					$data['domain'],
					$data['name'],
					$data['purpose'],
					$data['expiration'],
					$data['type'],
					$data['sensitivity'],
					$data['security'],
					$data['category_id'],
					$data['priority'],
					$data['cookie_domain_attribute'],
					$data['cookie_path_attribute'],
					$data['update_id']
				)
			);

			if ( false !== $query_result ) {
				$this->shared->save_dismissible_notice(
					__( 'The cookie has been successfully updated.', 'lightweight-cookie-notice-free' ),
					'updated'
				);
			}
		} elseif ( ! is_null( $data['form_submitted'] ) && ! isset( $invalid_data ) ) {

			// Add record to database ------------------------------------------------------------------------------------.

				// insert into the database.

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$query_result = $wpdb->query(
					$wpdb->prepare(
						"INSERT INTO {$wpdb->prefix}daextlwcnf_cookie SET
							provider = %s,
			                domain = %s,
			                name = %s,
			                purpose = %s,
			                expiration = %s,
			                type = %s,
			                sensitivity = %s,
			                security = %s,
			                category_id = %d,
			                priority = %d,
                            cookie_domain_attribute = %s,
                            cookie_path_attribute = %s",
						$data['provider'],
						$data['domain'],
						$data['name'],
						$data['purpose'],
						$data['expiration'],
						$data['type'],
						$data['sensitivity'],
						$data['security'],
						$data['category_id'],
						$data['priority'],
						$data['cookie_domain_attribute'],
						$data['cookie_path_attribute']
					)
				);

			if ( false !== $query_result ) {
				$this->shared->save_dismissible_notice(
					__( 'The cookie has been successfully added.', 'lightweight-cookie-notice-free' ),
					'updated'
				);
			}
		}
	}

	/**
	 * Defines the form fields present in the add/edit form and call the method to print them.
	 *
	 * @param array $item_obj The item object.
	 *
	 * @return void
	 */
	public function print_form_fields( $item_obj = null ) {

		global $wpdb;

		// Get the term groups.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$category_a = $wpdb->get_results(
			"SELECT category_id, name FROM {$wpdb->prefix}daextlwcnf_category ORDER BY category_id DESC",
			ARRAY_A
		);

		$category_a_option_value      = array();
		$category_a_option_value['0'] = __( 'None', 'lightweight-cookie-notice-free' );
		foreach ( $category_a as $key => $value ) {
			$category_a_option_value[ $value['category_id'] ] = $value['name'];
		}

		// Add the form data in the $cookies array.
		$cookies = array(
			array(
				'label'          => __( 'Main', 'lightweight-cookie-notice-free' ),
				'section_id'     => 'main',
				'display_header' => false,
				'fields'         => array(
					array(
						'type'        => 'text',
						'name'        => 'name',
						'label'       => __( 'Name', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the name of the cookie.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['name'] : $this->default_values['name'],
						'maxlength'   => 255,
						'required'    => true,
					),
					array(
						'type'        => 'text',
						'name'        => 'expiration',
						'label'       => __( 'Expiration', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the expiration of the cookie.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['expiration'] : $this->default_values['expiration'],
						'maxlength'   => 255,
						'required'    => true,
					),
					array(
						'type'        => 'textarea',
						'name'        => 'purpose',
						'label'       => __( 'Purpose', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the purpose of the cookie.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['purpose'] : $this->default_values['purpose'],
						'maxlength'   => 100000,
						'required'    => true,
					),
					array(
						'type'        => 'select',
						'name'        => 'category_id',
						'label'       => __( 'Category', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Select the category associated with the cookie.', 'lightweight-cookie-notice-free' ),
						'options'     => $category_a_option_value,
						'value'       => isset( $item_obj ) ? $item_obj['category_id'] : $this->default_values['category_id'],
					),
				),
			),
			array(
				'label'          => __( 'Attributes (Display)', 'lightweight-cookie-notice-free' ),
				'section_id'     => 'cookie-attributes-display',
				'icon_id'        => 'file-code-01',
				'display_header' => true,
				'fields'         => array(
					array(
						'type'        => 'text',
						'name'        => 'provider',
						'label'       => __( 'Provider', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the provider of the cookie.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['provider'] : $this->default_values['provider'],
						'maxlength'   => 255,
						'required'    => false,
					),
					array(
						'type'        => 'text',
						'name'        => 'domain',
						'label'       => __( 'Domain', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the domain of the cookie.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['domain'] : $this->default_values['domain'],
						'maxlength'   => 255,
						'required'    => false,
					),
					array(
						'type'        => 'text',
						'name'        => 'type',
						'label'       => __( 'Type', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the type of the cookie.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['type'] : $this->default_values['type'],
						'maxlength'   => 255,
						'required'    => false,
					),
					array(
						'type'        => 'text',
						'name'        => 'sensitivity',
						'label'       => __( 'Sensitivity', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the expiration of the cookie.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['sensitivity'] : $this->default_values['sensitivity'],
						'maxlength'   => 255,
						'required'    => false,
					),
					array(
						'type'        => 'text',
						'name'        => 'security',
						'label'       => __( 'Security', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the security of the cookie.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['security'] : $this->default_values['security'],
						'maxlength'   => 255,
						'required'    => false,
					),
				),
			),
			array(
				'label'          => __( 'Attributes (Deletion)', 'lightweight-cookie-notice-free' ),
				'section_id'     => 'cookie-attributes-deletion',
				'icon_id'        => 'trash-01',
				'display_header' => true,
				'fields'         => array(
					array(
						'type'        => 'text',
						'name'        => 'cookie_domain_attribute',
						'label'       => __( 'Domain', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the cookie domain attribute used for the automatic cookie deletion.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['cookie_domain_attribute'] : $this->default_values['cookie_domain_attribute'],
						'maxlength'   => 255,
						'required'    => false,
					),
					array(
						'type'        => 'text',
						'name'        => 'cookie_path_attribute',
						'label'       => __( 'Path', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the cookie path attribute used for the automatic cookie deletion.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['cookie_path_attribute'] : $this->default_values['cookie_path_attribute'],
						'maxlength'   => 255,
						'required'    => false,
					),
				),
			),
			array(
				'label'          => __( 'Advanced', 'lightweight-cookie-notice-free' ),
				'section_id'     => 'advanced',
				'icon_id'        => 'settings-01',
				'display_header' => true,
				'fields'         => array(
					array(
						'type'        => 'input_range',
						'name'        => 'priority',
						'label'       => __( 'Priority', 'lightweight-cookie-notice-free' ),
						'description' => __( 'The priority value determines the order used to display the cookies.', 'lightweight-cookie-notice-free' ),
						'value'       => isset( $item_obj ) ? $item_obj['priority'] : $this->default_values['priority'],
						'min'         => 0,
						'max'         => 100,
					),
				),
			),
		);

		$this->print_form_fields_from_array( $cookies );
	}

	/**
	 * Check if the item is deletable. If not, return the message to be displayed.
	 *
	 * @param int $item_id The ID of the item to be checked.
	 *
	 * @return array
	 */
	public function item_is_deletable( $item_id ) {

		$is_deletable               = true;
		$dismissible_notice_message = null;

		return array(
			'is_deletable'               => $is_deletable,
			'dismissible_notice_message' => $dismissible_notice_message,
		);
	}
}
