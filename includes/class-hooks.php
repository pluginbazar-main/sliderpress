<?php
/**
 * Class Hooks
 *
 * @author Pluginbazar
 */

use Pluginbazar\Pluginbazar_meta;
use Pluginbazar\Pluginbazar_shortcodes;
use Pluginbazar\Pluginbazar_utils;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'SliderPress_hooks' ) ) {
	/**
	 * Class SliderPress_hooks
	 */
	class SliderPress_hooks {
		/**
		 * SliderPress_hooks constructor.
		 */
		function __construct() {

			add_action( 'init', array( $this, 'register_everything' ) );
		}


		/**
		 * Register Post Types and Settings
		 */
		function register_everything() {
			Pluginbazar_Utils::register_post_type( 'slider', array(
				'singular'            => esc_html__( 'Slider', 'sliderpress' ),
				'plural'              => esc_html__( 'Sliders', 'sliderpress' ),
				'menu_icon'           => 'dashicons-slides',
				'menu_position'       => 40,
				'public'              => false,
				'show_in_rest'        => false,
				'show_in_admin_bar'   => false,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'supports'            => array( 'title' ),
			) );

			Pluginbazar_shortcodes::add_shortcode( 'slider-1', false, SLIDERPRESS_PLUGIN_DIR . 'templates/slider-1.php' );
			Pluginbazar_shortcodes::add_shortcode_args( 'slider-1', array(
				'sliders' => array(
					array(
						'title'           => 'Mens Jackets',
						'thumb'           => 'https://demo.shapedplugin.com/woocommerce-product-slider/wp-content/uploads/2017/07/Hand-T-Shirt-268x322.png',
						'rating'          => 4.5,
						'add_to_cart'     => 'https://demo.shapedplugin.com/woocommerce-product-slider/?add-to-cart=828',
						'desc'            => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam',
						'read_more_text'  => 'Read more',
						'read_more_link'  => 'https://demo.shapedplugin.com/woocommerce-product-slider/',
						'price_regular'   => 99,
						'price_onsale'    => 49,
						'currency'        => '$',
						'is_featured'     => true,
						'show_onsale_tag' => false,
					),
					array(
						'title'           => 'Mens Winter Jackets',
						'thumb'           => 'https://demo.shapedplugin.com/woocommerce-product-slider/wp-content/uploads/2017/07/woolen-jacket-268x322.png',
						'rating'          => 4,
						'add_to_cart'     => 'https://demo.shapedplugin.com/woocommerce-product-slider/?add-to-cart=828',
						'desc'            => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam',
						'read_more_text'  => 'Read more',
						'read_more_link'  => 'https://demo.shapedplugin.com/woocommerce-product-slider/',
						'price_regular'   => 99,
						'price_onsale'    => 49,
						'currency'        => '$',
						'is_featured'     => true,
						'show_onsale_tag' => false,
					),
					array(
						'title'           => 'Women Jackets',
						'thumb'           => 'https://demo.shapedplugin.com/woocommerce-product-slider/wp-content/uploads/2017/07/Check-Shirt-268x322.png',
						'rating'          => 4.5,
						'add_to_cart'     => 'https://demo.shapedplugin.com/woocommerce-product-slider/?add-to-cart=828',
						'desc'            => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam',
						'read_more_text'  => 'Read more',
						'read_more_link'  => 'https://demo.shapedplugin.com/woocommerce-product-slider/',
						'price_regular'   => 99,
						'price_onsale'    => 49,
						'currency'        => '$',
						'is_featured'     => true,
						'show_onsale_tag' => false,
					),
				),
			) );

			Pluginbazar_meta::register_meta_box( 'slider-data', 'slider' );
			Pluginbazar_meta::add_section( 'slider-data', array(
				'id'     => 'main_meta',
				'label'  => 'Main Meta',
				'fields' => array(
					array(
						'id'          => 'sliderpress_enable_rules',
						'title'       => esc_html__( 'Enable These Rules', 'sliderpress' ),
						'desc'        => esc_html__( 'Field description text here', 'sliderpress' ),
						'placeholder' => esc_html__( 'Placeholder text here', 'sliderpress' ),
						'type'        => 'text',
					),
					array(
						'id'          => 'sliderpress_enable_rules2',
						'title'       => esc_html__( 'Enable These Rules', 'sliderpress' ),
						'desc'        => esc_html__( 'Field description text here', 'sliderpress' ),
						'placeholder' => esc_html__( 'Placeholder text here', 'sliderpress' ),
						'type'        => 'text',
					),
					array(
						'id'          => 'sliderpress_enable_rules3',
						'title'       => esc_html__( 'Enable These Rules', 'sliderpress' ),
						'desc'        => esc_html__( 'Field description text here', 'sliderpress' ),
						'placeholder' => esc_html__( 'Placeholder text here', 'sliderpress' ),
						'type'        => 'text',
					),
					array(
						'id'          => 'sliderpress_enable_rules4',
						'title'       => esc_html__( 'Enable These Rules', 'sliderpress' ),
						'desc'        => esc_html__( 'Field description text here', 'sliderpress' ),
						'placeholder' => esc_html__( 'Placeholder text here', 'sliderpress' ),
						'type'        => 'text',
					),
				),
			) );
			Pluginbazar_meta::add_section( 'slider-data', array(
				'id'     => 'main_meta2',
				'label'  => 'Main Meta 2',
				'fields' => array(
					array(
						'id'          => 'sliderpress_enable_rules7',
						'title'       => esc_html__( 'Enable These Rules', 'sliderpress' ),
						'desc'        => esc_html__( 'Field description text here', 'sliderpress' ),
						'placeholder' => esc_html__( 'Placeholder text here', 'sliderpress' ),
						'type'        => 'text',
					),
					array(
						'id'          => 'sliderpress_enable_rules27',
						'title'       => esc_html__( 'Enable These Rules', 'sliderpress' ),
						'desc'        => esc_html__( 'Field description text here', 'sliderpress' ),
						'placeholder' => esc_html__( 'Placeholder text here', 'sliderpress' ),
						'type'        => 'text',
					),
				),
			) );
		}
	}

	new SliderPress_hooks();
}