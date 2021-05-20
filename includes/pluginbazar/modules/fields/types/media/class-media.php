<?php
/**
 * Fields class
 *
 * @author Pluginbazar
 */

namespace Pluginbazar\Fields;

use Pluginbazar\Main;

/**
 * Class Field_media
 */
class Field_media {

	/**
	 * Field_media instance
	 *
	 * @var null
	 */
	private static $_instance = null;


	/**
	 * Render the field output
	 *
	 * @param Field $field
	 */
	public static function render( Field $field ) {

		ob_start();

		$media_title = get_the_title( $field->value );
		$media_url   = wp_get_attachment_url( $field->value );
		$media_ext   = pathinfo( $media_url, PATHINFO_EXTENSION );

		?>
        <div class="preview" style="width: 180px; margin-bottom: 15px; background: #d2d2d2;padding: 8px;text-align: center; border-radius: 5px; float: none;">

			<?php if ( in_array( $media_ext, array( 'mp3', 'wav' ) ) ) : ?>
                <div id="preview_<?php echo esc_attr( $field->unique_id ); ?>" class="dashicons dashicons-format-audio" style="font-size: 70px;display: inline;"></div>
                <div><?php echo esc_html( $media_title ); ?></div>
			<?php else : ?>
                <img id="preview_<?php echo esc_attr( $field->unique_id ); ?>" src="<?php echo esc_url( $media_url ); ?>" style="width:100%" alt="<?php echo esc_attr( $media_title ); ?>"/>
			<?php endif; ?>

        </div>
        <div class="">
            <input type="hidden" name="<?php echo esc_attr( $field->id ); ?>" id="media_input_<?php echo esc_attr( $field->unique_id ); ?>" value="<?php echo esc_attr( $field->value ); ?>"/>
            <div class="button" <?php $field->is_disabled(); ?> id="media_upload_<?php echo esc_attr( $field->unique_id ); ?>"><?php esc_html_e( 'Upload' ); ?></div>

			<?php if ( ! empty( $field->value ) ) : ?>
                <div class="button button-primary" id="media_upload_<?php echo esc_attr( $field->unique_id ); ?>_remove"><?php esc_html_e( 'Remove' ); ?></div>
			<?php endif; ?>
        </div>
        <script>
            jQuery(document).ready(function ($) {

                $(document).on('click', '#media_upload_<?php echo esc_attr( $field->unique_id ); ?>_remove', function () {
                    $(this).parent().find('.preview img').attr('src', '');
                    $(this).parent().find('#media_input_<?php echo esc_attr( $field->unique_id ); ?>').val('');
                });

                $(document).on('click', '#media_upload_<?php echo esc_attr( $field->unique_id ); ?>', function () {
                    let send_attachment_bkp = wp.media.editor.send.attachment;
                    wp.media.editor.send.attachment = function (props, attachment) {
                        $("#preview_<?php echo esc_attr( $field->unique_id ); ?>").attr('src', attachment.url);
                        $("#media_input_<?php echo esc_attr( $field->unique_id ); ?>").val(attachment.id);
                        wp.media.editor.send.attachment = send_attachment_bkp;
                    };
                    wp.media.editor.open($(this));
                    return false;
                });
            });
        </script>
		<?php

		$field->output( ob_get_clean() );

		Main::add_style( '.media-router .media-menu-item', array( 'height' => '36px !important', ) );
		Main::add_style( '.media-router .media-menu-item:active, .media-router .media-menu-item:focus', array( 'outline' => 'none !important', 'box-shadow' => 'none !important', ) );
	}


	/**
	 * @return Field_media|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}