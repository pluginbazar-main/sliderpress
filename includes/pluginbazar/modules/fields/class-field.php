<?php
/**
 * Field class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

use Pluginbazar\Utils;

class Field {

	public $id = null;
	public $args = array();
	public $title = null;
	public $type = null;
	public $placeholder = null;
	public $desc = null;
	public $value = null;
	private $is_disabled = false;
	private $is_required = false;
	private $options = array();
	private $empty_options = false;
	public $cols = 30;
	public $rows = 5;


	/**
	 * Field constructor.
	 *
	 * @param array $args
	 */
	public function __construct( array $args = array() ) {
		foreach ( $args as $key => $val ) {
			$this->$key = $val;
		}
	}


	/**
	 * Return options for radio, select, checkbox types
	 *
	 * @return array
	 */
	public function get_options(): array {

		if ( ! is_array( $this->options ) ) {
			return array();
		}

		$options = array();

		if ( $this->empty_options === true ) {
			$options[] = esc_html( 'Select your choice' );
		} else if ( $this->empty_options != '' ) {
			$options[] = $this->empty_options;
		}

		return array_merge( $options, $this->options );
	}


	/**
	 * Return attribute if this field is required
	 */
	public function is_current_option( string $key ) {
		switch ( $this->type ) {
			case 'checkbox':
				printf( '%s', in_array( $key, $this->value ) ? 'checked' : '' );
				break;

			case 'radio':
				printf( '%s', $this->value == $key ? 'checked' : '' );
				break;

			case 'select':
				printf( '%s', $this->value == $key ? 'selected' : '' );
				break;

			case 'select2':
				printf( '%s', in_array( $key, $this->value ) ? 'selected' : '' );
				break;
		}
	}


	/**
	 * Return attribute if this field is required
	 */
	public function is_required() {
		printf( '%s', $this->is_required ? 'required' : '' );
	}


	/**
	 * Return attribute if this field is disabled
	 */
	public function is_disabled() {
		printf( '%s', $this->is_disabled ? 'disabled' : '' );
	}


	/**
	 * Output the field HTML
	 *
	 * @param null $content
	 */
	public function output( $content = null ) {
		printf( '<div class="pluginbazar-field %s">%s<div class="field">%s%s</div></div>', $this->type, $this->get_label(), $content, $this->get_desc() );
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