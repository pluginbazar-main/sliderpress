<?php
/**
 * Settings class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar;

/**
 * Class Shortcodes
 */
class Shortcodes {

	/**
	 * Shortcodes instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	/**
	 * Registered shortcodes
	 *
	 * @var array
	 */
	private static $_shortcodes = array();


	/**
	 * Shortcodes constructor.
	 */
	public function __construct() {
		add_action( 'init', array( __CLASS__, 'register_shortcodes' ), 99 );
	}


	/**
	 * Render shortcode content from template
	 */
	public static function render_shortcode( $args, $content, $shortcode ) {

		if ( ! empty( $callable = self::get_shortcode_data( $shortcode, 'callable' ) ) ) {
			call_user_func( $callable, $content, $args );

			return;
		}

		if ( is_array( $args ) ) {
			extract( $args );
		}

		include self::get_shortcode_data( $shortcode, 'template' );
	}


	/**
	 * Return shortcode data
	 *
	 * @param string $shortcode
	 * @param string $return
	 *
	 * @return array|mixed|string
	 */
	public static function get_shortcode_data( string $shortcode, string $return = 'all' ) {

		$this_shortcode = Utils::get_args_option( $shortcode, self::$_shortcodes );

		if ( empty( $return ) || $return == 'all' ) {
			return $this_shortcode;
		}

		return Utils::get_args_option( $return, $this_shortcode );
	}


	/**
	 * Register shortcodes
	 */
	public static function register_shortcodes() {
		foreach ( self::$_shortcodes as $shortcode => $args ) {
			add_shortcode( $shortcode, array( __CLASS__, 'render_shortcode' ) );
		}
	}


	/**
	 * Add shortcodes globally
	 *
	 * @param string $shortcode
	 * @param string $callable
	 * @param string $template
	 */
	public static function add_shortcode( string $shortcode, string $callable, string $template ) {
		self::$_shortcodes[ $shortcode ] = array(
			'callable' => $callable,
			'template' => $template,
		);
	}


	/**
	 * Add shortcode data args
	 *
	 * @param string $shortcode
	 * @param array $args
	 */
	public static function add_shortcode_args( string $shortcode, array $args ) {
		if ( is_array( $args ) && ! empty( $args ) ) {
			self::$_shortcodes[ $shortcode ]['args'] = $args;
		}
	}


	/**
	 * @return Shortcodes|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}