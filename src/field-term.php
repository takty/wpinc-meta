<?php
/**
 * Fields for Term
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-12-27
 */

declare(strict_types=1);

namespace wpinc\meta;

require_once __DIR__ . '/utility.php';

/**
 * Adds a separator to term.
 */
function add_separator_to_term(): void {
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
	$val = is_string( $val ) ? $val : '';
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
	$val = is_string( $val ) ? $val : '';
	output_term_textarea_row( $label, $key, $val, $rows );
}

/**
 * Adds a rich editor to term.
 *
 * @param int                  $term_id  Term ID.
 * @param string               $key      Meta key.
 * @param string               $label    Label.
 * @param array<string, mixed> $settings Settings for wp_editor.
 */
function add_rich_editor_to_term( int $term_id, string $key, string $label, array $settings = array() ): void {
	$val = get_term_meta( $term_id, $key, true );
	$val = is_string( $val ) ? $val : '';
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

/**
 * Adds a post select to term.
 *
 * @param int        $term_id Term ID.
 * @param string     $key     Meta key.
 * @param string     $label   Label.
 * @param \WP_Post[] $posts   Posts to be selected.
 */
function add_post_select_to_term( int $term_id, string $key, string $label, array $posts ): void {
	$val = get_term_meta( $term_id, $key, true );
	$val = is_numeric( $val ) ? (int) $val : 0;
	output_term_post_select_row( $label, $key, $posts, $val );
}


// -----------------------------------------------------------------------------


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
 * @param string $val   Current value.
 * @param string $type  Input type. Default 'text'.
 */
function output_term_input_row( string $label, string $key, string $val, string $type = 'text' ): void {
	wp_enqueue_style( 'wpinc-meta' );
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
 * @param string $val   Current value.
 * @param int    $rows  Rows attribute. Default 2.
 */
function output_term_textarea_row( string $label, string $key, string $val, int $rows = 2 ): void {
	wp_enqueue_style( 'wpinc-meta' );
	?>
	<tr class="form-field wpinc-meta-field-tr textarea">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td><textarea <?php name_id( $key ); ?> rows="<?php echo esc_attr( (string) $rows ); ?>" cols="50" class="large-text"><?php echo esc_textarea( $val ); ?></textarea></td>
	</tr>
	<?php
}

/**
 * Outputs a rich editor row to term.
 *
 * @psalm-suppress ArgumentTypeCoercion
 *
 * @param string               $label    Label.
 * @param string               $key      Meta key.
 * @param string               $val      Current value.
 * @param array<string, mixed> $settings Settings for wp_editor.
 */
function output_term_rich_editor_row( string $label, string $key, string $val, array $settings = array() ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$cls = '';
	if ( isset( $settings['media_buttons'] ) && false === $settings['media_buttons'] ) {
		$cls = ' no-media-button';
	}
	?>
	<tr class="form-field wpinc-meta-field-rich-editor-tr<?php echo esc_attr( $cls ); ?>">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td><?php wp_editor( $val, $key, $settings );  // @phpstan-ignore-line ?></td>
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

/**
 * Outputs a post select row to term.
 *
 * @param string     $label Label.
 * @param string     $key   Meta key.
 * @param \WP_Post[] $posts Posts to be selected.
 * @param int        $val   Current value.
 */
function output_term_post_select_row( string $label, string $key, array $posts, int $val ): void {
	wp_enqueue_style( 'wpinc-meta' );
	?>
	<tr class="form-field wpinc-meta-field-tr select">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td>
			<select <?php name_id( $key ); ?>">
	<?php
	foreach ( $posts as $p ) {
		$name = $p->post_title;
		$id   = $p->ID;
		echo '<option value="' . esc_attr( (string) $id ) . '"' . selected( $id, $val, false ) . '>' . esc_html( $name ) . '</option>';
	}
	?>
			</select>
		</td>
	</tr>
	<?php
}
