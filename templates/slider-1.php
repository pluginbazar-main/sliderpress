<?php
/**
 * Slider Template - 1
 *
 * @author Pluginbazar
 */

use Pluginbazar\Pluginbazar_shortcodes;
use Pluginbazar\Pluginbazar_utils;

$slider_args = Pluginbazar_shortcodes::get_shortcode_data( $shortcode, 'args' );
$sliders     = Pluginbazar_utils::get_args_option( 'sliders', $slider_args );

echo "<pre>";
print_r( $sliders );
echo "</pre>";