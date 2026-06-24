/**
 * This file is used to handle the confirmation dialog for performing a task in the Maintenance menu.
 *
 * @package lightweight-cookie-notice-free
 */

(function ($) {

	'use strict';

	$( document ).ready(
		function () {

			'use strict';

			initSelect2();

			$( document.body ).on(
				'click',
				'#execute-task' ,
				function (event) {

					'use strict';

					event.preventDefault();
					$( '#dialog-confirm' ).dialog( 'open' );

				}
			);

		}
	);

	$(
		function () {

			'use strict';

			$( '#dialog-confirm' ).dialog(
				{
					autoOpen: false,
					resizable: false,
					height: 'auto',
					width: 340,
					modal: true,
					buttons: {
						[window.objectL10n.confirmText]: function () {

							'use strict';

							$( '#form-maintenance' ).submit();

						},
						[window.objectL10n.cancelText]: function () {

							'use strict';

							$( this ).dialog( 'close' );

						},
					},
				}
			);

		}
	);

	/**
	 * Initialize the select2 fields.
	 */
	function initSelect2() {

		'use strict';

		$( '#task' ).select2();

	}

}(window.jQuery));
