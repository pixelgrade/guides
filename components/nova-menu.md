---
permalink: /components/nova-menu
layout: markdown
title: Nova Menu Component Guide
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for the **Pixelgrade Nova Menu** component. We will tackle both behaviour and technical details.

## What Does It Do?

It is a very straight forward component: it **activates support for Jetpack Food Menus** (the code name is Nova-Menu) and **provides a shortcode** for outputting those food menus in pages.

## What It Doesn't Do?

This is a functional component meaning it will provide theme sections like a hero or footer does.

It doesn't hold any template parts, WP admin or frontend CSS or JS. Just the functional code and SCSS to include in the theme's SCSS.

## How It Works?

The component **activates support for Food Menus** found in Jetpack (it's a hidden custom post type - it can't be controlled via Jetpack's settings). With this customers can easily manage their food menus. 

The menu items are organized in **sections** (like Breakfast or Lunch - you can think of them as categories) and each can have various **labels** (like spicy, hot, vegan - you can think of them as tags).

Each menu item has some **content, a price, featured image, and an optional excerpt** (if empty it will be automatically generated from the content via `the_excerpt()`).

Now to output those menus in pages, we need some shortcodes. The component adds the `[nova_menu]` shortcode as the main shortcode, but it also adds **two more shortcodes** that function exactly the same: `[jetpack_nova_menu]` for future compatibility and `[restaurant_menu]` for those that prefer this route. We will use `[nova_menu]` throughout this guide.

The **shortcode supports the following attributes**:

- `display_sections` (by default it's `false`) controls whether to **display the section title and description** before the menu items in that section;
- `display_labels` (by default it's `true`) controls whether to **display the labels** of each menu item;
- `display_content` (by default it's `true`) controls whether to **display the excerpt** (`true`), **the full menu item content** (`full`), or **no menu item description** (`false`);
- `link_items` (by default it's `false`) controls whether to **link each menu item to its single view**, for more details;
- `featured_label` (by default it's `featured`) controls which label(s) to use to **highlight** certain menu items - they will be given the `.highlighted` class; you can specify a single label or a comma separated list;
- `style` (by default it's `regular`) controls **the style** of the shortcode: `regular` or `dotted`;
- `include_section` (by default it's `false`) controls **what menu items to display based on section**; if empty or `false` we will display all menu items regardless of section; if given a comma separated list of section slugs (like `breakfast, petit-dejeuner, lunch`), only menu items from those sections will be displayed;
- `include_label` (by default it's `false`) controls **what menu items to display based on label**; if empty or `false` we will display all menu items regardless of label; if given a comma separated list of label slugs (like `vegan, hot-like-you, stop-drooling`), only menu items with those labels will be displayed;
- `showposts` (by default it's `-1`) controls **how many menu items to display**; if `-1` we will show all of them, otherwise the integer number specified;
- `order` (by default it's `asc`) controls **the order of the menu items**; `asc` or `ASC` for ascending order, `desc` or `DESC` for descending order;
- `orderby` (by default it's `date`) controls **the ordering parameter**; we only allow `date`, `title` and `rand` for random order;

Regarding the **highlighting of certain menu items**, there is one more detail to know, besides specifying the featured label or labels: if we will find **a portion of the menu item's title wrapped in parentheses** (`(Try this) Pork...`) or **square brackets** (`[Chef's choice] Bulion...`), we will **extract** that and use as the **highlight title.**

That's it. You can use multiple shortcodes on the same page, put them into columns using Gridable, put a shortcode with each menu section on separate pages and use our Multipage component, you are in charge.

## Important Technical Details

All **customizations done by a theme to a component** should reside in the `/inc/components.php` file, regardless if there are dedicated files for certain integrations (Customify comes to mind). This ensures that one can identify quickly the way a theme interacts with components.

You can control **the tags used in the shortcode markup** by filtering the default array given to the `pixelgrade_nova_menu_shortcode_menu_item_loop_markup` filter, something like this:

```php
$default_menu_item_loop_markup = array(
		'menu_tag'               => 'section',
		'menu_class'             => 'menu-list__section',
		'menu_header_tag'        => 'header',
		'menu_header_class'      => 'menu-group__header',
		'menu_title_tag'         => 'h4',
		'menu_title_class'       => 'menu-group__title underlined',
		'menu_description_tag'   => 'div',
		'menu_description_class' => 'menu-group__description',
	);
```

You can also change the **classes added to individual menu items** using the `pixelgrade_nova_menu-menu-item-post-class` filter.

One last filter is the `jetpack_nova_menu_thumbnail_size` that allows you to specify **a different thumbnail size** to use for the menu items featured image; by default we use `small`. Do note that the component doesn't register any thumbnail sizes via `add_image_size()`. That is up to the theme to do.