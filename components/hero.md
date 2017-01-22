---
permalink: /components/hero
layout: markdown
title: Hero Component Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for the **Pixelgrade Hero** component. We will tackle both behaviour and technical details.

## What Does It Do?

The Hero component is a real beauty. It will both the backend and frontend logic of a theme's heroes. 

It will provide **the editor metaboxes** to allow you to control the hero content, its alignment, height and son on.

At the same time will output **a standardized hero markup** via the component's templates, slideshow and maps support included.

## What It Doesn't Do?

Basically it does pretty much everything there is about heroes, except for the scroll down arrow or other complicated setups that you might envision for the hero (like hero widget areas or such). Those are best handled via the component's action hooks and filters.

## How It Works?

Using the `pixelgrade_before_entry_title` action hook it outputs the markup of the hero(this is hooked in `Pixelgrade_Header->register_hooks()`). The component has two template files: a `hero.php` for regular heroes, and a `hero-map.php` for heroes with Google Maps. It will automatically load the appropiate one depending on the page template being used.

So for this component to work, the theme must provide the following hook (usually found in a theme partial like `content-page.php`):

```php
<?php
/**
 * pixelgrade_before_entry_title hook.
 *
 * @hooked pixelgrade_the_hero() - 10 (outputs the hero markup)
 */
do_action( 'pixelgrade_before_entry_title', $location );
?>
```

One more important thing about the location of this hook: the component's markup is devised to be inserted in an `<article>` inside the `<header>`. This way we keep things semanthic and consistent with other behaviours like multipages.

The Hero component provides its own **.scss layout logic** that should be included in your theme's scss, located at `/components/hero/scss/_main.scss`.

Throughout the component's templates and template tags functions you will find numerous action hooks and filters that will allow you to either insert markup or change its behaviour. You should inspect the code for more details.

Also please note that the component provides plenty of template tags should you decide to create your own hero templates. Just check out `/components/hero/template-tags.php`.

## Important Technical Details

All **customizations done by a theme to a component** should reside in the `/inc/components.php` file, regardless if there are dedicated files for certain integrations (Customify comes to mind). This ensures that one can identify quickly the way a theme interacts with components.

### Customizing the PixTypes Settings

The component provides its custom metaboxes through our lovely [PixTypes](https://wordpress.org/plugins/pixtypes/) WordPress plugin.

Although well thought, you might find the need to add, delete, or 😱  completely replace options (although you would be quite the schmuck for doing this 💩). 

Luckily, the component allows you to **filter the hero metaboxes options** just before they are merged with the main PixTypes options via the `pixelgrade_hero_metaboxes_config` filter (see bellow).

Here is some example code to get you started in the right direction:

```php
/**
 * Modify the PixTypes Hero options.
 *
 * @param array $options
 *
 * @return array
 */
function osteria_change_hero_metaboxes( $options = array() ){
    // just add some new field at the end of a metabox, `hero_area_background__page` in our case
    $options['hero_area_background__page']['fields'][] = array(
        'name' => esc_html__( 'Thumbnail Transparent Image', 'components' ),
        'id'   => '_thumbnail_transparent_image',
        'type' => 'image',
        'button_text' => esc_html__( 'Add Transparent Thumbnail', 'components' ),
        'class' => 'thumbnail-transparent',
    );

    // or you could add some field after another by specifying the position - counting from 0
    $thumbnail_transparent_field = array(
	    'name' => esc_html__( 'Thumbnail Transparent Image', 'components' ),
	    'id'   => '_thumbnail_transparent_image',
	    'type' => 'image',
	    'button_text' => esc_html__( 'Add Transparent Thumbnail', 'components' ),
	    'class' => 'thumbnail-transparent',
    );
    // Insert in after position 0
    $after_position = 0;
    $options['hero_area_background__page']['fields'] = array_splice( $options['hero_area_background__page']['fields'], $after_position, 0, $thumbnail_transparent_field );

    // delete some option of the metabox
    if( array_key_exists( 'show_names', $options['enhanced_featured_image'] ) ) {
	    unset( $options['enhanced_featured_image']['show_names'] );
    }

    // change some settings for a specific option of the metabox
    // First we test to see if we have this option
    if( array_key_exists( 'show_names', $options['enhanced_featured_image'] ) ) {
	    $options['enhanced_featured_image']['show_names'] = true;
    }

    // Change some settings of a certain field of a metabox, searching it by id
    $searched_id = '_hero_background_gallery';
    foreach ( $options['hero_area_background__page']['fields'] as $key => $field ) {
	    if ( ! empty( $field['id'] ) && $searched_id == $field['id'] ) {
		    // change some field settings here
		    $options['hero_area_background__page']['fields'][ $key ]['name'] = esc_html__( 'Some funky name', 'components' );

		    // stop our search
		    break;
	    }
    }

    // or just replace the whole settings of a certain metabox
    $options['hero_area_background__page'] = array(
	    'id'     => 'hero_area_background__page',
	    'title'  => esc_html__( 'Hero Area » Background', 'components' ),
	    'fields' => array(
		    //put your fields here
	    )
    );
    
    // Add a new metabox after another one identified by its array key
    // If it doesn't exist it will add the new metabox array at the end
    $hero_area_map_page = array(
        'hero_area_map__page' => array(
            'id'         => 'hero_area_map__page',
            'title'      => esc_html__( 'Map Coordinates & Display Options', 'components' ),
            'pages'      => array( 'page' ), // Post type
            // And so on...
        )
    );
    $options = pixelgrade_array_insert_after( $options, 'hero_area_content__page', $hero_area_map_page );

    // Now return our modified options
    return $options;
}
add_filter( 'pixelgrade_hero_metaboxes_config', 'osteria_change_hero_metaboxes');
```

Please remember, code like the one above should go into `/inc/components.php` in your theme.