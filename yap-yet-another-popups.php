<?php
/**
 * Plugin Name: YAP - Yet Another Popups
 * Plugin URI: https://github.com/konstantin-agafonov/yap-yet-another-popups
 * Description: A simple plugin for creating and managing popup windows on your WordPress site.
 * Version: 1.0.1
 * Author: kagafonov2222@yandex.ru
 * Author URI: https://x.com/K0HCTAHTIH
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: yap-yet-another-popups
 * Requires at least: 6.0
 * Requires PHP: 7.4
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

define( 'YAPOPUPS_VERSION', '1.0.1' );
define( 'YAPOPUPS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'YAPOPUPS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'YAPOPUPS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'YAPOPUPS_CPT_SLUG', 'yapopup' );

/**
 * Main plugin class
 */
final class YAPOPUPS_Plugin {

	private static $instance = null;

	public static function get_instance(): YAPOPUPS_Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->init();
	}

	private function init(): void {
		add_action( 'init', array( $this, 'load_includes' ), -100 );
	}

	public function load_includes(): void {
		require_once YAPOPUPS_PLUGIN_DIR . 'includes/class-popup-cpt.php';
		require_once YAPOPUPS_PLUGIN_DIR . 'includes/class-popup-assets.php';
		require_once YAPOPUPS_PLUGIN_DIR . 'includes/class-popup-renderer.php';
		require_once YAPOPUPS_PLUGIN_DIR . 'includes/class-popup-admin.php';

		new YAPOPUPS_Popup_CPT();
		new YAPOPUPS_Popup_Assets();
		new YAPOPUPS_Popup_Renderer();
		new YAPOPUPS_Popup_Admin();
	}
}

YAPOPUPS_Plugin::get_instance();
