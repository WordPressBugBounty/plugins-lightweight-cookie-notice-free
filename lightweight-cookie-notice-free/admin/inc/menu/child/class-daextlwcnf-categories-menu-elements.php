<?php
/**
 * Class used to implement the back-end functionalities of the "Categories" menu.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * Class used to implement the back-end functionalities of the "Categories" menu.
 */
class Daextlwcnf_Categories_Menu_Elements extends Daextlwcnf_Menu_Elements {

	/**
	 * Daextlwcnf_Dashboard_Menu_Elements constructor.
	 *
	 * @param object $shared The shared class.
	 * @param string $page_query_param The page query parameter.
	 * @param string $config The config parameter.
	 */
	public function __construct( $shared, $page_query_param, $config ) {

		parent::__construct( $shared, $page_query_param, $config );

		$this->menu_slug          = 'category';
		$this->slug_plural        = 'categories';
		$this->label_singular     = __( 'Category', 'lightweight-cookie-notice-free' );
		$this->label_plural       = __( 'Categories', 'lightweight-cookie-notice-free' );
		$this->primary_key        = 'category_id';
		$this->db_table           = 'category';
		$this->list_table_columns = array(
			array(
				'db_field' => 'name',
				'label'    => __( 'Name', 'lightweight-cookie-notice-free' ),
			),
			array(
				'db_field'                => 'section_id',
				'label'                   => 'Section',
				'prepare_displayed_value' => array( $shared, 'get_section_name' ),
			),
			array(
				'db_field'                => 'category_id',
				'label'                   => 'Acceptance Rate',
				'prepare_displayed_value' => array( $shared, 'get_acceptance_rate_of_category' ),
			),
		);
		$this->searchable_fields  = array(
			'name',
			'description',
		);

		$this->default_values = array(
			'name'           => '',
			'description'    => '',
			'section_id'     => 0,
			'priority'       => 0,
			'toggle'         => 1,
			'default_status' => 1,
			'script_head'    => '',
			'script_body'    => '',
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

			$data['name']           = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : null;
			$data['description']    = isset( $_POST['description'] ) ? sanitize_text_field( wp_unslash( $_POST['description'] ) ) : null;
			$data['toggle']         = isset( $_POST['toggle'] ) ? 1 : 0;
			$data['default_status'] = isset( $_POST['default_status'] ) ? 1 : 0;
			$data['priority']       = isset( $_POST['priority'] ) ? intval( $_POST['priority'], 10 ) : null;
			$data['script_head']    = isset( $_POST['script_head'] ) ? wp_unslash( $_POST['script_head'] ) : null;
			$data['script_body']    = isset( $_POST['script_body'] ) ? wp_unslash( $_POST['script_body'] ) : null;
			$data['section_id']     = isset( $_POST['section_id'] ) ? intval( $_POST['section_id'], 10 ) : null;

		}

		// Validation ---------------------------------------------------------------------------------------------------------.
		if ( ! is_null( $data['update_id'] ) || ! is_null( $data['form_submitted'] ) ) {

			$invalid_data_message = '';

			// Validation on "name".
			if ( mb_strlen( trim( $data['name'] ) ) === 0 || mb_strlen( trim( $data['name'] ) ) > 100 ) {
				$this->shared->save_dismissible_notice(
					__( 'Please enter a valid value in the "Name" field.', 'lightweight-cookie-notice-free' ),
					'error'
				);
				$invalid_data = true;
			}

			// Validation on "description".
			if ( mb_strlen( trim( $data['description'] ) ) === 0 || mb_strlen( trim( $data['description'] ) ) > 255 ) {
				$this->shared->save_dismissible_notice(
					__( 'Please enter a valid value in the "Description" field.', 'lightweight-cookie-notice-free' ),
					'error'
				);
				$invalid_data = true;
			}

			// Validation on "priority".
			if ( $data['priority'] < 0 || $data['priority'] > 100 ) {
				$this->shared->save_dismissible_notice(
					__( 'Please enter a valid value in the "Priority" field.', 'lightweight-cookie-notice-free' ),
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
					"UPDATE {$wpdb->prefix}daextlwcnf_category SET 
		                name = %s,
		                description = %s,
		                toggle = %d,
		                default_status = %d,
		                priority = %d,
		                script_head = %s,
		                script_body = %s,
		                section_id = %d
		                WHERE category_id = %d",
					$data['name'],
					$data['description'],
					$data['toggle'],
					$data['default_status'],
					$data['priority'],
					$data['script_head'],
					$data['script_body'],
					$data['section_id'],
					$data['update_id']
				)
			);

			if ( false !== $query_result ) {
				$this->shared->save_dismissible_notice(
					__( 'The category has been successfully updated.', 'lightweight-cookie-notice-free' ),
					'updated'
				);
			}
		} elseif ( ! is_null( $data['form_submitted'] ) && ! isset( $invalid_data ) ) {

			// Add record to database ------------------------------------------------------------------------------------.

				// insert into the database.

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$query_result = $wpdb->query(
					$wpdb->prepare(
						"INSERT INTO {$wpdb->prefix}daextlwcnf_category SET           name = %s,
			                description = %s,
			                toggle = %d,
			                default_status = %d,
			                priority = %d,
			                script_head = %s,
			                script_body = %s,
			                section_id = %d",
						$data['name'],
						$data['description'],
						$data['toggle'],
						$data['default_status'],
						$data['priority'],
						$data['script_head'],
						$data['script_body'],
						$data['section_id'],
					)
				);

			if ( false !== $query_result ) {
				$this->shared->save_dismissible_notice(
					__( 'The category has been successfully added.', 'lightweight-cookie-notice-free' ),
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
		$section_a = $wpdb->get_results(
			"SELECT section_id, name FROM {$wpdb->prefix}daextlwcnf_section ORDER BY section_id DESC",
			ARRAY_A
		);

		$section_a_option_value      = array();
		$section_a_option_value['0'] = __( 'None', 'lightweight-cookie-notice-free' );
		foreach ( $section_a as $key => $value ) {
			$section_a_option_value[ $value['section_id'] ] = $value['name'];
		}

		// Add the form data in the $categories array.
		$categories = array(
			array(
				'label'          => __( 'Main', 'lightweight-cookie-notice-free' ),
				'section_id'     => 'main',
				'display_header' => false,
				'fields'         => array(
					array(
						'type'        => 'text',
						'name'        => 'name',
						'label'       => __( 'Name', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the name of the category.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['name'] : null,
						'maxlength'   => 100,
						'required'    => true,
					),
					array(
						'type'        => 'textarea',
						'name'        => 'description',
						'label'       => __( 'Description', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the description of the category.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['description'] : null,
						'maxlength'   => 100000,
						'required'    => true,
					),
					array(
						'type'        => 'select',
						'name'        => 'section_id',
						'label'       => __( 'Section', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Select the section where the category will be displayed.', 'lightweight-cookie-notice-free' ),
						'options'     => $section_a_option_value,
						'value'       => isset( $item_obj ) ? $item_obj['section_id'] : $this->default_values['section_id'],
					),
					array(
						'type'        => 'toggle',
						'name'        => 'toggle',
						'label'       => __( 'Active Toggle', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enable the toggle used to activate or deactivate this category.', 'lightweight-cookie-notice-free' ),
						'value'       => isset( $item_obj ) ? $item_obj['toggle'] : $this->default_values['toggle'],
					),
					array(
						'type'        => 'toggle',
						'name'        => 'default_status',
						'label'       => __( 'Initial State', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Make this category enabled by default.', 'lightweight-cookie-notice-free' ),
						'value'       => isset( $item_obj ) ? $item_obj['default_status'] : $this->default_values['default_status'],
					),
				),
			),
			array(
				'label'          => __( 'Code Snippets', 'lightweight-cookie-notice-free' ),
				'section_id'     => 'code-snippets',
				'icon_id'        => 'code-browser',
				'display_header' => true,
				'fields'         => array(
					array(
						'type'        => 'textarea',
						'name'        => 'script_head',
						'label'       => __( 'HTML Head', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the HTML that will be added to the page HEAD section if the user has given consent.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['script_head'] : $this->default_values['script_head'],
						'maxlength'   => 100000,
						'required'    => false,
					),
					array(
						'type'        => 'textarea',
						'name'        => 'script_body',
						'label'       => __( 'HTML Body', 'lightweight-cookie-notice-free' ),
						'description' => __( 'Enter the HTML that will be added to the page BODY section if the user has given consent.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['script_body'] : $this->default_values['script_body'],
						'maxlength'   => 100000,
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
						'description' => __( 'The priority value determines the order used to display the sections.', 'lightweight-cookie-notice-free' ),
						'value'       => isset( $item_obj ) ? $item_obj['priority'] : $this->default_values['priority'],
						'min'         => 0,
						'max'         => 100,
					),
				),
			),
		);

		$this->print_form_fields_from_array( $categories );
	}

	/**
	 * Check if the item is deletable. If not, return the message to be displayed.
	 *
	 * @param int $item_id The ID of the item to be checked.
	 *
	 * @return array
	 */
	public function item_is_deletable( $item_id ) {

		if ( $this->shared->category_is_used_in_cookies( $item_id ) ) {
			$is_deletable               = false;
			$dismissible_notice_message = __( "This category is associated with one or more cookies and can't be deleted.", 'lightweight-cookie-notice-free' );
		} else {
			$is_deletable               = true;
			$dismissible_notice_message = null;
		}

		return array(
			'is_deletable'               => $is_deletable,
			'dismissible_notice_message' => $dismissible_notice_message,
		);
	}
}
