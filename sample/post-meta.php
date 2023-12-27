<?php
/**
 * Post Meta Sample
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-12-27
 */

namespace wpinc\meta\sample;

require_once __DIR__ . '/../src/field.php';
require_once __DIR__ . '/../src/field-post.php';
require_once __DIR__ . '/../src/key-suffix.php';
require_once __DIR__ . '/../src/picker.php';
require_once __DIR__ . '/../src/utility.php';

/**
 * Adds a metabox of post meta sample.
 *
 * @param string     $pt  Post type.
 * @param \WP_Post[] $ps  Posts.
 * @param string     $tax Taxonomy.
 */
function add_post_meta_sample( string $pt, array $ps, string $tax ): void {
	add_action(
		'admin_menu',
		function () use ( $pt, $ps, $tax ) {
			add_meta_box(
				'mb_post_meta_sample',
				'Post Meta Sample',
				function ( \WP_Post $post ) use ( $ps, $tax ): void {
					$post_id = $post->ID;
					\wpinc\meta\add_input_to_post( $post_id, '_meta_input', 'Input' );
					\wpinc\meta\add_textarea_to_post( $post_id, '_meta_textarea', 'Textarea' );
					\wpinc\meta\add_separator_to_post();
					\wpinc\meta\add_rich_editor_to_post( $post_id, '_meta_rich_editor', 'Rich Editor' );
					\wpinc\meta\add_checkbox_to_post( $post_id, '_meta_checkbox', 'Checkbox', 'Checkbox title' );
					\wpinc\meta\add_post_select_to_post( $post_id, '_meta_post_select', 'Post Select', $ps );
					\wpinc\meta\add_term_select_to_post( $post_id, '_meta_term_select', 'Term Select', $tax );
					\wpinc\meta\add_related_term_select_to_post( $post_id, '_meta_related_term_select', 'Related Term Select', $tax );
					\wpinc\meta\add_separator_to_post();
					\wpinc\meta\add_input_suffix_to_post( $post_id, '_meta_input_suffix', array( 'ja', 'en' ), 'Input Suffix' );
					\wpinc\meta\add_textarea_suffix_to_post( $post_id, '_meta_textarea_suffix', array( 'ja', 'en' ), 'Input Suffix' );
					\wpinc\meta\add_separator_to_post();
					\wpinc\meta\add_media_picker_to_post( $post_id, '_meta_media_picker', 'Media Picker' );
					\wpinc\meta\add_date_picker_to_post( $post_id, '_meta_date_picker', 'Date Picker' );
					$cp_opts = array(
						'placeholder' => '#00ff00',
						'default'     => '#00ff00',
					);
					\wpinc\meta\add_color_picker_to_post( $post_id, '_meta_color_picker', 'Color Picker', $cp_opts );
					\wpinc\meta\add_color_hue_picker_to_post( $post_id, '_meta_color_hue_picker', 'Color Hue Picker', $cp_opts );
				},
				$pt
			);
		}
	);
	add_action(
		'save_post_' . $pt,
		function ( int $post_id ) {
			\wpinc\meta\set_post_meta( $post_id, '_meta_input' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_textarea' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_rich_editor' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_checkbox' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_post_select' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_term_select' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_related_term_select' );
			\wpinc\meta\set_post_meta_suffix( $post_id, '_meta_input_suffix', array( 'ja', 'en' ) );
			\wpinc\meta\set_post_meta_suffix( $post_id, '_meta_textarea_suffix', array( 'ja', 'en' ) );
			\wpinc\meta\set_post_meta( $post_id, '_meta_media_picker' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_date_picker' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_color_picker' );
			\wpinc\meta\set_post_meta( $post_id, '_meta_color_hue_picker' );
		}
	);
}
