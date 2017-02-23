---
permalink: /components/
layout: markdown
title: Theme Components Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
These are the general guidelines for **working with and developing** our theme components. 

First, before diving into the the technical aspects, let's clarify **the thinking behind them**.

## Why Have Components At All?

The need arose from the fact that, as we've started to increase our theme portfolio, the effort needed to maintain them naturally increased. This **wasn't going to be sustainable** in the long term.

A second, nagging, recurring issue is the fact that often we've fixed a bug in one theme only to fail to fix it in all the other similar themes. Improvements followed the same logic. This lead to **frustrations among us and among our customers**.

Thirdly, **certain patterns** began to firmly take shape. Some areas of similar themes began to have the same logic and behaviour (both due to widely used web patterns, but also to make it easy for customers to transition between our themes). We should be able to **reuse and improve these areas in one fell sweep**.

So, something needed to change. We needed to be able to have the flexibility of implementing whatever design was presented in front of us, but at the same time **share as much code as possible between as many themes**.

The obvious danger in such an undertaking is "bending" the design to certain predefined blocks, and, in no time, have our portfolio lose it's diversity and appeal. **We won't allow for that.**

## Is Everything a Component?

With our sights set on the problem at hand, we needed to analyze and decide **where we would draw the line** between what can go into a component and what should remain specific to a theme.

First of all, NO! We will not have our themes become a LEGO game of components. But **we will code our themes in an open manner** that allows for other entities (components in our case) to intervene and give a helping hand - filters and action hooks FTW.

So, **we will make components** out of the **theme parts** that have a high likelihood to be **shared across themes** (2 or more) and that **present sufficient complexity** to justify the trade-off in simplicity.

## What Is a Component?

After further analysis, another nagging question arose: **what should a component do?**

Should it just handle the markup generation and leave the styling all to the theme? Should it include WP-Admin logic where it would make sense? Should it hold it's own JavaScript behaviour? How about scss? How could the theme reliably style it and not introduce more anxiety on components update? Should they be Git submodules?

The questions were (and still are) pretty endless. That is OK as it will **keep the components system evolving and forward looking.**

To make components possible we needed to **standardize the way we approached markup and CSS classes**, keeping it consistent across themes. Also **[the theme boilerplate]({{page.boilerplate}})** (based on [_s]({{https://underscores.me/}})) should provide a set of **standardized action hooks** throughout the templates. More details about this later on.

For now, a **component should include all theme independent functionality, markup, layout and JavaScript logic of well defined theme area.**

There will be components that are entirely frontend facing, meaning they will handle the markup and its logic, entirely functional (backend focused), or hybrid ones. This is OK as long as they **function as a drop-in, with no adverse side effects**.

## Themes: Establishing a Good Working Relationship

Now that we have a good grasp about why and what should a component do, we need to define the relation between a certain theme and its components.

From  a theme's perspective, a component is something that helps but **it's not fundamental**. Life could go on without it - it wouldn't have as much fun, but it's life nonetheless. So **a theme shouldn't crash and burn when a component goes missing.**

**Action hooks are crucial** to making this relationship work. So throughout the theme's templates, a standardized set of `do_action`s should be present - skipping one of them should be done consciously. We will not detail them here as they are more then obvious in our [theme boilerplate]({{page.boilerplate}}):

```html+php
<?php get_header(); ?>

<?php
/**
 * pixelgrade_before_main_content hook.
 *
 * @hooked nothing() - 10 (outputs nothing)
 */
do_action( 'pixelgrade_before_main_content', $location );
?>

<div id="primary" class="content-area">
```

A second, crucial, behaviour to this symbiosis is **the location concept.** Think of it this way: it can be quite useful to know at any given moment during execution where we've been and where exactly we are. The location is like a set of set of stamps stuck to our face :) It's not the most elegant thing around, but it's obvious.

**Each theme template (including partials) should begin by defining the location details:**

```php
// Let the template parts know about our location
$location = pixelgrade_set_location( 'page full-width' );
```
This is a top level template (like `page.php`) that **sets** the first location. You can use strings (space or comma separated for multiple values) or arrays - we will standardize them to arrays either way.

Subsequent template parts (like `content.php`) should get the already set location, provide a fallback default if that is the case or add to it (put their own stamp):

```php
// We first need to know the bigger picture - the location this template part was loaded from
// Since we are in content-page.php, we provide the 'page' default fallback
$location = pixelgrade_get_location( 'page' );

// We could also add some extra stamps to the location
// Make sure we have some map in there
$location = pixelgrade_set_location( 'map', true );
```

Now **what do we do with this location**, and its stamps? We pass them to the template tags and action hooks! What did you think we would? This way a component or some logic in our theme could behave accordingly - **information is power.**

As you've feverishly focused on the code snippets above, you've surely noticed some template tags like `pixelgrade_get_location` or `pixelgrade_set_location`. These are **our component template tags.**

So, besides each individual component, we have a set of **helper template tags** that are used by all, including the theme. Due to this reason, **the `components/pixelgrade_template-tags.php` file should not be missing from any theme.** It would be a shame if we couldn't use those lovely standardized theme templates when we don't have any components, right?

Finally, where do components spend their time? Well... in **the `/components` directory**, silly!

**The main directory structure** would be like this:

```text
/theme_directory
	/assets
	...
	/components
		/component1
		/component2
		...
		/componentN
		pixelgrade_template-tags.php
		power-up.php
		typeline.php
	/inc
	...
	/template-parts
	index.php
	style.css
```

We have each component in its own directory and a series of .php files:

- **the `power-up.php` file is mandatory** for it loads each component and the extra files bellow; this is **the only file loaded by the theme in functions.php**;
- **the second mandatory file** is `pixelgrade_template-tags.php` as it contains various helper template tags;
- `typeline.php` holds the general functions of our Typeline typography system; so, if a theme relies on Typeline, the components directory should contain this file.

## The Structure Of a Component

With a firm understanding on the way components interact with a theme, we can focus on **understanding how a component is structured** and how to best take advantage of that.

A component is built upon **the same organizing and naming principles as a theme** is:

```text
/component-name
    /css
    /js
    /scss
    /templates
    class_component-name.php
    template-tags.php
/other-component
    ...
```

Lets set some guidelines about these files and directories.

### The Main Component Class

The `class_component-name.php` file is **the main file of a component**, and it's **the only one required** (due to the fact that it's the only one loaded by the `power-up.php` general file). It holds the main class of the component (usually called `Pixelgrade_Component_Name`).

The main component class deals primarily with:

- **hooking** everything the component requires;
- **registering and enqueueing** static assets (both in the WP Admin and the frontend);
- **providing configurations** (like the PixTypes or Customify ones);
- other small bits of extras (think of it in terms of the `extras.php` theme file).

If this class becomes too big (like way big) or too convoluted in its logic, then you can consider splitting it into various classes. In this case the `/inc` directory would make its appearance. But lets hope that we don't come to that - we might first need to consider if we've grown our component too big and we would be better off splitting the component instead.

The specific code details (like being a **singleton**) are available in the [boilerplate]({{page.boilerplate}}).

### The Template Tags

The `template-tags.php` file holds the template functions used by this component throughout its templates. These should provide **a decent level of filters** so the theme can interact with the component's behaviour.

Also, they should all be **prefixed with `pixelgrade_component_name_`** and **should not be wrapped** by `if ( function_exists( ... ))` as we don't want others to overwrite the component's functionality in bulk. **They should use filters.**

The [boilerplate]({{page.boilerplate}}) provides a set of **starter template tags** (think classes or main output).

### The Templates

The `/templates` directory contains the component's partials. 

These are loaded via the `pxg_load_component_file( $component_slug, $slug, $name = '', $require_once = true )` function which ensures that a theme or a child theme can override them. The override logic is as following:

- first it looks for, in this order:

```text
yourtheme/template-parts/component_slug/slug-name.php 
yourtheme/component_slug/slug-name.php
yourtheme/components/component_slug/slug-name.php
```

- then it looks for, in this order:

```text
yourtheme/template-parts/component_slug/slug.php
yourtheme/component_slug/slug.php
yourtheme/components/component_slug/slug.php
```

We use the `locate_template()` function which searches firstly in the child theme (if in use), then in the main theme. So we keep with the standard WordPress way of doing things.

**Please note** that the `pxg_load_component_file()` function has a `$require_once` parameter that is **true by default**; this is because we are using this function to also load the rest of the files in the component. For partials, **we should always set this parameter to `false`.**

### The SCSS

In the `/scss` directory we hold our .scss files:
 
- the ones we use to generate .css files in the `/css` directory (e.g. css assets that will be loaded by the component);
- also .scss files that will be included by the theme, in its own .scss files, and compiled as a whole; these are usually prefixed with underscore (i.e. `_hero.scss`).

The component doesn't handle the Gulp or Grunt processing of .scss files. That is up to the theme to do. Here is the needed gulp task:

```js
gulp.task('styles-components', 'Compiles Sass and uses autoprefixer', function() {

    function handleError(err, res) {
        log(c.red('Sass failed to compile'));
        log(c.red('> ') + err.file.split('/')[err.file.split('/').length - 1] + ' ' + c.underline('line ' + err.line) + ': ' + err.message);
    }

    return gulp.src('components/**/*.scss')
        .pipe(sass({outputStyle: 'nested'}).on('error', sass.logError))
        .pipe(prefix("last 3 versions", "> 1%"))
        .pipe(rename(function (path) {
            path.dirname = path.dirname.replace( '/scss', '' ); //Remove the scss directory at the end
            path.dirname += "/css"; //Append the css subdirectory to the path; see http://stackoverflow.com/questions/31358552/gulp-write-output-files-to-subfolder-relative-of-src-path
        }))
        .pipe(gulp.dest('./components'));
});
```

## Code Styling

Obviously, we follow all the standard WordPress code styling:

- [PHP Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/)
- [CSS Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/css/)
- [HTML Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/html/)
- [JavaScript Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/)

In addition there are some further details that we should know so we can keep on **creating happy components.**

### File Headers

Each .php file should start with a header like the following:

```php
<?php
/**
 * The main template for header
 *
 * This template can be overridden by copying it to a child theme in /components/header/templates/header.php
 *
 * HOWEVER, on occasion Pixelgrade will need to update template files and you
 * will need to copy the new files to your child theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://pixelgrade.com
 * @author     Pixelgrade
 * @package    Components/Header
 * @version    1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
```

This provides information about what the file represents (the first line), how to override it and a disclaimer about how to treat this file in future updates.

The rest of the lines are standard and they provide the link to us, our name, the package name and the current version of this file. 

**You should always increase this version when making changes to a file.** This will make it easier for everybody to keep all of our themes up-to-date.

### Components Versioning

Speaking of versions, lets set some **clear rules for how we handle versions**:
 
- We use [semantic versioning](http://semver.org/) the simple way, meaning without all the alpha, or release additions; just **MAJOR.MINOR.PATCH**;
- Each component has **it's own version** that resides in its **main file** and we put the version both in the class variable and in the file header (because the file has changed);
- The component's version increases whenever there is a change or addition in one of it's files;
- **Each component file** (including the main file) has a version in its header; we will increase this version whenever we make a change or addition;
- Each new component file version starts at version 1.0.0;

Following these rules, it is not uncommon to have lets say a component at version 1.2.3 and one of its files (not the main file because that will be also at 1.2.3) at version 1.0.0, 1.2.0, but **no more than 1.2.3.**
