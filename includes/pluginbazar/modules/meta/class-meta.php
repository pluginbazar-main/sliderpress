<?php
/**
 * Settings class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar;

use Pluginbazar\Pluginbazar_main;
use Pluginbazar\Pluginbazar_utils;
use WP_Post;

/**
 * Class Pluginbazar_meta
 */
class Pluginbazar_meta {

	/**
	 * Pluginbazar_meta instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	private static $_meta_boxes = array();


	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
	}


	/**
	 * Render metabox data
	 *
	 * @param WP_Post $post
	 */
	public function render_metabox( \WP_Post $post ) {

		ob_start();
		$index = 0;
		foreach ( $this->get_sections() as $section ) {
			Fields::render_sections( array_merge( array( 'index' => $index ), $section ) );
			$index ++;
		}

		printf( '<div class="pluginbazar-metabox"><ul class="tabs">%s</ul><div class="tab-contents">%s</div></div>',
			implode( ' ', $this->get_tabs() ), ob_get_clean()
		);

		// Adding CSS
		Pluginbazar_main::add_style( sprintf( '#%s', $this->get_metabox_id() ), array( 'border' => 'none', 'background-color' => 'transparent' ) );
		Pluginbazar_main::add_style( sprintf( '#%s .postbox-header', $this->get_metabox_id() ), array( 'display' => 'none' ) );
		Pluginbazar_main::add_style( sprintf( '#%s .inside', $this->get_metabox_id() ), array( 'margin' => '0', 'padding' => 0 ) );
	}


	/**
	 * Return tabs as array of HTML
	 *
	 * @return array
	 */
	public function get_tabs(): array {

		$tabs  = array();
		$index = 0;

		foreach ( $this->get_sections() as $section ) {
			$tabs[] = sprintf( '<li class="item-%1$s %3$s" data-target="%1$s"><a href="#%1$s">%2$s</a></li>',
				Pluginbazar_utils::get_args_option( 'id', $section ),
				Pluginbazar_utils::get_args_option( 'label', $section ),
				$index == 0 ? 'active' : ''
			);
			$index ++;
		}

		return $tabs;
	}


	/**
	 * Return sections for current meta screen
	 *
	 * @return array|mixed|string
	 */
	private function get_sections() {

		global $current_screen;

		$sections = array();

		foreach ( self::$_meta_boxes as $meta_box ) {
			if ( Pluginbazar_utils::get_args_option( 'post_type', $meta_box ) == $current_screen->post_type ) {
				$sections = Pluginbazar_utils::get_args_option( 'sections', $meta_box );
				break;
			}
		}

		return $sections;
	}


	/**
	 * Return metabox ID
	 *
	 * @return int|string
	 */
	private function get_metabox_id() {
		global $current_screen;

		$metabox_id = '';

		foreach ( self::$_meta_boxes as $id => $meta_box ) {
			if ( Pluginbazar_utils::get_args_option( 'post_type', $meta_box ) == $current_screen->post_type ) {
				$metabox_id = $id;
				break;
			}
		}

		return $metabox_id;
	}


	/**
	 * Add metabox section
	 *
	 * @param string $metabox_id
	 * @param array $section
	 */
	public static function add_section( string $metabox_id, array $section = array() ) {

		$sections = array();

		if ( isset( self::$_meta_boxes[ $metabox_id ]['sections'] ) && ! empty( $sections = self::$_meta_boxes[ $metabox_id ]['sections'] ) ) {
			$sections = self::$_meta_boxes[ $metabox_id ]['sections'];
		}

		$sections += $section;

		self::$_meta_boxes[ $metabox_id ]['sections'][] = $sections;
	}


	/**
	 * Add meta boxes
	 */
	public function add_meta_boxes() {
		foreach ( self::$_meta_boxes as $meta_box_id => $meta_box ) {
			add_meta_box( $meta_box_id, Pluginbazar_utils::get_args_option( 'title', $meta_box ), array( $this, 'render_metabox' ),
				Pluginbazar_utils::get_args_option( 'post_type', $meta_box ),
				Pluginbazar_utils::get_args_option( 'context', $meta_box ),
				Pluginbazar_utils::get_args_option( 'priority', $meta_box )
			);
		}
	}


	/**
	 * Add meta box
	 *
	 * @param $id
	 * @param $post_type
	 * @param string $title
	 * @param string $context
	 * @param string $priority
	 */
	public static function register_meta_box( $id, $post_type, string $title = '', string $context = 'normal', string $priority = 'high' ) {

		self::$_meta_boxes[ $id ] = array(
			'title'     => empty( $title ) ? sprintf( esc_html( '%s Data' ), ucfirst( $post_type ) ) : $title,
			'post_type' => $post_type,
			'context'   => $context,
			'priority'  => $priority,
		);
	}


	/**
	 * Return Post Meta Value
	 *
	 * @param string $meta_key
	 * @param bool $post_id
	 * @param string|array $default
	 *
	 * @return mixed|string|void
	 */
	function get_meta( string $meta_key = '', bool $post_id = false, $default = '', string $type = 'post', bool $single = true ) {

		$post_id    = ! $post_id ? get_the_ID() : $post_id;
		$meta_value = get_metadata( $type, $post_id, $meta_key, $single );
		$meta_value = empty( $meta_value ) ? $default : $meta_value;

		return apply_filters( 'pluginbazar_get_meta', $meta_value, $meta_key, $post_id, $default );
	}


	/**
	 * @return Pluginbazar_meta|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}