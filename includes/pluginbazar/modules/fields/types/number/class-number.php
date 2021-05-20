<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_number
 */
class Field_number {

	/**
	 * Field_number instance
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
        <input type="number"
	        <?php $field->is_disabled(); ?>
	        <?php $field->is_required(); ?>
               id="<?php echo esc_html( $field->unique_id ); ?>"
               name="<?php echo esc_html( $field->id ); ?>"
               value="<?php echo esc_html( $field->value ); ?>"
               placeholder="<?php echo esc_html( $field->placeholder ); ?>">
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_number|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}