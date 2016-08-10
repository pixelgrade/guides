<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Guides
 */

if ( ! function_exists( 'guides_get_option' ) ) {
	/**
	 * Get option from the database
	 *
	 * @param string
	 *
	 * @return mixed
	 */
	function guides_get_option( $option, $default = null ) {
		global $pixcustomify_plugin;

		// if there is set an key in url force that value
		if ( isset( $_GET[ $option ] ) && ! empty( $option ) ) {

			return $_GET[ $option ];

		} elseif ( $pixcustomify_plugin !== null ) {

			$customify_value = $pixcustomify_plugin->get_option( $option, $default );

			return $customify_value;
		}

		return $default;
	} //end function
} // end if guides_get_option exists

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
if ( ! function_exists( 'guides_body_classes' ) ) {
	function guides_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'guides_body_classes' );