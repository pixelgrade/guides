<?php
/**
 * Theme activation hook for PixTypes
 *
 * @package Guides
 * @since Guides 1.0
 */

if ( ! function_exists( 'guides_prepare_theme_for_pixtypes' ) ) :
	function guides_prepare_theme_for_pixtypes() {
		/**
		 * ACTIVATION SETTINGS
		 * These settings will be needed when the theme will get active
		 * Careful with the first setup, most of them will go in the clients database and they will be stored there
		 */
		$pixtypes_conf_settings = array(
			'first_activation' => true,
			'metaboxes'        => array(
				'_listing_the_aside' => array(
					'id'         => 'listing_aside',
					'title'      => esc_html__( 'Gallery Images', 'guides' ),
					'pages'      => array( 'job_listing' ), // Post type
					'context'    => 'side',
					'priority'   => 'low',
					'show_names' => true, // Show field names on the left
					'fields'     => array(
						array(
							'name' => esc_html__( 'Gallery Image', 'guides' ),
							'id'   => 'main_image',
							'type' => 'gallery',
						),
					)
				),

				'_page_background' => array(
					'id'         => '_page_background',
					'title'      => sprintf(
						'%s <a class="tooltip" title="%s.<p>%s <strong>%s</strong>, %s <strong>%s</strong> %s.</p>"></a>',
						esc_html__( 'Hero Area', 'guides' ) ,
						esc_html__( 'Add an image or a video to be used as a Background for the Hero Area on the Front Page', 'guides' ),
						esc_html__( 'Tip: Uploading', 'guides' ),
						esc_html__( 'multiple images and/or videos', 'guides' ),
						esc_html__( 'will', 'guides' ),
						esc_html__( 'randomly', 'guides' ),
						esc_html__( 'pick one when page is loaded', 'guides' )
					),
					'pages'      => array( 'page' ), // Post type
					'context'    => 'side',
					'priority'   => 'low',
					'show_names' => false, // Show field names on the left
					'show_on'    => array(
						'key'   => 'page-template',
						'value' => array( 'page-templates/front_page.php' ),
					),
					'fields'     => array(
						array(
							'name' => esc_html__( 'Gallery Image', 'guides' ),
							'id'   => 'image_backgrounds',
							'type' => 'gallery',

						),
						array(
							'name' => esc_html__( 'Playlist', 'guides' ),
							'id'   => 'videos_backgrounds',
							'type' => 'playlist',
						),
					)
				),
				'_page_frontpage_search_fields' => array(
					'id'         => '_page_frontpage_search_fields',
					'title'      => '&#x1f535; ' . esc_html__( 'Front Page &raquo; Search Fields', 'guides' ) . ' <a class="tooltip" title="' . esc_html__( '<p>Choose what fields to show in the hero area of this front page.</p>', 'guides' ) . '"></a>',
					'pages'      => array( 'page' ), // Post type
					'priority'   => 'high',
					'show_names' => true, // Show field names on the left
					'show_on'    => array(
						'key'   => 'page-template',
						'value' => array( 'page-templates/front_page.php' ),
					),
					'fields'     => array(
						array(
							'name' => esc_html__( 'Search Fields', 'guides' ),
							'desc' => '',
							'id'   => 'frontpage_search_fields',
							'type' => 'multicheck',
							'options' => array(
								'keywords' => esc_html__( 'Keywords', 'guides' ),
								'location' => esc_html__( 'Location', 'guides' ),
								'categories' => esc_html__( 'Categories', 'guides' ),
							),
							'std' => array('keywords'),
						),
					)
				),
				'_page_frontpage_categories' => array(
					'id'         => '_page_frontpage_listing_categories',
					'title'      => '&#x1f535; ' . esc_html__( 'Front Page &raquo; Highlighted Categories', 'guides' ) . ' <a class="tooltip" title="' . esc_html__( '<p>You can select which categories to highlight, by adding their <em>slugs</em>, separated by a comma: <em>food, hotels, restaurants</em></p><p> You can change their <em>shown name</em> (in case it is too long) with this pattern: <em>slug (My Custom Name)</em></p>', 'guides' ) . '"></a>',
					'pages'      => array( 'page' ), // Post type
					'priority'   => 'high',
					'show_names' => false, // Show field names on the left
					'show_on'    => array(
						'key'   => 'page-template',
						'value' => array( 'page-templates/front_page.php' ),
					),
					'fields'     => array(
						array(
							'name' => esc_html__( 'Frontend Categories', 'guides' ),
							'id'   => 'frontpage_listing_categories',
							'type' => 'text',
						),
					)
				),
			),
		);

		/**
		 * After this line we won't config nothing.
		 * Let's add these settings into WordPress's options db
		 */

		// First, Pixtypes
		$types_options = get_option( 'pixtypes_themes_settings' );
		if ( empty( $types_options ) ) {
			$types_options = array();
		}
		$types_options['guides_pixtypes_theme'] = $pixtypes_conf_settings;
		update_option( 'pixtypes_themes_settings', $types_options );
	}
endif; // end guides_config_getting_active
add_action( 'after_switch_theme', 'guides_prepare_theme_for_pixtypes' );


// pixtypes requires these things below for a pixelgrade theme
// for the moment we'll shim them until we update pixtypes
if ( ! class_exists( 'wpgrade' ) ) :
	class wpgrade {
		static function shortname() {
			return 'guides';
		}

		/** @var WP_Theme */
		protected static $theme_data = null;

		/**
		 * @return WP_Theme
		 */
		static function themedata() {
			if ( self::$theme_data === null ) {
				if ( is_child_theme() ) {
					$theme_name       = get_template();
					self::$theme_data = wp_get_theme( $theme_name );
				} else {
					self::$theme_data = wp_get_theme();
				}
			}

			return self::$theme_data;
		}

		/**
		 * @return string
		 */
		static function themeversion() {
			return wpgrade::themedata()->Version;
		}
	}

	function wpgrade_callback_geting_active() {
		guides_config_getting_active();
	}

endif;