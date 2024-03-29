<?php
/**
 * Term Meta Sample
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-12-27
 */

namespace wpinc\meta\sample;

require_once __DIR__ . '/../src/field.php';
require_once __DIR__ . '/../src/field-term.php';
require_once __DIR__ . '/../src/key-suffix.php';
require_once __DIR__ . '/../src/picker.php';
require_once __DIR__ . '/../src/utility.php';

/**
 * Adds a metabox of term meta sample.
 *
 * @param string     $tax Taxonomy.
 * @param \WP_Post[] $ps  Posts.
 */
function add_term_meta_sample( string $tax, array $ps ): void {
	add_action(
		$tax . '_edit_form_fields',
		function ( \WP_Term $term ) use ( $ps ): void {
			$term_id = $term->term_id;
			\wpinc\meta\add_input_to_term( $term_id, '_meta_input', 'Input' );
			\wpinc\meta\add_textarea_to_term( $term_id, '_meta_textarea', 'Textarea' );
			\wpinc\meta\add_separator_to_term();
			\wpinc\meta\add_rich_editor_to_term( $term_id, '_meta_rich_editor', 'Rich Editor' );
			\wpinc\meta\add_checkbox_to_term( $term_id, '_meta_checkbox', 'Checkbox', 'Checkbox title' );
			\wpinc\meta\add_post_select_to_term( $term_id, '_meta_post_select', 'Post Select', $ps );
			\wpinc\meta\add_separator_to_term();
			\wpinc\meta\add_input_suffix_to_term( $term_id, '_meta_input_suffix', array( 'ja', 'en' ), 'Input Suffix' );
			\wpinc\meta\add_textarea_suffix_to_term( $term_id, '_meta_textarea_suffix', array( 'ja', 'en' ), 'Input Suffix' );
			\wpinc\meta\add_separator_to_term();
			\wpinc\meta\add_media_picker_to_term( $term_id, '_meta_media_picker', 'Media Picker' );
			\wpinc\meta\add_date_picker_to_term( $term_id, '_meta_date_picker', 'Date Picker' );
			$cp_opts = array(
				'placeholder' => '#00ff00',
				'default'     => '#00ff00',
			);
			\wpinc\meta\add_color_picker_to_term( $term_id, '_meta_color_picker', 'Color Picker', $cp_opts );
			\wpinc\meta\add_color_hue_picker_to_term( $term_id, '_meta_color_hue_picker', 'Color Hue Picker', $cp_opts );
		},
		20
	);
	add_action(
		'edited_' . $tax,
		function ( int $term_id ): void {
			\wpinc\meta\set_term_meta( $term_id, '_meta_input' );
			\wpinc\meta\set_term_meta( $term_id, '_meta_textarea' );
			\wpinc\meta\set_term_meta( $term_id, '_meta_rich_editor' );
			\wpinc\meta\set_term_meta( $term_id, '_meta_checkbox' );
			\wpinc\meta\set_term_meta( $term_id, '_meta_post_select' );
			\wpinc\meta\set_term_meta_suffix( $term_id, '_meta_input_suffix', array( 'ja', 'en' ) );
			\wpinc\meta\set_term_meta_suffix( $term_id, '_meta_textarea_suffix', array( 'ja', 'en' ) );
			\wpinc\meta\set_term_meta( $term_id, '_meta_media_picker' );
			\wpinc\meta\set_term_meta( $term_id, '_meta_date_picker' );
			\wpinc\meta\set_term_meta( $term_id, '_meta_color_picker' );
			\wpinc\meta\set_term_meta( $term_id, '_meta_color_hue_picker' );
		}
	);
}
