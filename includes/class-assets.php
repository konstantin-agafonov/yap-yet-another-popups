<?php
/**
 * Frontend asset enqueuing.
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

namespace MyPlugin;

final class Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    public function enqueue_assets(): void {
        if ( ! $this->is_enabled() ) {
            return;
        }

        wp_enqueue_style(
            'myplugin',
            MYPLUGIN_PLUGIN_URL . 'assets/css/plugin.css',
            [],
            MYPLUGIN_VERSION
        );

        wp_enqueue_script(
            'myplugin',
            MYPLUGIN_PLUGIN_URL . 'assets/js/plugin.js',
            [ 'jquery' ],
            MYPLUGIN_VERSION,
            true
        );

        wp_localize_script(
            'myplugin',
            'mypluginData',
            [
                'debug' => (bool) get_option( 'myplugin_debug_mode', false ),
            ]
        );
    }

    private function is_enabled(): bool {
        return (bool) get_option( 'myplugin_enable', true );
    }
}
