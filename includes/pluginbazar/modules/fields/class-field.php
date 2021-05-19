<?php
/**
 * Field class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

use Pluginbazar\Pluginbazar_utils;

class Field {

	public $id = null;
	public $title = null;
	public $type = null;
	public $placeholder = null;
	public $desc = null;

	/**
	 * Field constructor.
	 *
	 * @param array $args
	 */
	public function __construct( array $args = array() ) {
		$this->id          = Pluginbazar_utils::get_args_option( 'id', $args );
		$this->title       = Pluginbazar_utils::get_args_option( 'title', $args );
		$this->type        = Pluginbazar_utils::get_args_option( 'type', $args );
		$this->placeholder = Pluginbazar_utils::get_args_option( 'placeholder', $args );
		$this->desc        = Pluginbazar_utils::get_args_option( 'desc', $args );
	}


	/**
	 * Output the field HTML
	 *
	 * @param null $content
	 */
	public function output( $content = null ) {
		printf( '<div class="pluginbazar-field">%s<div class="field">%s%s</div></div>', $this->get_label(), $content, $this->get_desc() );
	}


	/**
	 * Return field desc
	 *
	 * @return string
	 */
	public function get_desc(): string {
		return sprintf( '<p>%s</p>', $this->desc );
	}


	/**
	 * Return field label
	 *
	 * @return string
	 */
	public function get_label(): string {
		return sprintf( '<label for="%s">%s</label>', $this->id, $this->title );
	}
}