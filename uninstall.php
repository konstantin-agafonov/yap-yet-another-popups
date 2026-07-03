<?php
/**
 * Uninstall handler.
 *
 * Removes plugin data (posts + options) if configured.
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

$remove_data = (bool) get_option( 'myplugin_remove_data_on_uninstall', false );

if ( ! $remove_data ) {
    return;
}

if ( ! defined( 'MYPLUGIN_CPT_SLUG' ) ) {
    define( 'MYPLUGIN_CPT_SLUG', 'myplugin_item' );
}

$items = get_posts(
    [
        'post_type'      => MYPLUGIN_CPT_SLUG,
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ]
);

foreach ( $items as $item_id ) {
    wp_delete_post( $item_id, true );
}

$options = [
    'myplugin_enable',
    'myplugin_debug_mode',
    'myplugin_heading_text',
    'myplugin_items_per_page',
    'myplugin_display_style',
    'myplugin_accent_color',
    'myplugin_custom_css',
    'myplugin_rules_flushed',
    'myplugin_remove_data_on_uninstall',
];

foreach ( $options as $option ) {
    delete_option( $option );
}
