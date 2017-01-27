---
permalink: /components/multipage
layout: markdown
title: Multipage Component Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for the **Pixelgrade Multipage** component. We will tackle both behaviour and technical details.

## What Does It Do?

## What It Doesn't Do?

## How It Works?

## Important Technical Details

All **customizations done by a theme to a component** should reside in the `/inc/components.php` file, regardless if there are dedicated files for certain integrations (Customify comes to mind). This ensures that one can identify quickly the way a theme interacts with components.

### Customizing the Customify Settings

The component provides its standard Customizer options by registering them through our wonderful [Customify](https://wordpress.org/plugins/customify/) WordPress plugin. 

Although well thought, you might find the need to add, delete, or 😱  completely replace options (although you would be quite the schmuck for doing this 💩). 

Luckily, the component allows you to **filter the header options** just before they are merged with the main Customify options via the `pixelgrade_header_customify_section_options` filter (see bellow).

Also you can **filter the recommended fonts** for all typography controls in one fel swoop via the `pixelgrade_header_customify_recommended_headings_fonts` filter (see bellow).

Here is some example code to get you started in the right direction:

```php
// To change the recommended fonts you can use the following

/**
 * Modify the Customify recommended fonts for the Header font controls.
 *
 * @param array $fonts
 *
 * @return array
 */
function osteria_change_customify_header_recommended_fonts( $fonts = array() ){
    // just add some font to the existing list
    $fonts[] = 'Some Font Family';

    // delete a certain font family
    if( ( $key = array_search( 'NiceFont', $fonts ) ) !== false) {
        unset( $fonts[ $key ] );
    }

    // or just replace the whole array
    $fonts = array(
        'Playfair Display',
        'Oswald',
        'Lato',
    );

    // Now return our modified fonts list
    return $fonts;
}
add_filter( 'pixelgrade_header_customify_recommended_headings_fonts', 'osteria_change_customify_header_recommended_fonts');

// To change some options

/**
 * Modify the Customify Header section options.
 *
 * @param array $options
 *
 * @return array
 */
function osteria_change_customify_header_section_options( $options = array() ){
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
add_filter( 'pixelgrade_header_customify_section_options', 'osteria_change_customify_header_section_options');
```

Please remember, code like the one above should go into `/inc/components.php` in your theme.