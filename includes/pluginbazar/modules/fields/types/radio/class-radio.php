<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_radio
 */
class Field_radio {

	/**
	 * Field_radio instance
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

		foreach ( $field->get_options() as $key => $label ) {
			?>
            <label for="<?php echo esc_attr( $field->id . $key ); ?>">
                <input type="radio"
					<?php $field->is_disabled(); ?>
					<?php $field->is_required(); ?>
					<?php $field->is_current_option( $key ); ?>
                       id="<?php echo esc_attr( $field->id . $key ); ?>"
                       name="<?php echo esc_attr( $field->id ); ?>"
                       value="<?php echo esc_attr( $key ); ?>">
				<?php echo esc_html( $label ); ?>
            </label>
			<?php
		}

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_radio|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}