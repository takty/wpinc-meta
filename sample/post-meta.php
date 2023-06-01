<?php
/**
 * Post Meta Sample
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-06-01
 */

namespace wpinc\meta\sample;

/**
 * Adds a metabox of post meta sample.
 *
 * @param string $pt  Post type.
 * @param string $tax Taxonomy.
 */
function add_post_meta_sample( string $pt, string $tax ): void {
	add_action(
		'admin_menu',
		function () {
			add_meta_box(
				'mb_post_meta_sample',
				'Post Meta Sample',
				function ( \WP_Post $post ): void {
					$post_id = $post->ID;
					\st\meta\add_input_to_post( $post_id, '_meta_input', 'Input' );
					\st\meta\add_textarea_to_post( $post_id, '_meta_textarea', 'Textarea' );
					\st\meta\add_separator_to_post();
					\st\meta\add_rich_editor_to_post( $post_id, '_meta_rich_editor', 'Rich Editor' );
					\st\meta\add_checkbox_to_post( $post_id, '_meta_checkbox', 'Checkbox', 'Checkbox title' );
					\st\meta\add_term_select_to_post( $post_id, '_meta_term_select', 'Term Select', $tax );
					\st\meta\add_related_term_select_to_post( $post_id, '_meta_related_term_select', 'Related Term Select', $tax );
					\st\meta\add_separator_to_post();
					\st\meta\add_input_postfix_to_post( $post_id, '_meta_input_postfix', array( 'ja', 'en' ), 'Input Postfix' );
					\st\meta\add_textarea_postfix_to_post( $post_id, '_meta_textarea_postfix', array( 'ja', 'en' ), 'Input Postfix' );
					\st\meta\add_separator_to_post();
					\st\meta\add_media_picker_to_post( $post_id, '_meta_media_picker', 'Media Picker' );
					\st\meta\add_date_picker_to_post( $post_id, '_meta_date_picker', 'Date Picker' );
				},
				$pt
			);
		}
	);
	add_action(
		'save_post_' . $pt,
		function ( int $post_id ) {
			\st\meta\set_post_meta( $post_id, '_meta_input' );
			\st\meta\set_post_meta( $post_id, '_meta_textarea' );
			\st\meta\set_post_meta( $post_id, '_meta_rich_editor' );
			\st\meta\set_post_meta( $post_id, '_meta_checkbox' );
			\st\meta\set_post_meta( $post_id, '_meta_term_select' );
			\st\meta\set_post_meta( $post_id, '_meta_related_term_select' );
			\st\meta\set_post_meta_postfix( $post_id, '_meta_input_postfix', array( 'ja', 'en' ) );
			\st\meta\set_post_meta_postfix( $post_id, '_meta_textarea_postfix', array( 'ja', 'en' ) );
			\st\meta\set_post_meta( $post_id, '_meta_media_picker' );
			\st\meta\set_post_meta( $post_id, '_meta_date_picker' );
		}
	);
}
