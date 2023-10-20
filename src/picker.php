<?php
/**
 * Pickers
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-10-20
 */

declare(strict_types=1);

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
	wp_enqueue_media();
	wp_enqueue_script( 'wpinc-meta-picker-media' );
	wp_enqueue_script( 'wpinc-meta-media-picker' );
	wp_enqueue_style( 'wpinc-meta' );

	$src   = '';
	$title = '';
	if ( $media_id ) {
		$ais = wp_get_attachment_image_src( $media_id, 'small' );
		$src = ( false !== $ais ) ? $ais[0] : '';
		$p   = get_post( $media_id );
		if ( $p instanceof \WP_Post ) {
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
		<input type="hidden" <?php name_id( $key ); ?> value="<?php echo esc_attr( (string) $media_id ); ?>" />
		<script>window.addEventListener('load', () => { wpinc_meta_media_picker_initialize('<?php echo esc_attr( $key ); ?>'); });</script>
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
	wp_enqueue_media();
	wp_enqueue_script( 'wpinc-meta-picker-media' );
	wp_enqueue_script( 'wpinc-meta-media-picker' );
	wp_enqueue_style( 'wpinc-meta' );

	$src   = '';
	$title = '';
	if ( $media_id ) {
		$ais = wp_get_attachment_image_src( $media_id, 'small' );
		$src = ( false !== $ais ) ? $ais[0] : '';
		$p   = get_post( $media_id );
		if ( $p instanceof \WP_Post ) {
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
			<input type="hidden" <?php name_id( $key ); ?> value="<?php echo esc_attr( (string) $media_id ); ?>" />
			<script>window.addEventListener('load', () => { wpinc_meta_media_picker_initialize('<?php echo esc_attr( $key ); ?>'); });</script>
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
	$val = is_string( $val ) ? $val : '';
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
	$val = is_string( $val ) ? $val : '';
	output_term_date_picker_row( $label, $key, $val );
}

/**
 * Outputs date picker row for post.
 *
 * @param string $label Label.
 * @param string $key   Key.
 * @param string $val   Value.
 */
function output_post_date_picker_row( string $label, string $key, string $val ): void {
	wp_enqueue_script( 'flatpickr' );
	wp_enqueue_script( 'flatpickr.l10n.ja' );
	wp_enqueue_style( 'flatpickr' );
	wp_enqueue_style( 'wpinc-meta' );

	$loc = strtolower( str_replace( '_', '-', get_user_locale() ) );
	?>
	<div class="wpinc-meta-date-picker">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div class="flatpickr input-group" id="<?php echo esc_attr( $key ); ?>_row">
			<input type="text" <?php name_id( $key ); ?> size="12" value="<?php echo esc_attr( $val ); ?>" data-input>
			<a class="button" title="clear" data-clear>X</a>
		</div>
		<script>window.addEventListener('load', () => { flatpickr('#<?php echo esc_attr( $key ); ?>_row', { locale: '<?php echo esc_html( $loc ); ?>', wrap: true }); });</script>
	</div>
	<?php
}

/**
 * Outputs date picker row for term.
 *
 * @param string $label Label.
 * @param string $key   Key.
 * @param string $val   Value.
 */
function output_term_date_picker_row( string $label, string $key, string $val ): void {
	wp_enqueue_script( 'flatpickr' );
	wp_enqueue_script( 'flatpickr.l10n.ja' );
	wp_enqueue_style( 'flatpickr' );
	wp_enqueue_style( 'wpinc-meta' );

	$loc = strtolower( str_replace( '_', '-', get_user_locale() ) );
	?>
	<tr class="form-field wpinc-meta-date-picker-tr">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td class="flatpickr input-group" id="<?php echo esc_attr( $key ); ?>_row">
			<input type="text" <?php name_id( $key ); ?> size="12" value="<?php echo esc_attr( $val ); ?>" data-input>
			<a class="button" title="clear" data-clear>X</a>
		</td>
		<script>window.addEventListener('load', () => { flatpickr('#<?php echo esc_attr( $key ); ?>_row', { locale: '<?php echo esc_html( $loc ); ?>', wrap: true }); });</script>
	</tr>
	<?php
}


// -----------------------------------------------------------------------------


/** phpcs:ignore
 * Adds color picker for post meta.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Key.
 * @param string $label   Label.
 * phpcs:ignore
 * @param array{
 *     placeholder?: string,
 *     default?    : string,
 * } $opts Options.
 *
 * $opts {
 *     Options.
 *
 *     @type string 'placeholder' Placeholder of the input. Default ''.
 *     @type string 'default'     Default color. Default ''.
 * }
 */
function add_color_picker_to_post( int $post_id, string $key, string $label, array $opts = array() ): void {
	$val = get_post_meta( $post_id, $key, true );
	$val = is_string( $val ) ? $val : '';
	if ( empty( $val ) && ! empty( $opts['default'] ) ) {
		$val = $opts['default'];
	}
	output_post_color_picker_row( $label, $key, $val, $opts );
}

/** phpcs:ignore
 * Adds color picker for term meta.
 *
 * @param int    $term_id Term ID.
 * @param string $key     Key.
 * @param string $label   Label.
 * phpcs:ignore
 * @param array{
 *     placeholder?: string,
 *     default?    : string,
 * } $opts Options.
 *
 * $opts {
 *     Options.
 *
 *     @type string 'placeholder' Placeholder of the input. Default ''.
 *     @type string 'default'     Default color. Default ''.
 * }
 */
function add_color_picker_to_term( int $term_id, string $key, string $label, array $opts = array() ): void {
	$val = get_term_meta( $term_id, $key, true );
	$val = is_string( $val ) ? $val : '';
	if ( empty( $val ) && ! empty( $opts['default'] ) ) {
		$val = $opts['default'];
	}
	output_term_color_picker_row( $label, $key, $val, $opts );
}

/**
 * Outputs color picker row for post.
 *
 * @param string               $label Label.
 * @param string               $key   Key.
 * @param string               $val   Value.
 * @param array<string, mixed> $opts  Options.
 */
function output_post_color_picker_row( string $label, string $key, string $val, array $opts = array() ): void {
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'wpinc-meta' );
	wp_add_inline_script( 'wp-color-picker', 'jQuery(document).ready(function($){$(\'.wpinc-meta-color-picker input\').wpColorPicker();});' );

	$ph  = is_string( $opts['placeholder'] ) ? $opts['placeholder'] : '';
	$def = is_string( $opts['default'] ) ? $opts['default'] : '';
	?>
	<div class="wpinc-meta-color-picker">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div>
			<input type="text" <?php name_id( $key ); ?> value="<?php echo esc_attr( $val ); ?>" maxlength="7" placeholder="<?php echo esc_attr( $ph ); ?>" data-default-color="<?php echo esc_attr( $def ); ?>">
		</div>
	</div>
	<?php
}

/**
 * Outputs color picker row for term.
 *
 * @param string               $label Label.
 * @param string               $key   Key.
 * @param string               $val   Value.
 * @param array<string, mixed> $opts  Options.
 */
function output_term_color_picker_row( string $label, string $key, string $val, array $opts = array() ): void {
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'wpinc-meta' );
	wp_add_inline_script( 'wp-color-picker', 'jQuery(document).ready(function($){$(\'.wpinc-meta-color-picker-tr input\').wpColorPicker();});' );

	$ph  = is_string( $opts['placeholder'] ) ? $opts['placeholder'] : '';
	$def = is_string( $opts['default'] ) ? $opts['default'] : '';
	?>
	<tr class="form-field wpinc-meta-color-picker-tr">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td id="<?php echo esc_attr( $key ); ?>_row">
			<input type="text" <?php name_id( $key ); ?> value="<?php echo esc_attr( $val ); ?>" maxlength="7" placeholder="<?php echo esc_attr( $ph ); ?>" data-default-color="<?php echo esc_attr( $def ); ?>">
		</td>
	</tr>
	<?php
}


// -----------------------------------------------------------------------------


/** phpcs:ignore
 * Adds color hue picker for post meta.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Key.
 * @param string $label   Label.
 * phpcs:ignore
 * @param array{
 *     placeholder?: string,
 *     default?    : string,
 * } $opts Options.
 *
 * $opts {
 *     Options.
 *
 *     @type string 'placeholder' Placeholder of the input. Default ''.
 *     @type string 'default'     Default color. Default ''.
 * }
 */
function add_color_hue_picker_to_post( int $post_id, string $key, string $label, array $opts = array() ): void {
	$val = get_post_meta( $post_id, $key, true );
	$val = is_string( $val ) ? $val : '';
	if ( empty( $val ) && ! empty( $opts['default'] ) ) {
		$val = $opts['default'];
	}
	output_post_color_hue_picker_row( $label, $key, $val, $opts );
}

/** phpcs:ignore
 * Adds color hue picker for term meta.
 *
 * @param int    $term_id Term ID.
 * @param string $key     Key.
 * @param string $label   Label.
 * phpcs:ignore
 * @param array{
 *     placeholder?: string,
 *     default?    : string,
 * } $opts Options.
 *
 * $opts {
 *     Options.
 *
 *     @type string 'placeholder' Placeholder of the input. Default ''.
 *     @type string 'default'     Default color. Default ''.
 * }
 */
function add_color_hue_picker_to_term( int $term_id, string $key, string $label, array $opts = array() ): void {
	$val = get_term_meta( $term_id, $key, true );
	$val = is_string( $val ) ? $val : '';
	if ( empty( $val ) && ! empty( $opts['default'] ) ) {
		$val = $opts['default'];
	}
	output_term_color_hue_picker_row( $label, $key, $val, $opts );
}

/**
 * Outputs color hue picker row for post.
 *
 * @param string               $label Label.
 * @param string               $key   Key.
 * @param string               $val   Value.
 * @param array<string, mixed> $opts  Options.
 */
function output_post_color_hue_picker_row( string $label, string $key, string $val, array $opts = array() ): void {
	wp_enqueue_script( 'colorjst' );
	wp_enqueue_style( 'wpinc-meta' );
	wp_enqueue_script( 'wpinc-meta-color-hue-picker' );

	$def = is_string( $opts['default'] ) ? $opts['default'] : '';
	?>
	<div id="<?php echo esc_attr( "{$key}-body" ); ?>" class="wpinc-meta-color-hue-picker">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div>
			<span class="wpinc-meta-color-hue-picker-sample"></span>
			<input type="range" class="wpinc-meta-color-hue-picker-h" min="0" max="359">
	<?php if ( ! empty( $def ) ) : ?>
			<button type="button" class="button button-small wpinc-meta-color-hue-picker-default" aria-label="<?php echo esc_attr( __( 'Select default color' ) ); ?>"><?php esc_html_e( 'Default' ); ?></button>
	<?php endif; ?>
		</div>
		<input type="hidden" <?php name_id( $key ); ?> value="<?php echo esc_attr( $val ); ?>" data-default-color="<?php echo esc_attr( $def ); ?>">
		<input type="hidden" class="wpinc-meta-color-hue-picker-l">
		<input type="hidden" class="wpinc-meta-color-hue-picker-c">
		<script>window.addEventListener('load', () => { wpinc_meta_color_hue_picker_initialize('<?php echo esc_attr( $key ); ?>'); });</script>
	</div>
	<?php
}

/**
 * Outputs color hue picker row for term.
 *
 * @param string               $label Label.
 * @param string               $key   Key.
 * @param string               $val   Value.
 * @param array<string, mixed> $opts  Options.
 */
function output_term_color_hue_picker_row( string $label, string $key, string $val, array $opts = array() ): void {
	wp_enqueue_script( 'colorjst' );
	wp_enqueue_style( 'wpinc-meta' );
	wp_enqueue_script( 'wpinc-meta-color-hue-picker' );

	$def = is_string( $opts['default'] ) ? $opts['default'] : '';
	?>
	<tr class="form-field wpinc-meta-color-hue-picker-tr">
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td id="<?php echo esc_attr( "{$key}-body" ); ?>">
			<div>
				<span class="wpinc-meta-color-hue-picker-sample"></span>
				<input type="range" class="wpinc-meta-color-hue-picker-h" min="0" max="359">
	<?php if ( ! empty( $def ) ) : ?>
				<button type="button" class="button button-small wpinc-meta-color-hue-picker-default" aria-label="<?php echo esc_attr( __( 'Select default color' ) ); ?>"><?php esc_html_e( 'Default' ); ?></button>
	<?php endif; ?>
			</div>
			<input type="hidden" <?php name_id( $key ); ?> value="<?php echo esc_attr( $val ); ?>" data-default-color="<?php echo esc_attr( $def ); ?>">
			<input type="hidden" class="wpinc-meta-color-hue-picker-l">
			<input type="hidden" class="wpinc-meta-color-hue-picker-c">
			<script>window.addEventListener('load', () => { wpinc_meta_color_hue_picker_initialize('<?php echo esc_attr( $key ); ?>'); });</script>
		</td>
	</tr>
	<?php
}
