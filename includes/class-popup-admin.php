<?php
/**
 * Admin Settings Page
 *
 * Handles the plugin settings page in WordPress admin.
 *
 * @package YAP_Yet_Another_Popups
 *
 * Copyright (C) 2026 YAP - Yet Another Popups
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class YAPOPUPS_Popup_Admin
 */
class YAPOPUPS_Popup_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 20 );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_filter( 'plugin_action_links_' . YAPOPUPS_PLUGIN_BASENAME, array( $this, 'add_plugin_action_links' ) );
		add_action( 'admin_notices', array( $this, 'settings_notice' ) );
	}

	/**
	 * Add admin menu page
	 */
	public function add_admin_menu(): void {
		add_submenu_page(
			'edit.php?post_type=' . YAPOPUPS_CPT_SLUG,
			__( 'Popup Settings', 'yap-yet-another-popups' ),
			__( 'Settings', 'yap-yet-another-popups' ),
			'manage_options',
			'yapopups-settings',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Register plugin settings
	 */
	public function register_settings(): void {
		register_setting(
			'yapopups_settings_group',
			'yapopups_enable',
			array(
				'type'              => 'boolean',
				'sanitize_callback' => 'rest_sanitize_boolean',
				'default'           => true,
			)
		);

		register_setting(
			'yapopups_settings_group',
			'yapopups_debug_mode',
			array(
				'type'              => 'boolean',
				'sanitize_callback' => 'rest_sanitize_boolean',
				'default'           => false,
			)
		);

		register_setting(
			'yapopups_settings_group',
			'yapopups_remove_data_on_uninstall',
			array(
				'type'              => 'boolean',
				'sanitize_callback' => 'rest_sanitize_boolean',
				'default'           => false,
			)
		);

		add_settings_section(
			'yapopups_general_section',
			__( 'General Settings', 'yap-yet-another-popups' ),
			array( $this, 'render_section_callback' ),
			'yapopups_settings_group'
		);

		add_settings_field(
			'yapopups_enable',
			__( 'Enable Popups', 'yap-yet-another-popups' ),
			array( $this, 'render_enable_field' ),
			'yapopups_settings_group',
			'yapopups_general_section'
		);

		add_settings_field(
			'yapopups_debug_mode',
			__( 'Debug Mode', 'yap-yet-another-popups' ),
			array( $this, 'render_debug_field' ),
			'yapopups_settings_group',
			'yapopups_general_section'
		);

		add_settings_field(
			'yapopups_remove_data_on_uninstall',
			__( 'Remove plugin data on uninstall', 'yap-yet-another-popups' ),
			array( $this, 'render_remove_data_on_uninstall_field' ),
			'yapopups_settings_group',
			'yapopups_general_section'
		);
	}

	/**
	 * Settings notice callback
	 */
	public function settings_notice(): void {
		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) {
			add_settings_error(
				'yapopups_settings_group',
				'yapopups_settings_saved',
				__( 'Settings saved.', 'yap-yet-another-popups' ),
				'updated'
			);
		}
	}

	/**
	 * Section callback
	 */
	public function render_section_callback(): void {
		echo '<p>' . esc_html__( 'Configure plugin general settings.', 'yap-yet-another-popups' ) . '</p>';
	}

	/**
	 * Render enable field
	 */
	public function render_enable_field(): void {
		$value = get_option( 'yapopups_enable', true );
		?>
		<input type="checkbox"
			   id="yapopups_enable"
			   name="yapopups_enable"
			   value="1"
			   <?php checked( $value, true ); ?>
		/>
		<label for="yapopups_enable">
			<?php esc_html_e( 'Enable popup functionality on the frontend', 'yap-yet-another-popups' ); ?>
		</label>
		<?php
	}

	/**
	 * Render debug field
	 */
	public function render_debug_field(): void {
		$value = get_option( 'yapopups_debug_mode', false );
		?>
		<input type="checkbox"
			   id="yapopups_debug_mode"
			   name="yapopups_debug_mode"
			   value="1"
			   <?php checked( $value, true ); ?>
		/>
		<label for="yapopups_debug_mode">
			<?php esc_html_e( 'Enable debug logging in browser console', 'yap-yet-another-popups' ); ?>
		</label>
		<?php
	}

	/**
	 * Render remove data on uninstall field
	 */
	public function render_remove_data_on_uninstall_field(): void {
		$value = get_option( 'yapopups_remove_data_on_uninstall', false );
		?>
		<input type="checkbox"
			   id="yapopups_remove_data_on_uninstall"
			   name="yapopups_remove_data_on_uninstall"
			   value="1"
			   <?php checked( $value, true ); ?>
		/>
		<label for="yapopups_remove_data_on_uninstall">
			<?php esc_html_e( 'Delete all popup posts and plugin settings when uninstalling the plugin', 'yap-yet-another-popups' ); ?>
		</label>
		<?php
	}

	/**
	 * Render settings page
	 */
	public function render_settings_page(): void {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<?php
			settings_errors( 'yapopups_settings_group' );
			?>

			<form action="options.php" method="post">
				<?php
				settings_fields( 'yapopups_settings_group' );
				do_settings_sections( 'yapopups_settings_group' );
				submit_button();
				?>
			</form>

			<hr style="margin: 40px 0;" />

			<h2><?php esc_html_e( 'How to Use Popups', 'yap-yet-another-popups' ); ?></h2>

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

			<?php if ( current_user_can( 'manage_options' ) ) : ?>
			<hr style="margin: 40px 0;" />

			<h2><?php esc_html_e( 'Debug Information', 'yap-yet-another-popups' ); ?></h2>
			<div class="card" style="max-width: 800px; margin-top: 20px;">
				<?php
				$popups = get_posts(
					array(
						'post_type'      => YAPOPUPS_CPT_SLUG,
						'post_status'    => 'publish',
						'posts_per_page' => -1,
					)
				);
				?>
				<p>
					<strong><?php esc_html_e( 'Published Popups:', 'yap-yet-another-popups' ); ?></strong>
					<?php echo count( $popups ); ?>
				</p>
				<?php if ( ! empty( $popups ) ) : ?>
					<ul>
						<?php foreach ( $popups as $popup ) : ?>
							<li>
								<strong><?php echo esc_html( $popup->post_title ); ?></strong>
								(ID: <?php echo esc_html( $popup->ID ); ?>)
								- <code>#yapopup<?php echo esc_html( $popup->ID ); ?></code>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Add plugin action links
	 *
	 * @param array $links Existing action links.
	 * @return array Modified action links.
	 */
	public function add_plugin_action_links( $links ): array {
		$settings_link = '<a href="' . admin_url( 'edit.php?post_type=' . YAPOPUPS_CPT_SLUG . '&page=yapopups-settings' ) . '">' . __( 'Settings', 'yap-yet-another-popups' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
}
