<?php
/**
 * This file includes functions that in order to support the "Page Fragment Cache" feature of W3 Total Cache can't be
 * included in the plugin classes.
 *
 * @package lightweight-cookie-notice-free
 */

/**
 * Prints the scripts associated with the categories when the acceptance state of the category is enabled.
 *
 * @param bool $in_footer Whether to verify and print the HEAD or the BODY script of the category.
 */
function daextlwcnf_print_scripts( $in_footer = false ) {

	if ( ! isset( $_COOKIE['daextlwcnf-accepted'] ) || ! isset( $_COOKIE['daextlwcnf-category-status'] ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- The sanitization is performed in sanitize_category_state().
	$category_state_a = sanitize_category_state( wp_unslash( $_COOKIE['daextlwcnf-category-status'] ) );

	if ( $in_footer ) {
		$position = 'script_body';
	} else {
		$position = 'script_head';
	}

	global $wpdb;

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$category_a = $wpdb->get_results(
		"SELECT * FROM {$wpdb->prefix}daextlwcnf_category ORDER BY priority ASC",
		ARRAY_A
	);

	foreach ( $category_a as $key => $category ) {

		if ( strlen( trim( $category[ $position ] ) ) > 0 ) {

			// Print the script only if this category state is enabled.
			foreach ( $category_state_a as $key => $single_category_state ) {
				if ( intval( $category['category_id'], 10 ) === $single_category_state->categoryId &&
					1 === $single_category_state->status ) {

					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- This is necessary and not a security issues since the plugin gives the ability to the user to insert HTML in the page.
					echo wp_unslash( $category[ $position ] );

				}
			}
		}
	}
}

/**
 * Sanitize the data of the category states provided as an escaped json string.
 *
 * @param array $category_state The category state data provided as an escaped json string.
 *
 * @return array|bool
 */
function sanitize_category_state( $category_state ) {

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
