<?php
/**
 * Fields
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-06-06
 */

namespace wpinc\meta;

require_once __DIR__ . '/assets/asset-url.php';

/**
 * Initializes fields.
 *
 * @param array $args {
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
			wp_register_style( 'wpinc-meta', \wpinc\abs_url( $url_to, './assets/css/style.min.css' ), array(), 1.0 );

			// For functions 'output_post_date_picker_row' and 'output_term_date_picker_row'.
			wp_register_script( 'flatpickr', \wpinc\abs_url( $url_to, './assets/lib/flatpickr.min.js' ), array(), 1.0, true );
			wp_register_script( 'flatpickr.l10n.ja', \wpinc\abs_url( $url_to, './assets/lib/flatpickr.l10n.ja.min.js' ), array(), 1.0, true );
			wp_register_style( 'flatpickr', \wpinc\abs_url( $url_to, './assets/lib/flatpickr.min.css' ), array(), 1.0 );

			// For functions 'output_post_media_picker_row' and 'output_term_media_picker_row'.
			wp_register_script( 'wpinc-meta-picker-media', \wpinc\abs_url( $url_to, './assets/lib/picker-media.min.js' ), array(), 1.0, true );
			wp_register_script( 'wpinc-meta-media-picker', \wpinc\abs_url( $url_to, './assets/js/media-picker.min.js' ), array(), 1.0, true );
		}
	);
}


// -----------------------------------------------------------------------------


/**
 * Adds a separator to post.
 */
function add_separator_to_post() {
	output_post_separator();
}

/**
 * Adds an input to post.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @param string $label   Label.
 * @param string $type    Input type. Default 'text'.
 */
function add_input_to_post( int $post_id, string $key, string $label, string $type = 'text' ): void {
	$val = get_post_meta( $post_id, $key, true );
	output_post_input_row( $label, $key, $val, $type );
}

/**
 * Adds a textarea to post.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @param string $label   Label.
 * @param int    $rows    Rows attribute. Default 2.
 */
function add_textarea_to_post( int $post_id, string $key, string $label, int $rows = 2 ): void {
	$val = get_post_meta( $post_id, $key, true );
	output_post_textarea_row( $label, $key, $val, $rows );
}

/**
 * Adds a rich editor to post.
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key.
 * @param string $label    Label.
 * @param array  $settings Settings for wp_editor.
 */
function add_rich_editor_to_post( int $post_id, string $key, string $label, array $settings = array() ): void {
	$val = get_post_meta( $post_id, $key, true );
	output_post_rich_editor_row( $label, $key, $val, $settings );
}

/**
 * Adds a checkbox to post.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @param string $label   Label.
 * @param string $title   Title of the checkbox.
 */
function add_checkbox_to_post( int $post_id, string $key, string $label, string $title = '' ): void {
	$val = get_post_meta( $post_id, $key, true );
	output_post_checkbox_row( $label, $key, 'on' === $val, $title );
}

/**
 * Adds a term select to post.
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key.
 * @param string $label    Label.
 * @param string $taxonomy Taxonomy slug.
 * @param string $field    Term field.
 */
function add_term_select_to_post( int $post_id, string $key, string $label, string $taxonomy, string $field = 'slug' ): void {
	$val = get_post_meta( $post_id, $key, true );
	output_post_term_select_row( $label, $key, $taxonomy, $val, $field );
}

/**
 * Adds a related term select to post.
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key.
 * @param string $label    Label.
 * @param string $taxonomy Taxonomy slug.
 * @param string $field    Term field.
 */
function add_related_term_select_to_post( int $post_id, string $key, string $label, string $taxonomy, string $field = 'slug' ): void {
	$val   = get_post_meta( $post_id, $key, true );
	$terms = get_the_terms( $post_id, $taxonomy );
	output_post_term_select_row( $label, $key, $terms, $val, $field );
}


// - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - -.


/**
 * Adds a separator to term.
 */
function add_separator_to_term() {
	output_term_separator();
}

/**
 * Adds an input to term.
 *
 * @param int    $term_id Term ID.
 * @param string $key     Meta key.
 * @param string $label   Label.
 * @param string $type    Input type. Default 'text'.
 */
function add_input_to_term( int $term_id, string $key, string $label, string $type = 'text' ): void {
	$val = get_term_meta( $term_id, $key, true );
	output_term_input_row( $label, $key, $val, $type );
}

/**
 * Adds a textarea to term.
 *
 * @param int    $term_id Term ID.
 * @param string $key     Meta key.
 * @param string $label   Label.
 * @param int    $rows    Rows attribute. Default 2.
 */
function add_textarea_to_term( int $term_id, string $key, string $label, int $rows = 2 ): void {
	$val = get_term_meta( $term_id, $key, true );
	output_term_textarea_row( $label, $key, $val, $rows );
}

/**
 * Adds a rich editor to term.
 *
 * @param int    $term_id  Term ID.
 * @param string $key      Meta key.
 * @param string $label    Label.
 * @param array  $settings Settings for wp_editor.
 */
function add_rich_editor_to_term( int $term_id, string $key, string $label, array $settings = array() ): void {
	$val = get_term_meta( $term_id, $key, true );
	output_term_rich_editor_row( $label, $key, $val, $settings );
}

/**
 * Adds a checkbox to term.
 *
 * @param int    $term_id Term ID.
 * @param string $key     Meta key.
 * @param string $label   Label.
 * @param string $title   Title of the checkbox.
 */
function add_checkbox_to_term( int $term_id, string $key, string $label, string $title = '' ): void {
	$val = get_term_meta( $term_id, $key, true );
	output_term_checkbox_row( $label, $key, 'on' === $val, $title );
}


// -----------------------------------------------------------------------------


/**
 * Outputs a separator to post.
 */
function output_post_separator(): void {
	wp_enqueue_style( 'wpinc-meta' );
	?>
	<hr class="wpinc-meta-field-separator">
	<?php
}

/**
 * Outputs an input row to post.
 *
 * @param string $label Label.
 * @param string $key   Meta key.
 * @param mixed  $val   Current value.
 * @param string $type  Input type. Default 'text'.
 */
function output_post_input_row( string $label, string $key, $val, string $type = 'text' ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$val = $val ?? '';
	?>
	<div class="wpinc-meta-field-row <?php echo esc_attr( $type ); ?>">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div>
			<input <?php name_id( $key ); ?> type="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( $val ); ?>" size="64">
		</div>
	</div>
	<?php
}

/**
 * Outputs a textarea row to post.
 *
 * @param string $label Label.
 * @param string $key   Meta key.
 * @param mixed  $val   Current value.
 * @param int    $rows  Rows attribute. Default 2.
 */
function output_post_textarea_row( string $label, string $key, $val, int $rows = 2 ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$val = $val ?? '';
	?>
	<div class="wpinc-meta-field-row textarea">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div>
			<textarea <?php name_id( $key ); ?> cols="64" rows="<?php echo esc_attr( $rows ); ?>"><?php echo esc_textarea( $val ); ?></textarea>
		</div>
	</div>
	<?php
}

/**
 * Outputs a rich editor row to post.
 *
 * @param string $label    Label.
 * @param string $key      Meta key.
 * @param mixed  $val      Current value.
 * @param array  $settings Settings for wp_editor.
 */
function output_post_rich_editor_row( string $label, string $key, $val, array $settings = array() ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$cls = '';
	if ( isset( $settings['media_buttons'] ) && false === $settings['media_buttons'] ) {
		$cls = ' no-media-button';
	}
	?>
	<div class="wpinc-meta-field-rich-editor<?php echo esc_attr( $cls ); ?>">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<?php wp_editor( $val, $key, $settings ); ?>
	</div>
	<?php
}

/**
 * Outputs a checkbox row to post.
 *
 * @param string $label   Label.
 * @param string $key     Meta key.
 * @param bool   $checked Current value. Default false.
 * @param string $title   Title of the checkbox.
 */
function output_post_checkbox_row( string $label, string $key, bool $checked = false, string $title = '' ): void {
	wp_enqueue_style( 'wpinc-meta' );
	?>
	<div class="wpinc-meta-field-row checkbox">
		<span class="label" for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></span>
		<div>
			<input <?php name_id( $key ); ?> type="checkbox" <?php echo esc_attr( $checked ? 'checked' : '' ); ?>>
	<?php if ( ! empty( $title ) ) : ?>
			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $title ); ?></label>
	<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Outputs a term select row to post.
 *
 * @param string            $label             Label.
 * @param string            $key               Meta key.
 * @param string|\WP_Term[] $taxonomy_or_terms Taxonomy slug or term objects.
 * @param string            $val               Current value.
 * @param string            $field             Term field.
 */
function output_post_term_select_row( string $label, string $key, $taxonomy_or_terms, $val, string $field = 'slug' ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$terms = is_array( $taxonomy_or_terms ) ? $taxonomy_or_terms : get_terms( $taxonomy_or_terms );
	if ( ! is_array( $terms ) ) {
		$terms = array();
	}
	?>
	<div class="wpinc-meta-field-row select">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div>
			<select <?php name_id( $key ); ?>">
	<?php
	foreach ( $terms as $t ) {
		$name = $t->name;
		$tf   = get_term_field( $field, $t, '', 'raw' );
		echo '<option value="' . esc_attr( $val ) . '"' . selected( $tf, $val, false ) . '>' . esc_html( $name ) . '</option>';
	}
	?>
			</select>
		</div>
	</div>
	<?php
}


// - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - -.


/**
 * Outputs a separator to term.
 */
function output_term_separator(): void {
	wp_enqueue_style( 'wpinc-meta' );
	?>
	<tr class="form-field wpinc-meta-field-separator-tr">
		<th></th><td></td>
	</tr>
	<?php
}

/**
 * Outputs an input row to term.
 *
 * @param string $label Label.
 * @param string $key   Meta key.
 * @param mixed  $val   Current value.
 * @param string $type  Input type. Default 'text'.
 */
function output_term_input_row( string $label, string $key, $val, string $type = 'text' ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$val = $val ?? '';
	?>
	<tr class="form-field wpinc-meta-field-tr <?php echo esc_attr( $type ); ?>">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td><input type="<?php echo esc_attr( $type ); ?>" <?php name_id( $key ); ?> size="40" value="<?php echo esc_attr( $val ); ?>"></td>
	</tr>
	<?php
}

/**
 * Outputs a textarea row to term.
 *
 * @param string $label Label.
 * @param string $key   Meta key.
 * @param mixed  $val   Current value.
 * @param int    $rows  Rows attribute. Default 2.
 */
function output_term_textarea_row( string $label, string $key, $val, int $rows = 2 ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$val = $val ?? '';
	?>
	<tr class="form-field wpinc-meta-field-tr textarea">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td><textarea <?php name_id( $key ); ?> rows="<?php echo esc_attr( $rows ); ?>" cols="50" class="large-text"><?php echo esc_textarea( $val ); ?></textarea></td>
	</tr>
	<?php
}

/**
 * Outputs a rich editor row to term.
 *
 * @param string $label    Label.
 * @param string $key      Meta key.
 * @param mixed  $val      Current value.
 * @param array  $settings Settings for wp_editor.
 */
function output_term_rich_editor_row( string $label, string $key, $val, array $settings = array() ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$cls = '';
	if ( isset( $settings['media_buttons'] ) && false === $settings['media_buttons'] ) {
		$cls = ' no-media-button';
	}
	?>
	<tr class="form-field wpinc-meta-field-rich-editor-tr<?php echo esc_attr( $cls ); ?>">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td><?php wp_editor( $val, $key, $settings ); ?></td>
	</tr>
	<?php
}

/**
 * Outputs a checkbox row to term.
 *
 * @param string $label   Label.
 * @param string $key     Meta key.
 * @param bool   $checked Current value. Default false.
 * @param string $title   Title of the checkbox.
 */
function output_term_checkbox_row( string $label, string $key, bool $checked = false, string $title = '' ): void {
	wp_enqueue_style( 'wpinc-meta' );
	?>
	<tr class="form-field wpinc-meta-field-tr checkbox">
		<th scope="row"><?php echo esc_html( $label ); ?></th>
		<td><label>
			<input type="checkbox" <?php name_id( $key ); ?> <?php echo esc_attr( $checked ? 'checked' : '' ); ?>>
	<?php if ( ! empty( $title ) ) : ?>
		<?php echo esc_html( $title ); ?>
	<?php endif; ?>
		</label></td>
	</tr>
	<?php
}
