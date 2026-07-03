<?php
/**
 * Frontend rendering via wp_footer.
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

namespace MyPlugin;

final class Renderer {

    public function __construct() {
        add_action( 'wp_footer', [ $this, 'output_items' ], 999 );
    }

    public function output_items(): void {
        if ( ! (bool) get_option( 'myplugin_enable', true ) ) {
            return;
        }

        $items = get_posts(
            [
                'post_type'      => MYPLUGIN_CPT_SLUG,
                'post_status'    => 'publish',
                'posts_per_page' => (int) get_option( 'myplugin_items_per_page', -1 ),
                'orderby'        => 'date',
                'order'          => 'ASC',
            ]
        );

        if ( empty( $items ) ) {
            return;
        }

        $debug_enabled = (bool) get_option( 'myplugin_debug_mode', false );
        $display_style = get_option( 'myplugin_display_style', 'inline' );

        foreach ( $items as $item ) {
            setup_postdata( $item );

            $item_slug    = '#' . MYPLUGIN_CPT_SLUG . $item->ID;
            $item_title   = get_the_title( $item );
            $item_content = get_the_content( null, false, $item );

            include MYPLUGIN_PLUGIN_DIR . 'templates/frontend-template.php';
        }

        wp_reset_postdata();
    }
}
