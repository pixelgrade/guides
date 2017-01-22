---
permalink: /components/footer
layout: markdown
title: Footer Component Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for the **Pixelgrade Footer** component. We will tackle both behaviour and technical details.

## What Does It Do?

This is quite a straight forward component. It will handle the **markup, Customizer options and widgets** of the `<footer>` section of the `<body>`.

The footer contains the widget area and the copyright text controlled through the Customizer.

## What It Doesn't Do?

It doesn't handle the final part of the `<body>` like the call to `wp_footer()` or the closing `</body>`. That is best left to the theme.


## How It Works?

It registers a widget area (sidebar) called 'Footer Area' and outputs the markup of those widgets.

Using the `pixelgrade_footer` action hook it outputs the markup found in the component's `templates/footer.php` file (this is hooked in `Pixelgrade_Footer->register_hooks()`).

So for this component to work, the theme must provide the following hook (usually found in the theme's `footer.php` file):

```php
<?php
/**
 * pixelgrade_before_footer hook.
 *
 * @hooked nothing() - 10 (outputs nothing)
 */
do_action( 'pixelgrade_before_footer', 'main' );
?>

<?php
/**
 * pixelgrade_footer hook.
 *
 * @hooked pixelgrade_the_footer() - 10 (outputs the footer markup)
 */
do_action( 'pixelgrade_footer', 'main' );
?>

<?php
/**
 * pixelgrade_after_footer hook.
 *
 * @hooked nothing() - 10 (outputs nothing)
 */
do_action( 'pixelgrade_after_footer', 'main' );
?>
```

We only need the middle hook (`pixelgrade_footer`), but we **strongly recommend** keeping all three as it allows for others to be able to reliably relate to the footer component and add things around it.

This component **doesn't have any static assets of its own** (like .css or .js), but it does have in its `/scss` folder **the necessary frontend logic for handling layout**. So you should include `/components/footer/scss/_main.scss` this in your theme's SCSS and add your styling.

The widgets in the footer are **laid out in columns.**

## Important Technical Details

All **customizations done by a theme to a component** should reside in the `/inc/components.php` file, regardless if there are dedicated files for certain integrations (Customify comes to mind). This ensures that one can identify quickly the way a theme interacts with components.

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
    $options['footer_section']['options']['footer_hide_back_to_top_link'] = array(
        'type'    => 'checkbox',
        'label'   => esc_html__( 'Hide "Back To Top" Link', 'components' ),
        'default' => 1,
    );

    // or you could add some option after another
    $footer_hide_back_to_top = array(
        'footer_hide_back_to_top_link' => array(
            'type'    => 'checkbox',
            'label'   => esc_html__( 'Hide "Back To Top" Link', 'components' ),
            'default' => 1,
        )
    );
    $options['footer_section']['options'] = pixelgrade_array_insert_after( $options['footer_section']['options'], 'footer_bottom_spacing', $footer_hide_back_to_top );

    // delete some option
    if( array_key_exists( 'footer_bottom_spacing', $options['footer_section']['options'] ) ) {
        unset( $options['footer_section']['options']['footer_bottom_spacing'] );
    }

    // change some settings for a specific option
    // First we test to see if we have this option
    if( array_key_exists( 'footer_bottom_spacing', $options['footer_section']['options'] ) ) {
        $options['footer_section']['options']['footer_bottom_spacing']['default'] = 10;
    }

    // or just replace the whole array
    $options['footer_section'] = array(
        'title'   => esc_html__( 'Footer', 'components' ),
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