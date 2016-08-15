<?php
/**
 * Require files that deal with various plugin integrations.
 *
 * @package Guides
 */

/**
 * Load WooCommerce compatibility file.
 * https://www.woothemes.com/woocommerce/
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/integrations/woocommerce.php';
}

/**
 * Load Customify compatibility file.
 * http://pixelgrade.com/
 */
require get_template_directory() . '/inc/integrations/customify.php';

/**
 * Load PixTypes compatibility file.
 * http://pixelgrade.com/
 */
require get_template_directory() . '/inc/integrations/pixtypes.php';