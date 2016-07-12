<?php
/**
 * Guides Options Config
 *
 * @package Guides
 * @since Guides 1.0
 */

/**
 * Hook into the Customify's fields and settings
 *
 * @param $options array - Contains the plugin's options array right before they are used, so edit with care
 *
 * @return mixed
 *
 *
 *
 * @TODO review this config
 *
 *
 */
if ( ! function_exists( 'guides_add_customify_options' ) ) {
	function guides_add_customify_options( $options ) {

		$options['opt-name'] = 'guides_options';

		// keep this empty now
		$options['sections'] = array();

		$options['panels']['theme_options'] = array(
			'title'    => '&#x1f506; ' . esc_html__( 'Theme Options', 'guides' ),
			'sections' => array(
				'general'     => array(
					'title'   => esc_html__( 'General', 'guides' ),
					'options' => array(
						'footer_copyright' => array(
							'type'              => 'textarea',
							'label'             => esc_html__( 'Footer Copyright Text', 'guides' ),
							//'desc' => esc_html__( 'The copyright text which should appear in footer.', 'guides' ),
							'default'           => esc_html__( 'Copyright &copy; 2015 Company Inc.   &bull;   Address  &bull;   Tel: 42-898-4363', 'guides' ),
							'sanitize_callback' => 'wp_kses_post',
							'live'              => array( '.site-info .site-text-area' )
						),
					)
				),
				'map_options' => array(
					'title'   => esc_html__( 'Map Options', 'guides' ),
					'options' => array(
						'mapbox_token' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Mapbox Integration (optional)', 'guides' ),
							'default' => '',
							// 'desc'      => __( 'Guides uses the Mapbox API for different reasons. <a href="https://www.mapbox.com/help/create-api-access-token/">Get an API token</a> for best performances.', 'guides' ),
							'desc'    => sprintf(
								'<p>%s <a href="https://www.mapbox.com/" target="_blank">%s</a> %s.</p><p><a href="https://www.mapbox.com/help/create-api-access-token/" target="_blank">%s</a> %s.</p>',
								esc_html__( 'We are offering integration with the', 'guides' ),
								esc_html__( 'Mapbox', 'guides' ),
								esc_html__( 'service, so you can have better looking and highly performance maps', 'guides' ),
								esc_html__( 'Get a FREE token', 'guides' ),
								esc_html__( 'and paste it below. If there is nothing added, we will fallback to the Google Maps service', 'guides' )
							)
						),
						'mapbox_style' => array(
							'type'    => 'radio_image',
							'label'   => esc_html__( 'Mapbox Style', 'guides' ),
							'default' => 'mapbox.streets-basic',
							'choices' => array(
								'mapbox.streets-basic' => get_template_directory_uri() . '/assets/img/streets-basic.png',
								'mapbox.streets'       => get_template_directory_uri() . '/assets/img/streets.png',
								'mapbox.outdoors'      => get_template_directory_uri() . '/assets/img/outdoors.png',
								'mapbox.light'         => get_template_directory_uri() . '/assets/img/light.png',
								'mapbox.emerald'       => get_template_directory_uri() . '/assets/img/emerald.png',
								'mapbox.satellite'     => get_template_directory_uri() . '/assets/img/satellite.png',
								'mapbox.pencil'        => get_template_directory_uri() . '/assets/img/pencil.png',
								'mapbox.pirates'       => get_template_directory_uri() . '/assets/img/pirates.png'
							),
							'desc'    => esc_html__( 'Custom styles works only if you have set a valid Mapbox API token in the field above.', 'guides' ),
						),
						'google_maps_api_key' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Google Maps API key', 'guides' ),
							'default' => '',
							'desc'    => sprintf(
								'<p>%s </p> <a href="//developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key" target="_blank">%s</a>',
								esc_html__( 'To use the Google Maps library you must authenticate your application with an API key.', 'guides' ),
								esc_html__( 'Get a Key', 'guides' )
							)
						)

					)
				),
				'custom_js'   => array(
					'title'   => esc_html__( 'Custom JavaScript', 'guides' ),
					'options' => array(
						'custom_js'        => array(
							'type'        => 'ace_editor',
							'label'       => esc_html__( 'Header', 'guides' ),
							'desc'        => esc_html__( 'Easily add Custom Javascript code. This code will be loaded in the <head> section.', 'guides' ),
							'editor_type' => 'javascript',
						),
						'custom_js_footer' => array(
							'type'        => 'ace_editor',
							'label'       => esc_html__( 'Footer', 'guides' ),
							'desc'        => esc_html__( 'You can paste here your Google Analytics tracking code (or for what matters any tracking code) and we will put it on every page.', 'guides' ),
							'editor_type' => 'javascript',
						),
					)
				),

				'import_demo_data' => array(
					'title'    => __( 'Demo Data', 'guides' ),
					'description' => esc_html__( 'If you would like to have a "ready to go" website as the Guides\'s demo page here is the button', 'guides' ),
					'priority' => 999999,
					'options'  => array(
						'import_demodata_button' => array(
							'title' => 'Import',
							'type'  => 'html',
							'html'  => '<input type="hidden" name="wpGrade-nonce-import-posts-pages" value="' . wp_create_nonce( 'wpGrade_nonce_import_demo_posts_pages' ) . '" />
										<input type="hidden" name="wpGrade-nonce-import-theme-options" value="' . wp_create_nonce( 'wpGrade_nonce_import_demo_theme_options' ) . '" />
										<input type="hidden" name="wpGrade-nonce-import-widgets" value="' . wp_create_nonce( 'wpGrade_nonce_import_demo_widgets' ) . '" />
										<input type="hidden" name="wpGrade_import_ajax_url" value="' . admin_url( "admin-ajax.php" ) . '" />' .
							           '<span class="description customize-control-description">' . esc_html__( '(Note: We cannot serve you the original images due the ', 'guides' ) . '<strong>&copy;</strong>)</span></br>' .
							           '<a href="#" class="button button-primary" id="wpGrade_import_demodata_button" style="width: 70%; text-align: center; padding: 10px; display: inline-block; height: auto;  margin: 0 15% 10% 15%;">
											' . esc_html__( 'Import demo data', 'guides' ) . '
										</a>

										<div class="wpGrade-loading-wrap hidden">
											<span class="wpGrade-loading wpGrade-import-loading"></span>
											<div class="wpGrade-import-wait">' .
							           esc_html__( 'Please wait a few minutes (between 1 and 3 minutes usually, but depending on your hosting it can take longer) and ', 'guides' ) .
							           '<strong>' . esc_html__( 'don\'t reload the page', 'guides' ) . '</strong>.' .
							           esc_html__( 'You will be notified as soon as the import has finished!', 'guides' ) . '
											</div>
										</div>

										<div class="wpGrade-import-results hidden"></div>
										<div class="hr"><div class="inner"><span>&nbsp;</span></div></div>'
						)
					)
				)
			)
		);

		/**
		 * Register a second logo option which will be moved in the title_tagline section
		 */
		$options['sections']['to_be_removed'] = array(
			'options' => array(
				'logo_invert'           => array(
					'type'  => 'media',
					'label' => esc_html__( 'Logo while on Transparent Hero Area', 'guides' ),
					'desc' => esc_html__( 'Replace the default logo on the Front Page Hero.', 'guides' ),
					'show_on' => array( 'header_transparent' ),
				),
			)
		);
		// $options['panels'] = array();
		return $options;
	}
}
add_filter( 'customify_filter_fields', 'guides_add_customify_options' );
