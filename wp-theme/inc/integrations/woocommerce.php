<?php
/**
 * In this file we will put every function or hook which is needed to provide WooCommerce compatibility
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

