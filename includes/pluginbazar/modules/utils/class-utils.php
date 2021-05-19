<?php
/**
 * Class Utils
 */

namespace Pluginbazar;

/**
 * Class Pluginbazar_utils
 */
class Pluginbazar_utils {

	/**
	 * Pluginbazar_utils instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	/**
	 * Registered endpoints
	 *
	 * @var array
	 */
	private static $_endpoints = array();


	/**
	 * Pluginbazar_utils constructor.
	 */
	function __construct() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_endpoints' ) );
	}


	/**
	 * Registering endpoints
	 */
	public static function add_endpoint( $route, $callback, $namespace = 'data', $method = 'GET' ) {

		if ( ! empty( $namespace ) && ! empty( $route ) && ! empty( $callback ) ) {
			self::$_endpoints[] = array(
				'namespace' => $namespace,
				'route'     => $route,
				'callback'  => $callback,
				'method'    => $method,
			);
		}
	}


	/**
	 * Register endpoints
	 */
	public static function register_endpoints() {
		foreach ( self::$_endpoints as $endpoint ) {
			register_rest_route( $endpoint['namespace'], $endpoint['route'], array(
				'methods'  => $endpoint['method'],
				'callback' => $endpoint['callback'],
			) );
		}
	}


	/**
	 * Register taxonomy
	 *
	 * @param $taxonomy
	 * @param $object_type
	 * @param $args
	 */
	public static function register_taxonomy( $taxonomy, $object_type, $args ) {

		if ( taxonomy_exists( $taxonomy ) ) {
			return;
		}

		$taxonomy_name = isset( $args['singular'] ) ? $args['singular'] : '';
		$defaults      = array(
			'labels'              => array(
				'name'               => sprintf( __( '%s' ), $taxonomy_name ),
				'singular_name'      => sprintf( __( '%s' ), $taxonomy_name ),
				'menu_name'          => __( $taxonomy_name ),
				'all_items'          => sprintf( __( '%s' ), $taxonomy_name ),
				'add_new'            => sprintf( __( 'Add %s' ), $taxonomy_name ),
				'add_new_item'       => sprintf( __( 'Add %s' ), $taxonomy_name ),
				'edit'               => __( 'Edit' ),
				'edit_item'          => sprintf( __( '%s Details' ), $taxonomy_name ),
				'new_item'           => sprintf( __( 'New %s' ), $taxonomy_name ),
				'view'               => sprintf( __( 'View %s' ), $taxonomy_name ),
				'view_item'          => sprintf( __( 'View %s' ), $taxonomy_name ),
				'search_items'       => sprintf( __( 'Search %s' ), $taxonomy_name ),
				'not_found'          => sprintf( __( 'No %s found' ), $taxonomy_name ),
				'not_found_in_trash' => sprintf( __( 'No %s found in trash' ), $taxonomy_name ),
				'parent'             => sprintf( __( 'Parent %s' ), $taxonomy_name ),
			),
			'public'              => true,
			'show_ui'             => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'hierarchical'        => true,
		);

		register_taxonomy( $taxonomy, $object_type, wp_parse_args( $args, $defaults ) );
	}


	/**
	 * Register post types
	 *
	 * @param string $post_type
	 * @param array $args
	 */
	public static function register_post_type( string $post_type, array $args = array() ) {

		$singular = self::get_args_option( 'singular', $args );
		$plural   = self::get_args_option( 'plural', $args );
		$defaults = array(
			'labels'              => array(
				'name'               => sprintf( __( '%s' ), $plural ),
				'singular_name'      => $singular,
				'menu_name'          => __( $singular ),
				'all_items'          => sprintf( __( '%s' ), $plural ),
				'add_new'            => sprintf( __( 'Add %s' ), $singular ),
				'add_new_item'       => sprintf( __( 'Add %s' ), $singular ),
				'edit'               => __( 'Edit' ),
				'edit_item'          => sprintf( __( 'Edit %s' ), $singular ),
				'new_item'           => sprintf( __( 'New %s' ), $singular ),
				'view'               => sprintf( __( 'View %s' ), $singular ),
				'view_item'          => sprintf( __( 'View %s' ), $singular ),
				'search_items'       => sprintf( __( 'Search %s' ), $plural ),
				'not_found'          => sprintf( __( 'No %s found' ), $plural ),
				'not_found_in_trash' => sprintf( __( 'No %s found in trash' ), $plural ),
				'parent'             => sprintf( __( 'Parent %s' ), $singular ),
			),
			'description'         => sprintf( __( 'This is where you can create and manage %s.' ), $plural ),
			'public'              => true,
			'show_ui'             => true,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'hierarchical'        => false,
			'rewrite'             => true,
			'query_var'           => true,
			'supports'            => array( 'title', 'thumbnail', 'editor', 'author' ),
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'menu_icon'           => '',
		);

		register_post_type( $post_type, wp_parse_args( $args, $defaults ) );
	}


	/**
	 * Return Arguments Value
	 *
	 * @param string $key
	 * @param array $args
	 *
	 * @param string|array $default
	 *
	 * @return mixed|string
	 */
	public static function get_args_option( string $key = '', array $args = array(), $default = '' ) {

		$default = is_array( $default ) && empty( $default ) ? array() : $default;
		$default = ! is_array( $default ) && empty( $default ) ? '' : $default;
		$key     = empty( $key ) ? '' : $key;

		if ( isset( $args[ $key ] ) && ! empty( $args[ $key ] ) ) {
			return $args[ $key ];
		}

		return $default;
	}


	/**
	 * @return Pluginbazar_utils|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}