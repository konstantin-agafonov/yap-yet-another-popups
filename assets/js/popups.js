/**
 * Popup JavaScript
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

(function($) {
	'use strict';

	const yapopupsData = window.yapopupsData || { debug: false };

	function log() {
		if (yapopupsData.debug && window.console && window.console.log) {
			console.log.apply(console, arguments);
		}
	}

	// Popup functionality
	function yapopupsPopup() {
		// Get scrollbar width
		function getScrollbarWidth() {
			const outer = document.createElement('div');
			outer.style.visibility = 'hidden';
			outer.style.overflow = 'scroll';
			document.body.appendChild(outer);
			const inner = document.createElement('div');
			outer.appendChild(inner);
			const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
			outer.parentNode.removeChild(outer);
			return scrollbarWidth;
		}

		// Function to open popup
		function openPopup( popupId ) {
			log('[YAPopups] Opening popup:', popupId);

			const $popup = $(popupId);
			if ($popup.length === 0) {
				log('[YAPopups] Popup not found:', popupId);
				return;
			}

			// Add scrollbar compensation to prevent page shift
			const scrollbarWidth = getScrollbarWidth();
			$('body').css('padding-right', scrollbarWidth + 'px');
			$('body').addClass('yapopups-popup-open');

			$popup.addClass('active');

			log('[YAPopups] Popup opened:', popupId);

			// Handler for closing popup
			$popup.find('.yapopups-popup__close').off('click').on('click', function() {
				closePopup(popupId);
			});
		}

		// Function to close popup
		function closePopup( popupId ) {
			log('[YAPopups] Closing popup:', popupId);

			const $popup = $(popupId);
			$popup.removeClass('active');
			$('body').removeClass('yapopups-popup-open');
			$('body').css('padding-right', '');

			log('[YAPopups] Popup closed:', popupId);

			if (window.location.hash === popupId) {
				history.pushState("", document.title, window.location.pathname + window.location.search);
			}
		}

		// Handler for opening popup via anchor links (using event delegation)
		$(document).on('click', 'a[href*="#yapopup"]', function(e) {
			log('[YAPopups] Anchor clicked:', $(this).attr('href'));

			const href = $(this).attr('href');
			if (!href) {
				return;
			}

			const $target = $(href);
			const elementById = document.getElementById(href.substring(1));

			if ($target.length && $target.hasClass('yapopups-popup')) {
				e.preventDefault();
				e.stopPropagation();
				openPopup(href);
			} else if (elementById && elementById.classList.contains('yapopups-popup')) {
				e.preventDefault();
				e.stopPropagation();
				openPopup(href);
			}
		});

		// Handler for clicking outside popup
		$(document).on('click', function(e) {
			log('[YAPopups] Document clicked');

			if ($(e.target).hasClass('yapopups-popup')) {
				log('[YAPopups] Clicked outside popup, closing active popups');
				$('.yapopups-popup').each(function() {
					if ($(this).hasClass('active')) {
						closePopup('#' + $(this).attr('id'));
					}
				});
			}
		});

		// Check hash on page load
		function checkHash() {
			log('[YAPopups] Checking hash');
			const hash = window.location.hash;
			if (hash && hash.startsWith('#yapopup')) {
				log('[YAPopups] Hash matches popup:', hash);
				const $popup = $(hash);
				if ($popup.length && $popup.hasClass('yapopups-popup')) {
					openPopup(hash);
				}
			}
		}

		// Listen for hash changes
		$(window).on('hashchange', function() {
			log('[YAPopups] Hash changed');
			checkHash();
		});

		// Initial check
		checkHash();
	}

	// Initialize on document ready
	$(document).ready(function() {
		log('[YAPopups] Initializing, debug:', yapopupsData.debug);
		yapopupsPopup();
	});

})(jQuery);
