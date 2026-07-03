<?php
/**
 * Admin settings page with Settings API.
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

namespace MyPlugin;

final class Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ], 20 );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_filter( 'plugin_action_links_' . MYPLUGIN_PLUGIN_BASENAME, [ $this, 'add_plugin_action_links' ] );
        add_action( 'admin_notices', [ $this, 'settings_notice' ] );
    }

    public function add_admin_menu(): void {
        add_submenu_page(
            'edit.php?post_type=' . MYPLUGIN_CPT_SLUG,
            __( 'Settings', 'my-plugin' ),
            __( 'Settings', 'my-plugin' ),
            'manage_options',
            'myplugin-settings',
            [ $this, 'render_settings_page' ]
        );
    }

    public function register_settings(): void {
        register_setting( 'myplugin_settings_group', 'myplugin_enable', [
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'default'           => true,
        ] );

        register_setting( 'myplugin_settings_group', 'myplugin_debug_mode', [
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'default'           => false,
        ] );

        register_setting( 'myplugin_settings_group', 'myplugin_heading_text', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => __( 'Welcome', 'my-plugin' ),
        ] );

        register_setting( 'myplugin_settings_group', 'myplugin_items_per_page', [
            'type'              => 'integer',
            'sanitize_callback' => 'absint',
            'default'           => 10,
        ] );

        register_setting( 'myplugin_settings_group', 'myplugin_display_style', [
            'type'              => 'string',
            'sanitize_callback' => [ $this, 'sanitize_display_style' ],
            'default'           => 'inline',
        ] );

        register_setting( 'myplugin_settings_group', 'myplugin_accent_color', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_hex_color',
            'default'           => '#0073aa',
        ] );

        register_setting( 'myplugin_settings_group', 'myplugin_custom_css', [
            'type'              => 'string',
            'sanitize_callback' => 'wp_strip_all_tags',
            'default'           => '',
        ] );

        register_setting( 'myplugin_settings_group', 'myplugin_remove_data_on_uninstall', [
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'default'           => false,
        ] );

        add_settings_section(
            'myplugin_general_section',
            __( 'General Settings', 'my-plugin' ),
            [ $this, 'render_section_description' ],
            'myplugin-settings'
        );

        add_settings_field(
            'myplugin_enable',
            __( 'Enable Frontend Output', 'my-plugin' ),
            [ $this, 'render_checkbox_field' ],
            'myplugin-settings',
            'myplugin_general_section',
            [
                'label' => __( 'Enable frontend rendering of items', 'my-plugin' ),
                'id'    => 'myplugin_enable',
                'name'  => 'myplugin_enable',
            ]
        );

        add_settings_field(
            'myplugin_heading_text',
            __( 'Heading Text', 'my-plugin' ),
            [ $this, 'render_text_field' ],
            'myplugin-settings',
            'myplugin_general_section',
            [
                'id'          => 'myplugin_heading_text',
                'name'        => 'myplugin_heading_text',
                'placeholder' => __( 'Enter heading text', 'my-plugin' ),
            ]
        );

        add_settings_field(
            'myplugin_items_per_page',
            __( 'Items Per Page', 'my-plugin' ),
            [ $this, 'render_number_field' ],
            'myplugin-settings',
            'myplugin_general_section',
            [
                'id'    => 'myplugin_items_per_page',
                'name'  => 'myplugin_items_per_page',
                'min'   => 1,
                'max'   => 100,
                'step'  => 1,
            ]
        );

        add_settings_field(
            'myplugin_display_style',
            __( 'Display Style', 'my-plugin' ),
            [ $this, 'render_select_field' ],
            'myplugin-settings',
            'myplugin_general_section',
            [
                'id'     => 'myplugin_display_style',
                'name'   => 'myplugin_display_style',
                'options' => [
                    'inline' => __( 'Inline', 'my-plugin' ),
                    'modal'  => __( 'Modal', 'my-plugin' ),
                    'popup'  => __( 'Popup', 'my-plugin' ),
                ],
            ]
        );

        add_settings_field(
            'myplugin_accent_color',
            __( 'Accent Color', 'my-plugin' ),
            [ $this, 'render_color_field' ],
            'myplugin-settings',
            'myplugin_general_section',
            [
                'id'   => 'myplugin_accent_color',
                'name' => 'myplugin_accent_color',
            ]
        );

        add_settings_field(
            'myplugin_custom_css',
            __( 'Custom CSS', 'my-plugin' ),
            [ $this, 'render_textarea_field' ],
            'myplugin-settings',
            'myplugin_general_section',
            [
                'id'          => 'myplugin_custom_css',
                'name'        => 'myplugin_custom_css',
                'placeholder' => __( 'Enter custom CSS rules...', 'my-plugin' ),
                'rows'        => 6,
            ]
        );

        add_settings_field(
            'myplugin_debug_mode',
            __( 'Debug Mode', 'my-plugin' ),
            [ $this, 'render_checkbox_field' ],
            'myplugin-settings',
            'myplugin_general_section',
            [
                'label' => __( 'Enable debug logging in browser console', 'my-plugin' ),
                'id'    => 'myplugin_debug_mode',
                'name'  => 'myplugin_debug_mode',
            ]
        );

        add_settings_field(
            'myplugin_remove_data_on_uninstall',
            __( 'Data Cleanup', 'my-plugin' ),
            [ $this, 'render_checkbox_field' ],
            'myplugin-settings',
            'myplugin_general_section',
            [
                'label' => __( 'Remove all plugin data on uninstall', 'my-plugin' ),
                'id'    => 'myplugin_remove_data_on_uninstall',
                'name'  => 'myplugin_remove_data_on_uninstall',
            ]
        );
    }

    public function render_section_description(): void {
        echo '<p>' . esc_html__( 'Configure the behaviour and appearance of My Plugin.', 'my-plugin' ) . '</p>';
    }

    public function render_checkbox_field( array $args ): void {
        $value = (bool) get_option( $args['id'], false );
        include MYPLUGIN_PLUGIN_DIR . 'templates/option-checkbox.php';
    }

    public function render_text_field( array $args ): void {
        $value = get_option( $args['id'], '' );
        include MYPLUGIN_PLUGIN_DIR . 'templates/option-text.php';
    }

    public function render_number_field( array $args ): void {
        $value = (int) get_option( $args['id'], 10 );
        include MYPLUGIN_PLUGIN_DIR . 'templates/option-text.php';
    }

    public function render_select_field( array $args ): void {
        $value = get_option( $args['id'], 'inline' );
        include MYPLUGIN_PLUGIN_DIR . 'templates/option-select.php';
    }

    public function render_color_field( array $args ): void {
        $value = get_option( $args['id'], '#0073aa' );
        include MYPLUGIN_PLUGIN_DIR . 'templates/option-text.php';
    }

    public function render_textarea_field( array $args ): void {
        $value = get_option( $args['id'], '' );
        include MYPLUGIN_PLUGIN_DIR . 'templates/option-text.php';
    }

    public function render_settings_page(): void {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to access this page.', 'my-plugin' ) );
        }

        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'myplugin_settings_group' );
                do_settings_sections( 'myplugin-settings' );
                submit_button();
                ?>
            </form>

            <hr>

            <h2><?php esc_html_e( 'Published Items', 'my-plugin' ); ?></h2>
            <?php $this->render_published_items(); ?>

            <hr>

            <h2><?php esc_html_e( 'How to Use', 'my-plugin' ); ?></h2>
            <div class="notice notice-info inline">
                <p>
                    <?php echo wp_kses_post(
                        sprintf(
                            /* translators: %s: CPT slug example */
                            __( 'Create items under <strong>My Plugin → Add New</strong>. Use the slug <code>%s</code> followed by the item ID (e.g. <code>%s1</code>) to reference items in your theme templates.', 'my-plugin' ),
                            '#' . MYPLUGIN_CPT_SLUG,
                            '#' . MYPLUGIN_CPT_SLUG
                        )
                    ); ?>
                </p>
            </div>
        </div>
        <?php
    }

    public function add_plugin_action_links( array $links ): array {
        $settings_link = sprintf(
            '<a href="%s">%s</a>',
            esc_url( admin_url( 'edit.php?post_type=' . MYPLUGIN_CPT_SLUG . '&page=myplugin-settings' ) ),
            esc_html__( 'Settings', 'my-plugin' )
        );
        array_unshift( $links, $settings_link );
        return $links;
    }

    public function settings_notice(): void {
        settings_errors( 'myplugin_settings_group' );
    }

    public function sanitize_display_style( string $value ): string {
        $allowed = [ 'inline', 'modal', 'popup' ];
        return in_array( $value, $allowed, true ) ? $value : 'inline';
    }

    private function render_published_items(): void {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $items = get_posts(
            [
                'post_type'      => MYPLUGIN_CPT_SLUG,
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'fields'         => 'ids',
            ]
        );

        if ( empty( $items ) ) {
            echo '<p>' . esc_html__( 'No published items yet.', 'my-plugin' ) . '</p>';
            return;
        }

        echo '<p>' . esc_html(
            sprintf(
                /* translators: %d: number of published items */
                __( 'You have %d published item(s).', 'my-plugin' ),
                count( $items )
            )
        ) . '</p>';

        echo '<ul>';
        foreach ( $items as $item_id ) {
            echo '<li><code>#' . esc_attr( MYPLUGIN_CPT_SLUG . $item_id ) . '</code></li>';
        }
        echo '</ul>';
    }
}
