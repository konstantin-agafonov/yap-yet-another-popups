<?php
/**
 * Plugin Name:       My Plugin
 * Plugin URI:        https://example.com/my-plugin
 * Description:       A WordPress plugin starter template with CPT, settings page, and frontend assets.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Your Name
 * Text Domain:       my-plugin
 * Domain Path:       /languages
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'MYPLUGIN_VERSION', '1.0.0' );
define( 'MYPLUGIN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MYPLUGIN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MYPLUGIN_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'MYPLUGIN_CPT_SLUG', 'myplugin_item' );

/**
 * PSR-4-like autoloader for the MyPlugin namespace.
 *
 * Maps: MyPlugin\ClassName -> includes/class-classname.php
 */
spl_autoload_register( function ( string $class ): void {
    $prefix = 'MyPlugin\\';

    if ( strncmp( $class, $prefix, strlen( $prefix ) ) !== 0 ) {
        return;
    }

    $relative_class = substr( $class, strlen( $prefix ) );
    $parts          = explode( '\\', $relative_class );
    $parts          = array_map( fn( string $part ): string => strtolower( $part ), $parts );
    $file           = MYPLUGIN_PLUGIN_DIR . 'includes/class-' . implode( '-', $parts ) . '.php';

    if ( file_exists( $file ) ) {
        require $file;
    }
} );

register_activation_hook( __FILE__, function (): void {
    flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function (): void {
    flush_rewrite_rules();
} );

final class MyPlugin_Plugin {

    private static ?self $instance = null;

    public static function get_instance(): self {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action( 'init', [ $this, 'init' ], -100 );
    }

    public function init(): void {
        $this->load_includes();
    }

    private function load_includes(): void {
        new MyPlugin\CPT();
        new MyPlugin\Assets();
        new MyPlugin\Renderer();
        new MyPlugin\Admin();
    }
}

MyPlugin_Plugin::get_instance();
