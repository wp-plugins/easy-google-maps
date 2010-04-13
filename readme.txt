=== Easy Google Maps ===
Contributors: gattdesign
Donate link: http://plugins.gattdesign.co.uk/
Tags: google map, google maps, gmap, gmaps, streetview
Requires at least: 2.9
Tested up to: 2.9.2
Stable tag: 1.0

An easy-to-use plugin for embedding Google Maps into your blog posts and pages. Requires PHP 5.0 or later.

== Description ==

The Easy Google Maps plugin for WordPress enables you to easily embed one or more Google Maps into your blog posts or pages.

It does this by embedding the map into a &lt;iframe&gt;.

== Installation ==

1. Upload the `easy-google-maps` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use the shortcode `&#91;gmap&#93;{url}&#91;/gmap&#93;` in any of your posts or pages

== ChangeLog ==

= Version 1.0 =

* First release.

== Frequently Asked Questions ==

= Where Can I Use Easy Google Maps? =

You can use it in any post or page.  Simply insert the shortcode `&#91;gmap&#93;{url}&#91;/gmap&#93;`. Example:

`&#91;gmap class="myclass" width="500" height="500"&#93;http://maps.google.co.uk/maps?hl=en&ie=UTF8&ll=51.482398,-0.60751&spn=0,0.090895&t=h&z=14&layer=c&cbll=51.482533,-0.607619&panoid=wT3WvpJQcFZmBu8Rd2lUmA&cbp=12,26.35,,0,-1.93&#91;/gmap&#93;`

The URL to your map can be copied from where it says "Paste link in email or IM" or "Paste HTML to embed in website" in Google Maps.

The following map attributes are all optional:

`class` - name of &#91;iframe&#93; CSS class
`width` - width of &#91;iframe&#93; (defaults to 400)
`height` - height of &#91;iframe&#93; (defaults to 400)

== Screenshots ==

1. Admin screenshot.
1. Google Map on WordPress page.