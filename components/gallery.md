---
permalink: /components/gallery
layout: markdown
title: Gallery Component Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for the **Pixelgrade Gallery** component. We will tackle both behaviour and technical details.

## What Does It Do?

This component is a functional one, meaning it only provides extra, backend functionality. This component will add extra attributes to the `[gallery]` shortcode:

- it will add the `masonry` gallery type to the types list;
- it will add the `slideshow` gallery type if Jetpack is not active;
- it will add the `spacing` attribute to the `[gallery]` shortcode, with the following options: **none, small, medium, large, and xlarge.**

All these options are added directly in the `Insert Media` popup available through the WordPress editor, in a very standard way. So nothing seems at odds for the end user.
 
Through the admin styling it provides, the component will rearrange the gallery controls to make more sense.

![Gallery Controls]({{site.url}}/components/assets/gallery_component_settings.png)

## What It Doesn't Do?

It will **not add JavaScript** to make the masonry work on the frontend, that is for the theme to do. It will also not add the JavaScript to make the slideshow work in case Jetpack is missing.

## How It Works?

One simply uses the `[gallery]` shortcode and its options as usual. The component will automatically add classes to the gallery `<div>` so you can target it in your styling.

For the spacing option, it will add a class like `u-gallery-spacing--small`, and for the masonry type it will add the class `u-gallery-type--masonry`.

In case Jetpack is not active, then we will also add the `u-gallery-type--slideshow` class to the gallery div.

## Important Technical Details

All **customizations done by a theme to a component** should reside in the `/inc/components.php` file, regardless if there are dedicated files for certain integrations (Customify comes to mind). This ensures that one can identify quickly the way a theme interacts with components.

### Customizing The Spacing Options

The Gallery component provides a filter to allow your theme to **change the options for the spacing select:** `pixelgrade_gallery_spacing_options`. Just return an array in the following form (the array bellow is the default one):

```php
array(
    'none'   => __( 'None', 'components' ),
    'small'  => __( 'Small', 'components' ),
    'medium' => __( 'Medium', 'components' ),
    'large'  => __( 'Large', 'components' ),
    'xlarge' => __( 'X-Large', 'components' ),
);
```

You can also **change the default gallery spacing** used (its `small` by default) through the `pixelgrade_default_gallery_spacing` filter.

Please remember, code like the one above should go into `/inc/components.php` in your theme.