<?php
/**
 * Class used to implement the back-end functionalities of the "Dashboard" menu.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * Class used to implement the back-end functionalities of the "Consent Log" menu.
 */
class Daextlwcnf_Consent_Log_Menu_Elements extends Daextlwcnf_Menu_Elements {

	/**
	 * Daextlwcnf_Dashboard_Menu_Elements constructor.
	 *
	 * @param object $shared The shared class.
	 * @param string $page_query_param The page query parameter.
	 * @param string $config The config parameter.
	 */
	public function __construct( $shared, $page_query_param, $config ) {

		parent::__construct( $shared, $page_query_param, $config );

		$this->menu_slug      = 'consent-log';
		$this->slug_plural    = 'consent-log';
		$this->label_singular = __( 'Consent Log', 'lightweight-cookie-notice-free' );
		$this->label_plural   = __( 'Consent Log', 'lightweight-cookie-notice-free' );
	}

	/**
	 * Display the content of the body.
	 *
	 * @return void
	 */
	public function display_custom_content() {

		?>

		<div id="react-root"></div>

		<?php
	}
}
