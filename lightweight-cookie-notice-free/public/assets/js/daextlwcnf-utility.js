/**
 * Utility Methods
 */
window.daextlwcnUtility = {

  /**
   * The own properties of object b are copied in object a. Object a is then returned.
   *
   * @param a The target object
   * @param b The source object
   * @returns a The object with the properties extended
   */
  extend: function(a, b) {

    'use strict';

    for (let key in b) {
      if (b.hasOwnProperty(key)) {
        a[key] = b[key];
      }
    }
    return a;

  },

  /**
   * Returns a string with the not allowed characters converted to hex entities.
   *
   * @param s
   * @return s
   */
  escapeHtml: function(s) {

    'use strict';

    return s.replace(/&/g, '&#x26;').
        replace(/</g, '&#x3C;').
        replace(/>/g, '&#x3E;').
        replace(/"/g, '&#x22;').
        replace(/'/g, '&#x27;');

  },

  /**
   * Returns a string with the not allowed characters converted to hex entities.
   *
   * @param s
   * @return s
   */
  escapeUrl: function(s) {

    'use strict';

    return s.replace(/</g, '&#x3C;').
        replace(/>/g, '&#x3E;').
        replace(/"/g, '&#x22;').
        replace(/'/g, '&#x27;');

  },

  /**
   * Given the name of the cookie the cookie value is returned if the cookie is found. If the cookie is not found false
   * is returned.
   *
   * @param cname The name of the cookie
   * @returns mixed The value of the cookie if the cookie is found or false if the cookie is not found
   */
  getCookie: function(cname) {

    'use strict';

    let name = cname + '=';
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return false;
  },

  /**
   * Deletes the specified cookie.
   *
   * @param name The name of the cookie
   */
  deleteCookie: function(name, cookiePathAttribute) {

    'use strict';

    /**
     * Configure the cookie property of the Document interface based on the options selected by the user via the plugin
     * options.
     */
    let cookieProperty = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT';
    if(cookiePathAttribute !== ''){
      cookieProperty += '; path=' + cookiePathAttribute;
    }

    // Set the cookie property of the Document interface.
    document.cookie = cookieProperty;

  },

  /**
   * Closes the cookie notice.
   *
   * @param name
   */
  closeNotice: function(name) {

    'use strict';

    //Remove the notice from the DOM
    document.getElementById('daextlwcnf-cookie-notice-container').remove();

    //Remove the mask from the DOM
    let cm = document.getElementById('daextlwcnf-cookie-notice-container-mask');
    if (cm) {
      cm.remove();
    }

  },

  /**
   * Set a cookie based on the provided parameters.
   *
   * @param name The name of the cookie.
   * @param value The value of the cookie.
   * @param The expiration in seconds.
   */
  setCookie: function(name, value, settings) {

    'use strict';

    // Calculate teh cookie expiration value based on the options selected by the user via the plugin options.
    let now = new Date();
    let time = now.getTime();
    let expireTime = time + (settings.cookieExpiration * 1000);
    now.setTime(expireTime);
    let formattedExpiration = now.toUTCString();

    /**
     * Configure the cookie property of the Document interface based on the options selected by the user via the plugin
     * options.
     */
    let cookieProperty = name + '=' + value + '; expires=' + formattedExpiration;
    if(settings.cookiePathAttribute !== ''){
        cookieProperty += '; path=' + settings.cookiePathAttribute;
    }

    // Set the cookie property of the Document interface.
    document.cookie = cookieProperty;

  },

  hexToRgb: function(hex) {

    'use strict';

    let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16),
    } : null;


  },

  sectionHasToggle: function(categoryA) {

    'use strict';

    let result = false;

    categoryA.forEach(function(category) {
      if (parseInt(category.toggle, 10) === 1) {
        result = true;
      }

    });

    return result;

  },

  /**
   * Returns the HTML of a table that includes the provided cookies. The table will include the columns specified in the
   * columns argument.
   *
   * @param cookies An array with the cookies.
   * @param columns The columns that should be displayed.
   * @returns {string}
   */
  generateCookieTable: function(cookies, columns) {

    'use strict';

    try {
      columns = JSON.parse(columns);
    } catch (error) {
      columns = false;
    }

    let tableHtml = '<table>';

    tableHtml += '<thead>';
    tableHtml += '<tr>';

    columns.forEach(function(column) {
      switch (column) {
        case 'name':
          tableHtml += '<th>' + DAEXTLWCN_PHPDATA.nameText + '</th>';
          break;
        case 'expiration':
          tableHtml += '<th>' + DAEXTLWCN_PHPDATA.expirationText + '</th>';
          break;
        case 'purpose':
          tableHtml += '<th>' + DAEXTLWCN_PHPDATA.purposeText + '</th>';
          break;
        case 'provider':
          tableHtml += '<th>' + DAEXTLWCN_PHPDATA.providerText + '</th>';
          break;
        case 'domain':
          tableHtml += '<th>' + DAEXTLWCN_PHPDATA.domainText + '</th>';
          break;
        case 'type':
          tableHtml += '<th>' + DAEXTLWCN_PHPDATA.typeText + '</th>';
          break;
        case 'sensitivity':
          tableHtml += '<th>' + DAEXTLWCN_PHPDATA.sensitivityText + '</th>';
          break;
        case 'security':
          tableHtml += '<th>' + DAEXTLWCN_PHPDATA.securityText + '</th>';
          break;
      }
    });

    tableHtml += '</tr>';
    tableHtml += '</thead>';

    tableHtml += '<tbody>';
    cookies.forEach(function(cookie) {
      tableHtml += '<tr>';

      columns.forEach(function(column) {
        switch (column) {
          case 'name':
            tableHtml += '<td>' + cookie.name + '</td>';
            break;
          case 'expiration':
            tableHtml += '<td>' + cookie.expiration + '</td>';
            break;
          case 'purpose':
            tableHtml += '<td>' + cookie.purpose + '</td>';
            break;
          case 'provider':
            tableHtml += '<td>' + cookie.provider + '</td>';
            break;
          case 'domain':
            tableHtml += '<td>' + cookie.domain + '</td>';
            break;
          case 'type':
            tableHtml += '<td>' + cookie.type + '</td>';
            break;
          case 'sensitivity':
            tableHtml += '<td>' + cookie.sensitivity + '</td>';
            break;
          case 'security':
            tableHtml += '<td>' + cookie.security + '</td>';
            break;
        }
      });

      tableHtml += '</tr>';
    });
    tableHtml += '</tbody>';

    tableHtml += '</table>';

    return tableHtml;

  },

  /**
   * Sends an AJAX request that includes the state of all the categories.
   *
   * @param categoryCookies
   */
  saveCategoryAcceptance: function (categoryCookies, settings) {

    'use strict';

    // Do not proceed if the "Store User Consent" option is disabled.
    if(parseInt(settings.storeUserConsent, 10) === 0){
        return;
    }

    //Do not proceed if there are no category cookies
    let categoryCookiesJSON;
    try {
      categoryCookiesJSON = JSON.parse(categoryCookies);
    } catch (error) {
      categoryCookiesJSON = false;
    }
    if (categoryCookiesJSON === false) {
      return;
    }

    // Prepare the request
    const url = window.location.href;
    const country_code = localStorage.getItem("daextlwcnf_country_code") !== null ? localStorage.getItem("daextlwcnf_country_code") : '';

    //Ajax request
    const oReq1 = new XMLHttpRequest();
    oReq1.addEventListener('load', function (response) {

      // Create a cookie that keeps the category acceptance
      window.daextlwcnUtility.setCookie('daextlwcnf-encrypted-key', this.response,
          settings);

    });

    oReq1.open('POST', window.DAEXTLWCN_PHPDATA.ajaxUrl, true);
    let formData = new FormData();
    formData.append('action', 'daextlwcnf_save_consent_log');
    formData.append('security', window.DAEXTLWCN_PHPDATA.nonce);
    formData.append('category_cookies', categoryCookies);
    formData.append('url', url);
    formData.append('country_code', country_code);
    oReq1.send(formData);

  },

  /**
   * This method does what follows:
   *
   * - Create the category states if the cookie with the category states is not present.
   * - Set the cookie "daextlwcnf-accepted" used to save the cookie acceptance.
   * - Calls the method used to save the category acceptance.
   *
   * @param settings
   */
  acceptCookies: function(settings, enableAllCookieCategories = false, disableAllCookieCategories = false) {

    let categoryCookies = null;

    /**
     * With the following conditions create the cookie categories by getting the data from the settings:
     *
     * - If the cookie that keeps the category statuses (daextlwcnf-category-status) is not present. Note that the cookie
     * that keeps the category statuses is present when the user has used one of the toggles avaialble in the cookie
     * settings modal window.
     * - If the "Accept All Cookies" button has been clicked (when enableAllCookieCategories is true)
     * - If the "Disable All Cookies" button has been clicked (when disableAllCookieCategories is true)
     *
     * Otherwise create the cookie categories from the existing cookie in the browser.
     */
    if (this.getCookie('daextlwcnf-category-status') === false || enableAllCookieCategories === true || disableAllCookieCategories === true) {
      categoryCookies = this.setDefaultCategoryCookie(settings, enableAllCookieCategories, disableAllCookieCategories);
    } else {
      categoryCookies = this.getCookie('daextlwcnf-category-status');
    }

    //Set the cookie used to save the cookie acceptance
    this.setCookie('daextlwcnf-accepted', '1', settings);

    //Save the category acceptance
    this.saveCategoryAcceptance(categoryCookies, settings);

  },

  /**
   * Save the the default values of the category cookies.
   */
  setDefaultCategoryCookie: function(settings, enableAllCookieCategories = false, disableAllCookieCategories = false){

    let sections = settings.sections;
    let categoryCookies = [];

    //Iterate over all the sections
    sections.forEach(function(section) {

      //Save the status of the category toggles in an array
      section.category_a.forEach(function(singleCategory) {
        categoryCookies.push({
          'categoryId': singleCategory.category_id,
          'status': singleCategory.default_status,
        });
      });

    });

    //Enable all the cookie categories if the user has clicked the "Accept All Cookies" button
    if(enableAllCookieCategories){
      categoryCookies = this.enableAllCookieCategories(settings, categoryCookies);
    }

    //Disable all the cookie categories if the user has clicked the "Reject All Cookies" button
    if(disableAllCookieCategories){
      categoryCookies = this.disableAllCookieCategories(settings, categoryCookies);
    }

    //Save the status of the category toggle in the "daextlwcnf-category-status" serialized cookie
    categoryCookies = JSON.stringify(categoryCookies);

    this.setCookie('daextlwcnf-category-status', categoryCookies,
        settings);

    return categoryCookies;

  },

  /**
   * Reloads the current page if the "Reload Page" option is enabled.
   *
   * @param settings
   */
  reload: function(settings) {

    if (parseInt(settings.reloadPage, 10) === 1) {
      window.location.reload(false);
    }

  },

  /**
   *
   * Find if the cookie category for which is provided the ID has the toggle field enabled. Returns true if the toggle
   * is enabled, false otherwise.
   */
  isToggleEnabled: function(settings, categoryId){

    'use strict';

    let sections = settings.sections;

    let category = sections.find(function(section){
      return section.category_a.find(function(category){
        return category.category_id === categoryId;
      });
    });

    return category.category_a[0].toggle === "1";

  },

  /**
   * Enable all the cookie categories.
   *
   * Note: The status of the category cookie is modified only if the toggle is enabled.
   *
   * @param settings
   * @param categoryCookies
   * @returns {*}
   */
  enableAllCookieCategories: function(settings, categoryCookies){

    'use strict';

    categoryCookies.forEach((categoryCookie) => {

      // Modify the status of the category cookie only if the toggle is enabled
      if(this.isToggleEnabled(settings, categoryCookie.categoryId)) {
        categoryCookie.status = "1";
      }

    });

    return categoryCookies;

  },

  /**
   * Disable all the cookie categories.
   *
   * Note: The status of the category cookie is modified only if the toggle is enabled.
   *
   * @param settings
   * @param categoryCookies
   * @returns {*}
   */
  disableAllCookieCategories: function(settings, categoryCookies){

    'use strict';

    categoryCookies.forEach((categoryCookie) => {

      // Modify the status of the category cookie only if the toggle is enabled
      if(this.isToggleEnabled(settings, categoryCookie.categoryId)){
          categoryCookie.status = "0";
      }

    });

    return categoryCookies;

  },

  /**
   * Add to the DOM a hidden div field. This field can be used by a
   * Google Tag Manager trigger to identify when the cookie notice is disabled.
   */
  addHiddenFieldForGTagManager: function(){

    'use strict';

    let div = document.createElement('div');
    div.className = 'daextlwcnf-consent-data-available';

    // Add the div style.
    div.style.width = '1px';
    div.style.height = '1px';
    div.style.position = 'absolute';
    div.style.top = '0';
    div.style.left = '0';

    document.body.appendChild(div);

    // After 50 milliseconds, the div is removed.
    setTimeout(function(){
      div.remove();
    }, 500);

  },

};