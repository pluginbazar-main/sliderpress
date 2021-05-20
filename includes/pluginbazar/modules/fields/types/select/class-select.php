<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_select
 */
class Field_select {

	/**
	 * Field_select instance
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
        <select name="<?php echo esc_attr( $field->id ); ?>" id="<?php echo esc_attr( $field->unique_id ); ?>" <?php $field->is_disabled(); ?> <?php $field->is_required(); ?>>
			<?php foreach ( $field->get_options() as $key => $label ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php $field->is_current_option( $key ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
        </select>
		<?php

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_select|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}