<?php
/**
 * Key with Suffix
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-06-05
 */

namespace wpinc\meta;

require_once __DIR__ . '/utility.php';

/**
 * Adds multiple input to post.
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @param string $label    Label.
 * @param string $type     Input type. Default 'text'.
 */
function add_input_suffix_to_post( int $post_id, string $key, array $suffixes, string $label, string $type = 'text' ): void {
	$vals = get_post_meta_suffix( $post_id, $key, $suffixes );
	output_post_input_row_suffix( $label, $key, $suffixes, $vals, $type );
}

/**
 * Adds multiple input to term.
 *
 * @param int    $term_id  Term ID.
 * @param string $key      Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @param string $label    Label.
 * @param string $type     Input type. Default 'text'.
 */
function add_input_suffix_to_term( int $term_id, string $key, array $suffixes, string $label, string $type = 'text' ): void {
	$vals = get_term_meta_suffix( $term_id, $key, $suffixes );
	output_term_input_row_suffix( $label, $key, $suffixes, $vals, $type );
}

/**
 * Outputs input rows to post.
 *
 * @param string $label    Label.
 * @param string $key      Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @param array  $vals     Current values.
 * @param string $type     Input type. Default 'text'.
 */
function output_post_input_row_suffix( string $label, string $key, array $suffixes, array $vals, string $type = 'text' ): void {
	wp_enqueue_style( 'wpinc-meta-field' );
	?>
	<div class="wpinc-meta-field-group">
	<?php
	foreach ( $suffixes as $sfx ) {
		$val = $vals[ $sfx ] ?? '';
		$ni  = is_null( $sfx ) ? $key : "{$key}_$sfx";
		$lab = is_null( $sfx ) ? $label : "$label [$sfx]";
		?>
		<div class="wpinc-meta-field-row">
			<label for="<?php echo esc_attr( $ni ); ?>"><?php echo esc_html( $lab ); ?></label>
			<div>
				<input <?php name_id( $ni ); ?> type="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( $val ); ?>" size="64">
			</div>
		</div>
		<?php
	}
	?>
	</div>
	<?php
}

/**
 * Outputs input rows to term.
 *
 * @param string $label    Label.
 * @param string $key      Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @param array  $vals     Current values.
 * @param string $type     Input type. Default 'text'.
 */
function output_term_input_row_suffix( string $label, string $key, array $suffixes, array $vals, string $type = 'text' ): void {
	wp_enqueue_style( 'wpinc-meta-field' );
	foreach ( $suffixes as $idx => $sfx ) {
		$val = $vals[ $sfx ] ?? '';
		$ni  = is_null( $sfx ) ? $key : "{$key}_$sfx";
		$lab = is_null( $sfx ) ? $label : "$label [$sfx]";
		$cls = ( 0 === $idx ) ? ' wpinc-meta-field-tr-first' : ( ( count( $suffixes ) - 1 === $idx ) ? ' wpinc-meta-field-tr-last' : '' );
		?>
		<tr class="form-field wpinc-meta-field-tr-multiple<?php echo esc_attr( $cls ); ?>">
			<th scope="row"><label for="<?php echo esc_attr( $ni ); ?>"><?php echo esc_html( $lab ); ?></label></th>
			<td><input type="<?php echo esc_attr( $type ); ?>" <?php name_id( $ni ); ?> size="40" value="<?php echo esc_attr( $val ); ?>"></td>
		</tr>
		<?php
	}
}


// -----------------------------------------------------------------------------


/**
 * Adds multiple textarea to post.
 *
 * @param int    $post_id  Post ID.
 * @param string $key      Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @param string $label    Label.
 * @param int    $rows     Rows attribute. Default 2.
 */
function add_textarea_suffix_to_post( int $post_id, string $key, array $suffixes, string $label, int $rows = 2 ): void {
	$vals = get_post_meta_suffix( $post_id, $key, $suffixes );
	output_post_textarea_row_suffix( $label, $key, $suffixes, $vals, $rows );
}

/**
 * Adds multiple textarea to term.
 *
 * @param int    $term_id  Term ID.
 * @param string $key      Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @param string $label    Label.
 * @param int    $rows     Rows attribute. Default 5.
 */
function add_textarea_suffix_to_term( int $term_id, string $key, array $suffixes, string $label, int $rows = 5 ): void {
	$vals = get_term_meta_suffix( $term_id, $key, $suffixes );
	output_term_textarea_row_suffix( $label, $key, $suffixes, $vals, $rows );
}

/**
 * Outputs textarea rows for post.
 *
 * @param string $label    Label.
 * @param string $key      Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @param array  $vals     Current values.
 * @param int    $rows     Rows attribute. Default 2.
 */
function output_post_textarea_row_suffix( string $label, string $key, array $suffixes, array $vals, int $rows = 2 ): void {
	wp_enqueue_style( 'wpinc-meta-field' );
	?>
	<div class="wpinc-meta-field-group">
	<?php
	foreach ( $suffixes as $sfx ) {
		$val = $vals[ $sfx ] ?? '';
		$ni  = is_null( $sfx ) ? $key : "{$key}_$sfx";
		$lab = is_null( $sfx ) ? $label : "$label [$sfx]";
		?>
		<div class="wpinc-meta-field-row textarea">
			<label for="<?php echo esc_attr( $ni ); ?>"><?php echo esc_html( $lab ); ?></label>
			<div>
				<textarea <?php name_id( $ni ); ?> cols="64" rows="<?php echo esc_attr( $rows ); ?>"><?php echo esc_textarea( $val ); ?></textarea>
			</div>
		</div>
		<?php
	}
	?>
	</div>
	<?php
}

/**
 * Outputs textarea rows for term.
 *
 * @param string $label    Label.
 * @param string $key      Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @param array  $vals     Current values.
 * @param int    $rows     Rows attribute. Default 2.
 */
function output_term_textarea_row_suffix( string $label, string $key, array $suffixes, array $vals, int $rows = 5 ): void {
	wp_enqueue_style( 'wpinc-meta-field' );
	foreach ( $suffixes as $idx => $sfx ) {
		$val = $vals[ $sfx ] ?? '';
		$ni  = is_null( $sfx ) ? $key : "{$key}_$sfx";
		$lab = is_null( $sfx ) ? $label : "$label [$sfx]";
		$cls = ( 0 === $idx ) ? ' wpinc-meta-field-tr-first' : ( ( count( $suffixes ) - 1 === $idx ) ? ' wpinc-meta-field-tr-last' : '' );
		?>
		<tr class="form-field wpinc-meta-field-tr-multiple<?php echo esc_attr( $cls ); ?>">
			<th scope="row"><label for="<?php echo esc_attr( $ni ); ?>"><?php echo esc_html( $lab ); ?></label></th>
			<td><textarea <?php name_id( $ni ); ?> rows="<?php echo esc_attr( $rows ); ?>" cols="50" class="large-text"><?php echo esc_textarea( $val ); ?></textarea></td>
		</tr>
		<?php
	}
}
