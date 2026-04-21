<?php
/**
 * Popup Renderer
 *
 * Handles rendering popups in the frontend.
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
 * Class YAPOPUPS_Popup_Renderer
 */
class YAPOPUPS_Popup_Renderer {

	public function __construct() {
		add_action( 'wp_footer', array( $this, 'output_popups' ), 999 );
	}

	/**
	 * Check if plugin is enabled
	 *
	 * @return bool
	 */
	private function is_enabled(): bool {
		$enabled = get_option( 'yapopups_enable', true );
		return (bool) $enabled;
	}

	/**
	 * Check if debug mode is enabled
	 *
	 * @return bool
	 */
	private function is_debug_enabled(): bool {
		$debug = get_option( 'yapopups_debug_mode', false );
		return (bool) $debug;
	}

	/**
	 * Get all published popups
	 *
	 * @return array Array of published popup posts.
	 */
	public function get_published_popups(): array {
		$args = array(
			'post_type'      => YAPOPUPS_CPT_SLUG,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'ASC',
		);

		return get_posts( $args );
	}

	/**
	 * Output all published popups in footer
	 */
	public function output_popups(): void {
		if ( ! $this->is_enabled() ) {
			return;
		}

		$popups = $this->get_published_popups();

		if ( empty( $popups ) ) {
			return;
		}

		$debug_enabled = $this->is_debug_enabled();

		foreach ( $popups as $popup ) {
			setup_postdata( $popup );
			$this->render_popup( $popup, $debug_enabled );
		}

		wp_reset_postdata();
	}

	/**
	 * Render a single popup
	 *
	 * @param WP_Post $popup The popup post object.
	 * @param bool    $debug_enabled Whether debug mode is enabled.
	 */
	private function render_popup( $popup, bool $debug_enabled = false ): void {
		$popup_slug  = YAPOPUPS_CPT_SLUG . $popup->ID;
		$popup_title = get_the_title( $popup->ID );
		$popup_content = get_the_content( $popup->ID );

		include YAPOPUPS_PLUGIN_DIR . 'templates/popup-template.php';
	}
}
