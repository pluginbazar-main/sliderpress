<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

use Pluginbazar\Fields;
use Pluginbazar\Main;
use Pluginbazar\Utils;

/**
 * Class Field_repeater
 */
class Field_repeater {

	/**
	 * Field_repeater instance
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
		printf( '<div class="repeater-items">' );

		foreach ( $field->value as $index => $value ) {

			$value = ! is_array( $value ) ? array() : $value;
			foreach ( $fields = $field->fields as $i => $f ) {
				$fields[ $i ]['value'] = Utils::get_args_option( Utils::get_args_option( 'id', $f ), $value );
			}

			self::render_repeater_item(
				array(
					'parent_id' => $field->id,
					'index'     => (int) $index,
					'fields'    => $fields,
				)
			);
		}

		printf( '</div>' );
		printf( '<div class="button button-primary pluginbazar-repeater-add" data-parent-id="%s">%s</div>', $field->id, esc_html__( 'Add new' ) );

		$field->output( ob_get_clean() );
	}


	/**
	 * Render repeater item
	 *
	 * @param array $item
	 */
	private static function render_repeater_item( array $item ) {

		$allowed_fields = Fields::get_fields();
		$parent_id      = Utils::get_args_option( 'parent_id', $item );

		?>
        <div class="repeater-item">
            <div class="fields">
				<?php foreach ( Utils::get_args_option( 'fields', $item ) as $nested_field ) {
					if ( in_array( $type = Utils::get_args_option( 'type', $nested_field ), $allowed_fields ) ) {
						$nested_field['id'] = sprintf( '%s[%s][%s]', $parent_id, (int) Utils::get_args_option( 'index', $item ), $nested_field['id'] );
						call_user_func( array( sprintf( 'Pluginbazar\Fields\Field_%s', $type ), 'render' ), new Field( $nested_field ) );
					}
				} ?>
            </div>
            <div class="controls">
                <div class="control close"><img src="<?php echo esc_url( Main::get_image( 'close' ) ); ?>" alt="<?php echo esc_attr( 'Close' ); ?>"></div>
                <div class="control copy"><img src="<?php echo esc_url( Main::get_image( 'copy' ) ); ?>" alt="<?php echo esc_attr( 'Copy' ); ?>"></div>
                <div class="control drag"><img src="<?php echo esc_url( Main::get_image( 'drag' ) ); ?>" alt="<?php echo esc_attr( 'Drag' ); ?>"></div>
            </div>
        </div>
		<?php
	}


	/**
	 * @return Field_repeater|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}