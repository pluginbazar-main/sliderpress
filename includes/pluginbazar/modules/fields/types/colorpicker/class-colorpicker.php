<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 * @doc https://timepicker.co/
 */

namespace Pluginbazar\Fields;

use MaxMind\Db\Reader\Util;
use Pluginbazar\Main;
use Pluginbazar\Utils;

/**
 * Class Field_colorpicker
 */
class Field_colorpicker {

	/**
	 * Field_colorpicker instance
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

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		Main::add_style( '.wp-picker-container .iris-picker', array(
			'width'  => '260px !important',
			'height' => '230px !important',
		) );

		ob_start();

		?>
        <input type="text"
			<?php $field->is_disabled(); ?>
			<?php $field->is_required(); ?>
               id="<?php echo esc_attr( $field->unique_id ); ?>"
               name="<?php echo esc_attr( $field->id ); ?>"
               value="<?php echo esc_attr( $field->value ); ?>"
               placeholder="<?php echo esc_attr( $field->placeholder ); ?>">

        <script>
            jQuery(document).ready(function ($) {
                $("#<?php echo esc_attr( $field->unique_id ); ?>").wpColorPicker( <?php $field->field_args( array() ); ?> );
            });
        </script>
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_colorpicker|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}