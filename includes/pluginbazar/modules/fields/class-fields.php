<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar;

use Pluginbazar\Fields\Field;

/**
 * Class Fields
 */
class Fields {

	/**
	 * Fields instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	function __construct() {
		self::load_fields();
	}


	public static function render_sections( array $section = array() ) {

		$allowed_fields = self::get_fields();

		ob_start();

		foreach ( Utils::get_args_option( 'fields', $section ) as $field ) {
			if ( in_array( $type = Utils::get_args_option( 'type', $field ), $allowed_fields ) ) {
				call_user_func( array( sprintf( 'Pluginbazar\Fields\Field_%s', $type ), 'render' ), new Field( $field ) );
			}
		}

		printf( '<div class="content-%s %s">%s</div>',
			Utils::get_args_option( 'id', $section ),
			Utils::get_args_option( 'index', $section ) == 0 ? 'active' : '',
			ob_get_clean()
		);
	}


	/**
	 * Load all fields
	 */
	private static function load_fields() {

		if ( ! class_exists( 'Pluginbazar\Fields\Field' ) ) {
			require_once __DIR__ . '/class-field.php';
		}

		foreach ( self::get_fields() as $field_id ) {

			$class = sprintf( 'Pluginbazar\Fields\Field_%s', $field_id );
			$file  = sprintf( '%1$s/types/%2$s/class-%2$s.php', __DIR__, $field_id );

			if ( file_exists( $file ) ) {
				require_once( $file );
				call_user_func( array( $class, 'instance' ) );
			}
		}
	}

	/**
	 * Return all fields
	 *
	 * @return string[]
	 */
	private static function get_fields(): array {

		$fields = scandir( __DIR__ . '/types' );

		array_shift( $fields );
		array_shift( $fields );


		return $fields;
	}


	/**
	 * @return Fields|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}