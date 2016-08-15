<?php
/**
 * In this file we will put every function or hook which is needed to provide WooCommerce compatibility.
 *
 * Is preferable to use this file instead of overwriting WooCommerce template files. The plugin will always update
 * template files and trigger the "Deprecated template" notice.
 * Overwriting a functionality with a filter or an action is always the first choice
 *
 */

/**
 * Declare support for WooCommerce
 */
function guides_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'guides_add_woocommerce_support' );

/**
 * First remove the WooCommerce style. We'll provide one.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

