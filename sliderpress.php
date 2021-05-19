<?php
/*
	Plugin Name: SliderPress - All in one slider plugin for WordPress
	Plugin URI: https://pluginbazar.com/
	Description: Create unlimited different types of slider easily in WordPress
	Version: 1.0.0
	Author: Pluginbazar
	Author URI: https://pluginbazar.com/
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) || exit;
defined( 'SLIDERPRESS_PLUGIN_URL' ) || define( 'SLIDERPRESS_PLUGIN_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
defined( 'SLIDERPRESS_PLUGIN_DIR' ) || define( 'SLIDERPRESS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
defined( 'SLIDERPRESS_PLUGIN_FILE' ) || define( 'SLIDERPRESS_PLUGIN_FILE', plugin_basename( __FILE__ ) );

if ( ! class_exists( 'SliderPress_main' ) ) {
	/**
	 * Class SliderPress_main
	 */
	final class SliderPress_main {

		protected static $_instance = null;

		/**
		 * SliderPress_main constructor.
		 */
		function __construct() {

			$this->loading_scripts();
			$this->loading_functions_classes();

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		}


		/**
		 * @return \SliderPress_main
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		/**
		 * Load Textdomain
		 */
		function load_textdomain() {
			load_plugin_textdomain( 'sliderpress', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
		}


		/**
		 * Loading Functions and Classes
		 */
		function loading_functions_classes() {

			require_once SLIDERPRESS_PLUGIN_DIR . 'includes/pluginbazar/class-pluginbazar.php';

//			require_once SLIDERPRESS_PLUGIN_DIR . 'includes/class-pb-settings-3.3.php';
			require_once SLIDERPRESS_PLUGIN_DIR . 'includes/class-hooks.php';
//			require_once SLIDERPRESS_PLUGIN_DIR . 'includes/class-functions.php';
//
//			require_once SLIDERPRESS_PLUGIN_DIR . 'includes/functions.php';
		}


		/**
		 * Admin Scripts
		 */
		function admin_scripts() {

			wp_enqueue_script( 'sliderpress-admin', plugins_url( '/assets/admin/js/scripts.js', __FILE__ ), array( 'jquery' ) );
			wp_localize_script( 'sliderpress-admin', 'sliderpress', array(
				'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
				'confirmText' => esc_html__( 'Are you really want to reset the listener?', 'sliderpress' ),
			) );

			wp_enqueue_style( 'tool-tip', SLIDERPRESS_PLUGIN_URL . 'assets/tool-tip.min.css' );
			wp_enqueue_style( 'pb-core', SLIDERPRESS_PLUGIN_URL . 'assets/pb-core.css' );
			wp_enqueue_style( 'sliderpress-admin', SLIDERPRESS_PLUGIN_URL . 'assets/admin/css/style.css' );
		}


		/**
		 * Loading Scripts
		 */
		function loading_scripts() {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		}
	}
}

SliderPress_main::instance();
