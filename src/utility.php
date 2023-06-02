<?php
/**
 * Custom Field Utilities
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2023-06-02
 */

namespace wpinc\meta;

/**
 * Retrieve post meta values of keys with suffixes.
 *
 * @param int    $post_id   Post ID.
 * @param string $key       Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @return array Values.
 */
function get_post_meta_suffix( int $post_id, string $key, array $suffixes ): array {
	$vals = array();
	foreach ( $suffixes as $sfx ) {
		$vals[ $sfx ] = get_post_meta( $post_id, is_null( $sfx ) ? $key : "{$key}_$sfx", true );
	}
	return $vals;
}

/**
 * Retrieves a post meta field as date.
 *
 * @param int         $post_id Post ID.
 * @param string      $key     The meta key to retrieve.
 * @param string|null $format  Date format.
 * @return string Date string.
 */
function get_post_meta_date( int $post_id, string $key, ?string $format = null ) {
	$format ??= get_option( 'date_format' );

	$val = mb_trim( get_post_meta( $post_id, $key, true ) );
	return mysql2date( $format, $val );
}

/**
 * Retrieves a post meta field as multiple lines.
 *
 * @param int    $post_id Post ID.
 * @param string $key     The meta key to retrieve.
 * @return string[] Lines.
 */
function get_post_meta_lines( int $post_id, string $key ): array {
	$val  = mb_trim( get_post_meta( $post_id, $key, true ) );
	$vals = explode( "\n", $val );
	$vals = array_map( '\wpinc\meta\mb_trim', $vals );
	$vals = array_filter( $vals );
	return array_values( $vals );
}

/**
 * Retrieve term meta values of keys with suffixes.
 *
 * @param int    $term_id   Term ID.
 * @param string $key       Meta key base.
 * @param array  $suffixes Meta key suffixes.
 * @return array Values.
 */
function get_term_meta_suffix( int $term_id, string $key, array $suffixes ): array {
	$vals = array();
	foreach ( $suffixes as $sfx ) {
		$vals[ $sfx ] = get_term_meta( $term_id, is_null( $sfx ) ? $key : "{$key}_$sfx", true );
	}
	return $vals;
}

/**
 * Retrieves a term meta field as date.
 *
 * @param int         $term_id Term ID.
 * @param string      $key     The meta key to retrieve.
 * @param string|null $format  Date format.
 * @return string Date string.
 */
function get_term_meta_date( int $term_id, string $key, ?string $format = null ) {
	$format ??= get_option( 'date_format' );

	$val = mb_trim( get_term_meta( $term_id, $key, true ) );
	return mysql2date( $format, $val );
}

/**
 * Retrieves a term meta field as multiple lines.
 *
 * @param int    $term_id Term ID.
 * @param string $key     The meta key to retrieve.
 * @return string[] Lines.
 */
function get_term_meta_lines( int $term_id, string $key ): array {
	$val  = mb_trim( get_term_meta( $term_id, $key, true ) );
	$vals = explode( "\n", $val );
	$vals = array_map( '\wpinc\meta\mb_trim', $vals );
	$vals = array_filter( $vals );
	return array_values( $vals );
}


// -----------------------------------------------------------------------------


/**
 * Stores a post meta field.
 *
 * @param int           $post_id Post ID.
 * @param string        $key     Metadata key.
 * @param callable|null $filter  Filter.
 * @param mixed|null    $default Default value.
 */
function set_post_meta( int $post_id, string $key, ?callable $filter = null, $default = null ): void {
	$val = $_POST[ $key ] ?? null;  // phpcs:ignore
	if ( null !== $filter && null !== $val ) {
		$val = $filter( $val );
	}
	if ( empty( $val ) ) {
		if ( null === $default ) {
			delete_post_meta( $post_id, $key );
			return;
		}
		$val = $default;
	}
	update_post_meta( $post_id, $key, $val );
}

/**
 * Stores a post meta field after applying filters.
 *
 * @param int         $post_id     Post ID.
 * @param string      $key         Metadata key.
 * @param string|null $filter_name Filter name.
 * @param mixed|null  $default     Default value.
 */
function set_post_meta_with_wp_filter( int $post_id, string $key, ?string $filter_name = null, $default = null ): void {
	$val = $_POST[ $key ] ?? null;  // phpcs:ignore
	if ( null !== $filter_name && null !== $val ) {
		$val = apply_filters( $filter_name, $val );
	}
	if ( empty( $val ) ) {
		if ( null === $default ) {
			delete_post_meta( $post_id, $key );
			return;
		}
		$val = $default;
	}
	update_post_meta( $post_id, $key, $val );
}

/**
 * Stores post meta values of keys with suffixes.
 *
 * @param int           $post_id   Post ID.
 * @param string        $key       Meta key base.
 * @param array         $suffixes Meta key suffixes.
 * @param callable|null $filter    Filter function.
 */
function set_post_meta_suffix( int $post_id, string $key, array $suffixes, ?callable $filter = null ): void {
	foreach ( $suffixes as $sfx ) {
		\wpinc\meta\set_post_meta( $post_id, is_null( $sfx ) ? $key : "{$key}_$sfx", $filter );
	}
}

/**
 * Stores a term meta field.
 *
 * @param int           $term_id Term ID.
 * @param string        $key     Metadata key.
 * @param callable|null $filter  Filter.
 * @param mixed|null    $default Default value.
 */
function set_term_meta( int $term_id, string $key, ?callable $filter = null, $default = null ): void {
	$val = $_POST[ $key ] ?? null;  // phpcs:ignore
	if ( null !== $filter && null !== $val ) {
		$val = $filter( $val );
	}
	if ( empty( $val ) ) {
		if ( null === $default ) {
			delete_term_meta( $term_id, $key );
			return;
		}
		$val = $default;
	}
	update_term_meta( $term_id, $key, $val );
}

/**
 * Stores a term meta field after applying filters.
 *
 * @param int         $term_id     Term ID.
 * @param string      $key         Metadata key.
 * @param string|null $filter_name Filter name.
 * @param mixed|null  $default     Default value.
 */
function set_term_meta_with_wp_filter( int $term_id, string $key, ?string $filter_name = null, $default = null ): void {
	$val = $_POST[ $key ] ?? null;  // phpcs:ignore
	if ( null !== $filter_name && null !== $val ) {
		$val = apply_filters( $filter_name, $val );
	}
	if ( empty( $val ) ) {
		if ( null === $default ) {
			delete_term_meta( $term_id, $key );
			return;
		}
		$val = $default;
	}
	update_term_meta( $term_id, $key, $val );
}

/**
 * Stores term meta values of keys with suffixes.
 *
 * @param int           $term_id   Term ID.
 * @param string        $key       Meta key base.
 * @param array         $suffixes Meta key suffixes.
 * @param callable|null $filter    Filter function.
 */
function set_term_meta_suffix( int $term_id, string $key, array $suffixes, ?callable $filter = null ): void {
	foreach ( $suffixes as $sfx ) {
		\wpinc\meta\set_term_meta( $term_id, is_null( $sfx ) ? $key : "{$key}_$sfx", $filter );
	}
}


// -----------------------------------------------------------------------------


/**
 * Trims string.
 *
 * @param string $str String.
 * @return string Trimmed string.
 */
function mb_trim( string $str ): string {
	return preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $str );
}

/**
 * Outputs name and id attributes.
 *
 * @param string $key Key.
 */
function name_id( string $key ): void {
	echo 'name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '"';
}

/**
 * Normalizes date string.
 *
 * @param string $str String representing date.
 * @return string Normalized string.
 */
function normalize_date( string $str ): string {
	$str  = mb_convert_kana( $str, 'n', 'utf-8' );
	$nums = preg_split( '/\D/', $str );
	$vals = array();
	foreach ( $nums as $num ) {
		$v = (int) trim( $num );
		if ( 0 !== $v ) {
			$vals[] = $v;
		}
	}
	if ( 3 <= count( $vals ) ) {
		$str = sprintf( '%04d-%02d-%02d', $vals[0], $vals[1], $vals[2] );
	} elseif ( count( $vals ) === 2 ) {
		$str = sprintf( '%04d-%02d', $vals[0], $vals[1] );
	} elseif ( count( $vals ) === 1 ) {
		$str = sprintf( '%04d', $vals[0] );
	}
	return $str;
}

/**
 * Normalizes YouTube video ID.
 *
 * @param string $str String of YouTube video ID.
 * @return string Normalized YouTube video ID.
 */
function normalize_youtube_video_id( string $str ): string {
	$pu = wp_parse_url( trim( $str ) );
	if ( $pu ) {
		if ( 'youtu.be' === $pu['host'] ) {
			return trim( $pu['path'], '/' );
		}
		if ( 'www.youtube.com' === $pu['host'] ) {
			$q  = $pu['query'];
			$qs = explode( '&', $q );

			foreach ( $qs as $qp ) {
				list( $key, $val ) = explode( '=', $qp );
				if ( 'v' === $key ) {
					return $val;
				}
			}
		}
	}
	return $str;
}
