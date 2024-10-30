<?php

declare(strict_types=1);

namespace ItalyStrap\Cleaner;

/**
 * ========================
 *
 * Sanitizer
 *
 * ========================
 */

/**
 * Sanitize taxonomy_multiple_select and return an array with taxonomies ID
 *
 * @param  array|string $instance_value The value to sanitize
 * @return array                        The sanitized array
 */
function sanitize_taxonomy_multiple_select( $instance_value ) {

	if ( ! $instance_value ) {
		return $instance_value;
	}

	$array = array_map( 'esc_attr', (array) $instance_value );
	$array = array_map( 'absint', $array );
	$count = count( $array );
	if ( 1 === $count && 0 === $array[0] ) {
		return array();
	}
	return $array;

}

/**
 * Sanitize taxonomy_multiple_select and return an array with taxonomies ID
 *
 * @param  array|string $instance_value The value to sanitize
 * @return array                        The sanitized array
 */
function sanitize_select_multiple( $instance_value ) {

	if ( ! $instance_value ) {
		return $instance_value;
	}

	$array = array_map( 'esc_attr', (array) $instance_value );
	$count = count( $array );
	if ( 1 === $count && 0 === $array[0] ) {
		return array();
	}
	return $array;

}


/**
 * ========================
 *
 * Validator
 *
 * ========================
 */

function alpha_dash( $instance_value ) {
	return (bool) \preg_match( '/^[a-z0-9-_]+$/', $instance_value );
}

function natural_not_zero($instance_value) {

	if ( ! \preg_match( '/^[0-9]+$/', $instance_value ) ) {
		return false;
	}

	if ( 0 === $instance_value ) {
		return false;
	}

	return true;
}


/**
 * ========================
 *
 * Factory function
 *
 * ========================
 */

function sanitizator() {
	return ( new Cleaner_Factory() )->make( 'Sanitization' );
}

function validator() {
	return ( new Cleaner_Factory )->make( 'Validation' );
}