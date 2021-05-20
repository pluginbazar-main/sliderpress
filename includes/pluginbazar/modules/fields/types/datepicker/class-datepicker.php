<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 * @doc http://www.daterangepicker.com/
 */

namespace Pluginbazar\Fields;

use Pluginbazar\Utils;

/**
 * Class Field_datepicker
 */
class Field_datepicker {

	/**
	 * Field_datepicker instance
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

		wp_enqueue_style( 'pluginbazar-datepicker' );
		wp_enqueue_script( 'pluginbazar-datepicker' );

		$defaults = array(
			'singleDatePicker' => true,
			'autoApply'        => true,
			'drops'            => 'auto',
		);

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
                $("#<?php echo esc_attr( $field->unique_id ); ?>").daterangepicker( <?php $field->field_args( $defaults ); ?> );
            });
        </script>
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_datepicker|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}