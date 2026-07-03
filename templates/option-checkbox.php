<?php
/**
 * Checkbox field template.
 *
 * Variables set before include:
 *   $args  - array with 'id', 'name', 'label'
 *   $value - bool
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<label>
    <input type="checkbox"
           id="<?php echo esc_attr( $args['id'] ); ?>"
           name="<?php echo esc_attr( $args['name'] ); ?>"
           value="1"
        <?php checked( $value, true ); ?>
    />
    <?php echo esc_html( $args['label'] ?? '' ); ?>
</label>
