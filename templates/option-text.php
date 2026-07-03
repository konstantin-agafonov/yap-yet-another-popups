<?php
/**
 * Text / number / color / textarea field template.
 *
 * Determines field type from $args context.
 *
 * Variables set before include:
 *   $args  - array with 'id', 'name', 'placeholder', 'rows', 'min', 'max', 'step'
 *   $value - mixed
 *
 * @package MyPlugin
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$field_id    = $args['id'] ?? '';
$field_name  = $args['name'] ?? '';
$placeholder = $args['placeholder'] ?? '';
$is_textarea = isset( $args['rows'] );
$is_number   = isset( $args['min'] ) || isset( $args['max'] );
$is_color    = str_contains( $field_id, 'color' );

if ( $is_textarea ) : ?>
    <textarea id="<?php echo esc_attr( $field_id ); ?>"
              name="<?php echo esc_attr( $field_name ); ?>"
              class="large-text"
              rows="<?php echo esc_attr( (string) $args['rows'] ); ?>"
              placeholder="<?php echo esc_attr( $placeholder ); ?>"
    ><?php echo esc_textarea( (string) $value ); ?></textarea>
<?php elseif ( $is_color ) : ?>
    <input type="color"
           id="<?php echo esc_attr( $field_id ); ?>"
           name="<?php echo esc_attr( $field_name ); ?>"
           value="<?php echo esc_attr( (string) $value ); ?>"
    />
    <code><?php echo esc_html( (string) $value ); ?></code>
<?php elseif ( $is_number ) : ?>
    <input type="number"
           id="<?php echo esc_attr( $field_id ); ?>"
           name="<?php echo esc_attr( $field_name ); ?>"
           value="<?php echo esc_attr( (string) $value ); ?>"
           class="small-text"
           min="<?php echo esc_attr( (string) ( $args['min'] ?? '' ) ); ?>"
           max="<?php echo esc_attr( (string) ( $args['max'] ?? '' ) ); ?>"
           step="<?php echo esc_attr( (string) ( $args['step'] ?? '1' ) ); ?>"
    />
<?php else : ?>
    <input type="text"
           id="<?php echo esc_attr( $field_id ); ?>"
           name="<?php echo esc_attr( $field_name ); ?>"
           value="<?php echo esc_attr( (string) $value ); ?>"
           class="regular-text"
           placeholder="<?php echo esc_attr( $placeholder ); ?>"
    />
<?php endif; ?>
