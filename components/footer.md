---
permalink: /components/footer
layout: markdown
title: Footer Component Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for the **Pixelgrade Footer** component. We will tackle both behaviour and technical details.

## What Does It Do?

## What It Doesn't Do?

## How It Works?

## Important Technical Details

### Customizing the Customify Settings

The component provides its standard Customizer options by registering them through our wonderful [Customify](https://wordpress.org/plugins/customify/) WordPress plugin. 

Although well thought, you might find the need to add, delete, or 😱  completely replace options (although you would be quite the schmuck for doing this 💩). 

Luckily, the component allows you to **filter the footer options** just before they are merged with the main Customify options via the `pixelgrade_footer_customify_section_options` (see bellow).

Here is some example code to get you started in the right direction:

```php
/**
 * Modify the Customify Footer section options.
 *
 * @param array $options
 *
 * @return array
 */
function osteria_change_customify_footer_section_options( $options = array() ){
    // just add some option at the end
    $options['header_section']['options']['header_transparent_header'] = array(
        'type'    => 'checkbox',
        'label'   => esc_html__( 'Transparent Header while on Hero', 'components' ),
        'default' => 1,
    );

    // or you could add some option after another
    $header_transparent_option = array(
        'header_transparent' => array(
            'type'    => 'checkbox',
            'label'   => esc_html__( 'Transparent Header while on Hero', 'components' ),
            'default' => 1,
        )
    );
    $options['header_section']['options'] = pixelgrade_array_insert_after( $options['header_section']['options'], 'header_sides_spacing', $header_transparent_option );

    // delete some option
    if( array_key_exists( 'header_background', $options['header_section']['options'] ) ) {
        unset( $options['header_section']['options']['header_background'] );
    }

    // change some settings for a specific option
    // First we test to see if we have this option
    if( array_key_exists( 'header_background', $options['header_section']['options'] ) ) {
        $options['header_section']['options']['header_background']['default'] = '#555555';
    }

    // or just replace the whole array
    $options['header_section'] = array(
        'title'   => __( 'Header', 'components' ),
        'options' => array(
                //put your options here
        )
    );

    // Now return our modified options
    return $options;
}
add_filter( 'pixelgrade_footer_customify_section_options', 'osteria_change_customify_footer_section_options');
```

Please remember, code like the one above should go into `/inc/components.php` in your theme.