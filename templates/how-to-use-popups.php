<?php
/**
 * How to Use Popups template
 *
 * @package YAP_Yet_Another_Popups
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="card" style="max-width: 800px; margin-top: 20px;">
	<h3><?php esc_html_e( 'Creating a Popup', 'yap-yet-another-popups' ); ?></h3>
	<ol>
		<li><?php esc_html_e( 'Go to', 'yap-yet-another-popups' ); ?> <strong><?php esc_html_e( 'Popups → Add New Popup', 'yap-yet-another-popups' ); ?></strong></li>
		<li><?php esc_html_e( 'Enter a title for your popup (this will be displayed as the popup heading)', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Add content in the editor (supports HTML, shortcodes, and Contact Form 7)', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Click Publish', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Copy the Popup Slug from the "Popup Slug" meta box on the right', 'yap-yet-another-popups' ); ?></li>
	</ol>

	<h3><?php esc_html_e( 'Adding a Link to Open a Popup', 'yap-yet-another-popups' ); ?></h3>
	<p><?php esc_html_e( 'To open a popup, add a link with the href equal to the popup slug:', 'yap-yet-another-popups' ); ?></p>
	<pre style="background: #f0f0f1; padding: 15px; border-radius: 4px;"><code>&lt;a href="#yapopup123"&gt;<?php esc_html_e( 'Open Popup', 'yap-yet-another-popups' ); ?>&lt;/a&gt;</code></pre>

	<h3><?php esc_html_e( 'Examples', 'yap-yet-another-popups' ); ?></h3>

	<h4><?php esc_html_e( '1. Simple Text Popup', 'yap-yet-another-popups' ); ?></h4>
	<ol>
		<li><?php esc_html_e( 'Create a new popup with title "Information"', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Add your text content', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Publish and get slug, e.g.,', 'yap-yet-another-popups' ); ?> <code>#yapopup42</code></li>
		<li><?php esc_html_e( 'Add link:', 'yap-yet-another-popups' ); ?> <code>&lt;a href="#yapopup42"&gt;<?php esc_html_e( 'Learn More', 'yap-yet-another-popups' ); ?>&lt;/a&gt;</code></li>
	</ol>

	<h4><?php esc_html_e( '2. Popup with Contact Form 7', 'yap-yet-another-popups' ); ?></h4>
	<ol>
		<li><?php esc_html_e( 'Create a new popup with title "Contact Us"', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Add Contact Form 7 shortcode:', 'yap-yet-another-popups' ); ?> <code>[contact-form-7 id="123"]</code></li>
		<li><?php esc_html_e( 'Publish and use the slug in your link', 'yap-yet-another-popups' ); ?></li>
	</ol>

	<h4><?php esc_html_e( '3. Open Popup via JavaScript', 'yap-yet-another-popups' ); ?></h4>
	<pre style="background: #f0f0f1; padding: 15px; border-radius: 4px;"><code>// Vanilla JavaScript
document.querySelector('a[href="#yapopup42"]').click();

// jQuery
jQuery('a[href="#yapopup42"]').trigger('click');</code></pre>

	<h3><?php esc_html_e( 'Popup Features', 'yap-yet-another-popups' ); ?></h3>
	<ul>
		<li><?php esc_html_e( 'Click outside popup or on × button to close', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Supports all WordPress shortcodes', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Responsive design for mobile devices', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'Scroll lock when popup is open', 'yap-yet-another-popups' ); ?></li>
		<li><?php esc_html_e( 'URL hash updates on open/close', 'yap-yet-another-popups' ); ?></li>
	</ul>
</div>
