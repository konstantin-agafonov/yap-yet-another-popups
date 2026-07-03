<?php
/**
 * Custom Post Type registration.
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

namespace MyPlugin;

final class CPT {

    public function __construct() {
        add_action( 'init', [ $this, 'register_post_type' ], 0 );
        add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
        add_filter( 'manage_' . MYPLUGIN_CPT_SLUG . '_posts_columns', [ $this, 'custom_columns' ] );
        add_action( 'manage_' . MYPLUGIN_CPT_SLUG . '_posts_custom_column', [ $this, 'custom_column_content' ], 10, 2 );
        add_action( 'admin_init', [ $this, 'maybe_flush_rewrite_rules' ] );
    }

    public function register_post_type(): void {
        $labels = [
            'name'                  => _x( 'Items', 'post type general name', 'my-plugin' ),
            'singular_name'         => _x( 'Item', 'post type singular name', 'my-plugin' ),
            'add_new'               => __( 'Add New', 'my-plugin' ),
            'add_new_item'          => __( 'Add New Item', 'my-plugin' ),
            'edit_item'             => __( 'Edit Item', 'my-plugin' ),
            'new_item'              => __( 'New Item', 'my-plugin' ),
            'view_item'             => __( 'View Item', 'my-plugin' ),
            'search_items'          => __( 'Search Items', 'my-plugin' ),
            'not_found'             => __( 'No items found', 'my-plugin' ),
            'not_found_in_trash'    => __( 'No items found in Trash', 'my-plugin' ),
            'all_items'             => __( 'All Items', 'my-plugin' ),
            'menu_name'             => __( 'My Plugin', 'my-plugin' ),
        ];

        $args = [
            'labels'              => $labels,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-admin-generic',
            'supports'            => [ 'title', 'editor', 'thumbnail' ],
            'show_in_rest'        => true,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'has_archive'         => false,
        ];

        register_post_type( MYPLUGIN_CPT_SLUG, $args );
    }

    public function add_meta_box(): void {
        add_meta_box(
            'myplugin_item_slug_box',
            __( 'Item Slug', 'my-plugin' ),
            [ $this, 'render_meta_box' ],
            MYPLUGIN_CPT_SLUG,
            'side',
            'high'
        );
    }

    public function render_meta_box( \WP_Post $post ): void {
        wp_nonce_field( 'myplugin_item_slug_box', 'myplugin_item_slug_box_nonce' );

        $slug = '#' . MYPLUGIN_CPT_SLUG . $post->ID;
        echo '<p><code>' . esc_html( $slug ) . '</code></p>';
        echo '<p class="description">' . esc_html__( 'Use this slug to reference this item in your templates.', 'my-plugin' ) . '</p>';
    }

    public function custom_columns( array $columns ): array {
        $new_columns = [];

        foreach ( $columns as $key => $label ) {
            $new_columns[ $key ] = $label;

            if ( 'title' === $key ) {
                $new_columns['item_slug'] = __( 'Slug', 'my-plugin' );
            }
        }

        return $new_columns;
    }

    public function custom_column_content( string $column, int $post_id ): void {
        if ( 'item_slug' === $column ) {
            echo '<code>#' . esc_attr( MYPLUGIN_CPT_SLUG . $post_id ) . '</code>';
        }
    }

    public function maybe_flush_rewrite_rules(): void {
        if ( ! get_option( 'myplugin_rules_flushed' ) ) {
            flush_rewrite_rules();
            update_option( 'myplugin_rules_flushed', true );
        }
    }
}
