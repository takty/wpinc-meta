<?php
/**
 * Term Meta Sample
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-06-02
 */

namespace wpinc\meta\sample;

/**
 * Adds a metabox of term meta sample.
 *
 * @param string $tax Taxonomy.
 */
function add_term_meta_sample( string $tax ) {
	add_action(
		$tax . '_edit_form_fields',
		function ( \WP_Term $term ): void {
			$term_id = $term->term_id;
			\wpinc\meta\add_input_to_term( $term_id, '_meta_input', 'Input' );
			\wpinc\meta\add_textarea_to_term( $term_id, '_meta_textarea', 'Textarea' );
			\wpinc\meta\add_separator_to_term();
			\wpinc\meta\add_rich_editor_to_term( $term_id, '_meta_rich_editor', 'Rich Editor' );
			\wpinc\meta\add_checkbox_to_term( $term_id, '_meta_checkbox', 'Checkbox', 'Checkbox title' );
			\wpinc\meta\add_separator_to_term();
			\wpinc\meta\add_input_suffix_to_term( $term_id, '_meta_input_suffix', array( 'ja', 'en' ), 'Input Suffix' );
			\wpinc\meta\add_textarea_suffix_to_term( $term_id, '_meta_textarea_suffix', array( 'ja', 'en' ), 'Input Suffix' );
			\wpinc\meta\add_separator_to_term();
			\wpinc\meta\add_media_picker_to_term( $term_id, '_meta_media_picker', 'Media Picker' );
			\wpinc\meta\add_date_picker_to_term( $term_id, '_meta_date_picker', 'Date Picker' );
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
			\wpinc\meta\set_term_meta_suffix( $term_id, '_meta_input_suffix', array( 'ja', 'en' ) );
			\wpinc\meta\set_term_meta_suffix( $term_id, '_meta_textarea_suffix', array( 'ja', 'en' ) );
			\wpinc\meta\set_term_meta( $term_id, '_meta_media_picker' );
			\wpinc\meta\set_term_meta( $term_id, '_meta_date_picker' );
		}
	);
}
