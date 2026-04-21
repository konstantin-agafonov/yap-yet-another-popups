<?php
/**
 * Uninstall functionality for YAP - Yet Another Popups plugin.
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

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

define( 'YAPOPUPS_CPT_SLUG', 'yapopup' );

// Delete all popup posts.
$yapopups_popups = get_posts(
	array(
		'post_type'      => YAPOPUPS_CPT_SLUG,
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	)
);

foreach ( $yapopups_popups as $yapopups_popup_id ) {
	wp_delete_post( $yapopups_popup_id, true );
}

// Delete plugin options.
delete_option( 'yapopups_enable' );
delete_option( 'yapopups_debug_mode' );
delete_option( 'yapopups_rules_flushed' );
