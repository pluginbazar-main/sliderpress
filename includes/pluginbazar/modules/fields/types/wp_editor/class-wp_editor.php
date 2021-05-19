<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

use Pluginbazar\Main;
use Pluginbazar\Utils;

/**
 * Class Field_wp_editor
 */
class Field_wp_editor {

	/**
	 * Field_wp_editor instance
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

		wp_editor( $field->value, $field->id, self::get_settings( $field->args ) );

		Main::add_style( '.wp-switch-editor', array( 'height' => '30px' ) );

		$field->output( ob_get_clean() );
	}


	/**
	 * Return wp_editor settings
	 *
	 * @param array $args
	 *
	 * @return array|object
	 */
	private static function get_settings( array $args = array() ) {
		$defaults = array(
			'textarea_rows' => 8,
		);

		return wp_parse_args( $defaults, $args );
	}


	/**
	 * @return Field_wp_editor|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}