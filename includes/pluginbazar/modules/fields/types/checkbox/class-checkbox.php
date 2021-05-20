<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

/**
 * Class Field_checkbox
 */
class Field_checkbox {

	/**
	 * Field_checkbox instance
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
            <label for="<?php echo esc_attr( $field->unique_id . $key ); ?>">
                <input type="checkbox"
					<?php $field->is_disabled(); ?>
					<?php $field->is_required(); ?>
					<?php $field->is_current_option( $key ); ?>
                       id="<?php echo esc_attr( $field->unique_id . $key ); ?>"
                       name="<?php echo esc_attr( $field->id ); ?>[]"
                       value="<?php echo esc_attr( $key ); ?>">
				<?php echo esc_html( $label ); ?>
            </label>
			<?php
		}

		$field->output( ob_get_clean() );
	}


	/**
	 * @return Field_checkbox|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}