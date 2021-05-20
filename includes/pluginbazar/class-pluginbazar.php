<?php
/**
 * Pluginbazar Utilities Class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar;

use Pluginbazar\Utils;
use Pluginbazar\Meta;

class Main {

	/**
	 * class Pluginbazar
	 *
	 * @var null
	 */
	protected static $_instance = null;


	/**
	 * Styles to print
	 *
	 * @var array
	 */
	protected static $_admin_styles = array();


	/**
	 * Pluginbazar constructor.
	 */
	function __construct() {
		add_action( 'init', array( $this, 'load_modules' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'admin_footer', array( $this, 'print_admin_styles' ), 99 );
	}


	/**
	 * Return all modules
	 *
	 * @return string[][]
	 */
	private static function get_modules(): array {

		return array(
			'utils'      => array( 'class' => 'Pluginbazar\Utils' ),
			'fields'     => array( 'class' => 'Pluginbazar\Fields' ),
			'meta'       => array( 'class' => 'Pluginbazar\Meta' ),
			'shortcodes' => array( 'class' => 'Pluginbazar\Shortcodes' ),
			'settings'   => array( 'class' => 'Pluginbazar\Settings' ),
		);
	}


	/**
	 * Register admin scripts
	 */
	function admin_scripts() {

		wp_enqueue_script( 'jquery-ui-sortable' );

		wp_enqueue_style( 'pluginbazar-styles', self::get_file_url( 'assets/css/style.css' ), array(), date( 'H:s' ) );
		wp_enqueue_script( 'pluginbazar-scripts', self::get_file_url( 'assets/js/scripts.js' ), array( 'jquery' ), date( 'H:s' ) );
		wp_localize_script( 'pluginbazar-scripts', 'pluginbazar', array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'confirmText' => esc_html( 'Do you really want to continue?' ),
		) );

		// For datepicker field
		wp_register_style( 'pluginbazar-datepicker', self::get_file_url( 'assets/css/datepicker.css' ) );
		wp_register_script( 'pluginbazar-moment', self::get_file_url( 'assets/js/moment.min.js' ), array( 'jquery' ) );
		wp_register_script( 'pluginbazar-datepicker', self::get_file_url( 'assets/js/datepicker.js' ), array( 'pluginbazar-moment' ) );

		// For timepicker field
		wp_register_style( 'pluginbazar-timepicker', self::get_file_url( 'assets/css/timepicker.min.css' ) );
		wp_register_script( 'pluginbazar-timepicker', self::get_file_url( 'assets/js/timepicker.min.js' ) );

		// For select2 field
		wp_register_style( 'pluginbazar-select2', self::get_file_url( 'assets/css/select2.min.css' ) );
		wp_register_script( 'pluginbazar-select2', self::get_file_url( 'assets/js/select2.min.js' ) );
	}


	/**
	 * Return file URL of current directory
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	public static function get_file_url( string $path = '' ): string {
		return is_ssl() ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . str_replace( $_SERVER['DOCUMENT_ROOT'], '', realpath( __DIR__ ) ) . ( empty( $path ) ? '' : '/' . $path );
	}


	/**
	 * Return image URL
	 *
	 * @param string $name
	 * @param string $extension
	 *
	 * @return string
	 */
	public static function get_image( string $name, string $extension = 'svg' ): string {
		return self::get_file_url( 'assets/images/' . $name . '.' . $extension );
	}


	/**
	 * Load classes
	 */
	public static function load_modules() {

		foreach ( self::get_modules() as $module_id => $module ) {

			$module_class = isset( $module['class'] ) ? $module['class'] : '';
			$module_file  = sprintf( '%1$s/modules/%2$s/class-%2$s.php', __DIR__, $module_id );

			if ( file_exists( $module_file ) ) {
				require_once( $module_file );
				call_user_func( array( $module_class, 'instance' ) );
			}
		}
	}

	/**
	 * Add style
	 *
	 * @param $selector
	 * @param array $style
	 */
	public static function add_style( $selector, array $style = array() ) {
		$added_styles = Utils::get_args_option( $selector, self::$_admin_styles, array() );
		$added_styles = ! is_array( $added_styles ) ? array() : $added_styles;

		$added_styles += $style;

		self::$_admin_styles[ $selector ] = $added_styles;
	}

	/**
	 * Printing custom styles
	 *
	 * $this->add_style( '.postbox-header', array(
	 *      'display'   => 'inline-block',
	 *      'font-size' => '12px',
	 * ) );
	 */
	public function print_admin_styles() {

		ob_start();

		foreach ( self::$_admin_styles as $selector => $style ) {
			if ( ! is_array( $style ) ) {
				continue;
			}

			$styles = array_map( function ( $v, $p ) {
				return sprintf( '%s: %s;', $p, $v );
			}, $style, array_keys( $style ) );

			printf( '%s{%s}', $selector, implode( ' ', $styles ) );
		}

		printf( '<style>%s</style>', ob_get_clean() );
	}


	/**
	 * @return Main|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}

Main::instance();