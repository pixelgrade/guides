---
permalink: /components/featured-image
layout: markdown
title: Featured Image Component Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for the **Pixelgrade Featured Image** component. We will tackle both behaviour and technical details.

## What Does It Do?

This component **replaces the standard featured image** options with custom controls that allows us to have **two images defined**, one regular and one for the hover state. 

![Featured Image Controls]({{site.url}}/components/assets/featured_image_component.png)

The regular image will behave **exactly like the core featured image** (it uses the same meta key `_thumbnail_id`), so all standard template tags will still work (like `the_post_thumbnail()`).

By default, we only do this for the `jetpack-portfolio` custom post type, not for all post types.

## What It Doesn't Do?

It doesn't handle **any frontend markup or logic** regarding the featured image. That is up to the theme to handle.

## How It Works?

It's quite plug-and-play in its behaviour. You can use the two images in your theme with code similar to this:

```php
<?php
// Output the featured image
the_post_thumbnail();

// Also output the markup for the hover image if we have it
// Make sure that we have the Featured Image component loaded
if ( function_exists( 'pixelgrade_featured_image_get_hover_id' ) ) {
    $hover_image_id = pixelgrade_featured_image_get_hover_id();
    if ( ! empty( $hover_image_id ) ) { ?>

                            <div class="c-card__frame-hover">
          <?php echo wp_get_attachment_image( $hover_image_id, 'full' ); ?>
                            </div>

    <?php }
} ?>
```

## Important Technical Details

All **customizations done by a theme to a component** should reside in the `/inc/components.php` file, regardless if there are dedicated files for certain integrations (Customify comes to mind). This ensures that one can identify quickly the way a theme interacts with components.

### Customizing Post Types

As stated above, by default we replace the core featured image functionality for the `jetpack-portfolio` custom post type. You can use the `pixelgrade_featured_image_post_types` filter to change this.

### Customizing the PixTypes Settings

The component provides its custom metaboxes through our lovely [PixTypes](https://wordpress.org/plugins/pixtypes/) WordPress plugin.

Although well thought, you might find the need to add, delete, or 😱  completely replace options (although you would be quite the schmuck for doing this 💩). 

Luckily, the component allows you to **filter the featured image metaboxes options** just before they are merged with the main PixTypes options via the `pixelgrade_featured_image_metaboxes_config` filter (see bellow).

Here is some example code to get you started in the right direction:

```php
/**
 * Modify the PixTypes Featured Image options.
 *
 * @param array $options
 *
 * @return array
 */
function osteria_change_featured_image_metaboxes( $options = array() ){
    // just add some new field at the end
    $options['enhanced_featured_image']['fields'][] = array(
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
    $options['enhanced_featured_image']['fields'] = array_splice( $options['enhanced_featured_image']['fields'], $after_position, 0, $thumbnail_transparent_field );

    // delete some option of the metabox
    if( array_key_exists( 'show_names', $options['enhanced_featured_image'] ) ) {
	    unset( $options['enhanced_featured_image']['show_names'] );
    }

    // change some settings for a specific option of the metabox
    // First we test to see if we have this option
    if( array_key_exists( 'show_names', $options['enhanced_featured_image'] ) ) {
	    $options['enhanced_featured_image']['show_names'] = true;
    }

    // Change some settings of a certain field, searching it by id
    $searched_id = '_thumbnail_hover_image';
    foreach ( $options['enhanced_featured_image']['fields'] as $key => $field ) {
	    if ( ! empty( $field['id'] ) && $searched_id == $field['id'] ) {
		    // change some field settings here
		    $options['enhanced_featured_image']['fields'][ $key ]['class'] = 'thumbnail-hover-more';

		    // stop our search
		    break;
	    }
    }

    // or just replace the whole array
    $options['enhanced_featured_image'] = array(
	    'id'     => 'enhanced_featured_image',
	    'title'  => __( 'Featured Image', 'components' ),
	    'fields' => array(
		    //put your fields here
	    )
    );

    // Now return our modified options
    return $options;
}
add_filter( 'pixelgrade_featured_image_metaboxes_config', 'osteria_change_featured_image_metaboxes');
```

Please remember, code like the one above should go into `/inc/components.php` in your theme.