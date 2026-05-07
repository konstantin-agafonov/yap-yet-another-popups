<?php
/**
 * Popup template file
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

$yapopups_popup_slug     = YAPOPUPS_CPT_SLUG . $popup->ID;
$yapopups_popup_title    = get_the_title( $popup->ID );
$yapopups_popup_content  = get_the_content( $popup->ID );
$yapopups_output_titles  = get_option( 'yapopups_output_titles', true );
?>

<div id="<?php echo esc_attr( $yapopups_popup_slug ); ?>" class="yapopups-popup">
	<div class="yapopups-popup__body">
		<div class="yapopups-popup__close"></div>
		<?php if ( $yapopups_output_titles && $yapopups_popup_title ) : ?>
			<h3 class="yapopups-popup__title"><?php echo esc_html( $yapopups_popup_title ); ?></h3>
		<?php endif; ?>
		<div class="yapopups-popup__content">
			<?php echo do_shortcode( wp_kses_post( $yapopups_popup_content ) ); ?>
		</div>
	</div>
</div>
