<?php
/**
 * Key with Postfix
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-06-02
 */

namespace wpinc\meta;

require_once __DIR__ . '/utility.php';

/**
 * Adds multiple input to post.
 *
 * @param int    $post_id   Post ID.
 * @param string $key       Meta key base.
 * @param array  $postfixes Meta key postfixes.
 * @param string $label     Label.
 * @param string $type      Input type. Default 'text'.
 */
function add_input_postfix_to_post( int $post_id, string $key, array $postfixes, string $label, string $type = 'text' ): void {
	$vals = get_post_meta_postfix( $post_id, $key, $postfixes );
	output_post_input_row_postfix( $label, $key, $postfixes, $vals, $type );
}

/**
 * Adds multiple input to term.
 *
 * @param int    $term_id   Term ID.
 * @param string $key       Meta key base.
 * @param array  $postfixes Meta key postfixes.
 * @param string $label     Label.
 * @param string $type      Input type. Default 'text'.
 */
function add_input_postfix_to_term( int $term_id, string $key, array $postfixes, string $label, string $type = 'text' ): void {
	$vals = get_term_meta_postfix( $term_id, $key, $postfixes );
	output_term_input_row_postfix( $label, $key, $postfixes, $vals, $type );
}

/**
 * Outputs input rows to post.
 *
 * @param string $label     Label.
 * @param string $key       Meta key base.
 * @param array  $postfixes Meta key postfixes.
 * @param array  $vals      Current values.
 * @param string $type      Input type. Default 'text'.
 */
function output_post_input_row_postfix( string $label, string $key, array $postfixes, array $vals, string $type = 'text' ): void {
	wp_enqueue_style( 'wpinc-meta-field' );
	?>
	<div class="wpinc-meta-field-group">
	<?php
	foreach ( $postfixes as $pf ) {
		$val = $vals[ $pf ] ?? '';
		$ni  = is_null( $pf ) ? $key : "{$key}_$pf";
		?>
		<div class="wpinc-meta-field-row">
			<label for="<?php echo esc_attr( $ni ); ?>"><?php echo esc_html( "$label [$pf]" ); ?></label>
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
 * @param string $label     Label.
 * @param string $key       Meta key base.
 * @param array  $postfixes Meta key postfixes.
 * @param array  $vals      Current values.
 * @param string $type      Input type. Default 'text'.
 */
function output_term_input_row_postfix( string $label, string $key, array $postfixes, array $vals, string $type = 'text' ): void {
	wp_enqueue_style( 'wpinc-meta-field' );
	foreach ( $postfixes as $idx => $pf ) {
		$val = $vals[ $pf ] ?? '';
		$ni  = is_null( $pf ) ? $key : "{$key}_$pf";
		$cls = ( 0 === $idx ) ? ' wpinc-meta-field-tr-first' : ( ( count( $postfixes ) - 1 === $idx ) ? ' wpinc-meta-field-tr-last' : '' );
		?>
		<tr class="form-field wpinc-meta-field-tr-multiple<?php echo esc_attr( $cls ); ?>">
			<th scope="row"><label for="<?php echo esc_attr( $ni ); ?>"><?php echo esc_html( "$label [$pf]" ); ?></label></th>
			<td><input type="<?php echo esc_attr( $type ); ?>" <?php name_id( $ni ); ?> size="40" value="<?php echo esc_attr( $val ); ?>"></td>
		</tr>
		<?php
	}
}


// -----------------------------------------------------------------------------


/**
 * Adds multiple textarea to post.
 *
 * @param int    $post_id   Post ID.
 * @param string $key       Meta key base.
 * @param array  $postfixes Meta key postfixes.
 * @param string $label     Label.
 * @param int    $rows      Rows attribute. Default 2.
 */
function add_textarea_postfix_to_post( int $post_id, string $key, array $postfixes, string $label, int $rows = 2 ): void {
	$vals = get_post_meta_postfix( $post_id, $key, $postfixes );
	output_post_textarea_row_postfix( $label, $key, $postfixes, $vals, $rows );
}

/**
 * Adds multiple textarea to term.
 *
 * @param int    $term_id   Term ID.
 * @param string $key       Meta key base.
 * @param array  $postfixes Meta key postfixes.
 * @param string $label     Label.
 * @param int    $rows      Rows attribute. Default 2.
 */
function add_textarea_postfix_to_term( int $term_id, string $key, array $postfixes, string $label, int $rows = 5 ): void {
	$vals = get_term_meta_postfix( $term_id, $key, $postfixes );
	output_term_textarea_row_postfix( $label, $key, $postfixes, $vals, $rows );
}

/**
 * Outputs textarea rows for post.
 *
 * @param string $label     Label.
 * @param string $key       Meta key base.
 * @param array  $postfixes Meta key postfixes.
 * @param array  $vals      Current values.
 * @param int    $rows      Rows attribute. Default 2.
 */
function output_post_textarea_row_postfix( string $label, string $key, array $postfixes, array $vals, int $rows = 2 ): void {
	wp_enqueue_style( 'wpinc-meta-field' );
	?>
	<div class="wpinc-meta-field-group">
	<?php
	foreach ( $postfixes as $pf ) {
		$val = $vals[ $pf ] ?? '';
		$ni  = is_null( $pf ) ? $key : "{$key}_$pf";
		?>
		<div class="wpinc-meta-field-row textarea">
			<label for="<?php echo esc_attr( $ni ); ?>"><?php echo esc_html( "$label [$pf]" ); ?></label>
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
 * @param string $label     Label.
 * @param string $key       Meta key base.
 * @param array  $postfixes Meta key postfixes.
 * @param array  $vals      Current values.
 * @param int    $rows      Rows attribute. Default 2.
 */
function output_term_textarea_row_postfix( string $label, string $key, array $postfixes, array $vals, int $rows = 5 ): void {
	wp_enqueue_style( 'wpinc-meta-field' );
	foreach ( $postfixes as $idx => $pf ) {
		$val = $vals[ $pf ] ?? '';
		$ni  = is_null( $pf ) ? $key : "{$key}_$pf";
		$cls = ( 0 === $idx ) ? ' wpinc-meta-field-tr-first' : ( ( count( $postfixes ) - 1 === $idx ) ? ' wpinc-meta-field-tr-last' : '' );
		?>
		<tr class="form-field wpinc-meta-field-tr-multiple<?php echo esc_attr( $cls ); ?>">
			<th scope="row"><label for="<?php echo esc_attr( $ni ); ?>"><?php echo esc_html( "$label [$pf]" ); ?></label></th>
			<td><textarea <?php name_id( $ni ); ?> rows="<?php echo esc_attr( $rows ); ?>" cols="50" class="large-text"><?php echo esc_textarea( $val ); ?></textarea></td>
		</tr>
		<?php
	}
}
