<?php
/**
 * Checkbox option template
 *
 * @package YAP_Yet_Another_Popups
 *
 * @var string $id    Field ID.
 * @var string $name  Field name.
 * @var bool   $value Whether checked.
 * @var string $label Label text.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<input type="checkbox"
	   id="<?php echo esc_attr( $id ); ?>"
	   name="<?php echo esc_attr( $name ); ?>"
	   value="1"
	   <?php checked( $value, true ); ?>
/>
<label for="<?php echo esc_attr( $id ); ?>">
	<?php echo esc_html( $label ); ?>
</label>
