<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 * @doc https://select2.org/
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_select2
 */
class Field_select2 {

	/**
	 * Field_select2 instance
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

		wp_enqueue_style( 'pluginbazar-select2' );
		wp_enqueue_script( 'pluginbazar-select2' );

		$defaults = array(
			'placeholder' => $field->placeholder,
		);

		ob_start();

		?>
        <select name="<?php echo esc_attr( $field->id ); ?><?php echo esc_attr( $field->multiple ? '[]' : '' ); ?>" <?php $field->is_multiple(); ?> id="<?php echo esc_attr( $field->unique_id ); ?>" <?php $field->is_disabled(); ?> <?php $field->is_required(); ?>>
			<?php foreach ( $field->get_options() as $key => $label ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php $field->is_current_option( $key ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
        </select>

        <script>
            jQuery(document).ready(function ($) {
                $("#<?php echo esc_attr( $field->unique_id ); ?>").select2(<?php $field->field_args( $defaults ); ?>);
            });
        </script>
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_select2|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}