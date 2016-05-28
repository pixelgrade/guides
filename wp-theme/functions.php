<?php
/**
 * Functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Guides
 */

if ( ! function_exists( 'guides_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function guides_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Listable, use a find and replace
		 * to change 'guides' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'guides', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Used for Listing Cards
		// Max Width of 450px
		add_image_size( 'guides-card-image', 450, 9999, false );

		// Used for Single Listing carousel images
		// Max Height of 800px
		add_image_size( 'guides-carousel-image', 9999, 800, false );

		// Used for Full Width (fill) images on Pages and Listings
		// Max Width of 2700px
		add_image_size( 'guides-featured-image', 2700, 9999, false );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary'            => esc_html__( 'Primary Menu', 'guides' ),
			'footer_menu'        => esc_html__( 'Footer Menu', 'guides' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * No support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array() );

		add_theme_support( 'woocommerce' );

		add_post_type_support( 'page', 'excerpt' );

		remove_post_type_support( 'page', 'thumbnail' );
		/*
		 * Add editor custom style to make it look more like the frontend
		 * Also enqueue the custom Google Fonts and self-hosted ones
		 */
		add_editor_style( array( 'editor-style.css' ) );
	}
endif; // guides_setup
add_action( 'after_setup_theme', 'guides_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function guides_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'guides_content_width', 1050, 0 );
}

add_action( 'after_setup_theme', 'guides_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function guides_scripts() {
	$theme = wp_get_theme();

	//only enqueue the de default font if Customify is not present
	if ( ! class_exists( 'PixCustomifyPlugin' ) ) {
		wp_enqueue_style( 'guides-default-fonts', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700' );
		$main_style_deps[] = 'guides-default-fonts';
	}

	if ( ! is_rtl() ) {
		wp_enqueue_style( 'guides-style', get_template_directory_uri() . '/style.css', array(), $theme->get( 'Version' ) );
	}

	wp_enqueue_script( 'guides-scripts', get_template_directory_uri() . '/assets/js/main.js', array(), $theme->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'guides_scripts' );

function guides_admin_scripts() {

	wp_enqueue_script( 'guides-admin-general-scripts', get_template_directory_uri() . '/assets/js/admin/admin-general.js', array( 'jquery' ), '1.0.0', true );

	$translation_array = array (
		'import_failed' => esc_html__( 'The import didn\'t work completely!', 'guides') . '<br/>' . esc_html__( 'Check out the errors given. You might want to try reloading the page and try again.', 'guides'),
		'import_confirm' => esc_html__( 'Importing the demo data will overwrite your current site content and options. Proceed anyway?', 'guides'),
		'import_phew' => esc_html__( 'Phew...that was a hard one!', 'guides'),
		'import_success_note' => esc_html__( 'The demo data was imported without a glitch! Awesome! ', 'guides') . '<br/><br/>',
		'import_success_reload' => esc_html__( '<i>We have reloaded the page on the right, so you can see the brand new data!</i>', 'guides'),
		'import_success_warning' => '<p>' . esc_html__( 'Remember to update the passwords and roles of imported users.', 'guides') . '</p><br/>',
		'import_all_done' => esc_html__( "All done!", 'guides'),
		'import_working' => esc_html__( "Working...", 'guides'),
		'import_widgets_failed' => esc_html__( "The setting up of the demo widgets failed...", 'guides'),
		'import_widgets_error' => esc_html__( 'The setting up of the demo widgets failed', 'guides') . '</i><br />' . esc_html__( '(The script returned the following message', 'guides'),
		'import_widgets_done' => esc_html__( 'Finished setting up the demo widgets...', 'guides'),
		'import_theme_options_failed' => esc_html__( "The importing of the theme options has failed...", 'guides'),
		'import_theme_options_error' => esc_html__( 'The importing of the theme options has failed', 'guides') . '</i><br />' . esc_html__( '(The script returned the following message', 'guides'),
		'import_theme_options_done' => esc_html__( 'Finished importing the demo theme options...', 'guides'),
		'import_posts_failed' => esc_html__( "The importing of the theme options has failed...", 'guides'),
		'import_posts_step' => esc_html__( 'Importing posts | Step', 'guides'),
		'import_error' =>  esc_html__( "Error:", 'guides'),
		'import_try_reload' =>  esc_html__( "You can reload the page and try again.", 'guides'),
	);
	wp_localize_script( 'guides-admin-general-scripts', 'guides_admin_js_texts', $translation_array );
}

add_action( 'admin_enqueue_scripts', 'guides_admin_scripts' );



/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */

require get_template_directory() . '/inc/extras.php';

require get_template_directory() . '/inc/widgets.php';

require get_template_directory() . '/inc/activation.php';

/**
 * Load various plugin integrations
 */
require get_template_directory() . '/inc/integrations.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Recommended/Required plugins notification
 */
require get_template_directory() . '/inc/required-plugins/required-plugins.php';


