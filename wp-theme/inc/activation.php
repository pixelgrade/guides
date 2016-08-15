<?php
/**
 * Theme activation hook
 *
 * @package Guides
 * @since Guides 1.0
 */

if ( ! function_exists( 'guides_config_getting_active' ) ) {
	/**
	 * ACTIVATION SETTINGS
	 * These settings will be needed when the theme will get active
	 * Careful with the first setup, most of them will go in the clients database and they will be stored there
	 */
	function guides_config_getting_active() {

		// force  settings for comments ratings settings
		$pixreviews_settings = get_option( 'pixreviews_settings' );
		if ( ! isset( $pixreviews_settings['settings_saved_once'] ) || $pixreviews_settings['settings_saved_once'] !== '1' ) {

			$pixreviews_settings['enable_selective_ratings'] = true;
			$pixreviews_settings['display_on_post_types']    = array(
				'job_listing' => 'on'
			);
			$pixreviews_settings['settings_saved_once']      = '1';
			update_option( 'pixreviews_settings', $pixreviews_settings );
		}

		// force  settings for category icon settings
		$category_icons = get_option( 'category-icon' );
		if ( ! isset( $category_icons['settings_saved_once'] ) || $category_icons['settings_saved_once'] !== '1' ) {
			$category_icons['taxonomies']          = array(
				'category'             => 'on',
				'post_tag'             => 'on',
				'job_listing_category' => 'on',
				'job_listing_region'   => 'on',
				'job_listing_tag'      => 'on'
			);
			$category_icons['settings_saved_once'] = '1';
			update_option( 'category-icon', $category_icons );

			// also at the first activation adjust a few settings for wp-job manager
			update_option( 'job_manager_enable_categories', '1' );
			update_option( 'job_manager_enable_tag_archive', '1' );
			update_option( 'job_manager_tag_input', 'multiselect' );
			update_option( 'job_manager_paid_listings_flow', 'before' );
		}

		// add defaults widgets
		$already_added = get_option( 'guides_default_widgets_added' );
		if ( empty( $already_added ) || $already_added !== '1' ) {

			$current_widgets = get_option( 'sidebars_widgets' );

			// prepare the default widgets
			$current_widgets['listing_content']         = array(
				'listing_actions-2',
				'listing_content-2',
				'listing_comments-2'
			);
			$current_widgets['listing__sticky_sidebar'] = array(
				'listing_sidebar_map-2'
			);
			$current_widgets['listing_sidebar']         = array(
				'listing_sidebar_categories-2',
				'listing_sidebar_hours-2',
				'listing_sidebar_gallery-2',
			);
			$current_widgets['front_page_sections']     = array(
				'front_page_listing_categories-2',
				'front_page_listing_cards-2',
				'front_page_spotlights-2',
				'front_page_recent_posts-2',
			);

			update_option( 'sidebars_widgets', $current_widgets );
			update_option( 'guides_default_widgets_added', '1' );

			update_option( 'widget_listing_content', array( '2' => array(), '_multiwidget' => 1 ) );
			update_option( 'widget_listing_actions', array( '2' => array(), '_multiwidget' => 1 ) );
			update_option( 'widget_listing_comments', array( '2' => array(), '_multiwidget' => 1 ) );

			update_option( 'widget_listing_sidebar_map', array( '2' => array(), '_multiwidget' => 1 ) );

			update_option( 'widget_listing_sidebar_categories', array( '2' => array(), '_multiwidget' => 1 ) );
			update_option( 'widget_listing_sidebar_hours', array( '2' => array(), '_multiwidget' => 1 ) );
			update_option( 'widget_listing_sidebar_gallery', array( '2' => array(), '_multiwidget' => 1 ) );

			update_option( 'widget_front_page_listing_categories', array( '2' => array(), '_multiwidget' => 1 ) );
			update_option( 'widget_front_page_listing_cards', array( '2' => array(), '_multiwidget' => 1 ) );
			update_option( 'widget_front_page_spotlights', array( '2' => array(), '_multiwidget' => 1 ) );
			update_option( 'widget_front_page_recent_posts', array( '2' => array(), '_multiwidget' => 1 ) );
		}
	}
} // end guides_config_getting_active
add_action( 'after_switch_theme', 'guides_config_getting_active' );