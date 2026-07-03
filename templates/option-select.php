<?php
/**
 * Select dropdown field template.
 *
 * Variables set before include:
 *   $args  - array with 'id', 'name', 'options' (key => label)
 *   $value - string (selected value)
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<select id="<?php echo esc_attr( $args['id'] ); ?>"
        name="<?php echo esc_attr( $args['name'] ); ?>"
        class="regular-text">
    <?php foreach ( $args['options'] as $option_value => $option_label ) : ?>
        <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $value, $option_value ); ?>>
            <?php echo esc_html( $option_label ); ?>
        </option>
    <?php endforeach; ?>
</select>
