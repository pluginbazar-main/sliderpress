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
               id="<?php echo esc_html( $field->id ); ?>"
               name="<?php echo esc_html( $field->id ); ?>"
               placeholder="<?php echo esc_html( $field->placeholder ); ?>">
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