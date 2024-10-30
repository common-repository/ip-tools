<?php
/*
Plugin Name: IP Tools
Plugin URI: 
Description: Useful tools to do with IP version and address
Version: 0.1.5
Author: Chris Dennis
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

//-----------------------------------------------------------------------------------------

function have_ipv6 () {
	return strstr($_SERVER['REMOTE_ADDR'], ':') ? True : False;
}

//-----------------------------------------------------------------------------------------

/* Widget that displays the IP address of the visitor, with a customisable title
 * (see http://codex.wordpress.org/Widgets_API)
 */
class ipt_address_widget extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		parent::__construct(false, 'IP Tools Address');
	}

	function widget($args, $instance) {
		// Widget output
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}
		$addr = $_SERVER['REMOTE_ADDR'];
		echo strstr($addr, ':') ? 'IPv6' : 'IPv4';
		// add optional line-break points after each ':' (HTML5)
		$addr = str_replace(':', ':<wbr>', $addr);
		echo ' address: ' . $addr;
		echo $after_widget;
	}

	function form($instance) {
		// Output admin widget options form
		if (isset($instance['title'])) {
			$title = $instance['title'];
		}
		else {	// default value:
			$title = __('IP Tools', 'text_domain');
		}
		echo '<p><label for="' . $this->get_field_name('title') . '">' . _e('Title:') . '</label>';
		echo '<input class="widefat" id="' . $this->get_field_id('title') . 
			'" name="' . $this->get_field_name('title') . 
			'" type="text" value="' . esc_attr($title) . '" /></p>';
	}

	function update($new_instance, $old_instance) {
		// Check and save widget options from form
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		return $instance;
	}
}

function iptools_register_widgets() {
	register_widget('ipt_address_widget');
}

add_action('widgets_init', 'iptools_register_widgets');

//-----------------------------------------------------------------------------------------

/* Shortcodes: 
 * [ipt_address] is replaced by the visitor's IP address
 * [ipt_ipv6logo] is replaced by an IPv6 logo
 * [ipt_ipv6only]...text...[/ipt_ipv6only] displays the text only if IPv6 is in use
 * [ipt_ipv4only]...text...[/ipt_ipv4only] displays the text only if IPv4 is in use
 *   (other shortcodes can be nested within these last two)
 */

// [ipt_address]
function address_shortcode_func($attrs, $content = null){
	return $_SERVER['REMOTE_ADDR'];
}
add_shortcode('ipt_address', 'address_shortcode_func');

// [ipt_ipv6logo] -- optional parameter 'width' with default of 64
function ipv6logo_shortcode_func($attrs, $content = null) {
	extract(shortcode_atts(array('width' => '64px',), $attrs));
	$result = '';
	if (have_ipv6()) {
		$logo = plugins_url('images/World_IPv6_launch_logo.svg', __FILE__);
		$result .= "<img alt=\"IPv6 logo\" title=\"IPv6 is in use on this web page\" style=\"width: $width;\" src=\"$logo\">";
	}
	return $result;
}
add_shortcode('ipt_ipv6logo', 'ipv6logo_shortcode_func');

// [ipt_ipv6only]text if ipv6[/ipt_ipv6only]
function ipv6only_shortcode_func($attrs, $content = null){
	return have_ipv6() ? do_shortcode($content) : '';
}
add_shortcode('ipt_ipv6only', 'ipv6only_shortcode_func');

// [ipt_ipv4only]text if ipv4[/ipt_ipv4only]
function ipv4only_shortcode_func($attrs, $content = null){
	return have_ipv6() ? '' : do_shortcode($content);
}
add_shortcode('ipt_ipv4only', 'ipv4only_shortcode_func');

//-----------------------------------------------------------------------------------------

/* CSS classes 'ipt_ip4only' and 'ipt_ip6only' can be used to tag any HTML element 
 * so that it's only displayed when the user connects via IPv4 or IPv6
 */
function add_stylesheets () {
	if (have_ipv6()) {
		wp_register_style('ipt-ip46-style', plugins_url('css/ipt_ip6only.css', __FILE__));
		wp_enqueue_style('ipt-ip46-style');
	} else {
		wp_register_style('ipt-ip46-style', plugins_url('css/ipt_ip4only.css', __FILE__));
		wp_enqueue_style('ipt-ip46-style');
	}
}
add_action('wp_enqueue_scripts', 'add_stylesheets');

//-----------------------------------------------------------------------------------------

