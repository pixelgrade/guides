---
permalink: /components/header
layout: markdown
title: Header Component Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for the **Pixelgrade Header** component. We will tackle both behaviour and technical details.

## What Does It Do?

The Header component takes care markup and logic of the top `<header>` section of the `<body>`. It handles everything about the top menus (we have 3 of them) and the branding of the site (logo or site title).

We will register 3 menus:
- a `primary-left` menu;
- a `primary-right` menu;
- and it registers support for **the Jetpack Social Menu**.

It also **adds support for the `custom-logo` core feature** introduced in WordPress 4.5, that will be used to allow our customers to upload their logo through the Customizer.

Lastly, but not the least, it **adds a Header Customizer options section** (via our Customify plugin) that provides a decent amount of layout and styling controls for the header elements. 

## What It Doesn't Do?

The Header component will not handle (nor should it) the `<head>` part the page. That is usually found in the theme's `header.php` root file. Do not confuse these two.
 
The Header component will not handle any header background images or sliders that might sight behind or bellow its menus and branding. Those will be handled by other components (Heroes anyone?).

## How It Works?

Using the `pixelgrade_header` action hook it outputs the markup found in the component's `templates/header.php` file (this is hooked in `Pixelgrade_Header->register_hooks()`).

So for this component to work, the theme must provide the following hooks (usually found in the theme's `header.php` file):

```php
<?php
/**
 * pixelgrade_before_header hook.
 *
 * @hooked nothing() - 10 (outputs nothing)
 */
do_action( 'pixelgrade_before_header', 'main' );
?>

<?php
/**
 * pixelgrade_header hook.
 *
 * @hooked pixelgrade_the_header() - 10 (outputs the header markup)
 */
do_action( 'pixelgrade_header', 'main' );
?>

<?php
/**
 * pixelgrade_after_header hook.
 *
 * @hooked nothing() - 10 (outputs nothing)
 */
do_action( 'pixelgrade_after_header', 'main' );
?>
```

We only need the middle hook (`pixelgrade_header`), but we **strongly recommend** keeping all three as it allows for others to be able to reliably relate to the header component and add things around it.

This component **doesn't have any static assets of its own** (like .css or .js), but it does have in its `/scss` folder **the necessary frontend logic for handling layout**. So you should include `/components/header/scss/_main.scss` this in your theme's SCSS and add your styling.

The image bellow explains **all the different behavioural cases** and how the Header component handles them (think of it in terms of something is missing and what happens) - click on it for a bigger version:

[![Header Logic]({{site.url}}/components/assets/header_component_logic.png)]({{site.url}}/components/assets/header_component_logic_big.png)


## Important Technical Details

All **customizations done by a theme to a component** should reside in the `/inc/components.php` file, regardless if there are dedicated files for certain integrations (Customify comes to mind). This ensures that one can identify quickly the way a theme interacts with components.

### Customizing the Customify Settings

The component provides its standard Customizer options by registering them through our wonderful [Customify](https://wordpress.org/plugins/customify/) WordPress plugin. 

Although well thought, you might find the need to add, delete, or 😱  completely replace options (although you would be quite the schmuck for doing this 💩). 

Luckly, the component allows you to **filter the header options** just before they are merged with the main Customify options via the `pixelgrade_header_customify_section_options` (see bellow).

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