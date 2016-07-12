<?php
/**
 * This file is responsible for registering sidebar areas and widgets
 */

/**
 * First register the widget areas, aka sidebars, following this pattern
 * https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function guides_widgets_areas() {
	register_sidebar( array(
		'name' => esc_html__( 'Main Sidebar', 'guides' ),
		'id' => 'sidebar-1',
		'description' => esc_html__( 'Widgets in this area will be shown on all posts and pages.', 'guides' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'guides_widgets_areas' );

/**
 * Any widget registration should follow this patter
 * https://codex.wordpress.org/Function_Reference/register_widget
 */