<?php
/*
Plugin Name: Easy Google Maps
Plugin URI: http://plugins.gattdesign.co.uk
Version: 1.0
Author: Gatt Design
Author URI: http://plugins.gattdesign.co.uk
Description: An easy-to-use plugin for embedding Google Maps into your blog posts and pages. Requires PHP 5.0 or later.

Copyright 2010 Gatt Design  (email : info@gattdesign.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// plugin class
if(!class_exists('EasyGMaps')) {
	class EasyGMaps {

		// shortcode and message handling functions
		function short_code($short_code_attributes, $short_code_content) {
			// if there is no URL specified, use the default UK map
			if(empty($short_code_content)) $short_code_content = wp_specialchars('http://maps.google.co.uk/maps?ie=UTF8&ll=53.800651,-4.064941&spn=14.641113,46.538086&t=h&z=5');

			// set default attributes
			extract(shortcode_atts(array('class' => '', 'width' => '400', 'height' => '400'), $short_code_attributes));	
			$check_the_content = strpos($short_code_content, 'iframe');

			if($check_the_content != FALSE) {
				// user has given full <iframe> content, decode the URL and replace the fancy quotes used in the WP TinyMCE editor
				$short_code_content = wp_specialchars_decode($short_code_content);
				$short_code_replacement_array = array('&#8221;', '&#8243;');
				$short_code_content = str_replace($short_code_replacement_array, '"', $short_code_content);

				// extract the URL
				$extraction_position_start = strpos($short_code_content, 'src="');
				$extraction_position_start = $extraction_position_start + 5;
				$extraction_position_start_clean = substr($short_code_content, $extraction_position_start);		
				$extraction_position_end = strpos($extraction_position_start_clean, '">');
				$extraction_position_end = substr($extraction_position_start_clean, 0, $extraction_position_end);

				// remove any embed code
				$expEmbedRemovalArray = array('&amp;output=embed', '&output=embed', '&amp;source=embed', '&source=embed', '&amp;output=svembed', '&output=svembed');
				$expEmbedRemoved = str_replace($expEmbedRemovalArray, NULL, $extraction_position_end);
				$short_code_content = $expEmbedRemoved;			
			}

			// has a class name been given?
			if(!empty($class)) { $iframe_class = ' class="' . $class . '"'; } else { $iframe_class = NULL; }

			// has a width been given?
			if(!empty($width)) { $iframe_width = ' width="' . $width . '"'; } else { $iframe_width = NULL; }

			// has a height been given?
			if(!empty($height)) { $iframe_height = ' height="' . $height . '"'; } else { $iframe_height = NULL; }

			// add parameters according to map type
			$embed_parameter = NULL;
			if(strpos($short_code_content, '&amp;panoid=') != FALSE) { $type_street = TRUE; } else { $type_street = FALSE; }
			if($type_street != FALSE) { $embed_parameter = '&amp;source=embed&amp;output=svembed'; } else { $embed_parameter = '&amp;output=embed'; }

			// construct output
			$short_code_output = "\n" . '<!-- start of Easy Google Maps -->' . "\n";
			$short_code_output .= '<iframe src="' . $short_code_content . $embed_parameter . '"' . $iframe_class . $iframe_width . $iframe_height . '></iframe>' . "\n";
			$short_code_output .= '<!-- end of Easy Google Maps -->' . "\n\n";

			// output the map
			return $short_code_output;

		}

		// meta box text
		function meta_box_text() {
			echo '<p>The <i>Easy Google Maps</i> plugin for WordPress enables you to easily embed one or more Google Maps into your blog posts or pages. It does this by embedding the map into a &lt;iframe&gt;.<br /><br />You can embed any type of Google map (i.e. map/satellite/hybrid/terrain/street view) and customise the width, height and styling of the &lt;iframe&gt; by using any or all of the optional shortcode attributes.</p>' . "\n";
			echo '<p><b><span style="color: #800099;">Shortcode syntax:</span> [gmap class</b>="{class}" <b>width</b>="{width}" <b>height</b>="{height}"<b>]</b>{URL}<b>[/gmap]</b><br /><br />The <b><i>URL</i></b> to your map can be copied from where it says "<i>Paste link in email or IM</i>" or "<i>Paste HTML to embed in website</i>" in Google Maps.<br /><br />The following map attributes are all optional:</p>' . "\n";
			echo '<p><b><i>class</i></b> - name of &lt;iframe&gt; CSS class<br /><b><i>width</i></b> - width of &lt;iframe&gt; (defaults to <i>400</i>)<br /><b><i>height</i></b> - height of &lt;iframe&gt; (defaults to <i>400</i>)</p>' . "\n";
			echo '<p><b><span style="color: #FF0000;">Need some help?</span></b> Get support for this plugin by visiting the <a href="http://plugins.gattdesign.co.uk">Gatt Design Plugins forums</a>.</p>' . "\n";
		}

		// construct meta box
		function meta_box_constructor() {
			if(function_exists('add_meta_box')) { 
				add_meta_box('easy_google_maps_post', __('Easy Google Maps', 'easy_google_maps_post_' ), array('EasyGMaps', 'meta_box_text'), 'post', 'normal', 'high');
				add_meta_box('easy_google_maps_page', __('Easy Google Maps', 'easy_google_maps_post_' ), array('EasyGMaps', 'meta_box_text'), 'page', 'normal', 'high');
			}

			if(function_exists('do_meta_box')) {
				do_meta_box('easy_google_maps_post_', 'normal', NULL);
				do_meta_box('easy_google_maps_page_', 'normal', NULL);
			}
		}

		// create the [gmap] shortcode
		function create_shortcode() { return add_shortcode('gmap', array('EasyGMaps', 'short_code')); }

		// function initialisations
		function start_me_up() {
			// append short code functionality
			self::create_shortcode();

			// add meta box to post and page editors
			add_action('admin_menu', array('EasyGMaps', 'meta_box_constructor'));
		}

		// plugin class constructor
		function EasyGMaps() { return self::start_me_up(); }

	}

}

// initialise class
if(class_exists('EasyGMaps')) $EasyGMaps_class = new EasyGMaps;

?>