<?php
/**
 * Popup Custom Post Type Registration
 *
 * Registers the popup custom post type and related functionality.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class YAPOPUPS_Popup_CPT
 */
class YAPOPUPS_Popup_CPT {

	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ), 0 );
		add_action( 'init', array( $this, 'setup_admin' ), 0 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_filter( 'manage_' . YAPOPUPS_CPT_SLUG . '_posts_columns', array( $this, 'custom_columns' ) );
		add_action( 'manage_' . YAPOPUPS_CPT_SLUG . '_posts_custom_column', array( $this, 'custom_column_content' ), 10, 2 );
		add_action( 'admin_init', array( $this, 'flush_rewrite_rules' ) );
		add_action( 'after_switch_theme', array( $this, 'force_flush_rewrite_rules' ) );
	}

	/**
	 * Setup admin menu for CPT
	 */
	public function setup_admin(): void {
		add_filter( 'parent_file', array( $this, 'set_parent_file_for_settings' ) );
	}

	/**
	 * Set parent file for settings page
	 *
	 * @param string $parent_file The parent file.
	 * @return string Modified parent file.
	 */
	public function set_parent_file_for_settings( $parent_file ): string {
		global $submenu_file;

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Page comparison is safe, no form data processing.
		if ( isset( $_GET['page'] ) && 'yapopups-settings' === $_GET['page'] ) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Internal URL construction.
			$submenu_file = 'edit.php?post_type=' . YAPOPUPS_CPT_SLUG . '&page=yapopups-settings';
			$parent_file  = 'edit.php?post_type=' . YAPOPUPS_CPT_SLUG;
		}

		return $parent_file;
	}

	/**
	 * Register Popup Custom Post Type
	 */
	public function register_post_type(): void {
		$labels = array(
			'name'                  => _x( 'Popups', 'Post Type General Name', 'yap-yet-another-popups' ),
			'singular_name'         => _x( 'Popup', 'Post Type Singular Name', 'yap-yet-another-popups' ),
			'menu_name'             => __( 'YAP - Yet Another Popups', 'yap-yet-another-popups' ),
			'name_admin_bar'        => __( 'Popup', 'yap-yet-another-popups' ),
			'archives'              => __( 'Popup Archives', 'yap-yet-another-popups' ),
			'attributes'            => __( 'Popup Attributes', 'yap-yet-another-popups' ),
			'parent_item_colon'     => __( 'Parent Popup:', 'yap-yet-another-popups' ),
			'all_items'             => __( 'All Popups', 'yap-yet-another-popups' ),
			'add_new_item'          => __( 'Add New Popup', 'yap-yet-another-popups' ),
			'add_new'               => __( 'Add New', 'yap-yet-another-popups' ),
			'new_item'              => __( 'New Popup', 'yap-yet-another-popups' ),
			'edit_item'             => __( 'Edit Popup', 'yap-yet-another-popups' ),
			'update_item'           => __( 'Update Popup', 'yap-yet-another-popups' ),
			'view_item'             => __( 'View Popup', 'yap-yet-another-popups' ),
			'view_items'            => __( 'View Popups', 'yap-yet-another-popups' ),
			'search_items'          => __( 'Search Popups', 'yap-yet-another-popups' ),
			'not_found'             => __( 'Not found', 'yap-yet-another-popups' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'yap-yet-another-popups' ),
			'featured_image'        => __( 'Featured Image', 'yap-yet-another-popups' ),
			'set_featured_image'    => __( 'Set featured image', 'yap-yet-another-popups' ),
			'remove_featured_image' => __( 'Remove featured image', 'yap-yet-another-popups' ),
			'use_featured_image'    => __( 'Use as featured image', 'yap-yet-another-popups' ),
			'insert_into_item'      => __( 'Insert into popup', 'yap-yet-another-popups' ),
			'uploaded_to_this_item' => __( 'Uploaded to this popup', 'yap-yet-another-popups' ),
			'items_list'            => __( 'Popups list', 'yap-yet-another-popups' ),
			'items_list_navigation' => __( 'Popups list navigation', 'yap-yet-another-popups' ),
			'filter_items_list'     => __( 'Filter popups list', 'yap-yet-another-popups' ),
		);

		$args = array(
			'label'                 => __( 'Popup', 'yap-yet-another-popups' ),
			'description'           => __( 'Popup custom post type', 'yap-yet-another-popups' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor' ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-editor-outdent',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
		);

		register_post_type( YAPOPUPS_CPT_SLUG, $args );
	}

	/**
	 * Add custom meta box for popup slug
	 */
	public function add_meta_box(): void {
		add_meta_box(
			'yapopups_popup_slug_box',
			__( 'Popup Slug', 'yap-yet-another-popups' ),
			array( $this, 'slug_box_callback' ),
			YAPOPUPS_CPT_SLUG,
			'side',
			'high'
		);
	}

	/**
	 * Meta box callback to display popup slug
	 *
	 * @param WP_Post $post The current post object.
	 */
	public function slug_box_callback( $post ): void {
		wp_nonce_field( 'yapopups_popup_slug_box', 'yapopups_popup_slug_box_nonce' );

		$popup_slug  = YAPOPUPS_CPT_SLUG . $post->ID;
		?>
		<p>
			<label for="yapopups-popup-slug"><?php esc_html_e( 'Use this value in anchor href:', 'yap-yet-another-popups' ); ?></label>
			<input type="text"
				   id="yapopups-popup-slug"
				   value="#<?php echo esc_attr( $popup_slug ); ?>"
				   class="widefat"
				   readonly
				   onclick="this.select();" />
		</p>
		<p class="description">
			<?php esc_html_e( 'Use #', 'yap-yet-another-popups' ); ?><strong><?php echo esc_html( $popup_slug ); ?></strong> <?php esc_html_e( 'as the href value in anchor tags to open this popup.', 'yap-yet-another-popups' ); ?>
		</p>
		<p class="description">
			<?php esc_html_e( 'Example:', 'yap-yet-another-popups' ); ?>
			<code>&lt;a href="#<?php echo esc_attr( $popup_slug ); ?>"&gt;Open Popup&lt;/a&gt;</code>
		</p>
		<?php
	}

	/**
	 * Add custom column for popup slug
	 *
	 * @param array $columns Existing columns.
	 * @return array Modified columns.
	 */
	public function custom_columns( $columns ): array {
		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			$new_columns[ $key ] = $value;
			if ( 'title' === $key ) {
				$new_columns['popup_slug'] = __( 'Popup Slug', 'yap-yet-another-popups' );
			}
		}

		return $new_columns;
	}

	/**
	 * Populate custom column content
	 *
	 * @param string $column  The column name.
	 * @param int    $post_id The post ID.
	 */
	public function custom_column_content( $column, $post_id ): void {
		if ( 'popup_slug' === $column ) {
			echo '<code>#yapopup' . esc_html( $post_id ) . '</code>';
		}
	}

	/**
	 * Flush rewrite rules on admin init
	 */
	public function flush_rewrite_rules(): void {
		$flushed = get_option( 'yapopups_rules_flushed' );
		if ( ! $flushed ) {
			$this->force_flush_rewrite_rules();
			update_option( 'yapopups_rules_flushed', true );
		}
	}

	/**
	 * Force flush rewrite rules
	 */
	public function force_flush_rewrite_rules(): void {
		$this->register_post_type();
		flush_rewrite_rules();
	}
}
