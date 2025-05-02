<?php
/**
 * Class used to implement the back-end functionalities of the "Maintenance" menu.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * Class used to implement the back-end functionalities of the "Maintenance" menu.
 */
class Daextlwcnf_Maintenance_Menu_Elements extends Daextlwcnf_Menu_Elements {

	/**
	 * Constructor.
	 *
	 * @param object $shared The shared class.
	 * @param string $page_query_param The page query parameter.
	 * @param string $config The config parameter.
	 */
	public function __construct( $shared, $page_query_param, $config ) {

		parent::__construct( $shared, $page_query_param, $config );

		$this->menu_slug      = 'maintenance';
		$this->slug_plural    = 'maintenance';
		$this->label_singular = __( 'Maintenance', 'lightweight-cookie-notice-free' );
		$this->label_plural   = __( 'Maintenance', 'lightweight-cookie-notice-free' );
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

		// Preliminary operations ---------------------------------------------------------------------------------------------.
		global $wpdb;

		if ( isset( $_POST['form_submitted'] ) ) {

			// Nonce verification.
			check_admin_referer( 'daextlwcnf_execute_task', 'daextlwcnf_execute_task_nonce' );

			// Sanitization ---------------------------------------------------------------------------------------------------.
			$data['task'] = isset( $_POST['task'] ) ? intval( $_POST['task'], 10 ) : null;

			// Validation -----------------------------------------------------------------------------------------------------.

			$invalid_data_message = '';
			$invalid_data         = false;

			if ( false === $invalid_data ) {

				switch ( $data['task'] ) {

					// Reset Plugin.
					case 0:
						// Delete the records of all the database tables of the plugin.
						$this->shared->reset_plugin_database_tables();

						// Set the default values of the options.
						$this->shared->reset_plugin_options();

						$this->shared->save_dismissible_notice(
							__( 'The plugin data have been successfully deleted.', 'lightweight-cookie-notice-free' ),
							'updated'
						);

						break;

					// Delete consolidated consent.
					case 1:
						// Delete data in the 'consent_log' table.
						global $wpdb;

						// phpcs:ignore WordPress.DB.DirectDatabaseQuery
						$query_result = $wpdb->query( "DELETE FROM {$wpdb->prefix}daextlwcnf_consent_log" );

						$this->shared->save_dismissible_notice(
							__( 'The consolidated consent statistics have been deleted.', 'lightweight-cookie-notice-free' ),
							'updated'
						);

						break;

					// Delete Transient.
					case 2:
						$result = delete_transient( 'daextlwcnf_data' );

						// Generate message.
						if ( $result ) {
							$this->shared->save_dismissible_notice(
								__( 'The transient has been successfully deleted.', 'lightweight-cookie-notice-free' ),
								'updated'
							);
						} else {
							$this->shared->save_dismissible_notice(
								__( 'There is no transient at the moment.', 'lightweight-cookie-notice-free' ),
								'error'
							);
						}

						break;

				}
			}
		}
	}

	/**
	 * Display the form.
	 *
	 * @return void
	 */
	public function display_custom_content() {

		?>

		<div class="daextlwcnf-admin-body">

			<?php

			// Display the dismissible notices.
			$this->shared->display_dismissible_notices();

			?>

			<div class="daextlwcnf-main-form">

				<form id="form-maintenance" method="POST"
						action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-maintenance"
						autocomplete="off">

				<div class="daextlwcnf-main-form__daext-form-section">

					<div class="daextlwcnf-main-form__daext-form-section-body">

							<input type="hidden" value="1" name="form_submitted">

							<?php wp_nonce_field( 'daextlwcnf_execute_task', 'daextlwcnf_execute_task_nonce' ); ?>

							<?php

							// Task.
							$this->select_field(
								'task',
								'Task',
								__( 'The task that should be performed.', 'lightweight-cookie-notice-free' ),
								array(
									'0' => __( 'Reset Plugin', 'lightweight-cookie-notice-free' ),
									'1' => __( 'Reset Consent Log', 'lightweight-cookie-notice-free' ),
									'2' => __( 'Delete Transient', 'lightweight-cookie-notice-free' ),
								),
								null,
								'main'
							);

							?>

							<!-- submit button -->
							<div class="daext-form-action">
								<input id="execute-task" class="daextlwcnf-btn daextlwcnf-btn-primary" type="submit"
										value="<?php esc_attr_e( 'Execute Task', 'lightweight-cookie-notice-free' ); ?>">
							</div>

						</div>

					</div>

				</form>

			</div>

		</div>

		<!-- Dialog Confirm -->
		<div id="dialog-confirm" title="<?php esc_attr_e( 'Maintenance Task', 'lightweight-cookie-notice-free' ); ?>" class="daext-display-none">
			<p><?php esc_html_e( 'Do you really want to proceed?', 'lightweight-cookie-notice-free' ); ?></p>
		</div>

		<?php
	}
}
