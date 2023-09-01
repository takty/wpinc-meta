<?php
/**
 * Sub Post-*
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-08-30
 */

namespace wpinc\meta;

/**
 * Retrieves sub post title.
 *
 * @param string       $meta_key Post meta key.
 * @param int|\WP_Post $post     (Optional) Post ID or WP_Post object. Default is global $post.
 * @return string Sub post title.
 */
function get_the_sub_title( string $meta_key, $post = 0 ): string {
	if ( WP_DEBUG ) {
		trigger_error( 'Use function \'\\wpinc\\post\\get_the_title\' instead.', E_USER_DEPRECATED );  // phpcs:ignore
	}
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}
	$title = get_post_meta( $post->ID, $meta_key, true );

	$ls = preg_split( '/<\s*br\s*\/?>/iu', $title );
	if ( ! $ls ) {
		return $title;
	}
	return implode( '<br>', array_map( 'wp_kses_post', $ls ) );
}

/**
 * Display sub post title with optional markup.
 *
 * @param string       $meta_key Post meta key.
 * @param string       $before   (Optional) Markup to prepend to the title. Default ''.
 * @param string       $after    (Optional) Markup to append to the title. Default ''.
 * @param int|\WP_Post $post     (Optional) Post ID or WP_Post object. Default is global $post.
 */
function the_sub_title( string $meta_key, string $before = '', string $after = '', $post = 0 ): void {
	if ( WP_DEBUG ) {
		trigger_error( 'Use function \'\\wpinc\\post\\the_title\' instead.', E_USER_DEPRECATED );  // phpcs:ignore
	}
	$title = get_the_sub_title( $meta_key, $post );
	if ( empty( $title ) ) {
		return;
	}
	$title = $before . $title . $after;
	echo $title;  // phpcs:ignore
}


// -----------------------------------------------------------------------------


/**
 * Retrieves sub post content.
 *
 * @param string       $meta_key Post meta key.
 * @param int|\WP_Post $post     (Optional) Post ID or WP_Post object. Default is global $post.
 * @return string Sub post content.
 */
function get_the_sub_content( string $meta_key, $post = 0 ): string {
	if ( WP_DEBUG ) {
		trigger_error( 'Use function \'\\wpinc\\post\\get_the_content\' instead.', E_USER_DEPRECATED );  // phpcs:ignore
	}
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}
	$content = get_post_meta( $post->ID, $meta_key, true );
	return $content;
}

/**
 * Display the sub post content.
 *
 * @param string       $meta_key Post meta key.
 * @param int|\WP_Post $post     (Optional) Post ID or WP_Post object. Default is global $post.
 */
function the_sub_content( string $meta_key, $post = 0 ): void {
	if ( WP_DEBUG ) {
		trigger_error( 'Use function \'\\wpinc\\post\\the_content\' instead.', E_USER_DEPRECATED );  // phpcs:ignore
	}
	$content = get_the_sub_content( $meta_key, $post );
	if ( empty( $content ) ) {
		return;
	}
	$content = filter_content( $content );
	echo $content;  // phpcs:ignore
}

/**
 * Apply content filters to string.
 *
 * @param string $str String.
 * @return string Filtered string.
 */
function filter_content( string $str ): string {
	if ( WP_DEBUG ) {
		trigger_error( 'Use function \'\\wpinc\\post\\process_content\' instead.', E_USER_DEPRECATED );  // phpcs:ignore
	}
	$str = apply_filters( 'the_content', $str );  // Shortcodes are expanded here.
	$str = str_replace( ']]>', ']]&gt;', $str );
	return $str;
}
