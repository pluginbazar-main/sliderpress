<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_text
 */
class Field_text {

	/**
	 * Field_text instance
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
        <input type="text"
			<?php $field->is_disabled(); ?>
			<?php $field->is_required(); ?>
               id="<?php echo esc_attr( $field->unique_id ); ?>"
               name="<?php echo esc_attr( $field->id ); ?>"
               value="<?php echo esc_attr( $field->value ); ?>"
               placeholder="<?php echo esc_attr( $field->placeholder ); ?>">
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_text|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}