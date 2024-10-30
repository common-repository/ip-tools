=== Plugin Name ===
Contributors: ChrisDennis
Tags: ipv6, ipv4, ip, widget, address
Requires at least: 2.8
Tested up to: 5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

IP Tools is a small collection of useful shortcodes, widgets, and classes related to IP addresses.

== Description ==

The IP Tools plugin provides a number of ways to control the content displayed 
to the visitor depending on whether they have connected to the server
via IPv4 or IPv6.

IPv6 is slowly being adopted, and will eventually replace IPv4.
There is plenty of information on this topic on the internet -- 
on [Wikipedia](https://en.wikipedia.org/wiki/IPv6), for example.

Suggestions for more things to add to this tool box will be welcome.

= Shortcodes =

Place these shortcodes in your posts and pages.

* `[ipt_address]` is replaced by the visitor's IP address.
* `[ipt_ipv6logo width=80px]` is replaced by an IPv6 logo (from the 
  [World IPv6 Launch](http://www.worldipv6launch.org/) website)
  displayed with the given width.  The default width is 64 pixels: the width can be
  specified in any [CSS length unit](http://www.w3.org/TR/css3-values/#lengths).
* `[ipt_ipv6only]...text...[/ipt_ipv6only]` displays the text only if IPv6 is in use.
* `[ipt_ipv4only]...text...[/ipt_ipv4only]` displays the text only if IPv4 is in use.

Other shortcodes can be nested within these last two.

Note that shortcodes can be used in text widgets, but only if the theme includes
the necessary filter.
If shortcodes in widgets are not working in your current theme, 
you need to modify your WordPress theme and put the following 
code into the "functions.php" file of the theme.

    <?php add_filter('widget_text', 'do_shortcode'); ?>

Thanks to the [Lost in Code website](http://www.lost-in-code.com/platforms/wordpress/wordpress-shortcode-in-text-widget/) for this tip.

= CSS Classes =

IP Tools creates CSS which can be used to hide any HTML element depending on whether IPv4 or IPv6 is in use.

It defines classes `ipt_ipv4only` and `ipt_ipv6only` which basically do what they say: the element
with that class is modified with `display: none` if the visitor's IP address is in the other IP domain.

For example, if you included the following HTML in a page, post, or widget
only the relevant section of text would be displayed to the user.

    <div class="ipt_ipv4only">
        <p>You've come to this webpage via IPv4 -- 
	that's <em>so</em> last century.
    </div>
    <div class="ipt_ipv6only">
        <p>Well done!  You're enjoying the modern wonders of IPv6.
    </div>

= Widgets =

So far, IP Tools just provides one small widget called 'IP Tools Address' that displays the visitor's IP address -- something like 
'IPv4 address: 12.34.56.78' or 'IPv6 address: 2001:0db8:85a3:0000:0000:8a2e:0370:7334'.

The title of the widget can be changed from its default value of 'IP Tools'.

== Installation ==

Installation is very simple 

1. Download the plugin and extract it to your WordPress plugin directory (`.../wp-content/plugins/`),
   or else search for it in the Install Plugins page from within WordPress and click on 'Install Now'.
2. Activate the plugin through the 'Plugins' menu in WordPress.

Then you can add shortcodes, widgets, and classes to your website: see the
Description section for details.

== Frequently Asked Questions ==

== Screenshots ==

== Upgrade Notice == 

== Changelog ==

= 0.1.5

* Fixed deprecated use of class name as constructor function.
* Tested on WP 5.0.2.

= 0.1.4

* Tested on WP 4.9.1

= 0.1.3 =

* Tested on WP 4.7.2

= 0.1.2 =

* Tested on WP 4.0

= 0.1.1 =

* Minor tweaks.

= 0.1.0 =

* First public release.
