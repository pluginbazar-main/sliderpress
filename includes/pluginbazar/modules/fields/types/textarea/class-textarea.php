<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_textarea
 */
class Field_textarea {

	/**
	 * Field_textarea instance
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
        <textarea
            <?php $field->is_disabled(); ?>
			<?php $field->is_required(); ?>
            name="<?php echo esc_attr( $field->id ); ?>"
            id="<?php echo esc_attr( $field->unique_id ); ?>"
            cols="<?php echo esc_attr( $field->cols ); ?>"
            rows="<?php echo esc_attr( $field->rows ); ?>"
            placeholder="<?php echo esc_attr( $field->placeholder ); ?>"><?php echo esc_attr( $field->value ); ?></textarea>
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_textarea|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}