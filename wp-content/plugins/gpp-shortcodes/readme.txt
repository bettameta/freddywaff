=== GPP Shortcodes ===
Contributors: endortrails, kcssm
Donate link: http://graphpaperpress.com/
Tags: shortcode, shortcodes, icons, buttons, grid, google maps, tables, graphpaperpress
Requires at least: 3.6
Tested up to: 3.6.1
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

GPP Shortcodes enables you to easily add "flat design" buttons, icons, pricing tables and more without modifying CSS, HTML or PHP. 

== Description ==

Building complex page layouts with buttons, icons and pricing tables typically requires lots of experience with html, css, php and the WordPress template hierarchy. Use this plugin to whip up fancy looking page designs in no time flat.

There are 11 shortcodes packaged into this plugin:

*   Flat Buttons
*   Icons courtesy of Genericons
*   Icon Buttons
*   Highlights
*   Dividers
*   Accordions
*   Toggles
*   Tabs
*   Google Maps
*   Pricing Tables
*   Grids

See live examples, a full list of the options and usage instructions here:

http://graphpaperpress.com/plugins/gpp-shortcodes/

== Installation ==

1. Upload the whole `gpp-shortcodes` directory to the `/wp-content/plugins/` directory
1. Activate the 'GPP Shortcodes' plugin through the 'Plugins' menu in WordPress
1. Add shortcodes to Posts and Pages using the instructions found on this page:

http://graphpaperpress.com/plugins/gpp-shortcodes/

== Screenshots ==

1. Flat buttons with size, color, icon, link and alignment options
3. Flat boxes with color and alignment options
4. Flat HDMI Icons courtesy of Genericons
5. Tabs, Toggles, Accordions
6. Google Maps
7. Pricing Tables

== Frequently Asked Questions ==

Below are a list of all the shortcodes and how to use them.

= BOXES =

Usage: `[gpp_box]Alert Box Text[/gpp_box]`

Attributes: color, width, text_align, margin_bottom, margin_top, class

Available colors: grey, yellow, green, red, blue, purple, black

Attributes usage: `[gpp_box color="green" width="50%" text_align="left" margin_bottom="50px" margin_top="50px"]Alert Box Text[/gpp_box]`

= ICONS =

Usage: `[gpp_icon type="image"]`

Attributes: type

Availabe types: standard, aside, image, gallery, video, status, quote, link, chat, audio, github, dribble, twitter, facebook, facebook-alt, wordpress, googleplus, linkedin, linkedin-alt, pinterest, pinterest-alt, flickr, vimeo, youtube, tumblr, instagram, codepen, polldaddy, comment, category, tag, time, user, day, week, month, pinned, search, unzoom, zoom, show, hide, close, close-alt, trash, star, home, mail, edit, reply, feed, warning, share, attachment, location, checkmark, menu, top, minimize, maximize, 404, spam, summary, cloud, key, dot, next, previous, expand, collapse, dropdown, dropdown-left, top, draggable, phone, send-to-phone, plugin, cloud-download, cloud-upload, external, document, book, cog, unapprove, cart, pause, stop, skip-back, skip-ahead, play, tablet, send-to-tablet, info, notice, help, fastforward, rewind, portfolio, uparrow, rightarrow, downarrow, leftarrow

= BUTTONS =

Usage: `[gpp_button]Button Text[/gpp_button]`

Attributes: color, url, title, target, rel, class, icon_left, icon_right, size, display

Available colors: grey, yellow, green, red, blue, purple, black

Available sizes: small, medium, large

Available displays: inline, block

Available icon_left and icon_right: standard, aside, image, gallery, video, status, quote, link, chat, audio, github, dribble, twitter, facebook, facebook-alt, wordpress, googleplus, linkedin, linkedin-alt, pinterest, pinterest-alt, flickr, vimeo, youtube, tumblr, instagram, codepen, polldaddy, comment, category, tag, time, user, day, week, month, pinned, search, unzoom, zoom, show, hide, close, close-alt, trash, star, home, mail, edit, reply, feed, warning, share, attachment, location, checkmark, menu, top, minimize, maximize, 404, spam, summary, cloud, key, dot, next, previous, expand, collapse, dropdown, dropdown-left, top, draggable, phone, send-to-phone, plugin, cloud-download, cloud-upload, external, document, book, cog, unapprove, cart, pause, stop, skip-back, skip-ahead, play, tablet, send-to-tablet, info, notice, help, fastforward, rewind, portfolio, uparrow, rightarrow, downarrow, leftarrow

Attributes usage: `[gpp_button color="blue" url="http://graphpaperpress.com" title="themes" icon_left="twitter" target="_blank" size="large" display="block"]Button Text[/gpp_button]`

= TEXT HIGHLIGHT =

Usage: `[gpp_highlight]text to highlight[/gpp_highlight]`

Attributes: color

Available colors: grey, yellow, green, red, blue, purple, black

Attributes usage: [gpp_highlight color="green"]text to highlight[/gpp_highlight]

= DIVIDERS =

Usage: `[gpp_divider]`

Attributes: type, color

Available types: solid, dashed, dotted, double

Available colors: grey, yellow, green, red, blue, purple, black

Attributes Usage: `[gpp_divider type="dashed" color="green"]`

= ACCORDIONS =

Usage: `[gpp_accordion][gpp_accordion_section title="Section #1"]Section 1 text[/gpp_accordion_section][gpp_accordion_section title="Section #2"]Section 2 text[/gpp_accordion_section][gpp_accordion_section title="Section #3"]Section 3 text[/gpp_accordion_section][/gpp_accordion]`

Attributes: title, class

Attributes usage: `[gpp_accordion][gpp_accordion_section title="Section #1"]Section 1 text[/gpp_accordion_section][gpp_accordion_section title="Section #2"]Section 2 text[/gpp_accordion_section][gpp_accordion_section title="Section #3"]Section 3 text[/gpp_accordion_section][/gpp_accordion]`

= TOGGLES =

Usage: `[gpp_toggle title="Toggle Title"]Toggle text[/gpp_toggle]`

Attributes: title, class

= TABS =

Usage: `[gpp_tabgroup][gpp_tab title="Tab #1"]Tab 1 text [/gpp_tab][gpp_tab title="Tab #2"]Tab 2 text[/gpp_tab][/gpp_tabgroup]`

Attributes: title, class

= GOOGLE MAPS =

Usage: `[gpp_googlemap location="new york,usa"]`

Attributes: location, height, title, zoom, class

Attributes Usage: `[gpp_googlemap location="new york,usa" zoom="5" title="New York" height="500px"]`

= PRICING TABLE =

Usage:
`[gpp_pricing plan="Premium" cost="$200" per="per month" button_url="http://graphpaperpress.com" button_text="Sign Up" button_color="green" button_target="self" button_rel="nofollow"]
plan feature
plan feature
plan feature
plan feature
[/gpp_pricing]`

Attributes: plan, cost, per, button_url, button_text, button_color, button_target, button_rel, position, class

Here is an example pricing table with three columns:

`[one_third_first][gpp_pricing plan="Gold" cost="$99" per="per month" button_url="http://graphpaperpress.com" button_text="Sign Up" button_color="green" button_target="self" button_rel="nofollow"]
plan feature
plan feature
plan feature
plan feature
[/gpp_pricing][/one_third_first][one_third][gpp_pricing plan="Silver" cost="$69" per="per month" button_url="http://graphpaperpress.com" button_text="Sign Up" button_color="green" button_target="self" button_rel="nofollow"]
plan feature
plan feature
plan feature
plan feature
[/gpp_pricing][/one_third][one_third_last][gpp_pricing plan="Bronze" cost="$39" per="per month" button_url="http://graphpaperpress.com" button_text="Sign Up" button_color="green" button_target="self" button_rel="nofollow"]
plan feature
plan feature
plan feature
plan feature
[/gpp_pricing][/one_third_last]`

= GRIDS =
You can use the following shortcodes `[one_sixth]`, `[one_fourth]`, `[one_third]`, `[one_half]` in any combination as long as they total 1 in then end. The start of each column begins with a shortcode that ends in `_first`, like this: `[one_sixth_first]`. Each row ends with a shortcode that ends in `_last`, like this: `[/one_third_last]`. 

You can combine grid with many of the shortcodes above to create complex page layouts. One important point to remember is this: When you are adding your grid shortcodes in the WordPress editor, WordPress will transform all RETURNS as linebreaks and add a `<br />` tag. This can cause your grids to display in a stair step layout, which isn’t good. To fix this, do not RETURN when adding your grid shortcodes to the WordPress editor.

For example, this is correct:

`[one_half_first]
This is the first column
[/one_half_first][one_half_last]
This is the first column
[one_half_last]`

This is incorrect:

`[one_half_first]
This is the first column
[/one_half_first]
[one_half_last]
This is the first column
[one_half_last]`

Notice that there is a RETURN after the [/one_half_first]? This will cause layout problems (the stair step effect, which we don’t want). Simply make sure that your ending and beginning grid shortcodes but directly up against each other, like this:

`[/one_half_first][one_half_last]`

Now, onto the full grid shortcodes. Below are some usage examples:

Six Columns

    `[one_sixth_first]This is the first column[/one_sixth_first]
    [one_sixth]This is the second column[/one_sixth]
    [one_sixth]This is the third column[/one_sixth]
    [one_sixth]This is the fourth column[/one_sixth]
    [one_sixth]This is the fifth column[/one_sixth]
    [one_sixth_last]This is the sixth and last column[/one_sixth_last]`


Four Columns

   `[one_fourth_first]This is the first column[/one_fourth_first]
    [one_fourth]This is the second column[/one_fourth]
    [one_fourth]This is the third column[/one_fourth]
    [one_fourth_last]This is the fourth and last column[/one_fourth_last]`


Three Columns

    `[one_third_first]This is the first column[/one_third_first]
    [one_third]This is the second column[/one_third]
    [one_third_last]This is the third and last column[/one_third_last]`


Two Columns

    `[one_half_first]This is the first column[/one_half_first]
    [one_half_last]This is the second and last column[/one_half_last]`


One-Sixth & Five-Sixth Columns

    `[one_sixth_first]This is the first column[/one_sixth_first]
    [five_sixth_last]This is the second and last column[/five_sixth_last]`


One-Third & Two-Third Columns

    `[one_third_first]This is the first column[/one_third_first]
    [two_thirds_last]This is the second and last column[/two_thirds_last]`



== Changelog ==

= 1.1 =
* New buttons, icons, google maps, pricing table, tabs, toggles and more

= 1.0.2 =
* css conflict resolved

= 1.0 =
* Initial beta release

== Upgrade Notice ==

* If you are upgrading from version 1.0 to version 1.1 you will need to update your [button] shortcodes to [gpp_button] and your grid shortcodes to use the new grid shortcode syntax. Please refer to the official instructions here:

http://graphpaperpress.com/plugins/gpp-shortcodes/