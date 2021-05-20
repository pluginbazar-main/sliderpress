<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 * @doc https://timepicker.co/
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_timepicker
 */
class Field_timepicker {

	/**
	 * Field_timepicker instance
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

		wp_enqueue_style( 'pluginbazar-timepicker' );
		wp_enqueue_script( 'pluginbazar-timepicker' );

		$defaults = array(
			'showDuration' => true,
			'interval'     => '15',
		);

		ob_start();

		?>
        <input type="text" style="min-width: inherit;width: 128px;"
			<?php $field->is_disabled(); ?>
			<?php $field->is_required(); ?>
               id="<?php echo esc_attr( $field->unique_id ); ?>"
               name="<?php echo esc_attr( $field->id ); ?>"
               value="<?php echo esc_attr( $field->value ); ?>"
               placeholder="<?php echo esc_attr( $field->placeholder ); ?>">

        <script>
            jQuery(document).ready(function ($) {
                $("#<?php echo esc_attr( $field->unique_id ); ?>").timepicker( <?php $field->field_args(); ?> );
            });
        </script>
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_timepicker|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}