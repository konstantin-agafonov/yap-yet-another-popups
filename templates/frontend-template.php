<?php
/**
 * Frontend output template for a single item.
 *
 * Variables passed from Renderer:
 *   $item           - WP_Post object
 *   $item_slug      - string (e.g. "#myplugin_item1")
 *   $item_title     - string
 *   $item_content   - string (raw content with shortcodes)
 *   $debug_enabled  - bool
 *   $display_style  - string (inline|modal|popup)
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div id="<?php echo esc_attr( ltrim( $item_slug, '#' ) ); ?>" class="myplugin-item myplugin-item--<?php echo esc_attr( $display_style ); ?>">
    <div class="myplugin-item__body">

        <?php if ( in_array( $display_style, [ 'modal', 'popup' ], true ) ) : ?>
            <button class="myplugin-item__close" type="button" aria-label="<?php esc_attr_e( 'Close', 'my-plugin' ); ?>">&times;</button>
        <?php endif; ?>

        <?php if ( $item_title ) : ?>
            <h3 class="myplugin-item__title"><?php echo esc_html( $item_title ); ?></h3>
        <?php endif; ?>

        <div class="myplugin-item__content">
            <?php echo do_shortcode( wp_kses_post( $item_content ) ); ?>
        </div>

    </div>
</div>
<?php if ( $debug_enabled ) : ?>
<!-- MyPlugin: rendered <?php echo esc_html( $item_slug ); ?> -->
<?php endif; ?>
