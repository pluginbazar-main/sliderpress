<?php
/**
 * Settings class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar;

/**
 * Class Pluginbazar_settings
 */
class Pluginbazar_settings {

	/**
	 * Pluginbazar_Utils instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	/**
	 * @return Pluginbazar_settings|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}