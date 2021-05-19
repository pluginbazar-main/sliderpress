<?php
/**
 * Class Functions
 *
 * @author Pluginbazar
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'SliderPress_functions' ) ) {
	/**
	 * Class SliderPress_functions
	 */
	class SliderPress_functions {


		protected static $_instance = null;

		/**
		 * Return settings pages
		 *
		 * @return mixed|void
		 */
		function get_settings_pages() {

			$settings = array(
				'listener'          => array(
					'page_nav'    => __( 'Order Listener', 'sliderpress' ),
					'show_submit' => false,
				),
				'listener-settings' => array(
					'page_nav'      => __( 'Settings', 'sliderpress' ),
					'page_settings' => array(
						array(
							'title'   => __( 'General', 'sliderpress' ),
							'options' => array(
								array(
									'id'       => 'sliderpress_audio',
									'title'    => __( 'Custom audio', 'sliderpress' ),
									'details'  => __( 'You can set any custom audio as alarm.', 'sliderpress' ),
									'type'     => 'media',
									'disabled' => ! sliderpress()->is_pro(),
								),
								array(
									'id'          => 'sliderpress_req_per_minute',
									'title'       => __( 'Requests per Minute', 'sliderpress' ),
									'details'     => __( 'You can limit the requests per minute to the server. We heard some servers do not allow too many requests per minute, to handle this case, just decrease the check per minute to the server.', 'sliderpress' ),
									'type'        => 'number',
									'default'     => '30',
									'placeholder' => '30',
								),
								array(
									'id'       => 'sliderpress_order_status',
									'title'    => __( 'Check by Order Status', 'sliderpress' ),
									'details'  => __( 'Please specify which order status will be checked only. By default system will notify for all orders with any of these status', 'sliderpress' ),
									'type'     => 'checkbox',
									'args'     => $this->get_order_statuses(),
									'disabled' => ! sliderpress()->is_pro(),
								),
							)
						),
						array(
							'title'       => __( 'Custom Searching Rules on Items', 'sliderpress' ),
							'description' => __( 'You can configure custom searching rules with the ordered items for order listener. If you need to add any custom rules, Please contact support.', 'sliderpress' ),
							'options'     => array(
								array(
									'id'       => 'sliderpress_enable_rules',
									'title'    => __( 'Enable These Rules', 'sliderpress' ),
									'type'     => 'checkbox',
									'disabled' => ! sliderpress()->is_pro(),
									'args'     => array(
										'yes' => __( 'Yes! Enable these searching rules.', 'sliderpress' ),
									),
								),
								array(
									'id'            => 'sliderpress_products_included',
									'title'         => __( 'Products Included', 'sliderpress' ),
									'details'       => __( 'When any of these products are ordered only then alarm will start', 'sliderpress' ),
									'type'          => 'select2',
									'args'          => 'POSTS_%product%',
									'multiple'      => true,
									'disabled'      => ! sliderpress()->is_pro(),
									'field_options' => array(
										'placeholder' => __( 'Select Products', 'sliderpress' ),
									),
								),
								array(
									'id'            => 'sliderpress_categories_included',
									'title'         => __( 'Product Categories Included', 'sliderpress' ),
									'details'       => __( 'When any product from these categories are ordered only then alarm will start', 'sliderpress' ),
									'type'          => 'select2',
									'args'          => 'TAX_%product_cat%',
									'multiple'      => true,
									'disabled'      => ! sliderpress()->is_pro(),
									'field_options' => array(
										'placeholder' => __( 'Select Categories', 'sliderpress' ),
									),
								),
								array(
									'id'            => 'sliderpress_tags_included',
									'title'         => __( 'Product Tags Included', 'sliderpress' ),
									'details'       => __( 'When any product from these tags are ordered only then alarm will start', 'sliderpress' ),
									'type'          => 'select2',
									'args'          => 'TAX_%product_tag%',
									'multiple'      => true,
									'disabled'      => ! sliderpress()->is_pro(),
									'field_options' => array(
										'placeholder' => __( 'Select Tags', 'sliderpress' ),
									),
								),
								array(
									'id'          => 'sliderpress_min_order_amount',
									'title'       => __( 'Minimum order amount', 'sliderpress' ),
									'details'     => __( 'When this selected amount or more will be ordered only then alarm will start', 'sliderpress' ),
									'type'        => 'number',
									'placeholder' => __( '100', 'sliderpress' ),
									'disabled'    => ! sliderpress()->is_pro(),
								),
								array(
									'id'       => 'sliderpress_rules_relation',
									'title'    => __( 'Relation', 'sliderpress' ),
									'type'     => 'checkbox',
									'args'     => array(
										'products'   => __( 'Products', 'sliderpress' ),
										'categories' => __( 'Product Categories', 'sliderpress' ),
										'tags'       => __( 'Product Tags', 'sliderpress' ),
										'amount'     => __( 'Order Minimum Amount', 'sliderpress' ),
									),
									'details'  => __( 'Please select the conditions you wish to check for new order checking. If you leave empty, system will notify you if any of the condition is matched.', 'sliderpress' ),
									'disabled' => ! sliderpress()->is_pro(),
								),
							)
						),
					),
				),
				'listener-help'     => array(
					'page_nav'      => __( 'Help', 'sliderpress' ),
					'show_submit'   => false,
					'priority'      => 40,
					'page_settings' => array(

						array(
							'title'       => __( 'Help & support', 'sliderpress' ),
							'description' => __( 'Here is all about help and support.', 'sliderpress' ),
							'options'     => array(
								array(
									'id'      => '__1',
									'title'   => esc_html__( 'Support Ticket', 'sliderpress' ),
									'details' => sprintf( '%1$s<br>' . __( '<a href="%1$s" target="_blank">Create Support Ticket</a>', 'sliderpress' ), SLIDERPRESS_TICKET_URL ),
								),
								array(
									'id'      => '__2',
									'title'   => esc_html__( 'Can\'t Login..?', 'sliderpress' ),
									'details' => sprintf( __( '<span>Unable to login <strong>Pluginbazar.com</strong></span><br><a href="%1$s" target="_blank">Get Immediate Solution</a>', 'sliderpress' ), SLIDERPRESS_CONTACT_URL ),
								),
								array(
									'id'      => '__3',
									'title'   => esc_html__( 'Like this Plugin?', 'sliderpress' ),
									'details' => sprintf( __( '<span>To share feedback about this plugin Please </span><br><a href="%1$s" target="_blank">Rate now</a>', 'sliderpress' ), SLIDERPRESS_REVIEW_URL ),
								),
							)
						),
					),
				),
			);

			return apply_filters( 'sliderpress_filters_setting_pages', $settings );
		}


		/**
		 * @return \SliderPress_functions
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		/**
		 * Return option value
		 *
		 * @param string $option_key
		 * @param string $default_val
		 *
		 * @return mixed|string|void
		 */
		function get_option( $option_key = '', $default_val = '' ) {

			if ( empty( $option_key ) ) {
				return '';
			}

			$option_val = get_option( $option_key, $default_val );
			$option_val = empty( $option_val ) ? $default_val : $option_val;

			return apply_filters( 'woc_filters_option_' . $option_key, $option_val );
		}
	}
}

if ( ! function_exists( 'sliderpress' ) ) {
	function sliderpress() {
		global $sliderpress;

		if ( empty( $sliderpress ) ) {
			$sliderpress = SliderPress_functions::instance();
		}

		return $sliderpress;
	}
}