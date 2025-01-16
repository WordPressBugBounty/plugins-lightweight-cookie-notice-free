<?php
/**
 * This class should be used to stores properties and methods shared by the
 * admin and public side of WordPress.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * This class should be used to stores properties and methods shared by the
 *  admin and public side of WordPress.
 */
class Daextlwcnf_Shared {

	/**
	 * The singleton instance of the class.
	 *
	 * @var Daextlwcnf_Shared
	 */
	protected static $instance = null;

	/**
	 * The data of the plugin.
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * Constructor.
	 */
	private function __construct() {

		$this->data['slug'] = 'daextlwcnf';
		$this->data['ver']  = '1.17';
		$this->data['dir']  = substr( plugin_dir_path( __FILE__ ), 0, - 7 );
		$this->data['url']  = substr( plugin_dir_url( __FILE__ ), 0, - 7 );

		// Here are stored the plugin option with the related default values.
		$this->data['options'] = array(

			// Database version. (not available in the options UI).
			$this->get( 'slug' ) . '_database_version'     => '0',

			// Options version. (not available in the options UI).
			$this->get( 'slug' ) . '_options_version'      => '0',

			// General ------------------------------------------------------------------------------------------------.
			$this->get( 'slug' ) . '_headings_font_family' => "'Open Sans', Helvetica, Arial, sans-serif",
			$this->get( 'slug' ) . '_headings_font_weight' => '600',
			$this->get( 'slug' ) . '_paragraphs_font_family' => "'Open Sans', Helvetica, Arial, sans-serif",
			$this->get( 'slug' ) . '_paragraphs_font_weight' => '400',
			$this->get( 'slug' ) . '_strong_tags_font_weight' => '600',
			$this->get( 'slug' ) . '_buttons_font_family'  => "'Open Sans', Helvetica, Arial, sans-serif",
			$this->get( 'slug' ) . '_buttons_font_weight'  => '400',
			$this->get( 'slug' ) . '_buttons_border_radius' => '4',
			$this->get( 'slug' ) . '_containers_border_radius' => '4',

			// Cookie Notice ------------------------------------------------------------------------------------------.
			$this->get( 'slug' ) . '_cookie_notice_main_message_text' => esc_html__( 'This site uses cookies to improve your online experience, allow you to share content on social media, measure traffic to this website and display customised ads based on your browsing activity.', 'lightweight-cookie-notice-free' ),
			$this->get( 'slug' ) . '_cookie_notice_main_message_font_color' => '#666666',
			$this->get( 'slug' ) . '_cookie_notice_main_message_link_font_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_1_text' => esc_html__( 'Settings', 'lightweight-cookie-notice-free' ),
			$this->get( 'slug' ) . '_cookie_notice_button_1_action' => '1',
			$this->get( 'slug' ) . '_cookie_notice_button_1_url' => '',
			$this->get( 'slug' ) . '_cookie_notice_button_1_background_color' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_notice_button_1_background_color_hover' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_notice_button_1_border_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_1_border_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_1_font_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_1_font_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_2_text' => esc_html__( 'Accept', 'lightweight-cookie-notice-free' ),
			$this->get( 'slug' ) . '_cookie_notice_button_2_action' => '2',
			$this->get( 'slug' ) . '_cookie_notice_button_2_url' => '',
			$this->get( 'slug' ) . '_cookie_notice_button_2_background_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_2_background_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_2_border_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_2_border_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_2_font_color' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_notice_button_2_font_color_hover' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_notice_button_3_text' => esc_html__( 'Default Label', 'lightweight-cookie-notice-free' ),
			$this->get( 'slug' ) . '_cookie_notice_button_3_action' => '0',
			$this->get( 'slug' ) . '_cookie_notice_button_3_url' => '',
			$this->get( 'slug' ) . '_cookie_notice_button_3_background_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_3_background_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_3_border_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_3_border_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_notice_button_3_font_color' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_notice_button_3_font_color_hover' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_notice_button_dismiss_action' => '0',
			$this->get( 'slug' ) . '_cookie_notice_button_dismiss_url' => '',
			$this->get( 'slug' ) . '_cookie_notice_button_dismiss_color' => '#646464',
			$this->get( 'slug' ) . '_cookie_notice_container_position' => '2',
			$this->get( 'slug' ) . '_cookie_notice_container_width' => '1140',
			$this->get( 'slug' ) . '_cookie_notice_container_opacity' => '1',
			$this->get( 'slug' ) . '_cookie_notice_container_border_width' => '0',
			$this->get( 'slug' ) . '_cookie_notice_container_background_color' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_notice_container_border_color' => '#e1e1e1',
			$this->get( 'slug' ) . '_cookie_notice_container_border_opacity' => '1',
			$this->get( 'slug' ) . '_cookie_notice_container_drop_shadow' => '1',
			$this->get( 'slug' ) . '_cookie_notice_container_drop_shadow_color' => '#242f42',
			$this->get( 'slug' ) . '_cookie_notice_mask'   => '0',
			$this->get( 'slug' ) . '_cookie_notice_mask_color' => '#242f42',
			$this->get( 'slug' ) . '_cookie_notice_mask_opacity' => '0.54',
			$this->get( 'slug' ) . '_cookie_notice_shake_effect' => '0',

			// Cookie Settings ----------------------------------------------------------------------------------------.
			$this->get( 'slug' ) . '_cookie_settings_logo_url' => '',
			$this->get( 'slug' ) . '_cookie_settings_title' => esc_html__( 'Cookie Settings', 'lightweight-cookie-notice-free' ),
			$this->get( 'slug' ) . '_cookie_settings_description_header' => '<p>' . esc_html__( 'We want to be transparent about the data we and our partners collect and how we use it, so you can best exercise control over your personal data. For more information, please see our Privacy Policy.', 'lightweight-cookie-notice-free' ) . '</p><p><strong>' . esc_html__( 'Information we collect', 'lightweight-cookie-notice-free' ) . '</strong></p><p>' . esc_html__( 'We use this information to improve the performance and experience of our site visitors. This includes improving search results, showing more relevant content and promotional materials, better communication, and improved site performance.', 'lightweight-cookie-notice-free' ) . '<p>',
			$this->get( 'slug' ) . '_cookie_settings_toggle_on_color' => '#3a70c4',
			$this->get( 'slug' ) . '_cookie_settings_toggle_off_color' => '#808080',
			$this->get( 'slug' ) . '_cookie_settings_toggle_misc_color' => '#808080',
			$this->get( 'slug' ) . '_cookie_settings_toggle_disabled_color' => '#e5e5e5',
			$this->get( 'slug' ) . '_cookie_settings_chevron_color' => '#6e6e6e',
			$this->get( 'slug' ) . '_cookie_settings_expand_close_color' => '#6e6e6e',
			$this->get( 'slug' ) . '_cookie_settings_description_footer' => '<p><strong>' . esc_html__( 'Information about cookies', 'lightweight-cookie-notice-free' ) . '</strong></p><p>' . esc_html__( 'We use the following essential and non-essential cookies to better improve your overall web browsing experience. Our partners use cookies and other mechanisms to connect you with your social networks and tailor advertising to better match your interests.', 'lightweight-cookie-notice-free' ) . '</p><p>' . esc_html__( 'You can make your choices by allowing categories of cookies by using the respective activation switches. Essential cookies cannot be rejected as without them certain core website functionalities would not work.', 'lightweight-cookie-notice-free' ) . '</p>',
			$this->get( 'slug' ) . '_cookie_settings_button_1_text' => esc_html__( 'Close', 'lightweight-cookie-notice-free' ),
			$this->get( 'slug' ) . '_cookie_settings_button_1_action' => '2',
			$this->get( 'slug' ) . '_cookie_settings_button_1_url' => '',
			$this->get( 'slug' ) . '_cookie_settings_button_1_background_color' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_settings_button_1_background_color_hover' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_settings_button_1_border_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_button_1_border_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_button_1_font_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_button_1_font_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_button_2_text' => esc_html__( 'Accept', 'lightweight-cookie-notice-free' ),
			$this->get( 'slug' ) . '_cookie_settings_button_2_action' => '1',
			$this->get( 'slug' ) . '_cookie_settings_button_2_url' => '',
			$this->get( 'slug' ) . '_cookie_settings_button_2_background_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_button_2_background_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_button_2_border_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_button_2_border_color_hover' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_button_2_font_color' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_settings_button_2_font_color_hover' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_settings_headings_font_color' => '#222222',
			$this->get( 'slug' ) . '_cookie_settings_paragraphs_font_color' => '#666666',
			$this->get( 'slug' ) . '_cookie_settings_links_font_color' => '#1e58b1',
			$this->get( 'slug' ) . '_cookie_settings_container_background_color' => '#ffffff',
			$this->get( 'slug' ) . '_cookie_settings_container_opacity' => '1.0',
			$this->get( 'slug' ) . '_cookie_settings_container_border_width' => '0',
			$this->get( 'slug' ) . '_cookie_settings_container_border_color' => '#e1e1e1',
			$this->get( 'slug' ) . '_cookie_settings_container_border_opacity' => '1.0',
			$this->get( 'slug' ) . '_cookie_settings_container_drop_shadow' => '1',
			$this->get( 'slug' ) . '_cookie_settings_container_drop_shadow_color' => '#242f42',
			$this->get( 'slug' ) . '_cookie_settings_container_highlight_color' => '#f8f8f8',
			$this->get( 'slug' ) . '_cookie_settings_separator_color' => '#e1e1e1',
			$this->get( 'slug' ) . '_cookie_settings_mask' => '1',
			$this->get( 'slug' ) . '_cookie_settings_mask_color' => '#242f42',
			$this->get( 'slug' ) . '_cookie_settings_mask_opacity' => '0.54',

			// Revisit Consent ----------------------------------------------------------------------------------------.
			$this->get( 'slug' ) . '_revisit_consent_button_enable' => '1',
			$this->get( 'slug' ) . '_revisit_consent_button_tooltip_text' => 'Cookie Settings',
			$this->get( 'slug' ) . '_revisit_consent_button_position' => 'left',
			$this->get( 'slug' ) . '_revisit_consent_button_background_color' => '#1e58b1',
			$this->get( 'slug' ) . '_revisit_consent_button_icon_color' => '#ffffff',

			// Geolocation --------------------------------------------------------------------------------------------.
			$this->get( 'slug' ) . '_enable_geolocation'   => '0',
			$this->get( 'slug' ) . '_geolocation_service'  => '0',
			$this->get( 'slug' ) . '_geolocation_behavior' => '0',
			$this->get( 'slug' ) . '_geolocation_locale'   => array(
				'at',
				'be',
				'bg',
				'cy',
				'cz',
				'dk',
				'ee',
				'fi',
				'fr',
				'hu',
				'ie',
				'it',
				'lv',
				'lt',
				'lu',
				'mt',
				'nl',
				'pl',
				'pt',
				'sk',
				'si',
				'es',
				'se',
				'gb',
			),
			$this->get( 'slug' ) . '_geolocation_subdivision' => array(),
			$this->get( 'slug' ) . '_maxmind_database_file_path' => '',
			$this->get( 'slug' ) . '_maxmind_database_city_file_path' => '',

			// Advanced -----------------------------------------------------------------------------------------------.
			$this->get( 'slug' ) . '_assets_mode'          => '1',
			$this->get( 'slug' ) . '_test_mode'            => '0',
			$this->get( 'slug' ) . '_cookie_expiration'    => '0',
			$this->get( 'slug' ) . '_cookie_path_attribute' => '/',
			$this->get( 'slug' ) . '_reload_page'          => '0',
			$this->get( 'slug' ) . '_store_user_consent'   => '1',
			$this->get( 'slug' ) . '_transient_expiration' => '0',
			$this->get( 'slug' ) . '_google_font_url'      => 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap',
			$this->get( 'slug' ) . '_responsive_breakpoint' => '700',
			$this->get( 'slug' ) . '_cookie_table_columns' => array(
				'name',
				'expiration',
				'purpose',
			),
			$this->get( 'slug' ) . '_force_css_specificity' => '1',
			$this->get( 'slug' ) . '_compress_output'      => '1',
			$this->get( 'slug' ) . '_page_fragment_caching_exception_w3tc' => '0',
			$this->get( 'slug' ) . '_max_displayed_consent_log_records' => '1000',

		);

		// Country list (ISO 3166-1 alpha-2).
		$geolocation_locale                                        = array(
			'Andorra'                                      => 'ad',
			'United Arab Emirates'                         => 'ae',
			'Afghanistan'                                  => 'af',
			'Antigua and Barbuda'                          => 'ag',
			'Anguilla'                                     => 'ai',
			'Albania'                                      => 'al',
			'Armenia'                                      => 'am',
			'Angola'                                       => 'ao',
			'Antartica'                                    => 'aq',
			'Argentina'                                    => 'ar',
			'American Samoa'                               => 'as',
			'Austria'                                      => 'at',
			'Australia'                                    => 'au',
			'Aruba'                                        => 'aw',
			'Åland Islands'                                => 'ax',
			'Azerbaijan'                                   => 'az',
			'Bosnia and Herzegovina'                       => 'ba',
			'Barbados'                                     => 'bb',
			'Bangladesh'                                   => 'bd',
			'Belgium'                                      => 'be',
			'Burkina Faso'                                 => 'bf',
			'Bulgaria'                                     => 'bg',
			'Bahrain'                                      => 'bh',
			'Burundi'                                      => 'bi',
			'Benin'                                        => 'bj',
			'Saint Barthélemy'                             => 'bl',
			'Bermuda'                                      => 'bm',
			'Brunei Darussalam'                            => 'bn',
			'Bolivia'                                      => 'bo',
			'Bonaire, Sint Eustatius and Saba'             => 'bq',
			'Brazil'                                       => 'br',
			'Bahamas'                                      => 'bs',
			'Bhutan'                                       => 'bt',
			'Bouvet Island'                                => 'bv',
			'Botswana'                                     => 'bw',
			'Belarus'                                      => 'by',
			'Belize'                                       => 'bz',
			'Canada'                                       => 'ca',
			'Cocos (Keeling) Islands'                      => 'cc',
			'Congo Democratic Republic'                    => 'cd',
			'Central African Republic'                     => 'cf',
			'Congo'                                        => 'cg',
			'Switzerland'                                  => 'ch',
			'Côte d\'Ivoire'                               => 'ci',
			'Cook Islands'                                 => 'ck',
			'Chile'                                        => 'cl',
			'Cameroon'                                     => 'cm',
			'China'                                        => 'cn',
			'Colombia'                                     => 'co',
			'Costa Rica'                                   => 'cr',
			'Cuba'                                         => 'cu',
			'Cape Verde'                                   => 'cv',
			'Curaçao'                                      => 'cw',
			'Christmas Island'                             => 'cx',
			'Cyprus'                                       => 'cy',
			'Czech Republic'                               => 'cz',
			'Germany'                                      => 'de',
			'Djibouti'                                     => 'dj',
			'Denmark'                                      => 'dk',
			'Dominica'                                     => 'dm',
			'Dominican Republic'                           => 'do',
			'Algeria'                                      => 'dz',
			'Ecuador'                                      => 'ec',
			'Estonia'                                      => 'ee',
			'Egypt'                                        => 'eg',
			'Western Sahara'                               => 'eh',
			'Eritrea'                                      => 'er',
			'Spain'                                        => 'es',
			'Ethiopia'                                     => 'et',
			'Finland'                                      => 'fi',
			'Fiji'                                         => 'fj',
			'Falkland Islands (Malvinas)'                  => 'fk',
			'Micronesia Federated States of'               => 'fm',
			'Faroe Islands'                                => 'fo',
			'France'                                       => 'fr',
			'Gabon'                                        => 'ga',
			'United Kingdom'                               => 'gb',
			'Grenada'                                      => 'gd',
			'Georgia'                                      => 'ge',
			'French Guiana'                                => 'gf',
			'Guernsey'                                     => 'gg',
			'Ghana'                                        => 'gh',
			'Gibraltar'                                    => 'gi',
			'Greenland'                                    => 'gl',
			'Gambia'                                       => 'gm',
			'Guinea'                                       => 'gn',
			'Guadeloupe'                                   => 'gp',
			'Equatorial Guinea'                            => 'gq',
			'Greece'                                       => 'gr',
			'South Georgia and the South Sandwich Islands' => 'gs',
			'Guatemala'                                    => 'gt',
			'Guam'                                         => 'gu',
			'Guinea-Bissau'                                => 'gw',
			'Guyana'                                       => 'gy',
			'Hong Kong'                                    => 'hk',
			'Heard Island and McDonald Islands'            => 'hm',
			'Honduras'                                     => 'hn',
			'Croatia'                                      => 'hr',
			'Haiti'                                        => 'ht',
			'Hungary'                                      => 'hu',
			'Indonesia'                                    => 'id',
			'Ireland'                                      => 'ie',
			'Israel'                                       => 'il',
			'Isle of Man'                                  => 'im',
			'India'                                        => 'in',
			'British Indian Ocean Territory'               => 'io',
			'Iraq'                                         => 'iq',
			'Iran, Islamic Republic of'                    => 'ir',
			'Iceland'                                      => 'is',
			'Italy'                                        => 'it',
			'Jersey'                                       => 'je',
			'Jamaica'                                      => 'jm',
			'Jordan'                                       => 'jo',
			'Japan'                                        => 'jp',
			'Kenya'                                        => 'ke',
			'Kyrgyzstan'                                   => 'kg',
			'Cambodia'                                     => 'kh',
			'Kiribati'                                     => 'ki',
			'Comoros'                                      => 'km',
			'Saint Kitts and Nevis'                        => 'kn',
			'Korea, Democratic People\'s Republic of'      => 'kp',
			'Korea, Republic of'                           => 'kr',
			'Kuwait'                                       => 'kw',
			'Cayman Islands'                               => 'ky',
			'Kazakhstan'                                   => 'kz',
			'Lao People\'s Democratic Republic'            => 'la',
			'Lebanon'                                      => 'la',
			'Saint Lucia'                                  => 'lc',
			'Liechtenstein'                                => 'li',
			'Sri Lanka'                                    => 'lk',
			'Liberia'                                      => 'lr',
			'Lesotho'                                      => 'ls',
			'Lithuania'                                    => 'lt',
			'Luxembourg'                                   => 'lu',
			'Latvia'                                       => 'lv',
			'Libya'                                        => 'ly',
			'Morocco'                                      => 'ma',
			'Monaco'                                       => 'mc',
			'Moldova, Republic of'                         => 'md',
			'Montenegro'                                   => 'me',
			'Saint Martin (French part)'                   => 'mf',
			'Madagascar'                                   => 'mg',
			'Marshall Islands'                             => 'mh',
			'Macedonia, the former Yugoslav Republic of'   => 'mk',
			'Mali'                                         => 'ml',
			'Myanmar'                                      => 'mm',
			'Mongolia'                                     => 'mn',
			'Macao'                                        => 'mo',
			'Northern Mariana Islands'                     => 'mp',
			'Martinique'                                   => 'mq',
			'Mauritania'                                   => 'mr',
			'Montserrat'                                   => 'ms',
			'Malta'                                        => 'mt',
			'Mauritius'                                    => 'mu',
			'Maldives'                                     => 'mv',
			'Malawi'                                       => 'mw',
			'Mexico'                                       => 'mx',
			'Malaysia'                                     => 'my',
			'Mozambique'                                   => 'mz',
			'Namibia'                                      => 'na',
			'New Caledonia'                                => 'nc',
			'Niger'                                        => 'ne',
			'Norfolk Island'                               => 'nf',
			'Nigeria'                                      => 'ng',
			'Nicaragua'                                    => 'ni',
			'Netherlands'                                  => 'nl',
			'Norway'                                       => 'no',
			'Nepal'                                        => 'np',
			'Nauru'                                        => 'nr',
			'Niue'                                         => 'nu',
			'New Zealand'                                  => 'nz',
			'Oman'                                         => 'om',
			'Panama'                                       => 'pa',
			'Peru'                                         => 'pe',
			'French Polynesia'                             => 'pf',
			'Papua New Guinea'                             => 'pg',
			'Philippines'                                  => 'ph',
			'Pakistan'                                     => 'pk',
			'Poland'                                       => 'pl',
			'Saint Pierre and Miquelon'                    => 'pm',
			'Pitcairn'                                     => 'pn',
			'Puerto Rico'                                  => 'pr',
			'Palestine, State of'                          => 'ps',
			'Portugal'                                     => 'pt',
			'Palau'                                        => 'pw',
			'Paraguay'                                     => 'py',
			'Qatar'                                        => 'qa',
			'Réunion'                                      => 're',
			'Romania'                                      => 'ro',
			'Serbia'                                       => 'rs',
			'Russian Federation'                           => 'ru',
			'Rwanda'                                       => 'rw',
			'Saudi Arabia'                                 => 'sa',
			'Solomon Islands'                              => 'sb',
			'Seychelles'                                   => 'sc',
			'Sudan'                                        => 'sd',
			'Sweden'                                       => 'se',
			'Singapore'                                    => 'sg',
			'Saint Helena, Ascension and Tristan da Cunha' => 'sh',
			'Slovenia'                                     => 'si',
			'Svalbard and Jan Mayen'                       => 'sj',
			'Slovakia'                                     => 'sk',
			'Sierra Leone'                                 => 'sl',
			'San Marino'                                   => 'sm',
			'Senegal'                                      => 'sn',
			'Somalia'                                      => 'so',
			'Suriname'                                     => 'sr',
			'South Sudan'                                  => 'ss',
			'Sao Tome and Principe'                        => 'st',
			'El Salvador'                                  => 'sv',
			'Sint Maarten (Dutch part)'                    => 'sx',
			'Syrian Arab Republic'                         => 'sy',
			'Swaziland'                                    => 'sz',
			'Turks and Caicos Islands'                     => 'tc',
			'Chad'                                         => 'td',
			'French Southern Territories'                  => 'tf',
			'Togo'                                         => 'tg',
			'Thailand'                                     => 'th',
			'Tajikistan'                                   => 'tj',
			'Tokelau'                                      => 'tk',
			'Timor-Leste'                                  => 'tl',
			'Turkmenistan'                                 => 'tm',
			'Tunisia'                                      => 'tn',
			'Tonga'                                        => 'to',
			'Turkey'                                       => 'tr',
			'Trinidad and Tobago'                          => 'tt',
			'Tuvalu'                                       => 'tv',
			'Taiwan, Province of China'                    => 'tw',
			'Tanzania, United Republic of'                 => 'tz',
			'Ukraine'                                      => 'ua',
			'Uganda'                                       => 'ug',
			'United States Minor Outlying Islands'         => 'um',
			'United States'                                => 'us',
			'Uruguay'                                      => 'uy',
			'Uzbekistan'                                   => 'uz',
			'Holy See (Vatican City State)'                => 'va',
			'Saint Vincent and the Grenadines'             => 'vc',
			'Venezuela, Bolivarian Republic of'            => 've',
			'Virgin Islands, British'                      => 'vg',
			'Virgin Islands, U.S.'                         => 'vi',
			'Viet Nam'                                     => 'vn',
			'Vanuatu'                                      => 'vu',
			'Wallis and Futuna'                            => 'wf',
			'Samoa'                                        => 'ws',
			'Yemen'                                        => 'ye',
			'Mayotte'                                      => 'yt',
			'South Africa'                                 => 'za',
			'Zambia'                                       => 'zm',
			'Zimbabwe'                                     => 'zw',
		);
		$this->data['options'][ $this->get( 'slug' ) . '_locale' ] = $geolocation_locale;
	}

	/**
	 * Get the singleton instance of the class.
	 *
	 * @return Daextlwcnf_Shared|self|null
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Retrieve data.
	 *
	 * @param string $index The index of the data to retrieve.
	 *
	 * @return mixed
	 */
	public function get( $index ) {
		return $this->data[ $index ];
	}

	/**
	 * Returns true if one or more categories are using the specified section.
	 *
	 * @param int $section_id The section ID.
	 *
	 * @return bool
	 */
	public function section_is_used_in_categories( $section_id ) {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$total_items = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}daextlwcnf_category WHERE section_id = %d", $section_id )
		);

		if ( $total_items > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns true if one or more cookies are using the specified category.
	 *
	 * @param int $category_id The category ID.
	 *
	 * @return bool
	 */
	public function category_is_used_in_cookies( $category_id ) {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$total_items = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}daextlwcnf_cookie WHERE category_id = %d", $category_id )
		);

		if ( $total_items > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Verifies if the provided IP address belongs to a country included in the "Geolocation Locale" option.
	 *
	 * @param string $country_code The country code.
	 * @param object $city The city object.
	 *
	 * @return bool Returns True if the country associated with the IP address is included in the "Geolocation Locale"
	 * option, otherwise returns false.
	 * @throws \MaxMind\Db\Reader\InvalidDatabaseException If there is an issue with the MaxMind database.
	 */
	public function is_valid_locale_maxmind_geolite2( $country_code, $city ) {

		$result = false;

		// Get the list of the countries from the "Geolocation Locale" option.
		$country_iso_code     = $country_code;
		$geolocation_locale   = get_option( $this->get( 'slug' ) . '_geolocation_locale' );
		$geolocation_locale_a = maybe_unserialize( $geolocation_locale );

		// Verify if the detected locale is present in the list of the countries.
		if ( is_array( $geolocation_locale_a ) && null !== $country_iso_code ) {
			foreach ( $geolocation_locale_a as $key => $single_geolocation_locale ) {
				if ( mb_strtolower( $single_geolocation_locale ) === mb_strtolower( $country_iso_code ) ) {
					$result = true;
				}
			}
		}

		// Get the list of the subdivisions from the "Geolocation Subdivisions" option.
		$subdivision_iso_code      = isset( $city->subdivisions[0]->isoCode ) ? $country_iso_code . '-' . $city->subdivisions[0]->isoCode : null;
		$geolocation_subdivision   = get_option( $this->get( 'slug' ) . '_geolocation_subdivision' );
		$geolocation_subdivision_a = maybe_unserialize( $geolocation_subdivision );

		// Verify if the detected subdivision is present in the list of the subdivisions.
		if ( is_array( $geolocation_subdivision_a ) && null !== $subdivision_iso_code ) {
			foreach ( $geolocation_subdivision_a as $key => $single_geolocation_subdivision ) {
				if ( mb_strtolower( $single_geolocation_subdivision ) === mb_strtolower( $subdivision_iso_code ) ) {
					$result = true;
				}
			}
		}

		return $result;
	}

	/**
	 * Get the country code from the provided IP address.
	 *
	 * @param string $ip_address The IP address.
	 *
	 * @return mixed|string|null
	 * @throws \MaxMind\Db\Reader\InvalidDatabaseException If there is an issue with the MaxMind database.
	 */
	public function get_country_code_from_ip( $ip_address ) {

		$file_path = get_option( $this->get( 'slug' ) . '_maxmind_database_file_path' );

		// Check if file exists given the path.
		if ( ! file_exists( $file_path ) ) {
			return null;
		}

		// Create the Reader object.
		$reader = new GeoIp2\Database\Reader( $file_path );

		// Get the country.
		try {
			$record = $reader->country( $ip_address );
		} catch ( Exception $e ) {
			return null;
		}

		return $record->country->isoCode;
	}

	/**
	 * Get the city data from the provided IP address.
	 *
	 * @param string $ip_address The IP address.
	 *
	 * @return mixed|null
	 * @throws \MaxMind\Db\Reader\InvalidDatabaseException If there is an issue with the MaxMind database.
	 */
	public function get_city_from_ip( $ip_address ) {

		// Create the Reader object for the city database.
		$database_city_file_path = get_option( $this->get( 'slug' ) . '_maxmind_database_city_file_path' );

		// Check if file exists given the path.
		if ( ! file_exists( $database_city_file_path ) ) {
			return false;
		}

		$reader_city = new GeoIp2\Database\Reader( $database_city_file_path );

		// Get the city data.
		try {
			$record_city = $reader_city->city( $ip_address );
		} catch ( Exception $e ) {
			return null;
		}

		return $record_city;
	}

	/**
	 * Get the IP address of the user. If the retrieved IP address is not valid an empty string is returned.
	 *
	 * @return string
	 */
	public function get_ip_address() {

		// phpcs:disable WordPress.Security.ValidatedSanitizedInput -- Invalid IP address are not used.
		if ( rest_is_ip_address( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip_address = '';
		}
		// phpcs:enable WordPress.Security.ValidatedSanitizedInput

		return $ip_address;
	}

	/**
	 * Get the anonymized IP address of the user.
	 *
	 * Note:
	 *
	 * - For IPv4 addresses the last 16 bits are removed.
	 * - For IPv6 addresses the last 96 bits are removed.
	 *
	 * @return false|string
	 */
	public function get_anonymized_ip_address() {

		$ip_address = $this->get_ip_address();

		if ( filter_var( $ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {

			// IPv4 IP address.
			$anonymized_ip_address = $this->remove_last_16_bits( $ip_address );

		} elseif ( filter_var( $ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) ) {

			// IPv6 IP address.
			$anonymized_ip_address = $this->remove_last_96_bits( $ip_address );

		} else {

			// Unknown IP address type.
			$anonymized_ip_address = 'Unknown';

		}

		return $anonymized_ip_address;
	}

	/**
	 * Remove the last 16 bit of an IPv4 ip address.
	 *
	 * @param string $ipv4 The IPv4 address.
	 *
	 * @return false|string
	 */
	public function remove_last_16_bits( $ipv4 ) {

		// Convert IP address to binary.
		$ip_long = ip2long( $ipv4 );

		// Zero out the last 16 bits.
		$modified_ip_long = $ip_long & 0xFFFF0000;

		// Convert back to dotted format and return.
		return long2ip( $modified_ip_long );
	}

	/**
	 * Remove the last 96 bit of IPv6 ip address.
	 *
	 * @param string $ipv6 The IPv6 address.
	 *
	 * @return string
	 */
	public function remove_last_96_bits( $ipv6 ) {

		// Split the IPv6 address into its parts.
		$parts = explode( ':', $ipv6 );

		// Remove the last 96 bits (3 parts).
		$trimmed_parts = array_slice( $parts, 0, -3 );

		// Reconstruct the IPv6 address.
		$trimmed_ipv6 = implode( ':', $trimmed_parts );

		return $trimmed_ipv6;
	}

	/**
	 * Get the plugin upload path.
	 *
	 * @return string The plugin updload path
	 */
	public function get_plugin_upload_path() {

		$upload_path = WP_CONTENT_DIR . '/uploads/daextlwcnf_uploads/';

		return $upload_path;
	}

	/**
	 * Generates the XML version of the data of the table.
	 *
	 * @param string $db_table_name The name of the db table without the prefix.
	 * @param string $db_table_primary_key The name of the primary key of the table
	 *
	 * @return string The XML version of the data of the db table.
	 */
	public function convert_db_table_to_xml( $db_table_name, $db_table_primary_key ) {

		// Get the data from the db table.
		global $wpdb;

		// Get the data from the db table.
		global $wpdb;
		// phpcs:disable WordPress.DB.DirectDatabaseQuery
		// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared -- $db_table_name is sanitized.
		$data_a = $wpdb->get_results(
			'SELECT * FROM ' . $wpdb->prefix . 'daextlwcnf_' . sanitize_key( $db_table_name ) . ' ORDER BY ' . sanitize_key( $db_table_primary_key ) . ' ASC',
			ARRAY_A
		);
		// phpcs:enable

		// Generate the data of the db table.
		foreach ( $data_a as $record ) {

			echo '<' . esc_attr( $db_table_name ) . '>';

			// Get all the indexes of the $data array.
			$record_keys = array_keys( $record );

			// Cycle through all the indexes of the single record and create all the XML tags.
			foreach ( $record_keys as $key ) {
				echo '<' . esc_attr( $key ) . '>' . esc_attr( $record[ $key ] ) . '</' . esc_attr( $key ) . '>';
			}

			echo '</' . esc_attr( $db_table_name ) . '>';

		}
	}

	/**
	 * Objects as a value are set to empty strings. This prevents generating notices with the methods of the wpdb class.
	 *
	 * @param array $data An array which includes objects that should be converted to an empty strings.
	 * @return array An array where the objects have been replaced with empty strings.
	 */
	public function replace_objects_with_empty_strings( $data ) {

		foreach ( $data as $key => $value ) {
			if ( gettype( $value ) === 'object' ) {
				$data[ $key ] = '';
			}
		}

		return $data;
	}

	/**
	 * Reset the plugin options.
	 *
	 * Set the initial value to all the plugin options.
	 */
	public function reset_plugin_options() {

		$options = $this->get( 'options' );
		foreach ( $options as $option_name => $default_option_value ) {
			update_option( $option_name, $default_option_value );
		}
	}

	/**
	 * Get the name of a section.
	 *
	 * @param int $section_id The id of the section.
	 *
	 * @return string|null
	 */
	public function get_section_name( $section_id ) {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$section_obj = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT name FROM {$wpdb->prefix}daextlwcnf_section WHERE section_id = %d",
				$section_id
			)
		);

		if ( null !== $section_obj ) {
			return $section_obj->name;
		} else {
			return __( 'None', 'lightweight-cookie-notice-free' );
		}
	}

	/**
	 * Filters the provided string with wp_kses() and custom parameters.
	 *
	 * @param string $str The string that should be filtered.
	 *
	 * @return string
	 */
	public function apply_custom_kses( $str ) {

		$allowed_html = array(
			'p'      => array(),
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
				'rel'    => array(),
			),
			'strong' => array(),
			'br'     => array(),
			'ol'     => array(),
			'ul'     => array(),
			'li'     => array(),
		);

		return wp_kses( $str, $allowed_html );
	}

	/**
	 * Get the number of seconds associated with the provided identifier of a time period defined with the "Cookie
	 * Expiration" option.
	 *
	 * @param int $period The identifier of the time period.
	 *
	 * @return float|int
	 */
	public function get_cookie_expiration_seconds( $period ) {

		switch ( intval( $period, 10 ) ) {

			// Unlimited.
			case 0:
				$expiration = 3153600000;
				break;

			// One Hour.
			case 1:
				$expiration = 3600;
				break;

			// One Day.
			case 2:
				$expiration = 3600 * 24;
				break;

			// One Week.
			case 3:
				$expiration = 3600 * 24 * 7;
				break;

			// One Month.
			case 4:
				$expiration = 3600 * 24 * 30;
				break;

			// Three Months.
			case 5:
				$expiration = 3600 * 2490;
				break;

			// Six Months.
			case 6:
				$expiration = 3600 * 24 * 180;
				break;

			// One Year.
			case 7:
				$expiration = 3600 * 24 * 365;
				break;

		}

		return $expiration;
	}

	/**
	 * Delete all the records of the database tables used by the plugin.
	 */
	public function reset_plugin_database_tables() {

		global $wpdb;

		// Delete data in 'category' table.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DELETE FROM {$wpdb->prefix}daextlwcnf_category" );

		// Delete data in 'section' table.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DELETE FROM {$wpdb->prefix}daextlwcnf_section" );

		// Delete data in 'cookie' table.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DELETE FROM {$wpdb->prefix}daextlwcnf_cookie" );

		// Delete data in 'consent_log' table.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DELETE FROM {$wpdb->prefix}daextlwcnf_consent_log" );
	}

	/**
	 * Returns the category acceptance of the provided category.
	 *
	 * @param int $category_id The category ID.
	 *
	 * @return string
	 */
	public function get_acceptance_rate_of_category( $category_id ) {

		$accepted = 0;
		$rejected = 0;

		global $wpdb;


		/**
		 * Get the consent log data. Note that to prevent the query from being too slow or fail due to memory issues,
		 * only the last 5000 records are retrieved.
		 */
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$consent_log_a = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}daextlwcnf_consent_log ORDER BY consent_log_id DESC LIMIT 5000",
			ARRAY_A
		);

		foreach ( $consent_log_a as $consent_log ) {

			// Decode the base64 encoded string.
			// phpcs:disable WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- Base64 decode is required.
			$compressed_string = base64_decode( $consent_log['state'] );

			// Decompress the string.
			$original_string = gzuncompress( $compressed_string );

			// Convert the JSON in $result['formatted_state'] to an array.
			$formatted_state = json_decode( $original_string, true );

			if ( isset( $formatted_state['category_cookies'] ) ) {
				foreach ( $formatted_state['category_cookies'] as $category_cookie ) {

					if ( intval( $category_id, 10 ) !== intval( $category_cookie['categoryId'], 10 ) ) {
						continue;
					}

					if ( 1 === intval( $category_cookie['status'], 10 ) ) {
						++$accepted;
					} else {
						++$rejected;
					}
				}
			}
		}

		if ( 0 === $accepted && 0 === $rejected ) {
			$result = 'N/A';
		} else {
			$result = (string) round( $accepted / ( $accepted + $rejected ) * 100, 2 );
			$result = $result . '%';
		}

		return $result;
	}

	/**
	 * Get the cookies notice data from the plugin database tables and return them as an array.
	 *
	 * @return array
	 */
	public function get_cookie_notice_data() {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$category_a = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}daextlwcnf_category ORDER BY section_id, priority ASC",
			ARRAY_A
		);

		$section_a       = array();
		$cookies         = array();
		$last_section_id = false;

		foreach ( $category_a as $key => $category ) {

			if ( intval( $category['section_id'], 10 ) === 0 ) {
				continue;
			}

			// Remove the unnecessary fields from the category.
			unset( $category['script_head'] );
			unset( $category['script_body'] );

			if ( $last_section_id !== $category['section_id'] ) {

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$section_obj = $wpdb->get_row(
					$wpdb->prepare(
						"SELECT * FROM {$wpdb->prefix}daextlwcnf_section WHERE section_id = %d ",
						$category['section_id']
					)
				);

				$section_a[] = array(
					'section_id'  => $section_obj->section_id,
					'name'        => stripslashes( $section_obj->name ),
					'description' => stripslashes( $section_obj->description ),
					'category_a'  => array(),
				);

			}

			$last_section_id = $category['section_id'];
			unset( $category['section_id'] );

			// Get the cookies associated with this category.
			$category_id = $category['category_id'];

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$cookie_a = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}daextlwcnf_cookie WHERE category_id = %d ORDER BY priority DESC, cookie_id ASC",
					$category_id
				),
				ARRAY_A
			);

			// Apply stripslashes() on the text fields of the cookie.
			foreach ( $cookie_a as $key => $single_cookie ) {
				$cookie_a[ $key ]['provider']    = stripslashes( $single_cookie['provider'] );
				$cookie_a[ $key ]['domain']      = stripslashes( $single_cookie['domain'] );
				$cookie_a[ $key ]['name']        = stripslashes( $single_cookie['name'] );
				$cookie_a[ $key ]['purpose']     = stripslashes( $single_cookie['purpose'] );
				$cookie_a[ $key ]['expiration']  = stripslashes( $single_cookie['expiration'] );
				$cookie_a[ $key ]['type']        = stripslashes( $single_cookie['type'] );
				$cookie_a[ $key ]['sensitivity'] = stripslashes( $single_cookie['sensitivity'] );
				$cookie_a[ $key ]['security']    = stripslashes( $single_cookie['security'] );
			}

			// Assign the cookie to the category.
			$category['cookies'] = $cookie_a;

			// Apply stripslashes() on the text fields of the category.
			$category['name']        = stripslashes( $category['name'] );
			$category['description'] = stripslashes( $category['description'] );

			// Assign the category to the section.
			$section_a[ count( $section_a ) - 1 ]['category_a'][] = $category;

			// Get all the cookies defined in the "Cookies" menu.
			global $wpdb;

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$cookie_a = $wpdb->get_results(
				"SELECT name, cookie_domain_attribute, cookie_path_attribute FROM {$wpdb->prefix}daextlwcnf_cookie ORDER BY cookie_id ASC",
				ARRAY_A
			);

			$cookies = array();
			foreach ( $cookie_a as $cookie ) {
				$cookies[] = array(
					'name'                    => $cookie['name'],
					'cookie_domain_attribute' => $cookie['cookie_domain_attribute'],
					'cookie_path_attribute'   => $cookie['cookie_path_attribute'],
				);
			}
		}

		return array(
			'section_a' => $section_a,
			'cookies'   => $cookies,
		);
	}

	/**
	 * Returns an array with the data used by React to initialize the options.
	 *
	 * @return array[]
	 */
	public function menu_options_configuration() {

		// Generate the options for the "Geolocation Locale" select field.
		$array_locale                      = get_option( 'daextlwcnf_locale' );
		$geolocation_locale_select_options = array();
		foreach ( $array_locale as $key => $value ) {

			$geolocation_locale_select_options[] = array(
				'value' => $value,
				'text'  => $key,
			);

		}

		// Generate the options for the "Geolocation Subdivisions" select field.
		$array_subdivision                      = array(
			'US-AL' => 'Alabama	State',
			'US-AK' => 'Alaska State',
			'US-AZ' => 'Arizona	State',
			'US-AR' => 'Arkansas State',
			'US-CA' => 'California State',
			'US-CO' => 'Colorado State',
			'US-CT' => 'Connecticut	State',
			'US-DE' => 'Delaware State',
			'US-FL' => 'Florida	State',
			'US-GA' => 'Georgia	State',
			'US-HI' => 'Hawaii State',
			'US-ID' => 'Idaho State',
			'US-IL' => 'Illinois State',
			'US-IN' => 'Indiana	State',
			'US-IA' => 'Iowa State',
			'US-KS' => 'Kansas State',
			'US-KY' => 'Kentucky State',
			'US-LA' => 'Louisiana State',
			'US-ME' => 'Maine State',
			'US-MD' => 'Maryland State',
			'US-MA' => 'Massachusetts State',
			'US-MI' => 'Michigan State',
			'US-MN' => 'Minnesota State',
			'US-MS' => 'Mississippi	State',
			'US-MO' => 'Missouri State',
			'US-MT' => 'Montana	State',
			'US-NE' => 'Nebraska State',
			'US-NV' => 'Nevada State',
			'US-NH' => 'New Hampshire State',
			'US-NJ' => 'New Jersey State',
			'US-NM' => 'New Mexico State',
			'US-NY' => 'New York State',
			'US-NC' => 'North Carolina State',
			'US-ND' => 'North Dakota State',
			'US-OH' => 'Ohio State',
			'US-OK' => 'Oklahoma State',
			'US-OR' => 'Oregon State',
			'US-PA' => 'Pennsylvania State',
			'US-RI' => 'Rhode Island State',
			'US-SC' => 'South Carolina State',
			'US-SD' => 'South Dakota State',
			'US-TN' => 'Tennessee State',
			'US-TX' => 'Texas State',
			'US-UT' => 'Utah State',
			'US-VT' => 'Vermont	State',
			'US-VA' => 'Virginia State',
			'US-WA' => 'Washington State',
			'US-WV' => 'West Virginia State',
			'US-WI' => 'Wisconsin State',
			'US-WY' => 'Wyoming	State',
			'US-DC' => 'District of Columbia District',
			'US-AS' => 'American Samoa Outlying area',
			'US-GU' => 'Guam Outlying area',
			'US-MP' => 'Northern Mariana Islands Outlying area',
			'US-PR' => 'Puerto Rico	Outlying area',
			'US-UM' => 'United States Minor Outlying Islands Outlying area',
			'US-VI' => 'Virgin Islands, U.S. Outlying area',
		);
		$geolocation_subdivision_select_options = array();
		foreach ( $array_subdivision as $key => $value ) {
			$geolocation_subdivision_select_options[] = array(
				'value' => $key,
				'text'  => $key . ' - ' . $value,
			);
		}

		$font_weight_select_options = array(
			array(
				'value' => '100',
				'text'  => __( '100', 'lightweight-cookie-notice-free' ),
			),
			array(
				'value' => '200',
				'text'  => __( '200', 'lightweight-cookie-notice-free' ),
			),
			array(
				'value' => '300',
				'text'  => __( '300', 'lightweight-cookie-notice-free' ),
			),
			array(
				'value' => '400',
				'text'  => __( '400 (Normal)', 'lightweight-cookie-notice-free' ),
			),
			array(
				'value' => '500',
				'text'  => __( '500', 'lightweight-cookie-notice-free' ),
			),
			array(
				'value' => '600',
				'text'  => __( '600', 'lightweight-cookie-notice-free' ),
			),
			array(
				'value' => '700',
				'text'  => __( '700 (Bold)', 'lightweight-cookie-notice-free' ),
			),
			array(
				'value' => '800',
				'text'  => __( '800', 'lightweight-cookie-notice-free' ),
			),
			array(
				'value' => '900',
				'text'  => __( '900', 'lightweight-cookie-notice-free' ),
			),
		);

		$configuration = array(
			array(
				'title'       => __( 'Content', 'lightweight-cookie-notice-free' ),
				'description' => __( 'Configure the content and behavior of all the elements.', 'lightweight-cookie-notice-free' ),
				'cards'       => array(
					array(
						'title'   => __( 'Cookie Notice', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'    => 'daextlwcnf_cookie_notice_main_message_text',
								'label'   => __( 'Message Text', 'lightweight-cookie-notice-free' ),
								'type'    => 'textarea',
								'tooltip' => __(
									'Enter the message of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the message of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_1_text',
								'label'   => __( 'Button 1 Text', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'This option determines the text for the first button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the text for the first button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_notice_button_1_action',
								'label'         => __( 'Button 1 Action', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The action performed after clicking the first button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the action performed after clicking the first button of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Disabled', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Open Cookie Settings', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'Accept Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '3',
										'text'  => __( 'Close Cookie Notice', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '4',
										'text'  => __( 'Redirect to URL', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '5',
										'text'  => __( 'Accept All Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '6',
										'text'  => __( 'Reject All Cookies', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_1_url',
								'label'   => __( 'Button 1 URL', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The URL to which the user will be redirected after clicking the first button of the cookie notice. Note that this option will only be used if "Redirect to URL" is selected in the "Button 1 Action" option.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the URL to which the user will be redirected after clicking the first button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_2_text',
								'label'   => __( 'Button 2 Text', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'This option determines the text for the second button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the text for the second button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_notice_button_2_action',
								'label'         => __( 'Button 2 Action', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The action performed after clicking the second button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the action performed after clicking the second button of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Disabled', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Open Cookie Settings', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'Accept Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '3',
										'text'  => __( 'Close Cookie Notice', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '4',
										'text'  => __( 'Redirect to URL', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '5',
										'text'  => __( 'Accept All Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '6',
										'text'  => __( 'Reject All Cookies', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_2_url',
								'label'   => __( 'Button 2 URL', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The URL to which the user will be redirected after clicking the second button of the cookie notice. Note that this option will only be used if "Redirect to URL" is selected in the "Button 2 Action" option.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the URL to which the user will be redirected after clicking the second button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_3_text',
								'label'   => __( 'Button 3 Text', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'This option determines the text for the third button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the text for the third button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_notice_button_3_action',
								'label'         => __( 'Button 3 Action', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The action performed after clicking the third button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the action performed after clicking the third button of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Disabled', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Open Cookie Settings', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'Accept Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '3',
										'text'  => __( 'Close Cookie Notice', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '4',
										'text'  => __( 'Redirect to URL', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '5',
										'text'  => __( 'Accept All Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '6',
										'text'  => __( 'Reject All Cookies', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_3_url',
								'label'   => __( 'Button 3 URL', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The URL to which the user will be redirected after clicking the third button of the cookie notice. Note that this option will only be used if "Redirect to URL" is selected in the "Button 3 Action" option.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the URL to which the user will be redirected after clicking the third button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),

							array(
								'name'          => 'daextlwcnf_cookie_notice_button_dismiss_action',
								'label'         => __( 'Dismiss Button Action', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The action performed after clicking the dismiss button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the action performed after clicking the dismiss button of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Disabled', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '3',
										'text'  => __( 'Open Cookie Settings', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'Accept Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '3',
										'text'  => __( 'Close Cookie Notice', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '4',
										'text'  => __( 'Redirect to URL', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '5',
										'text'  => __( 'Accept All Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '6',
										'text'  => __( 'Reject All Cookies', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_dismiss_url',
								'label'   => __( 'Dismiss Button URL', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The URL to which the user will be redirected after clicking the dismiss button of the cookie notice. Note that this option will only be used if "Redirect to URL" is selected in the "Dismiss Button Action" option.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the URL to which the user will be redirected after clicking the dismiss button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_shake_effect',
								'label'   => __( 'Shake Effect', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'If you enable this option, a shake effect will be applied to the cookie notice when the user clicks on the mask.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enable a shake effect when the user clicks on the mask.', 'lightweight-cookie-notice-free' ),
							),
						),
					),
					array(
						'title'   => __( 'Cookie Settings', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'    => 'daextlwcnf_cookie_settings_logo_url',
								'label'   => __( 'Logo URL', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The logo displayed in the header of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the logo URL.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_title',
								'label'   => __( 'Title', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The title of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the title of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_description_header',
								'label'   => __( 'Description Header', 'lightweight-cookie-notice-free' ),
								'type'    => 'textarea',
								'tooltip' => __(
									'The text displayed in the header of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the text displayed in the header of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_description_footer',
								'label'   => __( 'Description Footer', 'lightweight-cookie-notice-free' ),
								'type'    => 'textarea',
								'tooltip' => __(
									'The text displayed in the footer of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the text displayed in the footer of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_1_text',
								'label'   => __( 'Button 1 Text', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'This option determines the text for the first button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the text for the first button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_settings_button_1_action',
								'label'         => __( 'Button 1 Action', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The action performed after clicking the first button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the action performed after clicking the first button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Disabled', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Accept Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'Close Cookie Settings', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '3',
										'text'  => __( 'Redirect to URL', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '4',
										'text'  => __( 'Accept All Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '5',
										'text'  => __( 'Reject All Cookies', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_1_url',
								'label'   => __( 'Button 1 URL', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The URL to which the user will be redirected after clicking the first button of the cookie settings modal window. Note that this option will only be used if "Redirect to URL" is selected in the "Button 1 Action" option.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the URL to which the user will be redirected after clicking the first button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_2_text',
								'label'   => __( 'Button 2 Text', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'This option determines the text for the second button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the text for the first button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_settings_button_2_action',
								'label'         => __( 'Button 2 Action', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The action performed after clicking the first button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the action performed after clicking the second button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Disabled', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Accept Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'Close Cookie Settings', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '3',
										'text'  => __( 'Redirect to URL', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '4',
										'text'  => __( 'Accept All Cookies', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '5',
										'text'  => __( 'Reject All Cookies', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_2_url',
								'label'   => __( 'Button 2 URL', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The URL to which the user will be redirected after clicking the second button of the cookie settings modal window. Note that this option will only be used if "Redirect to URL" is selected in the "Button 2 Action" option.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the URL to which the user will be redirected after clicking the second button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
						),
					),
					array(
						'title'   => __( 'Revisit Consent', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'    => 'daextlwcnf_revisit_consent_button_enable',
								'label'   => __( 'Enable', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'Whether to enable or not the revisit consent button. The revisit consent button allows visitors to revoke their cookie preferences.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enable the revisit consent button.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_revisit_consent_button_tooltip_text',
								'label'   => __( 'Tooltip Text', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The tooltip of the revisit content button.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the tooltip of the revisit content button.', 'lightweight-cookie-notice-free' ),
							),
						),
					),
				),
			),
			array(
				'title'       => __( 'Style', 'lightweight-cookie-notice-free' ),
				'description' => __( 'Set colors, typography, spacing, and additional UI preferences.', 'lightweight-cookie-notice-free' ),
				'cards'       => array(
					array(
						'title'   => __( 'General', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'          => 'daextlwcnf_headings_font_weight',
								'label'         => __( 'Headings Font Weight', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The font weight used for the headings.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the font weight used for the headings.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => $font_weight_select_options,
							),
							array(
								'name'          => 'daextlwcnf_paragraphs_font_weight',
								'label'         => __( 'Paragraphs Font Weight', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'Select the font weight used for the paragraphs.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Enter the font weight used for the paragraphs.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => $font_weight_select_options,
							),
							array(
								'name'          => 'daextlwcnf_strong_tags_font_weight',
								'label'         => __( 'Strong Tags Font Weight', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'Select the font weight used for the bold text.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Enter the font weight used for the bold text.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => $font_weight_select_options,
							),
							array(
								'name'          => 'daextlwcnf_buttons_font_weight',
								'label'         => __( 'Buttons Font Weight', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The font weight used for the buttons.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the font weight used for the buttons.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => $font_weight_select_options,
							),
							array(
								'name'      => 'daextlwcnf_buttons_border_radius',
								'label'     => __( 'Buttons Border Radius', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'Set the border radius of the buttons.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'The border radius of the buttons.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 16,
								'rangeStep' => 1,
							),
							array(
								'name'      => 'daextlwcnf_containers_border_radius',
								'label'     => __( 'Containers Border Radius', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'Set the border radius of the containers.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'The border radius of the containers.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 16,
								'rangeStep' => 1,
							),
						),
					),
					array(
						'title'   => __( 'Cookie Notice', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'    => 'daextlwcnf_cookie_notice_main_message_font_color',
								'label'   => __( 'Message Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the message displayed in the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the message displayed in the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_main_message_link_font_color',
								'label'   => __( 'Message Link Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the links included in the message displayed in the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the links included in the message displayed in the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_1_background_color',
								'label'   => __( 'Button 1 Background Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color of the first button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color of the first button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_1_background_color_hover',
								'label'   => __( 'Button 1 Background Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color of the first button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color of the first button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_1_border_color',
								'label'   => __( 'Button 1 Border Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color of the first button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color of the first button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_1_border_color_hover',
								'label'   => __( 'Button 1 Border Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color of the first button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color of the first button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_1_font_color',
								'label'   => __( 'Button 1 Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the first button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the first button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_1_font_color_hover',
								'label'   => __( 'Button 1 Font Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the first button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the first button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),

							array(
								'name'    => 'daextlwcnf_cookie_notice_button_2_background_color',
								'label'   => __( 'Button 2 Background Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color of the second button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color of the second button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_2_background_color_hover',
								'label'   => __( 'Button 2 Background Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color of the second button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color of the second button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_2_border_color',
								'label'   => __( 'Button 2 Border Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color of the second button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color of the second button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_2_border_color_hover',
								'label'   => __( 'Button 2 Border Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color of the second button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color of the second button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_2_font_color',
								'label'   => __( 'Button 2 Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the second button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the second button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_2_font_color_hover',
								'label'   => __( 'Button 2 Font Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the second button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the second button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),

							array(
								'name'    => 'daextlwcnf_cookie_notice_button_3_background_color',
								'label'   => __( 'Button 3 Background Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color of the third button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color of the third button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_3_background_color_hover',
								'label'   => __( 'Button 3 Background Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color of the third button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color of the third button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_3_border_color',
								'label'   => __( 'Button 3 Border Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color of the third button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color of the third button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_3_border_color_hover',
								'label'   => __( 'Button 3 Border Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the third button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the third button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_3_font_color',
								'label'   => __( 'Button 3 Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the third button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the third button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_3_font_color_hover',
								'label'   => __( 'Button 3 Font Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color of the third button (in hover state) of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color of the third button (in hover state) of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_button_dismiss_color',
								'label'   => __( 'Dismiss Button Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The color of the dismiss button of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the color of the dismiss button of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_notice_container_position',
								'label'         => __( 'Container Position', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The position of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the position of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Top', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Center', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'Bottom', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'      => 'daextlwcnf_cookie_notice_container_width',
								'label'     => __( 'Wrapper Width', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The width of the wrapper that includes the content of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Enter the width of the wrapper that includes the content of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 1920,
								'rangeStep' => 1,
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_container_background_color',
								'label'   => __( 'Container Background Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'      => 'daextlwcnf_cookie_notice_container_opacity',
								'label'     => __( 'Container Opacity', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The opacity of the background of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the opacity of the background of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 1,
								'rangeStep' => 0.01,
							),
							array(
								'name'      => 'daextlwcnf_cookie_notice_container_border_width',
								'label'     => __( 'Container Border Width', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The width of the border of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the width of the border of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 16,
								'rangeStep' => 1,
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_container_border_color',
								'label'   => __( 'Container Border Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The color of the border of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the color of the border of the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'      => 'daextlwcnf_cookie_notice_container_border_opacity',
								'label'     => __( 'Container Border Opacity', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The opacity of the background of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the opacity of the background of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 1,
								'rangeStep' => 0.01,
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_container_drop_shadow',
								'label'   => __( 'Container Drop Shadow', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'If you enable this option, a drop shadow will be added to the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enable a drop shadow.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_container_drop_shadow_color',
								'label'   => __( 'Container Drop Shadow Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The color of the drop shadow applied to the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the color of the drop shadow applied to the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_notice_mask',
								'label'         => __( 'Mask', 'lightweight-cookie-notice-free' ),
								'type'          => 'toggle',
								'tooltip'       => __(
									'If you enable this option, a mask will be applied behind the cookie notice to prevent user interactions with the website.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Enable a mask applied behind the cookie notice.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Disabled', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Enabled', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_cookie_notice_mask_color',
								'label'   => __( 'Mask Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The color of the mask applied behind the cookie notice to prevent user interactions with the website.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the color of the mask applied to the cookie notice.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'      => 'daextlwcnf_cookie_notice_mask_opacity',
								'label'     => __( 'Mask Opacity', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The opacity of the mask applied behind the cookie notice to prevent user interactions with the website.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the opacity of the mask applied behind the cookie notice.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 1,
								'rangeStep' => 0.01,
							),
						),
					),
					array(
						'title'   => __( 'Cookie Settings', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_1_background_color',
								'label'   => __( 'Button 1 Background Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color for the first button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color for the first button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_1_background_color_hover',
								'label'   => __( 'Button 1 Background Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color for the first button (in hover state) of the cookie settings modal',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color for the first button (in hover state) of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_1_border_color',
								'label'   => __( 'Button 1 Border Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color for the first button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color for the first button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_1_border_color_hover',
								'label'   => __( 'Button 1 Border Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color for the first button (in hover state) of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color for the first button (in hover state) of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_1_font_color',
								'label'   => __( 'Button 1 Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color for the first button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color for the first button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_1_font_color_hover',
								'label'   => __( 'Button 1 Font Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color for the first button (in hover state) of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color for the first button (in hover state) of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_2_background_color',
								'label'   => __( 'Button 2 Background Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color for the second button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color for the second button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_2_background_color_hover',
								'label'   => __( 'Button 2 Background Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color (in hover state) for the second button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color for the second button (in hover state) of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_2_border_color',
								'label'   => __( 'Button 2 Border Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color for the second button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color for the second button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_2_border_color_hover',
								'label'   => __( 'Button 2 Border Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color for the second button (in hover state) of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color for the second button (in hover state) of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_2_font_color',
								'label'   => __( 'Button 2 Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color for the second button of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color for the second button of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_button_2_font_color_hover',
								'label'   => __( 'Button 2 Font Color Hover', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color for the second button (in hover state) of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color for the second button (in hover state) of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),

							array(
								'name'    => 'daextlwcnf_cookie_settings_headings_font_color',
								'label'   => __( 'Heading Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color for the headings of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color for the headings of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_paragraphs_font_color',
								'label'   => __( 'Paragraphs Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color for the paragraphs of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color for the paragraphs of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_links_font_color',
								'label'   => __( 'Links Font Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The font color for the links of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the font color for the links of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_settings_toggle_on_color',
								'label'         => __( 'Toggle On Color', 'lightweight-cookie-notice-free' ),
								'type'          => 'color-picker',
								'tooltip'       => __(
									'The color of the toggle in the cookie settings modal window when it is in the "On" state.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the color of the toggle in the cookie settings modal window when it is in the "On" state.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_settings_toggle_off_color',
								'label'         => __( 'Toggle Off Color', 'lightweight-cookie-notice-free' ),
								'type'          => 'color-picker',
								'tooltip'       => __(
									'The color of the toggle in the cookie settings modal window when it is in the "Off" state.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the color of the toggle in the cookie settings modal window when it is in the "Off" state.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_settings_toggle_misc_color',
								'label'         => __( 'Toggle Mixed Color', 'lightweight-cookie-notice-free' ),
								'type'          => 'color-picker',
								'tooltip'       => __(
									'The color of the toggle in the cookie settings modal window when it is in the "Mixed" state.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the color of the toggle in the cookie settings modal window when it is in the "Mixed" state.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_cookie_settings_toggle_disabled_color',
								'label'         => __( 'Toggle Disabled Color', 'lightweight-cookie-notice-free' ),
								'type'          => 'color-picker',
								'tooltip'       => __(
									'The color of the toggle in the cookie settings modal window when it is in the "Disabled" state.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the color of the toggle in the cookie settings modal window when it is in the "Disabled" state.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_container_background_color',
								'label'   => __( 'Container Background Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color for the container of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color for the container of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'      => 'daextlwcnf_cookie_settings_container_opacity',
								'label'     => __( 'Container Opacity', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The opacity for the container of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the opacity for the container of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 1,
								'rangeStep' => 0.01,
							),
							array(
								'name'      => 'daextlwcnf_cookie_settings_container_border_width',
								'label'     => __( 'Container Border Width', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'Set the width for the border of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the width for the border of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 16,
								'rangeStep' => 1,
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_container_border_color',
								'label'   => __( 'Container Border Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The border color for the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the border color for the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'      => 'daextlwcnf_cookie_settings_container_border_opacity',
								'label'     => __( 'Container Border Opacity', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'Set the opacity for the border of the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Select the opacity for the border of the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 1,
								'rangeStep' => 0.01,
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_container_drop_shadow',
								'label'   => __( 'Container Drop Shadow', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'If you enable this option, a drop shadow will be added to the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enable a drop shadow.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_container_drop_shadow_color',
								'label'   => __( 'Container Drop Shadow Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The color of the drop shadow applied to the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the color of the drop shadow applied to the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_container_highlight_color',
								'label'   => __( 'Container Highlight Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The highlight color for the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the highlight color for the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_separator_color',
								'label'   => __( 'Separator Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The color of the separators for the cookie settings modal window.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the color of the separators for the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_cookie_settings_mask',
								'label'   => __( 'Mask', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'If you enable this option, a mask will be applied behind the cookie settings modal window to prevent user interactions with the website.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enable a mask applied behind the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),

							array(
								'name'    => 'daextlwcnf_cookie_settings_mask_color',
								'label'   => __( 'Mask Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The color of the mask applied behind the cookie settings modal window to prevent user interactions with the website.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the color of the mask applied to the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'      => 'daextlwcnf_cookie_settings_mask_opacity',
								'label'     => __( 'Mask Opacity', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The opacity of the mask applied behind the cookie settings modal window to prevent user interactions with the website.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the opacity of the mask applied behind the cookie settings modal window.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 1,
								'rangeStep' => 0.01,
							),
						),
					),
					array(
						'title'   => __( 'Revisit Consent', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'          => 'daextlwcnf_revisit_consent_button_position',
								'label'         => __( 'Position', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The position of the revisit consent button.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the position of the revisit consent button.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => 'left',
										'text'  => __( 'Left', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'right',
										'text'  => __( 'Right', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_revisit_consent_button_background_color',
								'label'   => __( 'Background Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The background color of the revisit consent button.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the background color of the revisit consent button.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_revisit_consent_button_icon_color',
								'label'   => __( 'Icon Color', 'lightweight-cookie-notice-free' ),
								'type'    => 'color-picker',
								'tooltip' => __(
									'The icon color of the revisit consent button.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Select the icon color of the revisit consent button.', 'lightweight-cookie-notice-free' ),
							),
						),
					),
				),
			),
			array(
				'title'       => __( 'Geolocation', 'lightweight-cookie-notice-free' ),
				'description' => __( 'Enable and configure the geolocation functionalities.', 'lightweight-cookie-notice-free' ),
				'cards'       => array(
					array(
						'title'   => __( 'General', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'    => 'daextlwcnf_enable_geolocation',
								'label'   => __( 'Geolocation', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'The plugin uses the geolocation feature in two different contexts. To apply the custom behavior defined with the "Behavior" option and also to store the user\'s country in the consent log.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enable the geolocation functionalities of the plugin.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'          => 'daextlwcnf_geolocation_behavior',
								'label'         => __( 'Behavior', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The behavior applied when the user is not located in the selected geographic targets.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the behavior applied when the user is not located in the selected geographic targets.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Disable cookie notice', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Disable cookie notice and enable all cookie categories', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'None', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'          => 'daextlwcnf_geolocation_service',
								'label'         => __( 'Service', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The geolocation service used to detect the user location.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the geolocation service used to detect the user location.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'HostIP.info', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'MaxMind GeoLite2', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'          => 'daextlwcnf_geolocation_locale',
								'label'         => __( 'Geolocation Locale', 'lightweight-cookie-notice-free' ),
								'type'          => 'select-multiple',
								'tooltip'       => __(
									'The list of countries where the site should display the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the countries where the site should display the cookie notice.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => $geolocation_locale_select_options,
							),
						),
					),
					array(
						'title'   => __( 'Maxmind GeoLite2', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'          => 'daextlwcnf_geolocation_subdivision',
								'label'         => __( 'Geolocation Subdivision', 'lightweight-cookie-notice-free' ),
								'type'          => 'select-multiple',
								'tooltip'       => __(
									'The list of subdivisions where the site should display the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the subdivisions where the site should display the cookie notice.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => $geolocation_subdivision_select_options,
							),
							array(
								'name'    => 'daextlwcnf_maxmind_database_file_path',
								'label'   => __( 'Country Database File Path', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The file path where the country database provided by MaxMind is located.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the file path where the country database provided by MaxMind is located.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_maxmind_database_city_file_path',
								'label'   => __( 'City Database File Path', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The file path where the city database provided by MaxMind is located.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the file path where the city database provided by MaxMind is located.', 'lightweight-cookie-notice-free' ),
							),
						),
					),
				),
			),
			array(
				'title'       => __( 'Advanced', 'lightweight-cookie-notice-free' ),
				'description' => __( 'Manage advanced plugin settings.', 'lightweight-cookie-notice-free' ),
				'cards'       => array(
					array(
						'title'   => __( 'Behavior', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'          => 'daextlwcnf_assets_mode',
								'label'         => __( 'Assets Mode', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'With "Development" selected the development version of the JavaScript files used by the plugin will be loaded on the front-end. With "Production" selected the minified version of the JavaScript file used by the plugin will be loaded on the front-end.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the type of assets loaded on the site front end.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Development', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'Production', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_test_mode',
								'label'   => __( 'Test Mode', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'With the test mode enabled, the cookie notice will be applied to the front end only if the user requesting the page is the website administrator.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Apply the cookie notice only when the site is viewed by the website administrator.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_reload_page',
								'label'   => __( 'Reload Page', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'With this option enabled, the page is reloaded when the user accepts the cookies.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Reload the page when the user accepts the cookies.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_store_user_consent',
								'label'   => __( 'Store User Consent', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'When the user makes a selection using the cookie notice buttons, the plugin can store the consent information. The collected records are available in the "Consent Log" menu.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Store the user consent data in a dedicated log.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'      => 'daextlwcnf_transient_expiration',
								'label'     => __( 'Transient Expiration', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The transient expiration in seconds. Set 0 to turn off the transient.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the transient expiration in seconds.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 3600,
								'rangeStep' => 60,
							),
							array(
								'name'    => 'daextlwcnf_page_fragment_caching_exception_w3tc',
								'label'   => __( 'Page Fragment Caching Exception (W3TC)', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'Add the HTML Head and HTML Body code snippets to the page using the Page Fragment Caching Exception feature of the W3 Total Cache plugin.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Use the Page Fragment Caching Exception feature of the W3 Total Cache plugin.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'      => 'daextlwcnf_max_displayed_consent_log_records',
								'label'     => __( 'Consent Log Records', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'The maximum number of consent log records displayed in the "Consent Log" menu.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the maximum number of consent log records displayed in the "Consent Log" menu.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 1000,
								'rangeMax'  => 1000000,
								'rangeStep' => 1000,
							),
						),
					),
					array(
						'title'   => __( 'Fonts', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'    => 'daextlwcnf_google_font_url',
								'label'   => __( 'Google Fonts Embed Code URL', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The URL provided in the Embed Code section of the Google Fonts site.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Load a font on the front end of your site by entering the Embed Code URL.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_headings_font_family',
								'label'   => __( 'Headings Font Family', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The font family used for the headings.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the font family used for the headings.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_paragraphs_font_family',
								'label'   => __( 'Paragraphs Font Family', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The font family used for the paragraphs.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the font family used for the paragraphs.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_buttons_font_family',
								'label'   => __( 'Buttons Font Family', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The font family used for the buttons.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Enter the font family used for the buttons.', 'lightweight-cookie-notice-free' ),
							),
						),
					),
					array(
						'title'   => __( 'Content', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'      => 'daextlwcnf_responsive_breakpoint',
								'label'     => __( 'Responsive Breakpoint', 'lightweight-cookie-notice-free' ),
								'type'      => 'range',
								'tooltip'   => __(
									'When the browser viewport width goes below this value, the plugin will use the mobile version of the cookie notice.',
									'lightweight-cookie-notice-free'
								),
								'help'      => __( 'Set the responsive breakpoint used to enable the mobile version of the cookie notice.', 'lightweight-cookie-notice-free' ),
								'rangeMin'  => 0,
								'rangeMax'  => 1920,
								'rangeStep' => 1,
							),
							array(
								'name'          => 'daextlwcnf_cookie_table_columns',
								'label'         => __( 'Cookie Table Columns', 'lightweight-cookie-notice-free' ),
								'type'          => 'select-multiple',
								'tooltip'       => __(
									'The columns included in the table used to display the cookies.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Select the columns included in the table used to display the cookies.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => 'name',
										'text'  => __( 'Name', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'expiration',
										'text'  => __( 'Expiration', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'purpose',
										'text'  => __( 'Purpose', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'provider',
										'text'  => __( 'Provider', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'domain',
										'text'  => __( 'Domain', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'type',
										'text'  => __( 'Type', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'sensitivity',
										'text'  => __( 'Sensitivity', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'security',
										'text'  => __( 'Security', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => 'more-information',
										'text'  => __( 'More Information', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_force_css_specificity',
								'label'   => __( 'Force CSS Specificity', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'If you enable this option, the plugin will increase the specificity of the plugin CSS using the "!important" directive.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Increase the specificity of the plugin CSS.', 'lightweight-cookie-notice-free' ),
							),
							array(
								'name'    => 'daextlwcnf_compress_output',
								'label'   => __( 'Compress Output', 'lightweight-cookie-notice-free' ),
								'type'    => 'toggle',
								'tooltip' => __(
									'This option determines if the plugin should compress the JavaScript code used to initialize the cookie notice in the front-end.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Compress the JavaScript code used by the plugin.', 'lightweight-cookie-notice-free' ),
							),
						),
					),
					array(
						'title'   => __( 'Cookie Attributes', 'lightweight-cookie-notice-free' ),
						'options' => array(
							array(
								'name'          => 'daextlwcnf_cookie_expiration',
								'label'         => __( 'Expiration', 'lightweight-cookie-notice-free' ),
								'type'          => 'select',
								'tooltip'       => __(
									'The maximum lifetime of the cookies used to store the user selections. When these cookies expire, the user has to submit again its preferences.',
									'lightweight-cookie-notice-free'
								),
								'help'          => __( 'Set the maximum lifetime of the cookies used to store the user selections.', 'lightweight-cookie-notice-free' ),
								'selectOptions' => array(
									array(
										'value' => '0',
										'text'  => __( 'Unlimited', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '1',
										'text'  => __( 'One Hour', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '2',
										'text'  => __( 'One Day', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '3',
										'text'  => __( 'One Week', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '4',
										'text'  => __( 'One Month', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '5',
										'text'  => __( 'Three Months', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '6',
										'text'  => __( 'Six Months', 'lightweight-cookie-notice-free' ),
									),
									array(
										'value' => '7',
										'text'  => __( 'One Year', 'lightweight-cookie-notice-free' ),
									),
								),
							),
							array(
								'name'    => 'daextlwcnf_cookie_path_attribute',
								'label'   => __( 'Path', 'lightweight-cookie-notice-free' ),
								'type'    => 'text',
								'tooltip' => __(
									'The path that must exist in the requested URL for the browser to send the cookies used to store the user selections.',
									'lightweight-cookie-notice-free'
								),
								'help'    => __( 'Indicates the path that must exist in the requested URL for the browser to send the cookies used to store the user selections.', 'lightweight-cookie-notice-free' ),
							),
						),
					),
				),
			),
		);

		return $configuration;
	}

	/**
	 * Echo the SVG icon specified by the $icon_name parameter.
	 *
	 * @param string $icon_name The name of the icon to echo.
	 *
	 * @return void
	 */
	public function echo_icon_svg( $icon_name ) {

		switch ( $icon_name ) {

			case 'file-06':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M14 2.26953V6.40007C14 6.96012 14 7.24015 14.109 7.45406C14.2049 7.64222 14.3578 7.7952 14.546 7.89108C14.7599 8.00007 15.0399 8.00007 15.6 8.00007H19.7305M16 13H8M16 17H8M10 9H8M14 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H15.2C16.8802 22 17.7202 22 18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362C20 19.7202 20 18.8802 20 17.2V8L14 2Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'rows-01':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.8 10C18.9201 10 19.4802 10 19.908 9.78201C20.2843 9.59027 20.5903 9.28431 20.782 8.90798C21 8.48016 21 7.92011 21 6.8V6.2C21 5.0799 21 4.51984 20.782 4.09202C20.5903 3.7157 20.2843 3.40973 19.908 3.21799C19.4802 3 18.9201 3 17.8 3L6.2 3C5.0799 3 4.51984 3 4.09202 3.21799C3.71569 3.40973 3.40973 3.71569 3.21799 4.09202C3 4.51984 3 5.07989 3 6.2L3 6.8C3 7.9201 3 8.48016 3.21799 8.90798C3.40973 9.28431 3.71569 9.59027 4.09202 9.78201C4.51984 10 5.07989 10 6.2 10L17.8 10Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M17.8 21C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V17.2C21 16.0799 21 15.5198 20.782 15.092C20.5903 14.7157 20.2843 14.4097 19.908 14.218C19.4802 14 18.9201 14 17.8 14L6.2 14C5.0799 14 4.51984 14 4.09202 14.218C3.71569 14.4097 3.40973 14.7157 3.21799 15.092C3 15.5198 3 16.0799 3 17.2L3 17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21H17.8Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'rows-02':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3 12H21M7.8 3H16.2C17.8802 3 18.7202 3 19.362 3.32698C19.9265 3.6146 20.3854 4.07354 20.673 4.63803C21 5.27976 21 6.11984 21 7.8V16.2C21 17.8802 21 18.7202 20.673 19.362C20.3854 19.9265 19.9265 20.3854 19.362 20.673C18.7202 21 17.8802 21 16.2 21H7.8C6.11984 21 5.27976 21 4.63803 20.673C4.07354 20.3854 3.6146 19.9265 3.32698 19.362C3 18.7202 3 17.8802 3 16.2V7.8C3 6.11984 3 5.27976 3.32698 4.63803C3.6146 4.07354 4.07354 3.6146 4.63803 3.32698C5.27976 3 6.11984 3 7.8 3Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'divider':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3 12H3.01M7.5 12H7.51M16.5 12H16.51M12 12H12.01M21 12H21.01M21 21V20.2C21 19.0799 21 18.5198 20.782 18.092C20.5903 17.7157 20.2843 17.4097 19.908 17.218C19.4802 17 18.9201 17 17.8 17H6.2C5.0799 17 4.51984 17 4.09202 17.218C3.7157 17.4097 3.40973 17.7157 3.21799 18.092C3 18.5198 3 19.0799 3 20.2V21M21 3V3.8C21 4.9201 21 5.48016 20.782 5.90798C20.5903 6.28431 20.2843 6.59027 19.908 6.78201C19.4802 7 18.9201 7 17.8 7H6.2C5.0799 7 4.51984 7 4.09202 6.78201C3.71569 6.59027 3.40973 6.28431 3.21799 5.90798C3 5.48016 3 4.92011 3 3.8V3" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'rows-03':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3 9H21M3 15H21M7.8 3H16.2C17.8802 3 18.7202 3 19.362 3.32698C19.9265 3.6146 20.3854 4.07354 20.673 4.63803C21 5.27976 21 6.11984 21 7.8V16.2C21 17.8802 21 18.7202 20.673 19.362C20.3854 19.9265 19.9265 20.3854 19.362 20.673C18.7202 21 17.8802 21 16.2 21H7.8C6.11984 21 5.27976 21 4.63803 20.673C4.07354 20.3854 3.6146 19.9265 3.32698 19.362C3 18.7202 3 17.8802 3 16.2V7.8C3 6.11984 3 5.27976 3.32698 4.63803C3.6146 4.07354 4.07354 3.6146 4.63803 3.32698C5.27976 3 6.11984 3 7.8 3Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'list':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M21 12L9 12M21 6L9 6M21 18L9 18M5 12C5 12.5523 4.55228 13 4 13C3.44772 13 3 12.5523 3 12C3 11.4477 3.44772 11 4 11C4.55228 11 5 11.4477 5 12ZM5 6C5 6.55228 4.55228 7 4 7C3.44772 7 3 6.55228 3 6C3 5.44772 3.44772 5 4 5C4.55228 5 5 5.44772 5 6ZM5 18C5 18.5523 4.55228 19 4 19C3.44772 19 3 18.5523 3 18C3 17.4477 3.44772 17 4 17C4.55228 17 5 17.4477 5 18Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'tool-02':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6 6L10.5 10.5M6 6H3L2 3L3 2L6 3V6ZM19.259 2.74101L16.6314 5.36863C16.2354 5.76465 16.0373 5.96265 15.9632 6.19098C15.8979 6.39183 15.8979 6.60817 15.9632 6.80902C16.0373 7.03735 16.2354 7.23535 16.6314 7.63137L16.8686 7.86863C17.2646 8.26465 17.4627 8.46265 17.691 8.53684C17.8918 8.6021 18.1082 8.6021 18.309 8.53684C18.5373 8.46265 18.7354 8.26465 19.1314 7.86863L21.5893 5.41072C21.854 6.05488 22 6.76039 22 7.5C22 10.5376 19.5376 13 16.5 13C16.1338 13 15.7759 12.9642 15.4298 12.8959C14.9436 12.8001 14.7005 12.7521 14.5532 12.7668C14.3965 12.7824 14.3193 12.8059 14.1805 12.8802C14.0499 12.9501 13.919 13.081 13.657 13.343L6.5 20.5C5.67157 21.3284 4.32843 21.3284 3.5 20.5C2.67157 19.6716 2.67157 18.3284 3.5 17.5L10.657 10.343C10.919 10.081 11.0499 9.95005 11.1198 9.81949C11.1941 9.68068 11.2176 9.60347 11.2332 9.44681C11.2479 9.29945 11.1999 9.05638 11.1041 8.57024C11.0358 8.22406 11 7.86621 11 7.5C11 4.46243 13.4624 2 16.5 2C17.5055 2 18.448 2.26982 19.259 2.74101ZM12.0001 14.9999L17.5 20.4999C18.3284 21.3283 19.6716 21.3283 20.5 20.4999C21.3284 19.6715 21.3284 18.3283 20.5 17.4999L15.9753 12.9753C15.655 12.945 15.3427 12.8872 15.0408 12.8043C14.6517 12.6975 14.2249 12.7751 13.9397 13.0603L12.0001 14.9999Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'code-browser':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M22 9H2M14 17.5L16.5 15L14 12.5M10 12.5L7.5 15L10 17.5M2 7.8L2 16.2C2 17.8802 2 18.7202 2.32698 19.362C2.6146 19.9265 3.07354 20.3854 3.63803 20.673C4.27976 21 5.11984 21 6.8 21H17.2C18.8802 21 19.7202 21 20.362 20.673C20.9265 20.3854 21.3854 19.9265 21.673 19.362C22 18.7202 22 17.8802 22 16.2V7.8C22 6.11984 22 5.27977 21.673 4.63803C21.3854 4.07354 20.9265 3.6146 20.362 3.32698C19.7202 3 18.8802 3 17.2 3L6.8 3C5.11984 3 4.27976 3 3.63803 3.32698C3.07354 3.6146 2.6146 4.07354 2.32698 4.63803C2 5.27976 2 6.11984 2 7.8Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'toggle-02-right':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.9995 16H6C3.79086 16 2 14.2091 2 12C2 9.79086 3.79086 8 6 8H13.9995M21.9995 12C21.9995 14.7614 19.7609 17 16.9995 17C14.2381 17 11.9995 14.7614 11.9995 12C11.9995 9.23858 14.2381 7 16.9995 7C19.7609 7 21.9995 9.23858 21.9995 12Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'palette':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M2 12C2 17.5228 6.47715 22 12 22C13.6569 22 15 20.6569 15 19V18.5C15 18.0356 15 17.8034 15.0257 17.6084C15.2029 16.2622 16.2622 15.2029 17.6084 15.0257C17.8034 15 18.0356 15 18.5 15H19C20.6569 15 22 13.6569 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M7 13C7.55228 13 8 12.5523 8 12C8 11.4477 7.55228 11 7 11C6.44772 11 6 11.4477 6 12C6 12.5523 6.44772 13 7 13Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M16 9C16.5523 9 17 8.55228 17 8C17 7.44772 16.5523 7 16 7C15.4477 7 15 7.44772 15 8C15 8.55228 15.4477 9 16 9Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M10 8C10.5523 8 11 7.55228 11 7C11 6.44772 10.5523 6 10 6C9.44772 6 9 6.44772 9 7C9 7.55228 9.44772 8 10 8Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'book-open-01':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 21L11.8999 20.8499C11.2053 19.808 10.858 19.287 10.3991 18.9098C9.99286 18.5759 9.52476 18.3254 9.02161 18.1726C8.45325 18 7.82711 18 6.57482 18H5.2C4.07989 18 3.51984 18 3.09202 17.782C2.71569 17.5903 2.40973 17.2843 2.21799 16.908C2 16.4802 2 15.9201 2 14.8V6.2C2 5.07989 2 4.51984 2.21799 4.09202C2.40973 3.71569 2.71569 3.40973 3.09202 3.21799C3.51984 3 4.07989 3 5.2 3H5.6C7.84021 3 8.96031 3 9.81596 3.43597C10.5686 3.81947 11.1805 4.43139 11.564 5.18404C12 6.03968 12 7.15979 12 9.4M12 21V9.4M12 21L12.1001 20.8499C12.7947 19.808 13.142 19.287 13.6009 18.9098C14.0071 18.5759 14.4752 18.3254 14.9784 18.1726C15.5467 18 16.1729 18 17.4252 18H18.8C19.9201 18 20.4802 18 20.908 17.782C21.2843 17.5903 21.5903 17.2843 21.782 16.908C22 16.4802 22 15.9201 22 14.8V6.2C22 5.07989 22 4.51984 21.782 4.09202C21.5903 3.71569 21.2843 3.40973 20.908 3.21799C20.4802 3 19.9201 3 18.8 3H18.4C16.1598 3 15.0397 3 14.184 3.43597C13.4314 3.81947 12.8195 4.43139 12.436 5.18404C12 6.03968 12 7.15979 12 9.4" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'target-03':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M22 12H18M6 12H2M12 6V2M12 22V18M20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12ZM15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'share-05':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M21 6H17.8C16.1198 6 15.2798 6 14.638 6.32698C14.0735 6.6146 13.6146 7.07354 13.327 7.63803C13 8.27976 13 9.11984 13 10.8V12M21 6L18 3M21 6L18 9M10 3H7.8C6.11984 3 5.27976 3 4.63803 3.32698C4.07354 3.6146 3.6146 4.07354 3.32698 4.63803C3 5.27976 3 6.11984 3 7.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V14" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'settings-01':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M18.7273 14.7273C18.6063 15.0015 18.5702 15.3056 18.6236 15.6005C18.6771 15.8954 18.8177 16.1676 19.0273 16.3818L19.0818 16.4364C19.2509 16.6052 19.385 16.8057 19.4765 17.0265C19.568 17.2472 19.6151 17.4838 19.6151 17.7227C19.6151 17.9617 19.568 18.1983 19.4765 18.419C19.385 18.6397 19.2509 18.8402 19.0818 19.0091C18.913 19.1781 18.7124 19.3122 18.4917 19.4037C18.271 19.4952 18.0344 19.5423 17.7955 19.5423C17.5565 19.5423 17.3199 19.4952 17.0992 19.4037C16.8785 19.3122 16.678 19.1781 16.5091 19.0091L16.4545 18.9545C16.2403 18.745 15.9682 18.6044 15.6733 18.5509C15.3784 18.4974 15.0742 18.5335 14.8 18.6545C14.5311 18.7698 14.3018 18.9611 14.1403 19.205C13.9788 19.4489 13.8921 19.7347 13.8909 20.0273V20.1818C13.8909 20.664 13.6994 21.1265 13.3584 21.4675C13.0174 21.8084 12.5549 22 12.0727 22C11.5905 22 11.1281 21.8084 10.7871 21.4675C10.4461 21.1265 10.2545 20.664 10.2545 20.1818V20.1C10.2475 19.7991 10.1501 19.5073 9.97501 19.2625C9.79991 19.0176 9.55521 18.8312 9.27273 18.7273C8.99853 18.6063 8.69437 18.5702 8.39947 18.6236C8.10456 18.6771 7.83244 18.8177 7.61818 19.0273L7.56364 19.0818C7.39478 19.2509 7.19425 19.385 6.97353 19.4765C6.7528 19.568 6.51621 19.6151 6.27727 19.6151C6.03834 19.6151 5.80174 19.568 5.58102 19.4765C5.36029 19.385 5.15977 19.2509 4.99091 19.0818C4.82186 18.913 4.68775 18.7124 4.59626 18.4917C4.50476 18.271 4.45766 18.0344 4.45766 17.7955C4.45766 17.5565 4.50476 17.3199 4.59626 17.0992C4.68775 16.8785 4.82186 16.678 4.99091 16.5091L5.04545 16.4545C5.25503 16.2403 5.39562 15.9682 5.4491 15.6733C5.50257 15.3784 5.46647 15.0742 5.34545 14.8C5.23022 14.5311 5.03887 14.3018 4.79497 14.1403C4.55107 13.9788 4.26526 13.8921 3.97273 13.8909H3.81818C3.33597 13.8909 2.87351 13.6994 2.53253 13.3584C2.19156 13.0174 2 12.5549 2 12.0727C2 11.5905 2.19156 11.1281 2.53253 10.7871C2.87351 10.4461 3.33597 10.2545 3.81818 10.2545H3.9C4.2009 10.2475 4.49273 10.1501 4.73754 9.97501C4.98236 9.79991 5.16883 9.55521 5.27273 9.27273C5.39374 8.99853 5.42984 8.69437 5.37637 8.39947C5.3229 8.10456 5.18231 7.83244 4.97273 7.61818L4.91818 7.56364C4.74913 7.39478 4.61503 7.19425 4.52353 6.97353C4.43203 6.7528 4.38493 6.51621 4.38493 6.27727C4.38493 6.03834 4.43203 5.80174 4.52353 5.58102C4.61503 5.36029 4.74913 5.15977 4.91818 4.99091C5.08704 4.82186 5.28757 4.68775 5.50829 4.59626C5.72901 4.50476 5.96561 4.45766 6.20455 4.45766C6.44348 4.45766 6.68008 4.50476 6.9008 4.59626C7.12152 4.68775 7.32205 4.82186 7.49091 4.99091L7.54545 5.04545C7.75971 5.25503 8.03183 5.39562 8.32674 5.4491C8.62164 5.50257 8.9258 5.46647 9.2 5.34545H9.27273C9.54161 5.23022 9.77093 5.03887 9.93245 4.79497C10.094 4.55107 10.1807 4.26526 10.1818 3.97273V3.81818C10.1818 3.33597 10.3734 2.87351 10.7144 2.53253C11.0553 2.19156 11.5178 2 12 2C12.4822 2 12.9447 2.19156 13.2856 2.53253C13.6266 2.87351 13.8182 3.33597 13.8182 3.81818V3.9C13.8193 4.19253 13.906 4.47834 14.0676 4.72224C14.2291 4.96614 14.4584 5.15749 14.7273 5.27273C15.0015 5.39374 15.3056 5.42984 15.6005 5.37637C15.8954 5.3229 16.1676 5.18231 16.3818 4.97273L16.4364 4.91818C16.6052 4.74913 16.8057 4.61503 17.0265 4.52353C17.2472 4.43203 17.4838 4.38493 17.7227 4.38493C17.9617 4.38493 18.1983 4.43203 18.419 4.52353C18.6397 4.61503 18.8402 4.74913 19.0091 4.91818C19.1781 5.08704 19.3122 5.28757 19.4037 5.50829C19.4952 5.72901 19.5423 5.96561 19.5423 6.20455C19.5423 6.44348 19.4952 6.68008 19.4037 6.9008C19.3122 7.12152 19.1781 7.32205 19.0091 7.49091L18.9545 7.54545C18.745 7.75971 18.6044 8.03183 18.5509 8.32674C18.4974 8.62164 18.5335 8.9258 18.6545 9.2V9.27273C18.7698 9.54161 18.9611 9.77093 19.205 9.93245C19.4489 10.094 19.7347 10.1807 20.0273 10.1818H20.1818C20.664 10.1818 21.1265 10.3734 21.4675 10.7144C21.8084 11.0553 22 11.5178 22 12C22 12.4822 21.8084 12.9447 21.4675 13.2856C21.1265 13.6266 20.664 13.8182 20.1818 13.8182H20.1C19.8075 13.8193 19.5217 13.906 19.2778 14.0676C19.0339 14.2291 18.8425 14.4584 18.7273 14.7273Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'file-code-01':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M14 2.26953V6.40007C14 6.96012 14 7.24015 14.109 7.45406C14.2049 7.64222 14.3578 7.7952 14.546 7.89108C14.7599 8.00007 15.0399 8.00007 15.6 8.00007H19.7305M14 17.5L16.5 15L14 12.5M10 12.5L7.5 15L10 17.5M20 9.98822V17.2C20 18.8802 20 19.7202 19.673 20.362C19.3854 20.9265 18.9265 21.3854 18.362 21.673C17.7202 22 16.8802 22 15.2 22H8.8C7.11984 22 6.27976 22 5.63803 21.673C5.07354 21.3854 4.6146 20.9265 4.32698 20.362C4 19.7202 4 18.8802 4 17.2V6.8C4 5.11984 4 4.27976 4.32698 3.63803C4.6146 3.07354 5.07354 2.6146 5.63803 2.32698C6.27976 2 7.11984 2 8.8 2H12.0118C12.7455 2 13.1124 2 13.4577 2.08289C13.7638 2.15638 14.0564 2.27759 14.3249 2.44208C14.6276 2.6276 14.887 2.88703 15.4059 3.40589L18.5941 6.59411C19.113 7.11297 19.3724 7.3724 19.5579 7.67515C19.7224 7.94356 19.8436 8.2362 19.9171 8.5423C20 8.88757 20 9.25445 20 9.98822Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'file-code-02':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5 18.5C5 18.9644 5 19.1966 5.02567 19.3916C5.2029 20.7378 6.26222 21.7971 7.60842 21.9743C7.80337 22 8.03558 22 8.5 22H16.2C17.8802 22 18.7202 22 19.362 21.673C19.9265 21.3854 20.3854 20.9265 20.673 20.362C21 19.7202 21 18.8802 21 17.2V9.98822C21 9.25445 21 8.88757 20.9171 8.5423C20.8436 8.2362 20.7224 7.94356 20.5579 7.67515C20.3724 7.3724 20.113 7.11296 19.5941 6.59411L16.4059 3.40589C15.887 2.88703 15.6276 2.6276 15.3249 2.44208C15.0564 2.27759 14.7638 2.15638 14.4577 2.08289C14.1124 2 13.7455 2 13.0118 2H8.5C8.03558 2 7.80337 2 7.60842 2.02567C6.26222 2.2029 5.2029 3.26222 5.02567 4.60842C5 4.80337 5 5.03558 5 5.5M9 14.5L11.5 12L9 9.5M5 9.5L2.5 12L5 14.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'trash-01':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'trash-03':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M9 3H15M3 6H21M19 6L18.2987 16.5193C18.1935 18.0975 18.1409 18.8867 17.8 19.485C17.4999 20.0118 17.0472 20.4353 16.5017 20.6997C15.882 21 15.0911 21 13.5093 21H10.4907C8.90891 21 8.11803 21 7.49834 20.6997C6.95276 20.4353 6.50009 20.0118 6.19998 19.485C5.85911 18.8867 5.8065 18.0975 5.70129 16.5193L5 6M10 10.5V15.5M14 10.5V15.5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'grid-01':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.4 3H4.6C4.03995 3 3.75992 3 3.54601 3.10899C3.35785 3.20487 3.20487 3.35785 3.10899 3.54601C3 3.75992 3 4.03995 3 4.6V8.4C3 8.96005 3 9.24008 3.10899 9.45399C3.20487 9.64215 3.35785 9.79513 3.54601 9.89101C3.75992 10 4.03995 10 4.6 10H8.4C8.96005 10 9.24008 10 9.45399 9.89101C9.64215 9.79513 9.79513 9.64215 9.89101 9.45399C10 9.24008 10 8.96005 10 8.4V4.6C10 4.03995 10 3.75992 9.89101 3.54601C9.79513 3.35785 9.64215 3.20487 9.45399 3.10899C9.24008 3 8.96005 3 8.4 3Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M19.4 3H15.6C15.0399 3 14.7599 3 14.546 3.10899C14.3578 3.20487 14.2049 3.35785 14.109 3.54601C14 3.75992 14 4.03995 14 4.6V8.4C14 8.96005 14 9.24008 14.109 9.45399C14.2049 9.64215 14.3578 9.79513 14.546 9.89101C14.7599 10 15.0399 10 15.6 10H19.4C19.9601 10 20.2401 10 20.454 9.89101C20.6422 9.79513 20.7951 9.64215 20.891 9.45399C21 9.24008 21 8.96005 21 8.4V4.6C21 4.03995 21 3.75992 20.891 3.54601C20.7951 3.35785 20.6422 3.20487 20.454 3.10899C20.2401 3 19.9601 3 19.4 3Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M19.4 14H15.6C15.0399 14 14.7599 14 14.546 14.109C14.3578 14.2049 14.2049 14.3578 14.109 14.546C14 14.7599 14 15.0399 14 15.6V19.4C14 19.9601 14 20.2401 14.109 20.454C14.2049 20.6422 14.3578 20.7951 14.546 20.891C14.7599 21 15.0399 21 15.6 21H19.4C19.9601 21 20.2401 21 20.454 20.891C20.6422 20.7951 20.7951 20.6422 20.891 20.454C21 20.2401 21 19.9601 21 19.4V15.6C21 15.0399 21 14.7599 20.891 14.546C20.7951 14.3578 20.6422 14.2049 20.454 14.109C20.2401 14 19.9601 14 19.4 14Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M8.4 14H4.6C4.03995 14 3.75992 14 3.54601 14.109C3.35785 14.2049 3.20487 14.3578 3.10899 14.546C3 14.7599 3 15.0399 3 15.6V19.4C3 19.9601 3 20.2401 3.10899 20.454C3.20487 20.6422 3.35785 20.7951 3.54601 20.891C3.75992 21 4.03995 21 4.6 21H8.4C8.96005 21 9.24008 21 9.45399 20.891C9.64215 20.7951 9.79513 20.6422 9.89101 20.454C10 20.2401 10 19.9601 10 19.4V15.6C10 15.0399 10 14.7599 9.89101 14.546C9.79513 14.3578 9.64215 14.2049 9.45399 14.109C9.24008 14 8.96005 14 8.4 14Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'chevron-up':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M18 15L12 9L6 15" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'chevron-down':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6 9L12 15L18 9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'chevron-left':
				$xml = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M15 18L9 12L15 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'chevron-left-double':
				$xml = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M18 17L13 12L18 7M11 17L6 12L11 7" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'chevron-right':
				$xml = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M9 18L15 12L9 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'chevron-right-double':
				$xml = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6 17L11 12L6 7M13 17L18 12L13 7" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'arrow-up-right':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M7 17L17 7M17 7H7M17 7V17" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'plus':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 5V19M5 12H19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'check-circle-broken':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M22 11.0857V12.0057C21.9988 14.1621 21.3005 16.2604 20.0093 17.9875C18.7182 19.7147 16.9033 20.9782 14.8354 21.5896C12.7674 22.201 10.5573 22.1276 8.53447 21.3803C6.51168 20.633 4.78465 19.2518 3.61096 17.4428C2.43727 15.6338 1.87979 13.4938 2.02168 11.342C2.16356 9.19029 2.99721 7.14205 4.39828 5.5028C5.79935 3.86354 7.69279 2.72111 9.79619 2.24587C11.8996 1.77063 14.1003 1.98806 16.07 2.86572M22 4L12 14.01L9 11.01" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'log-in-04':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 8L16 12M16 12L12 16M16 12H3M3.33782 7C5.06687 4.01099 8.29859 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C8.29859 22 5.06687 19.989 3.33782 17" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'log-out-04':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M18 8L22 12M22 12L18 16M22 12H9M15 4.20404C13.7252 3.43827 12.2452 3 10.6667 3C5.8802 3 2 7.02944 2 12C2 16.9706 5.8802 21 10.6667 21C12.2452 21 13.7252 20.5617 15 19.796" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			case 'clipboard-icon-svg':
				$xml = '<?xml version="1.0" encoding="utf-8"?>
				<svg version="1.1" id="Layer_3" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
					 viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
				<path d="M14,18H8c-1.1,0-2-0.9-2-2V7c0-1.1,0.9-2,2-2h6c1.1,0,2,0.9,2,2v9C16,17.1,15.1,18,14,18z M8,7v9h6V7H8z"/>
				<path d="M5,4h6V2H5C3.9,2,3,2.9,3,4v9h2V4z"/>
				</svg>';

				$allowed_html = array(
					'svg'  => array(
						'version' => array(),
						'id'      => array(),
						'xmlns'   => array(),
						'x'       => array(),
						'y'       => array(),
						'viewbox' => array(),
						'style'   => array(),
					),
					'path' => array(
						'd' => array(),
					),
				);

				break;

			case 'x':
				$xml = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M17 7L7 17M7 7L17 17" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'version' => array(),
						'id'      => array(),
						'xmlns'   => array(),
						'x'       => array(),
						'y'       => array(),
						'viewbox' => array(),
						'style'   => array(),
					),
					'path' => array(
						'd' => array(),
					),
				);

				break;

			case 'diamond-01':
				$xml = '<svg class="untitled-ui-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M2.49954 9H21.4995M9.99954 3L7.99954 9L11.9995 20.5L15.9995 9L13.9995 3M12.6141 20.2625L21.5727 9.51215C21.7246 9.32995 21.8005 9.23885 21.8295 9.13717C21.8551 9.04751 21.8551 8.95249 21.8295 8.86283C21.8005 8.76114 21.7246 8.67005 21.5727 8.48785L17.2394 3.28785C17.1512 3.18204 17.1072 3.12914 17.0531 3.09111C17.0052 3.05741 16.9518 3.03238 16.8953 3.01717C16.8314 3 16.7626 3 16.6248 3H7.37424C7.2365 3 7.16764 3 7.10382 3.01717C7.04728 3.03238 6.99385 3.05741 6.94596 3.09111C6.89192 3.12914 6.84783 3.18204 6.75966 3.28785L2.42633 8.48785C2.2745 8.67004 2.19858 8.76114 2.16957 8.86283C2.144 8.95249 2.144 9.04751 2.16957 9.13716C2.19858 9.23885 2.2745 9.32995 2.42633 9.51215L11.385 20.2625C11.596 20.5158 11.7015 20.6424 11.8279 20.6886C11.9387 20.7291 12.0603 20.7291 12.1712 20.6886C12.2975 20.6424 12.4031 20.5158 12.6141 20.2625Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				';

				$allowed_html = array(
					'svg'  => array(
						'class'   => array(),
						'width'   => array(),
						'height'  => array(),
						'viewbox' => array(),
						'fill'    => array(),
						'xmlns'   => array(),
					),
					'path' => array(
						'd'               => array(),
						'stroke'          => array(),
						'stroke-width'    => array(),
						'stroke-linecap'  => array(),
						'stroke-linejoin' => array(),
					),
				);

				break;

			default:
				$xml = '';

				break;

		}

		echo wp_kses( $xml, $allowed_html );
	}

	/**
	 * Display the dismissible notices stored in the "daim_dismissible_notice_a" option.
	 *
	 * Note that the dismissible notice will be displayed only once to the user.
	 *
	 * The dismissable notice is first displayed (only to the same user with which has been generated) and then it is
	 * removed from the "daim_dismissible_notice_a" option.
	 *
	 * @return void
	 */
	public function display_dismissible_notices() {

		$dismissible_notice_a = get_option( 'daim_dismissible_notice_a' );

		// Iterate over the dismissible notices with the user id of the same user.
		if ( is_array( $dismissible_notice_a ) ) {
			foreach ( $dismissible_notice_a as $key => $dismissible_notice ) {

				// If the user id of the dismissible notice is the same as the current user id, display the message.
				if ( get_current_user_id() === $dismissible_notice['user_id'] ) {

					$message = $dismissible_notice['message'];
					$class   = $dismissible_notice['class'];

					?>
					<div class="<?php echo esc_attr( $class ); ?> notice">
						<p><?php echo esc_html( $message ); ?></p>
						<div class="notice-dismiss-button"><?php $this->echo_icon_svg( 'x' ); ?></div>
					</div>

					<?php

					// Remove the echoed dismissible notice from the "daim_dismissible_notice_a" WordPress option.
					unset( $dismissible_notice_a[ $key ] );

					update_option( 'daim_dismissible_notice_a', $dismissible_notice_a );

				}
			}
		}
	}

	/**
	 * Save a dismissible notice in the "daim_dismissible_notice_a" WordPress.
	 *
	 * @param string $message The message of the dismissible notice.
	 * @param string $element_class The class of the dismissible notice.
	 *
	 * @return void
	 */
	public function save_dismissible_notice( $message, $element_class ) {

		$dismissible_notice = array(
			'user_id' => get_current_user_id(),
			'message' => $message,
			'class'   => $element_class,
		);

		// Get the current option value.
		$dismissible_notice_a = get_option( 'daim_dismissible_notice_a' );

		// If the option is not an array, initialize it as an array.
		if ( ! is_array( $dismissible_notice_a ) ) {
			$dismissible_notice_a = array();
		}

		// Add the dismissible notice to the array.
		$dismissible_notice_a[] = $dismissible_notice;

		// Save the dismissible notice in the "daim_dismissible_notice_a" WordPress option.
		update_option( 'daim_dismissible_notice_a', $dismissible_notice_a );
	}

	/**
	 * Escape the double quotes of the $content string, so the returned string
	 * can be used in CSV fields enclosed by double quotes.
	 *
	 * @param string $content The unescape content ( Ex: She said "No!" ).
	 * @return string The escaped content ( Ex: She said ""No!"" ).
	 */
	public function esc_csv( $content ) {
		return str_replace( '"', '""', $content );
	}

	/**
	 * Iterate the $results array and find the acceptance rate of the categories.
	 *
	 * @param array $results The consent log records.
	 *
	 * @return float The acceptance rate of the categories.
	 */
	public function get_acceptance_rate( $results ) {

		// Init variables.
		$accepted = 0;
		$rejected = 0;

		// Iterate the $results array.
		foreach ( $results as $key => $result ) {

			// Convert the JSON in $result['formatted_state'] to an array.
			$formatted_state = json_decode( $result->formatted_state, true );

			if ( isset( $formatted_state['category_cookies'] ) ) {
				foreach ( $formatted_state['category_cookies'] as $category_cookie ) {
					if ( 1 === intval( $category_cookie['status'], 10 ) ) {
						++$accepted;
					} else {
						++$rejected;
					}
				}
			}
		}

		if ( $accepted + $rejected > 0 ) {
			$acceptance_rate = ( $accepted / ( $accepted + $rejected ) ) * 100;
			$acceptance_rate = round( $acceptance_rate, 1 ). '%';
		} else {
			$acceptance_rate = 'N/A';
		}

		return $acceptance_rate;
	}

	/**
	 * Returns true if there are exportable data or false if here are no exportable data.
	 */
	public function exportable_data_exists() {

		$exportable_data = false;
		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}daextlwcnf_category" );
		if ( $total_items > 0 ) {
			$exportable_data = true;
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}daextlwcnf_consent_log" );
		if ( $total_items > 0 ) {
			$exportable_data = true;
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}daextlwcnf_cookie" );
		if ( $total_items > 0 ) {
			$exportable_data = true;
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}daextlwcnf_section" );
		if ( $total_items > 0 ) {
			$exportable_data = true;
		}

		return $exportable_data;
	}

	/**
	 * Sanitize the data of an uploaded file.
	 *
	 * @param array $file The data of the uploaded file.
	 *
	 * @return array
	 */
	public function sanitize_uploaded_file( $file ) {

		return array(
			'name'     => sanitize_file_name( $file['name'] ),
			'type'     => $file['type'],
			'tmp_name' => $file['tmp_name'],
			'error'    => intval( $file['error'], 10 ),
			'size'     => intval( $file['size'], 10 ),
		);
	}

	/**
	 * Method used in the GenericReactSelect component of the "Cookies" Gutenberg blocks.
	 *
	 * Returns a JSON string that includes name and ID of all the categories. The returned value is used in the
	 * "Cookie" editor block to populate the "Category" select field.
	 */
	public function get_category_data() {

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
		return wp_json_encode( $category_a );
	}

	/**
	 * Generates the consent id.
	 */
	public function generate_consent_id() {

		$rnd_chars = '';

		do {

			// Generate a unique id based on the site url and current time in microseconds.
			$prefix    = get_site_url();
			$unique_id = uniqid( $prefix, true );

			// Generate a random string of 256 characters.
			for ( $i = 1; $i <= 256; $i++ ) {
				$rnd_chars .= wp_rand( 0, 9 );
			}

			$consent_id = hash( 'sha512', $unique_id . $rnd_chars );

		} while ( $this->consent_id_exists( $consent_id ) );

		return $consent_id;
	}

	/**
	 * Verifies if the consent id exists.
	 *
	 * @param string $consent_id The consent id.
	 *
	 * @return bool
	 */
	public function consent_id_exists( $consent_id ) {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$total_items = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}daextlwcnf_consent_log WHERE consent_id = %s", $consent_id )
		);

		if ( $total_items > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Sanitize the data of the category states provided as an escaped json string.
	 *
	 * @param array $category_state The category state data provided as an escaped json string.
	 *
	 * @return array|bool
	 */
	public function sanitize_category_state( $category_state ) {

		// Unescape and decode the data provided in json format.
		$category_state_a = json_decode( $category_state );

		// Verify if data property of the returned object is an array.
		if ( ! isset( $category_state_a ) || ! is_array( $category_state_a ) ) {
			return false;
		}

		foreach ( $category_state_a as $single_category_state ) {
			$single_category_state->categoryId = intval( $single_category_state->categoryId, 10 );
			$single_category_state->status     = intval( $single_category_state->status, 10 );
		}

		return $category_state_a;
	}
}
