<?php
/*
Plugin Name: Cleaner
Description: Data cleaner for PHP
Plugin URI: https://italystrap.com
Author: Enea Overclokk
Author URI: https://italystrap.com
Version: 1.0.0
License: GPL2
Text Domain: Text Domain
Domain Path: Domain Path
*/

/*

    Copyright (C) Year  Enea Overclokk  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require( __DIR__ . '/vendor/autoload.php' );

/**
 * debug_example
 */
function cleaner_example() {
	$sanitizator = new \ItalyStrap\Cleaner\Sanitization();
	$validator = new \ItalyStrap\Cleaner\Validation();

	$value = ' <p>Test</p> ';
	$expected = 'Test';

	$callback = function ( $value ) {
		return  'New value from callback';
	};

	$rule = 'trim';

	$rules = 'trim|strip_tags';

	$rule_callable = [
		$callback
	];

	$rules_callable = [
		$callback,
		$callback,
	];

	$rules_arr = [
		'trim',
		'strip_tags'
	];

	$sanitizator->addRules( 'trim' );
	$sanitizator->addRules( $callback );
	$sanitizator->addRules( [$callback] );
	$sanitizator->addRules( [$callback] );

	d( $sanitizator->sanitize( '<p>Testo</p>' ) );
}

add_action( 'wp_footer', 'cleaner_example' );
