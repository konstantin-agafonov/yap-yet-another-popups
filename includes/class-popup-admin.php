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

		register_setting(
			'yapopups_settings_group',
			'yapopups_output_titles',
			array(
				'type'              => 'boolean',
				'sanitize_callback' => 'rest_sanitize_boolean',
				'default'           => true,
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

		add_settings_field(
			'yapopups_output_titles',
			__( 'Output popups titles', 'yap-yet-another-popups' ),
			array( $this, 'render_output_titles_field' ),
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
		$this->render_checkbox_template(
			'yapopups_enable',
			'yapopups_enable',
			$value,
			__( 'Enable popup functionality on the frontend', 'yap-yet-another-popups' )
		);
	}

	/**
	 * Render checkbox template
	 *
	 * @param string $id    Field ID.
	 * @param string $name  Field name.
	 * @param bool   $value Whether checked.
	 * @param string $label Label text.
	 */
	private function render_checkbox_template( $id, $name, $value, $label ): void {
		include YAPOPUPS_PLUGIN_DIR . 'templates/option-checkbox.php';
	}

	/**
	 * Render debug field
	 */
	public function render_debug_field(): void {
		$value = get_option( 'yapopups_debug_mode', false );
		$this->render_checkbox_template(
			'yapopups_debug_mode',
			'yapopups_debug_mode',
			$value,
			__( 'Enable debug logging in browser console', 'yap-yet-another-popups' )
		);
	}

	/**
	 * Render remove data on uninstall field
	 */
	public function render_remove_data_on_uninstall_field(): void {
		$value = get_option( 'yapopups_remove_data_on_uninstall', false );
		$this->render_checkbox_template(
			'yapopups_remove_data_on_uninstall',
			'yapopups_remove_data_on_uninstall',
			$value,
			__( 'Delete all popup posts and plugin settings when uninstalling the plugin', 'yap-yet-another-popups' )
		);
	}

	/**
	 * Render output titles field
	 */
	public function render_output_titles_field(): void {
		$value = get_option( 'yapopups_output_titles', true );
		$this->render_checkbox_template(
			'yapopups_output_titles',
			'yapopups_output_titles',
			$value,
			__( 'Output popups titles', 'yap-yet-another-popups' )
		);
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

			<?php include YAPOPUPS_PLUGIN_DIR . 'templates/how-to-use-popups.php'; ?>

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
