<?php
/**
 * Custom Field Utilities
 *
 * @package Wpinc Meta
 * @author Takuto Yanagida
 * @version 2024-03-14
 */

declare(strict_types=1);

namespace wpinc\meta;

/**
 * Retrieves post meta values of keys with suffixes.
 *
 * @param int                $post_id  Post ID.
 * @param string             $key      Meta key base.
 * @param array<string|null> $suffixes Meta key suffixes.
 * @return array<string, mixed> Values.
 */
function get_post_meta_suffix( int $post_id, string $key, array $suffixes ): array {
	$vals = array();
	foreach ( $suffixes as $sfx ) {
		$vals[ (string) $sfx ] = get_post_meta( $post_id, is_null( $sfx ) ? $key : "{$key}_$sfx", true );
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
function get_post_meta_date( int $post_id, string $key, ?string $format = null ): string {
	$format = $format ?? get_option( 'date_format' );  // For PHP 7.3.
	$format = is_string( $format ) ? $format : '';

	$val = get_post_meta( $post_id, $key, true );
	$val = is_string( $val ) ? mb_trim( $val ) : '';
	return (string) mysql2date( $format, $val );
}

/**
 * Retrieves a post meta field as multiple lines.
 *
 * @param int    $post_id Post ID.
 * @param string $key     The meta key to retrieve.
 * @return string[] Lines.
 */
function get_post_meta_lines( int $post_id, string $key ): array {
	$val = get_post_meta( $post_id, $key, true );
	$val = is_string( $val ) ? mb_trim( $val ) : '';

	$vals = explode( "\n", $val );
	$vals = array_map( '\wpinc\meta\mb_trim', $vals );
	$vals = array_filter( $vals );
	return array_values( $vals );
}

/**
 * Retrieves term meta values of keys with suffixes.
 *
 * @param int                $term_id  Term ID.
 * @param string             $key      Meta key base.
 * @param array<string|null> $suffixes Meta key suffixes.
 * @return array<string, mixed> Values.
 */
function get_term_meta_suffix( int $term_id, string $key, array $suffixes ): array {
	$vals = array();
	foreach ( $suffixes as $sfx ) {
		$vals[ (string) $sfx ] = get_term_meta( $term_id, is_null( $sfx ) ? $key : "{$key}_$sfx", true );
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
function get_term_meta_date( int $term_id, string $key, ?string $format = null ): string {
	$format = $format ?? get_option( 'date_format' );  // For PHP 7.3.
	$format = is_string( $format ) ? $format : '';

	$val = get_term_meta( $term_id, $key, true );
	$val = is_string( $val ) ? mb_trim( $val ) : '';
	return (string) mysql2date( $format, $val );
}

/**
 * Retrieves a term meta field as multiple lines.
 *
 * @param int    $term_id Term ID.
 * @param string $key     The meta key to retrieve.
 * @return string[] Lines.
 */
function get_term_meta_lines( int $term_id, string $key ): array {
	$val = get_term_meta( $term_id, $key, true );
	$val = is_string( $val ) ? mb_trim( $val ) : '';

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
 * @param mixed|null    $def     Default value.
 */
function set_post_meta( int $post_id, string $key, ?callable $filter = null, $def = null ): void {
	if ( ! isset( $_POST[ $key ] ) ) {  // phpcs:ignore
		return;  // When called through bulk edit.
	}
	$val = $_POST[ $key ];  // phpcs:ignore
	if ( null !== $filter ) {
		$val = $filter( $val );
	}
	if ( null === $val || '' === $val ) {
		if ( null === $def ) {
			delete_post_meta( $post_id, $key );
			return;
		}
		$val = $def;
	}
	update_post_meta( $post_id, $key, $val );
}

/**
 * Stores a post meta field after applying filters.
 *
 * @param int         $post_id     Post ID.
 * @param string      $key         Metadata key.
 * @param string|null $filter_name Filter name.
 * @param mixed|null  $def         Default value.
 */
function set_post_meta_with_wp_filter( int $post_id, string $key, ?string $filter_name = null, $def = null ): void {
	if ( ! isset( $_POST[ $key ] ) ) {  // phpcs:ignore
		return;  // When called through bulk edit.
	}
	$val = $_POST[ $key ];  // phpcs:ignore
	if ( is_string( $filter_name ) ) {
		$val = apply_filters( $filter_name, $val );
	}
	if ( null === $val || '' === $val ) {
		if ( null === $def ) {
			delete_post_meta( $post_id, $key );
			return;
		}
		$val = $def;
	}
	update_post_meta( $post_id, $key, $val );
}

/**
 * Stores post meta values of keys with suffixes.
 *
 * @param int                $post_id  Post ID.
 * @param string             $key      Meta key base.
 * @param array<string|null> $suffixes Meta key suffixes.
 * @param callable|null      $filter   Filter function.
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
 * @param mixed|null    $def     Default value.
 */
function set_term_meta( int $term_id, string $key, ?callable $filter = null, $def = null ): void {
	if ( ! isset( $_POST[ $key ] ) ) {  // phpcs:ignore
		return;  // When called through bulk edit.
	}
	$val = $_POST[ $key ];  // phpcs:ignore
	if ( null !== $filter ) {
		$val = $filter( $val );
	}
	if ( null === $val || '' === $val ) {
		if ( null === $def ) {
			delete_term_meta( $term_id, $key );
			return;
		}
		$val = $def;
	}
	update_term_meta( $term_id, $key, $val );
}

/**
 * Stores a term meta field after applying filters.
 *
 * @param int         $term_id     Term ID.
 * @param string      $key         Metadata key.
 * @param string|null $filter_name Filter name.
 * @param mixed|null  $def         Default value.
 */
function set_term_meta_with_wp_filter( int $term_id, string $key, ?string $filter_name = null, $def = null ): void {
	if ( ! isset( $_POST[ $key ] ) ) {  // phpcs:ignore
		return;  // When called through bulk edit.
	}
	$val = $_POST[ $key ];  // phpcs:ignore
	if ( is_string( $filter_name ) ) {
		$val = apply_filters( $filter_name, $val );
	}
	if ( null === $val || '' === $val ) {
		if ( null === $def ) {
			delete_term_meta( $term_id, $key );
			return;
		}
		$val = $def;
	}
	update_term_meta( $term_id, $key, $val );
}

/**
 * Stores term meta values of keys with suffixes.
 *
 * @param int                $term_id  Term ID.
 * @param string             $key      Meta key base.
 * @param array<string|null> $suffixes Meta key suffixes.
 * @param callable|null      $filter   Filter function.
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
	return preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $str ) ?? $str;
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
	if ( $nums ) {
		foreach ( $nums as $num ) {
			$v = (int) trim( $num );
			if ( 0 !== $v ) {
				$vals[] = $v;
			}
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
		if ( ! isset( $pu['host'] ) ) {
			return '';
		}
		if ( 'youtu.be' === $pu['host'] ) {
			if ( ! isset( $pu['path'] ) ) {
				return '';
			}
			return trim( $pu['path'], '/' );
		}
		if ( 'www.youtube.com' === $pu['host'] ) {
			$q  = $pu['query'] ?? '';
			$qs = explode( '&', $q );

			foreach ( $qs as $qp ) {
				list( $key, $val ) = explode( '=', $qp );
				if ( 'v' === $key ) {
					return $val;
				}
			}
		}
	}
	return '';
}
