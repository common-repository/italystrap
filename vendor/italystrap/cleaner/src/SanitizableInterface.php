<?php
declare(strict_types=1);

namespace ItalyStrap\Cleaner;

interface SanitizableInterface
{
	/**
	 * Filters the given value
	 *
	 *
	 * @param  string|int $data The value you want to filter.
	 * @return string           Return the value filtered
	 */
	public function sanitize( $data = '' );

	/**
	 * @param  string|array $rules        Insert the filter name you want to use.
	 *                                    Use | to separate more filter.
	 *                                    The order of the filters is evaluate as is
	 *                                    trim|strip_tags will be executed with this order:
	 *                                    strip_tags( trim() )
	 * @return              self
	 */
	public function addRules( $rules );
}