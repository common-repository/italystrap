<?php
/**
 * Validation API: Validation Class
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ItalyStrap\Cleaner;

/**
 * Validation class
 */
class Validation implements ValidableInterface {

	use Rules_Trait;

	/**
	 * Validate the give value
	 *
	 * @todo Build a message error in case validation fail in ajax requests
	 *
	 * @todo Aggiungere rule required
	 *       Prendere spunto da questo articolo
	 *       https://tommcfarlin.com/validation-and-sanitization-wordpress-settings-api
	 *       In particolare la classe Address_Validator
	 *       Se presente il parametro required inviare
	 *       un errore che notifica il campo richiesto.
	 *       Esempio: 'required|alpha_dash'
	 *
	 * @param  string $data The value you want to validate.
	 * @return bool         Return true if valid and false if it is not
	 * @throws Exceptions\NoRuleWasProvidedException
	 */
	public function validate( $data = '' ): bool {

		if ( ! $this->count() ) {
			throw new Exceptions\NoRuleWasProvidedException( 'No rule was provided, use ::addRules( $rules )', 0 );
		}

		foreach ( $this->getRules() as $rule ) {
			if ( false === $this->do_validation( $rule, $data ) ) {

				/**
				 * Reset rules before return the value filtered
				 */
				$this->resetRules();
				return false;
			}
		}

		/**
		 * Reset rules before return the value filtered
		 */
		$this->resetRules();
		return true;
	}

	/**
	 * Validate the value of key
	 *
	 * @access private
	 *
	 * @param string $rule Insert the rule name you want to use for validation.
	 *                       Use | to separate more rules.
	 * @param string $data The value you want to validate.
	 *
	 * @return bool
	 */
	private function do_validation( $rule, $data = '' ): bool {

		if ( \is_callable( $rule ) ) {
			return (bool) \call_user_func( $rule, $data );
		}

		return false;
	}
}
