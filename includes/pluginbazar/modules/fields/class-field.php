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
	public $unique_id = null;
	public $args = array();
	public $title = null;
	public $type = null;
	public $placeholder = null;
	public $desc = null;
	public $value = null;
	private $default = null;
	private $is_disabled = false;
	private $is_required = false;
	private $options = array();
	private $empty_options = false;
	public $cols = 30;
	public $rows = 5;
	public $min = 1;
	public $max = 100;
	public $multiple = false;
	public $fields = array();


	/**
	 * Field constructor.
	 *
	 * @param array $args
	 */
	public function __construct( array $args = array() ) {
		foreach ( $args as $key => $val ) {
			$this->$key = $val;
		}

		if ( ! empty( $this->default ) && empty( $this->value ) ) {
			$this->value = $this->default;
		}

		$this->unique_id = str_replace( array( '-', '[', ']' ), '_', $this->id );
	}


	/**
	 * Print field arguments
	 *
	 * @param array $defaults
	 */
	public function field_args( array $defaults = array() ) {
		printf( '%s', preg_replace( '/"([^"]+)"\s*:\s*/', '$1:', json_encode( wp_parse_args( $defaults, $this->args ) ) ) );
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

		$field_value = $this->value;

		switch ( $this->type ) {
			case 'checkbox':
				$field_value = is_array( $field_value ) ? $field_value : array( $field_value );
				printf( '%s', in_array( $key, $field_value ) ? 'checked' : '' );
				break;

			case 'radio':
				printf( '%s', $field_value == $key ? 'checked' : '' );
				break;

			case 'select':
				printf( '%s', $field_value == $key ? 'selected' : '' );
				break;

			case 'select2':
				$field_value = is_array( $field_value ) ? $field_value : array( $field_value );
				printf( '%s', in_array( $key, $field_value ) ? 'selected' : '' );
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
	 * Return multiple attributes
	 */
	public function is_multiple() {
		printf( '%s', $this->multiple ? 'multiple="multiple"' : '' );
	}


	/**
	 * Output the field HTML
	 *
	 * @param null $content
	 */
	public function output( $content = null ) {
		printf( '<div class="pluginbazar-field %1$s" data-type="%1$s">%2$s<div class="field">%3$s%4$s</div></div>', $this->type, $this->get_label(), $content, $this->get_desc() );
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
		return sprintf( '<label for="%s">%s</label>', $this->unique_id, $this->title );
	}
}