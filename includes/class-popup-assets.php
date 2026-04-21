<?php
/**
 * Popup Assets
 *
 * Handles enqueueing popup scripts and styles.
 *
 * @package YAP_Yet_Another_Popups
 *
 * Copyright (C) 2024 YAP - Yet Another Popups
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
 * Class YAPOPUPS_Popup_Assets
 */
class YAPOPUPS_Popup_Assets {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
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
	 * Enqueue popup scripts and styles
	 */
	public function enqueue_assets(): void {
		if ( ! $this->is_enabled() ) {
			return;
		}

		wp_enqueue_style(
			'yapopups',
			YAPOPUPS_PLUGIN_URL . 'assets/css/popups.css',
			array(),
			YAPOPUPS_VERSION
		);

		wp_enqueue_script(
			'yapopups',
			YAPOPUPS_PLUGIN_URL . 'assets/js/popups.js',
			array( 'jquery' ),
			YAPOPUPS_VERSION,
			true
		);

		$debug_enabled = $this->is_debug_enabled();
		wp_localize_script(
			'yapopups',
			'yapopupsData',
			array(
				'debug' => $debug_enabled,
			)
		);
	}
}
