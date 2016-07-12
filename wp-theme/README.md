### PixelGrade Theme basis

## Why this repo

{{small intro}}

## TODOS

* Complete this document( intro?? )
* Add more examples for integrations
* Complete `Rules and descriptions` 
* Maybe add links to functions or repo files??

## Roots

We follow the _s structure https://github.com/automattic/_s

## WordPress Coding Standards

Since we are working with WordPress we respect the environment, concepts and coding standards https://make.wordpress.org/core/handbook/best-practices/coding-standards/php

Aside from the rules above we also need to check: 
1. Every string must be output in an escaped way with functions like `esc_html__` or `esc_html_e`
⋅⋅* For these [gettext](http://php.net/gettext) functions always use the same string textdomain which is set [here](#todo) and use only strings(no variables or constants)
⋅⋅* Never add HTML code inside the functions above, if you need to compose an HTML block with strings inside use `sprintf`.
⋅⋅* Also note that strings added to `sprintf` are XSS safe, and they can be output simply with `__` or `_e` functions.
2. Standards imposed by the https://wordpress.org/plugins/theme-check/
3. Always localize JS strings or params

## Rules / descriptions

1. **Child Theme perspective**
 ..* Every theme should have a child theme repo-example following this structure:
 ..* For child themes to succeed we need to allow them control, so whenever we declare a function we check it with the `function_exists` function,
 ..* in case it does exists it means it was created by a child theme

2. **Plugins Integrations**
 ..* We use TGM
 ..* For various integrations with plugins we use the integrations.php file and folder. For example the [woocommerce.php](#) file
 ..* For Theme Options we use Customify –– https://github.com/pixelgrade/customify
 ..* For Custom Post Types and Custom Metadata we use PixTypes –– https://github.com/pixelgrade/pixtypes
 ..* For Shortcodes management we use PixCodes –– https://github.com/pixelgrade/pixcodes

3. **Licensed under GPLv3. The sky is the limit.**
