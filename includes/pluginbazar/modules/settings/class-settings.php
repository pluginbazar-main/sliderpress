<?php
/**
 * Settings class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar;

/**
 * Class Settings
 */
class Settings {

	/**
	 * Pluginbazar_Utils instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	/**
	 * @return Settings|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}