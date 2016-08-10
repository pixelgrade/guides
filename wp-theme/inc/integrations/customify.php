<?php
/**
 * Guides Options Config
 *
 * @package Guides
 * @since Guides 1.0
 */

/**
 * Hook into the Customify's fields and settings.
 *
 * The config can turn to be complex so is better to visit:
 * https://github.com/pixelgrade/customify
 *
 * @param $options array - Contains the plugin's options array right before they are used, so edit with care
 *
 * @return mixed The return of options is required, if you don't need options return an empty array
 *
 */
if ( ! function_exists( 'guides_add_customify_options' ) ) {
	function guides_add_customify_options( $options ) {

		// $options['panels'] = array();
		return $options;
	}
}
add_filter( 'customify_filter_fields', 'guides_add_customify_options' );
