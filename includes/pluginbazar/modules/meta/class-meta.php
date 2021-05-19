<?php
/**
 * Settings class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar;

use Pluginbazar\Main;
use Pluginbazar\Utils;
use WP_Post;

/**
 * Class Meta
 */
class Meta {

	/**
	 * Meta instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	private static $_meta_boxes = array();


	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_data' ) );
	}


	/**
	 * Save post meta data
	 *
	 * @param int $post_id
	 */
	public function save_meta_data( int $post_id ) {

		$posted_data = wp_unslash( $_POST );

		if ( ! wp_verify_nonce( Utils::get_args_option( 'Meta_nonce', $posted_data ), self::get_metabox_id() ) ) {
			return;
		}

		foreach ( $this->get_fields() as $field_id ) {
			update_post_meta( $post_id, $field_id, Utils::get_args_option( $field_id, $posted_data ) );
		}
	}


	/**
	 * Return fields array data
	 *
	 * @return array
	 */
	private function get_fields(): array {
		$fields = array();

		foreach ( $this->get_sections() as $section ) {
			$fields = array_merge( $fields, array_map( function ( $field ) {
				return Utils::get_args_option( 'id', $field );
			}, Utils::get_args_option( 'fields', $section ) ) );
		}

		return $fields;
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

			$section = array_merge( array( 'index' => $index ), $section );

			foreach ( Utils::get_args_option( 'fields', $section, array() ) as $field_index => $field ) {
				$section['fields'][ $field_index ]['value'] = self::get_meta( Utils::get_args_option( 'id', $field ), $post->ID );
			}

			Fields::render_sections( $section );
			$index ++;
		}

		printf( '<div class="pluginbazar-metabox"><ul class="tabs">%s</ul><div class="tab-contents">%s</div></div>',
			implode( ' ', $this->get_tabs() ), ob_get_clean()
		);


		wp_nonce_field( self::get_metabox_id(), 'Meta_nonce' );

		// Adding CSS
		Main::add_style( sprintf( '#%s', $this->get_metabox_id() ), array( 'border' => 'none', 'background-color' => 'transparent' ) );
		Main::add_style( sprintf( '#%s .postbox-header', $this->get_metabox_id() ), array( 'display' => 'none' ) );
		Main::add_style( sprintf( '#%s .inside', $this->get_metabox_id() ), array( 'margin' => '0', 'padding' => 0 ) );
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
				Utils::get_args_option( 'id', $section ),
				Utils::get_args_option( 'label', $section ),
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
			if ( Utils::get_args_option( 'post_type', $meta_box ) == $current_screen->post_type ) {
				$sections = Utils::get_args_option( 'sections', $meta_box );
				break;
			}
		}

		return is_array( $sections ) ? $sections : array();
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
			if ( Utils::get_args_option( 'post_type', $meta_box ) == $current_screen->post_type ) {
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

		self::$_meta_boxes[ $metabox_id ]['sections'][ count( $sections ) ] = $section;
	}


	/**
	 * Add meta boxes
	 */
	public function add_meta_boxes() {
		foreach ( self::$_meta_boxes as $meta_box_id => $meta_box ) {
			add_meta_box( $meta_box_id, Utils::get_args_option( 'title', $meta_box ), array( $this, 'render_metabox' ),
				Utils::get_args_option( 'post_type', $meta_box ),
				Utils::get_args_option( 'context', $meta_box ),
				Utils::get_args_option( 'priority', $meta_box )
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
	 * @param int $post_id
	 * @param string|array $default
	 *
	 * @return mixed|string|void
	 */
	public static function get_meta( string $meta_key = '', int $post_id = 0, $default = '', string $type = 'post', bool $single = true ) {

		$post_id    = ! $post_id ? get_the_ID() : $post_id;
		$meta_value = get_metadata( $type, $post_id, $meta_key, $single );
		$meta_value = empty( $meta_value ) ? $default : $meta_value;

		return apply_filters( 'pluginbazar_get_meta', $meta_value, $meta_key, $post_id, $default );
	}


	/**
	 * @return Meta|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}