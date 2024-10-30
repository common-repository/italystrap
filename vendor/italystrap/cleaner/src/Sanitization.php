<?php
/**
 * Sanitization API: Sanitization Class
 *
 * @package ItalyStrap\Cleaner
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ItalyStrap\Cleaner;

/**
 * Sanitization class
 * @todo https://www.php.net/manual/en/ref.filter.php
 * @todo https://www.php.net/manual/en/function.filter-input.php
 */
class Sanitization implements SanitizableInterface {

	use Rules_Trait;

	/**
	 * Filters the given value
	 *
	 *
	 * @param  string|int $data The value you want to filter.
	 * @return string           Return the value filtered
	 */
	public function sanitize( $data = '' ) {

		if ( ! $this->count() ) {
			throw new Exceptions\NoRuleWasProvidedException( 'No rule was provided, use ::addRules( $rules )', 0 );
		}

		foreach ( $this->getRules() as $rule ) {
			$data = $this->do_filter( $rule, $data );
		}

		/**
		 * Reset rules before return the value filtered
		 */
		$this->resetRules();
		return $data;
	}

	/**
	 * Filter the value of key
	 *
	 * List of functions for sanitizing data:
	 * strip_tags
	 * wp_strip_all_tags
	 * esc_attr
	 * esc_url
	 * esc_textarea
	 * sanitize_email
	 * sanitize_file_name
	 * sanitize_html_class
	 * sanitize_key
	 * sanitize_meta
	 * sanitize_mime_type
	 * sanitize_sql_orderby
	 * sanitize_text_field
	 * sanitize_title
	 * sanitize_title_for_query
	 * sanitize_title_with_dashes
	 * sanitize_user
	 * sanitize_option // sanitize_option ha bisogno di 2 valori eseguire test
	 *
	 * @access private
	 * @param  string $rule           The filter name you want to use.
	 * @param  string $data The value you want to filter.
	 * @return string                 Return the value filtered
	 */
	private function do_filter( $rule, $data ) {

		if ( ! \is_callable( $rule ) ) {
			throw new Exceptions\CallableNotResolvableException( 'Could not resolve a callable', 0 );
		}

		return \call_user_func( $rule, $data );
	}
}
