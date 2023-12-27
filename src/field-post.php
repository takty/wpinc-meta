<?php
/**
 * Fields for Post
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-12-27
 */

declare(strict_types=1);

namespace wpinc\meta;

require_once __DIR__ . '/utility.php';

/**
 * Adds a separator to post.
 */
function add_separator_to_post(): void {
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
	$val = is_string( $val ) ? $val : '';
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
	$val = is_string( $val ) ? $val : '';
	output_post_textarea_row( $label, $key, $val, $rows );
}

/**
 * Adds a rich editor to post.
 *
 * @param int                  $post_id  Post ID.
 * @param string               $key      Meta key.
 * @param string               $label    Label.
 * @param array<string, mixed> $settings Settings for wp_editor.
 */
function add_rich_editor_to_post( int $post_id, string $key, string $label, array $settings = array() ): void {
	$val = get_post_meta( $post_id, $key, true );
	$val = is_string( $val ) ? $val : '';
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
 * Adds a post select to post.
 *
 * @param int        $post_id Post ID.
 * @param string     $key     Meta key.
 * @param string     $label   Label.
 * @param \WP_Post[] $posts   Posts to be selected.
 */
function add_post_select_to_post( int $post_id, string $key, string $label, array $posts ): void {
	$val = get_post_meta( $post_id, $key, true );
	$val = is_numeric( $val ) ? (int) $val : 0;
	output_post_post_select_row( $label, $key, $posts, $val );
}


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -.


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
	$val = is_string( $val ) ? $val : '';
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
	$val   = is_string( $val ) ? $val : '';
	$terms = get_the_terms( $post_id, $taxonomy );
	if ( is_array( $terms ) ) {
		output_post_term_select_row( $label, $key, $terms, $val, $field );
	}
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
 * @param string $val   Current value.
 * @param string $type  Input type. Default 'text'.
 */
function output_post_input_row( string $label, string $key, string $val, string $type = 'text' ): void {
	wp_enqueue_style( 'wpinc-meta' );
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
 * @param string $val   Current value.
 * @param int    $rows  Rows attribute. Default 2.
 */
function output_post_textarea_row( string $label, string $key, string $val, int $rows = 2 ): void {
	wp_enqueue_style( 'wpinc-meta' );
	?>
	<div class="wpinc-meta-field-row textarea">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div>
			<textarea <?php name_id( $key ); ?> cols="64" rows="<?php echo esc_attr( (string) $rows ); ?>"><?php echo esc_textarea( $val ); ?></textarea>
		</div>
	</div>
	<?php
}

/**
 * Outputs a rich editor row to post.
 *
 * @psalm-suppress ArgumentTypeCoercion
 *
 * @param string               $label    Label.
 * @param string               $key      Meta key.
 * @param string               $val      Current value.
 * @param array<string, mixed> $settings Settings for wp_editor.
 */
function output_post_rich_editor_row( string $label, string $key, string $val, array $settings = array() ): void {
	wp_enqueue_style( 'wpinc-meta' );
	$cls = '';
	if ( isset( $settings['media_buttons'] ) && false === $settings['media_buttons'] ) {
		$cls = ' no-media-button';
	}
	?>
	<div class="wpinc-meta-field-rich-editor<?php echo esc_attr( $cls ); ?>">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<?php wp_editor( $val, $key, $settings );  // @phpstan-ignore-line ?>
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
 * Outputs a post select row to post.
 *
 * @param string     $label Label.
 * @param string     $key   Meta key.
 * @param \WP_Post[] $posts Posts to be selected.
 * @param int        $val   Current value.
 */
function output_post_post_select_row( string $label, string $key, array $posts, int $val ): void {
	wp_enqueue_style( 'wpinc-meta' );
	?>
	<div class="wpinc-meta-field-row select">
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
		<div>
			<select <?php name_id( $key ); ?>">
	<?php
	foreach ( $posts as $p ) {
		$name = $p->post_title;
		$id   = $p->ID;
		echo '<option value="' . esc_attr( (string) $id ) . '"' . selected( $id, $val, false ) . '>' . esc_html( $name ) . '</option>';
	}
	?>
			</select>
		</div>
	</div>
	<?php
}


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -.


/**
 * Outputs a term select row to post.
 *
 * @param string            $label             Label.
 * @param string            $key               Meta key.
 * @param string|\WP_Term[] $taxonomy_or_terms Taxonomy slug or term objects.
 * @param string            $val               Current value.
 * @param string            $field             Term field.
 */
function output_post_term_select_row( string $label, string $key, $taxonomy_or_terms, string $val, string $field = 'slug' ): void {
	wp_enqueue_style( 'wpinc-meta' );
	if ( is_array( $taxonomy_or_terms ) ) {
		$terms = $taxonomy_or_terms;
	} else {
		/**
		 * Terms. This is determined by $args['fields'] being 'all'.
		 *
		 * @var \WP_Term[]|\WP_Error $terms
		 */
		$terms = get_terms( array( 'taxonomy' => $taxonomy_or_terms ) );
		$terms = is_array( $terms ) ? $terms : array();
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
		if ( ! is_string( $tf ) ) {
			continue;
		}
		echo '<option value="' . esc_attr( $tf ) . '"' . selected( $tf, $val, false ) . '>' . esc_html( $name ) . '</option>';
	}
	?>
			</select>
		</div>
	</div>
	<?php
}
