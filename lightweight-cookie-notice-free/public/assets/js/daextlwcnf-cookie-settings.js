/**
 * This file is used to generate the cookie settings and handle its events.
 */
window.daextlwcnCookieSettings = (function(utility, revisitCookieConsent) {

  'use strict';

  //This object is used to save all the settings -----------------------------------------------------------------------
  let settings = {};

  /**
   * Returns the HTML of the section toogle or category toggle.
   *
   * @returns {string}
   */
  function toggleHtml() {

    'use strict';

    let toggle = '';
    toggle += '<label class="daextlwcnf-switch">';
    toggle += '<div class="daextlwcnf-checkbox"></div>';
    toggle += '<span class="daextlwcnf-slider daextlwcnf-round"></span>';
    toggle += '</label>';
    return toggle;

  }

  /**
   * Add the cookie settings HTML at the end of the body.
   */
  function addToDOM() {

    'use strict';

    let sections = settings.sections;

    /**
     * If the cookie that keeps the status of the various categories is set use this cookie instead of the
     * defaultStatus to set the data-status of the toggle (.daextlwcnf-cookie-settings-category-toggle)
     */
    let categoryStatus = utility.getCookie('daextlwcnf-category-status');
    try {
      categoryStatus = JSON.parse(categoryStatus);
    } catch (error) {
      categoryStatus = false;
    }

    let html = '';

    html += '<div id="daextlwcnf-cookie-settings-blurred-header"></div>';
    html += '<div id="daextlwcnf-cookie-settings-header">';

    if (settings.cookieSettingsLogoUrl.length > 0) {
      html += '<img id="daextlwcnf-cookie-settings-logo" src="' +
          settings.cookieSettingsLogoUrl + '">';
    }
    html += '<div id="daextlwcnf-cookie-settings-title">' +
        settings.cookieSettingsTitle + '</div>';
    html += '</div>'; // #daextlwcnf-cookie-settings-header

    html += '<div id="daextlwcnf-cookie-settings-body">';
    html += '<div id="daextlwcnf-cookie-settings-intro">' +
        settings.cookieSettingsDescriptionHeader + '</div>';

    //Add the HTML of each section
    sections.forEach(function(section) {

      let dataToggle = utility.sectionHasToggle(section.category_a) === true
          ? '1'
          : '0';

      html += '<div class="daextlwcnf-cookie-settings-section-container">';
      html += '<div class="daextlwcnf-cookie-settings-section-header">';
      html += '<div class="daextlwcnf-cookie-settings-section-name">' +
          section.name + '</div>';
      html += '<div class="daextlwcnf-cookie-settings-section-toggle" data-toggle="' +
          dataToggle + '" data-status="0" data-id="' +
          parseInt(section.section_id, 10) + '">' + toggleHtml() + '</div>';
      html += '<div class="daextlwcnf-cookie-settings-section-chevron" data-section-id="' +
          parseInt(section.section_id, 10) + '"></div>';
      html += '</div>';

      html += '<div class="daextlwcnf-cookie-settings-section-body" data-section-id="' +
          parseInt(section.section_id, 10) + '">';
      html += '<div class="daextlwcnf-cookie-settings-section-description" data-section-id="' +
          parseInt(section.section_id, 10) + '">' + section.description +
          '</div>';

      //Add the HTML of the categories included in this section
      section.category_a.forEach(function(category) {

        html += '<div class="daextlwcnf-cookie-settings-category-container" data-section-id="' +
            parseInt(section.section_id, 10) + '">';
        html += '<div class="daextlwcnf-cookie-settings-category-header">';
        html += '<div class="daextlwcnf-cookie-settings-category-expand" data-category-id="' +
            parseInt(category.category_id, 10) + '" data-status="0"></div>';
        html += '<div class="daextlwcnf-cookie-settings-category-title">' +
            category.name + '</div>';

        /**
         * Get the status of this category. If the category status is not available use the default category
         * status.
         */
        let dataStatus = category.default_status;
        if (categoryStatus !== false) {
          categoryStatus.forEach(function(value) {
            if (value.categoryId == category.category_id) {
              dataStatus = value.status;
            }
          });
        }

        let dataStatusValue = (parseInt(dataStatus, 10) == 0) ? '0' : '2';
        html += '<div class="daextlwcnf-cookie-settings-category-toggle" data-toggle="' +
            parseInt(category.toggle, 10) + '" data-status="' +
            dataStatusValue + '" data-id="' +
            parseInt(category.category_id, 10) + '" data-section-id="' +
            parseInt(section.section_id, 10) + '">' + toggleHtml() + '</div>';
        html += '</div>'; //.daextlwcnf-cookie-settings-category-header
        html += '<div class="daextlwcnf-cookie-settings-category-description" data-category-id="' +
            parseInt(category.category_id, 10) + '">' + category.description +
            '</div>';

        if (category.cookies.length > 0) {
          html += '<div class="daextlwcnf-cookie-settings-category-cookie-list" data-category-id="' +
              parseInt(category.category_id, 10) + '">' +
              utility.generateCookieTable(category.cookies,
                  settings.cookieTableColumns) + '</div>'; //.daextlwcnf-cookie-settings-category-container
        }

        html += '</div>'; //.daextlwcnf-cookie-settings-category-container

      });

      html += '</div>'; //.daextlwcnf-cookie-settings-section-body
      html += '</div>';

    });

    html += '<div id="daextlwcnf-cookie-settings-description-footer">' +
        settings.cookieSettingsDescriptionFooter + '</div>';
    html += '</div>'; // #daextlwcnf-cookie-settings-body

    html += '<div id="daextlwcnf-cookie-settings-blurred-footer"></div>';
    html += '<div id="daextlwcnf-cookie-settings-footer">';
    html += '<div id="daextlwcnf-cookie-settings-buttons-container">';
    if (parseInt(settings.cookieSettingsButton1Action) !== 0) {
      html += '<div id="daextlwcnf-cookie-settings-button-1" class="daextlwcnf-cookie-settings-button">' +
          settings.cookieSettingsButton1Text + '</div>';
    }
    if (parseInt(settings.cookieSettingsButton2Action) !== 0) {
      html += '<div id="daextlwcnf-cookie-settings-button-2" class="daextlwcnf-cookie-settings-button">' +
          settings.cookieSettingsButton2Text + '</div>';
    }
    html += '</div>'; // #daextlwcnf-cookie-settings-buttons-container
    html += '</div>'; // #daextlwcnf-cookie-settings-footer
    html += '</div>';

    //Add the cookie settings modal window HTML to the DOM
    let cookieSettings = document.createElement('div');
    cookieSettings.id = 'daextlwcnf-cookie-settings-container';
    cookieSettings.innerHTML = html;
    document.body.appendChild(cookieSettings);

    //Add the cookie icon inside the container
    let iconContainer = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-section-chevron');

    //iterate over iconContainer
    for (let i = 0; i < iconContainer.length; i++) {
      iconContainer[i].appendChild(generateChevronIconSVG());
    }

    //Add the cookie icon inside the container
    let plusIconContainer = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-category-expand');

    //iterate over iconContainer
    for (let i = 0; i < plusIconContainer.length; i++) {
      plusIconContainer[i].appendChild(generatePlusIconSVG());
      plusIconContainer[i].appendChild(generateDashIconSVG());
    }

    //Add the cookie settings mask if enabled
    let cookieSettingsMask = document.createElement('div');
    cookieSettingsMask.id = 'daextlwcnf-cookie-settings-mask';
    document.body.appendChild(cookieSettingsMask);

    //Update the toggles of all the categories
    sections.forEach(function(section) {
      updateSectionToggle(section.section_id);
    });

  }

  /**
   *
   * Create the SVG of the chevron icon.
   *
   * @returns {{}|SVGElement|Element|SVGSVGElement|HTMLElement}
   */
  function generateChevronIconSVG() {

    'use strict';

    let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('viewBox', '0 0 20 20');
    svg.setAttribute('version', '1.1');


    const style = document.createElementNS('http://www.w3.org/2000/svg',
        'style');
    style.append(document.createTextNode('.chevron-st0{fill:none;stroke:' + settings.cookieSettingsChevronColor + ';stroke-miterlimit:10;}'));

    svg.appendChild(style);

    const path = document.createElementNS('http://www.w3.org/2000/svg',
        'path');
    path.setAttribute('class', 'chevron-st0');
    path.setAttribute('d',
        'M4,7l6,6c2-2,4-4,6-6');

    svg.appendChild(path);

    return svg;

  }

  /**
   *
   * Create the SVG of the plus icon.
   *
   * @returns {{}|SVGElement|Element|SVGSVGElement|HTMLElement}
   */
  function generatePlusIconSVG() {

    'use strict';

    let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('viewBox', '0 0 20 20');
    svg.setAttribute('version', '1.1');

    const style = document.createElementNS('http://www.w3.org/2000/svg',
        'style');
    style.append(document.createTextNode('.plus-st0{fill:' + settings.cookieSettingsExpandCloseColor + ';}'));

    svg.appendChild(style);

    const polygon = document.createElementNS('http://www.w3.org/2000/svg',
        'polygon');
    polygon.setAttribute('class', 'plus-st0');
    polygon.setAttribute('points',
        '15,9 11,9 11,5 9,5 9,9 5,9 5,11 9,11 9,15 11,15 11,11 15,11');

    svg.appendChild(polygon);

    return svg;

  }

  /**
   *
   * Create the SVG of the dash icon.
   *
   * @returns {{}|SVGElement|Element|SVGSVGElement|HTMLElement}
   */
  function generateDashIconSVG() {

    'use strict';

    let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('viewBox', '0 0 20 20');
    svg.setAttribute('version', '1.1');

    const style = document.createElementNS('http://www.w3.org/2000/svg',
        'style');
    style.append(document.createTextNode('.dash-st0{fill:' + settings.cookieSettingsExpandCloseColor + ';}'));

    svg.appendChild(style);

    const rect = document.createElementNS('http://www.w3.org/2000/svg',
        'rect');
    rect.setAttribute('x', '9');
    rect.setAttribute('y', '5');
    rect.setAttribute('transform',
        'matrix(-1.836970e-16 1 -1 -1.836970e-16 20 1.776357e-15)');
    rect.setAttribute('class', 'dash-st0');
    rect.setAttribute('width', '2');
    rect.setAttribute('height', '10');

    svg.appendChild(rect);

    return svg;

  }

  /**
   * Apply the CSS style to the cookie settings HTML.
   */
  function applyStyle() {

    'use strict';

    let css = '';
    let declarationSuffix = '';
    if (parseInt(settings.forceCssSpecificity, 10) === 1) {
      declarationSuffix = ' !important';
    }

    // #daextlwcnf-cookie-settings-mask
    css += '#daextlwcnf-cookie-settings-mask{';
    css += 'background: ' + settings.cookieSettingsMaskColor +
        declarationSuffix + ';';
    css += 'opacity: ' + parseFloat(settings.cookieSettingsMaskOpacity) +
        declarationSuffix + ';';
    css += 'width: 100%' + declarationSuffix + ';';
    css += 'position: fixed' + declarationSuffix + ';';
    css += 'height: 100%' + declarationSuffix + ';';
    css += 'left: 0' + declarationSuffix + ';';
    css += 'top: 0' + declarationSuffix + ';';
    css += 'z-index: 999999998' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-container, #daextlwcnf-container *
    css += '#daextlwcnf-cookie-settings-container, #daextlwcnf-cookie-settings-container *{';
    css += 'box-sizing: content-box' + declarationSuffix + ';';
    css += '-webkit-touch-callout: none' + declarationSuffix + ';';
    css += '-webkit-user-select: none' + declarationSuffix + ';';
    css += '-khtml-user-select: none' + declarationSuffix + ';';
    css += '-moz-user-select: none' + declarationSuffix + ';';
    css += '-ms-user-select: none' + declarationSuffix + ';';
    css += 'user-select: none' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-container
    css += '#daextlwcnf-cookie-settings-container{';
    css += 'position: fixed' + declarationSuffix + ';';
    let partialTop = 300 +
        parseInt(settings.cookieSettingsContainerBorderWidth, 10);
    css += 'top: calc(50% - ' + partialTop + 'px)' + declarationSuffix + ';';
    let partialLeft = 300 +
        parseInt(settings.cookieSettingsContainerBorderWidth, 10);
    css += 'left: calc(50% - ' + partialLeft + 'px)' + declarationSuffix + ';';
    css += 'z-index: 999999999' + declarationSuffix + ';';
    css += 'height: 568px' + declarationSuffix + ';';
    css += 'width: 600px' + declarationSuffix + ';';
    css += 'background: ' + settings.cookieSettingsContainerBackgroundColor +
        declarationSuffix + ';';
    css += 'opacity: ' + parseFloat(settings.cookieSettingsContainerOpacity) +
        declarationSuffix + ';';
    css += 'border-width: ' + settings.cookieSettingsContainerBorderWidth +
        'px' + declarationSuffix + ';';
    css += 'border-color: rgba(' +
        utility.hexToRgb(settings.cookieSettingsContainerBorderColor).r + ',' +
        utility.hexToRgb(settings.cookieSettingsContainerBorderColor).g + ',' +
        utility.hexToRgb(settings.cookieSettingsContainerBorderColor).b + ', ' +
        parseFloat(settings.cookieSettingsContainerBorderOpacity) + ')' +
        declarationSuffix + ';';
    css += 'border-style: solid' + declarationSuffix + ';';
    css += 'color: #000' + declarationSuffix + ';';
    css += 'z-index: 999999999' + declarationSuffix + ';';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'padding: 16px 0' + declarationSuffix + ';';
    css += 'border-radius: ' + parseInt(settings.containersBorderRadius, 10) +
        'px' + declarationSuffix + ';';
    let drop_shadow_value = 'none';
    if (parseInt(settings.cookieSettingsContainerDropShadow, 10) === 1) {
      drop_shadow_value = 'rgba(' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).r +
          ', ' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).g +
          ', ' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).b +
          ', 0.08) 0px 0px 0px 1px, rgba(' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).r +
          ', ' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).g +
          ', ' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).b +
          ', 0.08) 0px 2px 1px, rgba(' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).r +
          ', ' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).g +
          ', ' +
          utility.hexToRgb(settings.cookieSettingsContainerDropShadowColor).b +
          ', 0.31) 0px 0px 20px -6px' + declarationSuffix + ';';
    }
    css += 'box-shadow: ' + drop_shadow_value + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-blurred-header
    css += '#daextlwcnf-cookie-settings-blurred-header{';
    css += 'width: 568px' + declarationSuffix + ';';
    css += 'height: 0px' + declarationSuffix + ';';
    css += 'position: absolute' + declarationSuffix + ';';
    css += 'left: 16px' + declarationSuffix + ';';
    css += 'top: 80px' + declarationSuffix + ';';
    css += 'box-shadow: 0px 0px 6px 6px ' +
        settings.cookieSettingsContainerBackgroundColor + '' +
        declarationSuffix + ';';
    css += 'z-index: 0' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-header
    css += '#daextlwcnf-cookie-settings-header{';
    css += 'height: 80px' + declarationSuffix + ';';
    css += 'display: flex' + declarationSuffix + ';';
    css += 'position: absolute' + declarationSuffix + ';';
    css += 'top: 0' + declarationSuffix + ';';
    css += 'width: 552px' + declarationSuffix + ';';
    css += 'padding: 0 24px' + declarationSuffix + ';';
    css += 'background: ' + settings.cookieSettingsContainerBackgroundColor +
        '' + declarationSuffix + ';';
    css += 'z-index: 999999999' + declarationSuffix + ';';
    css += 'border-bottom: 1px solid #ebecf0' + declarationSuffix + ';';
    css += 'border-radius: ' + parseInt(settings.containersBorderRadius, 10) +
        'px ' + parseInt(settings.containersBorderRadius, 10) + 'px 0 0' +
        declarationSuffix + ';';
    css += '}';

    if (settings.cookieSettingsLogoUrl.length > 0) {
      css += '#daextlwcnf-cookie-settings-logo{';
      css += 'height: 32px' + declarationSuffix + ';';
      css += 'margin: 24px 0' + declarationSuffix + ';';
      css += '}';
    }

    // #daextlwcnf-cookie-settings-title
    css += '#daextlwcnf-cookie-settings-title{';
    css += 'font-size: 20px' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsHeadingsFontColor +
        declarationSuffix + ';';
    css += 'line-height: 80px' + declarationSuffix + ';';
    css += 'margin: 0' + declarationSuffix + ';';
    if (settings.cookieSettingsLogoUrl.length > 0) {
      css += 'padding: 0 24px 0 8px' + declarationSuffix + ';';
    } else {
      css += 'padding: 0 24px 0 0' + declarationSuffix + ';';
    }
    css += 'font-family: ' + settings.headingsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + settings.headingsFontWeight + '' +
        declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-intro
    css += '#daextlwcnf-cookie-settings-intro{';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsParagraphsFontColor +
        declarationSuffix + ';';
    css += 'margin-top: 21px' + declarationSuffix + ';';
    css += 'margin-bottom: 18px' + declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'padding: 0 24px' + declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-intro strong
    css += '#daextlwcnf-cookie-settings-intro strong{';
    css += 'font-weight: ' + parseInt(settings.strongTagsFontWeight, 10) +
        declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-intro a
    css += '#daextlwcnf-cookie-settings-intro a{';
    css += 'color: ' + settings.cookieSettingsLinksFontColor +
        declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'text-decoration: none' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-intro a:hover
    css += '#daextlwcnf-cookie-settings-intro a:hover{';
    css += 'text-decoration: underline' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-body
    // Ref: https://stackoverflow.com/questions/16670931/hide-scroll-bar-but-while-still-being-able-to-scroll/38994837#38994837
    css += '#daextlwcnf-cookie-settings-body{';
    css += 'height: 440px' + declarationSuffix + ';';
    css += 'width: 600px' + declarationSuffix + ';';
    css += 'margin-top: 64px' + declarationSuffix + ';';
    css += 'overflow-y: scroll' + declarationSuffix + ';';
    css += 'scrollbar-width: none' + declarationSuffix + ';'; //Firefox
    css += '-ms-overflow-style: none' + declarationSuffix + ';'; //Internet Explorer 10+
    css += '}';

    // #daextlwcnf-cookie-settings-body
    css += '#daextlwcnf-cookie-settings-body::-webkit-scrollbar{';
    css += 'width: 0' + declarationSuffix + ';';
    css += 'height: 0' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-container
    css += '.daextlwcnf-cookie-settings-section-container{';
    css += 'padding: 0 24px' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-container:hover
    css += '.daextlwcnf-cookie-settings-section-container:hover{';
    css += 'background: ' + settings.cookieSettingsContainerHighlightColor +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-header
    css += '.daextlwcnf-cookie-settings-section-header{';
    css += 'display: flex' + declarationSuffix + ';';
    css += 'margin-bottom: 0' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-name
    css += '.daextlwcnf-cookie-settings-section-name{';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsHeadingsFontColor +
        declarationSuffix + ';';
    css += 'flex-basis: calc(100% - 96px)' + declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'padding: 14px 16px 14px 0' + declarationSuffix + ';';
    css += 'font-family: ' + settings.headingsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.headingsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-toggle
    css += '.daextlwcnf-cookie-settings-section-toggle{';
    css += 'flex-basis: 52px' + declarationSuffix + ';';
    css += 'margin-top: 12px' + declarationSuffix + ';';
    css += 'height: 24px' + declarationSuffix + ';';
    css += 'border-right: 1px solid ' + settings.cookieSettingsSeparatorColor +
        '' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-toggle
    css += '.daextlwcnf-cookie-settings-section-toggle[data-toggle="0"]{';
    css += 'border-right: 0' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-toggle[data-toggle="0"] .daextlwcnf-slider
    css += '.daextlwcnf-cookie-settings-section-container .daextlwcnf-cookie-settings-section-toggle[data-toggle="0"] .daextlwcnf-checkbox + .daextlwcnf-slider{';
    css += 'background-color: ' + settings.cookieSettingsToggleDisabledColor +
        declarationSuffix + ';';
    css += 'cursor: default' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-chevron
    css += '.daextlwcnf-cookie-settings-section-chevron{';
    css += 'min-width: 20px' + declarationSuffix + ';';
    css += 'width: 20px' + declarationSuffix + ';';
    css += 'height: 20px' + declarationSuffix + ';';
    css += 'flex-basis: 20px' + declarationSuffix + ';';
    css += 'transition: .2s' + declarationSuffix + ';';
    css += 'cursor: pointer' + declarationSuffix + ';';
    css += 'margin: 15px 1px 13px 6px' + declarationSuffix + ';';
    ;
    css += '}';

    // .daextlwcnf-cookie-settings-section-chevron.down
    css += '.daextlwcnf-cookie-settings-section-chevron.down{';
    css += 'top: 0' + declarationSuffix + ';';
    css += '-webkit-transform: rotate(-180deg)' + declarationSuffix + ';';
    css += '-ms-transform: rotate(-180deg)' + declarationSuffix + ';';
    css += 'transform: rotate(-180deg)' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-body
    css += '.daextlwcnf-cookie-settings-section-body{';
    css += 'display: none;';
    css += 'padding-bottom: 16px' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-description
    css += '.daextlwcnf-cookie-settings-section-description{';
    css += 'color: ' + settings.cookieSettingsParagraphsFontColor +
        declarationSuffix + ';';
    css += 'margin-top: 6px' + declarationSuffix + ';';
    css += 'margin-bottom: 6px' + declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-description strong
    css += '.daextlwcnf-cookie-settings-section-description strong{';
    css += 'font-weight: ' + parseInt(settings.strongTagsFontWeight, 10) +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-header
    css += '.daextlwcnf-cookie-settings-category-header{';
    css += 'display: flex' + declarationSuffix + ';';
    css += 'line-height: 48px' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-header:hover
    css += '.daextlwcnf-cookie-settings-category-header:hover{';
    css += 'background: ' + settings.cookieSettingsContainerBackgroundColor +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-expand
    css += '.daextlwcnf-cookie-settings-category-expand{';
    css += 'min-width: 20px' + declarationSuffix + ';';
    css += 'flex-basis: 20px' + declarationSuffix + ';';
    css += 'height: 20px' + declarationSuffix + ';';
    css += 'margin: 14px 10px' + declarationSuffix + ';';
    css += 'cursor: pointer' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-expand > svg
    css += '.daextlwcnf-cookie-settings-category-expand > svg{';
    css += 'display: block' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-expand[data-status="0"] > svg:last-of-type
    css += '.daextlwcnf-cookie-settings-category-expand[data-status="0"] > svg:last-of-type{';
    css += 'display: none' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-expand[data-status="1"] > svg:first-of-type
    css += '.daextlwcnf-cookie-settings-category-expand[data-status="1"] > svg:first-of-type{';
    css += 'display: none' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-title
    css += '.daextlwcnf-cookie-settings-category-title{';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsHeadingsFontColor +
        declarationSuffix + ';';
    css += 'flex-basis: calc(100% - 112px)' + declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'padding: 14px 16px 0 0' + declarationSuffix + ';';
    css += 'font-family: ' + settings.headingsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.headingsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-toggle
    css += '.daextlwcnf-cookie-settings-category-toggle{';
    css += 'flex-basis: 56px' + declarationSuffix + ';';
    css += 'width: 56px' + declarationSuffix + ';';
    css += 'height: 48px' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-description
    css += '.daextlwcnf-cookie-settings-category-description{';
    css += 'color: ' + settings.cookieSettingsParagraphsFontColor +
        declarationSuffix + ';';
    css += 'margin-left: 40px' + declarationSuffix + ';';
    css += 'margin-bottom: 15px' + declarationSuffix + ';';
    css += 'margin-top: 10px' + declarationSuffix + ';';
    css += 'display: none;';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-cookie-list
    css += '.daextlwcnf-cookie-settings-category-cookie-list{';
    css += 'margin: 0 0 0 40px' + declarationSuffix + ';';
    css += 'display: none;';
    css += '}';

    // .daextlwcnf-cookie-settings-category-cookie-list table
    css += '.daextlwcnf-cookie-settings-category-cookie-list table{';
    css += 'margin: 20px 0' + declarationSuffix + ';';
    css += 'border-collapse: collapse' + declarationSuffix + ';';
    css += '}';

    css += '.daextlwcnf-cookie-settings-category-cookie-list table,';
    css += '.daextlwcnf-cookie-settings-category-cookie-list table *{';
    css += 'background: ' + settings.cookieSettingsContainerBackgroundColor +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-section-container:hover
    css += '.daextlwcnf-cookie-settings-section-container:hover .daextlwcnf-cookie-settings-category-cookie-list table,';
    css += '.daextlwcnf-cookie-settings-section-container:hover .daextlwcnf-cookie-settings-category-cookie-list table *{';
    css += 'background: ' + settings.cookieSettingsContainerHighlightColor +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-cookie-list table th
    // .daextlwcnf-cookie-settings-category-cookie-list table td
    css += '.daextlwcnf-cookie-settings-category-cookie-list table th,';
    css += '.daextlwcnf-cookie-settings-category-cookie-list table td{';
    css += 'font-size: 11px' + declarationSuffix + ';';
    css += 'padding: 10px 10px' + declarationSuffix + ';';
    css += 'border: 1px solid ' + settings.cookieSettingsSeparatorColor + '' +
        declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'overflow-wrap: anywhere' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-cookie-list table th
    css += '.daextlwcnf-cookie-settings-category-cookie-list table th{';
    css += 'font-weight: 600' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsHeadingsFontColor +
        declarationSuffix + ';';
    css += 'font-family: ' + settings.headingsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.headingsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-cookie-list table td
    css += '.daextlwcnf-cookie-settings-category-cookie-list table td{';
    css += 'font-weight: 400' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsParagraphsFontColor +
        declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-description strong
    css += '.daextlwcnf-cookie-settings-category-description strong{';
    css += 'font-weight: ' + parseInt(settings.strongTagsFontWeight, 10) +
        declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-description a
    css += '.daextlwcnf-cookie-settings-category-description a{';
    css += 'color: ' + settings.cookieSettingsLinksFontColor +
        declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-blurred-footer
    css += '#daextlwcnf-cookie-settings-blurred-footer{';
    css += 'width: 568px' + declarationSuffix + ';';
    css += 'height: 0px' + declarationSuffix + ';';
    css += 'position: absolute' + declarationSuffix + ';';
    css += 'left: 16px' + declarationSuffix + ';';
    css += 'bottom: 80px' + declarationSuffix + ';';
    css += 'box-shadow: 0px 0px 6px 6px ' +
        settings.cookieSettingsContainerBackgroundColor + '' +
        declarationSuffix + ';';
    css += 'z-index: 0' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-description-footer
    css += '#daextlwcnf-cookie-settings-description-footer{';
    css += 'color: ' + settings.cookieSettingsParagraphsFontColor +
        declarationSuffix + ';';
    css += 'margin-top: 20px' + declarationSuffix + ';';
    css += 'padding: 0 24px' + declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += 'margin-bottom: 21px' + declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-description-footer strong
    css += '#daextlwcnf-cookie-settings-description-footer strong{';
    css += 'font-weight: ' + parseInt(settings.strongTagsFontWeight, 10) +
        declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-description-footer a
    css += '#daextlwcnf-cookie-settings-description-footer a{';
    css += 'color: ' + settings.cookieSettingsLinksFontColor +
        declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-footer
    css += '#daextlwcnf-cookie-settings-footer{';
    css += 'position: absolute' + declarationSuffix + ';';
    css += 'left: 0' + declarationSuffix + ';';
    css += 'bottom: 0' + declarationSuffix + ';';
    css += 'display: flex' + declarationSuffix + ';';
    css += 'width: 552px' + declarationSuffix + ';';
    css += 'padding: 20px 24px' + declarationSuffix + ';';
    css += 'border-top: 1px solid #ebecf0' + declarationSuffix + ';';
    css += 'background: ' + settings.cookieSettingsContainerBackgroundColor +
        '' + declarationSuffix + ';';
    css += 'border-radius: 0 0 ' +
        parseInt(settings.containersBorderRadius, 10) + 'px ' +
        parseInt(settings.containersBorderRadius, 10) + 'px' +
        declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-buttons-container
    css += '#daextlwcnf-cookie-settings-buttons-container{';
    css += 'margin-left: auto' + declarationSuffix + ';';
    css += 'line-height: 38px' + declarationSuffix + ';';
    css += 'height: 40px' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-button
    css += '.daextlwcnf-cookie-settings-button{';
    css += 'padding: 0 46px' + declarationSuffix + ';';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-button-2
    css += '#daextlwcnf-cookie-settings-button-2{';
    css += 'margin-left: 8px' + declarationSuffix + ';';
    css += '}';

    // Toggle ------------------------------------------------------------------------------------------------------

    /* The switch - the box around the slider */
    css += '.daextlwcnf-switch {';
    css += 'position: relative' + declarationSuffix + ';';
    css += 'display: inline-block' + declarationSuffix + ';';
    css += 'width: 40px' + declarationSuffix + ';';
    css += 'margin: 2px 12px 0 0' + declarationSuffix + ';';
    css += 'height: 20px' + declarationSuffix + ';';
    css += '}';

    // .daextlwcnf-cookie-settings-category-toggle .daextlwcnf-switch
    css += '.daextlwcnf-cookie-settings-category-toggle .daextlwcnf-switch {';
    css += 'margin-top: 14px' + declarationSuffix + ';';
    css += 'margin-right: 16px' + declarationSuffix + ';';
    css += '}';

    /* Hide default HTML checkbox */
    css += '.daextlwcnf-switch .daextlwcnf-checkbox {';
    css += 'opacity: 0' + declarationSuffix + ';';
    css += 'width: 40px' + declarationSuffix + ';';
    css += 'height: 20px' + declarationSuffix + ';';
    css += '}';

    /* The slider */
    css += '.daextlwcnf-slider {';
    css += 'position: absolute' + declarationSuffix + ';';
    css += 'cursor: pointer' + declarationSuffix + ';';
    css += 'top: 0' + declarationSuffix + ';';
    css += 'left: 0' + declarationSuffix + ';';
    css += 'right: 0' + declarationSuffix + ';';
    css += 'bottom: 0' + declarationSuffix + ';';
    css += 'width: 40px' + declarationSuffix + ';';
    css += 'height: 20px' + declarationSuffix + ';';
    css += 'background-color: ' + settings.cookieSettingsToggleOffColor +
        declarationSuffix + ';';
    css += '-webkit-transition: .4s' + declarationSuffix + ';';
    css += 'transition: .4s' + declarationSuffix + ';';
    css += '}';

    css += '.daextlwcnf-slider:before {';
    css += 'position: absolute' + declarationSuffix + ';';
    css += 'content: ""' + declarationSuffix + ';';
    css += 'height: 16px' + declarationSuffix + ';';
    css += 'width: 16px' + declarationSuffix + ';';
    css += 'left: 2px' + declarationSuffix + ';';
    css += 'bottom: 2px' + declarationSuffix + ';';
    css += 'background-color: white' + declarationSuffix + ';';
    css += '-webkit-transition: .4s' + declarationSuffix + ';';
    css += 'transition: .4s' + declarationSuffix + ';';
    css += '}';

    css += '.daextlwcnf-cookie-settings-section-toggle[data-status="1"] .daextlwcnf-checkbox + .daextlwcnf-slider,';
    css += '.daextlwcnf-cookie-settings-category-toggle[data-status="1"] .daextlwcnf-checkbox + .daextlwcnf-slider';
    css += ' {';
    css += 'background-color: ' + settings.cookieSettingsToggleMiscColor +
        declarationSuffix + ';';
    css += '}';

    css += '.daextlwcnf-cookie-settings-section-toggle[data-status="1"] .daextlwcnf-checkbox + .daextlwcnf-slider:before,';
    css += '.daextlwcnf-cookie-settings-category-toggle[data-status="1"] .daextlwcnf-checkbox + .daextlwcnf-slider:before';
    css += '{';
    css += '-webkit-transform: translateX(10px)' + declarationSuffix + ';';
    css += '-ms-transform: translateX(10px)' + declarationSuffix + ';';
    css += 'transform: translateX(10px)' + declarationSuffix + ';';
    css += '}';

    css += '.daextlwcnf-cookie-settings-section-toggle[data-status="2"] .daextlwcnf-checkbox + .daextlwcnf-slider,';
    css += '.daextlwcnf-cookie-settings-category-toggle[data-status="2"] .daextlwcnf-checkbox + .daextlwcnf-slider';
    css += '{';
    css += 'background-color: ' + settings.cookieSettingsToggleOnColor +
        declarationSuffix + ';';
    css += '}';

    css += '.daextlwcnf-cookie-settings-section-toggle[data-status="2"] .daextlwcnf-checkbox + .daextlwcnf-slider:before,';
    css += '.daextlwcnf-cookie-settings-category-toggle[data-status="2"] .daextlwcnf-checkbox + .daextlwcnf-slider:before';
    css += '{';
    css += '-webkit-transform: translateX(20px)' + declarationSuffix + ';';
    css += '-ms-transform: translateX(20px)' + declarationSuffix + ';';
    css += 'transform: translateX(20px)' + declarationSuffix + ';';
    css += '}';

    css += '.daextlwcnf-cookie-settings-category-toggle[data-toggle="0"] .daextlwcnf-checkbox + .daextlwcnf-slider';
    css += '{';
    css += 'background-color: ' + settings.cookieSettingsToggleDisabledColor +
        declarationSuffix + ';';
    css += 'cursor: default' + declarationSuffix + ';';
    css += '}';

    /* Rounded sliders */
    css += '.daextlwcnf-slider.daextlwcnf-round {';
    css += 'border-radius: 20px' + declarationSuffix + ';';
    css += '}';

    css += '.daextlwcnf-slider.daextlwcnf-round:before {';
    css += 'border-radius: 50%' + declarationSuffix + ';';
    css += '}';

    /* Buttons */

    // #daextlwcnf-button-1
    css += '#daextlwcnf-cookie-settings-button-1{';
    css += 'width: auto' + declarationSuffix + ';';
    css += 'background: ' + settings.cookieSettingsButton1BackgroundColor +
        declarationSuffix + ';';
    css += 'font-family: ' + settings.buttonsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.buttonsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += 'font-style: normal' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsButton1FontColor +
        declarationSuffix + ';';
    css += 'display: inline-block' + declarationSuffix + ';';
    css += 'cursor: pointer' + declarationSuffix + ';';
    css += 'border: 1px solid ' + settings.cookieSettingsButton1BorderColor +
        declarationSuffix + ';';
    css += 'border-radius: ' + settings.buttonsBorderRadius + 'px' +
        declarationSuffix + ';';
    css += 'text-align: center' + declarationSuffix + ';';
    css += 'padding: 0 10px' + declarationSuffix + ';';
    css += 'width: 158px' + declarationSuffix + ';';
    css += '}';

    css += '#daextlwcnf-cookie-settings-button-1:hover{';
    css += 'background: ' + settings.cookieSettingsButton1BackgroundColorHover +
        declarationSuffix + ';';
    css += 'border-color: ' + settings.cookieSettingsButton1BorderColorHover +
        declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsButton1FontColorHover +
        declarationSuffix + ';';
    css += '}';

    css += '#daextlwcnf-cookie-settings-button-2:hover{';
    css += 'background: ' + settings.cookieSettingsButton2BackgroundColorHover +
        declarationSuffix + ';';
    css += 'border-color: ' + settings.cookieSettingsButton2BorderColorHover +
        declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsButton2FontColorHover +
        declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-button-2
    css += '#daextlwcnf-cookie-settings-button-2{';
    css += 'width: auto' + declarationSuffix + ';';
    css += 'background: ' + settings.cookieSettingsButton2BackgroundColor +
        declarationSuffix + ';';
    css += 'font-family: ' + settings.buttonsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.buttonsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += 'font-style: normal' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsButton2FontColor +
        declarationSuffix + ';';
    css += 'display: inline-block' + declarationSuffix + ';';
    css += 'cursor: pointer' + declarationSuffix + ';';
    css += 'border: 1px solid ' + settings.cookieSettingsButton2BorderColor +
        declarationSuffix + ';';
    css += 'border-radius: ' + parseInt(settings.buttonsBorderRadius, 10) +
        'px' + declarationSuffix + ';';
    css += 'text-align: center' + declarationSuffix + ';';
    css += 'padding: 0 10px' + declarationSuffix + ';';
    css += 'width: 158px' + declarationSuffix + ';';
    css += '}';

    /**
     * Apply a style for the HTML tags allowed with wp_kses():
     *
     * - a
     * - p
     * - strong
     * - br
     * - ol
     * - ul
     * - li
     */

    //a
    css += '#daextlwcnf-cookie-settings-intro a,';
    css += '.daextlwcnf-cookie-settings-section-description a,';
    css += '.daextlwcnf-cookie-settings-category-description a,';
    css += '#daextlwcnf-cookie-settings-description-footer a{';
    css += 'color: ' + settings.cookieSettingsLinksFontColor +
        declarationSuffix + ';';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += 'text-decoration: none' + declarationSuffix + ';';
    css += '}';

    //a:hover
    css += '#daextlwcnf-cookie-settings-intro a:hover,';
    css += '.daextlwcnf-cookie-settings-section-description a:hover,';
    css += '.daextlwcnf-cookie-settings-category-description a:hover,';
    css += '#daextlwcnf-cookie-settings-description-footer a:hover{';
    css += 'text-decoration: underline' + declarationSuffix + ';';
    css += '}';

    //li
    css += '#daextlwcnf-cookie-settings-intro li,';
    css += '.daextlwcnf-cookie-settings-section-description li,';
    css += '.daextlwcnf-cookie-settings-category-description li,';
    css += '#daextlwcnf-cookie-settings-description-footer li{';
    css += 'margin: 0' + declarationSuffix + ';';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsParagraphsFontColor +
        declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    //p
    css += '#daextlwcnf-cookie-settings-intro p,';
    css += '.daextlwcnf-cookie-settings-section-description p,';
    css += '.daextlwcnf-cookie-settings-category-description p,';
    css += '#daextlwcnf-cookie-settings-description-footer p{';
    css += 'margin: 0 0 20px 0' + declarationSuffix + ';';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsParagraphsFontColor +
        declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    css += '#daextlwcnf-cookie-settings-intro p:last-child,';
    css += '.daextlwcnf-cookie-settings-section-description p:last-child,';
    css += '.daextlwcnf-cookie-settings-category-description p:last-child,';
    css += '#daextlwcnf-cookie-settings-description-footer p:last-child{';
    css += 'margin: 0' + declarationSuffix + ';';
    css += '}';

    //strong
    css += '#daextlwcnf-cookie-settings-intro strong,';
    css += '.daextlwcnf-cookie-settings-section-description strong,';
    css += '.daextlwcnf-cookie-settings-category-description strong,';
    css += '#daextlwcnf-cookie-settings-description-footer strong{';
    css += 'font-weight: ' + parseInt(settings.strongTagsFontWeight, 10) +
        declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsHeadingsFontColor +
        declarationSuffix + ';';
    css += '}';

    //ol
    css += '#daextlwcnf-cookie-settings-intro ol,';
    css += '.daextlwcnf-cookie-settings-section-description ol,';
    css += '.daextlwcnf-cookie-settings-category-description ol,';
    css += '#daextlwcnf-cookie-settings-description-footer ol{';
    css += 'margin: 0 0 20px 20px' + declarationSuffix + ';';
    css += 'list-style: decimal outside none' + declarationSuffix + ';';
    css += 'padding: 0' + declarationSuffix + ';';
    css += '}';

    css += '#daextlwcnf-cookie-settings-intro ol:last-child,';
    css += '.daextlwcnf-cookie-settings-section-description ol:last-child,';
    css += '.daextlwcnf-cookie-settings-category-description ol:last-child,';
    css += '#daextlwcnf-cookie-settings-description-footer ol:last-child{';
    css += 'margin: 0 0 0 20px' + declarationSuffix + ';';
    css += '}';

    //ul
    css += '#daextlwcnf-cookie-settings-intro ul,';
    css += '.daextlwcnf-cookie-settings-section-description ul,';
    css += '.daextlwcnf-cookie-settings-category-description ul,';
    css += '#daextlwcnf-cookie-settings-description-footer ul{';
    css += 'margin: 0 0 20px 20px' + declarationSuffix + ';';
    css += 'list-style: disc outside none' + declarationSuffix + ';';
    css += 'padding: 0' + declarationSuffix + ';';
    css += '}';

    css += '#daextlwcnf-cookie-settings-intro ul:last-child,';
    css += '.daextlwcnf-cookie-settings-section-description ul:last-child,';
    css += '.daextlwcnf-cookie-settings-category-description ul:last-child,';
    css += '#daextlwcnf-cookie-settings-description-footer ul:last-child{';
    css += 'margin: 0 0 0 20px' + declarationSuffix + ';';
    css += '}';

    //li
    css += '#daextlwcnf-cookie-settings-intro li,';
    css += '.daextlwcnf-cookie-settings-section-description li,';
    css += '.daextlwcnf-cookie-settings-category-description li,';
    css += '#daextlwcnf-cookie-settings-description-footer li{';
    css += 'margin: 0' + declarationSuffix + ';';
    css += 'font-size: 13px' + declarationSuffix + ';';
    css += 'color: ' + settings.cookieSettingsParagraphsFontColor +
        declarationSuffix + ';';
    css += 'line-height: 20px' + declarationSuffix + ';';
    css += 'font-family: ' + settings.paragraphsFontFamily + '' +
        declarationSuffix + ';';
    css += 'font-weight: ' + parseInt(settings.paragraphsFontWeight, 10) + '' +
        declarationSuffix + ';';
    css += '}';

    //End

    // #media query
    css += '@media only screen and (max-width: ' +
        settings.responsiveBreakpoint + 'px),';
    css += 'screen and (max-height: 640px){';

    // #daextlwcnf-cookie-settings-container
    css += '#daextlwcnf-cookie-settings-container{';
    css += 'top: 0' + declarationSuffix + ';';
    css += 'left: 0' + declarationSuffix + ';';
    css += 'width: 100%' + declarationSuffix + ';';
    css += 'height: calc(100% - 32px)' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-body
    css += '#daextlwcnf-cookie-settings-body{';
    css += 'width: 100%' + declarationSuffix + ';';
    css += 'height: calc(100% - 187px)' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-footer
    css += '#daextlwcnf-cookie-settings-footer{';
    css += 'width: calc(100% - 48px)' + declarationSuffix + ';';
    css += 'height: 100px' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-buttons-container
    css += '#daextlwcnf-cookie-settings-buttons-container{';
    css += 'margin: 0' + declarationSuffix + ';';
    css += 'width: 100%' + declarationSuffix + ';';
    css += 'height: 100px' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-blurred-footer
    css += '#daextlwcnf-cookie-settings-blurred-footer{';
    css += 'bottom: 140px' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-button
    css += '#daextlwcnf-cookie-settings-buttons-container .daextlwcnf-cookie-settings-button{';
    css += 'padding: 0' + declarationSuffix + ';';
    css += 'width: calc(100% - 2px)' + declarationSuffix + ';';
    css += 'display: block' + declarationSuffix + ';';
    css += 'text-align: center' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-button-1
    css += '#daextlwcnf-cookie-settings-button-1{';
    css += 'margin-bottom: 20px' + declarationSuffix + ';';
    css += '}';

    // #daextlwcnf-cookie-settings-button-2
    css += '#daextlwcnf-cookie-settings-button-2{';
    css += 'margin: 0' + declarationSuffix + ';';
    css += '}';

    css += '}';

    //Add the style element to the DOM
    let style = document.createElement('style');
    style.innerHTML = css;
    style.id = 'daextlwcnf-cookie-settings-style';
    document.head.appendChild(style);

  }

  /**
   * Bind all the event listeners.
   */
  function bindEventListeners() {

    'use strict';

    //Add click event listener on the button 1
    let bt1 = document.getElementById('daextlwcnf-cookie-settings-button-1');
    if (bt1) {
      bt1.addEventListener('click', function() {
        switch (parseInt(settings.cookieSettingsButton1Action, 10)) {
          case 1:
            utility.acceptCookies(settings);
            utility.reload(settings);
            closeCookieSettings();
            utility.closeNotice();
            revisitCookieConsent.initialize(settings);
            break;
          case 2:
            closeCookieSettings();
            break;
          case 3:
            window.location.href = settings.cookieSettingsButton1Url;
            break;
          case 4:
            utility.acceptCookies(settings, true);
            utility.reload(settings);
            closeCookieSettings();
            utility.closeNotice();
            revisitCookieConsent.initialize(settings);
            break;
          case 5:
            utility.acceptCookies(settings, false, true);
            utility.reload(settings);
            closeCookieSettings();
            utility.closeNotice();
            revisitCookieConsent.initialize(settings);
            break;
        }
      });
    }

    //Add click event listener on the button 2
    let bt2 = document.getElementById('daextlwcnf-cookie-settings-button-2');
    if (bt2) {
      bt2.addEventListener('click', function() {
        switch (parseInt(settings.cookieSettingsButton2Action, 10)) {
          case 1:
            utility.acceptCookies(settings);
            utility.reload(settings);
            closeCookieSettings();
            utility.closeNotice();
            revisitCookieConsent.initialize(settings);
            break;
          case 2:
            closeCookieSettings();
            break;
          case 3:
            window.location.href = settings.cookieSettingsButton2Url;
            break;
          case 4:
            utility.acceptCookies(settings, true);
            utility.reload(settings);
            closeCookieSettings();
            utility.closeNotice();
            revisitCookieConsent.initialize(settings);
            break;
          case 5:
            utility.acceptCookies(settings, false, true);
            utility.reload(settings);
            closeCookieSettings();
            utility.closeNotice();
            revisitCookieConsent.initialize(settings);
            break;
        }
      });
    }

    //Add click event listener to all the section chevrons
    let list = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-section-chevron');
    for (let i = 0; i < list.length; i++) {
      list[i].addEventListener('click', function() {
        toggleSection(this);
      });
    }

    //Add click event listener to all the category expand buttons
    let list4 = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-category-expand');
    for (let i = 0; i < list4.length; i++) {
      list4[i].addEventListener('click', toggleCategoryDescription);
    }

    //Add click event listener on the category toggles
    let categoryToggles = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-category-toggle');
    for (let i = 0; i < categoryToggles.length; i++) {
      if (parseInt(categoryToggles[i].getAttribute('data-toggle'), 10) === 1) {
        categoryToggles[i].addEventListener('click', setCategoryCookie);
      }
    }

    //Add click event listener on the section toggles
    let sectionToggles = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-section-toggle');
    for (let i = 0; i < sectionToggles.length; i++) {
      if (parseInt(sectionToggles[i].getAttribute('data-toggle'), 10) === 1) {
        sectionToggles[i].addEventListener('click', handleSectionToggle);
      }
    }

  }

  /**
   * Changes the class of the chevron and toggles the visibility of the section.
   */
  function toggleSection(thisCopy) {

    'use strict';

    //Change the class of the chevron
    if (thisCopy.classList.contains('down')) {
      thisCopy.classList.remove('down');
    } else {
      thisCopy.classList.add('down');
    }

    //Toggle the visibility of the section
    let section_id = thisCopy.getAttribute('data-section-id');
    let list = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-section-body');
    for (let i = 0; i < list.length; i++) {
      if (list[i].getAttribute('data-section-id') == section_id) {
        if (list[i].style.display != 'block') {
          list[i].style.display = 'block';
        } else {
          list[i].style.display = 'none';
        }
      }
    }
  }

  /**
   * Display and hide the description of the category.
   *
   * This method is called when the plus/minus sign beside the category title is clicked
   *
   * @param event
   */
  function toggleCategoryDescription(event) {

    'use strict';

    let categoryId = this.getAttribute('data-category-id');
    let status = this.getAttribute('data-status');

    //Iterate through all the categories and toggle only the category description associated with this category
    let collectionCD = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-category-description');
    for (let i = 0; i < collectionCD.length; i++) {
      if (collectionCD[i].getAttribute('data-category-id') == categoryId) {
        if (status == 0) {
          //Display
          collectionCD[i].style.display = 'block';
          this.setAttribute('data-status', '1');
        } else {
          //Hide
          collectionCD[i].style.display = 'none';
          this.setAttribute('data-status', '0');
        }
      }
    }

    //Iterate through all the categories and toggle only the category cookie list associated with this category
    let collectionCCL = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-category-cookie-list');
    for (let i = 0; i < collectionCCL.length; i++) {
      if (collectionCCL[i].getAttribute('data-category-id') == categoryId) {
        if (status == 0) {
          //Display
          collectionCCL[i].style.display = 'block';
          this.setAttribute('data-status', '1');
        } else {
          //Hide
          collectionCCL[i].style.display = 'none';
          this.setAttribute('data-status', '0');
        }
      }
    }

  }

  /**
   * This method does what follows:
   *
   * 1 - Find the new section states and category state based on custom criteria.
   * 2 - Change the state of the category toggles to the next status.
   * 3 - Change the state of the section toggle.
   * 4 - Save the status of all the categories in the serialized "daextlwcnf-category-status" cookie.
   *
   * @param event
   */
  function handleSectionToggle(event) {

    'use strict';

    let sectionId = this.getAttribute('data-id');
    let sectionState = this.getAttribute('data-status');
    let nextCategoryState = null;
    let nextSectionState = null;
    let list = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-category-toggle');
    let categoriesOfSection = [];
    let counter = 0;
    let disabledCounter = 0;
    let disabledOffCounter = 0;
    let disabledOnCounter = 0;

    //Generate the collection with the toggles associated with the categories of the section
    for (let i = 0; i < list.length; i++) {
      if (list[i].getAttribute('data-section-id') == sectionId) {
        categoriesOfSection.push(list[i]);
      }
    }

    /**
     * Iterate the toggles associated with the categories of the section and find the following values:
     *
     * - counter: The total number of toogles
     * - disabledCounter: The number of disabled toogles
     * - disabledOffCounter: The number of disabled toogles in "off" state
     * - disabledOffCounter: The number of disabled toogles in "on" state
     *
     * Note that these data are required in the other steps.
     */
    categoriesOfSection.forEach(function(categoryOfSection) {
      counter++;
      if (parseInt(categoryOfSection.getAttribute('data-toggle'), 10) === 0) {
        disabledCounter++;
        if (parseInt(categoryOfSection.getAttribute('data-status'), 10) === 0) {
          disabledOffCounter++;
        } else {
          disabledOnCounter++;
        }
      }
    });

    /**
     * 1. Find the new section states and category state based on custom criteria.
     *
     * Note that:
     *
     * - The disabledOffCounter is used to verify if the state 2 is reachable for the section.
     * - The disabledOnCounter is used to verify if the state 0 is reachable for the section.
     */
    if (parseInt(sectionState, 10) === 1) {
      if (disabledOffCounter === 0) {
        nextSectionState = 2;
        nextCategoryState = 2;
      } else {
        nextSectionState = 0;
        nextCategoryState = 0;
      }
    } else if (parseInt(sectionState, 10) === 0) {
      if (disabledOffCounter === 0) {
        nextSectionState = 2;
        nextCategoryState = 2;
      } else {
        nextSectionState = 1;
        nextCategoryState = 2;
      }
    } else if (parseInt(sectionState, 10) === 2) {
      if (disabledOnCounter === 0) {
        nextSectionState = 0;
        nextCategoryState = 0;
      } else {
        nextSectionState = 1;
        nextCategoryState = 0;
      }
    }

    /**
     * 2. Change the state of the category toggles to the next status (the nextCategoryState value is used).
     *
     * Note that the category toogle is not modified for the categories with the toggle disabled.
     */
    categoriesOfSection.forEach(function(categoryOfSection) {
      if (categoryOfSection.getAttribute('data-section-id') == sectionId) {
        if (parseInt(categoryOfSection.getAttribute('data-toggle'), 10) === 1) {
          categoryOfSection.setAttribute('data-status', nextCategoryState);
        }
      }
    });

    //3. Change the state of the section toggle. (the nextSectionState value is used).
    this.setAttribute('data-status', nextSectionState);

    //4. Save the status of all the categories in the serialized "daextlwcnf-category-status" cookie.
    saveCategoryCookiesInCookie();

  }

  /**
   * This methods does what follows:
   *
   * 1 - Toggle the status of the considered category toggle.
   * 2 - Save the status of all the category toggles in the "daextlwcnf-category-status" cookie.
   * 3 - Update the status of the section toggles based on the values of the category toggles.
   */
  function setCategoryCookie() {

    'use strict';

    //1 - Toggle the status of the considered category toggle
    let nextStatus = null;
    let status = this.getAttribute('data-status');
    switch (parseInt(status, 10)) {
      case 0:
        nextStatus = 2;
        break;
      case 2:
        nextStatus = 0;
        break;
    }
    this.setAttribute('data-status', nextStatus);

    //2 - Save the status of all the category toggles in the "daextlwcnf-category-status" cookie
    saveCategoryCookiesInCookie();

    //3 - Update the status of the section toggles based on the values of the category toggles
    let sectionId = this.getAttribute('data-section-id');
    updateSectionToggle(sectionId);

  }

  /**
   * Save the status of all the categories in the serialized "daextlwcnf-category-status" cookie.
   */
  function saveCategoryCookiesInCookie() {

    'use strict';

    let categoryCookies = [];
    let elements = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-category-toggle');

    //Get the category id and the value of all the cookies associated with the categories and save them in an array
    for (let i = 0; i < elements.length; i++) {
      let status = elements[i].getAttribute('data-status');
      let categoryId = elements[i].getAttribute('data-id');
      categoryCookies.push({
        'categoryId': categoryId,
        'status': parseInt(status, 10) === 2 ? '1' : '0',
      });
    }

    //Convert the array with the data to JSON and save these data in the 'daextlwcnf-category-status' cookie.
    categoryCookies = JSON.stringify(categoryCookies);
    utility.setCookie('daextlwcnf-category-status', categoryCookies,
        settings);

  }

  /**
   * Moves the section toggle of the specified section to the correct status based on the status of the category
   * toggles of the specified section.
   *
   * @param sectionId
   */
  function updateSectionToggle(sectionId) {

    'use strict';

    let checkedCategoryToggleCounter = 0;
    let categoryToggleCounter = 0;
    let status = 0;

    //Counts the total number of category toggles and the number of category toogle with enabled status.
    let categoryToggles = document.getElementsByClassName(
        'daextlwcnf-cookie-settings-category-toggle');
    for (let i = 0; i < categoryToggles.length; i++) {
      if (categoryToggles[i].getAttribute('data-section-id') == sectionId) {
        categoryToggleCounter++;
        let status = categoryToggles[i].getAttribute('data-status');
        if (status == '2') {
          checkedCategoryToggleCounter++;
        }
      }
    }

    /**
     *  Verify how many category toggles of this section are selected:
     *
     * - If they are all set a green (right position) toggle
     * - If they are more than 0 set an orange (middle position) toggle
     * - If they are 0 set a grey (left position) toggle
     */
    if (checkedCategoryToggleCounter > 0 &&
        categoryToggleCounter == checkedCategoryToggleCounter) {
      //Right position
      status = 2;
    } else if (checkedCategoryToggleCounter > 0 &&
        categoryToggleCounter > checkedCategoryToggleCounter) {
      //Middle position
      status = 1;
    } else if (checkedCategoryToggleCounter == 0) {
      //Left position
      status = 0;
    }

    //Move the section toggle to the correct status
    let el1 = document.querySelector(
        '.daextlwcnf-cookie-settings-section-toggle[data-id="' + sectionId +
        '"]');
    el1.setAttribute('data-status', status);

  }

  /**
   * Removes the cookie settings modal window and the cookie settings mask from the DOM.
   */
  function closeCookieSettings() {

    'use strict';

    //Remove the cookie settings window from the DOM
    document.getElementById('daextlwcnf-cookie-settings-container').remove();

    //Remove the cookie settings mask from the DOM
    let mm = document.getElementById('daextlwcnf-cookie-settings-mask');
    if (mm) {
      document.getElementById('daextlwcnf-cookie-settings-mask').remove();
    }

    //Remove the style associated with the cookie settings from the head section
    document.getElementById('daextlwcnf-cookie-settings-style').remove();

  }

  //Return an object exposed to the public -----------------------------------------------------------------------------
  return {

    initialize: function(configuration) {

      //Merge the custom configuration provided by the user with the default configuration
      settings = configuration;

      //Add the news ticker to the DOM
      addToDOM();

      //Apply the style available in the settings
      applyStyle();

      //Bind event listeners
      bindEventListeners();

    },

  };

}(daextlwcnUtility, daextlwcnRevisitCookieConsent));