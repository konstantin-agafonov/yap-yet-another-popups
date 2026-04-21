=== YAP - Yet Another Popups ===
Contributors: konstantin1agafonov
Donate link: https://boosty.to/konstantin1agafonov
Tags: popup, modal, lightbox, overlay, notification
Requires at least: 6.0
Tested up to: 6.9
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple plugin for creating and managing popup windows on your WordPress site.

== Description ==

This plugin provides a clean, lightweight solution for creating popups in WordPress. It uses a custom post type to manage popups and displays them in the site footer. Popups can be triggered via anchor links or JavaScript.

= Features =

* Create unlimited popups via WordPress admin
* Custom post type for easy management
* Support for shortcodes (Contact Form 7, etc.)
* Responsive design
* Click outside or × button to close
* URL hash-based triggering
* Scroll lock when popup is open

= Support =

If you want to buy me a coffee, write me a message to kagafonov2222@yandex.ru

== Installation ==

1. Upload the `yap-yet-another-popups` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to **YAP - Yet Another Popups → Add New Popup** to create your first popup

== Frequently Asked Questions ==

= How do I create a popup? =

1. In WordPress admin, go to **Popups → Add New Popup**
2. Enter a title (displayed as popup heading)
3. Add content in the editor (supports HTML and shortcodes)
4. Click **Publish**
5. Copy the **Popup Slug** from the meta box (e.g., `#yapopup123`)

= How do I open a popup? =

Add a link with the href equal to the popup slug:

`<a href="#yapopup123">Open Popup</a>`

= Does this work with Contact Form 7? =

Yes! You can add any shortcode including Contact Form 7 in the popup content editor.

= Can I customize the popup styles? =

Yes, override the CSS classes in your theme's stylesheet. See the Customization section in the plugin settings page.
