<?php
/**
 * Class used to implement the back-end functionalities of the "Sections" menu.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * Class used to implement the back-end functionalities of the "Sections" menu.
 */
class Daextlwcnf_Sections_Menu_Elements extends Daextlwcnf_Menu_Elements {

	/**
	 * Daextlwcnf_Dashboard_Menu_Elements constructor.
	 *
	 * @param object $shared The shared class.
	 * @param string $page_query_param The page query parameter.
	 * @param string $config The config parameter.
	 */
	public function __construct( $shared, $page_query_param, $config ) {

		parent::__construct( $shared, $page_query_param, $config );

		$this->menu_slug          = 'section';
		$this->slug_plural        = 'sections';
		$this->label_singular     = __( 'Section', 'lightweight-cookie-notice-free' );
		$this->label_plural       = __( 'Sections', 'lightweight-cookie-notice-free' );
		$this->primary_key        = 'section_id';
		$this->db_table           = 'section';
		$this->list_table_columns = array(
			array(
				'db_field' => 'name',
				'label'    => __( 'Name', 'lightweight-cookie-notice-free' ),
			),
			array(
				'db_field' => 'description',
				'label'    => __( 'Description', 'lightweight-cookie-notice-free' ),
			),
		);
		$this->searchable_fields  = array(
			'name',
			'description',
		);

		$this->default_values = array(
			'name'        => '',
			'description' => '',
			'priority'    => 0,
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

			$data['name']        = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : null;
			$data['description'] = isset( $_POST['description'] ) ? sanitize_text_field( wp_unslash( $_POST['description'] ) ) : null;
			$data['priority']    = isset( $_POST['priority'] ) ? intval( $_POST['priority'], 10 ) : null;

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
					"UPDATE {$wpdb->prefix}daextlwcnf_section SET 
		                name = %s,
		                description = %s,
		                priority = %d
		                WHERE section_id = %d",
					$data['name'],
					$data['description'],
					$data['priority'],
					$data['update_id']
				)
			);

			if ( false !== $query_result ) {
				$this->shared->save_dismissible_notice(
					__( 'The section has been successfully updated.', 'lightweight-cookie-notice-free' ),
					'updated'
				);
			}
		} elseif ( ! is_null( $data['form_submitted'] ) && ! isset( $invalid_data ) ) {

			// Add record to database ------------------------------------------------------------------------------------.

				// insert into the database.

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$query_result = $wpdb->query(
					$wpdb->prepare(
						"INSERT INTO {$wpdb->prefix}daextlwcnf_section SET 
			                name = %s,
			                description = %s,
                            priority = %d",
						$data['name'],
						$data['description'],
						$data['priority']
					)
				);

			if ( false !== $query_result ) {
				$this->shared->save_dismissible_notice(
					__( 'The section has been successfully added.', 'lightweight-cookie-notice-free' ),
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

		// Add the form data in the $sections array.
		$sections = array(
			array(
				'label'          => __( 'Main', 'lightweight-cookie-notice-free' ),
				'section_id'     => 'main',
				'display_header' => false,
				'fields'         => array(
					array(
						'type'        => 'text',
						'name'        => 'name',
						'label'       => __( 'Name', 'lightweight-cookie-notice-free' ),
						'description' => __( 'The name of the section.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['name'] : null,
						'maxlength'   => 100,
						'required'    => true,
					),
					array(
						'type'        => 'textarea',
						'name'        => 'description',
						'label'       => __( 'Description', 'lightweight-cookie-notice-free' ),
						'description' => __( 'The description of the section.', 'lightweight-cookie-notice-free' ),
						'placeholder' => '',
						'value'       => isset( $item_obj ) ? $item_obj['description'] : null,
						'maxlength'   => 100000,
						'required'    => true,
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

		$this->print_form_fields_from_array( $sections );
	}

	/**
	 * Check if the item is deletable. If not, return the message to be displayed.
	 *
	 * @param int $item_id The ID of the item to be checked.
	 *
	 * @return array
	 */
	public function item_is_deletable( $item_id ) {

		if ( $this->shared->section_is_used_in_categories( $item_id ) ) {
			$is_deletable               = false;
			$dismissible_notice_message = __( "This section is associated with one or more categories and can't be deleted.", 'lightweight-cookie-notice-free' );
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
