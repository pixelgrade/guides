<?php
/**
 * Guides required or recommended plugins
 *
 * @package Guides
 * @since Guides 1.0
 */

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'guides_register_required_plugins', 999 );

function guides_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	//	$plugins = array(
	//		array(
	//			'name'     				=> 'PLUGIN NAME', // The plugin name
	//			'slug'     				=> 'PLUGINSLUG', // The plugin slug (typically the folder name)
	//			'source'   				=> 'PLUGIN_LOCATION', // The plugin source
	//			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
	//			'version' 				=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented. If the plugin version is higher than the plugin version installed , the user will be notified to update the plugin
	//			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
	//			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	//			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
	//		)
	//	);
	//
	$plugins = array(
		array(
			'name'               => 'PixTypes',
			'slug'               => 'pixtypes',
			'required'           => true
		),
		array(
			'name'               => 'Customify',
			'slug'               => 'customify',
			'required'           => true
		),
		array(
			'name'               => 'Category Icon',
			'slug'               => 'category-icon',
			'required'  		 => false
		),
		array(
			'name'               => 'Comments Ratings',
			'slug'               => 'comments-ratings',
			'required'           => false
		),
		 array(
		 	'name'      		 => 'WooCommerce',
		 	'slug'      		 => 'woocommerce',
		 	'required'  		 => false
		 ),
		array(
			'name'      		 => 'Nav Menu Roles',
			'slug'      		 => 'nav-menu-roles',
			'required'  		 => false
		),
		 array(
		 	'name'               => 'PixCodes',
		 	'slug'               => 'pixcodes',
		 	'required'           => false,
		 ),
	);

	$config = array(
		'domain'           => 'guides', // Text domain - likely want to be the same as your theme.
		'default_path'     => '', // Default absolute path to pre-packaged plugins
		'menu'             => 'install-required-plugins', // Menu slug
		'has_notices'      => true, // Show admin notices or not
		'is_automatic'     => false, // Automatically activate plugins after installation or not
		'message'          => '', // Message to output right before the plugins table
		'strings'          => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'guides' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'guides' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'guides' ),
			// %1$s = plugin name
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'guides' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'guides' ),
			// %1$s = plugin name(s)
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'guides' ),
			// %1$s = plugin name(s)
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'guides' ),
			// %1$s = plugin name(s)
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'guides' ),
			// %1$s = plugin name(s)
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'guides' ),
			// %1$s = plugin name(s)
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'guides' ),
			// %1$s = plugin name(s)
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'guides' ),
			// %1$s = plugin name(s)
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'guides' ),
			// %1$s = plugin name(s)
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'guides' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'guides' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'guides' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'guides' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'guides' )
			// %1$s = dashboard link
		)
	);

	tgmpa( $plugins, $config );

} ?>