/**
 * This file is used to initialize the select2 fields in the Categories page.
 *
 * @package lightweight-cookie-notice-free
 */

(function ($) {

  'use strict';

  $( document ).ready(
      function () {

        'use strict';

        initSelect2();

      }
  );

  /**
   * Initialize the select2 fields.
   */
  function initSelect2() {

    'use strict';

    $('#category_id').select2();

  }

}(window.jQuery));