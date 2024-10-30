<?php
/**
 * Sanitization API: Rules_Trait
 *
 * @package ItalyStrap\Cleaner
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ItalyStrap\Cleaner;

trait Rules_Trait
{
	/**
	 * @var array
	 */
	private $rules = [];

	/**
	 * @param  string|array $rules        Insert the filter name you want to use.
	 *                                    Use | to separate more filter.
	 *                                    The order of the filters is evaluate as is
	 *                                    trim|strip_tags will be executed with this order:
	 *                                    strip_tags( trim() )
	 * @return              Sanitization
	 */
	public function addRules( $rules ): self {

		/**
		 * @todo Make test for this
		 */
		if ( \is_callable( $rules ) ) {
			$rules = (array) $rules;
		}

		if ( \is_string( $rules ) ) {
			/**
			 * If $rules is empty explode will return an array with always be count() === 1
			 * [
			 * 	0	=> null
			 * ]
			 * With array_filter it will be removed any empty element in the array
			 * []
			 */
			$rules = \array_filter( \explode( '|', $rules ) );
		}

		if ( ! \is_array( $rules ) ) {
			throw new Exceptions\IncorrectRuleTypeException( 'Incorrect $rules type, only strings and arrays are accepted', 0 );
		}

		$this->rules = \array_merge( $this->rules, $rules );
		return $this;
	}

	/**
	 * Reset the rules
	 */
	private function resetRules() {
		$this->rules = [];
	}

	/**
	 * @return array
	 */
	private function getRules(): array {
		return $this->rules;
	}

	/**
	 * @return int
	 */
	private function count(): int {
		return \count( $this->rules );
	}
}
