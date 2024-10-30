<?php
declare(strict_types=1);

namespace ItalyStrap\Cleaner;

interface ValidableInterface
{
	/**
	 * Validate the give value
	 *
	 * @todo Aggiungere rule required
	 *       Prendere spunto da questo articolo
	 *       https://tommcfarlin.com/validation-and-sanitization-wordpress-settings-api
	 *       In particolare la classe Address_Validator
	 *       Se presente il parametro required inviare
	 *       un errore che notifica il campo richiesto.
	 *       Esempio: 'required|alpha_dash'

	 * @param  string $rules Insert the rule name you want to use for validation.
	 *                       Use | to separate more rules.
	 * @param  string $data  The value you want to validate.
	 * @return bool          Return true if valid and folse if it is not
	 */
	public function validate( $data = '' );

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