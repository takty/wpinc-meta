<?php
/**
 * Fields
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-12-27
 */

declare(strict_types=1);

namespace wpinc\meta;

require_once __DIR__ . '/assets/asset-url.php';

/**
 * Initializes fields.
 *
 * @param array<string, mixed> $args {
 *     (Optional) Array of arguments.
 *
 *     @type string 'url_to' URL to this script.
 * }
 */
function initialize( array $args = array() ): void {
	$url_to = untrailingslashit( $args['url_to'] ?? \wpinc\get_file_uri( __DIR__ ) );

	add_action(
		'admin_enqueue_scripts',
		function () use ( $url_to ) {
			// Styles for various fields and pickers.
			wp_register_style( 'wpinc-meta', \wpinc\abs_url( $url_to, './assets/css/style.min.css' ), array(), '1.0' );

			// For functions 'output_post_date_picker_row' and 'output_term_date_picker_row'.
			wp_register_script( 'flatpickr', \wpinc\abs_url( $url_to, './assets/lib/flatpickr.min.js' ), array(), '1.0', true );
			wp_register_script( 'flatpickr.l10n.ja', \wpinc\abs_url( $url_to, './assets/lib/flatpickr.l10n.ja.min.js' ), array(), '1.0', true );
			wp_register_style( 'flatpickr', \wpinc\abs_url( $url_to, './assets/lib/flatpickr.min.css' ), array(), '1.0' );

			// For functions 'output_post_media_picker_row' and 'output_term_media_picker_row'.
			wp_register_script( 'wpinc-meta-picker-media', \wpinc\abs_url( $url_to, './assets/lib/picker-media.min.js' ), array(), '1.0', true );
			wp_register_script( 'wpinc-meta-media-picker', \wpinc\abs_url( $url_to, './assets/js/media-picker.min.js' ), array(), '1.0', true );

			// For functions 'output_post_color_hue_picker_row' and 'output_term_color_hue_picker_row'.
			wp_register_script( 'wpinc-meta-color-hue-picker', \wpinc\abs_url( $url_to, './assets/js/color-hue-picker.min.js' ), array(), '1.0', true );
			wp_register_script( 'colorjst', \wpinc\abs_url( $url_to, './assets/lib/color-space.min.js' ), array(), '1.0', true );
		}
	);
}
