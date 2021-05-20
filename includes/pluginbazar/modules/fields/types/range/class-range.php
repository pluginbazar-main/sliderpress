<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_range
 */
class Field_range {

	/**
	 * Field_range instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	/**
	 * Render the field output
	 *
	 * @param Field $field
	 */
	public static function render( Field $field ) {

		ob_start();

		?>
        <input type="range"
			<?php $field->is_disabled(); ?>
			<?php $field->is_required(); ?>
               min="<?php echo esc_attr( $field->min ); ?>"
               max="<?php echo esc_attr( $field->max ); ?>"
               name="<?php echo esc_attr( $field->id ); ?>"
               id="<?php echo esc_attr( $field->unique_id ); ?>"
               value="<?php echo esc_attr( $field->value ); ?>">
        <span id="<?php echo esc_attr( $field->unique_id ); ?>_show_value"><?php echo esc_html( $field->value ); ?></span>

        <script>
            jQuery(document).ready(function ($) {
                $('#<?php echo esc_attr( $field->unique_id ); ?>').on('input', function (e) {
                    $('#<?php echo esc_attr( $field->unique_id ); ?>_show_value').html($('#<?php echo esc_attr( $field->unique_id ); ?>').val());
                });
            })
        </script>
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_range|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}