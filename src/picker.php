<?php
/**
 * Picker
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-05-31
 */

namespace wpinc\meta;

require_once __DIR__ . '/utility.php';

/**
 * Adds media picker for post meta.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Key.
 * @param string $label   Label.
 */
function add_media_picker_to_post( int $post_id, string $key, string $label ): void {
	$val = get_post_meta( $post_id, $key, true );
	$val = is_numeric( $val ) ? (int) $val : 0;
	output_post_media_picker_row( $label, $key, $val );
}

/**
 * Adds media picker for term meta.
 *
 * @param int    $term_id Term ID.
 * @param string $key     Key.
 * @param string $label   Label.
 */
function add_media_picker_to_term( int $term_id, string $key, string $label ): void {
	$val = get_term_meta( $term_id, $key, true );
	$val = is_numeric( $val ) ? (int) $val : 0;
	output_term_media_picker_row( $label, $key, $val );
}

/**
 * Outputs media picker row for post.
 *
 * @param string $label    Label.
 * @param string $key      Key.
 * @param int    $media_id Media ID.
 */
function output_post_media_picker_row( string $label, string $key, int $media_id = 0 ): void {
	wp_enqueue_script( 'picker-media' );
	wp_enqueue_script( 'wpinc-meta-field' );
	wp_enqueue_style( 'wpinc-meta-field' );

	$src   = '';
	$title = '';
	if ( $media_id ) {
		$ais = wp_get_attachment_image_src( $media_id, 'small' );
		$src = ( false !== $ais ) ? $ais[0] : '';
		$p   = get_post( $media_id );
		if ( $p ) {
			$title = esc_html( $p->post_title );
		}
	}
	?>
	<div id="<?php echo esc_attr( "{$key}-body" ); ?>" class="wpinc-meta-media-picker">
		<label for="<?php echo esc_attr( $key ); ?>_src"><?php echo esc_html( $label ); ?></label>
		<div>
			<div>
				<button type="button" style="background-image:url('<?php echo esc_attr( $src ); ?>');" <?php name_id( "{$key}_src" ); ?> class="button wpinc-meta-media-picker-select"></button>
			</div>
			<div>
				<input type="text" disabled <?php name_id( "{$key}_title" ); ?> value="<?php echo esc_html( $title ); ?>">
				<button type="button" class="wpinc-meta-media-picker-delete"><?php esc_html_e( 'Remove' ); ?></button>
			</div>
		</div>
		<input type="hidden" <?php name_id( $key ); ?> value="<?php echo esc_attr( $media_id ); ?>" />
		<script>window.addEventListener('load', function () { wpinc_meta_media_picker_initialize('<?php echo esc_attr( $key ); ?>'); });</script>
	</div>
	<?php
}

/**
 * Outputs media picker row for term.
 *
 * @param string $label    Label.
 * @param string $key      Key.
 * @param int    $media_id Media ID.
 */
function output_term_media_picker_row( string $label, string $key, int $media_id = 0 ): void {
	wp_enqueue_script( 'picker-media' );
	wp_enqueue_script( 'wpinc-meta-field' );
	wp_enqueue_style( 'wpinc-meta-field' );

	$src   = '';
	$title = '';
	if ( $media_id ) {
		$ais = wp_get_attachment_image_src( $media_id, 'small' );
		$src = ( false !== $ais ) ? $ais[0] : '';
		$p   = get_post( $media_id );
		if ( $p ) {
			$title = esc_html( $p->post_title );
		}
	}
	?>
	<tr class="form-field wpinc-meta-media-picker-tr">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>_src"><?php echo esc_html( $label ); ?></label></th>
		<td id="<?php echo esc_attr( "{$key}-body" ); ?>">
			<div>
				<div>
					<button type="button" style="background-image:url('<?php echo esc_attr( $src ); ?>');" <?php name_id( "{$key}_src" ); ?> class="button wpinc-meta-media-picker-select"></button>
				</div>
				<div>
					<input type="text" disabled <?php name_id( "{$key}_title" ); ?> value="<?php echo esc_html( $title ); ?>">
					<button type="button" class="wpinc-meta-media-picker-delete"><?php esc_html_e( 'Remove' ); ?></button>
				</div>
			</div>
			<input type="hidden" <?php name_id( $key ); ?> value="<?php echo esc_attr( $media_id ); ?>" />
			<script>window.addEventListener('load', function () { wpinc_meta_media_picker_initialize('<?php echo esc_attr( $key ); ?>'); });</script>
		</td>
	<?php
}


// -----------------------------------------------------------------------------


/**
 * Adds date picker for post meta.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Key.
 * @param string $label   Label.
 */
function add_date_picker_to_post( int $post_id, string $key, string $label ): void {
	$val = get_post_meta( $post_id, $key, true );
	output_post_date_picker_row( $label, $key, $val );
}

/**
 * Adds date picker for term meta.
 *
 * @param int    $term_id Term ID.
 * @param string $key     Key.
 * @param string $label   Label.
 */
function add_date_picker_to_term( int $term_id, string $key, string $label ): void {
	$val = get_term_meta( $term_id, $key, true );
	output_term_date_picker_row( $label, $key, $val );
}

/**
 * Outputs date picker row for post.
 *
 * @param string $label Label.
 * @param string $key   Key.
 * @param mixed  $val   Value.
 */
function output_post_date_picker_row( string $label, string $key, $val ): void {
	wp_enqueue_script( 'flatpickr' );
	wp_enqueue_script( 'flatpickr.l10n.ja' );
	wp_enqueue_style( 'flatpickr' );
	wp_enqueue_style( 'wpinc-meta-field' );

	$val = $val ?? '';
	$loc = strtolower( str_replace( '_', '-', get_user_locale() ) );
	?>
	<div class="wpinc-meta-date-picker">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div class="flatpickr input-group" id="<?php echo esc_attr( $key ); ?>_row">
			<input type="text" <?php name_id( $key ); ?> size="12" value="<?php echo esc_attr( $val ); ?>" data-input>
			<a class="button" title="clear" data-clear>X</a>
		</div>
		<script>window.addEventListener('load', function () { flatpickr('#<?php echo esc_attr( $key ); ?>_row', { locale: '<?php echo esc_html( $loc ); ?>', wrap: true }); });</script>
	</div>
	<?php
}

/**
 * Outputs date picker row for term.
 *
 * @param string $label Label.
 * @param string $key   Key.
 * @param mixed  $val   Value.
 */
function output_term_date_picker_row( string $label, string $key, $val ): void {
	wp_enqueue_script( 'flatpickr' );
	wp_enqueue_script( 'flatpickr.l10n.ja' );
	wp_enqueue_style( 'flatpickr' );
	wp_enqueue_style( 'wpinc-meta-field' );

	$val = $val ?? '';
	$loc = strtolower( str_replace( '_', '-', get_user_locale() ) );
	?>
	<tr class="form-field wpinc-meta-date-picker-tr">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td class="flatpickr input-group" id="<?php echo esc_attr( $key ); ?>_row">
			<input type="text" <?php name_id( $key ); ?> size="12" value="<?php echo esc_attr( $val ); ?>" data-input>
			<a class="button" title="clear" data-clear>X</a>
		</td>
		<script>window.addEventListener('load', function () { flatpickr('#<?php echo esc_attr( $key ); ?>_row', { locale: '<?php echo esc_html( $loc ); ?>', wrap: true }); });</script>
	</tr>
	<?php
}
