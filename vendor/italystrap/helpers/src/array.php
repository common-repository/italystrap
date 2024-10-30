<?php

namespace ItalyStrap\Arrays;

if ( ! function_exists( 'ItalyStrap\Array\array_exclude_by_key' ) ) {

	/**
	 * Excludes attributes by a given keys
	 *
	 * @param array $original Attributes to concatenate.
	 * @param array $keys_to_exclude
	 * @return array New array
	 */
    function array_exclude_by_key( array $original, array $keys_to_exclude = [] ): array {
        return \array_diff_key( $original, \array_flip( $keys_to_exclude ) );
    }
}